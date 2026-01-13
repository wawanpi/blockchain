<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg text-[#D40000]">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="font-black text-xl text-gray-800 leading-tight">
                        {{ __('Manajemen User') }}
                    </h2>
                    <p class="text-sm text-gray-500">Kelola data pengguna dan hak akses sistem.</p>
                </div>
            </div>
            
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 bg-[#D40000] text-white font-bold text-sm rounded-xl shadow-lg shadow-red-200 hover:bg-red-700 hover:-translate-y-0.5 transition-all gap-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Tambah User Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if ($message = Session::get('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex justify-between items-center" role="alert">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>{{ $message }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if ($message = Session::get('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 flex justify-between items-center" role="alert">
                    <div class="flex items-center gap-2">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        <span>{{ $message }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            {{-- Tabel User --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50 bg-white flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="list" class="w-4 h-4 text-gray-400"></i> Daftar Pengguna
                    </h3>
                    <div class="text-xs text-gray-400 font-medium">
                        Total: {{ $users->total() }} User
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-50">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Pengguna</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Role / Hak Akses</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($users as $key => $user)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    
                                    {{-- Kolom Pengguna (Avatar + Nama + Email) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-sm font-bold text-gray-600 border border-gray-200">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom Role --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $roleName)
                                                @if($roleName == 'admin')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-900 text-white border border-gray-700">
                                                        <i data-lucide="shield-check" class="w-3 h-3"></i> Admin
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                        <i data-lucide="user" class="w-3 h-3"></i> {{ ucfirst($roleName) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tidak ada role</span>
                                        @endif
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                                               class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                               title="Edit User">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" 
                                                  class="m-0 block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                        title="Hapus User">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="users" class="w-8 h-8 text-gray-300"></i>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">Belum ada user.</p>
                                        <p class="text-xs text-gray-500 mt-1">Silakan tambahkan user baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="p-4 border-t border-gray-50 bg-gray-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>