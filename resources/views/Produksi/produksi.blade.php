@extends('layouts.app')

@section("title", "Dashboard")

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
    
    .nomor{
        width:50px;
        text-align:center;
    }
    .penomoran{
        width:110px;
        text-align: center;
    }
    .kartu_Home{
            background-color:#faf0dc;
            box-shadow: 0 6px 10px rgba(0,0,0,.08);
        }
</style>

@php
    $sesi=1;
    $dana=10000;
    $namaTeam="apapun namanya";
    $nomorSesi=1; 
    $timer="00:00";
@endphp

{{-- DOKUMENTASI ID --}}
{{-- 
    namaTeam : nama masing-masing team 
    timer : string timer
    dana : dana masing-masing team
    nomorSesi : nomor sesi
    cycleTime : cycle time
    totalDefect : jumlah akhir defect
    --}}

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

        {{--Nama Team dan Timer--}}
        <div class="row align-items-center rounded heading">
            <div class="col-9 nama_team">
                <h1 id="namaTeam">Team {{$namaTeam}}</h1> 
            </div>
            <div class="col-1"><h3 id="nomorSesi">Sesi {{$nomorSesi}}</h3></div>
            <div class="col-1 text-center align-self-end timer rounded-2"  style="font-family:TT Norms Regular;">
                <h3>Timer</h3>
                <h4 id="timer">{{$timer}}</h4>   
            </div>
        </div>
        <div class="row spacing"></div>

        <h1>Produksi</h1>
        {{--Form produksi--}}
        <form action="">
            <table class="table table-bordered" style="vertical-align: middle;">
                <thead class="thead">
                    <tr>
                        <th scope="col"> </th>
                        <th scope="col" colspan="9" style="text-align:center;">Urutan Produksi Produk</th>
                        <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;">Konfirmasi</th>
                    </tr>
                    <tr>
                        <th class="nomor" scope="col">Nomor</th>
                        @for ($i=1;$i<=9;$i++)
                        <th class="penomoran" scope="col">{{$i}}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    {{-- id proses_(prosesId) --}}
                    @for($i=1;$i<=3;$i++)
                    <tr id="tr_{{$i}}">
                        <th class="nomor" scope="row">Proses Produksi {{$i}}</th>
                        @for($j=1;$j<=9;$j++)
                        <td>
                            <select name="proses" id="proses_{{$i}}_{{$j}}">
                                <option value="">-Select-</option>
                                <option value="sorting">Sorting</option>
                                <option value="cutting">Cutting</option>
                                <option value="bending">Bending</option>
                                <option value="assembling">Assembling</option>
                                <option value="packing">Packing</option>
                                <option value="drilling">Drilling</option>
                                <option value="molding">Molding</option>
                            </select>
                        </td>
                        @endfor
                        <td><button class="btn btn-success" id="button_{{$i}}" onclick="konfirmasi($i, length)">Konfirmasi</button></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </form>

        <div class="row spacing"></div>

        {{--Kartu bawah--}}
        <div class="row"> 
            {{--Card Cycle Time--}} 
            <div class="col">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                          </svg>
                    </div>
                    <div class="col">
                        <h2>Cycle Time</h2>
                    </div>
                    <div class="col">
                        <h3 id="cycleTime">00:00</h3>
                    </div>
                </div>
            </div>
    
            {{--Card Defect--}}
            <div class="col">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                          </svg>
                    </div>
                    <div class="col">
                        <h2>Jumlah Defect</h2>
                    </div>
                    <div class="col">
                        <h3 id="totalDefect">0</h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
@endsection