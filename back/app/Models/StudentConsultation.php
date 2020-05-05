<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class StudentConsultation extends Model
{
    protected $table = 'student_consultation';
    public $timestamps = false;
    protected $fillable = [
        'student_name',
        'student_surname',
        'student_email',
        'start_time',
        'finish_time',
        'accepted'
    ];


    public function teacher()
    {
        return $this->belongsTo("App\Models\Teacher");
    }

    public function subject()
    {
        return $this->belongsTo("App\Models\Subject");
    }
}