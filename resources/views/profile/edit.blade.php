<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-[30px] leading-[1.2]">
            <span class="text-ember">Profil</span>
            <span class="text-graphite">Pengguna</span>
        </h2>
    </x-slot>

    <div class="py-12 pb-24">
        <div class="max-w-page mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 bg-paper border border-fog rounded-pill">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 bg-paper border border-fog rounded-pill">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-8 bg-paper border border-fog rounded-pill">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
