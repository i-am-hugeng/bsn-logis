<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\RevisionDecree;
use App\Models\OldStandard;


class skPenetapanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('revision_decrees')
            ->select('revision_decrees.id','revision_decrees.nmr_sk_sni','revision_decrees.tanggal_sk','revision_decrees.uraian_sk',
            'revision_decrees.pic','revision_decrees.status_proses_pic','revision_decrees.created_at')
            ->orderBy('revision_decrees.created_at','DESC')
            ->get();

            return DataTables::of($data)
            ->addColumn('aksi', function($data){
                $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-warning btn-sm '.($data->status_proses_pic == 1 ? 'disabled' : '').'" title="edit" data-toggle="modal" data-target="'.($data->status_proses_pic == 1 ? '' : '#modal-edit-sk').'"><i class="fa fa-pencil"></i></button>
                           &nbsp;
                           <button type="button" name="hapus" id="'.$data->id.'" class="hapus btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash"></i></button>';
                
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }

        $data_pic = DB::table('users')->select('id','name')
        ->where('level','!=',0)->orderBy('name')->get();

        return view('skPenetapanSNI', compact('data_pic'));
    }

    public function rekapPetugas(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('revision_decrees')
            ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
            ->select('revision_decrees.pic')
            ->selectRaw('count(case when revision_decrees.status_proses_pic = 0 then 1 end) as belum_terproses')
            ->selectRaw('count(case when revision_decrees.status_proses_pic = 1 then 1 end) as terproses')
            ->selectRaw('count(revision_decrees.status_proses_pic) as total')
            ->groupBy('revision_decrees.pic')->get();

            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('skPenetapanSNI');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // dd($data);

        //simpan data SK Penetapan SNI Revisi
        $data_sk = new RevisionDecree();
        $data_sk -> pic = $data['pic'];
        $data_sk -> tanggal_terima = $data['tanggal_terima'];
        $data_sk -> nmr_sk_sni = $data['nmr_sk_sni'];
        $data_sk -> uraian_sk = nl2br($data['uraian_sk']);
        $data_sk -> tanggal_sk = $data['tanggal_sk'];
        $data_sk -> nmr_sni_baru = $data['nmr_sni_baru'];
        $data_sk -> jdl_sni_baru = $data['jdl_sni_baru'];
        $data_sk -> tahun_sni_baru = $data['tahun_sni_baru'];
        $data_sk -> status_proses_pic = $data['status_proses_pic'];
        $data_sk -> status_proses_pic = $data['status_bahan_rapat'];
        $data_sk -> save();

        //simpan data SNI lama
        $nmr_sni_lama = $request->get('nmr_sni_lama');
        foreach($nmr_sni_lama as $item => $value) {
            $data_sni_lama = array(
                'id_sk_revisi'  => $data_sk->id,
                'nmr_sni_lama'  => $data['nmr_sni_lama'][$item],
                'jdl_sni_lama'  => $data['jdl_sni_lama'][$item],
            );
            OldStandard::insert($data_sni_lama);
        }
        
        return response()->json([]);
    }

    public function lihatDetailSK($id)
    {
        $detail_sk = DB::table('revision_decrees')
        ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->select('revision_decrees.id','revision_decrees.pic','revision_decrees.nmr_sk_sni','revision_decrees.uraian_sk',
        'revision_decrees.tanggal_sk','revision_decrees.tanggal_terima','revision_decrees.nmr_sni_baru','revision_decrees.jdl_sni_baru',
        'revision_decrees.tahun_sni_baru','revision_decrees.sifat_sni','identifications.komtek','identifications.sekretariat_komtek')
        ->where('revision_decrees.id','=',$id)
        ->first();

        $detail_sni_lama = DB::table('revision_decrees')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->select('old_standards.id','old_standards.nmr_sni_lama','old_standards.jdl_sni_lama')
        ->where('revision_decrees.id','=',$id)
        ->get();

        $detail_penerap = DB::table('revision_decrees')
        ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->leftJoin('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('standard_implementers.id','standard_implementers.penerap')
        ->where('revision_decrees.id','=',$id)
        ->get();

        return response()->json([
           'detail_sk' => $detail_sk,
           'detail_sni_lama' => $detail_sni_lama,
           'detail_penerap' => $detail_penerap,
        ]);
    }

    public function modalEdit($id)
    {
        $data_sk = DB::table('revision_decrees')
        ->select('revision_decrees.id','revision_decrees.pic','revision_decrees.nmr_sk_sni',
        'revision_decrees.tanggal_sk','revision_decrees.tanggal_terima','revision_decrees.status_proses_pic','revision_decrees.uraian_sk',
        'revision_decrees.nmr_sni_baru','revision_decrees.jdl_sni_baru','revision_decrees.tahun_sni_baru')
        ->where('revision_decrees.id','=',$id)
        ->first();

        $data_sni_lama = DB::table('revision_decrees')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->select('old_standards.id','old_standards.nmr_sni_lama','old_standards.jdl_sni_lama')
        ->where('old_standards.id_sk_revisi','=',$id)
        ->get();

        return response()->json([
            'data_sk' => $data_sk,
            'data_sni_lama' => $data_sni_lama,
        ]);
    }

    public function editSK(Request $request)
    {
        $data = $request->all();

        //update data SK
        RevisionDecree::where('id',$data['id_sk_edit'])
        ->update([
            'pic' => $data['pic_edit'],
            'tanggal_terima' => $data['tanggal_terima_edit'],
            'nmr_sk_sni' => $data['nmr_sk_sni_edit'],
            'tanggal_sk' => $data['tanggal_sk_edit'],
            'uraian_sk' => $data['uraian_sk_edit'],
            'nmr_sni_baru' => $data['nmr_sni_baru_edit'],
            'jdl_sni_baru' => $data['jdl_sni_baru_edit'],
            'tahun_sni_baru' => $data['tahun_sni_baru_edit'],
        ]);

        //update data SNI lama
        $sni_lama = $request->get('nmr_sni_lama_edit');
        foreach($sni_lama as $item => $value) {
            if(!empty($data['id_sni_lama_edit'][$item])) {
                OldStandard::where('id',$data['id_sni_lama_edit'][$item])
                ->update([
                    'id_sk_revisi' => $data['id_sk_edit'],
                    'nmr_sni_lama' => $data['nmr_sni_lama_edit'][$item],
                    'jdl_sni_lama' => $data['jdl_sni_lama_edit'][$item],
                ]);
            }
            else {
                $sni_lama_baru = new OldStandard();
                $sni_lama_baru->id_sk_revisi = $data['id_sk_edit'];
                $sni_lama_baru->nmr_sni_lama = $data['nmr_sni_lama_edit'][$item];
                $sni_lama_baru->jdl_sni_lama = $data['jdl_sni_lama_edit'][$item];
                $sni_lama_baru->save();
            }
        }

        return response()->json([]);
    }

    public function hapusSNILama($id)
    {
        $sni_lama = OldStandard::find($id);
        $sni_lama->delete();

        return response()->json([]);
    }

    public function modalKonfirmasiHapusSK($id)
    {
        $data = RevisionDecree::find($id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function hapusSK($id)
    {
        $data = RevisionDecree::find($id);
        $data->delete();

        return response()->json([]);
    }
}
