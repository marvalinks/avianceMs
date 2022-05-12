@extends('backend.layouts.app')

@section('name')
    Signees
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.signees.create') }}" autocomplete="on" enctype="multipart/form-data" class="row mtop-30" method="post">
                    @csrf
                    <div class="col-md-12">
                        <p class="sub-header">Signee info</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Name <span class="span-red">*</span></label>
                            <input type="text" required name="name" class="form-control flatpickr-input" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Choose passcode <span class="span-red">*</span></label>
                            <input type="text" required name="passcode" class="form-control flatpickr-input"
                                placeholder="passcode" value="{{ mt_rand(1111, 99999) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Signature <span class="span-red">*</span></label>
                            <input type="file" required name="signature" class="form-control flatpickr-input"
                                placeholder="Signature">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Staff no <span class="span-red">*</span></label>
                            <input type="text" name="staff_no" class="form-control flatpickr-input"
                                placeholder="Staff no">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Designation <span class="span-red">*</span></label>
                            <select required name="roleid" id="" class="form-control">
                                <option value="">-choose-</option>
                                <option value="1">Aviance Agent</option>
                                <option value="2">Aviance Security Agent</option>
                                <option value="3">Shipping Agent</option>
                            </select>
                        </div>
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
