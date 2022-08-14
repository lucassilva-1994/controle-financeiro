@extends("release.layout")

@section("title", "Novo lançamento")
@section("content")
<h1 class="text-center">Novo lançamento</h1>
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
<form class="" action="{{ route('create.release') }}" method="post">
    @csrf
    <div class="row justify-content-md-center">
        <div class="col-sm-8">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <div class="row mt-3 justify-content-md-center">
        <input type="hidden" name="user_id" value="{{ session('id_user') }}"/>
        <div class="col-sm-12 col-md-8 col-lg-6">
            <label for="description">Descrição:</label>
            <input type="text" name="description" value="{{ old('description') }}"
                   id="description" placeholder="Informe a descrição do lançamento"
                   class="form-control" autocomplete="off" required autofocus/>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2">
            <label for="value">Valor:</label>
            <input type="tel" name="value" value="{{old('value')}}" 
                   id="value" class="form-control" placeholder="Valor:" required/>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-5 col-lg-4">
            <label for="date">Data:</label>
            <input type="date" name="date" value="{{old('date')}}"
                   id="date" class="form-control" 
                   max="" min="" required placeholder="Data do lançamento"/>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4">
            <label for="type">Tipo:</label>
            <select name="type" class="form-control" id="type" required>
                <option value="">Selecione</option>
                <option value="RECEITA">Entrada</option>
                <option value="DESPESA">Saída</option>
            </select>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-10 col-lg-8">
            <div class="mb-3">
                <label for="details" class="form-label">Detalhes (Opcional):</label>
                <textarea class="form-control" id="details" name="details" rows="3"
                          placeholder="Caso queira informar detalhes do lançamento."></textarea>
            </div>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-sm-12 col-md-2 col-lg-2">
            <label for="payment">Pagamento:</label>
            <select name="payment" class="form-control" id="payment" required>
                <option value="">Selecione</option>
                <option value="DÉBITO">À vista</option>
                <option value="CRÉDITO">À prazo</option>
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
            <label for="category">Categoria:</label>
            <select name="category_id" class="form-control" id="category_id" required>
                <option value="">Selecione</option>
                @foreach($categories as $category)
                <option value="{{$category->id_category}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3 mt-4 mb-3 btn-group">
            <button type="submit" class="btn btn-success">Salvar</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
        </div>
    </div>
</form>

@if(!$releases->isEmpty())
<div class="row justify-content-md-center mt-4 mb-4">
    <h2 class="col-sm-12 col-md-10 col-lg-8">Últimos lançamentos</h2>
    <div class="table-responsive col-sm-12 col-md-10 col-lg-8">
        <table class="table caption-top table-striped table-hover" id="myTable2">

            <thead>
                <tr>
                    <th scope="col">Descrição</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Pagamento</th>
                    <th scope="col">Data</th>
                    <th scope="col">Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($releases as $release)
                <tr>
                    <td>{{$release->description}}</td>
                    <td>R$ {{$release->value}}</td>
                    <td>{{$release->type == "DESPESA" ? "Saída" : "Entrada"}}</td>
                    <td>{{$release->payment == "CRÉDITO" ? "À prazo" : "À vista"}}</td>
                    <td>{{date('d/m/Y', strtotime($release->date));}}</td>
                    <td>{{$release->Category->name}}</td>
                    <td>
                        <div class="btn-group d-flex" role="group" aria-label="Large button group">
                            <a href="{{route('delete.release',$release->id_release)}}" title="Excluir" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            <a href="{{route('edit.release',$release->id_release)}}" title="Editar" class="btn btn-success"><i class="bi bi-pencil"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
