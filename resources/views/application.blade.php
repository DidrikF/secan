<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),                
            ]) !!};
            
        </script>

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
        <link rel="stylesheet" type="text/css" href="css/app.css">
    </head>

    <body>
        <div class="" id="app">
            <!-- The SPA ! -->
            <application></application>

        </div>

       <script src="js/app.js"></script>

    </body>
</html>
