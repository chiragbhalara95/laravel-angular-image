<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryModel extends Model
{
    protected $table ="tbl_inquiry";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'web',
        'message',
        'product_id',
        'city_name',
    ];

    protected $casts = [
    ];}
