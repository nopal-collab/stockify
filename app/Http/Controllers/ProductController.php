<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Imports\ProductsImport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'supplier_id', 'category_id']);

        $data = $this->productService->getIndexData($filters);

        $data['products']->appends($request->all());

        return view('products.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW (detail produk — untuk manajer_gudang)
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);

        return view('products.show', compact('product'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $data = $this->productService->getFormData();

        return view('products.create', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name'        => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'min_stock'   => 'required|integer|min:0',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $this->productService->store(
            $request->except(['_token', '_method', 'image']),
            $request->file('image')
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $data = $this->productService->getFormData();

        return view('products.edit', array_merge($data, compact('product')));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name'        => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'min_stock'   => 'required|integer|min:0',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $this->productService->update(
            $product->id,
            $request->except(['_token', '_method', 'image']),
            $request->file('image')
        );

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $this->productService->delete($product->id);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'activity'    => 'Import Excel Product',
            'description' => 'Import data product dari file Excel',
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Import Excel berhasil.');
    }

    /*
    |--------------------------------------------------------------------------
    | MIN STOCK — Halaman pengaturan stok minimum (admin only)
    |--------------------------------------------------------------------------
    */

    public function minStock()
    {
        $data = $this->productService->getMinStockData();

        return view('stock.min-stock', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MIN STOCK — Simpan perubahan stok minimum (admin only)
    |--------------------------------------------------------------------------
    */

    public function updateMinStock(Request $request)
    {
        $request->validate([
            'min_stocks'   => 'required|array',
            'min_stocks.*' => 'required|integer|min:0',
        ]);

        $this->productService->updateMinStock($request->input('min_stocks'));

        return redirect()
            ->route('stock.min-stock')
            ->with('success', 'Stok minimum berhasil diperbarui.');
    }
}