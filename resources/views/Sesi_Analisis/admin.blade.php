@extends('layouts.template')

@section("title", "Admin")

@section('content')
    <style>

    .button_buka_tutup{
        color:#000000;
    }
    .button_buka_tutup:hover{
        background:#555555;
        color:#ffffff;
    }
    .col{
        
    }
    </style>

    @php
        $status="Tutup";
    @endphp

</head>
<body>
    <div class="container px-4 py-5">
        <h1>Sesi Analisis</h1>
        <h3>Buka/Tutup Sesi Analisis</h3>
        <button class="button_buka_tutup">Buka/Tutup</button>
        Status : {{$status}}
    </div>
</body>
@endsection