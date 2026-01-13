<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // <-- PENTING: Impor model Menu

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        return view('cart', compact('cartItems'));
    }

    /**
     * Menambahkan item ke keranjang dengan aman.
     * PERBAIKAN: Cek ketersediaan harian.
     */
    public function addToCart(Request $request)
    {
        // 1. Validasi input dasar
        $request->validate([
            'id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Ambil data produk dari DATABASE
        $menu = Menu::findOrFail($request->id);

        // 3. PERBAIKAN: Cek ketersediaan menggunakan accessor 'jumlah_saat_ini'
        if ($menu->jumlah_saat_ini < $request->quantity) {
            // PERBAIKAN: Pesan error diubah (tidak pakai kata 'stok')
            return redirect()->back()->with('error', 'Jumlah tidak mencukupi untuk ' . $menu->namaMenu);
        }

        // 4. Tambahkan ke keranjang menggunakan data dari database
        \Cart::add([
            'id' => $menu->id,
            'name' => $menu->namaMenu,
            'price' => $menu->harga,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $menu->gambar, 
            ]
        ]);

        session()->flash('success', 'Menu berhasil ditambahkan ke keranjang!');

        // Arahkan ke halaman daftar menu (dashboard) agar bisa belanja lagi
        return redirect()->route('dashboard')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Mengupdate jumlah item di keranjang dengan pengecekan ketersediaan.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($request->id);

        // PERBAIKAN: Cek ketersediaan sebelum update
        if ($menu->jumlah_saat_ini < $request->quantity) {
             // PERBAIKAN: Pesan error diubah (tidak pakai kata 'stok')
            return redirect()->back()->with('error', 'Jumlah tidak mencukupi untuk ' . $menu->namaMenu);
        }

        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Keranjang berhasil diperbarui!');

        return redirect()->route('cart.list');
    }

    /**
     * Menghapus satu item dari keranjang.
     */
    public function removeCart(Request $request)
    {
        $request->validate(['id' => 'required']);
        \Cart::remove($request->id);
        session()->flash('success', 'Item berhasil dihapus dari keranjang!');

        return redirect()->route('cart.list');
    }

    /**
     * Menghapus semua item dari keranjang.
     */
    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'Semua item berhasil dihapus dari keranjang!');

        return redirect()->route('cart.list');
    }
}