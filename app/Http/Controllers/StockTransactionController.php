<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\StockTransactionService;
use App\Exports\StockTransactionsExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StockTransactionController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $data = $this->transactionService->getIndexData();

        return view('stock-transactions.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(int $stockTransaction)
    {
        $transaction = $this->transactionService->findById($stockTransaction);

        return view('stock-transactions.show', compact('transaction'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $products = Product::all();

        return view('stock-transactions.create', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out',
            'qty'        => 'required|integer|min:1',
            'note'       => 'nullable|string',
        ]);

        $this->transactionService->store($request->only(['product_id', 'type', 'qty', 'note']));

        return redirect()
            ->route('stock-transactions.index')
            ->with('success', 'Transaksi stock berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM — untuk staff gudang mengkonfirmasi transaksi pending
    |--------------------------------------------------------------------------
    */

    public function confirm(Request $request, int $stockTransaction)
    {
        $this->transactionService->confirm($stockTransaction);

        return redirect()
            ->route('stock-transactions.index')
            ->with('success', 'Transaksi berhasil dikonfirmasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function exportPdf()
    {
        $transactions = $this->transactionService->getAllForExport();

        $pdf = Pdf::loadView('stock-transactions.pdf', compact('transactions'));

        return $pdf->download('stock-transactions.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportExcel()
    {
        return Excel::download(new StockTransactionsExport, 'stock-transactions.xlsx');
    }
}