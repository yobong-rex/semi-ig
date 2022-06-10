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

        .col-4{
            background-color:#faf0dc;
            padding:0px;
        }
        .kartu_Home{
            background-color:#faf0dc;
            box-shadow: 0 6px 10px rgba(0,0,0,.08);
        }
        .inventory{
            background-color:#ffffff;
            box-shadow: 0 6px 10px rgba(0,0,0,.08);
        }
        .nomor_inventory{
            width:50px;
            text-align:center;
        }
        .nomor_demand{
            width:50px;
            text-align:center;
        }
        .pemenuhan{
            background-color:#ffffff;
            box-shadow: 0 6px 10px rgba(0,0,0,.08);
        }
    </style>


{{-- DOKUMENTASI ID --}}
{{-- 
    namaTeam : nama masing-masing team 
    timer : string timer
    dana : dana masing-masing team
    sisaInventory : sisa inventory
    nomorSesi : nomor sesi
    demandTerpenuhi : demand terpenuhi
    customerValue : customer value
    inv_{nomor} : jumlah bahan baku yang ada di inventory
    demand-{barang nomor}_{row demand ke} : pemenuhan demand
    total-{barang nomor} : total untuk barang

    --}}


<body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
    
    <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
        @php
        $sesi=1;
        $dana=10000;
        $namaTeam="apapun namanya";
        $nomorSesi=1;   
        $sisaInventory=1000;
        $demandTerpenuhi=400;
        $customerValue=0.6;
        $timer="00:00";
        @endphp
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

            {{--3 Bar Card tengah--}}
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
                            <h3 id="sisaInventory">{{$sisaInventory}}</h3>
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
                            <h3 id="demandTerpenuhi">{{$demandTerpenuhi}}</h3>
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
                            <h3 id="customerValue">{{$customerValue}}</h3>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="spacing"></div>

        {{--Inventory--}}
        <div class="card-body inventory rounded">
            <h1>Inventory</h1>
            <table class="table table-bordered" style="vertical-align: middle;">
                <thead class="thead">
                    <tr>
                        <th class="nomor_inventory"scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $arrbahan = array('Steel', 'Iron', 'Aluminium Alloy', 'ABS Plastic', 'PP Plastic', 'PC Plastic', 'SBR Rubber', 'PU Rubber', 'NBR Rubber', 'Silicone', 'Acrylic', 'Cable', 'EVA Glue', 'PVA Glue'); 
                    @endphp
                    @for($i=1;$i<=count($arrbahan);$i++)
                    <tr>
                        <th class="nomor_inventory" scope="row">{{$i}}</th>
                        <td>{{$arrbahan[$i-1]}}</td>
                        <td id="inv_{{$i}}">0</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="spacing"></div>

        {{--Pemenuhan Demand--}}
        <div class="card-body pemenuhan rounded">
            <h1>Pemenuhan Demand</h1>
            <table class="table table-bordered" style="vertical-align: middle;">
                @php
                    $arrproduk = array('Scooter', 'Hoverboard', 'Skateboard', 'Bicycle', 'Claw Machine', 'RC Car', 'RC Helicopter', 'Trampoline', 'Robot', 'Airsoft Gun', 'Rubber Ball', 'Fidget Spinner', 'Bowling Set', 'Action Figure');
                    $col=3;
                @endphp
                <thead class="thead">
                    <tr>
                        <th class="nomor_demand" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col" colspan={{$col}} style="text-align:center;">Memenuhi Demand</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1; $i<=count($arrproduk);$i++)
                    <tr>
                        <th class="nomor_demand" scope="row">{{$i}}</th>
                        <td>{{$arrproduk[$i-1]}}</td>
                        @for($j=1; $j<=$col;$j++)
                        <td id="demand-{{$i}}_{{$j}}">0</td>
                        @endfor
                        <td id="total-{{$i}}">0</td>

                    </tr>
                    @endfor
                    
                </tbody>
             </table>
        </div>

</body>

@endsection