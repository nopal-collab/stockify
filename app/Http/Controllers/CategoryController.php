<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
    ) {}

    public function index(Request $request)
    {
        $categories = $this->categoryService->getIndexData($request->only(['search']));

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        $this->categoryService->store($request->only(['name']));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $this->categoryService->update($category->id, $request->only(['name']));

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category->id);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category berhasil dihapus');
    }
}