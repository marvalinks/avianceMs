@extends('backend.layouts.app')

@section('name')
    Acceptance
@endsection
@section('links')
    @livewireStyles()
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .bbtt {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .select2-container .select2-selection--single {
            height: calc(1.5em + 0.9rem + 2px) !important;
        }

        .spinner-grow {
            opacity: 1 !important;
            animation: none !important;
        }

    </style>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
    <script defer src="https://pyscript.net/alpha/pyscript.js"></script>

    @livewireScripts()
    <script>
        setInterval(function() {
            Livewire.emit('readWeight')
        }, 1000);
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.acceptance.create') }}" autocomplete="on" class="row mtop-30 accform"
                    method="post">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="clred">{{$error}}</div>
                    @endforeach
                    @endif
                    @csrf
                    <div class="row">
                        <div class="row">
                            @livewire('weight-reading')
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">stationCode <span class="span-red">*</span></label>
                                <input type="text" readonly class="form-control flatpickr-input"
                                    value="{{ $code }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <py-script>
import random


def w2():

    list1 = [1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000]
    print(random.choice(list1))
    
    

w2()
                            </py-script>
                            <p class="sub-header">airWaybill</p>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">prefix <span class="span-red">*</span></label>
                                <select class="form-control js-example-basic-multiple" name="prefix">
                                    <option value="">-choose-</option>
                                    @foreach ($airlines as $airline)
                                        <option value="{{ $airline['prefix'] }}">
                                            [{{ $airline['prefix'] }}] {{ $airline['airline'] }}</option>
                                    @endforeach
                                </select>
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
                                <input required type="text" readonly name="originCode" class="form-control flatpickr-input"
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
                                <label class="form-label">volume(MC)</label>
                                <input type="text" name="volume" class="form-control flatpickr-input" placeholder="volume">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">specialHandlingCodes</label>
                                <select class="form-control js-example-basic-multiple" name="specialHandlingCodes[]"
                                    multiple="multiple">
                                    @foreach ($handling_codes as $handling_code)
                                        <option value="{{ $handling_code['code'] }}">
                                            {{ $handling_code['code'] }}</option>
                                    @endforeach
                                </select>
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
                    @livewire('accept-form-inputs')
                </form>

            </div>
        </div>
    </div>
@endsection
