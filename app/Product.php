<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $table = 'products';
    protected $primaryKey = 'productId';
    protected $fillable = [
        'productName',
        'categoryId',
        'productDescription',
        'productImage',
        'productCreate',
        'productUpdate',
        'productDelete'
    ];
}
