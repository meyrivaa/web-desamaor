<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('partials.favicon')

    <title>Kelola Admin — {{ $desa['nama'] }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            min-height: 100vh;
            background: var(--light-bg);
        }

        .account-main {
            width: 100%;
            max-width: 1150px;
            margin: 0 auto;
            padding: 2.5rem 2rem 4rem;
        }

        .account-heading {
            margin-bottom: 2rem;
            text-align: center;
        }

        .account-heading h1 {
            margin-bottom: 0.5rem;
            color: var(--light-text);
            font-family: var(--font-serif);
            font-size: 2.4rem;
        }

        .account-heading p {
            color: var(--muted-sage);
            line-height: 1.6;
        }

        .account-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.8fr) minmax(0, 1.4fr);
            gap: 1.5rem;
            align-items: start;
        }

        .account-card {
            padding: 2rem;
            background: #ffffff;
            border: 1px solid var(--light-border);
            border-radius: 12px;
            box-shadow: 0 10px 30px var(--light-shadow);
        }

        .account-card h2 {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-border);

            color: var(--rust-buoy);
            font-family: var(--font-serif);
            font-size: 1.6rem;
        }

        .account-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;

            color: var(--muted-sage);
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem;

            background: #ffffff;
            border: 1px solid var(--light-border);
            border-radius: 6px;

            color: var(--light-text);
            font-family: var(--font-sans);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--rust-buoy-lt);
            box-shadow: 0 0 0 3px rgba(192, 87, 42, 0.15);
        }

        .form-help {
            display: block;
            margin-top: 0.5rem;

            color: var(--muted-sage);
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .account-submit {
            width: 100%;
            padding: 0.9rem 1rem;

            border: none;
            border-radius: 6px;
            background: var(--rust-buoy-lt);

            color: #ffffff;
            cursor: pointer;
            font-family: var(--font-sans);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .account-submit:hover {
            background: #a54b20;
        }

        .account-message {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;

            border-radius: 8px;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .account-message--success {
            border: 1px solid #16a34a;
            background: #f0fdf4;
            color: #166534;
        }

        .account-message--warning {
            border: 1px solid #d97706;
            background: #fffbeb;
            color: #92400e;
        }

        .account-message--error {
            border: 1px solid #dc2626;
            background: #fef2f2;
            color: #991b1b;
        }

        .account-message ul {
            margin: 0.75rem 0 0;
            padding-left: 1.25rem;
        }

        .account-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .account-table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        .account-table th,
        .account-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--light-border);
            text-align: left;
            vertical-align: middle;
        }

        .account-table th {
            color: var(--muted-sage);
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .account-name {
            display: block;
            color: var(--light-text);
            font-weight: 600;
        }

        .account-email {
            display: block;
            margin-top: 0.25rem;
            color: var(--muted-sage);
            font-size: 0.82rem;
        }

        .role-badge,
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0.35rem 0.7rem;
            border-radius: 999px;

            font-size: 0.75rem;
            font-weight: 600;
        }

        .role-badge--superadmin {
            background: #fef3c7;
            color: #92400e;
        }

        .role-badge--admin {
            background: #e0f2fe;
            color: #075985;
        }

        .status-badge--active {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge--inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .account-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .account-action-form {
            margin: 0;
        }

        .account-action-button {
            padding: 0.55rem 0.8rem;

            border: none;
            border-radius: 6px;

            cursor: pointer;
            font-family: var(--font-sans);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .account-action-button--status {
            background: #e0f2fe;
            color: #075985;
        }

        .account-action-button--delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .protected-account {
            color: var(--muted-sage);
            font-size: 0.78rem;
            font-style: italic;
        }

        .account-back-link {
            display: inline-block;
            margin-bottom: 1.5rem;

            color: var(--muted-sage);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .account-back-link:hover {
            color: var(--rust-buoy-lt);
        }

        @media (max-width: 850px) {
            .account-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .account-main {
                padding: 1.5rem 1rem 3rem;
            }

            .account-card {
                padding: 1.5rem;
            }

            .account-heading h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>

    <header class="site-nav admin-site-nav">
        <div class="nav-inner">

            <a class="brand" href="{{ route('admin_dashboard') }}">
                <span class="brand-mark admin-brand-mark" aria-hidden="true">
                    <img
                        src="{{ asset('uploads/logo-desa-maor.png') }}"
                        alt=""
                        class="brand-logo admin-brand-logo">
                </span>

                <span class="brand-text">
                    <strong>Kelola Admin</strong>
                    <small>{{ $desa['nama'] }}</small>
                </span>
            </a>

            <nav class="nav-links admin-header-links" aria-label="Navigasi admin">

                <a href="{{ route('admin_dashboard') }}" class="admin-web-link">
                    Dashboard
                </a>

                <a href="{{ route('listing') }}" class="admin-web-link">
                    Web Utama
                </a>

                <a href="{{ route('admin_logout') }}" class="admin-logout-link">
                    Logout
                </a>

            </nav>

        </div>
    </header>

    <main class="account-main">

        <a href="{{ route('admin_dashboard') }}" class="account-back-link">
            &larr; Kembali ke Dashboard
        </a>

        <div class="account-heading">
            <h1>Kelola Akun Admin</h1>

            <p>
                Tambahkan akun admin baru, aktifkan atau nonaktifkan akun,
                serta hapus akun yang sudah tidak digunakan.
            </p>
        </div>

        @if (session('success'))
            <div class="account-message account-message--success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="account-message account-message--warning">
                {{ session('warning') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="account-message account-message--error">
                <strong>Admin belum berhasil ditambahkan:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="account-grid">

            <section class="account-card">

                <h2>Tambah Admin Baru</h2>

                <form
                    method="POST"
                    action="{{ route('admin_accounts_store') }}"
                    class="account-form">

                    @csrf

                    <div class="form-group">
                        <label for="admin-name">
                            Nama Admin
                        </label>

                        <input
                            type="text"
                            id="admin-name"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama admin..."
                            maxlength="100"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="admin-email">
                            Email Admin
                        </label>

                        <input
                            type="email"
                            id="admin-email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email admin..."
                            autocomplete="email"
                            required>

                        <small class="form-help">
                            Tautan untuk membuat password akan dikirim ke email ini.
                            Superadmin tidak perlu menentukan password admin baru.
                        </small>
                    </div>

                    <button type="submit" class="account-submit">
                        Tambahkan Admin dan Kirim Email
                    </button>

                </form>

            </section>

            <section class="account-card">

                <h2>Daftar Akun Admin</h2>

                <div class="account-table-wrapper">

                    <table class="account-table">

                        <thead>
                            <tr>
                                <th>Admin</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($admins as $admin)

                                <tr>

                                    <td>
                                        <span class="account-name">
                                            {{ $admin->name }}

                                            @if (auth('admin')->id() === $admin->id)
                                                (Anda)
                                            @endif
                                        </span>

                                        <span class="account-email">
                                            {{ $admin->email }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($admin->role === 'superadmin')
                                            <span class="role-badge role-badge--superadmin">
                                                Superadmin
                                            </span>
                                        @else
                                            <span class="role-badge role-badge--admin">
                                                Admin
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($admin->is_active)
                                            <span class="status-badge status-badge--active">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="status-badge status-badge--inactive">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td>

                                        @if ($admin->role === 'superadmin')

                                            <span class="protected-account">
                                                Akun utama dilindungi
                                            </span>

                                        @else

                                            <div class="account-actions">

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin_accounts_toggle', $admin) }}"
                                                    class="account-action-form">

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="account-action-button account-action-button--status">

                                                        {{ $admin->is_active ? 'Nonaktifkan' : 'Aktifkan' }}

                                                    </button>

                                                </form>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin_accounts_destroy', $admin) }}"
                                                    class="account-action-form"
                                                    onsubmit="return confirm(
                                                        'Apakah Anda yakin ingin menghapus akun admin ini?'
                                                    );">

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="account-action-button account-action-button--delete">

                                                        Hapus

                                                    </button>

                                                </form>

                                            </div>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4">
                                        Belum ada akun admin.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

        </div>

    </main>

</body>

</html>