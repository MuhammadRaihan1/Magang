<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        return view('mahasiswa.dashboard');
    }
}
 