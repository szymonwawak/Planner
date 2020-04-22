<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    protected $table = 'consult_student';
    public $timestamps = false;
    protected $fillable = [
        'studentname',
        'studentsurname',
        'studentemail',
        'starttime',
        'finishtime',
        'accepted'
    ];

}