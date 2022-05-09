@extends('backend.layouts.app')

@section('name')
    Signees
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.configurations.create') }}" autocomplete="on" class="row mtop-30" method="post">
                    @csrf
                    <div class="col-md-12">
                        <p class="sub-header">Configuration info</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Station Code <span class="span-red">*</span></label>
                            <input type="text" required name="stationCode" class="form-control flatpickr-input" placeholder="Station Code" value="{{$configurations->stationCode ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">API Key <span class="span-red">*</span></label>
                            <input type="text" required name="apiKey" class="form-control flatpickr-input" placeholder="API Key" value="{{$configurations->apiKey ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">API Path <span class="span-red">*</span></label>
                            <input type="text" required name="apiPath" class="form-control flatpickr-input" placeholder="API Path" value="{{$configurations->apiPath ?? ''}}">
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
