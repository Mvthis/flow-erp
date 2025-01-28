<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->id }}</h1>
    <p>Client: {{ $invoice->client_name }}</p>
    <p>Email: {{ $invoice->client_email }}</p>
    <h3>Products:</h3>
    <ul>
        @foreach ($invoice->products as $product)
            <li>
                {{ $product->name }} (x{{ $product->pivot->quantity }}) - 
                ${{ $product->pivot->price }} each
            </li>
        @endforeach
    </ul>
    <h3>Total: ${{ $invoice->total }}</h3>
</body>
</html>
