<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Aviance | Open Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>
        /* canvas{
            width: 500px;
            height: 400px;
        } */
    </style>

</head>
<body>
    <div class="container">
        <section class="bg-light py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="display-5 font-weight-bold mb-5">Open Jobs</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div id="airlineRepPad" class="kbw-signature"></div>
                        <button id="clear1" class="btn clearbtn">clear</button>
                        <textarea name="airline_rep_signature" id="airline_rep_signature" class="form-control" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    

    <script type="text/javascript">
        var signaturePad1 = $('#airlineRepPad').signature({syncField: '#airline_rep_signature', syncFormat: 'PNG'});
        // var signaturePad2 = $('#trcRepPad').signature({syncField: '#trc_signature', syncFormat: 'PNG'});
        $('#clear1').click(function(e) {
            e.preventDefault();
            signaturePad1.signature('clear');
            $("#airline_rep_signature").val('');
        });
        // $('#clear2').click(function(e) {
        //     e.preventDefault();
        //     signaturePad2.signature('clear');
        //     $("#trc_signature").val('');
        // });
    </script>
</body>
</html>