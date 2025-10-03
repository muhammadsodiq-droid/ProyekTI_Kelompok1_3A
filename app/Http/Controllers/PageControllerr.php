<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pemberkasan() { return view('pages.pemberkasan'); }
    public function mitra()       { return view('pages.mitra'); }
    public function profile()     { return view('pages.profile'); }
    public function settings()    { return view('pages.settings'); }
}