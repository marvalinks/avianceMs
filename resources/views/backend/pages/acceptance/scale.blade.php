<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Scale Weight</title>
    <!-- plugins -->
    <link href="/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="/assets/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled />

    <!-- icons -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/css/override.css">
    @livewireStyles()

    <style>
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }
        .center-screen h3{
            /* font-size: 220px; */
            color: rgb(47, 76, 157);
        }
        .center-screen h3 span{
            font-size: 471.05px;
        }
        .center-screen h3 sup{
            font-size: 92.213px;
        }
        .center-screen h4{
            /* font-size: 220px; */
            color: rgb(47, 76, 157);
            font-size: 154.48px;
        }
        .lg67{
            width: 100%;
            text-align: end;
        }
        .lg67 img{
            width: 408.96px;
            height: 134.39px;
        }
    </style>

</head>
<body>
    <div class="row center-screen">
        <div class="lg67">
            <img src="/assets/images/aviance.png" alt="" height="24" />
        </div>
        @livewire('scale-tab')
        <h4>SCALE No. 2</h4>
    </div>

    <script defer src="https://pyscript.net/alpha/pyscript.js"></script>

    @livewireScripts()
    <script>
        setInterval(function() {
            Livewire.emit('weightTab')
        }, 1000);
    </script>
</body>
</html>