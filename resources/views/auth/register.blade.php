<x-guest-layout>
    <style>
        /* Mengganti warna background autofill browser agar tetap bersih */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="w-full min-h-screen flex flex-col lg:flex-row relative overflow-hidden">

        <div class="relative w-full lg:w-[45%] bg-[#990000] text-white flex flex-col justify-center items-center p-8 lg:p-12 z-10">
            
            <div class="absolute inset-0 bg-gradient-to-br from-[#b30000] to-[#660000] z-0"></div>

            <div class="relative z-30 flex flex-col items-center text-center mb-16 lg:mb-0 lg:pr-16">
                <div class="bg-white rounded-full p-2 mb-6 shadow-xl w-40 h-40 flex items-center justify-center transform hover:scale-105 transition duration-500 overflow-hidden border-4 border-red-900/10">
                    <img src="{{ asset('img/Burmin_logo.jpg') }}" alt="Logo Burjo Minang" class="w-full h-full object-cover rounded-full">
                </div>
    
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-wider mb-3 drop-shadow-md whitespace-nowrap">
                    BURJO MINANG
                </h1>
                
                <p class="text-base text-yellow-400 font-medium tracking-wide opacity-90 px-4">
                    Gabung dan nikmati cita rasa otentik.
                </p>
            </div>

            <div class="hidden lg:block absolute top-0 right-[-1px] h-full w-28 z-20 pointer-events-none text-white">
                 <svg viewBox="0 0 100 800" preserveAspectRatio="none" class="h-full w-full fill-current">
                    <path d="M100,0 H0 
                             C20,150 60,250 30,400 
                             C0,550 60,680 20,800 
                             H100 Z"></path>
                </svg>
            </div>
            
            <div class="absolute bottom-[-1px] left-0 w-full lg:hidden z-20 leading-[0] text-white">
                <svg viewBox="0 0 1440 320" class="w-full h-auto fill-current">
                    <path d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
        </div>

        <div class="w-full lg:w-[55%] bg-white flex flex-col justify-center relative z-0 px-8 sm:px-12 lg:px-24 py-12">
            
            <div class="w-full max-w-md mx-auto">
                <h2 class="text-4xl font-bold text-gray-800 mb-2 text-center lg:text-left">Daftar Akun</h2>
                <p class="text-gray-400 mb-8 text-sm text-center lg:text-left">Lengkapi data diri Anda untuk bergabung.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="relative group">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="Nama Anda">
                        
                        <div class="absolute right-0 bottom-4 text-gray-300 group-focus-within:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="relative group">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required 
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="nama@email.com">
                        
                        <div class="absolute right-0 bottom-4 text-gray-300 group-focus-within:text-red-500 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="relative group">
                        <label for="phone_number" class="block text-sm font-bold text-gray-700 mb-1">No HP / WhatsApp</label>
                        <input id="phone_number" type="text" name="phone_number" :value="old('phone_number')" required 
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="08xxxxxxxxxx"
                            inputmode="numeric" 
                            pattern="[0-9]*"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        
                        <div class="absolute right-0 bottom-4 text-gray-300 group-focus-within:text-red-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>

                    <div class="relative group">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="••••••••">
                        
                         <div class="absolute right-0 bottom-4 text-gray-300 group-focus-within:text-red-500 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="relative group">
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="••••••••">
                        
                         <div class="absolute right-0 bottom-4 text-gray-300 group-focus-within:text-red-500 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex flex-col gap-4 mt-8 pt-2">
                        <button type="submit" class="w-full px-6 py-4 bg-[#c70024] hover:bg-[#a3001e] text-white rounded-full font-bold shadow-lg hover:shadow-red-500/30 hover:-translate-y-1 transition-all duration-300 text-base tracking-wide">
                            {{ __('Daftar Sekarang') }}
                        </button>
                    </div>

                    <div class="mt-6 text-center text-sm text-gray-500">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-bold text-red-700 hover:text-red-900 hover:underline transition-colors">
                            Masuk di sini
                        </a>
                    </div>
                </form>

                <div class="mt-12 text-xs text-gray-400 text-center">
                    &copy; 2025 Burjo Minang. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>