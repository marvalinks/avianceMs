@extends('backend.layouts.app')

@section('name')
    Acceptance
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.acceptance.create') }}" autocomplete="on" class="row mtop-30 accform"
                    method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">stationCode <span class="span-red">*</span></label>
                                <input type="text" readonly class="form-control flatpickr-input" value="{{ $code }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="sub-header">airWaybill</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">prefix <span class="span-red">*</span></label>
                                <input required type="text" name="prefix" class="form-control flatpickr-input"
                                    placeholder="prefix">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">serial <span class="span-red">*</span></label>
                                <input required type="text" name="serial" class="form-control flatpickr-input"
                                    placeholder="serial">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">originCode <span class="span-red">*</span></label>
                                <input required type="text" name="originCode" class="form-control flatpickr-input"
                                    placeholder="originCode" value="{{ $code }}">
                            </div>
                        </div>
                        <div class=" col-md-4">
                            <div class="mb-3">
                                <label class="form-label">destinationCode <span class="span-red">*</span></label>
                                <input required type="text" name="destinationCode" class="form-control flatpickr-input"
                                    placeholder="destinationCode">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">pieces</label>
                                <input required type="number" min="0" name="pieces" class="form-control flatpickr-input"
                                    placeholder="pieces">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">natureOfGoods</label>
                                <input type="text" name="natureOfGoods" class="form-control flatpickr-input"
                                    placeholder="natureOfGoods">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="sub-header">parts</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">weight(KG) <span class="span-red">*</span></label>
                                <input required type="text" name="weight" class="form-control flatpickr-input"
                                    placeholder="weight">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">volume(MC)</label>
                                <input type="text" name="volume" class="form-control flatpickr-input" placeholder="volume">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">specialHandlingCodes</label>
                                <input type="text" name="specialHandlingCodes" class="form-control flatpickr-input"
                                    placeholder="specialHandlingCodes">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">securityStatus</label>
                                <input type="text" name="securityStatus" class="form-control flatpickr-input"
                                    placeholder="securityStatus">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">x-ray</label>
                                <select required name="x-ray" id="" class="form-control">
                                    <option value="">-choose-</option>
                                    <option value="1">true</option>
                                    <option value="0">false</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">remarks</label>
                                <input type="text" name="remarks" class="form-control flatpickr-input"
                                    placeholder="remarks">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">blockedForManifesting</label>
                                <select required name="blockedForManifesting" id="" class="form-control">
                                    <option value="">-choose-</option>
                                    <option value="1">true</option>
                                    <option value="0">false</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
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
