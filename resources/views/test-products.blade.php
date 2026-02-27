<!DOCTYPE html>
<html>
<head>
    <title>Test Products</title>
</head>
<body>
    <h1>Test Products</h1>

    <ul>
        @foreach ($products as $product)
            <li>
                <strong>{{ $product->name }}</strong><br>
                Land: {{ $product->origin->country }}<br>
                Region: {{ $product->region->region }}<br>
                Suffix: {{ $product->suffix->suffix }}<br>
                Roast: {{ $product->roast->roast }}<br>
                Typ: {{ $product->type->type }}<br>
                In stock: {{ $product->in_stock ? 'Yes' : 'No' }}
            </li>
            <hr>
        @endforeach
    </ul>

</body>
</html>
