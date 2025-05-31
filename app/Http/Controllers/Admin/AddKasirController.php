<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AddKasirController extends Controller
{
    public function index()
    {
        $kasirs = \App\Models\User::where('role', 'kasir')->get();
        return view('admin.kasir', compact('kasirs'));
    }

    public function create()
    {
        return view('admin.add-kasir');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $kasir = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'kasir',
        ]);

        event(new Registered($kasir));

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil ditambahkan');
    }
}
