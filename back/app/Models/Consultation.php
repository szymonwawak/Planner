<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Consultation extends Model
{
    protected $table = 'consultation_scheme';
    public $timestamps = false;
    protected $fillable = [
        'start_date',
        'start_time',
        'finish_time',
        'end_date',
        'day'
    ];
    protected $hidden = [
        "pvt"
    ];

    public function teacherSubject()
    {
        return $this->belongsTo("App\Models\Teacher");
    }

    public function studentConsultation()
    {

        return $this->hasMany("App\Models\StudentConsultation");
    }

}