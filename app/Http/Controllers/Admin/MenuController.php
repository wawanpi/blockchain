<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\DailyKetersediaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB; // <-- PENTING: Tambahkan ini untuk DB Transaction

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // =========================================================================
        // 0. AUTO-GENERATE DAILY STOCK LOGIC
        // =========================================================================
        
        $today = Carbon::today();

        // 1. Cek apakah data daily_ketersediaan untuk tanggal hari ini sudah ada?
        $cekDataHariIni = DailyKetersediaan::whereDate('tanggal', $today)->exists();

        // 2. Jika BELUM ADA (kosong), maka lakukan Auto-Generate
        if (!$cekDataHariIni) {
            $allMenus = Menu::all();

            // Gunakan DB Transaction agar proses insert aman (semua masuk atau tidak sama sekali)
            DB::transaction(function () use ($allMenus, $today) {
                foreach ($allMenus as $menu) {
                    DailyKetersediaan::create([
                        'menu_id'          => $menu->id,
                        'tanggal'          => $today,
                        // Reset Penuh sesuai kapasitas master menu
                        'jumlah_awal_hari' => $menu->kapasitas, 
                        'jumlah_saat_ini'  => $menu->kapasitas, 
                    ]);
                }
            });
        }

        // =========================================================================
        // LOGIKA QUERY LAMA (Menampilkan Data)
        // =========================================================================

        $query = Menu::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('namaMenu', 'like', '%' . $request->search . '%');
        }

        // Load relasi ketersediaanHariIni agar kolom 'Jumlah Hari Ini' di tabel tidak 0
        $menus = $query->latest()->with('ketersediaanHariIni', 'reviews')->paginate(10); 

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // --- 1. DEFINISI ATURAN VALIDASI ---
        $rules = [
            'namaMenu' => 'required|string|max:255|unique:menus,namaMenu',
            'harga'    => 'required|numeric|min:1', 
            'deskripsi'=> 'nullable|string',
            'kapasitas'=> 'required|integer|min:1', 
            'gambar'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori' => 'required|string|in:makanan,minuman',
        ];

        // --- 2. PESAN ERROR BAHASA INDONESIA (CUSTOM) ---
        $messages = [
            'required' => ':attribute wajib diisi.',
            'string'   => ':attribute harus berupa teks.',
            'numeric'  => ':attribute harus berupa angka.',
            'integer'  => ':attribute harus berupa bilangan bulat.',
            'min'      => ':attribute tidak boleh kurang dari :min.',
            'unique'   => ':attribute sudah terdaftar, gunakan nama lain.',
            'image'    => ':attribute harus berupa gambar.',
            'mimes'    => 'Format :attribute harus: jpeg, png, jpg, gif, atau svg.',
            'max'      => 'Ukuran :attribute maksimal :max KB.',
            'in'       => ':attribute yang dipilih tidak valid.',
        ];

        // Custom Attribute Names
        $customAttributes = [
            'namaMenu' => 'Nama Menu',
            'harga'    => 'Harga',
            'kapasitas'=> 'Kapasitas Harian',
            'gambar'   => 'Gambar Menu',
            'kategori' => 'Kategori',
        ];

        // --- 3. JALANKAN VALIDASI ---
        $validatedData = $request->validate($rules, $messages, $customAttributes);

        // Logika upload gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('menu-images'), $filename);
            
            $validatedData['gambar'] = 'menu-images/' . $filename;
        }

        // 4. Buat Menu Baru
        $menu = Menu::create($validatedData);

        // 5. Set Ketersediaan Hari Ini (Khusus menu baru yg dibuat hari ini)
        DailyKetersediaan::create([
            'menu_id' => $menu->id,
            'tanggal' => Carbon::today(),
            'jumlah_awal_hari' => $menu->kapasitas,
            'jumlah_saat_ini' => $menu->kapasitas,
        ]);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu baru berhasil ditambahkan!');
    }
    
    public function show(Menu $menu)
    {
        $menu->load('reviews.user');
        return view('admin.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $ketersediaanHariIni = $menu->ketersediaanHariIni;
        return view('admin.menus.edit', compact('menu', 'ketersediaanHariIni'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'namaMenu' => 'required|string|max:255|unique:menus,namaMenu,' . $menu->id,
            'harga' => 'required|numeric|min:1',
            'deskripsi' => 'nullable|string',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'kategori' => 'required|string|in:makanan,minuman', 
        ]);
        
        if ($request->hasFile('gambar')) {
            if ($menu->gambar && File::exists(public_path($menu->gambar))) {
                File::delete(public_path($menu->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('menu-images'), $filename);
            $validatedData['gambar'] = 'menu-images/' . $filename;
        }

        $menu->update($validatedData);

        // Update stok hari ini jika kapasitas master berubah
        $ketersediaanHariIni = $menu->ketersediaanHariIni()->firstOrCreate(
            ['tanggal' => Carbon::today()],
            ['jumlah_awal_hari' => 0, 'jumlah_saat_ini' => 0]
        );

        $jumlahTerjual = $ketersediaanHariIni->jumlah_awal_hari - $ketersediaanHariIni->jumlah_saat_ini;
        $jumlahSaatIniBaru = $menu->kapasitas - $jumlahTerjual;

        $ketersediaanHariIni->update([
            'jumlah_awal_hari' => $menu->kapasitas,
            'jumlah_saat_ini' => max(0, $jumlahSaatIniBaru), 
        ]);

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->gambar && File::exists(public_path($menu->gambar))) {
            File::delete(public_path($menu->gambar));
        }
        
        $menu->delete();

        return redirect()->route('admin.menus.index')
                         ->with('success', 'Menu berhasil dihapus.');
    }

    // =========================================================================
    // FITUR BARU: KHUSUS TAMBAH KUOTA HARIAN
    // =========================================================================

    /**
     * Menampilkan form khusus untuk menambah kuota (stok) tanpa edit data lain.
     */
    public function editKuota(Menu $menu)
    {
        // Ambil data ketersediaan hari ini, atau buat default jika belum ada
        $ketersediaan = $menu->ketersediaanHariIni()->firstOrCreate(
            ['tanggal' => Carbon::today()],
            ['jumlah_awal_hari' => $menu->kapasitas, 'jumlah_saat_ini' => $menu->kapasitas]
        );

        return view('admin.menus.add_quota', compact('menu', 'ketersediaan'));
    }

    /**
     * Memproses penambahan kuota harian.
     */
    public function updateKuota(Request $request, Menu $menu)
    {
        $request->validate([
            'tambahan_kuota' => 'required|integer|min:1',
        ], [
            'tambahan_kuota.required' => 'Jumlah tambahan wajib diisi.',
            'tambahan_kuota.min'      => 'Minimal tambahan adalah 1 porsi.',
        ]);

        $today = Carbon::today();

        // Cari record hari ini
        $daily = DailyKetersediaan::where('menu_id', $menu->id)
                    ->whereDate('tanggal', $today)
                    ->first();

        if ($daily) {
            // Tambahkan ke 'jumlah_saat_ini' (stok ready)
            // Tambahkan juga ke 'jumlah_awal_hari' (karena kapasitas hari ini bertambah)
            $daily->increment('jumlah_saat_ini', $request->tambahan_kuota);
            $daily->increment('jumlah_awal_hari', $request->tambahan_kuota);
        } else {
            // Jaga-jaga jika data belum ada (fallback)
            DailyKetersediaan::create([
                'menu_id' => $menu->id,
                'tanggal' => $today,
                'jumlah_awal_hari' => $menu->kapasitas + $request->tambahan_kuota,
                'jumlah_saat_ini'  => $menu->kapasitas + $request->tambahan_kuota,
            ]);
        }

        // Redirect kembali ke DASHBOARD agar Admin bisa lanjut pantau
        return redirect()->route('admin.dashboard')
                         ->with('success', "Porsi {$menu->namaMenu} berhasil ditambah {$request->tambahan_kuota} porsi.");
    }
}