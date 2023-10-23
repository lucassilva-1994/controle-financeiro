@extends('dashboard.layout')

@section('title', 'Seus lançamentos')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3 mt-3">
            <div class="card-group">
                <div class="card text-center">
                    <div class="card-header">
                        <h5>Entradas</h5>
                    </div>
                    <div class="card-body ">
                        <h4 class="text-success">R$ {{ number_format($balance_total['revenues'], 2, ',', '.') }}</h4>
                    </div>
                </div>
                <div class="card  text-center">
                    <div class="card-header">
                        <h5>Saídas</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="text-danger">R$ {{ number_format($balance_total['expenses'], 2, ',', '.') }}</h4>
                    </div>
                </div>
                <div class="card  text-center">
                    <div class="card-header">
                        <h5>Saldo</h5>
                    </div>
                    <div class="card-body text-center">
                        <h4 class="text-secondary">R$
                            {{ number_format($balance_total['revenues'] - $balance_total['expenses'], 2, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h1>Lançamentos</h1>
            @include('message')
            <div class="d-flex justify-content-end">
                <div class="col-md-2 d-grid">
                    <a class="btn btn-outline-secondary m-1" href="{{ route('new.release') }}"><i
                            class="bi bi-file-earmark-plus-fill"></i> Novo</a>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Seus lançamentos ({{ $releases->count() }}/{{ $releases_total->count() }})</h5>
                </div>
                <div class="card-body">
                    <form class="row mb-3" method="post" action="{{ route('show.release') }}">
                        @csrf
                        <div class="col-md-9 mb-3">
                            <input type="text" class="form-control" name="words" id="words"
                                placeholder="Buscar por fornecedor, lançamento ou categoria." />
                        </div>
                        <div class="col-md-3 d-grid mb-3">
                            <button type="submit" name="search" class="btn btn-success"><i class="bi bi-search"></i>
                                Buscar</button>
                        </div>
                    </form>
                    @if ($releases->isNotEmpty())
                        <div class="table-responsive">
                            <div class="col-md-12 d-flex justify-content-end">
                                <p>
                                    <strong>Entradas: </strong>
                                    R$ {{ number_format($balance['revenues'], 2, ',', '.') }}
                                </p> &nbsp;
                                <p>
                                    <strong>Saidas: </strong>
                                    R$ {{ number_format($balance['expenses'], 2, ',', '.') }}
                                </p> &nbsp;
                                <p>
                                    <strong>Saldo: </strong>
                                    R$ {{ number_format($balance['revenues'] - $balance['expenses'], 2, ',', '.') }}
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição:</th>
                                        <th>Valor: </th>
                                        <th>Categoria:</th>
                                        <th>Pagamento:</th>
                                        <th>Tipo:</th>
                                        <th>Data:</th>
                                        <th>Fornecedor:</th>
                                        <th>Ações:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($releases as $release)
                                            <tr>
                                                <td>{{ $release->description }}</td>
                                                <td>R$ {{ $release->value }}</td>
                                                <td>{{ $release->category->name}}</td>
                                                <td>{{ $release->payment->name }}</td>
                                                <td>{{ $release->type }}</td>
                                                <td>{{ date('d/m/Y', strtotime($release->date)) }}</td>
                                                <td>{{ isset($release->creditorClient) ? $release->creditorClient->name : 'Não informado.' }}
                                                </td>
                                                <td class="list-inline col-md-2">
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
                                                            <input type="hidden" name="id"
                                                                value="{{ $release->id }}" />
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
                        <nav class="mt-3">
                            <ul class="pagination justify-content-center">
                                <li class="">
                                    {{ $releases->onEachSide(1)->appends(request()->except('_token'))->links() }}
                                </li>
                            </ul>
                        </nav>
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
