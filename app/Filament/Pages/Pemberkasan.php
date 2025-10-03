<?php

namespace App\Filament\Pages;

use App\Models\Khs;
use App\Models\SuratBalasan;
use App\Models\LaporanPkl;
use App\Models\Mitra;
use App\Models\ActivityLog;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Pemberkasan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pemberkasan';

    protected static ?string $navigationGroup = 'Kelola PKL';

    protected static ?string $navigationLabel = 'Pemberkasan';

    protected static ?int $navigationSort = 10;

    // Hidden from navigation - use KHS, Surat, Laporan resources instead
    protected static bool $shouldRegisterNavigation = false;

    public ?array $dataKhs = [];
    public ?array $dataSurat = [];
    public ?array $dataLaporan = [];

    public static function canAccess(): bool
    {
        return Auth::user()?->isMahasiswa() ?? false;
    }

    public function mount(): void
    {
        $this->formKhs->fill();
        $this->formSurat->fill();
        $this->formLaporan->fill();
    }

    public function formKhs(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('khs_file')
                    ->label('File KHS (PDF/JPG/PNG)')
                    ->disk('public')
                    ->directory('uploads/khs')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(5120)
                    ->required(),
            ])
            ->statePath('dataKhs');
    }

    public function formSurat(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('mitra_id')
                    ->label('Pilih Mitra/Instansi')
                    ->options(Mitra::pluck('nama', 'id'))
                    ->searchable()
                    ->nullable()
                    ->placeholder('-- Pilih dari daftar (opsional) --'),
                TextInput::make('mitra_custom')
                    ->label('Nama Mitra (Custom)')
                    ->placeholder('Tulis manual jika tidak ada di daftar')
                    ->maxLength(150),
                FileUpload::make('surat_file')
                    ->label('File Surat Balasan (PDF/JPG/PNG)')
                    ->disk('public')
                    ->directory('uploads/surat')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(5120)
                    ->required(),
            ])
            ->statePath('dataSurat');
    }

    public function formLaporan(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('laporan_file')
                    ->label('File Laporan PKL (PDF/JPG/PNG)')
                    ->disk('public')
                    ->directory('uploads/laporan')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(10240)
                    ->required(),
            ])
            ->statePath('dataLaporan');
    }

    public function uploadKhs(): void
    {
        $data = $this->formKhs->getState();
        $userId = Auth::id();

        Khs::create([
            'mahasiswa_id' => $userId,
            'file_path' => $data['khs_file'],
            'status_validasi' => 'menunggu',
        ]);

        ActivityLog::create([
            'actor_user_id' => $userId,
            'mahasiswa_id' => $userId,
            'type' => 'upload_khs',
            'meta' => json_encode(['file' => $data['khs_file']]),
        ]);

        Notification::make()
            ->title('KHS berhasil diunggah')
            ->body('Menunggu validasi dari dosen pembimbing.')
            ->success()
            ->send();

        $this->formKhs->fill();
    }

    public function uploadSurat(): void
    {
        $data = $this->formSurat->getState();
        $userId = Auth::id();

        SuratBalasan::create([
            'mahasiswa_id' => $userId,
            'mitra_id' => $data['mitra_id'] ?? null,
            'mitra_nama_custom' => $data['mitra_custom'] ?? null,
            'file_path' => $data['surat_file'],
            'status_validasi' => 'menunggu',
        ]);

        ActivityLog::create([
            'actor_user_id' => $userId,
            'mahasiswa_id' => $userId,
            'type' => 'upload_surat_balasan',
            'meta' => json_encode(['file' => $data['surat_file']]),
        ]);

        Notification::make()
            ->title('Surat Balasan berhasil diunggah')
            ->body('Menunggu validasi dari dosen pembimbing.')
            ->success()
            ->send();

        $this->formSurat->fill();
    }

    public function uploadLaporan(): void
    {
        $data = $this->formLaporan->getState();
        $userId = Auth::id();

        LaporanPkl::create([
            'mahasiswa_id' => $userId,
            'file_path' => $data['laporan_file'],
            'status_validasi' => 'menunggu',
        ]);

        ActivityLog::create([
            'actor_user_id' => $userId,
            'mahasiswa_id' => $userId,
            'type' => 'upload_laporan',
            'meta' => json_encode(['file' => $data['laporan_file']]),
        ]);

        Notification::make()
            ->title('Laporan PKL berhasil diunggah')
            ->body('Menunggu validasi dari dosen pembimbing.')
            ->success()
            ->send();

        $this->formLaporan->fill();
    }

    public function deleteKhs(): void
    {
        $userId = Auth::id();
        $khs = Khs::where('mahasiswa_id', $userId)->latest()->first();

        if ($khs) {
            Storage::disk('public')->delete($khs->file_path);
            $khs->delete();

            Notification::make()
                ->title('KHS berhasil dihapus')
                ->success()
                ->send();
        }
    }

    public function deleteSurat(): void
    {
        $userId = Auth::id();
        $surat = SuratBalasan::where('mahasiswa_id', $userId)->latest()->first();

        if ($surat) {
            Storage::disk('public')->delete($surat->file_path);
            $surat->delete();

            Notification::make()
                ->title('Surat Balasan berhasil dihapus')
                ->success()
                ->send();
        }
    }

    public function deleteLaporan(): void
    {
        $userId = Auth::id();
        $laporan = LaporanPkl::where('mahasiswa_id', $userId)->latest()->first();

        if ($laporan) {
            Storage::disk('public')->delete($laporan->file_path);
            $laporan->delete();

            Notification::make()
                ->title('Laporan PKL berhasil dihapus')
                ->success()
                ->send();
        }
    }
}

