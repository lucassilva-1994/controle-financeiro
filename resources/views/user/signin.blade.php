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
            <a data-bs-toggle="modal" data-bs-target="#signup" class="btn btn-outline-primary"> <i
                    class="bi bi-person-plus-fill"></i>
                Cadastrar</a>
        </div>
        <div class="col-md-6 d-grid mb-3">
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#resetpassword"
                aria-expanded="true" aria-controls="resetpassword"><i class="bi bi-key-fill"></i> Redefinir senha</button>
        </div>
    </form>



    <div class="modal fade" id="resetpassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Redefinir senha</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row p-1" action="{{ route('user.reset.password') }}" method="post">
                        <div class="col-md-12">
                            @csrf
                            <label for="remail">Email:</label>
                            <input type="email" class="form-control mb-3 mt-1" name="remail" id="remail"
                                placeholder="Informe seu email." value="{{ old('remail') }}" />
                        </div>
                        <div class="col-md-12 d-grid">
                            <button type="submit" class="btn btn-success"> <i class="bi bi-send-fill"></i> Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create.user') }}" method="POST" class="row">
                        @csrf
                        <div class="col-md-12 mb-2">
                            <label for="name">Nome completo:</label>
                            <input type="text" class="form-control" placeholder="Seu nome completo" autocomplete="off"
                                autofocus name="name" value="{{ old('name') }}" id="name" />
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="user">Usuário:</label>
                            <input type="username" class="form-control" placeholder="Usuário de acesso"
                                autocomplete="off" value="{{ old('username') }}" id="username" name="username" />
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" placeholder="Email de acesso" autocomplete="off"
                                value="{{ old('email') }}" id="email" name="email" />
                        </div>
                        <div class="col-md-6 d-grid mt-3">
                            <button type="submit" class="btn btn-success"><i class="bi bi-send-fill"></i>
                                Enviar</button>
                        </div>
                        <div class="col-md-6 d-grid mt-3">
                            <a data-bs-dismiss="modal" class="btn btn-danger">
                                <i class="bi bi-x-circle-fill"></i> Fechar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
