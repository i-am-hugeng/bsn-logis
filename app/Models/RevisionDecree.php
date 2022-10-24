<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionDecree extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic',
        'nmr_sk_sni',
        'uraian_sk',
        'tanggal_sk',
        'tanggal_terima',
        'nmr_sni_baru',
        'jdl_sni_baru',
        'tahun_sni_baru',
        'status_proses_pic',
        'status_bahan_rapat',
    ];

    public function old_standards()
    {
        return $this->hasMany(OldStandard::class, 'id_sk_revisi');
    }
    
    public function identifications()
    {
        return $this->hasMany(Identification::class, 'id_sk_revisi');
    }
}
