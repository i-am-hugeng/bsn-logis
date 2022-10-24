<?php

namespace App\Http\Controllers;

use App\Models\MeetingMaterial;
use App\Models\MeetingSchedule;
use App\Models\OfficialMemo;
use App\Models\OfficialMemoHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NotaDinasController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('official_memos')
            ->join('meeting_schedules','official_memos.id_meeting_schedule','=','meeting_schedules.id')
            ->join('official_memo_histories','official_memos.id','=','official_memo_histories.id_official_memo')
            ->select('official_memos.id','official_memos.nmr_surat','meeting_schedules.tanggal_rapat','official_memos.jenis_nodin',
            'official_memos.nmr_kepka','official_memos.created_at')
            ->selectRaw('MAX(official_memo_histories.status_nodin) AS status_nodin_update')
            ->groupBy('official_memos.id')
            ->orderBy('official_memos.created_at','desc')
            ->get();

            return DataTables::of($data)
            ->addColumn('aksi', function($data){
                $button = '<button type="button" name="hapus" id="'.$data->id.'" class="hapus btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash"></i></button>';
                
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('nota-dinas');
    }

    public function pilihanTanggalRapat()
    {
        $pilihan = DB::table('meeting_schedules')
        ->join('meeting_materials','meeting_schedules.id','=','meeting_materials.id_meeting_schedule')
        ->select('meeting_schedules.id','meeting_schedules.tanggal_rapat')
        ->selectRaw('COUNT(CASE WHEN meeting_materials.status_sni_lama = 0 THEN 1 END) AS jumlah_pencabutan')
        ->selectRaw('COUNT(CASE WHEN meeting_materials.status_sni_lama = 1 THEN 1 END) AS jumlah_transisi')
        ->groupBy('meeting_schedules.tanggal_rapat')
        ->where('meeting_materials.status_nodin','=',0)
        ->where('meeting_schedules.status_pembahasan','=',1)
        ->where('meeting_schedules.status_nodin','=',0)
        ->get();

        return response()->json([
            'pilihan' => $pilihan,
        ]);
    }

    public function datapencabutan($id)
    {
        $data = DB::table('meeting_schedules')
        ->join('meeting_materials','meeting_schedules.id','=','meeting_materials.id_meeting_schedule')
        ->select('meeting_materials.nmr_sni_lama','meeting_materials.jdl_sni_lama')
        ->where('meeting_materials.status_sni_lama','=',0)
        ->where('meeting_materials.status_nodin','=',0)
        ->where('meeting_schedules.id','=',$id)
        ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function dataTransisi($id)
    {
        $data = DB::table('meeting_schedules')
        ->join('meeting_materials','meeting_schedules.id','=','meeting_materials.id_meeting_schedule')
        ->select('meeting_materials.nmr_sni_lama','meeting_materials.jdl_sni_lama')
        ->where('meeting_materials.status_sni_lama','=',1)
        ->where('meeting_materials.status_nodin','=',0)
        ->where('meeting_schedules.id','=',$id)
        ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // dd($data);

        //simpan data nota dinas
        $data_nodin = new OfficialMemo();
        $data_nodin->id_meeting_schedule = $data['tanggal_rapat'];
        $data_nodin->nmr_surat = $data['nmr_surat'];
        $data_nodin->jenis_nodin = $data['jenis_nodin'];
        $data_nodin->save();

        //simpan data status proses nota dinas
        $data_status_proses_nodin = new OfficialMemoHistory();
        $data_status_proses_nodin->id_official_memo = $data_nodin->id;
        $data_status_proses_nodin->status_nodin = $data['status_nodin'];
        $data_status_proses_nodin->save();

        //update status nodin pada tabel meeting_materials
        MeetingMaterial::where('id_meeting_schedule','=',$data['tanggal_rapat'])
        ->where('status_sni_lama','=',$data['jenis_nodin'])
        ->update([
            'status_nodin' => 1,
        ]);

        //cek jumlah SNI pencabutan dan transisi yang belum dimasukkan dalam nodin
        //jika hasil count = 0, maka nilai status_nodin pada tabel meeting_schedules diupdate menjadi '1'
        $sni = MeetingMaterial::where('id_meeting_schedule','=',$data['tanggal_rapat'])
        ->where('status_nodin','=',0)->get();
        if($sni->count() == 0)
        {
            MeetingSchedule::where('id','=',$data['tanggal_rapat'])
            ->update([
                'status_nodin' => 1,
            ]);
        }

        return response()->json([]);
    }

    public function modalKonfirmasiHapusNotaDinas($id)
    {
        $data = OfficialMemo::find($id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function hapusNotaDinas($id)
    {
        $status_nodin = DB::table('meeting_materials')
        ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
        ->join('official_memos','meeting_schedules.id','=','official_memos.id_meeting_schedule')
        ->select('meeting_materials.id AS id_bahan_rapat','meeting_schedules.id','official_memos.jenis_nodin')
        ->where('official_memos.id','=',$id)
        ->where('meeting_materials.status_nodin','=',1)
        ->get();

        // dd($status_nodin->count());

        //update status_nodin pada tabel meeting_materials 
        foreach($status_nodin as $item) {
            MeetingMaterial::where('id','=',$item->id_bahan_rapat)
            ->where('status_sni_lama','=',$item->jenis_nodin)
            ->update([
                'status_nodin' => 0,
            ]);
        }

        foreach($status_nodin as $item) {
            MeetingSchedule::where('id','=',$item->id)
            ->update([
                'status_nodin' => 0,
            ]);
        }

        $data = OfficialMemo::find($id);
        $data->delete();

        return response()->json([]);
    }

    public function modalUpdateNotaDinas($id)
    {
        $judul_modal = OfficialMemo::where('id','=',$id)->first();

        $tahap_nodin = DB::table('official_memos')
        ->join('official_memo_histories','official_memos.id','=','official_memo_histories.id_official_memo')
        ->select('official_memo_histories.status_nodin','official_memo_histories.created_at')
        ->where('official_memo_histories.id_official_memo','=',$id)
        ->get();

        return response()->json([
            'judul_modal' => $judul_modal,
            'tahap_nodin' => $tahap_nodin,
        ]);
    }

    public function updateNotaDinas($id, Request $request)
    {
        $data = $request->all();

        if($request->has('nmr_kepka'))
        {
            OfficialMemo::where('id','=',$id)
            ->update([
                'nmr_kepka' => $data['nmr_kepka'],
            ]);
        }

        $tahap_nodin = new OfficialMemoHistory();
        $tahap_nodin->id_official_memo = $data['id_nodin'];
        $tahap_nodin->status_nodin = $data['centang'];
        $tahap_nodin->save();

        return response()->json([]);
    }
}
