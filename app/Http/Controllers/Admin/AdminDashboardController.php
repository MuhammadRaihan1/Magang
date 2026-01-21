<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        
        $totalSupervisor = User::where('role', 'supervisor')->count();
        $totalMahasiswa  = User::where('role', 'mahasiswa')->count();

        return view('admin.dashboard', compact('totalSupervisor', 'totalMahasiswa'));
    }
}
