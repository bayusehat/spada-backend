<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    protected $table = 'services';
    protected $primaryKey = 'serviceId';
    protected $fillable = [
        'serviceName',
        'serviceImage',
        'serviceDescription',
        'serviceCreate',
        'serviceUpdate',
        'serviceDelete'
    ];
}
