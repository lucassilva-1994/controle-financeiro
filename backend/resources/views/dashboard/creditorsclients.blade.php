@extends('dashboard.layout')
@section('title', 'Fornecedores/clientes')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Fornecedores/clientes</h1>
            @include('message')
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $creditorClient_id ? 'Editar fornecedor/cliente' : 'Novo fornecedor/cliente' }}</h5>
                </div>
                <div class="card-body">
                    <form class="row" method="post" action="{{ $creditorClient_id ? route('creditorclient.update',$creditorClient_id->id) : route('creditorclient.create') }}">
                        @csrf
                        @if ($creditorClient_id)
                            <input type="hidden" name="id" value="{{ $creditorClient_id->id }}" />
                            @method('put')
                        @elseif(!$creditorClient_id)
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        @endif
                        <div class="col-md-5">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                                value="{{ $creditorClient_id ? $creditorClient_id->name : old('name') }}" autofocus />
                        </div>
                        <div class="col-md-3">
                            <label for="type">Tipo: </label>
                            <select class="form-control" id="type" name="type">
                                <option value="AMBOS" {{ $creditorClient_id && $creditorClient_id->type == "AMBOS" ? 'selected' : ''  }}>Ambos</option>
                                <option value="CLIENTE" {{ $creditorClient_id && $creditorClient_id->type == "CLIENTE" ? 'selected' : ''  }}>Cliente</option>
                                <option value="FORNECEDOR" {{ $creditorClient_id && $creditorClient_id->type == "FORNECEDOR" ? 'selected' : ''  }}>Fornecedor</option>
                            </select>
                        </div>
                        <div class="{{ $creditorClient_id ? 'col-md-2' : 'col-md-2' }} d-grid">
                            <br />
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-send-fill"></i> {{ $creditorClient_id ? 'Atualizar' : 'Enviar' }}
                            </button>
                        </div>
                        <div class="col-md-2 d-grid">
                            <br />
                            @if ($creditorClient_id)
                                <a href="{{ route('creditorclient.new') }}" class="btn btn-primary"><i
                                        class="bi bi-clipboard-plus"></i> Novo</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Fornecedores/Clientes</h5>
                </div>
                @if($creditorsClients->isNotEmpty())
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome:</th>
                                    <th>Tipo: </th>
                                    <th>Criado em:</th>
                                    <th>Lançamentos:</th>
                                    <th>Valores:</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($creditorsClients as $creditorclient)
                                    <tr class="text-nowrap">
                                        <td>{{ $creditorclient->name }}</td>
                                        <td>{{ $creditorclient->type }}</td>
                                        <td>{{ $creditorclient->created_at }}</td>
                                        <td>{{ $creditorclient->releases->count() }}</td>
                                        <td>R$ {{ number_format($creditorclient->releases_sum_value,2,',','.') }}</td>
                                        <td class="list-inline">
                                            <span class="list-inline-item  mb-2">
                                                <a href="{{ route('creditorclient.edit', $creditorclient->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            </span>
                                            <span class="list-inline-item">
                                                <form action="{{ route('creditorclient.delete', $creditorclient->id) }}"
                                                    method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="bi bi-trash-fill"></i></button>
                                                </form>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex  justify-content-lg-end">
                        <strong>{{ $creditorsClients->count() }} registros encontrados.</strong>
                    </div>
                </div>
                @else
                <div class="card-body">
                    <div>
                        <h4>Nenhum fornecedor/cliente encontrado.</h4>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
