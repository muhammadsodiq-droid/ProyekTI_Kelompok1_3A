<?php

namespace App\Filament\Widgets;

use App\Models\Khs;
use App\Models\SuratBalasan;
use App\Models\LaporanPkl;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class UserDashboardWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user = Auth::user();
        
        if (!$user || !$user->isMahasiswa()) {
            return [];
        }

        $userId = $user->id;

        // Hitung progress berkas
        $hasKhs = Khs::where('mahasiswa_id', $userId)->exists();
        $hasSuratBalasan = SuratBalasan::where('mahasiswa_id', $userId)->exists();
        $hasLaporan = LaporanPkl::where('mahasiswa_id', $userId)->exists();

        $berkasCount = ($hasKhs ? 1 : 0) + ($hasSuratBalasan ? 1 : 0) + ($hasLaporan ? 1 : 0);
        $progress = round(($berkasCount / 3) * 100);

        // Status validasi
        $statusKhs = $hasKhs ? Khs::where('mahasiswa_id', $userId)->latest()->first()->status_validasi ?? 'belum upload' : 'belum upload';
        $statusSurat = $hasSuratBalasan ? SuratBalasan::where('mahasiswa_id', $userId)->latest()->first()->status_validasi ?? 'belum upload' : 'belum upload';
        $statusLaporan = $hasLaporan ? LaporanPkl::where('mahasiswa_id', $userId)->latest()->first()->status_validasi ?? 'belum upload' : 'belum upload';

        return [
            Stat::make('Selamat Datang', $user->name)
                ->description('Role: Mahasiswa')
                ->icon('heroicon-o-user-circle')
                ->color('success'),

            Stat::make('Progress Berkas', $berkasCount . ' dari 3')
                ->description($progress . '% selesai')
                ->icon('heroicon-o-document-text')
                ->color($progress === 100 ? 'success' : ($progress > 0 ? 'warning' : 'danger')),

            Stat::make('Status KHS', ucfirst($statusKhs))
                ->description($hasKhs ? 'File sudah diunggah' : 'Belum mengupload')
                ->icon('heroicon-o-academic-cap')
                ->color($statusKhs === 'tervalidasi' ? 'success' : ($hasKhs ? 'warning' : 'danger')),

            Stat::make('Status Surat Balasan', ucfirst($statusSurat))
                ->description($hasSuratBalasan ? 'File sudah diunggah' : 'Belum mengupload')
                ->icon('heroicon-o-envelope')
                ->color($statusSurat === 'tervalidasi' ? 'success' : ($hasSuratBalasan ? 'warning' : 'danger')),

            Stat::make('Status Laporan PKL', ucfirst($statusLaporan))
                ->description($hasLaporan ? 'File sudah diunggah' : 'Belum mengupload')
                ->icon('heroicon-o-clipboard-document-check')
                ->color($statusLaporan === 'tervalidasi' ? 'success' : ($hasLaporan ? 'warning' : 'danger')),
        ];
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user !== null && $user->isMahasiswa();
    }
}
