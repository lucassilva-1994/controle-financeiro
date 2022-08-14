
@extends("release.layout")
@section("title", "Editar lançamento")
@section("content")
<h1 class="text-center">Editar lançamento</h1>
<div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10 col-lg-8">
        @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>
@if(!empty($release))
<form class="" action="{{ route('update.release', $release->id_release) }}" method="post">
    @csrf
    @method("PUT")
    <div class="row mt-3 justify-content-md-center">
        <input type="hidden" name="user_id" value="{{ session('id_user') }}"/>
        <input type="hidden" name="id_release" value="{{$release->id_release}}"/>
        <div class="col-sm-12 col-md-8 col-lg-6">
            <label for="description">Descrição:</label>
            <input type="text" name="description" value="{{ $release->description }}"
                   id="description" placeholder="Informe a descrição do lançamento"
                   class="form-control" autocomplete="off" autofocus="" required/>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2">
            <label for="value">Valor:</label>
            <input type="tel" name="value" value="{{$release->value}}" 
                   id="value" class="form-control" placeholder="Valor:" required/>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-5 col-lg-4">
            <label for="date">Data:</label>
            <input type="date" name="date" value="{{$release->date}}"
                   id="date" class="form-control" required="true"
                   max="" min="" placeholder="Data do lançamento"/>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4">
            <label for="type">Tipo:</label>
            <select name="type" class="form-control" id="type" required="true">
                <option value="">Selecione</option>
                <option value="RECEITA" {{$release->type == "RECEITA" ? "selected" : ""}}>Entrada</option>
                <option value="DESPESA" {{$release->type == "DESPESA" ? "selected" : ""}}>Saída</option>
            </select>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="mb-2 mt-2">
                <label for="details" class="form-label">Detalhes (Opcional):</label>
                <textarea class="form-control" id="details" name="details" rows="2"
                          placeholder="Caso queira informar detalhes do lançamento.">{{$release->details}}</textarea>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-2 col-lg-2">
            <label for="payment">Pagamento:</label>
            <select name="payment" class="form-control" id="payment" required>
                <option value="">Selecione</option>
                <option value="DÉBITO" {{$release->payment == "DÉBITO" ? "selected" : ""}}>À vista</option>
                <option value="CRÉDITO" {{$release->payment == "CRÉDITO" ? "selected" : ""}}>À prazo</option>
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
            <label for="category">Categoria:</label>
            <select name="category_id" class="form-control" id="category_id" required="true">
                @foreach($categories as $category)
                <option value="{{$category->id_category}}" {{ $category->id_category == $release->category_id ? "selected" : ""}} >{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3 mt-4 mb-3 btn-group">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a onclick="history.back()" class="btn btn-danger">Voltar</a>
        </div>
    </div>
</form>
@elseif(empty($release))
<div class="row justify-content-md-center">
    <div class="col-sm-12 col-md-10 col-lg-8">
        <div class="alert alert-danger text-center">
            Você não tem permissão para editar esse lançamento.
        </div>
    </div>
</div>
@endif

@endsection
