<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldStandard extends Model
{
    use HasFactory;

    protected $fillable = [
        'nmr_sni_lama',
        'jdl_sni_lama',
    ];

    public function revision_decrees()
    {
        return $this->belongsTo(RevisionDecree::class, 'id_sk_revisi');
    }
}
