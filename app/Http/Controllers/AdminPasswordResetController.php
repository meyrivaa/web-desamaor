<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AdminPasswordResetController extends Controller
{
    public function showForgotForm(): View
    {
        return view('admin_forgot_password', [
            'desa' => config('desa'),
        ]);
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::ResetLinkSent) {
            return back()->with(
                'status',
                'Tautan reset password telah dikirim ke email admin.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => __($status),
            ]);
    }

    public function showResetForm(
        Request $request,
        string $token
    ): View {
        return view('admin_reset_password', [
            'desa' => config('desa'),
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],
        ]);

        $status = Password::broker('admins')->reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function (Admin $admin, string $password): void {
                $admin->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $admin->save();

                event(new PasswordReset($admin));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()
                ->route('admin_login')
                ->with(
                    'status',
                    'Password berhasil diubah. Silakan login menggunakan password baru.'
                );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => __($status),
            ]);
    }
}