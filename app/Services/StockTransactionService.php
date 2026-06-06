<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransactionService
{
    use LogsActivity;

    public function __construct(
        protected StockTransactionRepositoryInterface $transactionRepository,
        protected ProductRepositoryInterface          $productRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX — pisah in dan out, masing-masing paginated
    |--------------------------------------------------------------------------
    */

    public function getIndexData(): array
    {
        return [
            'transactionsIn'  => $this->transactionRepository->getPaginatedByType('in'),
            'transactionsOut' => $this->transactionRepository->getPaginatedByType('out'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STORE TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        $product = $this->productRepository->findById($data['product_id']);

        // Validasi stok hanya jika barang keluar
        if ($data['type'] === 'out' && $product->stock < $data['qty']) {
            throw ValidationException::withMessages([
                'qty' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock,
            ]);
        }

        DB::transaction(function () use ($data, $product) {

            // Status 'pending' — stok belum berubah, menunggu konfirmasi staff
            $this->transactionRepository->create([
                'product_id' => $data['product_id'],
                'user_id'    => Auth::id(),
                'type'       => $data['type'],
                'qty'        => $data['qty'],
                'note'       => $data['note'] ?? null,
                'status'     => 'pending',
            ]);

            $jenis = $data['type'] === 'in' ? 'Barang Masuk' : 'Barang Keluar';

            $this->logActivity(
                'Buat Transaksi ' . $jenis,
                'Membuat transaksi ' . $jenis . ' sebanyak ' . $data['qty'] . ' unit untuk produk: ' . $product->name . ' (menunggu konfirmasi)'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return $this->transactionRepository->findById($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM — ubah status transaksi dari pending ke confirmed
    |--------------------------------------------------------------------------
    */

    public function confirm(int $id): void
    {
        $transaction = $this->transactionRepository->findById($id);

        if ($transaction->status === 'confirmed') {
            return; // sudah dikonfirmasi, skip
        }

        $product = $this->productRepository->findById($transaction->product_id);

        // Validasi stok saat konfirmasi barang keluar
        if ($transaction->type === 'out' && $product->stock < $transaction->qty) {
            throw ValidationException::withMessages([
                'qty' => 'Stok tidak mencukupi saat konfirmasi. Stok tersedia: ' . $product->stock,
            ]);
        }

        // Capture Auth::id() di luar closure agar tidak hilang di dalam DB::transaction
        $confirmedBy = Auth::id();

        DB::transaction(function () use ($transaction, $product, $id, $confirmedBy) {

            // Update stok produk saat dikonfirmasi
            if ($transaction->type === 'in') {
                $product->stock += $transaction->qty;
            } else {
                $product->stock -= $transaction->qty;
            }
            $product->save();

            $this->transactionRepository->updateStatus($id, 'confirmed');

            $jenis = $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar';

            // Simpan activity log dengan user_id yang sudah di-capture
            app(\App\Repositories\Interfaces\ActivityLogRepositoryInterface::class)->create([
                'user_id'     => $confirmedBy,
                'activity'    => 'Konfirmasi Transaksi',
                'description' => 'Mengkonfirmasi transaksi #' . $id . ' ' . $jenis . ' sebanyak ' . $transaction->qty . ' unit — produk: ' . ($transaction->product->name ?? '-'),
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GET CHART DATA
    |--------------------------------------------------------------------------
    */

    public function getChartData(): array
    {
        $raw = $this->transactionRepository->getChartData();

        $months   = [];
        $totalIn  = [];
        $totalOut = [];

        foreach ($raw as $item) {
            $months[]   = date('M', mktime(0, 0, 0, $item->month, 1));
            $totalIn[]  = $item->total_in;
            $totalOut[] = $item->total_out;
        }

        return compact('months', 'totalIn', 'totalOut');
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL FOR EXPORT
    |--------------------------------------------------------------------------
    */

    public function getAllForExport()
    {
        return $this->transactionRepository->getAllForExport();
    }
}