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
    protected $hidden=[
        "pvt"
    ];

    public function teacherSubjects(){

        return $this->belongsTo("App\Models\TeacherSubject");
    }
    public function studentConsultations(){

        return $this->hasMany("App\Models\Student");
    }

}