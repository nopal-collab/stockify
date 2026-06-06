<?php

namespace App\Exports;

use App\Models\StockTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class StockTransactionsExport implements FromCollection
{
    public function collection()
    {
        return StockTransaction::with(['product', 'user'])
            ->get()
            ->map(function ($transaction) {

                return [

                    'ID' => $transaction->id,

                    'Product' => $transaction->product->name ?? '-',

                    'User' => $transaction->user->name ?? '-',

                    'Type' => strtoupper($transaction->type),

                    'Qty' => $transaction->qty,

                    'Note' => $transaction->note,

                    'Date' => $transaction->created_at->format('d-m-Y H:i'),

                ];

            });
    }
}