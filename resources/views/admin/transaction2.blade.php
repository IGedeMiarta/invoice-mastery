@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Transaction</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $title ?? '' }}</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 ">
            @livewire('transaction.create-list')
        </div>
    </div>
@endsection
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.js') }}"></script>

    <script>
        'use strict';
        $(function() {
            var body = $('body');
            if (window.matchMedia('(min-width: 992px)').matches) {
                $('.sidebar-toggler').toggleClass('active');
                $('.sidebar-toggler').toggleClass('not-active');
                body.addClass("sidebar-folded");
            }
        });

        $('.select2').select2().on('change', function(e) {
            var productId = $(this).val();
            $('#selectProduct').val(productId);
        });
        $('.dropify').dropify();
    </script>
@endpush
