@extends("release.layout")

@section("title", "Seus lançamentos")

@section("content")

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h3>Filtro</h3>
    <form action="{{route('index.release')}}" method="get" class="mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-12 form-group mt-2">
                <select name="type" class="form-control">
                    <option value="">Todos</option>
                    <option value="RECEITA" {{ (request()->type == "RECEITA") ? 'selected' : '' }}>Entrada</option>
                    <option value="DESPESA" {{ (request()->type == "DESPESA") ? 'selected' : '' }}>Saída</option>
                </select>
            </div>

            <div class="col-md-6 col-sm-12 form-group mt-2">
                <div class="input-group ">
                    <input type="date" class="form-control" name="start_date" value="{{ $dateFilter['initial'] }}" id="start_date" required />

                    <label class="input-group-text"><i class="bi bi-calendar2"></i></label>

                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $dateFilter['final'] }}" required />

                    <button type="submit" class="btn text-light" style="background-color: #0f5132;"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="">
    <h2>{{ $title }}</h2>
    <strong>{{$releases->total()}} registros encontrados.</strong>
</div>

<div class="table-responsive">
    <table class="table caption-top table-striped table-hover">
        <thead>
            <tr>
                <th scope="col" style="width:30%;">Descrição</th>
                <th scope="col">Valor</th>
                <th scope="col">Data</th>
                <th scope="col">Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($releases as $release)
            <tr>
                <td>{{ mb_strimwidth($release->description, 0, 35, " ...")}}</td>
                <td>R$ {{$release->value}}</td>
                <td>{{date('d/m/Y', strtotime($release->date));}}</td>
                <td>{{$release->Category->name}}</td>
                <td>
                    <div class="btn-group d-flex" role="group" aria-label="Large button group">
                        <a href="{{route('remove.release',$release->id_release)}}" title="Excluir" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        <a href="{{route('edit.release',$release->id_release)}}" title="Editar" class="btn btn-success"><i class="bi bi-pencil"></i></a>
                        <a onclick="showDetails('{{$release}}')" title="Ver detalhes" class="btn btn-primary"><i class="bi bi-info-circle-fill"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach

            @if($releases->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center;">
                    <span>Nenhum lançamento cadastrado,
                        <a href="{{route('new.release')}}" title="Cadastrar lançamento">cadastre aqui</a>
                    </span>
                </td>
            </tr>
            @endif
        </tbody>
      @if(!$releases->isEmpty())
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;">
                    <strong>ENTRADAS:</strong> R$ {{ number_format($balance["revenues"], 2, ",", ".") }} &nbsp;
                    <strong>SAÍDAS:</strong> R$ {{ number_format($balance["expenses"], 2, ",", ".") }} &nbsp;
                    <strong>SALDO:</strong> R$ {{ number_format(($balance["revenues"] - $balance["expenses"]), 2, ",", ".") }}
                </td>
            </tr>
            <tr>
	<td colspan="5"  style="text-align: right;">
	    <span><strong>ENTRADAS, SAÍDAS E SALDO</strong> são calculados sobre lançamentos com pagamento <strong>À vista.</strong> </span>
	</td>
            <tr>
        </tfoot>
    @endif
    </table>
</div>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="">
            {{$releases->appends(request()->all())->links()}}
        </li>
    </ul>
</nav>

<div class="modal" id="show" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do lançamento</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <div class="btn-group d-flex d-grid" role="group" aria-label="Large button group">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
