<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\PesananDetail;
use App\Models\DailyKetersediaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan Filter & Search.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'details.menu', 'transaksi']);

        // 1. SEARCH: ID, Nama User, atau Catatan (Offline)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  })
                  ->orWhere('catatan_pelanggan', 'like', "%{$search}%");
            });
        }

        // 2. FILTER STATUS
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pesanans = $query
            ->orderByRaw("FIELD(status, 'pending', 'processing', 'completed', 'cancelled')")
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['user', 'details.menu', 'transaksi']); 
        $menus = Menu::orderBy('namaMenu')->get();
        return view('admin.pesanan.show', compact('pesanan', 'menus'));
    }

    /**
     * === [PENTING] LOGIKA UPDATE STATUS & PENGEMBALIAN STOK ===
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $pesanan->status;
            $newStatus = $request->status;

            // Jika pesanan DIBATALKAN (dari status apapun selain cancelled)
            // Maka kita harus MENGEMBALIKAN STOK (Restock)
            if ($newStatus == 'cancelled' && $oldStatus != 'cancelled') {
                
                foreach ($pesanan->details as $detail) {
                    $menu = $detail->menu;
                    
                    // Kembalikan stok ke 'jumlah_saat_ini' di DailyKetersediaan
                    if ($menu && $menu->ketersediaanHariIni) {
                        $menu->ketersediaanHariIni->increment('jumlah_saat_ini', $detail->jumlah);
                    }
                }

                // Opsional: Jika sudah ada transaksi, hapus transaksinya agar laporan keuangan bersih
                if ($pesanan->transaksi) {
                    $pesanan->transaksi()->delete();
                }
            }

            // Update status pesanan
            $pesanan->update(['status' => $newStatus]);

            DB::commit();

            return redirect()->route('admin.pesanan.show', $pesanan)
                             ->with('success', 'Status pesanan diperbarui menjadi ' . strtoupper($newStatus));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Membuat pesanan Offline (Walk-in).
     */
    public function storeOffline(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'nullable|string|max:100',
            'tipe_layanan' => 'required|in:Dine-in,Take Away'
        ]);

        $nama = $request->nama_pelanggan ? $request->nama_pelanggan : 'Pelanggan Offline';
        
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::create([
                'user_id' => auth()->id(),
                'total_bayar' => 0,
                'status' => 'pending',
                'tipe_layanan' => $request->tipe_layanan,
                'catatan_pelanggan' => "OFFLINE - " . $nama,
                'metode_pembayaran' => null,
                
                // [PERBAIKAN LOGIKA JUMLAH TAMU]
                // Jika Dine-in default 1, Jika Take Away 0 (agar tidak muncul di nota)
                'jumlah_tamu' => ($request->tipe_layanan == 'Dine-in') ? 1 : 0,
                
                'bukti_bayar' => null
            ]);

            DB::commit();

            return redirect()->route('admin.pesanan.show', $pesanan->id)
                             ->with('success', 'Pesanan Offline dibuat. Silakan input menu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menambah Item ke Pesanan (Update Stok & Total).
     */
    public function addItem(Request $request, Pesanan $pesanan)
    {
        if (!in_array($pesanan->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Tidak bisa mengubah pesanan yang sudah selesai/batal.');
        }

        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);
        $jumlah = (int)$validated['jumlah'];

        // Cek Stok
        if ($menu->jumlah_saat_ini < $jumlah) {
            return redirect()->back()->with('error', 'Stok ' . $menu->namaMenu . ' tidak cukup (Sisa: ' . $menu->jumlah_saat_ini . ').');
        }

        try {
            DB::beginTransaction();

            $subtotal = $menu->harga * $jumlah;

            // Update/Create Detail
            $existingDetail = $pesanan->details()->where('menu_id', $menu->id)->first();
            if ($existingDetail) {
                $existingDetail->increment('jumlah', $jumlah);
                $existingDetail->increment('subtotal', $subtotal);
            } else {
                PesananDetail::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id' => $menu->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $menu->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            // Update Total & Kurangi Stok
            $pesanan->increment('total_bayar', $subtotal);
            $menu->ketersediaanHariIni->decrement('jumlah_saat_ini', $jumlah);

            // Reset Pembayaran jika harga berubah
            if ($pesanan->transaksi) {
                $pesanan->transaksi()->delete();
                // Jika status processing, kembalikan ke pending karena harus bayar ulang
                if($pesanan->status == 'processing') {
                    $pesanan->update(['status' => 'pending']);
                }
                session()->flash('warning', 'Total harga berubah. Status pembayaran di-reset. Silakan verifikasi ulang.');
            } else {
                session()->flash('success', 'Item berhasil ditambahkan.');
            }

            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}