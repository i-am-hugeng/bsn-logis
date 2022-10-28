<?php

namespace App\Http\Controllers;

use App\Models\RevisionDecree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifikasi = RevisionDecree::where('status_proses_pic','=',0)
        ->where('pic','=',Auth::user()->name)
        ->count();

        return response()->json([
            'notifikasi' => $notifikasi,
        ]);
    }
}
