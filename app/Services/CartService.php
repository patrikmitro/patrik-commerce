<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    public function get() : array
    {
        $products = session()->pull('cart', []);
        if($products && is_array($products))
        {
            foreach ($products as $productUuid => &$product)
            {
                $isProduct = Product::find($productUuid);

                if($isProduct->quantity == 0)
                {
                    $product['is_available'] = false;
                }

                if($product['quantity'] > $isProduct->quantity)
                {
                    session()->forget('cart');

                    return response([], 505);
                }
            }
        }

        session()->put('cart', $products);

        return $products;
    }

}
