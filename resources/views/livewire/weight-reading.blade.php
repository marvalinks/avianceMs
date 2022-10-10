<div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">weight(KG) <span class="span-red">*</span></label>
                <input required type="text" wire:model="weight" readonly name="weight"
                    class="form-control flatpickr-input" placeholder="weight">
                    <small><a href="{{route('wscale')}}" target="_blank">Open weight reading tab</a></small>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="mb-3">
                <h2>COMPORT (3) STATUS</h2>
                <div class="spinner-grow text-{{ $color }} m-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-2 bbtt">
            <button wire:click.prevent="testPythonScript()" type="button" class="btn btn-danger me-4 mb-2 mb-md-0">
                Read Weight
            </button>
        </div> --}}
    </div>
</div>
