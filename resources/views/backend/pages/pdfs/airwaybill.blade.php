@extends('backend.layouts.pdf')


@section('links')
<style>
    .u90 h2{
        text-align: center;
        font-size: 18px;
        margin-bottom: 24px;
        text-transform: uppercase;
    }
    .u90 span.e4{
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
    }
    .u90 h6{
        font-size: 15px;
        margin-top: 24px;
    }
    #main-content{
        width: 85%;
        margin: auto;
    }
    .p56{
        /* display: flex;
        display: -webkit-flex; */
        display: -webkit-box;
        flex-direction: row;
        justify-content: space-between;
        -webkit-flex-direction: row;
        -webkit-justify-content: space-between;
    }
    .p56.row{
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
        margin-right: 10%;
    }
    .w50{
        width: 50%;
    }
    .table th, .table td {
        padding: 3px!important;
        font-size: 11px;
        border: 1px solid #000!important;
    }
    .tright{
        text-align: right;
    }
    tfoot{
        font-weight: 700;
    }
    .mb100{
        margin-bottom: 100px;
    }
    .row {
        display: -webkit-box;
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
    }

    .row>div {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
    }

    .row>div:last-child {
        margin-right: 0;
    }
    .op1{
        display: -webkit-flex;
        border: 1px solid #000000;
        margin-top: 30px;
        
    }
    .bright{
        border-right: 1px solid #000;
    }
    .bleft{
        border-left: 1px solid #000;
    }
    .op2{
        display: -webkit-box;
        display: flex;
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
        border-left: 1px solid #000;
    }
    .dflex{
        /* display: -webkit-box;
        display: flex;
        align-items: center; */
        display: -webkit-box;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .o9p input{
        height: 30px;
        margin-left: 10px
    }
    .op3{
        display: -webkit-box;
        display: flex;
        border-top: 1px solid #000;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .op4{
        justify-content: flex-start;
        margin-bottom: 10px;
    }
    .tbtb th,
    .r4r4{
        font-size: 16px!important;
    }
    .tbtb td{
        height: 24px;
        font-size: 13px;
        font-weight: 500;
    }
    .mb15{
        margin-bottom: 15px;
    }
    .mtop20{
        margin-top: 20px;
    }
    .gstrong{
        font-weight: 800!important;
    }
    .signn{
        width: 100px;
        height: 40px;
        object-fit: contain;
    }
    .tdeco{
        text-decoration: underline;
        text-decoration-style: dashed;
        text-decoration-thickness: 2px;
    }
</style>
@endsection



@section('content')

    <div class="row op1 p56">
        <div class="span6 bright">
            <img style="float: left;" src="http://159.223.238.21/assets/images/aviance.png" />
        </div>
        <div class="span6 dflex">
            <h4 class="gstrong">Cargo Operations Department</h4>
        </div>
        <div class="span6 bleft">
            <ul>
                <li><b>From No.: </b> AVIACGO57</li>
                <li><b>Issue 1 Rev 2:</b></li>
                <li><b>Is. Date: </b> {{\Carbon\Carbon::parse(date('d-m-Y'))->toFormattedDateString()}}</li>
            </ul>
        </div>
    </div>
    <div class="row p56 op2">
        <h4 class="gstrong">CARGO ACCEPTANCE PRE-WEIGH FORM</h4>
    </div>
    <div class="row p56 dflex o9p" style="margin-top: 10px;">
        <div class="span6 dflex">
            <h4>Date:</h4>
            <input type="text" style="width: 150px;" value="{{\Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString()}}">
        </div>
        <div class="span6 dflex">
            <h4>Flight No.:</h4>
            <input type="text" style="width: 150px;" value="{{$bill['flight_no' ?? 'N/A']}}">
        </div>
        <div class="span6 dflex">
            <h4>Sheet.:</h4>
            <input type="text" style="width: 150px;" id="">
        </div>
    </div>
    <div class="row p56 op3">
        <h4 class="gstrong">Note: Scale print outs MUST be attached to this form</h4>
    </div>
    <div class="row p56 dflex o9p op4">
        <div class="span6 dflex" style="width: 100%;">
            <h4>Airwaybill No::</h4>
            <input type="text" name="" id="" style="width: 600px;" value="{{$bill['airWaybill']}}">
        </div>
    </div>
    


    <div class="row p56">
        <table class="table table-bordered table-hover tbtb">
            <thead>
                <tr>
                    <th style="width: 345px;">ULD Number.</th>
                    <th style="width: 40px;">Unit Weight</th>
                    <th style="width: 70px;">Total No. of Pcs</th>
                    <th style="width: 110px;">Total Gross Scale Weight.</th>
                    <th style="width: 110px;">Tare Weight</th>
                    <th style="width: 110px;">Net Weight</th>
                    <th style="width: 90px;">Scale Print</th>

                </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr>
                    <td>{{$bill['uld_option']}}</td>
                    <td>kg</td>
                    <td>{{$bill['pieces']}}</td>
                    <td>{{number_format($bill['weight'], 2)}}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{number_format($bill['weight'], 2)}}</td>
                </tr>
            </tbody>
            <tfoot>
                @for ($i=0; $i< 5; $i++)
                    
                <tr class="gradeX even">
                    @for ($j=0; $j< 7; $j++)
                    <td>{{$j == 1 ? 'kg' : ''}}</td>
                    @endfor
                </tr>
                @endfor
                
            </tfoot>
            
        </table>
        
    </div>
    <div class="row p56">
        <table class="table table-bordered table-hover tbtb">
            <thead>
                <tr>
                    <th>Length (cm)</th>
                    <th>Width (cm)</th>
                    <th>Height (cm)</th>
                    <th>Volume (&#13221;)</th>

                </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
                @for ($i=0; $i< 2; $i++)
                    
                <tr class="gradeX even">
                    @for ($j=0; $j< 4; $j++)
                    <td></td>
                    @endfor
                </tr>
                @endfor
                <tr>
                    <td></td>
                    <td></td>
                    <td class="r4r4 gstrong">Total Volume (&#13221;)</td>
                    <td class="r4r4 gstrong"></td>
                </tr>
            </tbody>
            
            
        </table>
    </div>
    <div class="row p56 dflex">
        <h4 class="gstrong">Calculation - Length (cm) x Width (cm) x Height (cm) &#247; 1,000,000 = &#13221;</h4>
    </div>
    <div class="row p56">
        <p>I, the undersigned confirm that the cargo built into the ULD's listed above have been checked weighed on calibrated scales and recorded.</p>
    </div>
    <div class="row p56 dflex mtop20">
        <div class="span6 w50">
            <ul style="list-style-type: none;">
                <li class="dflex mb15">
                    <p class="gstrong">Aviance Agent Name: </p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['agent']['name']}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Signature: </p>&nbsp;&nbsp;&nbsp;
                    <span><img class="signn" src="{{$bill['agent']['signature']}}" alt=""></span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Staff No. :</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['agent']['staff_no'] ?? ''}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Date: </p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{\Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString()}}</span>
                </li>
            </ul>
        </div>
        <div class="span6 w50">
            <ul style="list-style-type: none;">
                <li class="dflex mb15">
                    <p class="gstrong">Aviance Security Agent Name</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['security']['name']}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Signature</p>&nbsp;&nbsp;&nbsp;
                    <span><img class="signn" src="{{$bill['security']['signature']}}" alt=""></span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Staff No.</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['security']['staff_no'] ?? ''}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Date</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{\Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString()}}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row p56 dflex mtop20" style="justify-content: left; margin-top: 50px;">
        <div class="span6 w50">
            <ul style="list-style-type: none;">
                <li class="dflex mb15">
                    <p class="gstrong">Shipping Agent Name</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['shipper']['name']}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Signature</p>&nbsp;&nbsp;&nbsp;
                    <span><img class="signn" src="{{$bill['shipper']['signature']}}" alt=""></span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Staff No.</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{$bill['shipper']['staff_no'] ?? ''}}</span>
                </li>
                <li class="dflex mb15">
                    <p class="gstrong">Date</p>&nbsp;&nbsp;&nbsp;
                    <span class="tdeco">{{\Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString()}}</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="row p56 dflex mtop20" style="margin-bottom: 20px;">
        <p class="gstrong">The completed form must be passed to the Cargo Duty Manager upon completion.</p>
    </div>

@endsection