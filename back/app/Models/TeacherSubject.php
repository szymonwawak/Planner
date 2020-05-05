<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TeacherSubject extends Model
{
    protected $table = 'teacher_subject';
    public $timestamps = false;

    protected $hidden = [
        "pvt"
    ];

    public function teacher()
    {
        return $this->belongsTo("App\Models\Teacher");
    }

    public function subject()
    {
        return $this->belongsTo("App\Models\Subject", 'subject_id');
    }

}