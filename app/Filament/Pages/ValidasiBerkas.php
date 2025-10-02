<?php

namespace App\Filament\Pages;

use App\Models\MahasiswaProfile;
use App\Models\Khs;
use App\Models\SuratBalasan;
use App\Models\LaporanPkl;
use App\Models\ActivityLog;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ValidasiBerkas extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.pages.validasi-berkas';

    protected static ?string $navigationGroup = 'Kelola PKL';

    protected static ?string $navigationLabel = 'Validasi Berkas';

    protected static ?int $navigationSort = 11;

    public ?int $selectedMahasiswa = null;
    public ?string $searchQuery = '';
    public ?string $sortBy = 'name_asc';

    public static function canAccess(): bool
    {
        return Auth::user()?->isDospem() ?? false;
    }

    public function mount(): void
    {
        if (request()->has('m')) {
            $this->selectedMahasiswa = (int) request('m');
        }
    }

    public function selectMahasiswa(int $mahasiswaId): void
    {
        $this->selectedMahasiswa = $mahasiswaId;
    }

    public function validateDocument(string $type, int $docId, string $status): void
    {
        $table = match($type) {
            'khs' => 'khs',
            'surat' => 'surat_balasan',
            'laporan' => 'laporan_pkl',
            default => null,
        };

        if (!$table || !$this->selectedMahasiswa) {
            Notification::make()
                ->title('Terjadi kesalahan')
                ->danger()
                ->send();
            return;
        }

        $model = match($type) {
            'khs' => Khs::class,
            'surat' => SuratBalasan::class,
            'laporan' => LaporanPkl::class,
        };

        $document = $model::where('id', $docId)
            ->where('mahasiswa_id', $this->selectedMahasiswa)
            ->first();

        if ($document) {
            $document->status_validasi = $status;
            $document->save();

            ActivityLog::create([
                'actor_user_id' => Auth::id(),
                'mahasiswa_id' => $this->selectedMahasiswa,
                'type' => 'validasi_' . $type,
                'meta' => json_encode(['status' => $status, 'doc_id' => $docId]),
            ]);

            $statusLabel = match($status) {
                'tervalidasi' => 'disetujui',
                'revisi' => 'ditandai perlu revisi',
                default => 'diperbarui',
            };

            Notification::make()
                ->title('Status berkas ' . $statusLabel)
                ->success()
                ->send();
        }
    }

    public function getMahasiswaList()
    {
        $dospemId = Auth::id();
        
        $query = User::query()
            ->join('mahasiswa_profiles', 'users.id', '=', 'mahasiswa_profiles.user_id')
            ->where('mahasiswa_profiles.dospem_id', $dospemId)
            ->where('users.role', 'mahasiswa')
            ->select([
                'users.id',
                'users.name',
                'users.photo',
                'mahasiswa_profiles.nim',
                'mahasiswa_profiles.prodi',
                'mahasiswa_profiles.semester',
            ])
            ->selectRaw('((CASE WHEN EXISTS(SELECT 1 FROM khs k WHERE k.mahasiswa_id=users.id) THEN 1 ELSE 0 END)+(CASE WHEN EXISTS(SELECT 1 FROM surat_balasan s WHERE s.mahasiswa_id=users.id) THEN 1 ELSE 0 END)+(CASE WHEN EXISTS(SELECT 1 FROM laporan_pkl l WHERE l.mahasiswa_id=users.id) THEN 1 ELSE 0 END)) AS progress');

        if ($this->searchQuery) {
            $query->where(function($q) {
                $q->where('users.name', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('mahasiswa_profiles.nim', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('mahasiswa_profiles.prodi', 'like', '%' . $this->searchQuery . '%');
            });
        }

        $orderBy = match($this->sortBy) {
            'name_desc' => ['users.name', 'desc'],
            'nim_asc' => ['mahasiswa_profiles.nim', 'asc'],
            'nim_desc' => ['mahasiswa_profiles.nim', 'desc'],
            'progress_desc' => ['progress', 'desc'],
            'progress_asc' => ['progress', 'asc'],
            default => ['users.name', 'asc'],
        };

        return $query->orderBy($orderBy[0], $orderBy[1])->get();
    }

    public function getSelectedMahasiswaData()
    {
        if (!$this->selectedMahasiswa) {
            return null;
        }

        return User::with('mahasiswaProfile')
            ->find($this->selectedMahasiswa);
    }

    public function getKhs()
    {
        if (!$this->selectedMahasiswa) return null;
        return Khs::where('mahasiswa_id', $this->selectedMahasiswa)->latest()->first();
    }

    public function getSurat()
    {
        if (!$this->selectedMahasiswa) return null;
        return SuratBalasan::where('mahasiswa_id', $this->selectedMahasiswa)->latest()->first();
    }

    public function getLaporan()
    {
        if (!$this->selectedMahasiswa) return null;
        return LaporanPkl::where('mahasiswa_id', $this->selectedMahasiswa)->latest()->first();
    }
}

