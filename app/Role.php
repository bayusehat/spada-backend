<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'roles';
    protected $primaryKey = 'roleId';
    protected $fillable = [
        'roleName',
        'roleCreate',
        'roleUpdate',
        'roleDelete'
    ];
}
