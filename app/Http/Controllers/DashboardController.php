<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Dummy user dan progres (tanpa DB)
        $user = (object)[
            'name' => 'Mahasiswa Contoh',
            'role' => 'mahasiswa',
            'photo' => null, // nanti ganti saat sudah ada storage
        ];

        $count = 1; // misal baru upload 1/3 berkas
        $pct   = (int)($count / 3 * 100);

        return view('dashboard.index', compact('user','count','pct'));
    }
}