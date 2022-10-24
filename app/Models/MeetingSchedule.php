<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'pic_rapat',
        'tanggal_rapat',
        'status_pembahasan',
    ];

    public function meeting_materials()
    {
        return $this->hasMany(MeetingMaterial::class, 'id_meeting_schedule');
    }
}
