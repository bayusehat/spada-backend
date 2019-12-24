<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    public $timestamps = false;
    protected $table = 'testimonis';
    protected $primaryKey = 'testimoniId';
    protected $fillable = [
        'testimoniName',
        'testimoniWork',
        'testimoniContent',
        'testimoniStatus',
        'testimoniCreate',
        'testimoniUpdate',
        'testimoniDelete'
    ];

}
