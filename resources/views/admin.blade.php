@extends('layouts.app')

@section("title", "Announcements")

@section('content')
    <style>
    .row{
        background-color:#faf0dc;
    }
    .button_buka_tutup{
        color:#000000;
    }
    .button_buka_tutup:hover{
        background:#555555;
        color:#ffffff;
    }
    </style>

    @php
        
    @endphp

</head>
<body>
    <div class="container px-4 py-5">
        <h1>Sesi Analisis</h1>
        <div class="row">
            <div class="col">
                <h3>Buka/Tutup Sesi Analisis</h3>
            </div>
            <div class="col">
                <button class="button_buka_tutup">Buka/Tutup</button>
            </div>

        </div>
    </div>
</body>
@endsection