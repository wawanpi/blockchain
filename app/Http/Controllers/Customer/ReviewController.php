<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Menampilkan form untuk membuat ulasan baru untuk pesanan tertentu.
     * Rute: GET /riwayat-pesanan/{pesanan}/review/create
     */
    public function create(Pesanan $pesanan)
    {
        // 1. Keamanan: Pastikan user ini adalah pemilik pesanan
        if (Auth::id() !== $pesanan->user_id) {
            abort(403, 'Anda tidak diizinkan memberi ulasan untuk pesanan ini.');
        }

        // 2. Validasi Logika: Hanya bisa diulas jika sudah 'completed'
        if ($pesanan->status !== 'completed') {
            return redirect()->route('orders.index')->with('error', 'Anda hanya bisa memberi ulasan untuk pesanan yang sudah selesai.');
        }

        // 3. Validasi Logika: Cek apakah sudah pernah diulas
        if ($pesanan->reviews()->exists()) {
             return redirect()->route('orders.index')->with('error', 'Pesanan ini sudah pernah Anda ulas.');
        }

        // 4. Ambil data menu dari pesanan (eager load)
        $pesanan->load('details.menu');

        // 5. Tampilkan view form
        return view('reviews.create', compact('pesanan'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     * Rute: POST /riwayat-pesanan/{pesanan}/review
     */
    public function store(Request $request, Pesanan $pesanan)
    {
        // 1. Keamanan: Pastikan user ini adalah pemilik pesanan
        if (Auth::id() !== $pesanan->user_id) {
            abort(403, 'Anda tidak diizinkan memberi ulasan untuk pesanan ini.');
        }

        // 2. Validasi Logika: Cek apakah sudah 'completed' atau sudah diulas
        if ($pesanan->status !== 'completed' || $pesanan->reviews()->exists()) {
            return redirect()->route('orders.index')->with('error', 'Ulasan tidak dapat disimpan.');
        }

        // 3. Validasi Form
        // 'reviews' akan menjadi array, jadi kita validasi setiap isinya
        $request->validate([
            'reviews' => 'required|array',
            'reviews.*.menu_id' => 'required|exists:menus,id', // Pastikan menu_id-nya ada
            'reviews.*.rating' => 'required|integer|min:1|max:5', // Rating 1-5
            'reviews.*.komentar' => 'nullable|string|max:1000', // Komentar boleh kosong
        ]);

        $ulasanData = $request->input('reviews');
        $userId = Auth::id();

        // 4. Gunakan Transaction (agar aman)
        try {
            DB::beginTransaction();

            foreach ($ulasanData as $menuId => $data) {
                // Pastikan menu_id dari form-looping sama
                if ($menuId != $data['menu_id']) {
                    throw new \Exception('Menu ID tidak cocok.');
                }
                
                Review::create([
                    'user_id' => $userId,
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $data['menu_id'],
                    'rating' => $data['rating'],
                    'komentar' => $data['komentar'],
                ]);
            }

            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            // Tampilkan error jika gagal
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan ulasan: ' . $e->getMessage());
        }

        // 5. Redirect kembali ke riwayat pesanan dengan pesan sukses
        return redirect()->route('orders.index')->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');
    }
}