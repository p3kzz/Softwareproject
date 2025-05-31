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

    public function edit($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);
        return view('admin.kasir-edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $kasir->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $kasir->name = $request->name;
        $kasir->email = strtolower($request->email);

        if ($request->filled('password')) {
            $kasir->password = Hash::make($request->password);
        }

        $kasir->save();

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kasir = User::where('role', 'kasir')->findOrFail($id);
        $kasir->delete();

        return redirect()->route('admin.kasir.index')->with('success', 'Kasir berhasil dihapus');
    }
}
