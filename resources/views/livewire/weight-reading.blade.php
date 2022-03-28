<div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">weight(KG) <span class="span-red">*</span></label>
                <input required type="text" wire:model="weight" readonly name="weight"
                    class="form-control flatpickr-input" placeholder="weight">
            </div>
        </div>
        {{-- <div class="col-md-2 bbtt">
            <button wire:click.prevent="testPythonScript()" type="button" class="btn btn-danger me-4 mb-2 mb-md-0">
                Read Weight
            </button>
        </div> --}}
    </div>
</div>
