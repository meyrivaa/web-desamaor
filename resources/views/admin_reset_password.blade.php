<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.favicon')

    <title>Reset Password Admin — {{ $desa['nama'] }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            min-height: 100vh;
            padding: 2rem 1rem;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;

            background: #ffffff;
            border: 1px solid var(--light-border);
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 12px 35px var(--light-shadow);
        }

        .password-container h1 {
            margin-bottom: 0.75rem;

            color: var(--rust-buoy-lt);
            font-family: var(--font-serif);
            font-size: 2rem;
        }

        .password-description {
            margin-bottom: 1.5rem;
            color: var(--light-text);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .password-input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;

            border: 1px solid var(--light-border);
            border-radius: 6px;

            background: #ffffff;
            color: var(--light-text);
        }

        .password-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .password-wrapper .password-input {
            margin-bottom: 0;
            padding-right: 3rem;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);

            display: flex;
            align-items: center;
            justify-content: center;

            width: 32px;
            height: 32px;
            padding: 0;

            border: none;
            background: transparent;
            color: #687773;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--rust-buoy-lt);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
        }

        .password-toggle .eye-closed {
            display: none;
        }

        .password-message {
            margin-bottom: 1rem;
            padding: 0.75rem;

            border-radius: 6px;
            background: #fff0f0;
            color: #b42318;

            font-size: 0.85rem;
            line-height: 1.5;
        }

        .password-back-link {
            display: block;
            margin-top: 1rem;

            color: var(--muted-sage);
            font-size: 0.85rem;
            text-decoration: none;
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .password-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <main class="password-container">

        <h1>Buat Password Baru</h1>

        <p class="password-description">
            Masukkan email admin dan buat password baru dengan minimal 8 karakter.
        </p>

        @if ($errors->any())
            <div class="password-message">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <input type="email" name="email" class="password-input" placeholder="Masukkan Email Admin..."
                value="{{ old('email', $email) }}" autocomplete="email" required>

            <div class="password-wrapper">
                <input id="new-password" type="password" name="password" class="password-input"
                    placeholder="Masukkan Password Baru..." autocomplete="new-password" required>

                <button type="button" class="password-toggle" data-password-toggle="new-password"
                    aria-label="Tampilkan password" title="Tampilkan password">

                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.7a2 2 0 002.7 2.7"></path>
                        <path d="M9.9 4.2A10.8 10.8 0 0112 4c6.5 0 10 8 10 8a17.5 17.5 0 01-2.1 3.2"></path>
                        <path d="M6.6 6.6C3.6 8.5 2 12 2 12s3.5 8 10 8a9.8 9.8 0 004.1-.9"></path>
                    </svg>
                </button>
            </div>

            <div class="password-wrapper">
                <input id="confirm-password" type="password" name="password_confirmation" class="password-input"
                    placeholder="Ulangi Password Baru..." autocomplete="new-password" required>

                <button type="button" class="password-toggle" data-password-toggle="confirm-password"
                    aria-label="Tampilkan password" title="Tampilkan password">

                    <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>

                    <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 3l18 18"></path>
                        <path d="M10.6 10.7a2 2 0 002.7 2.7"></path>
                        <path d="M9.9 4.2A10.8 10.8 0 0112 4c6.5 0 10 8 10 8a17.5 17.5 0 01-2.1 3.2"></path>
                        <path d="M6.6 6.6C3.6 8.5 2 12 2 12s3.5 8 10 8a9.8 9.8 0 004.1-.9"></path>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Simpan Password Baru
            </button>
        </form>

        <a href="{{ route('admin_login') }}" class="password-back-link">
            &larr; Kembali ke Login Admin
        </a>

    </main>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.passwordToggle);
                const eyeOpen = button.querySelector('.eye-open');
                const eyeClosed = button.querySelector('.eye-closed');
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';
                eyeOpen.style.display = isHidden ? 'none' : 'block';
                eyeClosed.style.display = isHidden ? 'block' : 'none';

                button.setAttribute(
                    'aria-label',
                    isHidden ? 'Sembunyikan password' : 'Tampilkan password'
                );

                button.setAttribute(
                    'title',
                    isHidden ? 'Sembunyikan password' : 'Tampilkan password'
                );
            });
        });
    </script>

</body>

</html>