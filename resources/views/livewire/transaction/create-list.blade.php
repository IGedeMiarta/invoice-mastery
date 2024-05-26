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
                        <select name="client" id="client"
                            class="form-control js-example-basic-single w-100 @error('client_id')
                            is-invalid
                        @enderror"
                            wire:model="client_id">
                            <option value="0">-Select</option>
                            @foreach ($client as $item)
                                <option value="{{ $item->id }}">{{ $item->company_name }}</option>
                            @endforeach
                        </select>
                        <div class="mt-2 d-flex justify-content-between">
                            @error('client_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <a href="#" data-toggle="modal" data-target="#addClient">Create New</a>
                        </div>
                        <livewire:transaction.client-create />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="dates">Dates</label>
                        <div class="input-group" wire:ignore.self>
                            <input type="date" wire:model="dates" id="dates"
                                class="form-control @error('dates')
                                is-invalid
                            @enderror">
                        </div>
                        @error('dates')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="desc">Description</label>
                        <div class="input-group" wire:ignore.self>
                            <textarea name="desc" id="desc" wire:model="desc" cols="30" rows="5"
                                class="form-control @error('desc')
                                is-invalid
                            @enderror"
                                placeholder="Tax Service : Tax Audit Assistance..."></textarea>
                        </div>
                        @error('desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="align-items: center">
                    <div style="align-items: center">
                        <div>
                            <h5>Total :</h5>
                            <div style="display: flex; justify-content: end">
                                <h2 id="amount">$ {{ num($fin_amount) }}</h2>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <h5>Total Due :</h5>
                            <div style="display: flex; justify-content: end">
                                <h2 id="due_amount">{{ rp(getAmount($total_due)) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="display: flex; justify-content: space-between">
            <h5>Import Table</h5>
            <div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importExcel"><i
                            class="mdi mdi-file-excel"></i> Import</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTable"><i
                            class="mdi mdi-plus"></i> Add</button>

                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTableExample" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Who</th>
                            <th>Desctiption</th>
                            <th>Cost</th>
                            <th>
                                Option
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($table as $index => $item)
                            <tr>
                                <td style="width: 100px;">{{ $index + 1 }}</td>
                                <td style="width: 100px">{{ $item['date'] }}</td>
                                <td style="width: 100px">{{ $item['start'] }}</td>
                                <td style="width: 100px">{{ $item['end'] }}</td>
                                <td style="width: 300px;">{{ $item['who'] }}</td>
                                <td style="width: 300px;">{{ $item['description'] }}</td>
                                <td style="width: 100px;">{{ $item['cost'] }}</td>
                                <td style="width: 100px">
                                    <button wire:click="deleteRow({{ $index }})" class="btn btn-danger"><i
                                            class="mdi mdi-close"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="row" style="display: flex; justify-content: end">
        <div class="col-md-6 stretch-card mt-2">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="name">Sub Total<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="priceTbInp" wire:model="sub_total">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" wire:ignore>
                                    <label for="notes"><i class="text-danger">*</i></label>
                                    <button class="btn btn-success form-control"
                                        wire:click="changeSubtotal">Change</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="">Additional</label>
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
                                    <td style="text-align: end">
                                        {{ $tax['type'] ? '+' : '-' }}{{ $tax['amount'] }}
                                    </td>

                                    <td style="width: 100px;text-align: center">
                                        {{-- <button wire:click="refresh({{ $index }})"
                                                class="btn btn-info btn-sm"><i class="mdi mdi-reload"></i></button> --}}
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
    <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="submitTable" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div style="text-align: center; margin-bottom: 20px;">
                            <a href="{{ route('download.excel') }}" style="margin-top: 30px">download excel
                                format</a>
                        </div>
                        <input type="file" name="excelInpt" wire:model="excelInpt" class="dropify"
                            id="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary justClose"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add to Table</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="addTable" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" wire:model="date">
                        </div>
                        <div class="mb-3">
                            <label for="start" class="form-label">Start</label>
                            <input type="time" class="form-control" id="start" wire:model="start">
                        </div>
                        <div class="mb-3">
                            <label for="end" class="form-label">End</label>
                            <input type="time" class="form-control" id="end" wire:model="end">
                        </div>
                        <div class="mb-3">
                            <label for="who" class="form-label">Who</label>
                            <input type="text" class="form-control" id="who" wire:model="who">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea cols="30" rows="5" class="form-control" id="description" wire:model="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost</label>
                            <input type="text" class="form-control" id="priceTb" wire:model="cost">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary justCloseAdd"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('custom-scripts')
    <script>
        window.addEventListener('closeModal', event => {
            // Find the button element
            var button = document.querySelector(".justClose");
            // Check if the button exists
            if (button) {
                // Simulate click on the button
                button.click();
            }
        });
        window.addEventListener('closeModalAdd', event => {
            // Find the button element
            var button = document.querySelector(".justCloseAdd");
            console.log(123);
            // Check if the button exists
            if (button) {
                // Simulate click on the button
                button.click();
                console.log('click');
            }
        });
    </script>
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
            $('#priceTbInp').on('input', function() {
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
