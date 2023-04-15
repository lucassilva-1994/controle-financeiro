<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        <title>@yield('title','Controle financeiro')</title>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-12 col-lg-5 rounded">
                    <div class="">
                        <h1 class="mb-3">@yield("subtitle","Controle financeiro")</h1>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
        <script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{url('js/financial.js')}}"></script>
    </body>
</html>




