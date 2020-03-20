<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table ="tbl_setting";

    protected $fillable = [
        'Field_name',
        'field_value',
    ];

    protected $casts = [
    ];
}
