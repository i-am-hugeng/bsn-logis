<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialMemoHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_nodin',
    ];

    public function official_memos()
    {
        return $this->belongsTo(OfficialMemo::class, 'id_official_memo');
    }
}
