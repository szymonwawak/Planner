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
    protected $hidden=[
        "pvt"
    ];


    public function consultation(){

        return $this->belongsTo("App\Models\Consultation");
    }

}