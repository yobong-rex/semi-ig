@extends('layouts.template')

@section('title', 'Dashboard')

@section('content')
    <style>
        .heading {
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
            padding: 5px;
        }

        .nama_team {
            color: #ea435e;
        }

        .timer {
            background-color: #77dd77;
            /* misal waktu habis background jadi #ea435e */
            width: 150px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

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

        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
            {{-- Nama Team dan Timer --}}
            <div class="row align-items-center rounded heading">
                <div class="col-9 nama_team">
                    <h1 id="namaTeam">Team {{ $user[0]->nama }}</h1>
                </div>
                <div class="col-1">
                    <h3 id="nomorSesi" value="{{ $sesi[0]->sesi }}">Sesi <span id="sesi">{{ $sesi[0]->nama }}</span>
                    </h3>
                </div>
                <div class="col-1 text-center align-self-end timer rounded-2" style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">- - : - -</h4>
                </div>
            </div>

            <div class="row spacing"></div>
            <div class="row-12">
                {{-- Card Dana --}}
                <div class="card-header rounded"
                    style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
                    <div class="row align-items-center">
                        <div class="col-1 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                class="bi bi-wallet2" viewBox="0 0 16 16">
                                <path
                                    d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                            </svg>
                        </div>
                        <div class="col-2 label_dana">
                            <h1>Dana : </h1>
                        </div>
                        <div class="col-9 dana">
                            <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                        </div>
                    </div>
                </div>

                <div class="row spacing"></div>

                {{-- 3 Bar Card tengah --}}
                <div class="row">

                    {{-- Card Inventory --}}
                    <div class="col">
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
                    <div class="col">
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
                    <div class="col">
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
                        <div class="col">
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

                <!-- modal info -->
                <div class="modal fade" id="modalInfoTimer" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                            </div>
                            <div class="modal-body flex" id='info-body'>
                                Sesi telah berganti!!
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary mdl-close"
                                    data-bs-dismiss="modal">Close</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal info -->


    </body>

    <script src="../../js/app.js"></script>
    <script>
        let x = null;

        // buat menjalankan / melanjutkan timer pas buka webpage
        $(document).ready(function() {
            let condition = localStorage.getItem('condition');

            // kalau game start
            if (condition == 'start') {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('timer') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'namaSesi': $('#sesi').text()
                    },
                    success: function(data) {
                        // alert('success');
                        let waktu = data.waktu[0].waktu;

                        /* Timer */
                        clearInterval(x);

                        // variable used to continue timer
                        const key = 'timer'
                        var timeInMs = localStorage.getItem(key);

                        // kalau sudah pernah buka web ini
                        if (timeInMs) {
                            // hitung waktu yang hilang saat reload
                            // let delta = Date.now() - localStorage.getItem('now');

                            // timer lanjut dari waktu sebelum reload
                            timer = timeInMs;

                            x = setInterval(function() {
                                // kalau masih ada waktu, maka kurangi
                                if (timer > 0) {
                                    // jadikan minutes : second
                                    let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                                        1000 *
                                        60));
                                    let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                                    // kalau tidak double digit jadikan double digit
                                    if (minutes < 10) {
                                        minutes = '0' + minutes;
                                    }
                                    if (seconds < 10) {
                                        seconds = '0' + seconds;
                                    }

                                    // tampilkan timer
                                    $('#timer').text(minutes + " : " + seconds);

                                    //kurangi per 1000 milisecond
                                    timer -= 1000;

                                    // masukkan timer dan tanggal sekarang ke localStorage per detik
                                    localStorage.setItem(key, timer);
                                    // localStorage.setItem('now', Date.now());
                                    console.log(localStorage.getItem(key));
                                    // console.log(localStorage.getItem('now'));
                                }
                                // kalau sudah habis, maka selesai 
                                else {
                                    // hapus timer sekarang
                                    clearInterval(x);
                                    localStorage.clear();
                                    $('#timer').text('00 : 00');

                                    // lanjut sesi berikutnya
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ganti.sesi') }}",
                                        data: {
                                            '_token': '<?php echo csrf_token(); ?>',
                                            'sesi': $('#nomorSesi').attr('value')
                                        },
                                        success: function() {
                                            // alert('success');
                                            // masuk pusher
                                        },
                                        error: function() {
                                            alert('error');
                                        }
                                    })
                                }
                            }, 1000);
                        }
                        // kalau belum pernah buka web ini
                        else {
                            let timer = waktu * 1000;

                            // buat timer baru
                            x = setInterval(function() {
                                // kalau masih ada waktu, maka kurangi
                                if (timer > 0) {
                                    // jadikan minutes : second
                                    let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                                        1000 *
                                        60));
                                    let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                                    // kalau tidak double digit jadikan double digit
                                    if (minutes < 10) {
                                        minutes = '0' + minutes;
                                    }
                                    if (seconds < 10) {
                                        seconds = '0' + seconds;
                                    }

                                    // tampilkan timer
                                    $('#timer').text(minutes + " : " + seconds);

                                    //kurangi per 1000 milisecond
                                    timer -= 1000;

                                    // masukkan timer dan tanggal sekarang ke localStorage per detik
                                    localStorage.setItem(key, timer);
                                    // localStorage.setItem('now', Date.now());
                                    console.log(localStorage.getItem(key));
                                    // console.log(localStorage.getItem('now'));
                                }
                                // kalau sudah habis, maka selesai 
                                else {
                                    // hapus timer sekarang
                                    clearInterval(x);
                                    localStorage.clear();
                                    $('#timer').text('00 : 00');

                                    // lanjut sesi berikutnya
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{ route('ganti.sesi') }}",
                                        data: {
                                            '_token': '<?php echo csrf_token(); ?>',
                                            'sesi': $('#nomorSesi').attr('value')
                                        },
                                        success: function() {
                                            // alert('success');
                                            // masuk pusher
                                        },
                                        error: function() {
                                            alert('error');
                                        }
                                    })
                                }
                            }, 1000);
                        }
                    },
                    error: function() {
                        alert('error');
                    }
                })
            }
            //  kalau game pause
            else if (condition == 'pause') {
                console.log('masuk pause');
                clearInterval(x);
            }
            //  kalau game stop
            else if (condition == 'stop') {
                console.log('masuk stop');
                clearInterval(x);
            }
        })

        /* Pusher */
        window.Echo.channel('sesiPusher').listen('.sesi', (e) => {
            console.log(e.id);
            console.log(e.sesi);
            console.log(e.waktu);
            console.log(e.condition);

            // setting sesi
            $('#nomorSesi').attr('value', e.id);
            $('#sesi').text(e.sesi);

            // setting timer
            let waktu = e.waktu;

            localStorage.setItem('condition', e.condition);
            let condition = localStorage.getItem('condition');
            console.log(localStorage.getItem('condition'));

            /* Timer */
            // variable used to continue timer
            const key = 'timer';
            var timeInMs = localStorage.getItem(key);

            // kalau game berjalan
            if (condition == 'start') {
                clearInterval(x);
                console.log('masuk start');
                // kalau sudah pernah buka web ini
                if (timeInMs) {
                    // hitung waktu yang hilang saat reload
                    // let delta = Date.now() - localStorage.getItem('now');

                    // timer lanjut dari waktu sebelum reload
                    timer = timeInMs;

                    x = setInterval(function() {
                        // kalau masih ada waktu, maka kurangi
                        if (timer > 0) {
                            // jadikan minutes : second
                            let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                                1000 *
                                60));
                            let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                            // kalau tidak double digit jadikan double digit
                            if (minutes < 10) {
                                minutes = '0' + minutes;
                            }
                            if (seconds < 10) {
                                seconds = '0' + seconds;
                            }

                            // tampilkan timer
                            $('#timer').text(minutes + " : " + seconds);

                            //kurangi per 1000 milisecond
                            timer -= 1000;

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem(key, timer);
                            // localStorage.setItem('now', Date.now());
                            console.log(localStorage.getItem(key));
                            // console.log(localStorage.getItem('now'));
                        }
                        // kalau sudah habis, maka selesai 
                        else {
                            // hapus timer sekarang
                            clearInterval(x);
                            localStorage.clear();
                            $('#timer').text('00 : 00');

                            // lanjut sesi berikutnya
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('ganti.sesi') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'sesi': $('#nomorSesi').attr('value')
                                },
                                success: function() {
                                    // alert('success');
                                    // masuk pusher
                                },
                                error: function() {
                                    alert('error');
                                }
                            })
                        }
                    }, 1000)
                }
                // kalau belum pernah buka web ini
                else {
                    let timer = waktu * 1000;

                    // buat timer baru
                    x = setInterval(function() {
                        // kalau masih ada waktu, maka kurangi
                        if (timer > 0) {
                            // jadikan minutes : second
                            let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                                1000 *
                                60));
                            let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                            // kalau tidak double digit jadikan double digit
                            if (minutes < 10) {
                                minutes = '0' + minutes;
                            }
                            if (seconds < 10) {
                                seconds = '0' + seconds;
                            }

                            // tampilkan timer
                            $('#timer').text(minutes + " : " + seconds);

                            //kurangi per 1000 milisecond
                            timer -= 1000;

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem(key, timer);
                            // localStorage.setItem('now', Date.now());
                            console.log(localStorage.getItem(key));
                            // console.log(localStorage.getItem('now'));
                        }
                        // kalau sudah habis, maka selesai 
                        else {
                            // hapus timer sekarang
                            clearInterval(x);
                            localStorage.clear();
                            $('#timer').text('00 : 00');

                            // lanjut sesi berikutnya
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('ganti.sesi') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'sesi': $('#nomorSesi').attr('value')
                                },
                                success: function() {
                                    // alert('success');
                                    // masuk pusher
                                },
                                error: function() {
                                    alert('error');
                                }
                            })
                        }
                    }, 1000)
                }
            }
            //  kalau game pause
            else if (condition == 'pause') {
                console.log('masuk pause');
                clearInterval(x);
            }
            //  kalau game stop
            else if (condition == 'stop') {
                console.log('masuk stop');
                clearInterval(x);

                // reset timer
                localStorage.removeItem(key);
                console.log(localStorage.getItem(key));

                // ganti timer ke default
                $('#timer').text('- - : - -');
            }
            // kalau ganti sesi
            else if (condition == 'ganti') {
                console.log('masuk ganti');
                clearInterval(x);

                let timer = waktu * 1000;

                // buat timer baru
                x = setInterval(function() {
                    // kalau masih ada waktu, maka kurangi
                    if (timer > 0) {
                        // jadikan minutes : second
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                            1000 *
                            60));
                        let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                        // kalau tidak double digit jadikan double digit
                        if (minutes < 10) {
                            minutes = '0' + minutes;
                        }
                        if (seconds < 10) {
                            seconds = '0' + seconds;
                        }

                        // tampilkan timer
                        $('#timer').text(minutes + " : " + seconds);

                        //kurangi per 1000 milisecond
                        timer -= 1000;

                        // masukkan timer dan tanggal sekarang ke localStorage per detik
                        localStorage.setItem(key, timer);
                        // localStorage.setItem('now', Date.now());
                        console.log(localStorage.getItem(key));
                        // console.log(localStorage.getItem('now'));
                    }
                    // kalau sudah habis, maka selesai 
                    else {
                        // hapus timer sekarang
                        clearInterval(x);
                        localStorage.clear();
                        $('#timer').text('00 : 00');

                        // lanjut sesi berikutnya
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('ganti.sesi') }}",
                            data: {
                                '_token': '<?php echo csrf_token(); ?>',
                                'sesi': $('#nomorSesi').attr('value')
                            },
                            success: function() {
                                // alert('success');
                                // masuk pusher
                            },
                            error: function() {
                                alert('error');
                            }
                        })
                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }
            // kalau ganti sesi
            else if (condition == 'back') {
                console.log('masuk back');
                clearInterval(x);

                let timer = waktu * 1000;

                // buat timer baru
                x = setInterval(function() {
                    // kalau masih ada waktu, maka kurangi
                    if (timer > 0) {
                        // jadikan minutes : second
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (
                            1000 *
                            60));
                        let seconds = Math.floor((timer % (1000 * 60)) / 1000);

                        // kalau tidak double digit jadikan double digit
                        if (minutes < 10) {
                            minutes = '0' + minutes;
                        }
                        if (seconds < 10) {
                            seconds = '0' + seconds;
                        }

                        // tampilkan timer
                        $('#timer').text(minutes + " : " + seconds);

                        //kurangi per 1000 milisecond
                        timer -= 1000;

                        // masukkan timer dan tanggal sekarang ke localStorage per detik
                        localStorage.setItem(key, timer);
                        // localStorage.setItem('now', Date.now());
                        console.log(localStorage.getItem(key));
                        // console.log(localStorage.getItem('now'));
                    }
                    // kalau sudah habis, maka selesai 
                    else {
                        // hapus timer sekarang
                        clearInterval(x);
                        localStorage.clear();
                        $('#timer').text('00 : 00');

                        // lanjut sesi berikutnya
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('ganti.sesi') }}",
                            data: {
                                '_token': '<?php echo csrf_token(); ?>',
                                'sesi': $('#nomorSesi').attr('value')
                            },
                            success: function() {
                                // alert('success');
                                // masuk pusher
                            },
                            error: function() {
                                alert('error');
                            }
                        })
                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }
        })
    </script>
@endsection
