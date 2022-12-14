@extends("user.layout")
@section("subtitle","Redefinir senha")
@section("content")
<form action="{{route("updatetoken.user")}}" method="POST">
    @csrf
    <div class="input-group mb-5">
        <label for="email" class="input-group-text"><i class="bi bi-envelope"></i></label>
        <input type="email" name="email" placeholder="Digite seu e-mail"
               value="{{old('email')}}" id="email"
               class="form-control" autocomplete="off" required="" autofocus=""/>
        <input type="submit" value="Enviar" class="btn btn-success"/>
    </div>
</form>
@endsection

