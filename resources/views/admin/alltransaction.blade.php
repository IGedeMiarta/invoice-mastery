@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Transaction</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title ?? '' }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <h6 class="card-title">Tabel {{ $title }}</h6>
                        {{-- <a href="{{ route('admin.order.form') }}" class="btn btn-success"><i data-feather="plus"></i> Add
                            {{ $title }}</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>TRX</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                    <th>Due Amount</th>
                                    <th>Description</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($table as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-end" style="text-align: end">
                                            <p><b>{{ $item->trx }}</b> <br>
                                                {{ dateFormat($item->dates) }}
                                            </p>

                                        </td>
                                        <td>
                                            <p>
                                                <b>{{ $item->getClient?->company_name }}</b> <br>
                                                {{ $item->getClient?->name }} <br>
                                                {{ $item->getClient?->position }} <br>
                                                {{ $item->getClient?->company_address }} <br>
                                            </p>
                                        </td>
                                        <td>{{ rp($item->total) }}</td>
                                        <td>{{ rp($item->due_total) }}</td>
                                        <td>
                                            <p>{{ cutStr($item->desc) }}</p>
                                        </td>
                                        <td>
                                            <ul class="list-group">
                                                <a href="{{ route('inv', $item->id) }}" target="_blank">
                                                    <li class="list-group-item list-group-item-info"> <i
                                                            class="mdi mdi-file-document"></i> Detail</li>
                                                </a>
                                                <a href="{{ route('transaction.edit', $item->id) }}">
                                                    <li class="list-group-item list-group-item-warning"> <i
                                                            class="mdi  mdi-pencil"></i> Edit</li>
                                                </a>
                                                <a href="{{ route('transaction.delete', $item->id) }}">
                                                    <li class="list-group-item list-group-item-danger"> <i
                                                            class="mdi mdi-trash-can"></i> Delete</li>
                                                </a>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
