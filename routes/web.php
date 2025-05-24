<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::redirect('/dashboard', '/');

Route::middleware([
    'verified',
])->group(function () {

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

Route::get('/', function () {
    $usedCategoryIds = [];

    $categoriesWithMostChildren = Category::withCount('children')
        ->with('children')
        ->has('children', '>', 0)
        ->orderByDesc('children_count')
        ->get()
        ->filter(function ($cat) use (&$usedCategoryIds) {
            if (in_array($cat->id, $usedCategoryIds)) return false;
            $usedCategoryIds[] = $cat->id;
            return true;
        })
        ->take(5)
        ->map(fn($cat) => [
            'type' => 'subcategories',
            'title' => $cat->name,
            'items' => $cat->children
                ->filter(fn($child) => $child->image_path)
                ->map(fn($child) => [
                    'name' => $child->name,
                    'src' => Storage::url($child->image_path),
                    'link' => route('category', $child),
                ])
                ->values()
        ])
        ->filter(fn($carrosel) => $carrosel['items']->isNotEmpty());

    $categoriesWithMostProducts = Category::withCount('products')
        ->with(['products.variations' => fn($q) => $q->orderBy('id')])
        ->has('products', '>', 0)
        ->orderByDesc('products_count')
        ->get()
        ->filter(function ($cat) use (&$usedCategoryIds) {
            if (in_array($cat->id, $usedCategoryIds)) return false;
            $usedCategoryIds[] = $cat->id;
            return true;
        })
        ->take(5)
        ->map(fn($cat) => [
            'type' => 'products',
            'title' => $cat->name,
            'items' => $cat->products
                ->filter(fn($prod) => $prod->variations->isNotEmpty())
                ->map(fn($prod) => [
                    'name' => $prod->name,
                    'price' => $prod->price,
                    'src' => $prod->variations->first()?->image_path
                        ? Storage::url($prod->variations->first()->image_path)
                        : null,
                    'link' => route('product', $prod),
                ])
                ->filter(fn($item) => $item['src'])
                ->values()
        ])
        ->filter(fn($carrosel) => $carrosel['items']->isNotEmpty());

    $carousels = $categoriesWithMostChildren
        ->concat($categoriesWithMostProducts)
        ->shuffle()
        ->values();

    $randomProducts = Product::with(['variations' => fn($q) => $q->orderBy('id')])
        ->inRandomOrder()
        ->take(10)
        ->get()
        ->filter(fn($prod) => $prod->variations->isNotEmpty())
        ->map(fn($prod) => [
            'name' => $prod->name,
            'price' => $prod->price,
            'link' => route('product', $prod),
            'image' => $prod->variations->first()?->image_path
                ? Storage::url($prod->variations->first()->image_path)
                : null,
        ])
        ->filter(fn($item) => $item['image'])
        ->values();

    return inertia('Home', [
        'carousels' => $carousels,
        'products' => $randomProducts,
    ]);
})->name('home');

Route::get('/category/{category}', function (Category $category, Request $request) {
    $sort = $request->get('sort');

    $query = $category->products()->with(['variations' => function ($q) {
        $q->orderBy('id');
    }]);

    if ($sort === 'menor') {
        $query->orderBy('price', 'asc');
    } elseif ($sort === 'maior') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    $products = $query->paginate(20)->withQueryString();

    return inertia('Category', [
        'category' => $category->only('id', 'name', 'banner'),
        'products' => $products->through(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => optional($product->variations->first())->image_path
                    ? asset('storage/' . $product->variations->first()->image_path)
                    : null,
                'link' => route('product', $product->id),
            ];
        }),
    ]);
})->name('category');

Route::get('/product/{product}', function (Product $product) {
    $product->load(['variations' => function ($q) {
        $q->orderBy('id');
    }]);

    return Inertia::render('Product', [
        'product' => $product
    ]);
})->name('product');

Route::get('/search', function (Request $request) {
    $searchQuery = $request->get('query');

    $products = Product::where('name', 'like', '%' . $searchQuery . '%')
        ->orWhereHas('variations', function ($q) use ($searchQuery) {
            $q->where('name', 'like', '%' . $searchQuery . '%');
        })
        ->get();

    return response()->json($products);
})->name('search');


require __DIR__ . '/auth.php';
