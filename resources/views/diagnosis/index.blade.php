@extends('layouts.app')

@section('title', 'Diagnosis AI - GiziCare')

@section('header')
    <h2 class="page-title">Diagnosis AI</h2>
@endsection

@section('content')
@php
    $starterPrompts = [
        'Anak saya susah makan dan berat badannya sulit naik.',
        'Bagaimana tanda awal stunting yang perlu saya cek?',
        'Anak sering lemas dan tampak pucat, apa yang harus dilakukan?',
        'Tolong bantu susun menu harian anak usia 2 tahun.',
    ];
@endphp

<div class="dashboard-container diagnosis-chat-page">
    <section class="diagnosis-chat-hero">
        <div>
            <p class="hero-kicker">Konsultasi AI</p>
            <h3>Ceritakan kondisi gizi yang sedang dialami.</h3>
            <p>Konsultasi awal untuk pola makan, pertumbuhan, stunting, anemia, berat badan, dan kebiasaan makan anak.</p>
        </div>

        <div class="diagnosis-ai-status {{ $aiReady ? 'is-ready' : 'is-missing' }}">
            <span></span>
            <strong>{{ $aiReady ? 'OpenAI aktif' : 'API key belum aktif' }}</strong>
            <small>{{ $openAiModel }}</small>
        </div>
    </section>

    <div class="diagnosis-chat-layout">
        <aside class="diagnosis-profile-panel" aria-label="Profil anak">
            <div class="panel-heading">
                <p>Profil</p>
                <h3>Data Anak</h3>
            </div>

            <div class="diagnosis-profile-grid">
                <label>
                    <span>Nama</span>
                    <input type="text" id="profileName" placeholder="Nama anak" autocomplete="name">
                </label>

                <label>
                    <span>Umur</span>
                    <input type="number" id="profileAge" min="0" max="216" placeholder="Bulan">
                </label>

                <label>
                    <span>Berat</span>
                    <input type="number" id="profileWeight" min="0" max="250" step="0.1" placeholder="Kg">
                </label>

                <label>
                    <span>Tinggi</span>
                    <input type="number" id="profileHeight" min="0" max="250" step="0.1" placeholder="Cm">
                </label>
            </div>

            <div class="diagnosis-safety-note">
                <strong>Konsultasi awal</strong>
                <p>Untuk sesak, kejang, lemas berat, dehidrasi, demam tinggi, atau muntah/diare terus-menerus, segera ke fasilitas kesehatan.</p>
            </div>
        </aside>

        <section
            class="diagnosis-chat-panel"
            data-endpoint="{{ route('diagnosis.chat') }}"
            data-ai-ready="{{ $aiReady ? '1' : '0' }}"
            aria-label="Chat diagnosis AI"
        >
            <div class="diagnosis-chat-topbar">
                <div>
                    <p>GiziCare AI</p>
                    <h3>Konsultasi Masalah Gizi</h3>
                </div>
                <span class="diagnosis-chat-dot {{ $aiReady ? 'is-ready' : 'is-missing' }}"></span>
            </div>

            <div class="diagnosis-chat-messages" id="diagnosisChatMessages" aria-live="polite">
                <article class="chat-message chat-message--assistant">
                    <div class="chat-message__meta">GiziCare AI</div>
                    <p>Halo, ceritakan keluhan atau kondisi anak. Saya akan bantu beri arahan awal yang aman dan mudah diikuti.</p>
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

    const profileValue = (id) => document.getElementById(id)?.value?.trim() || '';

    const currentProfile = () => ({
        nama: profileValue('profileName'),
        umur: profileValue('profileAge'),
        berat: profileValue('profileWeight'),
        tinggi: profileValue('profileHeight'),
    });

    const appendMessage = (role, content, state = '') => {
        const item = document.createElement('article');
        item.className = `chat-message chat-message--${role}${state ? ` ${state}` : ''}`;

        const meta = document.createElement('div');
        meta.className = 'chat-message__meta';
        meta.textContent = role === 'user' ? 'Anda' : 'GiziCare AI';

        const body = document.createElement('p');
        body.textContent = content;

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
                    profile: currentProfile(),
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
