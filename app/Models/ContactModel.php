<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table ="tbl_contact";

    protected $fillable = [
        'name',
        'email',
        'phone',
        //'web',
        'city_name',
        'message',
    ];

    protected $casts = [
    ];
}
