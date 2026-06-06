<?php

namespace App\Http\Controllers;

use App\Services\StockOpnameService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StockOpnameController extends Controller
{
    public function __construct(
        protected StockOpnameService $opnameService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX — Daftar semua sesi opname
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status']);

        $data = $this->opnameService->getIndexData($filters);

        return view('stock-opnames.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — Form buat sesi opname baru
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $data = $this->opnameService->getCreateData();

        return view('stock-opnames.create', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — Simpan sesi opname baru
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'notes'        => 'nullable|string',
            'product_ids'  => 'required|array|min:1',
            'product_ids.*'=> 'exists:products,id',
        ]);

        $this->opnameService->store($request->all());

        return redirect()->route('stock-opnames.index')
                         ->with('success', 'Sesi stock opname berhasil dibuat.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — Detail sesi opname + form input stok fisik
    |--------------------------------------------------------------------------
    */

    public function show(int $id)
    {
        $data = $this->opnameService->getShowData($id);

        return view('stock-opnames.show', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE ITEMS — Simpan hasil hitung stok fisik
    |--------------------------------------------------------------------------
    */

    public function updateItems(Request $request, int $id)
    {
        $request->validate([
            'items'                    => 'required|array',
            'items.*.physical_stock'   => 'required|integer|min:0',
            'items.*.notes'            => 'nullable|string',
        ]);

        try {
            $this->opnameService->updateItems($id, $request->input('items'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()->route('stock-opnames.show', $id)
                         ->with('success', 'Data stok fisik berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE — Selesaikan opname, sesuaikan stok sistem
    |--------------------------------------------------------------------------
    */

    public function complete(int $id)
    {
        try {
            $this->opnameService->complete($id);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return redirect()->route('stock-opnames.index')
                         ->with('success', 'Stock opname selesai. Stok produk telah disesuaikan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — Hapus sesi opname (hanya draft / in_progress)
    |--------------------------------------------------------------------------
    */

    public function destroy(int $id)
    {
        try {
            $this->opnameService->delete($id);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }

        return redirect()->route('stock-opnames.index')
                         ->with('success', 'Sesi opname berhasil dihapus.');
    }
}