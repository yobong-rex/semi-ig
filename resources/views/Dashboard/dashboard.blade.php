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
            bottom: 7%;
            right: 5%;
            background-color: rgba(0, 0, 0, 0);
        }

        .gambar_OP {
            width: 3.5em;
            height: 3.5em;
        }

        .gambarTengah {
            width: 64px;
            height: auto;
        }

        .text_kartu,
        .text_kartu_proses,.text_kartu_bawah {
            font-weight: bolder;
            font-size: 24px;
        }

        .text_nilai_kartu {
            font-weight: bold;
            font-size: 24px;
        }

        @media (max-width:580px) {
            .col-md-4 {
                width: fit-content;
            }

            .dana,
            .label_dana {
                text-align: center;
                padding-left: 24px;
            }

            .button_OverProduct,
            .gambar_OP {
                width: 2em;
                bottom: 5%;
                right: 5%;
                height: 2em;
            }

            .OP_text {
                font-size: 12px;
            }

            .bi-wallet2 {
                max-width: 64px;
            }

            .kartu_Home {
                width: fit-content;
                padding: 8px;
            }

            .gambarTengah {
                width: 36px;
                height: auto;
            }

            .text_kartu,
            .text_kartu_proses {
                font-weight: bolder;
                font-size: 14px;
            }

            .text_nilai_kartu {
                font-weight: bold;
                font-size: 16px;
            }

            .text_button_OP {
                font-size: 10px;
            }
        }

        @media (max-width:800px) and (min-width:580px) {
            .col-md-4 {
                width: fit-content;
                padding: 4px;
            }

            .dana,
            .label_dana {
                text-align: center;
                padding-left: 24px;
            }

            .button_OverProduct,
            .gambar_OP {
                width: 2em;
                bottom: 10%;
                right: 5%;
                height: 2em;
            }

            .OP_text {
                font-size: 12px;
            }

            .bi-wallet2 {
                max-width: 64px;
            }

            .kartu_Home {
                width: 160px;
                padding: 8px;
            }

            .gambarTengah {
                width: 36px;
                height: auto;
            }

            .text_kartu {
                font-weight: bolder;
                font-size: 16px;
            }

            .text_nilai_kartu {
                font-weight: bold;
                font-size: 16px;
            }

            .text_kartu_proses {
                font-weight: bolder;
                font-size: 14px;
            }
        }

        @media (max-width:1000px) and (min-width:800px) {
            .col-md-4 {
                width: fit-content;
            }

            .dana,
            .label_dana {
                font-size: 25px;
                padding-left: 24px;
            }

            .button_OverProduct,
            .gambar_OP {
                width: 3em;
                bottom: 10%;
                right: 5%;
                height: 3em;
            }

            .OP_text {
                font-size: 12px;
            }

            .gambarTengah {
                width: 45px;
                height: auto;
            }

            .kartu_Home {
                padding: 8px;
            }

            .text_kartu {
                font-weight: bolder;
                font-size: 24px;
            }

            .text_nilai_kartu {
                font-weight: bold;
                font-size: 18px;
            }

            .text_kartu_proses {
                font-weight: bolder;
                font-size: 20px;
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
        <div class="row justify-content-center">

            {{-- Card Inventory --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" class="gambarTengah" fill="currentColor" class="bi bi-safe"
                            viewBox="0 0 16 16">
                            <path
                                d="M1 1.5A1.5 1.5 0 0 1 2.5 0h12A1.5 1.5 0 0 1 16 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 1 14.5V13H.5a.5.5 0 0 1 0-1H1V8.5H.5a.5.5 0 0 1 0-1H1V4H.5a.5.5 0 0 1 0-1H1V1.5zM2.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-12z" />
                            <path
                                d="M13.5 6a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zM4.828 4.464a.5.5 0 0 1 .708 0l1.09 1.09a3.003 3.003 0 0 1 3.476 0l1.09-1.09a.5.5 0 1 1 .707.708l-1.09 1.09c.74 1.037.74 2.44 0 3.476l1.09 1.09a.5.5 0 1 1-.707.708l-1.09-1.09a3.002 3.002 0 0 1-3.476 0l-1.09 1.09a.5.5 0 1 1-.708-.708l1.09-1.09a3.003 3.003 0 0 1 0-3.476l-1.09-1.09a.5.5 0 0 1 0-.708zM6.95 6.586a2 2 0 1 0 2.828 2.828A2 2 0 0 0 6.95 6.586z" />
                        </svg>
                    </div>
                    <div class="col">
                        <span class="text_kartu">Sisa Inventory</span>
                    </div>
                    <div class="col">
                        <span class="text_nilai_kartu" id="sisaInventory">{{ $user[0]->inventory }}</span>
                    </div>
                </div>
            </div>


            {{-- Card Demand --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" class="gambarTengah" fill="currentColor" class="bi bi-truck"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                    </div>
                    <div class="col">
                        <span class="text_kartu">Demand Terpenuhi</span>
                    </div>
                    <div class="col">
                        <span class="text_nilai_kartu" id="demandTerpenuhi">{{ $user[0]->demand }}</span>
                    </div>
                </div>
            </div>
            {{-- Card Customer --}}
            <div class="col-md-4">
                <div class="card-body rounded text-center kartu_Home">
                    <div class="col">
                        <svg xmlns="http://www.w3.org/2000/svg" class="gambarTengah" fill="currentColor"
                            class="bi bi-person" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                        </svg>
                    </div>
                    <div class="col">
                        <span class="text_kartu">Customer Value</span>
                    </div>
                    <div class="col">
                        <span class="text_nilai_kartu" id="customerValue">{{ $user[0]->customer_value }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row spacing"></div>

        <div class="row justify-content-center">
            {{-- 3 Card Proses --}}
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="card-body rounded text-center kartu_Home">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" class="gambarTengah" fill="currentColor"
                                class="bi bi-stopwatch" viewBox="0 0 16 16">
                                <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                                <path
                                    d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                            </svg>
                        </div>
                        <div class="col">
                            <span class="text_kartu_proses">Proses {{ $i }}</span>
                        </div>
                        <div class="col">
                            <span class="text_kartu_proses">Kapasitas Mesin : </br><span style="color: #ea435e;"
                                    class="text_kartu_proses" id="maxProduct_{{ $i }}">
                                    @if ($i == 1)
                                        @if (isset($analisisProses[0]))
                                            {{ $analisisProses[0][1] }}
                                        @else
                                            50
                                        @endif
                                    @elseif($i == 2)
                                        @if (isset($analisisProses[1]))
                                            {{ $analisisProses[1][1] }}
                                        @else
                                            50
                                        @endif
                                    @elseif($i == 3)
                                        @if (isset($analisisProses[2]))
                                            {{ $analisisProses[2][1] }}
                                        @else
                                            50
                                        @endif
                                    @endif
                                </span>
                            </span>
                        </div>
                        <div class="col">
                            <span class="text_kartu_proses">Maksimal Produksi : </br><span style="color: #ea435e;"
                                    id="cycleTime_{{ $i }}">
                                    @if ($i == 1)
                                        @if (isset($analisisProses[0]))
                                            {{ $analisisProses[0][2] }}
                                        @else
                                            73
                                        @endif
                                    @elseif($i == 2)
                                        @if (isset($analisisProses[1]))
                                            {{ $analisisProses[1][2] }}
                                        @else
                                            79
                                        @endif
                                    @elseif($i == 3)
                                        @if (isset($analisisProses[2]))
                                            {{ $analisisProses[2][2] }}
                                        @else
                                            90
                                        @endif
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div class="row spacing"></div>

        <div class="row">

            <div class="col-12 col-md-6">
                {{-- Inventory --}}
                <div class="card-body inventory rounded">
                    <p class="text_kartu_bawah" style="margin-bottom:0.5rem !important;">Inventory</p>
                    <table class="table table-striped table-bordered w-100" style="vertical-align: middle;">
                        <thead class="table-dark">
                            <tr>
                                <th class="nomor_inventory " scope="col">No.</th>
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
                                                @if ($b->bahan_baku == $bt->ig_markets)
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
            </div>

            <div class="col-12 col-md-6 mt-4 mt-md-0">
                {{-- Pemenuhan Demand --}}
                <div class="card-body pemenuhan rounded">
                    <p class="text_kartu_bawah" style="margin-bottom:0.5rem !important;">Pemenuhan Demand</p>
                    {{-- Table Pemenuhan Demand Baru --}}
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered w-100" style="vertical-align: middle;">
                            <thead class="table-dark">
                                <tr style="vertical-align: middle;">
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
                </div>
            </div>
        </div>

        {{-- <div style="background:#000000 ;border:1px solid #000000;"> --}}
        <button class="button_OverProduct" id='btn-op' data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            style="width: fit-content;">
            <svg xmlns="http://www.w3.org/2000/svg" class="gambar_OP" fill="currentColor"
                class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
            </svg>
            <br>
            <span class="text_button_OP" id="OP_text" style="text-align:center;">Over Production</span>
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
                        <table class="table table-striped-bordered" style="vertical-align: middle;">
                            <!-- <thead>
                                <tr>
                                    <th scope="col" style="width:1.3em;">No.</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col" style="width:1.5em;">Jumlah</th>
                                </tr>
                            </thead> -->
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

                let idTeam = '<?php echo $idteam; ?>';
                console.log(e.id);
                console.log(idTeam);

                if (idTeam == e.id) {
                    console.log('masuk if-id sama')
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
                }
            })

            $('#btn-op').on('click', function() {
                // alert('dar');
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
                        $('#body-over').append(`
                            <tr>
                                <td id=""> Total Over Production: </td>
                                <td id="">` + data.result + `</td>
                            </tr>`);
                    }
                })
            })
        </script>

    </body>
@endsection
