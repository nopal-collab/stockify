<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Services\ProductAttributeService;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function __construct(
        protected ProductAttributeService $attributeService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $data = $this->attributeService->getIndexData(
            $request->only(['search', 'type'])
        );

        $data['attributes']->appends($request->all());

        return view('product-attributes.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('product-attributes.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:product_attributes,name',
            'type'        => 'required|in:text,number,color,select',
            'options'     => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $this->attributeService->store($request->only(['name', 'type', 'options', 'description']));

        return redirect()
            ->route('product-attributes.index')
            ->with('success', 'Atribut produk berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(ProductAttribute $productAttribute)
    {
        return view('product-attributes.edit', compact('productAttribute'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:product_attributes,name,' . $productAttribute->id,
            'type'        => 'required|in:text,number,color,select',
            'options'     => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $this->attributeService->update(
            $productAttribute->id,
            $request->only(['name', 'type', 'options', 'description'])
        );

        return redirect()
            ->route('product-attributes.index')
            ->with('success', 'Atribut produk berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(ProductAttribute $productAttribute)
    {
        $this->attributeService->delete($productAttribute->id);

        return redirect()
            ->route('product-attributes.index')
            ->with('success', 'Atribut produk berhasil dihapus.');
    }
}