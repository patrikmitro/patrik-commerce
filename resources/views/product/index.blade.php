@extends('layouts.master')

@section('content')
    <section class="shop spad">
        <form action="{{ route('product.index', $criteria) }}" method="get" id="form">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                                <input type="text" placeholder="Search..." value="{{ request('keyword') }}" name="keyword" >
                                <button type="submit" style="background: transparent; border: none"><span class="icon_search"></span></button>

                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                <ul class="nice-scroll">
                                                    @foreach($categories as $category)
                                                        <li><a href="#" onclick="selectCategory('{{ $category->slug }}')" style="color: {{ $criteria == $category->slug ? '#0a53be' : null }}"> {{ $category->name }} ({{ $category->products->count() }})</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__brand">
                                                <ul>
                                                    @foreach($brands as $brand)
                                                        <li><a href="#" style="color: #0a53be">{{ $brand->name }} ({{ $brand->products->count() }})</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="#">$0.00 - $50.00</a></li>
                                                    <li><a href="#">$50.00 - $100.00</a></li>
                                                    <li><a href="#">$100.00 - $150.00</a></li>
                                                    <li><a href="#">$150.00 - $200.00</a></li>
                                                    <li><a href="#">$200.00 - $250.00</a></li>
                                                    <li><a href="#">250.00+</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of {{ $products->count() }} results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <input type="radio" name="price" value="asc" id="lowToHigh" {{ request('price') === 'asc' ? 'checked' : '' }} />
                                    <label for="lowToHigh">Low To High</label>

                                    <input type="radio" name="price" value="desc" id="highToLow" {{ request('price') === 'desc' ? 'checked' : '' }} />
                                    <label for="highToLow">High To Low</label>
                                    <!-- <p>Sort by Price:</p> -->
                                    <!--
                                        <select>
                                        <a href="/asdsad">
                                            <option value="">Low To High</option>
                                        </a>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       @foreach($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <a href=" {{ route('product.show', ['slug' => $product->slug, 'product' => $product->uuid]) }}">
                                        <div class="product__item__pic set-bg" data-setbg=" {{ asset('storage/' . $product->images()->first()->path) }}"></div>
                                    </a>
                                    <div class="product__item__text">
                                        <h6>{{$product->title}}</h6>

                                            <a href="{{ route('product.add-to-cart', $product->uuid) }}" class="add-cart">
                                                + Add To Cart
                                            </a>

                                        <h5>{{ $product->price }}</h5>
                                    </div>
                                </div>
                            </div>
                       @endforeach

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product__pagination">
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <span>...</span>
                                <a href="#">21</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form');

            document.querySelectorAll('input[name="price"]').forEach(function(radioButton) {
                radioButton.addEventListener('click', function() {
                    form.submit();
                });
            });
        });

        const routeToProductIndex = "{{ route('product.index', ':category') }}";

        const selectCategory = ( category ) => {
            const form = document.getElementById('form');
            const route = routeToProductIndex.replace(':category', category);
            form.action = route;
            form.submit();
        }
    </script>
@endsection
