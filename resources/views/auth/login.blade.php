<x-guest-layout>
    <div class="w-full max-w-md mx-auto p-2">
        
        {{-- Welcome Header --}}
        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold" style="color: #D1232A;">Welcome Back</h2>
            <p class="text-sm text-slate-500 mt-1">Please log in to your account to access the evaluation platform.</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Menginisialisasi state Alpine.js 'showPassword' pada form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
            @csrf

            {{-- Email Field Block --}}
            <div class="space-y-1">
                <label for="email" class="block text-slate-700 font-semibold text-xs mb-1">Email</label>
                {{-- Menggunakan input HTML murni dengan inline style untuk border fokus merah --}}
                <input id="email" 
                    class="block w-full border border-slate-200 bg-slate-50 rounded-xl shadow-sm text-sm p-3.5 transition-all outline-none" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required autofocus 
                    autocomplete="username" 
                    placeholder="name@company.com"
                    onfocus="this.style.borderColor='#D1232A'; this.style.boxShadow='0 0 0 1px #D1232A';"
                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            {{-- Password Field Block --}}
            <div class="space-y-1">
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-slate-700 font-semibold text-xs">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium hover:underline" style="color: #D1232A;" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                {{-- Menggunakan Flexbox Container dengan inline dynamic style untuk efek fokus merah --}}
                <div id="passwordContainer" class="flex items-center w-full border border-slate-200 bg-slate-50 rounded-xl shadow-sm transition-all p-1">
                    
                    <input id="password" 
                        class="w-full bg-transparent border-0 text-sm p-2.5 outline-none text-slate-800 focus:ring-0 focus:outline-none"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••" 
                        style="border: none !important; box-shadow: none !important; outline: none !important;"
                        onfocus="document.getElementById('passwordContainer').style.borderColor='#D1232A'; document.getElementById('passwordContainer').style.boxShadow='0 0 0 1px #D1232A';"
                        onblur="document.getElementById('passwordContainer').style.borderColor='#e2e8f0'; document.getElementById('passwordContainer').style.boxShadow='none';" />

                    {{-- Tombol Toggle Mata --}}
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="px-3 text-slate-400 focus:outline-none transition-colors flex-shrink-0"
                            style="background: none; border: none; outline: none; shadow: none;"
                            onmouseover="this.style.color='#D1232A'"
                            onmouseout="this.style.color='#94a3b8'">
                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'" style="font-size: 14px;"></i>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            {{-- Remember Me Block --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 shadow-sm cursor-pointer" name="remember" style="color: #D1232A;">
                    <span class="ms-2 text-xs font-medium text-slate-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            {{-- Action Button Block --}}
            <div class="pt-2">
                {{-- Memaksa tombol Log In berwarna Merah IAI menggunakan inline style --}}
                <button type="submit" 
                        class="w-full flex justify-center py-3.5 px-4 text-sm font-bold text-white rounded-xl shadow-md transition-all uppercase tracking-wider active:scale-[0.98]"
                        style="background-color: #D1232A; border: none;"
                        onmouseover="this.style.backgroundColor='#b01b21'"
                        onmouseout="this.style.backgroundColor='#D1232A'">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
        
    </div>
</x-guest-layout>