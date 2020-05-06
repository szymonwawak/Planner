<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    protected $table = 'subject';
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];

    public function teachers()
    {
        return $this->belongsToMany("App\Models\Teacher", 'teacher_subject');
    }

    public function teacherSubjects()
    {
        return $this->hasMany("App\Models\TeacherSubject");
    }

    public function studentConsultations()
    {
        return $this->hasMany("App\Models\StudentConsultation");
    }
}