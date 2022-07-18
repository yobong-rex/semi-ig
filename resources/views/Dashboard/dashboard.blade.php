@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <style>
        
        .dana {
            text-align: right;
        }

        .col-4 {
            background-color: #faf0dc;
            padding: 0px;
        }

        .kartu_Home {
            background-color: #faf0dc;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

        .inventory {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

        .nomor_inventory {
            width: 50px;
            text-align: center;
        }

        .nomor_demand {
            width: 50px;
            text-align: center;
        }

        .pemenuhan {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }
        .col-md-4{
            margin-bottom:10px;
        }
        .button_OverProduct{
            border: 0px;
            position: fixed;
            bottom: 10%;
            right: 5%;
        }
        @media (max-width:800px){
            .dana, .label_dana{
                text-align: center;
            }
        }

        @media (max-width:1000px){
            .dana, .label_dana{
                font-size: 25px;
            }
        }
    </style>


    {{-- DOKUMENTASI ID --}}
    {{-- namaTeam : nama masing-masing team 
    timer : string timer
    dana : dana masing-masing team
    sisaInventory : sisa inventory
    nomorSesi : nomor sesi
    demandTerpenuhi : demand terpenuhi
    customerValue : customer value
    inv_{nomor} : jumlah bahan baku yang ada di inventory
    demand-{barang nomor}_{row demand ke} : pemenuhan demand
    total-{barang nomor} : total untuk barang --}}


    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        <div class="row spacing"></div>
        <div class="row-12">
            {{-- Card Dana --}}
            <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-wallet2" viewBox="0 0 16 16">
                            <path
                                d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                        </svg>
                    </div>
                    <div class="col-md-3 label_dana">
                        <h1>Dana :</h1> 
                    </div>
                    <div class="col-md-8 dana">
                        <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row spacing"></div>

        {{-- 3 Bar Card tengah --}}
        <div class="row">

            {{-- Card Inventory --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="auto" fill="currentColor"
                            class="bi bi-safe" viewBox="0 0 16 16">
                            <path
                                d="M1 1.5A1.5 1.5 0 0 1 2.5 0h12A1.5 1.5 0 0 1 16 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 1 14.5V13H.5a.5.5 0 0 1 0-1H1V8.5H.5a.5.5 0 0 1 0-1H1V4H.5a.5.5 0 0 1 0-1H1V1.5zM2.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-12z" />
                            <path
                                d="M13.5 6a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zM4.828 4.464a.5.5 0 0 1 .708 0l1.09 1.09a3.003 3.003 0 0 1 3.476 0l1.09-1.09a.5.5 0 1 1 .707.708l-1.09 1.09c.74 1.037.74 2.44 0 3.476l1.09 1.09a.5.5 0 1 1-.707.708l-1.09-1.09a3.002 3.002 0 0 1-3.476 0l-1.09 1.09a.5.5 0 1 1-.708-.708l1.09-1.09a3.003 3.003 0 0 1 0-3.476l-1.09-1.09a.5.5 0 0 1 0-.708zM6.95 6.586a2 2 0 1 0 2.828 2.828A2 2 0 0 0 6.95 6.586z" />
                        </svg>
                    </div>
                    <div class="col">
                        <h2>Sisa Inventory</h2>
                    </div>
                    <div class="col">
                        <h3 id="sisaInventory">{{ $user[0]->inventory }}</h3>
                    </div>
                </div>
            </div>


            {{-- Card Demand --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-truck" viewBox="0 0 16 16">
                            <path
                                d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                    </div>
                    <div class="col">
                        <h2>Demand Terpenuhi</h2>
                    </div>
                    <div class="col">
                        <h3 id="demandTerpenuhi">{{ $user[0]->demand }}</h3>
                    </div>
                </div>
            </div>
            {{-- Card Customer --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                    </div>
                    <div class="col">
                        <h2>Customer Value</h2>
                    </div>
                    <div class="col">
                        <h3 id="customerValue">{{ $user[0]->customer_value }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row spacing"></div>

        <div class="row">
            {{-- 3 Card Proses --}}
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="card-body rounded text-center kartu_Home">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                fill="currentColor" class="bi bi-stopwatch" viewBox="0 0 16 16">
                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                                <path
                                    d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                            </svg>
                        </div>
                        <div class="col">
                            <h2>Proses {{ $i }}</h2>
                        </div>
                        <div class="col">
                            <h4>Max Product : <span id="maxProduct_{{ $i }}">
                                    @if (isset($analisisProses[$i - 1][0]))
                                        {{ $analisisProses[$i - 1][0] }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </h4>
                        </div>
                        <div class="col">
                            <h4>Cycle Time : <span id="cycleTime_{{ $i }}">
                                    @if (isset($analisisProses[$i - 1][1]))
                                        {{ $analisisProses[$i - 1][1] }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="spacing"></div>

        {{-- Inventory --}}
        <div class="card-body inventory rounded">
            <h1>Inventory</h1>
            <table class="table table-bordered" style="vertical-align: middle;">
                <thead class="thead">
                    <tr>
                        <th class="nomor_inventory" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Tersedia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($bahanBaku as $b)
                        <tr>
                            <th class="nomor_inventory" scope="row">{{ $i }}</th>
                            <td>{{ $b->bahan_baku }}</td>
                            <td id="inv_{{ $i }}">
                                @if (count($bbTeam) == 0)
                                    0
                                @else
                                    <?php $trigerBB = 0; ?>
                                    @foreach ($bbTeam as $bt)
                                        @if ($b->idig_markets == $bt->ig_markets)
                                            {{ $bt->stock }}
                                            <?php $trigerBB += 1; ?>
                                        @endif
                                    @endforeach
                                    @if ($trigerBB == 0)
                                        {{ $trigerBB }}
                                    @endif
                                @endif

                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="spacing"></div>

        {{-- Pemenuhan Demand --}}
        <div class="card-body pemenuhan rounded">
            {{-- Table Pemenuhan Demand Baru --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="nomor_demand" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col" style="width:350px;">Jumlah Produk di Inventory</th>
                        <th scope="col" style="width:350px;">Demand Terpenuhi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($produk as $p)
                        <tr>
                            <td class="nomor_demand" scope="row">{{ $i++ }}</td>
                            <td>{{ $p->nama }}</td>
                            <td id="produkInventory">
                                @if (count($produk_team) == 0)
                                    0
                                @else
                                    <?php $trigerP = 0; ?>
                                    @foreach ($produk_team as $pt)
                                        @if ($p->idproduk == $pt->produk_idproduk)
                                            {{ $pt->hasil }}
                                            <?php $trigerP += 1; ?>
                                        @endif
                                    @endforeach
                                    @if ($trigerP == 0)
                                        {{ $trigerP }}
                                    @endif
                                @endif
                            </td>
                            <td id='total_{{ $p->idproduk }}'>
                                @if (count($data) == 0)
                                    0
                                @else
                                    <?php $triger = 0; ?>
                                    @foreach ($data as $d)
                                        @if ($p->idproduk == $d->idproduk)
                                            {{ $d->jumlah }}
                                            <?php $triger += 1; ?>
                                        @endif
                                    @endforeach
                                    @if ($triger == 0)
                                        {{ $triger }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button class="button_OverProduct" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-sign-stop" viewBox="0 0 16 16">
                <path d="M3.16 10.08c-.931 0-1.447-.493-1.494-1.132h.653c.065.346.396.583.891.583.524 0 .83-.246.83-.62 0-.303-.203-.467-.637-.572l-.656-.164c-.61-.147-.978-.51-.978-1.078 0-.706.597-1.184 1.444-1.184.853 0 1.386.475 1.436 1.087h-.645c-.064-.32-.352-.542-.797-.542-.472 0-.77.246-.77.6 0 .261.196.437.553.522l.654.161c.673.164 1.06.487 1.06 1.11 0 .736-.574 1.228-1.544 1.228Zm3.427-3.51V10h-.665V6.57H4.753V6h3.006v.568H6.587Z"/>
                <path fill-rule="evenodd" d="M11.045 7.73v.544c0 1.131-.636 1.805-1.661 1.805-1.026 0-1.664-.674-1.664-1.805V7.73c0-1.136.638-1.807 1.664-1.807 1.025 0 1.66.674 1.66 1.807Zm-.674.547v-.553c0-.827-.422-1.234-.987-1.234-.572 0-.99.407-.99 1.234v.553c0 .83.418 1.237.99 1.237.565 0 .987-.408.987-1.237Zm1.15-2.276h1.535c.82 0 1.316.55 1.316 1.292 0 .747-.501 1.289-1.321 1.289h-.865V10h-.665V6.001Zm1.436 2.036c.463 0 .735-.272.735-.744s-.272-.741-.735-.741h-.774v1.485h.774Z"/>
                <path fill-rule="evenodd" d="M4.893 0a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146A.5.5 0 0 0 11.107 0H4.893ZM1 5.1 5.1 1h5.8L15 5.1v5.8L10.9 15H5.1L1 10.9V5.1Z"/>
              </svg>
        </button>

        <div class="modal fade" id="staticBackdrop"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Over Production</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <!--Body buat di edit-->
                    <div class="modal-body flex">
                        <select id="selected_sesi">
                            @for($i=1;$i<=6;$i++)
                                <option value="">Sesi {{$i}}</option>
                            @endfor
                        </select>
                        <table class="table table-bordered" style="vertical-align: middle;">
                            <thead>
                                <tr>
                                    <th scope="col" style="width:1.3em;">No.</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col" style="width:1.5em;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($i=1;$i<=2;$i++)
                                <tr>
                                    <td class="nomor_OP" style="text-align: center;">{{$i}}</td>
                                    <td id="namaProdukOP_noSesi_{{$i}}">-</td>
                                    <td id="jumlahProdukOP_noSesi_{{$i}}">-</td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <!--End Body buat di edit-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        

    </body>
@endsection
