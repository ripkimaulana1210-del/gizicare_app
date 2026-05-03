@extends('layouts.app')

@section('title', 'Diagnosis AI - GiziCare')

@section('header')
    <h2 class="page-title">Diagnosis AI</h2>
@endsection

@section('content')
@php
    $starterPrompts = [
        'Anak 2 tahun susah makan dan BB sulit naik.',
        'Berat tidak naik 2 bulan, apa yang perlu dicek?',
        'Anak pucat, mudah lelah, dan nafsu makan turun.',
        'Buat menu 1 hari anak 2 tahun agar BB naik sehat.',
    ];
@endphp

<div class="dashboard-container diagnosis-chat-page">
    <section class="diagnosis-chat-hero">
        <div>
            <p class="hero-kicker">Konsultasi AI</p>
            <h3>Ruang chat untuk pertanyaan gizi anak.</h3>
            <p>Tulis kondisi anak, pola makan, atau hasil pencatatan. AI akan membantu memberi arahan awal yang mudah dipahami.</p>
        </div>

        <div class="diagnosis-ai-status {{ $aiReady ? 'is-ready' : 'is-missing' }}">
            <span></span>
            <strong>{{ $aiReady ? 'Gemini aktif' : 'API key belum aktif' }}</strong>
            <small>{{ $geminiModel }}</small>
        </div>
    </section>

    <div class="diagnosis-chat-layout diagnosis-chat-layout--solo">
        <section
            class="diagnosis-chat-panel"
            data-endpoint="{{ route('diagnosis.chat') }}"
            data-ai-ready="{{ $aiReady ? '1' : '0' }}"
            aria-label="Chat diagnosis AI"
        >
            <div class="diagnosis-chat-topbar">
                <div>
                    <p>GiziCare AI</p>
                    <h3>Chat Diagnosis Gizi</h3>
                </div>
                <div class="diagnosis-chat-topbar__meta">
                    <span>Pola makan</span>
                    <span>Pertumbuhan</span>
                    <span>MPASI</span>
                    <span>Anemia</span>
                    <span class="diagnosis-chat-dot {{ $aiReady ? 'is-ready' : 'is-missing' }}"></span>
                </div>
            </div>

            <div class="diagnosis-chat-messages" id="diagnosisChatMessages" aria-live="polite">
                <article class="chat-message chat-message--assistant">
                    <div class="chat-message__meta">GiziCare AI</div>
                    <div class="chat-message__content">
                        <p>Halo, ceritakan keluhan atau kondisi anak. Tambahkan umur, jenis kelamin, berat, tinggi, dan tren KMS bila ada supaya arahan awalnya lebih tepat.</p>
                    </div>
                </article>
            </div>

            <div class="diagnosis-prompt-row" aria-label="Contoh pertanyaan">
                @foreach ($starterPrompts as $prompt)
                    <button type="button" class="diagnosis-prompt-chip" data-prompt="{{ $prompt }}">
                        {{ $prompt }}
                    </button>
                @endforeach
            </div>

            <form class="diagnosis-chat-form" id="diagnosisChatForm">
                <label class="sr-only" for="diagnosisMessage">Pesan konsultasi</label>
                <textarea
                    id="diagnosisMessage"
                    rows="3"
                    maxlength="2000"
                    placeholder="Tulis kondisi anak, gejala, pola makan, atau pertanyaan gizi..."
                    required
                ></textarea>
                <button type="submit" class="btn-submit diagnosis-chat-send" id="diagnosisSendButton">
                    Kirim
                </button>
            </form>
        </section>
    </div>
</div>

<script>
(() => {
    const panel = document.querySelector('.diagnosis-chat-panel');
    const form = document.getElementById('diagnosisChatForm');
    const input = document.getElementById('diagnosisMessage');
    const messages = document.getElementById('diagnosisChatMessages');
    const sendButton = document.getElementById('diagnosisSendButton');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const history = [];

    if (!panel || !form || !input || !messages || !sendButton) {
        return;
    }

    const endpoint = panel.dataset.endpoint;

    const formatInline = (text) => {
        const fragment = document.createDocumentFragment();
        const parts = String(text).split(/(\*\*[^*]+\*\*)/g);

        parts.forEach((part) => {
            if (part.startsWith('**') && part.endsWith('**')) {
                const strong = document.createElement('strong');
                strong.textContent = part.slice(2, -2);
                fragment.appendChild(strong);
                return;
            }

            fragment.appendChild(document.createTextNode(part));
        });

        return fragment;
    };

    const appendTextBlock = (container, tagName, text) => {
        const element = document.createElement(tagName);
        element.appendChild(formatInline(text));
        container.appendChild(element);
    };

    const renderAssistantContent = (container, content) => {
        const lines = String(content || '').split(/\r?\n/);
        let activeList = null;

        const resetList = () => {
            activeList = null;
        };

        const addListItem = (text, ordered = false) => {
            const tagName = ordered ? 'OL' : 'UL';

            if (!activeList || activeList.tagName !== tagName) {
                activeList = document.createElement(ordered ? 'ol' : 'ul');
                container.appendChild(activeList);
            }

            const item = document.createElement('li');
            item.appendChild(formatInline(text));
            activeList.appendChild(item);
        };

        lines.forEach((rawLine) => {
            const line = rawLine.trim();

            if (!line) {
                resetList();
                return;
            }

            const markdownHeading = line.match(/^#{1,3}\s+(.+)$/);
            const boldHeading = line.match(/^\*\*([^*]+)\*\*:?\s*$/);
            const plainHeading = line.match(/^(Ringkasan|Yang perlu dicek|Langkah mulai hari ini|Kapan perlu ke puskesmas\/dokter|Data yang saya perlukan|Catatan penting):?$/i);
            const numberedHeading = line.match(/^\d+[.)]\s+(Ringkasan|Yang perlu dicek|Langkah mulai hari ini|Kapan perlu ke puskesmas\/dokter|Data yang saya perlukan|Catatan penting):?$/i);
            const bullet = line.match(/^[-*\u2022]\s+(.+)$/);
            const numbered = line.match(/^\d+[.)]\s+(.+)$/);

            if (markdownHeading || boldHeading || plainHeading || numberedHeading) {
                resetList();
                appendTextBlock(container, 'h4', (markdownHeading?.[1] || boldHeading?.[1] || plainHeading?.[1] || numberedHeading?.[1]).replace(/:$/, ''));
                return;
            }

            if (bullet) {
                addListItem(bullet[1]);
                return;
            }

            if (numbered) {
                addListItem(numbered[1], true);
                return;
            }

            resetList();
            appendTextBlock(container, 'p', line);
        });

        if (!container.hasChildNodes()) {
            appendTextBlock(container, 'p', content || '');
        }
    };

    const appendMessage = (role, content, state = '') => {
        const item = document.createElement('article');
        item.className = `chat-message chat-message--${role}${state ? ` ${state}` : ''}`;

        const meta = document.createElement('div');
        meta.className = 'chat-message__meta';
        meta.textContent = role === 'user' ? 'Anda' : 'GiziCare AI';

        const body = document.createElement('div');
        body.className = 'chat-message__content';

        if (role === 'assistant') {
            renderAssistantContent(body, content);
        } else {
            appendTextBlock(body, 'p', content);
        }

        item.append(meta, body);
        messages.appendChild(item);
        messages.scrollTop = messages.scrollHeight;

        return item;
    };

    const setBusy = (busy) => {
        sendButton.disabled = busy;
        input.disabled = busy;
        sendButton.textContent = busy ? 'Mengirim...' : 'Kirim';
    };

    document.querySelectorAll('.diagnosis-prompt-chip').forEach((chip) => {
        chip.addEventListener('click', () => {
            input.value = chip.dataset.prompt || '';
            input.focus();
        });
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();

        if (!message) {
            return;
        }

        appendMessage('user', message);
        input.value = '';
        setBusy(true);

        const loadingMessage = appendMessage('assistant', 'Sedang menyusun arahan...', 'is-loading');

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({
                    message,
                    history: history.slice(-6),
                }),
            });

            const data = await response.json().catch(() => ({}));

            loadingMessage.remove();

            if (!response.ok) {
                throw new Error(data.message || 'Layanan AI belum bisa menjawab sekarang.');
            }

            appendMessage('assistant', data.reply || 'Saya belum bisa membaca respons AI.');
            history.push({ role: 'user', content: message });
            history.push({ role: 'assistant', content: data.reply || '' });
        } catch (error) {
            loadingMessage.remove();
            appendMessage('assistant', error.message, 'is-error');
        } finally {
            setBusy(false);
            input.focus();
        }
    });
})();
</script>
@endsection
