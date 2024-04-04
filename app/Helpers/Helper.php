<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class Helper
{
    public static function cartTotal($cart)
    {
        if (!$cart) {
            return 0;
        }

        $cartSum = 0.0;
        foreach ($cart as $productId => $product) {
            $cartSum += $product['price'] * $product['quantity'];
        }
        return $cartSum;
    }

    public static function cartQuantity()
    {

        if (!session('cart')) {
            return 0;
        }
        $quantity = 0;

        $cart = session()->pull('cart', []);

        foreach ($cart as $productId => $cartItem) {
            $quantity += $cartItem['quantity'];
        }

        session()->put('cart', $cart);

        return $quantity;
    }
}
