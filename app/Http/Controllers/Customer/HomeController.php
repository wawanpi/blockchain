<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk user yang sudah login.
     */
    public function index()
        {
            // Redirect admin
            if (auth()->user() && auth()->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            // === Query 1: Best Seller (Fixed Logic) ===
            // MENGGUNAKAN SUBQUERY untuk Total Terjual agar tidak konflik dengan withAvg
            $bestSellers = Menu::query()
                ->select('menus.*')
                ->selectSub(function ($query) {
                    $query->from('pesanan_details')
                        ->selectRaw('SUM(jumlah)')
                        ->whereColumn('menu_id', 'menus.id');
                }, 'total_terjual')
                ->withAvg('reviews', 'rating') // Load Rating (Aman dari conflict groupBy)
                ->with('ketersediaanHariIni')
                ->havingRaw('total_terjual > 0') // Hanya ambil yang pernah terjual
                ->orderByDesc('total_terjual')
                ->orderByDesc('reviews_avg_rating')
                ->take(8)
                ->get();

            // Fallback jika belum ada data penjualan
            if ($bestSellers->isEmpty()) {
                $bestSellers = Menu::with('ketersediaanHariIni')
                                    ->withAvg('reviews', 'rating')
                                    ->orderByDesc('reviews_avg_rating')
                                    ->inRandomOrder()
                                    ->take(8)
                                    ->get();
            }

            // === Query 2: Makanan ===
            $allFood = Menu::where('kategori', 'makanan')
                            ->with('ketersediaanHariIni')
                            ->withAvg('reviews', 'rating')
                            ->latest()
                            ->get();

            // === Query 3: Minuman ===
            $allDrinks = Menu::where('kategori', 'minuman')
                            ->with('ketersediaanHariIni')
                            ->withAvg('reviews', 'rating')
                            ->latest()
                            ->get();

            return view('dashboard', compact('bestSellers', 'allFood', 'allDrinks'));
        }
}