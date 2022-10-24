<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardImplementer extends Model
{
    use HasFactory;

    protected $fillable = [
        'penerap'
    ];
    
    public function identifications()
    {
        return $this->belongsTo(Identification::class, 'id_identifikasi');
    }
}
