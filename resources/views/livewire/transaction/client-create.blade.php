<div>
    <div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="save" wire:ignore>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="company_name">Company Name<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="company_name" autocomplete="off"
                                placeholder="PT. MAZEA" wire:model="company_name" wire:ignore.self required>
                        </div>
                        <div class="form-group">
                            <label for="name">Dir Name<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="name" autocomplete="off"
                                placeholder="Mrs. Imelda Adhi Saputra" wire:model="name" wire:ignore.self required>
                        </div>
                        <div class="form-group">
                            <label for="position">Dir Position<i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="position" autocomplete="off"
                                placeholder="Direktur Utama" wire:model="position" wire:ignore.self required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address<i class="text-danger">*</i></label>
                            <textarea wire:model="company_address" id="address" cols="30" rows="5" class="form-control"
                                wire:ignore.self placeholder="Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btnClose" data-dismiss="modal" id="close-modal">
                            <i data-feather="x"></i>Close</button>
                        <button type="submit" class="btn btn-primary"> <i data-feather="save"></i>Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            Livewire.on('closeModal', function() {
                const closeButton = $('#close-modal');
                if (closeButton.length > 0) {
                    closeButton.trigger('click');
                } else {
                    console.error('Button with ID "close-modal" not found');
                }
            });
            Livewire.on('success', function(data) {
                Toast.fire({
                    icon: 'success',
                    title: 'Client Behasil Ditambahkan'
                });
            });

        });
    </script>
@endpush
