@extends('user.layout')
@section('subtitle', 'Novo usuário')
@section('title', 'Novo usuário')
@section('content')

    <form action="{{ route('create.user') }}" method="POST" class="row">
        @csrf
        <div class="col-md-12 mb-2">
            <label for="name">Nome completo:</label>
            <input type="text" class="form-control" placeholder="Seu nome completo" autocomplete="off" autofocus
                name="name" value="{{ old('name') }}" id="name" />
        </div>
        <div class="col-md-12 mb-2">
            <label for="user">Usuário:</label>
            <input type="user" class="form-control" placeholder="Usuário de acesso" autocomplete="off"
                value="{{ old('user') }}" id="user" name="user" />
        </div>
        <div class="col-md-12 mb-2">
            <label for="email">Email:</label>
            <input type="email" class="form-control" placeholder="Email de acesso" autocomplete="off"
                value="{{ old('email') }}" id="email" name="email" />
        </div>
        <div class="col-md-6 d-grid mt-3">
            <button type="submit" class="btn btn-success"><i class="bi bi-send-fill"></i> Enviar</button>
        </div>
        <div class="col-md-6 d-grid mt-3">
            <a href="{{ route('user.signin') }}" class="btn btn-secondary"><i class="bi bi-reply-fill"></i> Voltar</a>
        </div>
    </form>
@endsection
