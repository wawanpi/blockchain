<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\DailyKetersediaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Cart;
use Illuminate\Support\Carbon;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi checkout.
     */
    public function index()
    {
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();

        if ($cartItems->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Keranjang Anda kosong. Silakan pilih menu terlebih dahulu.');
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    /**
     * Menyimpan pesanan ke database.
     */
    public function store(Request $request)
    {
        $cartItems = Cart::getContent();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Keranjang Anda kosong.');
        }

        // --- 1. Validasi Data ---
        $validatedData = $request->validate([
            'tipe_layanan' => 'required|in:Take Away,Dine-in', 
            'catatan_pelanggan' => 'nullable|string|max:255',
            'jumlah_tamu' => 'required_if:tipe_layanan,Dine-in|nullable|numeric|min:1',
            
            // [BARU] Validasi Metode Pembayaran
            'metode_pembayaran' => 'required|in:Transfer Bank,QRIS',
            
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            'metode_pembayaran.required' => 'Silakan pilih metode pembayaran.',
            'bukti_bayar.required' => 'Anda wajib mengupload bukti transfer.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // --- 2. Proses Upload Gambar ---
        $buktiBayarPath = null;
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('payment_proofs'), $filename);
            $buktiBayarPath = 'payment_proofs/' . $filename;
        }

        // --- 3. Proses Transaksi Database ---
        try {
            DB::beginTransaction();

            // Simpan "kepala" pesanan ke tabel 'pesanans'
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'total_bayar' => Cart::getTotal(),
                'status' => 'pending', 
                'catatan_pelanggan' => $validatedData['catatan_pelanggan'],
                'tipe_layanan' => $validatedData['tipe_layanan'],
                'jumlah_tamu' => $validatedData['jumlah_tamu'] ?? 1,
                
                // [BARU] Simpan Metode Pembayaran
                'metode_pembayaran' => $validatedData['metode_pembayaran'],
                
                'bukti_bayar' => $buktiBayarPath, 
            ]);

            // Loop semua item di keranjang
            foreach ($cartItems as $item) {
                $menu = Menu::findOrFail($item->id);

                if ($menu->jumlah_saat_ini < $item->quantity) {
                    throw new \Exception('Jumlah untuk menu ' . $menu->namaMenu . ' tidak mencukupi (sisa ' . $menu->jumlah_saat_ini . ').');
                }

                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $item->id,
                    'jumlah' => $item->quantity,
                    'harga_satuan' => $item->price,
                    'subtotal' => $item->getPriceSum()
                ]);

                // Kurangi jumlah harian
                $ketersediaanHariIni = $menu->ketersediaanHariIni;
                $ketersediaanHariIni->decrement('jumlah_saat_ini', $item->quantity);
            }

            Cart::clear();
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan Anda (#'.$pesanan->id.') berhasil dibuat! Mohon tunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($buktiBayarPath && file_exists(public_path($buktiBayarPath))) {
                unlink(public_path($buktiBayarPath));
            }

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return redirect()->back()->withErrors($e->errors())->withInput();
            }

            return redirect()->route('cart.list')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}