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

        .col-md-4 {
            margin-bottom: 10px;
        }

        .button_OverProduct {
            border: 0px;
            position: fixed;
            bottom: 10%;
            right: 5%;
            background-color: rgba(0, 0, 0, 0);
        }

        .gambar_OP {
            width: 3.5em;
            height: 3.5em;
        }

        @media (max-width:800px) {

            .dana,
            .label_dana {
                text-align: center;
            }

            .button_OverProduct,
            .gambar_OP {
                width: 2em;
                bottom: 10%;
                right: 5%;
            }

            .OP_text {
                font-size: 12px;
            }
        }

        @media (max-width:1000px) {

            .dana,
            .label_dana {
                font-size: 25px;
            }

            .button_OverProduct,
            .gambar_OP {
                width: 3em;
                bottom: 10%;
                right: 5%;
            }

            .OP_text {
                font-size: 12px;
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                class="bi bi-stopwatch" viewBox="0 0 16 16">
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
                                        50
                                    @endif
                                </span>
                            </h4>
                        </div>
                        <div class="col">
                            <h4>Cycle Time : <span id="cycleTime_{{ $i }}">
                                    @if (isset($analisisProses[$i - 1][1]))
                                        {{ $analisisProses[$i - 1][1] }}
                                    @elseif ($i == 1)
                                        73
                                    @elseif ($i == 2)
                                        79
                                    @elseif ($i == 3)
                                        90
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
            <h1>Pemenuhan Demand</h1>
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

        {{-- <div style="background:#000000 ;border:1px solid #000000;"> --}}
        <button class="button_OverProduct" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <svg xmlns="http://www.w3.org/2000/svg" class="gambar_OP" fill="currentColor"
                class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
            </svg>
            <br>
            <span id="OP_text" style="text-align:center;">Over Production</span>
        </button>
        {{-- </div> --}}

        <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Over Production</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!--Body buat di edit-->
                    <div class="modal-body flex">
                        <select id="selected_sesi">
                            <option value="">Pilih Sesi</option>
                            @for ($i = 1; $i < $namaSesi; $i++)
                                <option value="{{ $i }}">Sesi {{ $i }}</option>
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
                            <tbody id='body-over'>
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

        <script src="../../js/app.js"></script>
        <script>
            window.Echo.channel('mesinPusher').listen('.mesin', (e) => {
                console.log(e.kapasitas1);
                console.log(e.cycle1);
                console.log(e.kapasitas2);
                console.log(e.cycle2);
                console.log(e.kapasitas3);
                console.log(e.cycle3);

                //  kalau kapasitas 1 ada isinya
                if (e.kapasitas1 != '') {
                    $('#maxProduct_1').text(e.kapasitas1);
                }

                //  kalau kapasitas 2 ada isinya
                if (e.kapasitas2 != '') {
                    $('#maxProduct_2').text(e.kapasitas2);
                }

                //  kalau kapasitas 3 ada isinya
                if (e.kapasitas3 != '') {
                    $('#maxProduct_3').text(e.kapasitas3);
                }

                //  kalau cycle 1 ada isinya
                if (e.cycle1 != '') {
                    $('#cycleTime_1').text(e.cycle1);
                }

                //  kalau cycle 2 ada isinya
                if (e.cycle2 != '') {
                    $('#cycleTime_2').text(e.cycle2);
                }

                //  kalau cycle 3 ada isinya
                if (e.cycle3 != '') {
                    $('#cycleTime_3').text(e.cycle3);
                }
            })

            $('#selected_sesi').on('change', function() {
                let sesi = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.overProduct') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'sesi': sesi,

                    },
                    success: function(data) {
                        $('#body-over').empty();
                        let nomer = 1;
                        if (data.msg == '') {
                            $.each(data.result, function(key, value) {
                                $('#body-over').append(`
                                    <tr>
                                        <td class="nomor_OP" style="text-align: center;">` + nomer + `</td>
                                        <td id="">` + value.nama + `</td>
                                        <td id="">` + value.hasil + `</td>
                                    </tr>`);
                                nomer += 1;
                            });
                        } else {
                            $('#body-over').append(`
                                    <tr>
                                        <td class="nomor_OP" style="text-align: center;"></td>
                                        <td id="">` + data.msg + `</td>
                                        <td id=""></td>
                                    </tr>`);
                        }
                    }
                })
            })
        </script>

    </body>
@endsection
