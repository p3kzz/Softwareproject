<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CustomAuthenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        // Untuk route /admin atau anaknya, arahkan ke halaman login admin
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        if ($request->is('kasir') || $request->is('kasir/*')) {
            return route('kasir.login');
        }

        // Default pengguna
        return route('login');
    }
}
