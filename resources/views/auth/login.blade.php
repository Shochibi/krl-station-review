<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
        <p class="text-xs text-slate-500 mt-1">Akses buku saku catatan pribadi dan bagikan ulasan stasiun.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Alamat Email
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username"
                   placeholder="nama@email.com"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="text-xs font-bold uppercase tracking-wider text-slate-700">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a class="text-[11px] text-red-600 hover:text-red-700 font-semibold" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500" name="remember">
                <span class="ms-2 text-xs font-medium text-slate-600">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <button type="submit"
                class="w-full py-3 px-4 rounded-xl font-bold text-xs text-white bg-red-600 hover:bg-red-700 active:bg-red-800 shadow-md shadow-red-600/20 transition-all flex items-center justify-center gap-2 mt-4">
            Masuk ke KRL Review
        </button>

        <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
            Belum punya akun komuter?
            <a href="{{ route('register') }}" class="font-bold text-red-600 hover:text-red-700 ml-1">
                Daftar sekarang
            </a>
        </div>
    </form>
</x-guest-layout>
