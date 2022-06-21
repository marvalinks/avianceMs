<div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Flight No <span class="span-red">*</span></label>
                <input required type="text" name="flight_no" class="form-control flatpickr-input"
                    placeholder="Flight No">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">ULD Option <span class="span-red">*</span></label>
                <select required wire:model="uld_option" name="uld_option" id="" class="form-control">
                    <option value="bulk">Bulk</option>
                    <option value="uld">ULD number</option>
                </select>
            </div>
        </div>
        @if ($uld_option == 'uld')
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">ULD Number <span class="span-red">*</span></label>
                <input required type="text" name="uld_number" class="form-control flatpickr-input"
                    placeholder="ULD Number">
            </div>
        </div>
        @endif
    </div>
</div>
