@extends('layouts.template')

@section('title', 'Mesin')

@section('content')
<style>
    .heading{
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        padding:5px;
    }
    .nama_team{
        color:#ea435e;
    }
    .timer{
        background-color:#77dd77; /* misal waktu habis background jadi #ea435e */
         width:150px;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
    }
    .dana{
        text-align:right;
    }
</style>
    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        {{-- @php
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
        </script> --}}

        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
            
            {{--Nama Team dan Timer--}}
            <div class="row align-items-center rounded heading">
                <div class="col-9 nama_team">
                    <h1 id="namaTeam">Team</h1> 
                </div>
                <div class="col-1"><h3 id="nomorSesi">Sesi 1</h3></div>
                <div class="col-1 text-center align-self-end timer rounded-2"  style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">00:00</h4>   
                </div>
            </div>

            <div class="row spacing"></div>

            {{-- Card Dana --}}
            <div class="card-header rounded" style="background-color:#faf0dc;">
                <div class="row align-items-center">
                    <div class="col-1 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                    </svg>
                    </div>
                    <div class="col-2 label_dana">
                        <h1>Dana : </h1>
                    </div>
                    <div class="col-9 dana">
                        <h1 id="dana">TC</h1>
                    </div>
                </div>
            </div>

            <div class="row spacing"></div>

            {{--Pilihan mesin--}}
            <div class="row">
                <div class="col-2">
                    <h4>Mesin :</h4>
                </div>
                <div class="col-8">
                    <select name="mesin">
                        <option value="sorting">Sorting</option>
                        <option value="cutting">Cutting</option>
                        <option value="bending">Bending</option>
                        <option value="assembling">Assembling</option>
                        <option value="packing">Packing</option>
                        <option value="drilling">Drilling</option>
                        <option value="molding">Molding</option>
                     </select>
                </div>
            </div>

            {{-- Table Komponen --}}
            <table class="table" style="width:100%;">
                {{-- Heading --}}
                <thead class="thead">

                </thead>
                <tbody>
                    <tr>
                        <td>Level Mesin : </td>
                        <td id="levelMesin_">1</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
@endsection