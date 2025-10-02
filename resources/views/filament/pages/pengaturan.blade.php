<x-filament-panels::page>
    <div class="grid gap-6 md:grid-cols-2">
        {{-- Card Ubah Password --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-lock-closed class="h-5 w-5" />
                    Ubah Password
                </div>
            </x-slot>
            
            <x-slot name="description">
                Kelola password akun Anda untuk keamanan.
            </x-slot>

            <form wire:submit="changePassword">
                {{ $this->form }}
                
                <div class="mt-6">
                    <x-filament::button type="submit" color="primary">
                        Simpan Password Baru
                    </x-filament::button>
                </div>
            </form>
        </x-filament::section>

        {{-- Card Info Akun --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-user-circle class="h-5 w-5" />
                    Informasi Akun
                </div>
            </x-slot>

            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</p>
                    <p class="text-base font-semibold">{{ auth()->user()->name }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                    <p class="text-base font-semibold">{{ auth()->user()->email }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</p>
                    <p class="text-base font-semibold capitalize">{{ auth()->user()->role }}</p>
                </div>

                @if(auth()->user()->google_linked)
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Google Account</p>
                    <p class="text-base font-semibold">{{ auth()->user()->google_email }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">✓ Terhubung</p>
                </div>
                @endif
            </div>
        </x-filament::section>

        {{-- Card Aksi Lainnya --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-cog-6-tooth class="h-5 w-5" />
                    Aksi Lainnya
                </div>
            </x-slot>

            <div class="space-y-3">
                @if(auth()->user()->isMahasiswa())
                <x-filament::button 
                    wire:click="editProfile"
                    color="gray"
                    outlined
                    class="w-full justify-start"
                >
                    <x-heroicon-o-identification class="h-4 w-4 mr-2" />
                    Edit Profile Mahasiswa
                </x-filament::button>
                @endif

                <form action="{{ route('filament.dashboard.auth.logout') }}" method="post" class="w-full">
                    @csrf
                    <x-filament::button 
                        type="submit"
                        color="danger"
                        outlined
                        class="w-full justify-start"
                    >
                        <x-heroicon-o-arrow-right-on-rectangle class="h-4 w-4 mr-2" />
                        Logout
                    </x-filament::button>
                </form>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

