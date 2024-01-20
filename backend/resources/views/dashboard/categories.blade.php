@extends('dashboard.layout')
@section('title', 'Categorias')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Categorias</h1>
            @include("message")
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $category ? 'Editar Categoria' : 'Nova Categoria' }}</h5>
                </div>
                <div class="card-body">
                    <form class="row"  action="{{ $category ? route('category.update') : route('category.create') }}" method="post">
                        @csrf
                        @if ($category)
                            <input type="hidden" name="id" value="{{ $category->id }}" />
                            @method('put')
                        @elseif(!$category)
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                        @endif
                        <div class="col-md-5">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                                value="{{ $category ? $category->name : old('name') }}" autofocus />
                        </div>
                        <div class="col-md-3">
                            <label for="type">Tipo:</label>
                            <select name="type" id="type" class="form-control">
                                <option value="ENTRADA" {{ $category && $category->type == 'ENTRADA' ? 'selected' : '' }}>
                                    Entrada</option>
                                <option value="SAIDA" {{ $category && $category->type == 'SAIDA' ? 'selected' : '' }}>Saída
                                </option>
                                <option value="AMBOS" {{ $category && $category->type == 'AMBOS' ? 'selected' : '' }}>
                                    Ambos
                                </option>
                            </select>
                        </div>
                        <div class="{{ $category ? 'col-md-2' : 'col-md-2' }} d-grid">
                            <br />
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-send-fill"></i> {{ $category ? 'Atualizar' : 'Enviar' }}
                            </button>
                        </div>
                        <div class="col-md-2 d-grid">
                            <br />
                            @if ($category)
                                <a href="{{ route('category.new') }}" class="btn btn-primary"><i
                                        class="bi bi-clipboard-plus"></i> Novo</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Suas Categorias</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Nome:</th>
                                    <th>Tipo:</th>
                                    <th>Criado em:</th>
                                    <th>Lançamentos:</th>
                                    <th>Valores:</th>
                                    <th>Ações:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr  class="text-nowrap">
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->type }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->releases->count() }}</td>
                                        <td>R$ {{ number_format($category->releases_sum_value,2,',','.') }}</td>
                                        <td class="list-inline">
                                            <span class="list-inline-item  mb-2">
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            </span>
                                            <span class="list-inline-item">
                                                <form action="{{ route('category.delete', $category->id) }}"
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
                    <div class="d-flex justify-content-lg-end">
                        <strong>
                            {{ $categories->count() }} registros encontrados.
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
