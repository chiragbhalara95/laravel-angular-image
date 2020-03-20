<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    protected $table ="tbl_slider";

    protected $fillable = [
        'name',
        'img_path',
    ];

    protected $casts = [
    ];

}
