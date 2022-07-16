@extends('layouts.template')

@section('title', 'Analisis Bahan Baku')

@section('content')
    @php
    if (isset($_GET['session'])) {
        if ($_GET['session'] == 1) {
            session_start();
        }
    }
    @endphp

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

        table,
        tbody,
        tr,
        th,
        td {
            border: 1px solid black;
        }

        table {
            padding: 5px;
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">

            <div class="row spacing"></div>
            {{-- Card Dana --}}
            <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
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

            <h1>Analisis Bahan Baku</h1>
            <table class="table" style="width:100%;">
                <tbody>
                    <tr>
                        {{-- Tulisan Bahan Baku --}}
                        <th class="header_bahanbaku" scope="col" colspan="2">Bahan Baku</th>

                        {{-- combobox di kanan atas yang isinya produk --}}
                        <th>
                            <select name="produk" id="produk">
                                @for ($x = 0; $x < count($product); $x++)
                                    <option value='{{ $product[$x]->nama }}'>{{ $product[$x]->nama }}</option>
                                @endfor
                            </select>
                        </th>
                        <th scope="col">Status</th>
                    </tr>
                    <tr>
                        {{-- 3 combobox di bawah yang isinya resource/bahan baku --}}
                        @for ($i = 1; $i <= 3; $i++)
                            <td>
                                @php
                                    $arrResource = ['Steel', 'Iron', 'Aluminium Alloy', 'ABS Plastic', 'PP Plastic', 'PC Plastic', 'SBR Rubber', 'PU Rubber', 'NBR Rubber', 'Silicone', 'Acrylic', 'Cable', 'EVA Glue', 'PVA Glue'];
                                @endphp
                                <select name="resource{{ $i }}" id="resource{{ $i }}">
                                    @foreach ($arrResource as $key => $resource)
                                        <option value='{{ $resource }}'>{{ $resource }}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endfor
                        {{-- Table kosong di kanan bawah buat tempat True/False --}}
                        <td>
                            <span id="status"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{-- Button Submit --}}
            <button id='analisisBahan' class="btn btn-primary" type="submit" value="submit">Submit</button>

        {{-- Modal --}}
        {{-- Modal Notif --}}
        <div class="modal fade" id="Notif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="NotifLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NotifLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        <h4><span id='notifUpgrade'></span></h4>
                    </div>
                    <div class="modal-footer">
                        {{-- button ok --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="../../js/app.js"></script>
    <script>
        // buat menjalankan timer pas buka webpage
        $(document).ready(function() {
            // alert($('#sesi').text());
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

                    // variable used to continue timer
                    const key = 'timer'
                    var timeInMs = localStorage.getItem(key);

                    // kalau sudah pernah buka web ini
                    if (timeInMs) {
                        // hitung waktu yang hilang saat reload
                        // let delta = Date.now() - localStorage.getItem('now');

                        // timer lanjut dari waktu sebelum reload
                        timer = timeInMs;

                        let x = setInterval(function() {
                            // kalau masih ada waktu, maka kurangi
                            if (timer > 0) {
                                // jadikan minutes : second
                                let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 *
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
                        let x = setInterval(function() {
                            // kalau masih ada waktu, maka kurangi
                            if (timer > 0) {
                                // jadikan minutes : second
                                let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 *
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
                },
                error: function() {
                    alert('error');
                }
            })
        })

        /* Pusher */
        window.Echo.channel('sesiPusher').listen('.sesi', (e) => {
            console.log(e.id);
            console.log(e.sesi);
            console.log(e.waktu);
            $('#nomorSesi').attr('value', e.id);
            $('#sesi').text(e.sesi);
            let waktu = e.waktu;

            /* Timer */
            // variable used to continue timer
            const key = 'timer'
            var timeInMs = localStorage.getItem(key);

            // kalau sudah pernah buka web ini
            if (timeInMs) {
                // hitung waktu yang hilang saat reload
                // let delta = Date.now() - localStorage.getItem('now');

                // timer lanjut dari waktu sebelum reload
                timer = timeInMs;

                let x = setInterval(function() {
                    // kalau masih ada waktu, maka kurangi
                    if (timer > 0) {
                        // jadikan minutes : second
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 *
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
                let x = setInterval(function() {
                    // kalau masih ada waktu, maka kurangi
                    if (timer > 0) {
                        // jadikan minutes : second
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 *
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
        })

        $('#analisisBahan').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('analisis.bahan') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'produk': $('#produk').val(),
                    'resource1': $('#resource1').val(),
                    'resource2': $('#resource2').val(),
                    'resource3': $('#resource3').val()
                },
                success: function(data) {
                    // alert('success');
                    if (data.msg == 'Dana Tidak Mencukupi') {
                        $('#notifUpgrade').text(data.msg);
                        $('#Notif').modal('show');
                    } else {
                        $('#dana').html(data.user[0].dana);
                        $('#status').text(data.status);
                    }
                },
                error: function() {
                    alert('error');
                }
            });
        });
    </script>
@endsection
