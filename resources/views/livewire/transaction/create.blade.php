@push('plugin-styles')
    <link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush
<div>
    <div class="row d-none" id="errInfo">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error!</h4>
                <p id="errMsg"></p>
                <hr>
                <p class="mb-0">Coba Hubungi Developer :(</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Client</h6>
                    <div class="form-group">
                        <select name="client" id="client" class="form-control js-example-basic-single w-100"
                            wire:model="client_id">
                            <option value="0">-Select</option>
                            @foreach ($client as $item)
                                <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2">
                            <a href="#" data-toggle="modal" data-target="#addClient">Tambah Client</a>
                        </div>
                        <livewire:transaction.client-create />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Desctiption</h6>
                    <div class="input-group" wire:ignore>
                        <textarea name="desc" id="desc" wire:model="desc" cols="30" rows="5" class="form-control"
                            placeholder="Tax Service : Tax Audit Assistance..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Total :</h6>
                    <div style="display: flex; justify-content: end">
                        <h1 id="amount">{{ rp($fin_amount) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="name">Service<i class="text-danger">*</i></label>
                            <select wire:model="service"
                                class=" form-control @error('service')
                                is-invalid
                            @enderror"
                                id="selectProduct">
                                <option>--Select</option>
                                @foreach ($allProduct as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->percent }}% | {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <div class="mt-2">
                                <a href="#" data-toggle="modal" data-target="#addService">Tambah Service</a>
                            </div>

                            <livewire:transaction.product-add />
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="priceTb">Price<i class="text-danger">*</i></label>
                                <input type="text" wire:model="price_amount" id="priceTb"
                                    class="form-control @error('price_amount')
                                is-invalid
                                @enderror"
                                    placeholder="1,000,000">
                                @error('price_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" wire:ignore>
                                <label for="notes"><i class="text-danger">*</i></label>
                                <button class="btn btn-success form-control" wire:click="addProduk">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Percent</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($table as $index => $item)
                                    <tr>
                                        <td style="width: 100px;">{{ $item['no'] }}</td>
                                        <td>{{ $item['product'] }}</td>
                                        <td style="width: 100px">{{ $item['percent'] }}%</td>
                                        <td style="width: 300px; text-align: end">{{ $item['price'] }}</td>
                                        <td style="width: 300px; text-align: end">{{ $item['amount'] }}</td>
                                        <td style="width: 100px">
                                            <button wire:click="deleteRow({{ $index }})"
                                                class="btn btn-danger"><i class="mdi mdi-close"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="justify-content: end">
        {{-- <div class="col-md-6 mt-2">
            <div class="card">
                <div class="card-body">
                    <label for="">NOTES</label>
                    <div class="form-group">
                        <textarea class="form-control" name="notes" wire:model="notes" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-6 stretch-card mt-2">
            <div class="card">
                <div class="card-body">
                    <label for="">Additional</label>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_name" placeholder="VAT" id="add_name"
                                    class="form-control" wire:model="add_name">
                            </div>
                            <div class="col-md-5">
                                <label for="name">Percent<span class="text-danger">*</span></label>
                                <input type="number" name="add_prercent" placeholder="10" class="form-control"
                                    wire:model="add_prercent">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" wire:ignore>
                                    <label for="notes"><i class="text-danger">*</i></label>
                                    <button class="btn btn-success form-control"
                                        wire:click="addAditional">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-end" style="text-align: end">Name</th>
                                <th class="text-end" style="text-align: end">Amount</th>
                                <th style="text-align: center">Opt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($additionalTable)
                                <tr>
                                    <td style="text-align: end">SUB TOTAL</td>
                                    <td style="text-align: end">{{ $subtotal }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            @forelse ($additionalTable as $index => $tax)
                                <tr>
                                    <td style="text-align: end">{{ $tax['name'] }} {{ $tax['percent'] }}</td>
                                    <td style="text-align: end">{{ $tax['amount'] }}</td>

                                    <td style="width: 100px;text-align: center">
                                        <button wire:click="refresh({{ $index }})"
                                            class="btn btn-info btn-sm"><i class="mdi mdi-reload"></i></button>
                                        <button wire:click="deleteAdditional({{ $index }})"
                                            class="btn btn-danger btn-sm"><i class="mdi mdi-close"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($additionalTable)
                            <tfoot>
                                <tr>
                                    <td style="text-align: end">TOTAL DUE</td>
                                    <td style="text-align: end">{{ $total_due }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>
    <button class="btn btn-primary mt-3 btn-block btn-lg" wire:click="submitOrder">SUBMIT</button>
</div>

@push('custom-scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('error', function(data) {
                $('#errInfo').removeClass('d-none');
                $('#errMsg').text(data);
            });
            $('#priceTb').on('input', function() {
                // Remove non-numeric characters
                var numericValue = $(this).val().replace(/\D/g, '');

                // Format the numeric value with commas
                var formattedValue = numberWithCommas(numericValue);

                // Set the formatted value to the input field
                $(this).val(formattedValue);
            });
        });

        // Function to add commas to a number
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endpush
