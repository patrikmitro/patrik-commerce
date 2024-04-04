<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
        'disk',
        'created_at'
    ];

    public function product()
    {
        return $this->belongsToMany(Image::class, 'product_images');
    }
}
