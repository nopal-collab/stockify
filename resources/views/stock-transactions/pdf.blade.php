<!DOCTYPE html>
<html>
<head>
    <title>Stock Transactions Report</title>

    <style>

        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid black;
        }

        th, td{
            padding:10px;
            text-align:left;
        }

        th{
            background:#f2f2f2;
        }

    </style>
</head>
<body>

    <h2>
        Stock Transactions Report
    </h2>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Note</th>
                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach($transactions as $transaction)

                <tr>

                    <td>{{ $transaction->id }}</td>

                    <td>
                        {{ $transaction->product->name ?? '-' }}
                    </td>

                    <td>
                        {{ $transaction->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ strtoupper($transaction->type) }}
                    </td>

                    <td>
                        {{ $transaction->qty }}
                    </td>

                    <td>
                        {{ $transaction->note }}
                    </td>

                    <td>
                        {{ $transaction->created_at->format('d-m-Y') }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>