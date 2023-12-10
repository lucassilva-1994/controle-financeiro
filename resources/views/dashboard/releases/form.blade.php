@extends('dashboard.layout')

@section('title', 'Seus lançamentos')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Lançamentos</h1>
            @include('message')
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $release_id ? 'Editar lançamento' : 'Novo lançamento' }}</h5>
                </div>
                <div class="card-body">
                    <form class="row" action="{{ $release_id ? route('update.release') : route('create.release') }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @if ($release_id)
                            @method('put')
                            <input type="hidden" name="id" value="{{ $release_id->id }}" />
                        @elseif(!$release_id)
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
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
                        <div class="col-md-4">
                            <label for="creditorsclients_id">Fornecedor/Cliente:</label>
                            <select name="creditorsclients_id" class="form-control" id="creditorsclients_id">
                                <option value="">Selecione uma opção</option>
                                @foreach ($creditorsClients as $creditorClient)
                                    <option value="{{ $creditorClient->id }}"
                                        {{ $release_id && $release_id->creditorsclients_id == $creditorClient->id ? 'selected' : '' }}>
                                        {{ $creditorClient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="type">Tipo:</label>
                            <select name="type" class="form-control" id="type">
                                <option value="ENTRADA"
                                    {{ $release_id && $release_id->type == 'ENTRADA' ? 'selected' : '' }}>ENTRADA
                                </option>
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
                                value="{{ $release_id ? $release_id->date : date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-2">
                            <label for="due_date">Vencimento:</label>
                            <input type="date" class="form-control" name="due_date" id="due_date"
                                value="{{ $release_id ? $release_id->due_date : date('Y-m-d') }}" />
                        </div>
                        <div class="col-md-3">
                            <label for="status_pay">Status:</label>
                            <select id="status_pay" name="status_pay" class="form-control">
                                <option value="ABERTO"
                                    {{ $release_id && $release_id->status_pay == 'ABERTO' ? 'selected' : '' }}>ABERTO
                                </option>
                                <option value="QUITADO"
                                    {{ $release_id && $release_id->status_pay == 'QUITADO' ? 'selected' : '' }}>QUITADO
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="files">Arquivos: </label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple />
                        </div>
                        <div class="col-md-12">
                            <label for="details">Detalhes (Opcional):</label>
                            <textarea class="form-control" id="details" name="details">{{ $release_id ? $release_id->details : old('details') }}</textarea>
                        </div>
                        <div class="col-md-4 d-grid">
                            <br />
                            <button type="submit" class="btn btn-success"><i class="bi bi-send-plus-fill"></i>
                                Salvar</button>
                        </div>
                        @if ($release_id)
                            <div class="col-md-4 d-grid">
                                <br />
                                <a href="{{ route('new.release') }}" class="btn btn-primary"><i
                                        class="bi bi-clipboard-plus-fill"></i> Novo</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            @if ($release_id && $release_id->files->count())
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Arquivos ({{ $release_id->files->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($release_id->files as $file)
                            <div class="btn-group  btn-group-sm m-1">
                                <a href="{{ env('APP_URL_FILES') . $file->path }}" target="_blank"
                                    class="btn btn-outline-primary">{{ $file->name }}</a>
                                <a href="{{ route('file.delete',$file->id) }}" class="btn btn-danger">Excluir</a>
                                <a href="{{ route('file.download',$file->id) }}" class="btn btn-primary">Baixar</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

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
                                        <th>Fornecedor:</th>
                                        <th>Data:</th>
                                        <th>Ações:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($releases as $release)
                                        <tr class="text-nowrap">
                                            <td>{{ $release->description }}</td>
                                            <td>R$ {{ $release->value }}</td>
                                            <td>{{ $release->category->name }}</td>
                                            <td>{{ $release->payment->name }}</td>
                                            <td>{{ $release->type }}</td>
                                            <td>{{ isset($release->creditorClient) ? $release->creditorClient->name : 'Não informado.' }}
                                            </td>
                                            <td>{{ date('d/m/Y', strtotime($release->date)) }}</td>
                                            <td class="list-inline">
                                                <span class="list-inline-item mb-2">
                                                    <a href="{{ route('edit.release', $release->id) }}"
                                                        class="btn btn-primary btn-sm">
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
                </div>
            @endif
        </div>
    </div>
@endsection
