<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';
    protected $fillable = [
        'title',
        'price',
        'old_price',
        'short_description',
        'description',
        'quantity',
        'category_id',
        'brand_id',
        'slug',
    ];

    public function scopeFilter($query)
    {
        if(request('price'))
        {
            $query->where('price', '>', $query->price);
        }

        return $query;
    }

    public function decreaseQuantity($quantity) : void
    {

        $this->quantity -= $quantity;

        $this->save();
    }

    public function scopeOrder($query) : void
    {

        if(request('price'))
        {
            $query->orderBy('price', request('price'));
        }

        if(request('keyword'))
        {
            $query->where('title', 'like', '%' . request('keyword') . '%');
        }

    }

    public function scopeRelatedProducts($query)
    {
        return $query->where('category_id', $this->category_id)
            ->where('brand_id', $this->brand_id)
            ->where('uuid', '!=', $this->uuid)
            ->limit(3);
    }

    public function images() : BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'product_images', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
