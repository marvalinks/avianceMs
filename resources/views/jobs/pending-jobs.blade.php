<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aviance | Pending Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <section class="bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="display-5 font-weight-bold mb-5">Pending Jobs</h2>
                    </div>
                </div>
                <div class="row">
                    @forelse ($bills as $bill)
                    <div class="col-md-6 col-xl-4">
                        <div class="image-box image-box--shadowed white-bg style-2 mb-4" style="background: #baba92;padding: 15px;">
                            <div class="overlay-container">
                                <h2>CODE: {{$bill['code']}}</h2>
                                <hr>
                            </div>
                            <div class="body">
                                <h5 class="font-weight-bold my-2">AWB: {{$bill['airWaybill']}}</h5>
                                <hr>
                                <h5 class="font-weight-bold my-2">DEST: {{strtoupper($bill['destination'])}}</h5>
                                <hr>
                                <h5 class="font-weight-bold my-2">PCS: {{number_format($bill['pieces'], 1)}}</h5>
                                <hr>
                                <h5 class="font-weight-bold my-2">WEIGHT: {{number_format($bill['weight'], 1)}} KG</h5>
                                <hr>
                                <h5 class="font-weight-bold my-2">Av AGENT: {{$bill['author_name']}}</h5>
                                <hr>
                                <p class="small">{{ \Carbon\Carbon::parse($bill['created_at'])->toFormattedDateString() }}</p>
                                <div class="row d-flex align-items-center">
                                    <div class="col-6">
                                        
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{route('open.jobs', [$bill['airWaybill']])}}" class="btn radius-50 btn-gray-transparent btn-animated">Open Job <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p>No pending jobs</p>
                    @endforelse
                    
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>