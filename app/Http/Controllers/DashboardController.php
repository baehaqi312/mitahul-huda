<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BarangPeminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = BarangPeminjaman::sum('jumlah');
        $totalDipinjam = BarangPeminjaman::where('status', 'Dipinjam')->sum('jumlah');
        $totalDikembalikan = BarangPeminjaman::where('status', 'Dikembalikan')->sum('jumlah');

        return Inertia::render('Dashboard', [
            'totalBarang' => $totalBarang,
            'totalDipinjam' => $totalDipinjam,
            'totalDikembalikan' => $totalDikembalikan,
        ]);
    }
}
