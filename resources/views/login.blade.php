<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.favicon')

  <title>Login Admin &mdash; {{ $desa['nama'] }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <style>
    .login-container {
      max-width: 400px;
      margin: 10rem auto;
      padding: 2rem;
      background: #ffffff;
      border: 1px solid var(--light-border);
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 12px 35px var(--light-shadow);
    }

    .login-input {
      width: 100%;
      padding: 0.75rem;
      margin: 1rem 0;
      border-radius: 6px;
      border: 1px solid var(--light-border);
      background: #ffffff;
      color: var(--light-text);
    }

    .login-input:focus {
      outline: none;
      border-color: var(--rust-buoy-lt);
      box-shadow: 0 0 0 3px rgba(192, 87, 42, 0.15);
    }

    .login-input::placeholder {
      color: #96a29e;
    }

    .password-wrapper {
      position: relative;
      margin: 1rem 0;
    }

    .password-wrapper .login-input {
      margin: 0;
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

    body {
      min-height: 100vh;
      padding: 2rem 1rem;

      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      width: 100%;
      margin: 0;
    }

    .login-container h2 {
      font-family: var(--font-serif);
      font-size: 2rem;
    }

    @media (max-width: 480px) {
      body {
        padding: 1rem;
      }

      .login-container {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2 style="color: var(--rust-buoy-lt); margin-bottom: 1rem;">Admin Panel</h2>
    @if(session('error', $error))
      <p style="color: #ff4c4c; font-size: 0.9rem;">{{ session('error', $error) }}</p>
    @endif
    <form method="POST" action="{{ route('admin_login_submit') }}">
      @csrf

      <input type="email" name="email" class="login-input" placeholder="Masukkan Email Admin..."
        value="{{ old('email') }}" autocomplete="email" required>

      <div class="password-wrapper">
        <input id="login-password" type="password" name="password" class="login-input"
          placeholder="Masukkan Password..." autocomplete="current-password" required>

        <button type="button" class="password-toggle" data-password-toggle="login-password"
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
        Masuk
      </button>
    </form>

    <a href="{{ route('password.request') }}"
      style="display: block; margin-top: 1rem; text-align: center; text-decoration: none;">
      Lupa Password?
    </a>
    <a href="{{ route('listing') }}"
      style="color: var(--muted-sage); display: block; margin-top: 1rem; font-size: 0.8rem;">&larr;
      Kembali ke Web Utama</a>
  </div>

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