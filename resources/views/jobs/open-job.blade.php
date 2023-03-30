@extends('backend.layouts.j2')

@section('links')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
@endsection
@section('scripts')
<script type="text/javascript">
    var signaturePad1 = $('#shipperAgentPad').signature({syncField: '#shipper_agent_sign', syncFormat: 'PNG'});
    var signaturePad2 = $('#avianceSecurityPad').signature({syncField: '#aviance_security_sign', syncFormat: 'PNG'});
    var signaturePad3 = $('#avianceAgentPad').signature({syncField: '#aviance_agent_sign', syncFormat: 'PNG'});
    $('#clear1').click(function(e) {
        e.preventDefault();
        signaturePad1.signature('clear');
        $("#shipper_agent_sign").val('');
    });
    $('#clear2').click(function(e) {
        e.preventDefault();
        signaturePad2.signature('clear');
        $("#aviance_security_sign").val('');
    });
    $('#clear3').click(function(e) {
        e.preventDefault();
        signaturePad3.signature('clear');
        $("#aviance_agent_sign").val('');
    });
</script>
@endsection

@section('content')
<div class="container">
    <form class="row" action="{{route('open.jobs', [$bill['airWaybill']])}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row fmy7" style="margin-top: 20px;">
            <div class="col-md-12" style="margin-bottom: 30px;">
                <h3>Details:</h3>
                <hr>
                <h5 class="font-weight-bold my-2"><span>Code: {{$bill['code']}}</span></h5>
                <hr>
                <h5 class="font-weight-bold my-2"><span>AWB: {{$bill['airWaybill']}}</span></h5>
                <hr>
                <h5 class="font-weight-bold my-2"><span>DEST: {{strtoupper($bill['destination'])}}</span></h5>
                <hr>
                <h5 class="font-weight-bold my-2"><span>PCS: {{number_format($bill['pieces'], 1)}}</span></h5>
                <hr>
                <h5 class="font-weight-bold my-2"><span>WEIGHT: {{number_format($bill['weight'], 1)}} KG</span></h5>
                <hr>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h3>Shipper Agent</h3>
                    <div class="row">
                        <label for="">Shipper Agent Name</label>
                        <input type="text" name="shipper_agent" class="form-control" required>
                    </div>
                    <div class="row">
                        <label for="">Shipper Agent Signature</label>
                        <div id="shipperAgentPad"></div>
                        <button id="clear1" class="btn clearbtn">clear</button>
                        <textarea name="shipper_agent_sign" required id="shipper_agent_sign" class="form-control" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h3>Aviance Security</h3>
                    <div class="row">
                        <label for="">Aviance Security</label>
                        <input type="text" name="aviance_security" class="form-control" required>
                    </div>
                    <div class="row">
                        <label for="">Aviance Security Signature</label>
                        <div id="avianceSecurityPad"></div>
                        <button id="clear2" class="btn clearbtn">clear</button>
                        <textarea name="aviance_security_sign" required id="aviance_security_sign" class="form-control" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <h3>Aviance Agent</h3>
                    <div class="row">
                        <label for="">Aviance Agent</label>
                        <input type="text" name="aviance_agent" class="form-control" required>
                    </div>
                    <div class="row">
                        <label for="">Aviance Agent Signature</label>
                        <div id="avianceAgentPad"></div>
                        <button id="clear3" class="btn clearbtn">clear</button>
                        <textarea name="aviance_agent_sign" required id="aviance_agent_sign" class="form-control" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 8%;">
            <button type="submit" class="btn btn-success submit67">Submit</button>
        </div>
    </form>
</div>
@endsection