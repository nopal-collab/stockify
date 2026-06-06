<!DOCTYPE html>
<html>
<head>
    <title>Products Report</title>

    <style>

        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background: #f2f2f2;
        }

        th, td {
            padding: 10px;
            font-size: 12px;
            text-align: left;
        }

    </style>

</head>

<body>

    <h2>Products Report</h2>

    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Description</th>

            </tr>

        </thead>

        <tbody>

            @foreach($products as $product)

                <tr>

                    <td>{{ $product->id }}</td>

                    <td>
                        {{ $product->category->name ?? '-' }}
                    </td>

                    <td>
                        {{ $product->name }}
                    </td>

                    <td>
                        {{ $product->stock }}
                    </td>

                    <td>
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $product->description }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>