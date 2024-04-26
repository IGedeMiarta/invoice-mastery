<div>
    <div class="modal fade" id="addService" tabindex="-1" role="dialog" aria-labelledby="addService" aria-hidden="true"
        wire:ignore>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addService">Add Service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="save" wire:ignore>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" wire:ignore>
                            <label for="name">Nama<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="PPh" wire:model="name" required>
                        </div>
                        <div class="form-group" wire:ignore>
                            <label for="percent">Percent (%)<i class="text-danger">*</i></label>
                            <input type="text" class="form-control mb-4 mb-md-0" id="percent" wire:model="percent"
                                placeholder="10" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" id="close-modal" data-dismiss="modal"> <i
                                data-feather="x"></i>Close</button>
                        <button type="submit" class="btn btn-primary"> <i data-feather="save"></i>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('closeModal', function() {
                $('#addService').modal('toggle');
            });
            Livewire.on('success', function(data) {
                Toast.fire({
                    icon: 'success',
                    title: 'Produk Behasil Ditambahkan'
                });
            });

        });
    </script>
@endpush
