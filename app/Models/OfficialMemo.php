<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialMemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nmr_surat',
        'jenis_nodin',
        'nmr_kepka',
    ];

    public function meeting_schedules()
    {
        return $this->belongsTo(MeetingSchedule::class, 'id_meeting_schedule');
    }

    public function official_memo_histories()
    {
        return $this->hasMany(OfficialMemoHistory::class, 'id_official_memo');
    }
}
