<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class ProductController extends Controller
{

    public function show($slug ,Product $product)
    {
        if($slug != $product->slug)
        {
            abort(404);
        }

        $relatedProducts = $product->RelatedProducts()->get();

        return view('product.show', compact('product', 'relatedProducts'));
    }

    public function index($criteria = null)
    {
        $productsQuery = Product::order()->where('quantity', '!=', 0);

        $categories = Category::whereHas('products')->get();
        $brands = Brand::whereHas('products')->get();


        if($criteria)
        {
            $category = $categories->where('slug',  $criteria)->first();
            if($category)
            {
                $productsQuery->where('category_id', $category->id);
            } else
            {
                abort(404);
            }

        }

        $products = $productsQuery->with('brand', 'category')->get();

        return view('product.index', compact('products', 'brands', 'categories', 'criteria'));
    }

    public function addToCart(Product $product)
    {

        $cart = session()->get('cart', []);

        if(isset($cart[$product->uuid])) {
            $cart[$product->uuid]['quantity']++;
        }  else {
            $cart[$product->uuid] = [
                "name" => $product->title,
                "image_path" => $product->images()->first()->path,
                "image_disk" => $product->images()->first()->disk,
                "price" => $product->price,
                "quantity" => 1,
                "is_available" => true,
                "slug" => $product->slug,
            ];
        }

        session()->put('cart', $cart);

        return redirect(route('cart.index'));

    }
}
