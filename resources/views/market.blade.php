@extends('layouts.app')

@section("title", "IG Markets")

@section('content')
<style>
    .spacing{
        margin:15px;
        padding:10px;
    }
    .heading{
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        padding:5px;
        color:#ea435e;
    }
    .nama_team{
        
    }
    .timer{
        background-color:#77dd77; /* misal waktu habis background jadi #ea435e */
        width:150px;
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        color:#000000;
    }
    .form-control{
        width:200px;
    }
    .popup_pembelian{
        
    }

</style>
@php
    $namaTeam="apapun namanya";
    $nomorSesi=1;
    $timer="00:00";
    $biayaPengiriman= 1500;
    $totalPembelian=1500;
@endphp

<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

        {{--Nama Team dan Timer--}}
        <div class="row align-items-center rounded heading">
            <div class="col-9 nama_team">
                <h1>Team {{$namaTeam}}</h1> 
            </div>
            <div class="col-1"><h3>Sesi {{$nomorSesi}}</h3></div>
            <div class="col-1 text-center align-self-end timer rounded-2"  style="font-family:TT Norms Regular;">
                <h3>Timer</h3>
                <h4>{{$timer}}</h4>   
            </div>
        </div>

        <div class="row spacing"></div>

        {{--market table--}}
        <table class="table table-bordered" style="vertical-align: middle;">
            <thead class="thead">
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Bahan Baku</th>
                    <th scope="col">Isi/Paket</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga Paket</th>
                    <th scope="col" style="width:250px;">Pembelian per paket</th>
                    <th scope="col">Sub-Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Steel</td>
                    <td>10</td>
                    <td>300</td>
                    <td>150</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Iron</td>
                    <td>10</td>
                    <td>600</td>
                    <td>150</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Aluminum Alloy</td>
                    <td>10</td>
                    <td>600</td>
                    <td>150</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>ABS Plastic</td>
                    <td>7</td>
                    <td>500</td>
                    <td>90</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>PP Plastic</td>
                    <td>4</td>
                    <td>500</td>
                    <td>60</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">6</th>
                    <td>PC Plastic</td>
                    <td>4</td>
                    <td>500</td>
                    <td>60</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">7</th>
                    <td>SBR Rubber</td>
                    <td>10</td>
                    <td>300</td>
                    <td>120</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">8</th>
                    <td>PU Rubber</td>
                    <td>4</td>
                    <td>1000</td>
                    <td>80</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">9</th>
                    <td>NBR Rubber</td>
                    <td>5</td>
                    <td>600</td>
                    <td>80</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">10</th>
                    <td>Silicone</td>
                    <td>4</td>
                    <td>600</td>
                    <td>80</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">11</th>
                    <td>Acrylic</td>
                    <td>4</td>
                    <td>600</td>
                    <td>80</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">12</th>
                    <td>Cable</td>
                    <td>4</td>
                    <td>500</td>
                    <td>60</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">13</th>
                    <td>EVA Glue</td>
                    <td>4</td>
                    <td>600</td>
                    <td>80</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <th scope="row">14</th>
                    <td>PVA Glue</td>
                    <td>4</td>
                    <td>600</td>
                    <td>60</td>
                    <td><input class="form-control" type="text" placeholder=0></td>
                    <td>0 TC</td>
                </tr>
                <tr>
                    <td colspan="6">Biaya Pengiriman:</td>
                    <td>{{$biayaPengiriman}} TC</td>
                </tr>
                <tr>
                    <td colspan="6">Total Pembelian:</td>
                    {{--button konfirmasi show pop up--}}
                    <td>{{$totalPembelian}} TC <br><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Konfirmasi</button></td>
                </tr>
            </tbody>
        </table>

        {{--Pop Up Konfirmasi--}}
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{--button konfirmasi akhir--}}
                <button type="button" class="btn btn-success" id="konfirmasi_pembelian">Konfirmasi</button>
            </div>
            </div>
        </div>
        </div>

    </div>
</body>
@endsection
