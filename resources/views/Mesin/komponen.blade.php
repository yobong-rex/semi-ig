@extends('layouts.template')

@section('title', 'Mesin')

@section('content')

    <body>
        @php
            $a = 1;
            $b = 1;
            $c = 1;
            $d = 1;
            
            $level = 1;
            $a_defect = -1;
            $b_defect = -1;
            $c_defect = -1;
            $d_defect = -1;
            
            // Check Level
            if ($a == 10 && $b == 10 && $c == 10 && $d == 10) {
                $level = 6;
            } elseif ($a >= 8 && $b >= 8 && $c >= 8 && $d >= 8) {
                $level = 5;
            } elseif ($a >= 6 && $b >= 6 && $c >= 6 && $d >= 6) {
                $level = 4;
            } elseif ($a >= 4 && $b >= 4 && $c >= 4 && $d >= 4) {
                $level = 3;
            } elseif ($a >= 2 && $b >= 2 && $c >= 2 && $d >= 2) {
                $level = 2;
            }
            
            // Check defect component A
            if ($a > 7) {
                $a_defect = -3;
            } elseif ($a > 3) {
                $a_defect = -2;
            }
            
            // Check defect component B
            if ($b > 7) {
                $b_defect = -3;
            } elseif ($b > 3) {
                $b_defect = -2;
            }
            
            // Check defect component C
            if ($c > 7) {
                $c_defect = -3;
            } elseif ($c > 3) {
                $c_defect = -2;
            }
            
            // Check defect component D
            if ($d > 7) {
                $d_defect = -3;
            } elseif ($d > 3) {
                $d_defect = -2;
            }
        @endphp
        <p> Level = {{ $level }} </p>
        <p id="a"> Level_a = {{ $a }} || Defect A = {{ $a_defect }} </p>
        <p id="b"> Level_b = {{ $b }} || Defect B = {{ $b_defect }}</p>
        <p id="c"> Level_c = {{ $c }} || Defect C = {{ $c_defect }}</p>
        <p id="d"> Level_d = {{ $d }} || Defect D = {{ $d_defect }}</p>
        <button onclick="upgrade_a()">Upgrade Komponen A</button><br>
        <button onclick="upgrade_b()">Upgrade Komponen B</button><br>
        <button onclick="upgrade_c()">Upgrade Komponen C</button><br>
        <button onclick="upgrade_d()">Upgrade Komponen D</button><br>
        <script>
            function upgrade_a() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('upgrade') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function() {
                        
                    },
                    error: function(){
                        alert('error');
                    }
                });
            }
        </script>
    </body>
@endsection
