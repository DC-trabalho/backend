<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(10);
        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return Inertia::render('Categories/Create', ['parents' => $parents]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'banner' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('categories', 'public');
        }

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('categories/images', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function show(Category $category)
    {
        $category->load('children');
        return Inertia::render('Categories/Show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category)
    {
        $category->load('children');

        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return Inertia::render('Categories/Edit', [
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->parent_id == $category->id) {
            return back()->withErrors(['parent_id' => 'A categoria não pode ser sua própria pai.']);
        }

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('categories', 'public');
        } else {
            unset($validated['banner']); 
        }

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('categories/images', 'public');
        } else {
            unset($validated['image_path']); 
        }

        $category->update($validated);

        return redirect()->route('categories.show', $category->id);
    }



    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Categoria deletada!');
    }
}
