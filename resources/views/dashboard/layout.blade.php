<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Refresh" content="600" />
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" />


    <title>@yield('title', 'Lançamentos')</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg mb-3" style="background-color: #0a3b24;">
            <div class="container">
                <h2 class="text-white"><i class="bi bi-cash-coin"></i></h2>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <h2 class="text-light"><i class="bi bi-list"></i></h2>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="menu">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link link-light" href="{{ route('show.release') }}"><i class="bi bi-card-list"></i> Lançamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light" href="{{ route('category.new') }}"><i class="bi bi-tags-fill"></i> Categorias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light" href="{{ route('payment.new') }}"><i class="bi bi-cash-stack"></i> Formas de pagamento</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light" href="{{ route('creditorclient.new') }}"><i class="bi bi-people-fill"></i> Fornecedores/clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light"><i class="bi bi-person-circle"></i> {{ auth()->user()->user }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light" href="{{ route('user.signout') }}"><i class="bi bi-box-arrow-in-right"></i> Sair</a>
                        </li>
                    </ul>
                </div>
        </div>
    </nav>
    <div class="container mt-3">@yield('content')</div>
</body>
<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="{{ url('js/jquery.maskMoney.min.js') }}"></script>
<script src="{{ url('js/financial.js') }}"></script>
</html>
