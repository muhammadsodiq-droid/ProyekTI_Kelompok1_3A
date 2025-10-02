<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\Khs;
use App\Models\SuratBalasan;
use App\Models\LaporanPkl;
use App\Models\Mitra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DospemDashboardWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user = Auth::user();
        
        if (!$user || !$user->isDospem()) {
            return [];
        }

        $dospemId = $user->id;

        // Hitung mahasiswa bimbingan
        $totalMahasiswa = MahasiswaProfile::where('dospem_id', $dospemId)->count();

        // Hitung total mitra
        $totalMitra = Mitra::count();

        // Hitung berkas yang sudah dikumpulkan
        $mahasiswaIds = MahasiswaProfile::where('dospem_id', $dospemId)->pluck('user_id');
        $berkasKhs = Khs::whereIn('mahasiswa_id', $mahasiswaIds)->count();
        $berkasSurat = SuratBalasan::whereIn('mahasiswa_id', $mahasiswaIds)->count();
        $berkasLaporan = LaporanPkl::whereIn('mahasiswa_id', $mahasiswaIds)->count();
        $totalBerkasDikumpulkan = $berkasKhs + $berkasSurat + $berkasLaporan;
        $totalBerkasExpected = $totalMahasiswa * 3;

        // Hitung berkas yang perlu validasi
        $needValidateKhs = Khs::whereIn('mahasiswa_id', $mahasiswaIds)
            ->where('status_validasi', '!=', 'tervalidasi')
            ->count();
        $needValidateSurat = SuratBalasan::whereIn('mahasiswa_id', $mahasiswaIds)
            ->where('status_validasi', '!=', 'tervalidasi')
            ->count();
        $needValidateLaporan = LaporanPkl::whereIn('mahasiswa_id', $mahasiswaIds)
            ->where('status_validasi', '!=', 'tervalidasi')
            ->count();
        $totalNeedValidate = $needValidateKhs + $needValidateSurat + $needValidateLaporan;

        return [
            Stat::make('Selamat Datang', $user->name)
                ->description('Role: Dosen Pembimbing')
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make('Mahasiswa Bimbingan', $totalMahasiswa)
                ->description('Total mahasiswa yang dibimbing')
                ->icon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('Mitra/Instansi', $totalMitra)
                ->description('Total mitra PKL tersedia')
                ->icon('heroicon-o-building-office')
                ->color('info'),

            Stat::make('Berkas Dikumpulkan', $totalBerkasDikumpulkan . ' dari ' . $totalBerkasExpected)
                ->description('Progress pengumpulan berkas')
                ->icon('heroicon-o-document-text')
                ->color($totalBerkasDikumpulkan === $totalBerkasExpected ? 'success' : 'warning'),

            Stat::make('Perlu Validasi', $totalNeedValidate)
                ->description('Berkas menunggu validasi')
                ->icon('heroicon-o-clock')
                ->color($totalNeedValidate > 0 ? 'danger' : 'success'),
        ];
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user !== null && $user->isDospem();
    }
}
