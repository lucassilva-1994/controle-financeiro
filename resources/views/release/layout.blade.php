<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Refresh" content="600"/>
        <link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css"/>


        <title>@yield('title','Lançamentos')</title>
    </head>
    <body>
        <nav class="pt-1" style="color: white;background-color: #0f5132;">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto">
                    <li class="nav-item nav-link link-light px-2"><h4><i class="bi bi-cash-coin"></i></h4></li>
                    <li class="nav-item"><a href="{{ route('index.release') }}" class="nav-link link-light px-2">Lançamentos</a></li>
                    <li class="nav-item"><a href="{{ route('new.release') }}" class="nav-link link-light px-2">Novo lançamento</a></li>
                    <li class="nav-item"><a href="{{ route('category.new') }}" class="nav-link link-light px-2">Categorias</a></li>

                    <li class="nav-item"><a href="{{ route('junk.release') }}" class="nav-link link-light px-2">Lixeira</a></li>
                </ul>
                <ul class="nav">
                    <li class="nav-item nav-link link-light px-2"><i class="bi bi-person-circle"></i> {{session('user')}}</li>
                    <li class="nav-item"><a href="{{ route('user.signout') }}" class="nav-link link-light px-2"><i class="bi bi-box-arrow-in-right"></i> Sair</a></li>
                </ul>
            </div>
        </nav>
        <div class="container mt-3">@yield("content")</div>
    </body>
    <script src="{{url('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{url('js/jquery.maskMoney.min.js')}}"></script>
    <script src="{{url('js/financial.js')}}"></script>
</html>
