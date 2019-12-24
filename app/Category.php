<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $table = 'categories';
    protected $primaryKey = 'categoryId';
    protected $fillable =[
        'categoryName',
        'categoryDescription',
        'categoryCreate',
        'categoryUpdate',
        'categoryDelete'
    ];
}
