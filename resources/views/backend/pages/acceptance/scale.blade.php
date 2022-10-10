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
            font-size: 220px;
        }
    </style>

</head>
<body>
    <div class="row center-screen">
        @livewire('scale-tab')
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