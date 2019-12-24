<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false;
    protected $table = 'contacts';
    protected $primaryKey = 'contactId';
    protected $fillable = [
        'contactPhone',
        'contactName',
        'contactAddress',
        'contactPostalCode',
        'contactEmail',
        'contactImage',
        'contactCreate',
        'contactUpdate',
        'contactDelete'
    ];
}
