<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.favicon')

    <title>Lupa Password Admin — {{ $desa['nama'] }}</title>

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

        .password-input:focus {
            outline: none;
            border-color: var(--rust-buoy-lt);
            box-shadow: 0 0 0 3px rgba(192, 87, 42, 0.15);
        }

        .password-message {
            margin-bottom: 1rem;
            padding: 0.75rem;

            border-radius: 6px;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .password-message--success {
            background: #eaf6ee;
            color: #23633c;
        }

        .password-message--error {
            background: #fff0f0;
            color: #b42318;
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

        <h1>Lupa Password</h1>

        <p class="password-description">
            Masukkan email admin. Tautan untuk membuat password baru akan dikirim ke email tersebut.
        </p>

        @if (session('status'))
            <div class="password-message password-message--success">
                {{ session('status') }}
            </div>
        @endif

        @error('email')
            <div class="password-message password-message--error">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <input type="email" name="email" class="password-input" placeholder="Masukkan Email Admin..."
                value="{{ old('email') }}" autocomplete="email" required>

            <button type="submit" class="btn btn-primary" style="width: 100%;">
                Kirim Tautan Reset
            </button>
        </form>

        <a href="{{ route('admin_login') }}" class="password-back-link">
            &larr; Kembali ke Login Admin
        </a>

    </main>

</body>

</html>