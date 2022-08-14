@extends("user.layout")
@section("subtitle","Nova senha")
@section("content")
            <form action="{{route("updatepassword.user")}}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{$token}}"/>
                <div class="input-group mt-2">
                    <label for="cpassword" class="input-group-text"><i class="bi bi-key-fill"></i></label>
                    <input type="password" name="cpassword" placeholder="Nova senha:"
                           value="{{old('cpassword')}}" id="cpassword"
                           class="form-control" autocomplete="off"/>
                </div>
                <div class="mt-2 input-group">
                    <label for="ccpassword" class="input-group-text"><i class="bi bi-key-fill"></i></label>
                    <input type="password" name="ccpassword" placeholder="Confirmar nova senha:"
                           value="{{old('ccpassword')}}" id="ccpassword"
                           class="form-control" />
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="checkbox" onclick="showHiddenPasswords()">
                    <label class="form-check-label" for="checkbox">
                        Conferir senhas
                    </label>
                </div>
                <div class="mb-3 mt-2 d-grid">
                    <input type="submit" value="Salvar" class="btn btn-success"/>
                </div>
            </form>
@endsection

