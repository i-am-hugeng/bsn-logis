<?php

namespace App\Http\Controllers;

use App\Models\MeetingMaterial;
use App\Models\OldStandard;
use Illuminate\Http\Request;
use App\Models\RevisionDecree;
use App\Models\TransitionTime;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sni_wajib = DB::table('old_standards')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->select('old_standards.nmr_sni_lama')
        ->where('revision_decrees.sifat_sni','=',0)->count();
        $sni_sukarela = DB::table('old_standards')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->select('old_standards.nmr_sni_lama')
        ->where('revision_decrees.sifat_sni','=',1)->count();
        $sk_total = OldStandard::count();

        $teridentifikasi = RevisionDecree::where('status_proses_pic','=',1)->count();
        $belum_teridentifikasi = RevisionDecree::where('status_proses_pic','=',0)->count();

        $list_pic = DB::table('revision_decrees')->select('pic')
        ->selectRaw('COUNT(CASE WHEN status_proses_pic = 0 THEN 1 END) AS belum_teridentifikasi')
        ->selectRaw('COUNT(CASE WHEN status_proses_pic = 1 THEN 1 END) AS teridentifikasi')
        ->groupBy('pic')->get();

        $belum_dibahas = DB::table('old_standards')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->whereNotIn('old_standards.nmr_sni_lama', DB::table('meeting_materials')->select('nmr_sni_lama'))
        ->where('revision_decrees.sifat_sni','=',1)
        ->count();
        $sudah_dibahas = DB::table('old_standards')
        ->whereIn('old_standards.nmr_sni_lama', DB::table('meeting_materials')->select('nmr_sni_lama')->whereRaw('status_sni_lama IS NOT NULL'))
        ->count();

        $pencabutan = MeetingMaterial::where('status_sni_lama','=',0)->count();
        $transisi = MeetingMaterial::where('status_sni_lama','=',1)->count();

        return view('dashboard', compact([
            'sni_wajib', 'sni_sukarela', 'sk_total',
            'teridentifikasi', 'belum_teridentifikasi',
            'list_pic',
            'pencabutan', 'transisi',
            'belum_dibahas', 'sudah_dibahas',
        ]));
    }

    public function masaTransisiSNI(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('meeting_materials')
            ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
            ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
            ->join('revision_decrees','revision_decrees.id','=','old_standards.id_sk_revisi')
            ->join('transition_times','meeting_materials.id','=','transition_times.id_sni_lama')
            ->leftJoin('official_memos','meeting_schedules.id','=','official_memos.id_meeting_schedule')
            ->select('revision_decrees.nmr_sni_baru','revision_decrees.jdl_sni_baru','meeting_materials.nmr_sni_lama','meeting_materials.jdl_sni_lama','transition_times.batas_transisi',
            'official_memos.nmr_kepka')
            ->where('meeting_materials.status_sni_lama','=',1)
            ->where('official_memos.jenis_nodin','=',1)
            ->orderBy('transition_times.batas_transisi','ASC')
            ->groupBy('meeting_materials.nmr_sni_lama')
            ->get();
            
            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('dashboard');
    }

    public function SNIpencabutan(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('meeting_materials')
            ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
            ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
            ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
            ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
            ->leftJoin('official_memos','meeting_schedules.id','=','official_memos.id_meeting_schedule')
            ->select('meeting_materials.nmr_sni_lama','meeting_materials.jdl_sni_lama','identifications.komtek',
            'official_memos.nmr_kepka','meeting_materials.status_nodin')
            ->where('meeting_materials.status_sni_lama','=',0)
            ->where('official_memos.jenis_nodin','=',0)
            ->orderBy('meeting_materials.nmr_sni_lama','ASC')
            ->groupBy('meeting_materials.nmr_sni_lama')
            ->get();

            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('dashboard');
    }

    public function test()
    {
        $data = TransitionTime::select('batas_transisi')->first();

        return response()->json([
            'data' => $data,
        ]);
    }
}
