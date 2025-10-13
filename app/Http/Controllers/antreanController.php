<?php

namespace App\Http\Controllers;

use App\Models\antreans;
use Illuminate\Http\Request;

class antreanController extends Controller
{
    public function dashboard() {
        $data = antreans::where('statusAmbilAntrean', 'sudah ambil')->get();

        return view('dashboard', compact('data'));
    }
}
