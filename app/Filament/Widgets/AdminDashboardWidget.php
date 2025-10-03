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

class AdminDashboardWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user = Auth::user();
        
        if (!$user || !$user->isAdmin()) {
            return [];
        }

        // Hitung statistik
        $totalDospem = User::where('role', 'dospem')->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalMitra = Mitra::count();

        // Hitung berkas yang sudah dikumpulkan
        $berkasKhs = Khs::count();
        $berkasSurat = SuratBalasan::count();
        $berkasLaporan = LaporanPkl::count();
        $totalBerkasDikumpulkan = $berkasKhs + $berkasSurat + $berkasLaporan;
        $totalBerkasExpected = $totalMahasiswa * 3;

        // Hitung mahasiswa yang belum punya dospem
        $mahasiswaBelumDospem = MahasiswaProfile::whereNull('dospem_id')
            ->orWhere('dospem_id', 0)
            ->count();

        return [
            Stat::make('Selamat Datang', $user->name)
                ->description('Role: Administrator / Koordinator')
                ->icon('heroicon-o-shield-check')
                ->color('success'),

            Stat::make('Dosen Pembimbing', $totalDospem)
                ->description('Total dosen pembimbing')
                ->icon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('Mahasiswa', $totalMahasiswa)
                ->description('Total mahasiswa terdaftar')
                ->icon('heroicon-o-users')
                ->color('info'),

            Stat::make('Mitra/Instansi', $totalMitra)
                ->description('Total mitra PKL tersedia')
                ->icon('heroicon-o-building-office')
                ->color('info'),

            Stat::make('Berkas Dikumpulkan', $totalBerkasDikumpulkan . ' dari ' . $totalBerkasExpected)
                ->description('Progress pengumpulan seluruh berkas')
                ->icon('heroicon-o-document-text')
                ->color($totalBerkasDikumpulkan === $totalBerkasExpected ? 'success' : 'warning'),

            Stat::make('Mahasiswa Belum Punya Dospem', $mahasiswaBelumDospem)
                ->description($mahasiswaBelumDospem > 0 ? 'Perlu ditindaklanjuti' : 'Semua sudah memiliki dospem')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($mahasiswaBelumDospem > 0 ? 'danger' : 'success'),
        ];
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user !== null && $user->isAdmin();
    }
}
