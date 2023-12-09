@extends('dashboard.layout')
@section('title', 'Forma de pagamento')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Formas de pagamento</h1>
            @include('message')
            <div class="card mb-3">
                <div class="card-header">
                    <h5>{{ $payment ? 'Editar forma de pagamento' : 'Nova forma de pagamento' }}</h5>
                </div>
                <div class="card-body">
                    <form class="row" method="post" action="{{ $payment ? route('payment.update',$payment->id) : route('payment.create') }}">
                        @csrf
                        @if ($payment)
                            <input type="hidden" name="id" value="{{ $payment->id }}" />
                            @method('put')
                        @elseif(!$payment)
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        @endif
                        <div class="col-md-5">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                                value="{{ $payment ? $payment->name : old('name') }}" autofocus />
                        </div>
                        <div class="col-md-3">
                            <label for="calculate">Calculável:</label>
                            <select name="calculate" id="calculate" class="form-control">
                                <option value="YES" {{ $payment && $payment->calculate == 'YES' ? 'selected' : '' }}>
                                    SIM</option>
                                <option value="NO" {{ $payment && $payment->calculate == 'NO' ? 'selected' : '' }}>Não
                                </option>
                            </select>
                        </div>
                        <div class="{{ $payment ? 'col-md-2' : 'col-md-2' }} d-grid">
                            <br />
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-send-fill"></i> {{ $payment ? 'Atualizar' : 'Enviar' }}
                            </button>
                        </div>
                        <div class="col-md-2 d-grid">
                            <br />
                            @if ($payment)
                                <a href="{{ route('payment.new') }}" class="btn btn-primary"><i
                                        class="bi bi-clipboard-plus"></i> Novo</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Suas formas de pagamento</h5>
                </div>
                @if ($payments->isNotEmpty())
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome:</th>
                                    <th>Calculavél</th>
                                    <th>Criado em:</th>
                                    <th>Lançamentos:</th>
                                    <th>Valores:</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr class="text-nowrap">
                                        <td>{{ $payment->name }}</td>
                                        <td>{{ $payment->calculate == 'YES' ? 'SIM' : 'NÃO' }}</td>
                                        <td>{{ $payment->created_at }}</td>
                                        <td>{{ $payment->releases->count() }}</td>
                                        <td>R$ {{ number_format($payment->releases_sum_value,2,',','.') }}</td>
                                        <td class="list-inline">
                                            <span class="list-inline-item  mb-2">
                                                <a href="{{ route('payment.edit', $payment->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                            </span>
                                            <span class="list-inline-item">
                                                <form action="{{ route('payment.delete', $payment->id) }}"
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
                        <strong>{{ $payments->count() }} registros encontrados.</strong>
                    </div>
                </div>
                @else
                    <div class="card-body">
                        <div>
                            <h4>Nenhuma forma de pagamento encontrado.</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
