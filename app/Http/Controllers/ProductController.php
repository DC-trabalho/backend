<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('variations')->latest()->paginate(20);

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'variations' => 'required|array',
            'variations.*.colour' => 'required|string',
            'variations.*.image' => 'required|image',
        ]);

        $product = Product::create([
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        foreach ($request->variations as $variation) {
            $image = $variation['image'];
            $path = $image->store("products/{$product->id}", 'public');

            $product->variations()->create([
                'colour' => $variation['colour'],
                'image_path' => $path,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function show(Product $product)
    {
        $product->load('variations');

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        $product->load('variations');

        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'variations' => 'required|array',
            'variations.*.colour' => 'required|string',
            'variations.*.image' => 'nullable|image',
            'variations.*.id' => 'nullable|exists:variations,id'
        ]);

        $product->update($validated);

        foreach ($validated['variations'] as $data) {
            if (isset($data['id'])) {
                $variation = $product->variations()->where('id', $data['id'])->first();
                if ($variation) {
                    $variation->colour = $data['colour'];

                    if (isset($data['image'])) {
                        $path = $data['image']->store('variations', 'public');
                        $variation->image_path = $path;
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

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        $product->variations()->delete();

        return redirect()->route('products.index')->with('success', 'Produto e suas variações foram removidos com sucesso.');
    }
}
