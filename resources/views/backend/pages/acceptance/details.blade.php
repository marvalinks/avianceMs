@extends('backend.layouts.app')

@section('name')
    Acceptance
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="#" autocomplete="on" class="row mtop-30">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">stationCode <span class="span-red">*</span></label>
                                <input type="text" readonly class="form-control flatpickr-input"
                                    value="{{ $bill->airWaybill->origin->code }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="sub-header">airWaybill</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">prefix <span class="span-red">*</span></label>
                                <input type="text" name="prefix" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->prefix ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">serial <span class="span-red">*</span></label>
                                <input type="text" name="serial" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->serial ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">originCode <span class="span-red">*</span></label>
                                <input type="text" name="originCode" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->origin->code ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">destinationCode <span class="span-red">*</span></label>
                                <input type="text" name="destinationCode" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->destination->code ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">pieces</label>
                                <input type="number" min="0" name="pieces" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->pieces ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">natureOfGoods</label>
                                <input type="text" name="natureOfGoods" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->natureOfGoods ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="sub-header">parts</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">weight(KG) <span class="span-red">*</span></label>
                                <input type="text" name="weight" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->weight->amount ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">volume(MC) <span class="span-red">*</span></label>
                                <input type="text" name="volume" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->volume->amount ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">securityStatus</label>
                                <input type="text" name="securityStatus" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->securityStatus ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">remarks</label>
                                <input type="text" name="remarks" class="form-control flatpickr-input" readonly
                                    value="{{ $bill->airWaybill->remarks ?? 'NA' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">blockedForManifesting</label>
                                <input type="text" name="blockedForManifesting" class="form-control flatpickr-input"
                                    readonly value="{{ $bill->airWaybill->blockedForManifesting ?? 'NA' }}">
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
