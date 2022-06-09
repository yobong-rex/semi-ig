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
    .spacing{
        margin:15px;
        padding:10px;
    }
    .nomor{
        width:50px;
        text-align:center;
    }
    .penomoran{
        width:110px;
        text-align: center;
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

            {{--Coba--}}
            <button type="button" class="btn btn-success" id="coba" onclick="coba_konfirmasi()">Coba</button>
            <p id="coba-text"></p> 
        </form>
    </div>

    <div class="row"> 
        {{--Card Inventory--}} 
        <div class="col">
            <div class="card-body rounded text-center kartu_Home">
                <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="auto" fill="currentColor" class="bi bi-safe" viewBox="0 0 16 16">
<path d="M1 1.5A1.5 1.5 0 0 1 2.5 0h12A1.5 1.5 0 0 1 16 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 1 14.5V13H.5a.5.5 0 0 1 0-1H1V8.5H.5a.5.5 0 0 1 0-1H1V4H.5a.5.5 0 0 1 0-1H1V1.5zM2.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-12z"/>
<path d="M13.5 6a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zM4.828 4.464a.5.5 0 0 1 .708 0l1.09 1.09a3.003 3.003 0 0 1 3.476 0l1.09-1.09a.5.5 0 1 1 .707.708l-1.09 1.09c.74 1.037.74 2.44 0 3.476l1.09 1.09a.5.5 0 1 1-.707.708l-1.09-1.09a3.002 3.002 0 0 1-3.476 0l-1.09 1.09a.5.5 0 1 1-.708-.708l1.09-1.09a3.003 3.003 0 0 1 0-3.476l-1.09-1.09a.5.5 0 0 1 0-.708zM6.95 6.586a2 2 0 1 0 2.828 2.828A2 2 0 0 0 6.95 6.586z"/>
</svg>
                </div>
                <div class="col">
                    <h2>Sisa Inventory</h2>
                </div>
                <div class="col">
                    <h3 id="sisaInventory">0</h3>
                </div>
            </div>
        </div>

        {{--Card Demand--}}
        <div class="col">
            <div class="card-body rounded text-center kartu_Home">
                <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
<path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
</svg>
                </div>
                <div class="col">
                    <h2>Demand Terpenuhi</h2>
                </div>
                <div class="col">
                    <h3 id="demandTerpenuhi">0</h3>
                </div>
            </div>
        </div>

        {{--Card Customer--}}
        <div class="col">
            <div class="card-body rounded text-center kartu_Home">
                <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
</svg>
                </div>
                <div class="col">
                    <h2>Customer Value</h2>
                </div>
                <div class="col">
                    <h3 id="customerValue">0</h3>
                </div>
            </div>
        </div>

    </div>
</body>
@endsection