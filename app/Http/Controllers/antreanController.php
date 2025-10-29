<?php

namespace App\Http\Controllers;

use App\Models\antreans;
use App\Models\perkara;
use Illuminate\Http\Request;

class antreanController extends Controller
{
    public function dashboard()
    {
        $data = antreans::where('statusAmbilAntrean', 'sudah ambil')
            ->whereDate('tanggal_sidang', today())
            ->with('perkara')
            ->orderBy('id', 'asc')
            ->get();

        $antreanSekarang = $data->where('status', 'telah di panggil')->first();

        $dataPerkara = $antreanSekarang ? $antreanSekarang->perkara : null;

        return view('dashboard', compact('data', 'antreanSekarang', 'dataPerkara'));
    }
}
