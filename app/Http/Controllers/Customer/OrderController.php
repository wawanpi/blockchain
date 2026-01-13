<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan; 
use Illuminate\Support\Facades\Auth; 
use App\Models\Menu; 
use Cart; 
use App\Models\PesananDetail; // (Import ini sepertinya tidak terpakai di sini, tapi tidak masalah)

class OrderController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan milik user yang sedang login.
     * (Fungsi ini sudah benar)
     */
    public function index()
    {
        // 1. Ambil ID user yang sedang login
        $userId = Auth::id();

        // 2. Ambil semua pesanan dari database HANYA untuk user ini
        $pesanans = Pesanan::where('user_id', $userId)
                            ->with(['details.menu', 'reviews']) // Eager load menu dan reviews
                            ->latest()
                            ->paginate(10); 

        // 3. Tampilkan view 'my-orders.blade.php'
        return view('my-orders', compact('pesanans'));
    }

    /**
     * Menampilkan detail satu pesanan spesifik.
     * (Fungsi ini sudah benar)
     */
    public function show(Pesanan $pesanan) 
    {
        // === PENTING: Cek Keamanan ===
        if (Auth::id() !== $pesanan->user_id) {
            abort(403, 'ANDA TIDAK BERHAK MENGAKSES PESANAN INI.');
        }

        // Jika lolos cek keamanan, ambil semua data yang berhubungan:
        $pesanan->load(['user', 'details.menu', 'reviews']); 
        
        // Tampilkan view 'order-detail.blade.php'
        return view('order-detail', compact('pesanan'));
    }


    /**
     * Memproses "Pesan Lagi" dari pesanan lama.
     * PERBAIKAN: Menggunakan sistem ketersediaan harian.
     *
     * @param int $id ID dari pesanan LAMA
     */
    public function reorder($id)
    {
        // 1. Cari pesanan lama, beserta 'details' dan 'menu'
        // PERBAIKAN: Eager load ketersediaanHariIni agar efisien!
        $pesananLama = Pesanan::with('details.menu.ketersediaanHariIni')->find($id);

        // 2. Keamanan: Pastikan pesanan ada dan milik user yang login
        if (!$pesananLama || $pesananLama->user_id != Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $itemsAdded = 0;
        $itemsSkipped = 0;
        $skippedItemNames = [];

        // 3. Loop setiap item detail di pesanan lama
        foreach ($pesananLama->details as $item) {
            
            // Cek apakah menu dari pesanan lama ini masih ada
            if (!isset($item->menu)) {
                $itemsSkipped++;
                continue; // Lompati item ini jika menu-nya sudah dihapus
            }

            $menu = $item->menu;

            // 4. PERBAIKAN: Cek Ketersediaan Harian
            // Gunakan accessor '$menu->jumlah_saat_ini'
            if ($menu->jumlah_saat_ini >= $item->jumlah) {
                
                // 5. Masukkan ke keranjang baru (menggunakan library Cart)
                Cart::add([
                    'id' => $menu->id,
                    'name' => $menu->namaMenu,
                    'price' => $menu->harga, // Ambil harga TERBARU dari tabel menu
                    'quantity' => $item->jumlah,
                    'attributes' => [
                        'image' => $menu->gambar
                    ]
                ]);
                $itemsAdded++;

            } else {
                // Jika jumlah habis atau menu sudah tidak ada
                $itemsSkipped++;
                $skippedItemNames[] = $menu->namaMenu;
            }
        }

        // 6. Siapkan pesan notifikasi untuk pelanggan
        if ($itemsAdded == 0) {
            // PERBAIKAN: Pesan error diubah
            return redirect()->route('orders.index')->with('error', 'Semua item dari pesanan ini sedang habis atau tidak tersedia.');
        }
        
        // Buat pesan sukses
        $message = "Berhasil menambahkan $itemsAdded item ke keranjang.";
        
        // Jika ada item yang dilewati, tambahkan info peringatan
        if ($itemsSkipped > 0) {
            // PERBAIKAN: Pesan error diubah
            $message .= " " . $itemsSkipped . " item dilewati karena jumlah habis (" . implode(', ', $skippedItemNames) . ").";
        }

        // 7. Arahkan ke halaman keranjang
        return redirect()->route('cart.list')->with('success', $message);
    }
}