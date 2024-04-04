<form action="{{ route('products') }}" method="post" style="display: flex; flex-direction: column; align-items: flex-start" enctype="multipart/form-data">
    @csrf
    <h1>Product</h1>
    <label for="product_name">Product Name</label>
    <input type="text" id="product_name" name="title">

    <label for="price">Price</label>
    <input type="number" id="price" name="price">

    <label for="price">Category</label>
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <select name="brand_id">
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}">
                {{ $brand->name }}
            </option>
        @endforeach
    </select>

    <label for="old_price">Old Price</label>
    <input type="number" id="old_price" name="old_price" step="0.01">

    <label for="short_description">Short Description</label>
    <input type="text" id="short_description" name="short_description">

    <label for="description">Description</label>
    <textarea id="description" name="description"></textarea>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity">

    <label for="quantity">Images</label>
    <input type="file" id="images" name="images[]" multiple>


    <button type="submit">Submit</button>
</form>

<form action="{{ route('category') }}" method="post" style="display: flex; flex-direction: column; align-items: flex-start">
    @csrf
    <h1>Create Category</h1>
    <label>Name</label>
    <input type="text" id="category_name" name="name" />
    <button type="submit">Submit</button>
</form>

<form action="{{ route('brand') }}" method="post" style="display: flex; flex-direction: column; align-items: flex-start">
    @csrf
    <h1>Create Brand</h1>
    <label>Name</label>
    <input type="text" id="brand_name" name="name" />
    <button type="submit">Submit</button>
</form>

<h1>Orders</h1>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Order Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <form action="{{ route('admin.order') }}" method="get">
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->created_at }}</td>
                <input type="hidden" name="order_id" value="{{ $order->id }}" />
                <td>
                    <button type="submit">More details</button>
                </td>
            </tr>
            </form>
        @endforeach
    </tbody>
</table>
