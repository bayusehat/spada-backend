<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $timestamps = false;
    protected $table = 'configs';
    protected $primaryKey = 'configId';
    protected $fillable = [
        'configWeName',
        'configTitle',
        'configOfficeHour',
        'configDescription',
        'configCreate',
        'configUpdate',
        'configDelete'
    ];
}
