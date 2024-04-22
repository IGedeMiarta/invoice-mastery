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
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($table as $item)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>
                                            <button class="btn btn-warning btnEdit" data-toggle="modal"
                                                data-target="#modalEdit" data-url="{{ route('client.update', $item->id) }}"
                                                data-name="{{ $item->name }}" data-address="{{ $item->address }}"
                                                data-phone="{{ $item->phone }}">Edit</button>
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
                <form action="{{ route('client.post') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="PT. MAZEA" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address<i class="text-danger">*</i></label>
                            <textarea name="address" id="address" cols="30" rows="5" class="form-control"
                                placeholder="Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control mb-4 mb-md-0" name="phone"
                                data-inputmask-alias="(+62)999 9999 9999" />
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
                                placeholder="PT. MAZEA" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="_address">Address<i class="text-danger">*</i></label>
                            <textarea name="address" id="_address" cols="30" rows="5" class="form-control"
                                placeholder="Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="_phone">Phone</label>
                            <input class="form-control mb-4 mb-md-0" name="phone" id="_phone"
                                data-inputmask-alias="(+62)999 9999 9999" />
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
            $('.btnEdit').on('click', function() {
                $('#_name').val($(this).data('name'));
                $('#_address').val($(this).data('address'));
                $('#_phone').val($(this).data('phone'));
                $('#formEdit').attr('action', $(this).data('url'));
            });
        })
    </script>
@endpush
