<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Pengaturan Profil Akun
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola informasi profil, kata sandi, dan keamanan akun KRL Review Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 space-y-6">
            <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-2xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-2xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-slate-200 shadow-2xs rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
