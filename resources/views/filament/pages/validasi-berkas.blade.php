<x-filament-panels::page>
    <div class="grid gap-6 md:grid-cols-3">
        {{-- Sidebar: Daftar Mahasiswa --}}
        <div class="md:col-span-1">
            <x-filament::section>
                <x-slot name="heading">
                    Mahasiswa Bimbingan
                </x-slot>

                {{-- Search & Sort --}}
                <div class="space-y-3 mb-4">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            wire:model.live.debounce.300ms="searchQuery"
                            placeholder="Cari nama/NIM/prodi..."
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="sortBy">
                            <option value="name_asc">Nama A-Z</option>
                            <option value="name_desc">Nama Z-A</option>
                            <option value="nim_asc">NIM ↑</option>
                            <option value="nim_desc">NIM ↓</option>
                            <option value="progress_desc">Progress ↓</option>
                            <option value="progress_asc">Progress ↑</option>
                        </x-filament::input.select>
                    </x-filament::input.wrapper>
                </div>

                {{-- List Mahasiswa --}}
                <div class="space-y-2 max-h-[600px] overflow-y-auto">
                    @foreach($this->getMahasiswaList() as $mhs)
                    @php
                        $isSelected = $this->selectedMahasiswa === $mhs->id;
                        $progress = (int) $mhs->progress;
                        $progress = min(3, $progress);
                        $percentage = round(($progress / 3) * 100);
                    @endphp
                    <div 
                        wire:click="selectMahasiswa({{ $mhs->id }})"
                        class="p-3 rounded-lg border cursor-pointer transition {{ $isSelected ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-primary-300' }}"
                    >
                        <div class="flex items-center gap-3">
                            @if($mhs->photo)
                            <img src="{{ Storage::url($mhs->photo) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <x-heroicon-o-user class="w-6 h-6 text-gray-400" />
                            </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm truncate">{{ $mhs->name }}</p>
                                <p class="text-xs text-gray-500">{{ $mhs->nim }}</p>
                                
                                {{-- Progress bar --}}
                                <div class="mt-1 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>

                            @if($progress === 3)
                            <x-heroicon-s-check-circle class="w-5 h-5 text-success-500" />
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($this->getMahasiswaList()->isEmpty())
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada mahasiswa</p>
                    @endif
                </div>
            </x-filament::section>
        </div>

        {{-- Main Content: Detail & Validasi --}}
        <div class="md:col-span-2">
            @if($this->selectedMahasiswa)
                @php
                    $mahasiswa = $this->getSelectedMahasiswaData();
                    $profile = $mahasiswa->mahasiswaProfile;
                    $khs = $this->getKhs();
                    $surat = $this->getSurat();
                    $laporan = $this->getLaporan();
                @endphp

                {{-- Info Mahasiswa --}}
                <x-filament::section class="mb-6">
                    <x-slot name="heading">
                        Detail Mahasiswa
                    </x-slot>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500">Nama</p>
                            <p class="font-medium">{{ $mahasiswa->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-medium">{{ $mahasiswa->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">NIM</p>
                            <p class="font-medium">{{ $profile->nim ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Prodi</p>
                            <p class="font-medium">{{ $profile->prodi ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Semester</p>
                            <p class="font-medium">{{ $profile->semester ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">IPK</p>
                            <p class="font-medium">{{ $profile->ipk ?? '-' }}</p>
                        </div>
                    </div>
                </x-filament::section>

                {{-- KHS --}}
                <x-filament::section class="mb-6">
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-academic-cap class="w-5 h-5" />
                            KHS
                        </div>
                    </x-slot>

                    @if($khs)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium mb-2">Status:</p>
                            @if(strtolower($khs->status_validasi) === 'tervalidasi')
                                <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                            @elseif(strtolower($khs->status_validasi) === 'revisi')
                                <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                            @else
                                <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                            @endif
                        </div>

                        <div>
                            <x-filament::button 
                                tag="a" 
                                href="{{ Storage::url($khs->file_path) }}" 
                                target="_blank"
                                size="sm"
                            >
                                Lihat File
                            </x-filament::button>
                        </div>

                        <div class="flex gap-2">
                            <x-filament::button 
                                wire:click="validateDocument('khs', {{ $khs->id }}, 'belum_valid')"
                                color="gray"
                                size="sm"
                            >
                                Belum Valid
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('khs', {{ $khs->id }}, 'revisi')"
                                color="warning"
                                size="sm"
                            >
                                Perlu Revisi
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('khs', {{ $khs->id }}, 'tervalidasi')"
                                color="success"
                                size="sm"
                            >
                                Setujui
                            </x-filament::button>
                        </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Belum ada KHS yang diunggah.</p>
                    @endif
                </x-filament::section>

                {{-- Surat Balasan --}}
                <x-filament::section class="mb-6">
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-envelope class="w-5 h-5" />
                            Surat Balasan Mitra
                        </div>
                    </x-slot>

                    @if($surat)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium mb-2">Status:</p>
                            @if(strtolower($surat->status_validasi) === 'tervalidasi')
                                <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                            @elseif(strtolower($surat->status_validasi) === 'revisi')
                                <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                            @else
                                <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Mitra:</p>
                            <p class="font-medium">{{ $surat->mitra_id ? \App\Models\Mitra::find($surat->mitra_id)?->nama : $surat->mitra_nama_custom }}</p>
                        </div>

                        <div>
                            <x-filament::button 
                                tag="a" 
                                href="{{ Storage::url($surat->file_path) }}" 
                                target="_blank"
                                size="sm"
                            >
                                Lihat File
                            </x-filament::button>
                        </div>

                        <div class="flex gap-2">
                            <x-filament::button 
                                wire:click="validateDocument('surat', {{ $surat->id }}, 'belum_valid')"
                                color="gray"
                                size="sm"
                            >
                                Belum Valid
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('surat', {{ $surat->id }}, 'revisi')"
                                color="warning"
                                size="sm"
                            >
                                Perlu Revisi
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('surat', {{ $surat->id }}, 'tervalidasi')"
                                color="success"
                                size="sm"
                            >
                                Setujui
                            </x-filament::button>
                        </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Belum ada Surat Balasan yang diunggah.</p>
                    @endif
                </x-filament::section>

                {{-- Laporan PKL --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-clipboard-document-check class="w-5 h-5" />
                            Laporan PKL
                        </div>
                    </x-slot>

                    @if($laporan)
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium mb-2">Status:</p>
                            @if(strtolower($laporan->status_validasi) === 'tervalidasi')
                                <x-filament::badge color="success">Tervalidasi</x-filament::badge>
                            @elseif(strtolower($laporan->status_validasi) === 'revisi')
                                <x-filament::badge color="danger">Perlu Revisi</x-filament::badge>
                            @else
                                <x-filament::badge color="warning">Menunggu Validasi</x-filament::badge>
                            @endif
                        </div>

                        <div>
                            <x-filament::button 
                                tag="a" 
                                href="{{ Storage::url($laporan->file_path) }}" 
                                target="_blank"
                                size="sm"
                            >
                                Lihat File
                            </x-filament::button>
                        </div>

                        <div class="flex gap-2">
                            <x-filament::button 
                                wire:click="validateDocument('laporan', {{ $laporan->id }}, 'belum_valid')"
                                color="gray"
                                size="sm"
                            >
                                Belum Valid
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('laporan', {{ $laporan->id }}, 'revisi')"
                                color="warning"
                                size="sm"
                            >
                                Perlu Revisi
                            </x-filament::button>
                            <x-filament::button 
                                wire:click="validateDocument('laporan', {{ $laporan->id }}, 'tervalidasi')"
                                color="success"
                                size="sm"
                            >
                                Setujui
                            </x-filament::button>
                        </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">Belum ada Laporan PKL yang diunggah.</p>
                    @endif
                </x-filament::section>

            @else
                <x-filament::section>
                    <div class="text-center py-12">
                        <x-heroicon-o-user-group class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                        <p class="text-gray-500">Pilih mahasiswa untuk melihat detail dan memvalidasi berkas</p>
                    </div>
                </x-filament::section>
            @endif
        </div>
    </div>
</x-filament-panels::page>

