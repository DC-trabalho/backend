<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['variations', 'categories'])->latest()->paginate(20);

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'variations' => 'required|array',
            'variations.*.colour' => 'required|string',
            'variations.*.image' => 'required|image',
        ]);

        $product = Product::create([
            'id' => (string) Str::uuid(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        foreach ($validated['variations'] as $variation) {
            $path = $variation['image']->store("products/{$product->id}", 'public');
            $product->variations()->create([
                'colour' => $variation['colour'],
                'image_path' => $path,
            ]);
        }

        if (!empty($validated['category_ids'])) {
            $product->categories()->sync($validated['category_ids']);
        }

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product)
    {
        $product->load(['variations', 'categories']);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        $product->load(['variations', 'categories']);
        $categories = Category::orderBy('name')->get();

        return Inertia::render('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'variations' => 'required|array',
            'variations.*.colour' => 'required|string',
            'variations.*.image' => 'nullable|image',
            'variations.*.id' => 'nullable|exists:variations,id'
        ]);

        $product->update($validated);

        foreach ($validated['variations'] as $data) {
            if (isset($data['id'])) {
                $variation = $product->variations()->find($data['id']);
                if ($variation) {
                    $variation->colour = $data['colour'];
                    if (isset($data['image'])) {
                        $variation->image_path = $data['image']->store('variations', 'public');
                    }
                    $variation->save();
                }
            } else {
                $path = isset($data['image']) ? $data['image']->store('variations', 'public') : null;
                $product->variations()->create([
                    'colour' => $data['colour'],
                    'image_path' => $path,
                ]);
            }
        }

        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
    {
        $product->categories()->detach(); 
        $product->variations()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto e suas variações foram removidos com sucesso.');
    }
}
