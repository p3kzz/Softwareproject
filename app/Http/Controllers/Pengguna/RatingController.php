<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\pesanan;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pesanan_id' => 'required|exists:pesanan,id',
                'menu_id' => 'required|exists:menu,id',
                'rating' => 'required|integer|min:1|max:5',
                'komentar' => 'nullable|string|max:255',
            ]);

            $rating = new Rating();
            $rating->pesanan_id = $request->pesanan_id;
            $rating->menu_id = $request->menu_id;
            $rating->rating = $request->rating;
            $rating->komentar = $request->komentar;
            $rating->user_id = $request->user_id ?: null;
            $rating->pelanggan_id = $request->pelanggan_id ?: null;
            $rating->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Jika ada error, balas JSON error
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
