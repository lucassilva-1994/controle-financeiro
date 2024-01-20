@extends('user.layout')
@section('subtitle', 'Configurar senha')
@section('content')
    @if (isset($findToken) && date('Y-m-d H:i:s') < $findToken->expires_token)
        <form action="{{ route('user.save.password') }}" method="POST" class="row">
            @csrf
            <input type="hidden" name="token" value="{{ $findToken->token }}" />
            <div class="col-md-12 mb-2">
                <label for="cpassword">Senha:</label>
                <input type="password" name="cpassword" placeholder="Senha" id="cpassword" value="{{ old('cpassword') }}"
                    class="form-control" autocomplete="off" />
            </div>
            <div class="col-md-12 mb-2">
                <label for="ccpassword">Confirmar senha:</label>
                <input type="password" name="ccpassword" id="ccpassword" placeholder="Confirmar senha"
                    value="{{ old('ccpassword') }}" class="form-control" autocomplete="off" />
            </div>
            <div class="col-md-12 mb-2">
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="checkbox" onclick="showHiddenPasswords()">
                    <label class="form-check-label" for="checkbox">
                        Conferir senhas
                    </label>
                </div>
            </div>
            <div class="col-md-12 d-grid">
                <button type="submit" class="btn btn-success"><i class="bi bi-send-check-fill"></i> Alterar senha</button>
            </div>
        </form>
    @elseif(isset($findToken) && date('Y-m-d H:i:s') > $findToken->expires_token)
        <div class="alert alert-danger">
            <h5>Link expirado.</h5>
        </div>
    @else
        <div class="alert alert-danger">
            <h5>Link indisponível.</h5>
        </div>
    @endif
@endsection
