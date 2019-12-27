<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = 'admins';
    protected $primaryKey = 'adminId';
    protected $fillable = [
        'adminName',
        'adminUsername',
        'adminPassword',
        'adminCreate',
        'adminUpdate',
        'adminDelete'
    ];
}
