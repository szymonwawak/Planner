<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    protected $table = 'consult_student';
    public $timestamps = false;
    protected $fillable = [
        'student_name',
        'student_surname',
        'student_email',
        'start_time',
        'finish_time',
        'accepted'
    ];

}