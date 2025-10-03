<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pemberkasan()
    {
        return view('pages.pemberkasan');
    }

    public function index()
    {
        return view('welcome');
    }

    public function mitra()
    {
        return view('pages.mitra');
    }

    public function pengaturan()
    {
        return view('pengaturan.index');
    }
}
