<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService){}

    public function index()
    {

        $cartItems = $this->cartService->get();

        return view('cart.index', compact('cartItems'));
    }

    public function destroy(Request $request)
    {
        $products = session()->pull('cart', []);

        unset($products[$request->input('product')]);

        session()->put('cart', $products);

        return redirect(route('cart.index'));
    }

    public function update(Request $request)
    {

        if(session()->get('cart') == null)
        {
            return redirect(route('cart.index'));
        }

        $request->validate([
            'cart.*.quantity' => ['required', 'numeric'],
        ]);

        $products = $this->cartService->get();


        foreach ($request->input('cart') as $productId => $product) {
            if ($product['quantity'] == 0) {
                unset($products[$productId]);
                continue;
            }
            $products[$productId]['quantity'] = $product['quantity'];
        }

        session()->put('cart', $products);

        return redirect(route('cart.index'));
    }
}
