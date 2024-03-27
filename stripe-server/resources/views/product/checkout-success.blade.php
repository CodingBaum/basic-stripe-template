<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ asset('styles.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
    <div class="center">
        <div class="container">
            <h2>Thank you for your purchase, {{$customer->name}} !</h2>

            <div>You got hold of: </div>

            <div>This results in a total Price of {{ '<Price>' }}.</div>

            <div class="button-container">
                <a href="{{$order->redirect_url}}" class="continue-link">Return to Shop</a>
                <div class="button-line"></div>
            </div>
        </div>
    </div>
</body>
</html>
