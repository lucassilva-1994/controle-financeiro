@extends('user.layout')
@section('subtitle', 'Configurar senha')
@section('content')
    @if (isset($findToken))
        <form action="{{ route('user.save.password') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $findToken->token }}" />
            <div class="input-group mt-2">
                <label for="cpassword" class="input-group-text"><i class="bi bi-key-fill"></i></label>
                <input type="password" name="cpassword" placeholder="Senha:" value="{{ old('cpassword') }}" id="cpassword"
                    class="form-control" autocomplete="off" />
            </div>
            <div class="mt-2 input-group">
                <label for="ccpassword" class="input-group-text"><i class="bi bi-key-fill"></i></label>
                <input type="password" name="ccpassword" placeholder="Configurar senha:" value="{{ old('ccpassword') }}"
                    id="ccpassword" class="form-control" />
            </div>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="checkbox" onclick="showHiddenPasswords()">
                <label class="form-check-label" for="checkbox">
                    Conferir senhas
                </label>
            </div>
            <div class="mb-3 mt-2 d-grid">
                <button type="submit" class="btn btn-success"><i class="bi bi-send-fill"></i> Enviar</button>
            </div>
        </form>
    @endif
@endsection
