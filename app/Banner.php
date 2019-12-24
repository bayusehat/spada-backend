<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public $timestamps = false;
    protected $table = 'banners';
    protected $primaryKey = 'bannerId';
    protected $fillable = [
        'bannerTitle',
        'bannerImage',
        'bannerDescription'
    ];
}
