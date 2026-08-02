<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()
                ->route('admin_login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($admin->role !== 'superadmin') {
            abort(403, 'Halaman ini hanya dapat diakses oleh superadmin.');
        }

        return $next($request);
    }
}