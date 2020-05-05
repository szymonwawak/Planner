<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    protected $table = 'teacher';
    public $timestamps = false;
    protected $fillable = [

        'email',
        'name',
        'surname',
        'first_login'
    ];
    protected $hidden = [
        'password',

    ];

    public function subjects()
    {
        return $this->belongsToMany("App\Models\Subject", 'teacher_subject')->withPivot('id');
    }

    public function consultation()
    {
        return $this->hasMany("App\Models\Consultation");
    }
}