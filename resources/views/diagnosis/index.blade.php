@extends('layouts.app')

@section('title', 'Diagnosis AI - GiziCare')

@section('header')
    <h2 class="page-title">Diagnosis AI</h2>
@endsection

@section('content')
@php
    $starterPrompts = [
        'Anak 2 tahun susah makan dan BB sulit naik.',
        'Tinggi 175 cm berat 111 kg, apakah ideal?',
        'Anak pucat, mudah lelah, dan nafsu makan turun.',
        'Buat menu 1 hari anak 2 tahun agar BB naik sehat.',
    ];
@endphp

<div class="dashboard-container diagnosis-chat-page">
    @if (session('success'))
        <div class="auth-status">{{ session('success') }}</div>
    @endif

    <section class="diagnosis-chat-hero">
        <div>
            <p class="hero-kicker">Konsultasi AI</p>
            <h3>Ruang chat untuk pertanyaan gizi keluarga.</h3>
            <p>Tulis kondisi anak, pola makan, tinggi-berat, atau hasil pencatatan. AI akan membantu memberi arahan awal yang mudah dipahami.</p>
        </div>

        <div class="diagnosis-ai-status {{ $aiReady ? 'is-ready' : 'is-missing' }}">
            <span></span>
            <strong>{{ $aiReady ? 'Gemini aktif' : 'API key belum aktif' }}</strong>
            <small>{{ $geminiModel }}</small>
        </div>
    </section>

    <div class="diagnosis-chat-layout diagnosis-chat-layout--with-history">
        <aside class="diagnosis-history-panel" aria-label="Riwayat diagnosis">
            <div class="diagnosis-history-panel__head">
                <div>
                    <p>Riwayat</p>
                    <h3>Sesi Diagnosis</h3>
                </div>
                <span>{{ $diagnosisSessions->count() }}</span>
            </div>

            <form method="POST" action="{{ route('diagnosis.session.store') }}" class="diagnosis-new-session">
                @csrf
                <button type="submit" class="btn-app btn-primary">Chat Baru</button>
            </form>

            <div class="diagnosis-session-list">
                @forelse ($diagnosisSessions as $session)
                    @php($isActiveSession = $activeSession && $activeSession->id === $session->id)
                    <div class="diagnosis-session-item {{ $isActiveSession ? 'is-active' : '' }}">
                        <a href="{{ route('diagnosis', ['session' => $session->id]) }}">
                            <strong>{{ $session->title }}</strong>
                            <span>
                                @if($session->pencatatan)
                                    {{ $session->pencatatan->nama }}
                                    &middot;
                                @endif
                                {{ $session->messages_count }} pesan
                            </span>
                        </a>
                        @if($isActiveSession)
                            <form method="POST" action="{{ route('diagnosis.session.destroy', $session) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Hapus riwayat diagnosis ini?')">Hapus</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="empty-state diagnosis-history-empty">
                        Belum ada riwayat. Klik Chat Baru atau langsung kirim pertanyaan.
                    </div>
                @endforelse
            </div>
        </aside>

        <section
            class="diagnosis-chat-panel"
            data-endpoint="{{ route('diagnosis.chat') }}"
            data-ai-ready="{{ $aiReady ? '1' : '0' }}"
            data-session-id="{{ $activeSession?->id }}"
            data-pencatatan-id="{{ $activeSession?->pencatatan_id }}"
            aria-label="Chat diagnosis AI"
        >
            <div class="diagnosis-chat-topbar">
                <div>
                    <p>GiziCare AI</p>
                    <h3>{{ $activeSession?->title ?? 'Chat Diagnosis Gizi' }}</h3>
                    @if($activeSession?->pencatatan)
                        <span class="diagnosis-linked-child">
                            {{ $activeSession->pencatatan->nama }} - {{ $activeSession->pencatatan->umur }} bulan
                        </span>
                    @endif
                </div>
                <div class="diagnosis-chat-topbar__meta">
                    <span>Pola makan</span>
                    <span>Pertumbuhan</span>
                    <span>BMI</span>
                    <span>MPASI</span>
                    <span class="diagnosis-chat-dot {{ $aiReady ? 'is-ready' : 'is-missing' }}"></span>
                </div>
            </div>

            <div class="diagnosis-chat-messages" id="diagnosisChatMessages" aria-live="polite">
                @if($savedMessages->isEmpty())
                    <article class="chat-message chat-message--assistant">
                        <div class="chat-message__meta">GiziCare AI</div>
                        <div class="chat-message__content">
                            <p>Ceritakan kondisi gizi yang ingin dicek. Untuk anak, tambahkan umur, jenis kelamin, BB, TB, dan tren KMS. Untuk dewasa, tulis tinggi, berat, pola makan, dan tujuan yang ingin dicapai.</p>
                        </div>
                    </article>
                @endif
            </div>

            <div class="diagnosis-prompt-row" aria-label="Contoh pertanyaan">
                @foreach ($starterPrompts as $prompt)
                    <button type="button" class="diagnosis-prompt-chip" data-prompt="{{ $prompt }}">
                        {{ $prompt }}
                    </button>
                @endforeach
            </div>

            <form class="diagnosis-chat-form" id="diagnosisChatForm">
                <div class="diagnosis-chat-input">
                    <label class="sr-only" for="diagnosisMessage">Pesan konsultasi</label>
                    <textarea
                        id="diagnosisMessage"
                        rows="3"
                        maxlength="2000"
                        placeholder="Contoh: tinggi 175 cm berat 111 kg, apakah ideal?"
                        required
                    ></textarea>
                    <div class="diagnosis-chat-tools">
                        <span id="diagnosisCharCount">0/2000</span>
                        <span>Umur, BB, TB, tren KMS</span>
                    </div>
                </div>
                <button type="submit" class="btn-submit diagnosis-chat-send" id="diagnosisSendButton" disabled>
                    <svg class="send-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4.5 11.7 19 4.8c.6-.3 1.2.3.9.9l-6.9 14.5c-.3.7-1.3.6-1.5-.1l-1.6-5.7-5.3-1.3c-.8-.2-.9-1.2-.1-1.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="m10 14 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span class="send-label">Kirim</span>
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
    const sendLabel = sendButton?.querySelector('.send-label');
    const charCount = document.getElementById('diagnosisCharCount');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const savedMessages = @json($savedMessages);
    const history = [];

    if (!panel || !form || !input || !messages || !sendButton || !sendLabel) {
        return;
    }

    const endpoint = panel.dataset.endpoint;
    const aiReady = panel.dataset.aiReady === '1';
    const activePencatatanId = panel.dataset.pencatatanId || '';
    let activeSessionId = panel.dataset.sessionId || '';
    let isBusy = false;

    const compactText = (content, maxLength = 1200) => {
        const text = String(content || '');

        if (text.length <= maxLength) {
            return text;
        }

        return `${text.slice(0, maxLength)}\n...[riwayat dipotong]`;
    };

    const compactHistory = () => history.slice(-6).map((item) => ({
        role: item.role,
        content: compactText(item.content),
    }));

    const scrollToMessage = (item) => {
        window.requestAnimationFrame(() => {
            item.scrollIntoView({ behavior: 'smooth', block: 'end' });
        });
    };

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
        scrollToMessage(item);

        return item;
    };

    const renderSavedMessages = () => {
        if (!Array.isArray(savedMessages) || savedMessages.length === 0) {
            return;
        }

        messages.innerHTML = '';
        panel.classList.add('has-conversation');

        savedMessages.forEach((message) => {
            if (!message.role || !message.content) {
                return;
            }

            appendMessage(message.role, message.content);
            history.push({
                role: message.role,
                content: message.content,
            });
        });
    };

    const updateComposer = () => {
        const length = input.value.length;

        if (charCount) {
            charCount.textContent = `${length}/2000`;
        }

        sendButton.disabled = isBusy || !aiReady || input.value.trim().length === 0;
    };

    const setBusy = (busy) => {
        isBusy = busy;
        input.disabled = busy || !aiReady;
        sendButton.classList.toggle('is-busy', busy);
        sendLabel.textContent = busy ? 'Mengirim...' : 'Kirim';
        updateComposer();
    };

    document.querySelectorAll('.diagnosis-prompt-chip').forEach((chip) => {
        chip.disabled = !aiReady;

        chip.addEventListener('click', () => {
            if (!aiReady) {
                return;
            }

            input.value = chip.dataset.prompt || '';
            input.focus();
            updateComposer();
        });
    });

    if (!aiReady) {
        input.disabled = true;
        input.placeholder = 'API key Gemini belum aktif. Aktifkan GEMINI_API_KEY di .env untuk memakai chat.';
        appendMessage('assistant', 'Chat AI belum aktif karena API key Gemini belum tersedia.', 'is-error');
    }

    input.addEventListener('input', updateComposer);
    renderSavedMessages();
    updateComposer();

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();

        if (!message || !aiReady || isBusy) {
            return;
        }

        panel.classList.add('has-conversation');
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
                    session_id: activeSessionId || null,
                    pencatatan_id: activePencatatanId || null,
                    history: compactHistory(),
                }),
            });

            const data = await response.json().catch(() => ({}));

            loadingMessage.remove();

            if (!response.ok) {
                const serverMessage = data.errors?.pencatatan_id?.[0] || data.message;
                throw new Error(serverMessage || 'Layanan AI belum bisa menjawab sekarang.');
            }

            if (data.session_id) {
                activeSessionId = String(data.session_id);
                panel.dataset.sessionId = activeSessionId;
            }

            appendMessage('assistant', data.reply || 'Saya belum bisa membaca respons AI.', data.fallback ? 'is-fallback' : '');
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
