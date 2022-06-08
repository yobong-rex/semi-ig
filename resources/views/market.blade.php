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
                <?php $nomer = 1; ?>
                @foreach ($data as $d)
                <tr>
                    <th class="nomor_bahan" scope="row">{{$nomer}}</th>
                    <td>{{$d->bahan_baku}}</td>
                    <td>{{$d->isi}}</td>
                    <td id="stok_{{$d->idig_markets}}">{{$d->stok}}</td>
                    <td id="harga_{{$d->idig_markets}}">{{$d->harga}}</td>
                    <td><input class="form-control quantity" id="input_{{$d->idig_markets}}" type="number" min="0" oninput="this.value = 
                        !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                    <td><span id="subtotal_{{$d->idig_markets}}">0</span>  TC</td>
                </tr>
                <?php $nomer += 1; ?>
                @endforeach
                <tr>
                    <td colspan="6">Biaya Pengiriman:</td>
                    <td id="biaya_pengiriman">0 TC</td>
                </tr>
                <tr>
                    <td colspan="6">Total Pembelian:</td>
                    {{--button konfirmasi show pop up--}}
                    <td><span id="total">0</span> TC</td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).on('change','.quantity', function(){
            let quantity = $(this).val();
            let id = $(this).attr('id');
            let split_id = id.split('_');
            let harga = $("#harga_"+split_id[1]).text();
            let subtotal = parseInt(harga) * quantity;
            $('#subtotal_'+split_id[1]).text(subtotal);
            total();
        })

        function total(){
            let total = 0;
            let count = 0;
            for (let i = 1; i <= 14; i++) {
                let subtotal = parseInt($('#subtotal_'+i).text())
                total += subtotal;
                if(subtotal !== 0) count += 1
            }
            if(count>= 10){
                total += (count-9)*200;
            }
            $('#total').text(total);
        }
    </script>
</body>
@endsection
