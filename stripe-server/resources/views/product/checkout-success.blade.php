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
            <h1>Thank you for your purchase, {{$customer->name}}!</h1>


            <a href="{{$order->redirect_url}}" class="continue-link">Continue</a>
        </div>
    </div>
</body>
</html>
