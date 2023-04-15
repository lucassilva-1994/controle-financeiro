@extends('user.layout')
@section('subtitle', 'Entrar')
@section('content')
    <form action="{{ route('user.auth') }}" method="POST" class="row">
        @csrf
        <div class="col-md-12 mb-2">
            <label for="email">Email:</label>
            <input type="email" placeholder="Digite seu e-mail" class="form-control" value="{{ old('email') }}" name="email"
                id="email" />
        </div>
        <div class="col-md-12 mb-2">
            <label for="password">Senha:</label>
            <input type="password" name="password" placeholder="Digite sua senha" class="form-control"
                value="{{ old('password') }}" id="password" name="password" />
        </div>
        <div class="col-md-12 mb-2">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="checkbox" onclick="showHiddenPassword()">
                <label class="form-check-label" for="checkbox">
                    Mostrar senha
                </label>
            </div>
        </div>
        <div class="col-md-12 d-grid mt-2 mb-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Entrar</button>
        </div>
        <div class="col-md-6 d-grid mb-3">
            <a href="{{ route('user.signup') }}" class="btn btn-primary" > <i class="bi bi-person-plus-fill"></i>
                Cadastrar</a>
        </div>
        <div class="col-md-6 d-grid mb-3">
            <button type="button" class="btn btn-danger" data-bs-toggle="collapse" data-bs-target="#resetpassword"
                aria-expanded="true" aria-controls="resetpassword"><i class="bi bi-key-fill"></i> Redefinir senha</button>
        </div>
    </form>
    <div class="col-md-12 mt-2">
        <div class="collapse" id="resetpassword">
            <div class="card card-body">
                <form class="row p-1" action="{{ route('user.reset.password') }}" method="post">
                    <div class="col-md-12">
                        @csrf
                        <label for="remail">Email:</label>
                        <input type="email" class="form-control mb-3 mt-1" name="remail" id="remail"
                            placeholder="Informe seu email." value="{{ old('remail') }}"/>
                    </div>
                    <div class="col-md-12 d-grid">
                        <button type="submit" class="btn btn-success"> <i class="bi bi-send-fill"></i> Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
