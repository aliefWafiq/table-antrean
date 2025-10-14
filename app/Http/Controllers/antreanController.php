<?php

namespace App\Http\Controllers;

use App\Models\antreans;
use Illuminate\Http\Request;

class antreanController extends Controller
{
    public function dashboard() {
        $data = antreans::where('statusAmbilAntrean', 'sudah ambil')
                ->whereDate('tanggal_sidang', today())
                ->orderBy('id', 'asc')
                ->get();

        $antreanSekarang = $data->where('status', 'telah di panggil')->first();

        return view('dashboard', compact('data', 'antreanSekarang'));
    }
}
