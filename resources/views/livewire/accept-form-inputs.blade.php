<div>
    <input type="hidden" name="shipper_agent" wire:model="said">
    <input type="hidden" name="aviance_agent" wire:model="aaid">
    <input type="hidden" name="aviance_security" wire:model="asid">
    @if ($sign_count == 1)
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Choose Aviance Agent</label>
                <select wire:model="aaid" required class="form-control" {{$sbm ? 'disabled' : ''}}>
                    <option value="">-choose-</option>
                    @foreach ($aa as $agent)
                        <option value="{{ $agent['userid'] }}">
                            {{ $agent['name'] }}</option>
                    @endforeach
                </select>
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Aviance Agent Passcode</label>
                <input type="password" wire:model="aa_code" class="form-control flatpickr-input"
                    placeholder="passcode" {{$sbm ? 'disabled' : ''}}>
            </div>
        </div>
        @if (!$sbm)
        <div class="col-md-4">
            <label for="">.</label>
            <button type="button" wire:click.prevent="sign()" {{($aa_code == null || $aaid == null) ? 'disabled' : ''}} class="btn btn-secondary submit-btn">I agree and sign documents</button>
            @if ($err)
            <small style="color: red;">wrong authorization credentials</small>
            @endif
        </div>
        @else
        <div class="col-md-4">
            <p style="color: green;">Authorization confirmed.</p>
        </div>
        @endif
    </div>
    @endif
    @if ($sign_count == 2)
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Choose Aviance Security</label>
                <select wire:model="asid" required class="form-control" {{$sbm ? 'disabled' : ''}}>
                    <option value="">-choose-</option>
                    @foreach ($as as $agent)
                        <option value="{{ $agent['userid'] }}">
                            {{ $agent['name'] }}</option>
                    @endforeach
                </select>
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Aviance Security Passcode</label>
                <input type="password" wire:model="as_code" class="form-control flatpickr-input"
                    placeholder="passcode" {{$sbm ? 'disabled' : ''}}>
            </div>
        </div>
        @if (!$sbm)
        <div class="col-md-4">
            <label for="">.</label>
            <button type="button" wire:click.prevent="sign()" {{($as_code == null || $asid == null) ? 'disabled' : ''}} class="btn btn-secondary submit-btn">I agree and sign documents</button>
            @if ($err)
            <small style="color: red;">wrong authorization credentials</small>
            @endif
        </div>
        @else
        <div class="col-md-4">
            <p style="color: green;">Authorization confirmed.</p>
        </div>
        @endif
    </div>
    @endif
    @if ($sign_count == 3)
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Choose Shipper Agent</label>
                <select wire:model="said" required class="form-control" {{$sbm ? 'disabled' : ''}}>
                    <option value="">-choose-</option>
                    @foreach ($sa as $agent)
                        <option value="{{ $agent['userid'] }}">
                            {{ $agent['name'] }}</option>
                    @endforeach
                </select>
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Shipper Agent Passcode</label>
                <input type="password" wire:model="sa_code" class="form-control flatpickr-input"
                    placeholder="passcode" {{$sbm ? 'disabled' : ''}}>
            </div>
        </div>
        @if (!$sbm)
        <div class="col-md-4">
            <label for="">.</label>
            <button type="button" wire:click.prevent="sign()" {{($sa_code == null || $said == null) ? 'disabled' : ''}} class="btn btn-secondary submit-btn">I agree and sign documents</button>
            @if ($err)
            <small style="color: red;">wrong authorization credentials</small>
            @endif
        </div>
        @else
        <div class="col-md-4">
            <p style="color: green;">Authorization confirmed.</p>
        </div>
        @endif
    </div>
    @endif
    
    @if ($sbm)
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-secondary submit-btn">Save & Submit</button>
        </div>
    </div>
    @endif
</div>
