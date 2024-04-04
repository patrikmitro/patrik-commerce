<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Mail\OrderCreated;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    public function __construct(protected CartService $cartService){}

    public function index()
    {
        $cart = $this->cartService->get();

        if(empty($cart))
        {
            return redirect(route('cart.index'));
        }

        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = $this->cartService->get();

        if(empty($cart))
        {
            return response([], 404);
        }

        $ProductUuids = [];

        foreach ($cart as $productUuid => $product)
        {
            array_push($ProductUuids, $productUuid);
        }

        //$products = Product::whereIn('uuid', $ProductUuids)->get();

        $orderData = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'country' => ['required'],
            'address' => ['required'],
            'accommodation' => ['nullable'],
            'city' => ['required'],
            'zip' => ['required', 'numeric'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'order_notes' => ['nullable', 'max:36'],
        ]);

        $order = Order::create($orderData);


        foreach ($cart as $productId => $product)
        {
            $productInstance = Product::find($productId);

            $order->products()->attach($productInstance, ['quantity' => $product['quantity']]);

            $productInstance->decreaseQuantity($product['quantity']);
        }

        session()->forget('cart');

        Mail::to($orderData['email'])->send(new OrderCreated($order));

        return redirect('/');
    }
}
