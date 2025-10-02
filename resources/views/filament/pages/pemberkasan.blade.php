<x-filament-panels::page>
    @php
        $userId = auth()->id();
        $khs = \App\Models\Khs::where('mahasiswa_id', $userId)->latest()->first();
        $surat = \App\Models\SuratBalasan::where('mahasiswa_id', $userId)->latest()->first();
        $laporan = \App\Models\LaporanPkl::where('mahasiswa_id', $userId)->latest()->first();
        
        $hasKhs = (bool) $khs;
        $hasSurat = (bool) $surat;
        $hasLaporan = (bool) $laporan;
        
        $kOk = $hasKhs && strtolower($khs->status_validasi ?? '') === 'tervalidasi';
        $sOk = $hasSurat && strtolower($surat->status_validasi ?? '') === 'tervalidasi';
        $lOk = $hasLaporan && strtolower($laporan->status_validasi ?? '') === 'tervalidasi';
        
        $okCount = ($kOk ? 1 : 0) + ($sOk ? 1 : 0) + ($lOk ? 1 : 0);
        
        $profile = auth()->user()->mahasiswaProfile;
    @endphp

    {{-- Progress Overview --}}
    <x-filament::section>
        <x-slot name="heading">
            Progress Pemberkasan PKL
        </x-slot>

        @if($okCount === 3)
        <x-filament::badge color="success" class="mb-4">
            ✓ Selamat! Semua berkas telah tervalidasi
        </x-filament::badge>
        @else
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Silakan lengkapi berkas PKL Anda. Pastikan setiap dokumen berstatus <strong>tervalidasi</strong>.
        </p>
        @endif

        <div class="flex items-center gap-4 mb-4">
            <div class="flex-1">
                <div class="flex gap-2 h-3">
                    <div class="flex-1 rounded-full {{ $kOk ? 'bg-success-500' : ($hasKhs ? 'bg-warning-500' : 'bg-gray-300') }}"></div>
                    <div class="flex-1 rounded-full {{ $sOk ? 'bg-success-500' : ($hasSurat ? 'bg-warning-500' : 'bg-gray-300') }}"></div>
                    <div class="flex-1 rounded-full {{ $lOk ? 'bg-success-500' : ($hasLaporan ? 'bg-warning-500' : 'bg-gray-300') }}"></div>
                </div>
            </div>
            <span class="text-sm font-bold">{{ $okCount }}/3</span>
        </div>

        <p class="text-xs text-gray-500">KHS • Surat Balasan • Laporan PKL</p>
    </x-filament::section>

    <div class="grid gap-6 md:grid-cols-1">
        {{-- Step 1: KHS --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-academic-cap class="h-5 w-5" />
                    Step 1: Unggah KHS
                </div>
            </x-slot>

            <div class="space-y-4">
                @if($khs)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium">Status:</p>
                        @if(strtolower($khs->status_validasi) === 'tervalidasi')
                            <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                        @elseif(strtolower($khs->status_validasi) === 'revisi')
                            <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                        @else
                            <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                        @endif
                        
                        <p class="text-xs text-gray-500 mt-2">
                            <a href="{{ Storage::url($khs->file_path) }}" target="_blank" class="text-primary-600 hover:underline">
                                Lihat File
                            </a>
                        </p>
                    </div>
                    
                    <x-filament::button 
                        wire:click="deleteKhs" 
                        color="danger" 
                        size="sm"
                        wire:confirm="Yakin ingin menghapus KHS?"
                    >
                        Hapus
                    </x-filament::button>
                </div>
                @endif

                <form wire:submit="uploadKhs">
                    {{ $this->formKhs }}
                    
                    <div class="mt-4">
                        <x-filament::button type="submit" color="primary">
                            {{ $khs ? 'Ganti File KHS' : 'Upload KHS' }}
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </x-filament::section>

        {{-- Step 2: Surat Balasan --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-envelope class="h-5 w-5" />
                    Step 2: Unggah Surat Balasan Mitra/Instansi
                </div>
            </x-slot>

            <div class="space-y-4">
                @if($surat)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium">Status:</p>
                        @if(strtolower($surat->status_validasi) === 'tervalidasi')
                            <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                        @elseif(strtolower($surat->status_validasi) === 'revisi')
                            <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                        @else
                            <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                        @endif
                        
                        <p class="text-xs text-gray-500 mt-2">
                            <a href="{{ Storage::url($surat->file_path) }}" target="_blank" class="text-primary-600 hover:underline">
                                Lihat File
                            </a>
                            <br>
                            Mitra: {{ $surat->mitra_id ? \App\Models\Mitra::find($surat->mitra_id)?->nama : $surat->mitra_nama_custom }}
                        </p>
                    </div>
                    
                    <x-filament::button 
                        wire:click="deleteSurat" 
                        color="danger" 
                        size="sm"
                        wire:confirm="Yakin ingin menghapus Surat Balasan?"
                    >
                        Hapus
                    </x-filament::button>
                </div>
                @endif

                <form wire:submit="uploadSurat">
                    {{ $this->formSurat }}
                    
                    <div class="mt-4">
                        <x-filament::button type="submit" color="primary">
                            {{ $surat ? 'Ganti Surat Balasan' : 'Upload Surat Balasan' }}
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </x-filament::section>

        {{-- Step 3: Laporan PKL --}}
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-clipboard-document-check class="h-5 w-5" />
                    Step 3: Unggah Laporan PKL
                </div>
            </x-slot>

            <div class="space-y-4">
                @if($laporan)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm font-medium">Status:</p>
                        @if(strtolower($laporan->status_validasi) === 'tervalidasi')
                            <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                        @elseif(strtolower($laporan->status_validasi) === 'revisi')
                            <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                        @else
                            <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                        @endif
                        
                        <p class="text-xs text-gray-500 mt-2">
                            <a href="{{ Storage::url($laporan->file_path) }}" target="_blank" class="text-primary-600 hover:underline">
                                Lihat File
                            </a>
                        </p>
                    </div>
                    
                    <x-filament::button 
                        wire:click="deleteLaporan" 
                        color="danger" 
                        size="sm"
                        wire:confirm="Yakin ingin menghapus Laporan PKL?"
                    >
                        Hapus
                    </x-filament::button>
                </div>
                @endif

                <form wire:submit="uploadLaporan">
                    {{ $this->formLaporan }}
                    
                    <div class="mt-4">
                        <x-filament::button type="submit" color="primary">
                            {{ $laporan ? 'Ganti Laporan PKL' : 'Upload Laporan PKL' }}
                        </x-filament::button>
                    </div>
                </form>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>

