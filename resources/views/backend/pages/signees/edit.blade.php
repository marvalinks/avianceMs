@extends('backend.layouts.app')

@section('name')
    Users
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.signees.edit', [$user->userid]) }}" autocomplete="off" class="row mtop-30"
                    method="post">
                    @csrf
                    <div class="col-md-12">
                        <p class="sub-header">User info</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="span-red">*</span></label>
                            <input type="text" required name="name" class="form-control flatpickr-input" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Choose passcode <span class="span-red">*</span></label>
                            <input type="text" required name="passcode" class="form-control flatpickr-input"
                                placeholder="passcode" value="{{ $user->passcode }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Signature</label>
                            <input type="file" name="signature" class="form-control flatpickr-input"
                                placeholder="Telephone">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-secondary submit-btn">Save & Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
