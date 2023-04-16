@extends('dashboard.layout')

@section('title', 'Seus lançamentos')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Lançamentos</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $release_id ? 'Editar lançamento' : 'Novo lançamento' }}</h5>
                </div>
                <div class="card-body">
                    <form class="row" action="{{ $release_id ? route('update.release') : route('create.release') }}"
                        method="post">
                        @csrf
                        @if ($release_id)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $release_id->id }}" />
                        @elseif(!$release_id)
                            <input type="hidden" name="user_id" value="{{ session('user_id') }}" />
                        @endif
                        <div class="col-md-9">
                            <label for="description">Descrição:</label>
                            <input type="text" class="form-control" id="description" name="description" autofocus
                                value="{{ $release_id ? $release_id->description : old('description') }}" />
                        </div>
                        <div class="col-md-3">
                            <label for="value">Valor</label>
                            <input type="tel" class="form-control" id="value" name="value"
                                value="{{ $release_id ? $release_id->value : old('value') }}" />
                        </div>
                        <div class="col-md-3">
                            <label for="category_id">Categoria</label>
                            <select name="category_id" class="form-control" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $release_id && $category->id == $release_id->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="type">Tipo:</label>
                            <select name="type" class="form-control" id="type">
                                <option value="ENTRADA"
                                    {{ $release_id && $release_id->type == 'ENTRADA' ? 'selected' : '' }}>ENTRADA</option>
                                <option value="SAIDA" {{ $release_id && $release_id->type == 'SAIDA' ? 'selected' : '' }}>
                                    SAIDA</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="payment_id">Forma de pagamento:</label>
                            <select id="payment_id" class="form-control" name="payment_id">
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}"
                                        {{ $release_id && $payment->id == $release_id->payment_id ? 'selected' : '' }}>
                                        {{ $payment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="date">Data:</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ $release_id ? $release_id->date : old('date') }}" />
                        </div>
                        <div class="col-md-2 d-grid">
                            <br />
                            <button type="submit" class="btn btn-success"><i class="bi bi-send-plus-fill"></i>
                                Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($releases->isNotEmpty())
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Últimos lançamentos</h5>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
