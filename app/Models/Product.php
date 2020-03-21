<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'featured',
        'menu',
        'image',
        'category_id',
        'display_product',
    ];

    protected $casts = [
        'parent_id' =>  'integer',
        'featured'  =>  'boolean',
        'menu'      =>  'boolean'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public static function checkProductNameExist($productName, $id = null)
    {
        $isExist = self::where('name', $productName);
        if (!empty($id)) {
            $isExist = $isExist->where('id', '!=', (int)$id);
        }
        $isExist = $isExist->exists();

        return $isExist;
    }

}
