@extends('layouts.master')


@section('content')
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="{{ route('cart.update') }}" id="cart-form-update"></form>
                            @if(session('cart'))
                                @foreach($cartItems as $productId => $product)
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="{{ asset('storage/' . $product['image_path']) }}" alt="" style="max-width: 90px">
                                            </div>
                                            @if(!$product['is_available'])
                                                Neni uz produkts
                                            @endif
                                            <div class="product__cart__item__text">
                                                <a href="{{ route('product.show', ['slug' => $product['slug'], 'product' => $productId]) }}">
                                                    <h6>{{ $product['name'] }}</h6>
                                                </a>
                                                <h5>${{ $product['price'] }}</h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <div class="quantity">
                                                <div class="pro-qty-2">
                                                    <input type="number"  id="product-quantity" name="cart[{{ $productId }}][quantity]" value="{{ $product['quantity'] }}" form="cart-update-form" readonly max="3">
                                                    <input type="hidden" name="cart[{{ $productId }}][product_id]" value="{{ $productId }}" form="cart-update-form">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart__price">${{ $product['price'] * $product['quantity'] }}</td>
                                        <form action="{{ route('cart.destroy') }}" method="post" id="{{ $productId }}">
                                            @method('DELETE')
                                            @csrf
                                            <td class="cart__close"><i class="fa fa-close" onclick="removeItem('{{ $productId }}')" style="cursor: pointer;"></i></td>
                                            <input name="product" value="{{ $productId }}" type="hidden">
                                        </form>
                                    </tr>

                                    @endforeach
                            @else
                                <tr>
                                    <td colspan="2">
                                        Nesu ziadne vyš jako
                                    </td>
                                </tr>

                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="#">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <form id="cart-update-form" method="post" action="{{ route('cart.update') }}">
                                    @csrf
                                    @method('PATCH')
                                    <button href="#" class="primary-btn" type="submit"><i></i> Update cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>$ 169.50</span></li>
                            <li>Total <span>$ {{ Helper::cartTotal(session('cart')) }}</span></li>
                        </ul>
                        <a href="{{ route('order.index') }}" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        const removeItem = (product) => {
            document.getElementById(product).submit();
        }
    </script>
@endsection
