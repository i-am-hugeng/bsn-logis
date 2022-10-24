<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransitionTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'batas_transisi'
    ];

    public function meeting_materials()
    {
        return $this->belongsTo(MeetingMaterial::class, 'id_sni_lama');
    }

    public function getRemainingDaysAttribute()
    {

        if ($this->batas_transisi) {
            $remaining_years = Carbon::now()->diffInYears(Carbon::parse($this->batas_transisi));
        } else {
            $remaining_years = 0;
        }
        return $remaining_years;
    }
}
