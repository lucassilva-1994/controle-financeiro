@extends('release.layout')

@section('title', 'Seus lançamentos')

@section('content')

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


    </div>

    <div class="">
        <h2>Lançamentos</h2>
        <strong> registros encontrados.</strong>
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            <span>Nenhum lançamento cadastrado,
                                <a href="{{ route('new.release') }}" title="Cadastrar lançamento">cadastre aqui</a>
                            </span>
                        </td>
                    </tr>
            </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <strong>ENTRADAS:</strong>
                            <strong>SAÍDAS:</strong>
                            <strong>SALDO:</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            <span><strong>ENTRADAS, SAÍDAS E SALDO</strong> são calculados sobre lançamentos com pagamento
                                <strong>À vista.</strong> </span>
                        </td>
                    <tr>
                </tfoot>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="">
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
