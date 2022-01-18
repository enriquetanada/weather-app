<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Weather App</title>
        <link rel="stylesheet" href="{{url('css/app.css?'.date('Ymdhis'))}}">

    </head>
    <body>
        <div id="app"></div>
        <script src="{{url('js/app.js?'.date('Ymdhis'))}}"></script>
    </body>
</html>
