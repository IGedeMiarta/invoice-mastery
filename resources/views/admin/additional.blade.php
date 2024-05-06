@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title ?? '' }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <h6 class="card-title">Tabel {{ $title }}</h6>
                        <button type="button" class="btn btn-success" class="btn btn-primary" data-toggle="modal"
                            data-target="#modalAdd"><i data-feather="plus"></i> Add {{ $title }}</button>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Percent</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($table as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->percent }}%</td>
                                        <td>{!! $item->type() !!}</td>
                                        <td>{!! $item->status() !!}</td>
                                        <td>
                                            <form action="{{ route('additional.delete', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-warning edit" data-toggle="modal"
                                                    data-target="#modalEdit"
                                                    data-url="{{ route('additional.update', $item->id) }}"
                                                    data-name="{{ $item->name }}" data-percent="{{ $item->percent }}"
                                                    data-type="{{ $item->type }}"
                                                    data-status="{{ $item->status }}">Edit</button>
                                                <button type="submit" class="btn btn-danger ">Delete</button>
                                            </form>
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
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add {{ $title ?? '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('additional.post') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="name" autocomplete="off" placeholder="VAT"
                                name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="percent">Percent (%)<i class="text-danger">*</i></label>
                            <input type="text" class="form-control mb-4 mb-md-0" id="percent" name="percent"
                                placeholder="11" />
                        </div>
                        <div class="form-group">
                            <label for="type">Type<i class="text-danger">*</i></label>
                            <select name="type" id="type" class="form-control">
                                <option value="1">(+) Plus</option>
                                <option value="0">(-) Minus</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"> <i
                                data-feather="x"></i>Close</button>
                        <button type="submit" class="btn btn-primary"> <i data-feather="save"></i>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit {{ $title ?? '' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="formEdit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="_name">Name<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="_name" autocomplete="off"
                                placeholder="Bussiness Counsulting" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="_percent">Percent (%)<i class="text-danger">*</i></label>
                            <input type="text" class="form-control mb-4 mb-md-0" id="_percent" name="percent"
                                placeholder="10" />

                        </div>
                        <div class="form-group">
                            <label for="type">Type<i class="text-danger">*</i></label>
                            <select name="type" id="_type" class="form-control">
                                <option value="1">(+) Plus</option>
                                <option value="0">(-) Minus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="_status">Status<i class="text-danger">*</i></label>
                            <select name="status" id="_status" class="form-select ">
                                <option value="1">Active</option>
                                <option value="0">NonActive</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"> <i
                                data-feather="x"></i>Close</button>
                        <button type="submit" class="btn btn-primary"> <i data-feather="save"></i>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.edit').on('click', function() {
                $('#_name').val($(this).data('name'));
                $('#_status').val($(this).data('status'));
                $('#_percent').val($(this).data('percent'));
                $('#_type').val($(this).data('type'));
                $('#_status').val($(this).data('status'));
                $('#formEdit').attr('action', $(this).data('url'));
            })
        })
    </script>
@endpush
