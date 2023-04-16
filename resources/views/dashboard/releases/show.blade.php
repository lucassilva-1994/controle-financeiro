@extends('dashboard.layout')

@section('title', 'Seus lançamentos')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3 mt-3">
            <div class="card-group">
                <div class="card">
                    <div class="card-header">
                        <h5>Entradas</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Saídas</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Saldo</h5>
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h1>Lançamentos</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif



            <div class="card mb-3">
                <div class="card-header">
                    <h5>Seus lançamentos</h5>
                </div>
                <div class="card-body">
                    @if ($releases->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição:</th>
                                        <th>Valor: </th>
                                        <th>Categoria:</th>
                                        <th>Pagamento:</th>
                                        <th>Tipo:</th>
                                        <th>Data:</th>
                                        <th>Ações:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($releases as $release)
                                        <tr>
                                            <td>{{ $release->description }}</td>
                                            <td>R$ {{ $release->value }}</td>
                                            <td>{{ $release->category->name }}</td>
                                            <td>{{ $release->payment->name }}</td>
                                            <td>{{ $release->type }}</td>
                                            <td>{{ date('d/m/Y', strtotime($release->date)) }}</td>
                                            <td class="list-inline">
                                                <span class="list-inline-item mb-2">
                                                    <a href="{{ route('edit.release', $release->id) }}"
                                                        class="btn btn-primary">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                </span>
                                                <span class="list-inline-item">
                                                    <form action="{{ route('delete.release', $release->id) }}"
                                                        method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $release->id }}" />
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </form>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif($releases->isEmpty())
                        <h5>Você não tem nenhum lançamento cadastrado,
                            <a href="{{ route('new.release') }}" class="link-success text-decoration-none">clique aqui</a>
                             para cadastrar um lançamento.
                        </h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
