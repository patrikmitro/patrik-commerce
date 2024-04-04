<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    $categories = Category::all();
    $brands = Brand::all();
    $orders = Order::all();
   return view('admin.admin', compact('categories', 'brands', 'orders'));
})->name('admin');

Route::get('admin/order', function (Request $request) {

    $order = Order::find($request->input('order_id'));

    return view('admin.order', compact('order'));

})->name('admin.order');

Route::post('/products', function (Request $request){

    $data = $request->validate([
       'title' => '',
        'price' => '',
        'old_price' => '',
        'short_description' => '',
        'description' => '',
        'quantity' => '',
        'category_id' => '',
        'brand_id' => '',
        'image' => 'image'
    ]);

    $product = Product::create(array_merge($data, ['slug' => str_slug($request->input('title'))]));

    foreach ($request->file('images') as $image) {

        $path = Storage::disk('public')->put('images', $image);

        $product->images()->create(
            [
                'path' => $path,
                'disk' => 'public'
            ],
            [
                'created_at' => now()
            ]
        );

    }

    return redirect(route('admin'));

})->name('products');

Route::post('/category', function (Request $request){
    Category::create([
        'name' => $request->input('name'),
        'slug' => str_slug($request->input('name'), '-')
    ]);
    return redirect('/admin');
})->name('category');

Route::post('/brand', function (Request $request){
    Brand::create([
        'name' => $request->input('name')
    ]);

    return redirect('/admin');

})->name('brand');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
Route::patch('/cart', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop/{criteria?}', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/add-to-cart/{product}', [\App\Http\Controllers\ProductController::class, 'addToCart'])->name('product.add-to-cart');
Route::get('/{slug}/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'index'])->name('order.index');

Route::post('/order', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
