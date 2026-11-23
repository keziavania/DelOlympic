<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function adminDashboard()
    {
        $user = Auth::user();
        return view('dashboard.admin', compact('user'));
    }

    /**
     * Dashboard Penyelenggara
     */
    public function penyelenggaraDashboard()
    {
        $user = Auth::user();
        return view('dashboard.penyelenggara', compact('user'));
    }

    /**
     * Dashboard Peserta
     */
    public function pesertaDashboard()
    {
        $user = Auth::user();
        return view('dashboard.peserta', compact('user'));
    }
}
