<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Identification;
use App\Models\StandardImplementer;
use App\Models\RevisionDecree;

class IdentifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('identifikasi-sni');
    }

    public function dtIdentifikasi($id, Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('revision_decrees')
            ->Join('users','revision_decrees.pic','=','users.name')
            ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
            ->leftJoin('meeting_materials','old_standards.nmr_sni_lama','=','meeting_materials.nmr_sni_lama')
            ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
            ->select('revision_decrees.id as id_sk_revisi', 'users.id','revision_decrees.nmr_sk_sni','revision_decrees.tanggal_sk',
            'revision_decrees.created_at','identifications.updated_at','revision_decrees.status_proses_pic',
            'revision_decrees.status_bahan_rapat','meeting_materials.status_sni_lama')
            ->where('users.id','=',$id)
            ->orderBy('revision_decrees.created_at','DESC')
            ->get();

            return DataTables::of($data)
            ->addColumn('aksi', function($data){
                $button = '<button type="button" name="identifikasi" id="'.$data->id_sk_revisi.'" class="identifikasi btn btn-warning btn-sm '.($data->status_sni_lama != '' ? 'disabled' : '').'" title="identifikasi/edit" data-toggle="modal" data-target="#modal-identifikasi-edit"><i class="fa fa-pencil"></i></button>';
                            // &nbsp;
                            // <button type="button" name="hapus" id="'.$data->id_sk_revisi.'" class="hapus btn btn-danger btn-sm" title="hapus"><i class="fa fa-trash"></i></button>;
                
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('identifikasi-sni');
    }

    public function kontenSuperAdmin()
    {
        $data_pic = DB::table('users')
        ->select('id','name')
        ->where('level','!=',0)
        ->orderBy('name')->get();

        return response()->json([
            'data_pic' => $data_pic,
        ]);
    }

    public function dtAdmin($id, Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('revision_decrees')
            ->join('users','revision_decrees.pic','=','users.name')
            ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
            ->select('revision_decrees.id','revision_decrees.nmr_sk_sni','revision_decrees.tanggal_sk','revision_decrees.created_at as waktu_disposisi','identifications.created_at as waktu_proses','status_proses_pic','users.id')
            ->where('users.id','=',$id)
            ->orderBy('revision_decrees.created_at','DESC')
            ->get();

            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('identifikasi-sni');
    }

    public function kontenAdmin()
    {
        $data_pic = DB::table('users')
        ->select('id','name')
        ->where('name','=',Auth::user()->name)
        ->first();

        return response()->json([
            'data_pic' => $data_pic,
        ]);
    }

    public function modalIdentifikasiEdit($id)
    {
        $data_sk = DB::table('revision_decrees')
        ->select('revision_decrees.id','revision_decrees.pic','revision_decrees.nmr_sk_sni',
        'revision_decrees.tanggal_sk','revision_decrees.status_proses_pic','revision_decrees.uraian_sk',
        'revision_decrees.nmr_sni_baru','revision_decrees.jdl_sni_baru','revision_decrees.tahun_sni_baru','revision_decrees.sifat_sni')
        ->where('revision_decrees.id','=',$id)
        ->first();

        $data_sni_lama = DB::table('revision_decrees')
        ->join('old_standards','revision_decrees.id','=','old_standards.id_sk_revisi')
        ->select('old_standards.id','old_standards.nmr_sni_lama','old_standards.jdl_sni_lama')
        ->where('old_standards.id_sk_revisi','=',$id)
        ->get();

        $data_identifikasi_komtek = DB::table('revision_decrees')
        ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('identifications.id','identifications.komtek','identifications.sekretariat_komtek')
        ->where('revision_decrees.id','=',$id)
        ->first();

        $data_identifikasi_penerap = DB::table('revision_decrees')
        ->leftJoin('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('standard_implementers.id','standard_implementers.penerap')
        ->where('revision_decrees.id','=',$id)
        ->get();

        return response()->json([
            'data_sk' => $data_sk,
            'data_sni_lama' => $data_sni_lama,
            'data_identifikasi_komtek' => $data_identifikasi_komtek,
            'data_identifikasi_penerap' => $data_identifikasi_penerap,
        ]);
    }

    public function modalKonfirmasiUbahSifatSNI($id)
    {
        // $data = DB::table('identifications')
        // ->join('revision_decrees','identifications.id_sk_revisi','=','revision_decrees')
        // ->select('identifications.id','revision_decrees.sifat_sni')
        // ->where('identifications.id','=',$id)
        // ->first();

        $data = Identification::find($id);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function ubahSifatSNI($id)
    {
        $data = Identification::find($id);
        $data->delete();

        return response()->json([]);
    }

    public function identifikasiEdit(Request $request)
    {
        $data = $request->all();

        // dd($data);

        if($data['sifat_sni'] == 0)
        {
            //update status_proses_pic dan sifat_sni pada table revision_decrees
            RevisionDecree::where('id',$data['id'])->update([
                'status_proses_pic' => 1,
                'sifat_sni' => $data['sifat_sni'],
            ]);
        }
        else
        {
            $cek_komtek = DB::table('revision_decrees')
            ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
            ->select('identifications.id')
            ->where('revision_decrees.id','=',$data['id'])
            ->first();

            if(is_null($cek_komtek)) {
                //simpan data Komite Teknis
                $data_komtek = new Identification();
                $data_komtek->id_sk_revisi = $data['id'];
                $data_komtek->komtek = $data['komtek'];
                $data_komtek->sekretariat_komtek = nl2br($data['sekretariat_komtek']);
                $data_komtek->save();
    
                //simpan data Penerap SNI
                $penerap = $request->get('penerap');
                foreach($penerap as $item => $value) {
                    $data_penerap = new StandardImplementer();
                    $data_penerap->id_identifikasi = $data_komtek->id;
                    $data_penerap->penerap = $data['penerap'][$item];
                    $data_penerap->save();
                }
            }
            else {
                //update data Komite Teknis
                Identification::updateOrCreate(
                    [
                        'id' => $cek_komtek->id,  
                    ],
                    [
                        'id_sk_revisi' => $data['id'],
                        'komtek' => $data['komtek'],
                        'sekretariat_komtek' => $data['sekretariat_komtek'],
                    ]
                );
    
                //update data Penerap SNI
                $penerap = $request->get('penerap');
                foreach($penerap as $item => $value) {
                    if(!empty($data['id_penerap'][$item])) {
                        StandardImplementer::where('id',$data['id_penerap'][$item])
                        ->update([
                            'id_identifikasi' => $data['id_identifikasi'],
                            'penerap' => $data['penerap'][$item],    
                        ]);
                    }
                    else {
                        $data_penerap_baru = new StandardImplementer();
                        $data_penerap_baru->id_identifikasi = $data['id_identifikasi'];
                        $data_penerap_baru->penerap = $data['penerap'][$item];
                        $data_penerap_baru->save();
                    }
                }
            }     
    
            //update sifat_sni pada table revision_decrees
            RevisionDecree::where('id',$data['id'])->update([
                'status_proses_pic' => 1,
                'sifat_sni' => $data['sifat_sni'],
            ]);
        }

        return response()->json([]);
    }

    public function hapusPenerap($id)
    {
        $penerap = StandardImplementer::find($id);
        $penerap->delete();

        return response()->json([]);
    }
}
