<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemberkasanController extends Controller
{
    public function index(Request $request)
    {
        // Dummy user & biodata
        $user = (object)[
            'id' => 123,
            'name' => 'Mahasiswa Contoh',
            'role' => 'mahasiswa',
        ];

        // Dummy biodata profile (nanti ganti Eloquent)
        $mp = [
            'nim' => '23123456',
            'prodi' => 'Teknologi Informasi',
            'semester' => 3,
            'ipk' => 3.12,
            'cek_min_semester' => 1,
            'cek_ipk_nilaisks' => 1,
            'cek_valid_biodata' => 1,
        ];

        // Helper biodata lengkap
        $biodataLengkap = function (?array $mp): bool {
            if (!$mp) return false;
            $required_ok = !empty($mp['nim']) && !empty($mp['prodi']) && (int)$mp['semester'] > 0 && $mp['ipk'] !== null && $mp['ipk'] !== '';
            $checks_ok = (int)$mp['cek_min_semester'] === 1 && (int)$mp['cek_ipk_nilaisks'] === 1 && (int)$mp['cek_valid_biodata'] === 1;
            return $required_ok && $checks_ok;
        };

        // Dummy status dokumen (nanti baca dari DB)
        // null = belum ada, 'menunggu' | 'tervalidasi' | 'revisi'
        $khs   = ['status_validasi' => null,       'file_path' => null];
        $surat = ['status_validasi' => 'menunggu', 'file_path' => '/upload/surat_123.pdf', 'mitra_id' => 2, 'mitra_nama_custom' => null];
        $lap   = ['status_validasi' => 'tervalidasi', 'file_path' => '/upload/lap_123.pdf'];

        $kUp = (bool)$khs['file_path'];
        $sUp = (bool)$surat['file_path'];
        $lUp = (bool)$lap['file_path'];
        $kOk = $kUp && strtolower((string)$khs['status_validasi']) === 'tervalidasi';
        $sOk = $sUp && strtolower((string)$surat['status_validasi']) === 'tervalidasi';
        $lOk = $lUp && strtolower((string)$lap['status_validasi']) === 'tervalidasi';
        $okCount = ($kOk ? 1 : 0) + ($sOk ? 1 : 0) + ($lOk ? 1 : 0);

        // Dummy list mitra
        $mitras = [
            ['id' => 1, 'nama' => 'PT Nusantara Jaya'],
            ['id' => 2, 'nama' => 'CV Teknologi Sejahtera'],
            ['id' => 3, 'nama' => 'UD Kreatif Mandiri'],
        ];

        // Dummy modal konfirmasi pilih mitra (simulasi ?pick_mitra=ID)
        $pickMitraModal = null;
        if ($request->has('pick_mitra')) {
            $pm = (int)$request->query('pick_mitra');
            foreach ($mitras as $m) {
                if ($m['id'] === $pm) { $pickMitraModal = $m; break; }
            }
        }

        return view('pages.pemberkasan', [
        // kirim semua variabel yang dipakai view:
        'user'   => $user,
        'mp'     => $mp,
        'khs'    => $khs,
        'surat'  => $surat,
        'lap'    => $lap,
        'okCount'=> $okCount,
        'mitras' => $mitras,
        'pickMitraModal' => $pickMitraModal,
        'biodataLengkap' => $biodataLengkap($mp),
    ]);
    }
}
