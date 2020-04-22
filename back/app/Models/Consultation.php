<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Consultation extends Model
{
    protected $table = 'consult_scheme';
    public $timestamps = false;
    protected $fillable = [
        'consultdate',
        'starttime',
        'finishtime'
    ];

}