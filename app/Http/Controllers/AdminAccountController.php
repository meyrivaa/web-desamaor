<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminAccountController extends Controller
{
    public function index(): View
    {
        $admins = Admin::query()
            ->orderByRaw("
                CASE
                    WHEN role = 'superadmin' THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('name')
            ->get();

        return view('admin_accounts', [
            'desa' => config('desa'),
            'admins' => $admins,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'email' => strtolower(
                trim((string) $request->input('email'))
            ),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:admins,email',
            ],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Str::random(40),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $status = Password::broker('admins')->sendResetLink([
            'email' => $admin->email,
        ]);

        if ($status === Password::ResetLinkSent) {
            return redirect()
                ->route('admin_accounts')
                ->with(
                    'success',
                    'Admin berhasil ditambahkan. Tautan pembuatan password telah dikirim ke email admin tersebut.'
                );
        }

        return redirect()
            ->route('admin_accounts')
            ->with(
                'warning',
                'Admin berhasil ditambahkan, tetapi email pembuatan password belum berhasil dikirim. Admin dapat menggunakan menu Lupa Password.'
            );
    }

    public function toggleStatus(Admin $admin): RedirectResponse
    {
        if ($admin->role === 'superadmin') {
            abort(
                403,
                'Akun superadmin tidak dapat dinonaktifkan.'
            );
        }

        $admin->update([
            'is_active' => !$admin->is_active,
        ]);

        $message = $admin->is_active
            ? 'Akun admin berhasil diaktifkan.'
            : 'Akun admin berhasil dinonaktifkan.';

        return redirect()
            ->route('admin_accounts')
            ->with('success', $message);
    }

    public function destroy(Admin $admin): RedirectResponse
    {
        if ($admin->role === 'superadmin') {
            abort(
                403,
                'Akun superadmin tidak dapat dihapus.'
            );
        }

        DB::table('password_reset_tokens')
            ->where('email', $admin->email)
            ->delete();

        $admin->delete();

        return redirect()
            ->route('admin_accounts')
            ->with(
                'success',
                'Akun admin berhasil dihapus.'
            );
    }
}