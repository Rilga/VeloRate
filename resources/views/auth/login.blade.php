<x-guest-layout>
    <div class="w-full max-w-md mx-auto p-2">
        
        {{-- Welcome Header --}}
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-[#1e293b]">Welcome Back</h2>
            <p class="text-sm text-slate-500 mt-1">Please log in to your account to access the evaluation platform.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Menginisialisasi state Alpine.js 'showPassword' pada form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
            @csrf

            <div class="space-y-1">
                <x-input-label for="email" :value="__('Email')" class="text-[#1e293b] font-semibold text-xs" />
                <x-text-input id="email" 
                    class="block w-full border-slate-200 bg-slate-50 focus:border-[#1e293b] focus:ring-[#1e293b] rounded-xl shadow-sm text-sm p-3.5 transition-all" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required autofocus 
                    autocomplete="username" 
                    placeholder="name@company.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="text-[#1e293b] font-semibold text-xs" />
                    @if (Route::has('password.request'))
                        <a class="text-xs text-[#1e293b] hover:underline font-medium" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                {{-- Menggunakan Flexbox Container dengan background menyatu --}}
                <div class="flex items-center w-full border border-slate-200 bg-slate-50 rounded-xl shadow-sm focus-within:border-[#1e293b] focus-within:ring-1 focus-within:ring-[#1e293b] transition-all p-1">
                    
                    {{-- Perbaikan: Mengubah ::type menjadi :type agar dieksekusi oleh Alpine.js --}}
                    <input id="password" 
                        class="w-full bg-transparent border-0 focus:ring-0 text-sm p-2.5 outline-none text-slate-800"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••" 
                        style="border: none !important; box-shadow: none !important; outline: none !important;" />

                    {{-- Tombol Toggle Mata --}}
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="px-3 text-slate-400 hover:text-[#1e293b] focus:outline-none transition-colors flex-shrink-0"
                            style="background: none; border: none; outline: none;">
                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" style="font-size: 14px;"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#1e293b] shadow-sm focus:ring-[#1e293b] cursor-pointer" name="remember">
                    <span class="ms-2 text-xs font-medium text-slate-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- Action Button --}}
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#1e293b] hover:bg-[#334155] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e293b] transition-all uppercase tracking-wider active:scale-[0.98]">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
        
    </div>
</x-guest-layout>