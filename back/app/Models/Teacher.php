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
'password'
];

}