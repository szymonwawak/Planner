<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TeacherSubject extends Model
{
    protected $table = 'teacher_subject';
    public $timestamps = false;

    protected $hidden=[
        "pvt"
    ];

    public function consultation(){

        return $this->hasMany("App\Models\Consultation");
    }
    public function teachers(){

        return $this->belongsTo("App\Models\Teacher");
    }
    public function subjects(){

        return $this->belongsTo("App\Models\Subject");
    }

}