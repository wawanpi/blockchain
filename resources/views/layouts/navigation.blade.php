{{-- 
    TRAFFIC CONTROLLER
    File ini tidak berisi markup HTML langsung, hanya logika pemilihan view.
--}}

@auth
    @if(Auth::user()->hasRole('admin'))
        {{-- Jika User adalah Admin --}}
        @include('layouts.navigation-admin')
    @else
        {{-- Jika User sudah login tapi bukan Admin (Customer) --}}
        @include('layouts.navigation-user')
    @endif
@else
    {{-- 
        Jika belum login (Tamu/Guest). 
        Biasanya tamu melihat tampilan yang sama dengan User (Customer),
        hanya saja menu profilnya berbeda (sudah dihandle di dalam file user).
    --}}
    @include('layouts.navigation-user')
@endauth