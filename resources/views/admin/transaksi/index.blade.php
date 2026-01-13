<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-red-100 rounded-lg text-[#D40000]">
                <i data-lucide="receipt" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    {{ __('Riwayat Transaksi') }}
                </h2>
                <p class="text-sm text-gray-500">Laporan keuangan dan histori pembayaran.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8" 
                 x-data="{
                    range: '{{ request('range', 'daily') }}',
                    startDate: '{{ request('start_date') }}',
                    endDate: '{{ request('end_date') }}',
                    setRange(val) {
                        this.range = val;
                        // Tunggu sebentar agar x-model update, lalu submit
                        this.$nextTick(() => {
                            if (val !== 'custom') {
                                this.$refs.filterForm.submit();
                            }
                        });
                    },
                    checkCustomDate() {
                        if (this.startDate && this.endDate) {
                            this.$refs.filterForm.submit();
                        }
                    }
                }">

                {{-- === KOLOM KIRI: FILTER SIDEBAR === --}}
                <div class="lg:col-span-1 space-y-6">
                    
                    {{-- Filter Card --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i data-lucide="filter" class="w-4 h-4 text-gray-400"></i> Filter Periode
                            </h3>
                        </div>
                        
                        <form x-ref="filterForm" action="{{ route('admin.transaksi.index') }}" method="GET" class="p-3">
                            <div class="space-y-1">
                                
                                {{-- Hari Ini --}}
                                <div @click="setRange('daily')" 
                                     class="cursor-pointer group flex items-center justify-between p-3 rounded-xl transition-all"
                                     :class="range === 'daily' ? 'bg-red-50 text-[#D40000] border border-red-100' : 'hover:bg-gray-50 text-gray-600 border border-transparent'">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="calendar-days" class="w-4 h-4"></i>
                                        <span class="text-sm font-semibold">Hari Ini</span>
                                    </div>
                                    <input type="radio" name="range" value="daily" x-model="range" class="hidden">
                                    <div x-show="range === 'daily'" class="w-2 h-2 rounded-full bg-[#D40000]"></div>
                                </div>

                                {{-- Minggu Ini --}}
                                <div @click="setRange('weekly')"
                                     class="cursor-pointer group flex items-center justify-between p-3 rounded-xl transition-all"
                                     :class="range === 'weekly' ? 'bg-red-50 text-[#D40000] border border-red-100' : 'hover:bg-gray-50 text-gray-600 border border-transparent'">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="calendar-range" class="w-4 h-4"></i>
                                        <span class="text-sm font-semibold">1 Minggu Terakhir</span>
                                    </div>
                                    <input type="radio" name="range" value="weekly" x-model="range" class="hidden">
                                    <div x-show="range === 'weekly'" class="w-2 h-2 rounded-full bg-[#D40000]"></div>
                                </div>

                                {{-- Bulan Ini --}}
                                <div @click="setRange('monthly')"
                                     class="cursor-pointer group flex items-center justify-between p-3 rounded-xl transition-all"
                                     :class="range === 'monthly' ? 'bg-red-50 text-[#D40000] border border-red-100' : 'hover:bg-gray-50 text-gray-600 border border-transparent'">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                        <span class="text-sm font-semibold">1 Bulan Terakhir</span>
                                    </div>
                                    <input type="radio" name="range" value="monthly" x-model="range" class="hidden">
                                    <div x-show="range === 'monthly'" class="w-2 h-2 rounded-full bg-[#D40000]"></div>
                                </div>

                                {{-- Custom Date --}}
                                <div class="pt-2">
                                    <div @click="setRange('custom')"
                                         class="cursor-pointer group flex items-center justify-between p-3 rounded-xl transition-all mb-2"
                                         :class="range === 'custom' ? 'bg-red-50 text-[#D40000] border border-red-100' : 'hover:bg-gray-50 text-gray-600 border border-transparent'">
                                        <div class="flex items-center gap-3">
                                            <i data-lucide="calendar-clock" class="w-4 h-4"></i>
                                            <span class="text-sm font-semibold">Pilih Tanggal</span>
                                        </div>
                                        <input type="radio" name="range" value="custom" x-model="range" class="hidden">
                                        <div x-show="range === 'custom'" class="w-2 h-2 rounded-full bg-[#D40000]"></div>
                                    </div>

                                    <div x-show="range === 'custom'" x-transition class="bg-gray-50 rounded-xl p-3 space-y-3 border border-gray-200 ml-1 mr-1">
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider pl-1">Dari</span>
                                            <input type="date" name="start_date" x-model="startDate" @change="checkCustomDate()"
                                                   class="mt-1 block w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-red-500 focus:ring-red-500">
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider pl-1">Sampai</span>
                                            <input type="date" name="end_date" x-model="endDate" @change="checkCustomDate()"
                                                   class="mt-1 block w-full rounded-lg border-gray-300 text-xs shadow-sm focus:border-red-500 focus:ring-red-500">
                                        </div>
                                        {{-- Tombol Terapkan Manual (Opsional, jika auto-submit gagal) --}}
                                        <button type="submit" class="w-full bg-white border border-gray-300 text-gray-700 text-xs font-bold py-2 rounded-lg hover:bg-gray-100">
                                            Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Tombol Cetak --}}
                    <a href="{{ route('admin.transaksi.cetak', request()->query()) }}" target="_blank"
                       class="flex items-center justify-center gap-2 w-full py-3 bg-gray-900 text-white rounded-xl text-sm font-bold shadow-lg hover:bg-black transition-all transform hover:-translate-y-0.5">
                        <i data-lucide="printer" class="w-4 h-4"></i>
                        Cetak Laporan PDF
                    </a>

                </div>

                {{-- === KOLOM KANAN: KONTEN UTAMA === --}}
                <div class="lg:col-span-3 space-y-6">
                    
                    {{-- TOTAL PENDAPATAN CARD --}}
                    <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5">
                            <i data-lucide="coins" class="w-32 h-32"></i>
                        </div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row justify-between md:items-end gap-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pendapatan</h3>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-4xl font-black text-gray-800 tracking-tight">
                                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2 font-medium bg-white px-2 py-1 rounded-md border border-gray-100 inline-block shadow-sm">
                                    Periode: <span class="text-[#D40000]">{{ ucfirst($filterLabel ?? 'Semua Waktu') }}</span>
                                </p>
                            </div>
                            
                            {{-- Decorative Icon --}}
                            <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 shadow-sm">
                                <i data-lucide="trending-up" class="w-6 h-6"></i>
                            </div>
                        </div>
                    </div>

                    {{-- TABEL DAFTAR TRANSAKSI --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-white flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800">Daftar Transaksi</h3>
                            <div class="text-xs text-gray-400 font-medium">
                                Menampilkan {{ $transaksis->count() }} data terbaru
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-50">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Nominal</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                        {{-- KOLOM BARU UNTUK AKSI AUDIT --}}
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    @forelse ($transaksis as $transaksi)
                                        <tr class="hover:bg-gray-50 transition-colors group">
                                            {{-- ID --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('admin.pesanan.show', $transaksi->pesanan_id) }}" 
                                                   class="font-mono text-sm font-bold text-[#D40000] bg-red-50 px-2 py-1 rounded hover:bg-red-100 transition-colors">
                                                    #{{ $transaksi->id }}
                                                </a>
                                            </td>

                                            {{-- Pelanggan --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                                        {{ substr($transaksi->pesanan->user->name ?? '?', 0, 1) }}
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-700">
                                                        {{ $transaksi->pesanan->user->name ?? 'Guest / Offline' }}
                                                    </span>
                                                </div>
                                            </td>

                                            {{-- Waktu --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">
                                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                            </td>

                                            {{-- Nominal --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-bold text-gray-900">
                                                    Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            {{-- Status --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($transaksi->status_pembayaran == 'paid')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                                        <i data-lucide="check-circle-2" class="w-3 h-3"></i> Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">
                                                        <i data-lucide="x-circle" class="w-3 h-3"></i> {{ ucfirst($transaksi->status_pembayaran) }}
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- AKSI (TOMBOL AUDIT BLOCKCHAIN) --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.transaksi.audit', $transaksi->id) }}"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-bold border border-blue-100"
                                                       title="Cek Integritas Blockchain">
                                                        <i data-lucide="shield-check" class="w-3 h-3"></i> Audit
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                                        <i data-lucide="file-x" class="w-8 h-8"></i>
                                                    </div>
                                                    <p class="text-sm font-medium text-gray-500">Tidak ada transaksi ditemukan.</p>
                                                    <p class="text-xs text-gray-400 mt-1">Coba ubah filter periode waktu Anda.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($transaksis->hasPages())
                            <div class="p-4 border-t border-gray-50 bg-gray-50/50">
                                {{ $transaksis->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>