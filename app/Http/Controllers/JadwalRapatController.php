<?php

namespace App\Http\Controllers;

use App\Models\MeetingMaterial;
use App\Models\MeetingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Exports\BahanRapatExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RevisionDecree;

class JadwalRapatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('meeting_schedules')
            ->join('meeting_materials','meeting_schedules.id','=','meeting_materials.id_meeting_schedule')
            ->select('meeting_schedules.id','meeting_schedules.tanggal_rapat','meeting_schedules.pic_rapat','meeting_schedules.created_at',
            'meeting_schedules.status_pembahasan')
            ->selectRaw('COUNT(DISTINCT(meeting_materials.nmr_sni_lama)) AS jumlah_sni_lama')
            ->groupBy('meeting_schedules.tanggal_rapat')
            ->get();

            return DataTables::of($data)
            ->addColumn('aksi', function($data){
                $button = '<button type="button" name="hapus" id="'.$data->id.'" class="hapus btn btn-danger btn-sm '.($data->status_pembahasan == 1 ? 'disabled' : '').'" title="hapus"><i class="fa fa-trash"></i></button>';
                
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }

        $data_pic = DB::table('users')->select('id','name')
        ->where('level','!=',0)->orderBy('name')->get();

        return view('jadwal-rapat', compact('data_pic'));
    }

    public function modalSNILama()
    {
        $data_sni_lama = DB::table('revision_decrees')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('old_standards.id','old_standards.nmr_sni_lama','old_standards.jdl_sni_lama','identifications.komtek')
        ->selectRaw('COUNT(CASE WHEN (standard_implementers.penerap = "-") THEN NULL ELSE 1 END) AS jumlah_penerap')
        ->where('revision_decrees.sifat_sni','=',1)
        ->orderBy('revision_decrees.id')
        ->whereNotIn('old_standards.nmr_sni_lama', DB::table('meeting_materials')->select('nmr_sni_lama'))
        ->groupBy('old_standards.id')
        ->get();

        return response()->json([
            'data_sni_lama' => $data_sni_lama,
        ]);
    }

    public function penerapModalSNILama($id)
    {
        $data_penerap = DB::table('standard_implementers')
        ->join('identifications','standard_implementers.id_identifikasi','=','identifications.id')
        ->join('revision_decrees','identifications.id_sk_revisi','=','revision_decrees.id')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->select('standard_implementers.penerap')
        ->where('old_standards.id','=',$id)
        ->get();

        return response()->json([
            'data_penerap' => $data_penerap,
        ]);
    }

    public function tambahSNILama($id)
    {
        $tambah_sni_lama = DB::table('old_standards')
        ->select('id','nmr_sni_lama','jdl_sni_lama')
        ->where('old_standards.id','=',$id)
        ->first();

        return response()->json([
            'tambah_sni_lama' => $tambah_sni_lama,
        ]);
    }

    public function simpanJadwalRapat(Request $request)
    {
        $data = $request->all();

        // dd($data);

        //Simpan data jadwal rapat
        $data_jadwal = new MeetingSchedule();
        $data_jadwal->pic_rapat = $data['pic_rapat'];
        $data_jadwal->tanggal_rapat = $data['tanggal_rapat'];
        $data_jadwal->status_pembahasan = $data['status_pembahasan'];
        $data_jadwal->status_nodin = $data['status_nodin'];
        $data_jadwal->save();

        //Simpan data SNI lama
        $nmr_sni_lama = $request->get('nmr_sni_lama');
        foreach($nmr_sni_lama as $item => $value) {
            $data_sni_lama = array(
                'id_meeting_schedule'   => $data_jadwal->id,
                'nmr_sni_lama'          => $data['nmr_sni_lama'][$item],
                'jdl_sni_lama'          => $data['jdl_sni_lama'][$item],
                'status_nodin'          => 0,
            );
            MeetingMaterial::insert($data_sni_lama);
        }

        //Update data status bahan rapat
        $status = $request->get('id_sk_revisi');
        foreach($status as $item => $value) {
            RevisionDecree::where('id',$data['id_sk_revisi'][$item])->update([
                'status_bahan_rapat' => 1,
            ]);
        }

        return response()->json([]);
    }

    public function lihatDetailJadwalRapat($id)
    {
        $detail_jadwal_rapat = DB::table('meeting_schedules')
        ->join('meeting_materials','meeting_schedules.id','=','meeting_materials.id_meeting_schedule')
        ->select('meeting_schedules.id','meeting_schedules.pic_rapat','meeting_schedules.tanggal_rapat')
        ->selectRaw('COUNT(DISTINCT(meeting_materials.nmr_sni_lama)) AS jumlah_sni_lama')
        ->where('meeting_schedules.id','=',$id)
        ->groupBy('meeting_schedules.id')
        ->first();

        $sni_lama = DB::table('meeting_materials')
        ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('meeting_materials.id','meeting_materials.nmr_sni_lama','identifications.komtek',
        'identifications.sekretariat_komtek','standard_implementers.penerap','revision_decrees.nmr_sni_baru')
        ->where('id_meeting_schedule','=',$id)
        ->get();

        return response()->json([
            'detail_jadwal_rapat' => $detail_jadwal_rapat,
            'sni_lama' => $sni_lama,
        ]);
    }

    public function export(Request $request)
    {
        $tanggal_rapat = MeetingSchedule::where('id',$request->id)->first();

        return Excel::download(new BahanRapatExport($request->id), 'bahan_rapat_'.$tanggal_rapat->tanggal_rapat.'.xlsx');
    }

    public function modalKonfirmasiHapusJadwalRapat($id)
    {
        $data = MeetingSchedule::find($id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function hapusJadwalRapat($id)
    {
        $status_bahan_rapat = DB::table('revision_decrees')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->join('meeting_materials','old_standards.nmr_sni_lama','=','meeting_materials.nmr_sni_lama')
        ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
        ->select('revision_decrees.id','revision_decrees.status_bahan_rapat')
        ->where('meeting_schedules.id','=',$id)
        ->get();

        // dd($status_bahan_rapat);

         
        foreach($status_bahan_rapat as $item) {
            RevisionDecree::where('id','=',$item->id)
            ->update([
                'status_bahan_rapat' => 0,
            ]);
        }

        $data = MeetingSchedule::find($id);
        $data->delete();

        return response()->json([]);
    }
}
