<div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Choose Signing Agent</label>
                <select wire:model="agentid" required class="form-control" name="signee" {{$sbm ? 'disabled' : ''}}>
                    <option value="">-choose-</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->userid }}">
                            {{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Agent Passcode</label>
                <input type="password" wire:model="passcode" class="form-control flatpickr-input"
                    placeholder="passcode" {{$sbm ? 'disabled' : ''}}>
            </div>
        </div>
        @if (!$sbm)
        <div class="col-md-4">
            <label for="">.</label>
            <button type="button" wire:click.prevent="sign()" {{($passcode == null || $agentid == null) ? 'disabled' : ''}} class="btn btn-secondary submit-btn">I agree and sign documents</button>
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
