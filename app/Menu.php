<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menus';
    protected $primaryKey = 'menuId';
    protected $fillable = [
        'menuName',
        'menuUrl',
        'menuParent',
        'menuActiveParent',
        'menuActiveUrl',
        'menuIcon',
        'menuCreate',
        'menuUpdate',
        'menuDelete'
    ];
}
