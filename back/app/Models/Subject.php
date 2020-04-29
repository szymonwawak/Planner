<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    protected $table = 'subject';
    public $timestamps = false;
    protected $fillable =[

        'name',
    ];
    protected  $hidden=[
        "pvt"
    ];

    public function teacherSubjects(){

        return $this->hasMany("App\Models\TeacherSubject");
    }

}