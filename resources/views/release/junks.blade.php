@extends("release.layout")
@section("title", "Lixeira")
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
<div class="">
	<h2>Lixeira</h2>
</div>
<div class="table-responsive">
    <table class="table caption-top table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Valor</th>
                <th scope="col">Data</th>
                <th scope="col">Categoria</th>
                <th scope="col" class="col-1">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($junks as $junk)
            <tr>
                <td>{{$junk->description}}</td>
                <td>R$ {{$junk->value}}</td>
                <td>{{date('d/m/Y', strtotime($junk->date));}}</td>
                <td>{{$junk->Category->name}}</td>
                <td>
                    <div class="btn-group d-flex" role="group" aria-label="Large button group">
                        <a href="{{route('delete.release',$junk->id_release)}}" title="Excluir permanentemente" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        <a href="{{route('restore.release',$junk->id_release)}}" title="Restaurar" class="btn btn-success"><i class="bi bi-reply-fill"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
            @if($junks->isEmpty())
            <tr>
                <td colspan="5" style="text-align: center;">
                    <span>Nenhum item na lixeira</span>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection


