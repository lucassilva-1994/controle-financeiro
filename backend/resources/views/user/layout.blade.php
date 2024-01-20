<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{env('APP_URL').'css/bootstrap.min.css'}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        <title>@yield('title','Controle financeiro')</title>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-12 col-lg-5 rounded">
                    <div class="">
                        <h1 class="mb-3">@yield("subtitle","Controle financeiro")</h1>

                        @include('message')
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
        <script src="{{env('APP_URL').'js/bootstrap.bundle.min.js'}}"></script>
        <script src="{{env('APP_URL').'js/financial.js'}}"></script>
    </body>
</html>




