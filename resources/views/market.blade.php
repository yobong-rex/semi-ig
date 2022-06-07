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
    .dana{
            text-align:right;
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
    .nomor_bahan{
            width:50px;
            text-align:center;
        }

</style>
@php
    $namaTeam="apapun namanya";
    $nomorSesi=1;
    $dana=10000;
    $timer="00:00";
    $biayaPengiriman= 1500;
    $totalPembelian=1500;
@endphp

{{-- DOKUMENTASI ID --}}
{{-- 
    namaTeam : nama masing-masing team 
    timer : string timer
    nomorSesi : nomor sesi
    dana : dana masing-masing team
    stok_{nomor bahan} : stok tiap bahan
    harga_{nomor bahan} : harga per paket tiap bahan
    input_{nomor bahan} : textbox input pembelian tiap bahan
    subtotal_{nomor bahan} : harga * input tiap bahan
    biaya_pengiriman : biaya pengiriman keseluruhan
    total : total pembelian semua bahan
    button_PopupModal : button untuk menampilkan modal konfirmasi
    konfirmasi_pembelian : button konfirmasi pembelian
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

        <div class="row-12">
            {{--Card Dana--}}
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
                        <h1 id="dana">{{number_format($dana)}} TC</h1>
                    </div>
                </div>
            </div>

        <div class="row spacing"></div>

        {{--market table--}}
        <table class="table table-bordered" style="vertical-align: middle;">
            <thead class="thead">
                <tr>
                    <th class="nomor_bahan" scope="col">No.</th>
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
                    <th class="nomor_bahan" scope="row">1</th>
                    <td>Steel</td>
                    <td>10</td>
                    <td id="stok_1">300</td>
                    <td id="harga_1">150</td>
                    <td><input class="form-control" id="input_1" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_1">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">2</th>
                    <td>Iron</td>
                    <td>10</td>
                    <td id="stok_2">600</td>
                    <td id="harga_2">150</td>
                    <td><input class="form-control" id="input_2" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_2">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">3</th>
                    <td>Aluminum Alloy</td>
                    <td>10</td>
                    <td id="stok_3">600</td>
                    <td id="harga_3">150</td>
                    <td><input class="form-control" id="input_3" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_3">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">4</th>
                    <td>ABS Plastic</td>
                    <td>7</td>
                    <td id="stok_4">500</td>
                    <td id="harga_4">90</td>
                    <td><input class="form-control" id="input_4" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_4">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">5</th>
                    <td>PP Plastic</td>
                    <td>4</td>
                    <td id="stok_5">500</td>
                    <td id="harga_5">60</td>
                    <td><input class="form-control" id="input_5" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_5">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">6</th>
                    <td>PC Plastic</td>
                    <td>4</td>
                    <td id="stok_6">500</td>
                    <td id="harga_6">60</td>
                    <td><input class="form-control" id="input_6" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_6">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="number">7</th>
                    <td>SBR Rubber</td>
                    <td>10</td>
                    <td id="stok_7">300</td>
                    <td id="harga_7">120</td>
                    <td><input class="form-control" id="input_7" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_7">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">8</th>
                    <td>PU Rubber</td>
                    <td>4</td>
                    <td id="stok_8">1000</td>
                    <td id="harga_8">80</td>
                    <td><input class="form-control" id="input_8" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_8">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">9</th>
                    <td>NBR Rubber</td>
                    <td>5</td>
                    <td id="stok_9">600</td>
                    <td id="harga_9">80</td>
                    <td><input class="form-control" id="input_9" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_9">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">10</th>
                    <td>Silicone</td>
                    <td>4</td>
                    <td id="stok_10">600</td>
                    <td id="harga_10">80</td>
                    <td><input class="form-control" id="input_10" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_10">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">11</th>
                    <td>Acrylic</td>
                    <td>4</td>
                    <td id="stok_11">600</td>
                    <td id="harga_11">80</td>
                    <td><input class="form-control" id="input_11" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_11">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">12</th>
                    <td>Cable</td>
                    <td>4</td>
                    <td id="stok_12">500</td>
                    <td id="harga_12">60</td>
                    <td><input class="form-control" id="input_12" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_12">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">13</th>
                    <td>EVA Glue</td>
                    <td>4</td>
                    <td id="stok_13">600</td>
                    <td id="harga_13">80</td>
                    <td><input class="form-control" id="input_13" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_13">0 TC</td>
                </tr>
                <tr>
                    <th class="nomor_bahan" scope="row">14</th>
                    <td>PVA Glue</td>
                    <td>4</td>
                    <td id="stok_14">600</td>
                    <td id="harga_14">60</td>
                    <td><input class="form-control" id="input_14" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td id="subtotal_14">0 TC</td>
                </tr>
                <tr>
                    <td colspan="6">Biaya Pengiriman:</td>
                    <td id="biaya_pengiriman">{{$biayaPengiriman}} TC</td>
                </tr>
                <tr>
                    <td colspan="6">Total Pembelian:</td>
                    {{--button konfirmasi show pop up--}}
                    <td id="total">{{$totalPembelian}} TC</td>
                </tr>
                <tr>
                    <td colspan="8" style="text-align:right;">
                        <button type="button" class="btn btn-success" id="button_PopupModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Konfirmasi</button>
                    </td>
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
                <div class="modal-body flex">
                    Apakah anda yakin untuk melakukan pembelian sebesar {{$totalPembelian}} TC?
                </div>
                <div class="modal-footer">
                    {{--button cancel--}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    {{--button konfirmasi akhir--}}
                    <button type="button" class="btn btn-success" id="konfirmasi_pembelian">Konfirmasi</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
