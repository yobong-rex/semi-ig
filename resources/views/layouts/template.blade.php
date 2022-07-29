<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}">

    {{-- CDN Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    {{-- CDN Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    {{-- CDN JQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- CSS Internal --}}
    <style>
        @font-face {
            font-family: 'TT Norms Light';
            font-style: normal;
            font-weight: bold;
            src: local('TT Norms Light'), url('assets/font/TTNorms-Light.otf');
        }

        @font-face {
            font-family: 'TT Norms Medium';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Medium'), url('assets/font/TTNorms-Medium.woff') format('woff');
        }

        @font-face {
            font-family: 'TT Norms Bold';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Bold'), url('assets/font/TTNorms-Bold.woff') format('woff');
        }

        @font-face {
            font-family: 'TT Norms Regular';
            font-style: normal;
            font-weight: normal;
            src: local('TT Norms Regular'), url('assets/font/TTNorms-Regular.woff') format('woff');
        }

        .nav-link,
        .nav-link:focus {
            font-family: 'TT Norms Bold';
            color: #ea435e;
            border-radius: 5px;
        }

        .nav-link:hover {
            color: #ffff;
            background-color: #ea435e;
            border-radius: 5px;
        }

        .nav-link:active {
            transform: scale(0.95);
        }

        .spacing {
            margin: 15px;
            padding: 10px;
        }

        .logOut {
            background-color: #6868ac;
            border-radius: 5px;
        }

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


        @media (max-width:800px) {

            .dana,
            .label_dana {
                text-align: center;
            }
        }

        @media (max-width:1000px) {
            .coloumn_sesi {
                max-width: fit-content;
            }
        }
    </style>

    {{-- CSS Tambahan Internal --}}
    @yield('css')

</head>

<body oncontextmenu="return false">

{{-- <body> --}}
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-lg" style="background-color: #ffff; box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.3);">
        <div class="container-fluid gap-5">


            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="justify-content:center;">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('assets') }}/logo/Logo_IG_Header.png" alt="Logo IGXXX"
                        style="max-height: 40px">
                </a>
                <ul class="navbar-nav mb-2 mb-lg-0 gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    @can('isMarketing')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('komponen') }}">Mesin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('demand') }}">Demand</a>
                        </li>
                    @elsecan('isResearcher')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('bahan') }}">Analisis Bahan</a>
                        </li>
                    @elsecan('isProduction_Manager')
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('kapasitas') }}">Kapasitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('produksi') }}">Produksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('analisis') }}">Analisis
                                Produksi</a>
                        </li>
                    @endcan

                    <li class="nav-item logOut">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-light nav-link active" aria-current="page" style="text-decoration:none;">
                            {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Body --}}
    @yield('admin')

    <div class="container-fluid p-0">
        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
            {{-- Nama Team dan Timer --}}
            <div class="row flex-wrap align-items-center rounded heading">

                <div class="col flex nama_team">
                    <h1 id="namaTeam">Team {{ $user[0]->nama }}</h1>
                </div>
                <div class="col flex coloumn_sesi" style="text-align:right;">
                    <h3 id="nomorSesi" value={{ $valueSesi }}>Sesi <span id="sesi">{{ $namaSesi }}</span>
                    </h3>
                </div>
                <div class="col-md-2 flex text-center align-self-end timer rounded-2"
                    style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">- - : - -</h4>
                </div>
            </div>

            @yield('content')
        </div>
    </div>

    <!-- modal info timer-->
    <div class="modal fade" id="modalInfoTimer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                </div>
                <div class="modal-body flex" id='info-body-timer'>
                    Sesi telah berganti!!
                </div>
                <div class="modal-footer">
                    @cannot('isAdmin')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary mdl-close">OK!</a>
                    @else
                        <button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">OK!</button>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
    <!-- end modal info timer-->


    <!-- modal info analisis-->
    <div class="modal fade" id="modalInfoAnalisis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                </div>
                <div class="modal-body flex" id='info-body-analisis'>
                    Sesi analisis telah <span id='analisis-status'></span>
                </div>
                <div class="modal-footer" id='footer-analisis'>
                    @can('isProduction_Manager')
                        <a href="{{ route('analisis') }}" class="btn btn-secondary mdl-close">OK!</a>
                    @else
                        <button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">OK!</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <!-- end modal info analisis-->

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
                                            // masuk pusher
                                            // alert('success');

                                            // tampilkan modal
                                            $('#modalInfoTimer').modal('show');
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
                                            // masuk pusher
                                            // alert('success');

                                            // tampilkan modal
                                            $('#modalInfoTimer').modal('show');
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
                            // $.ajax({
                            //     type: 'POST',
                            //     url: "{{ route('ganti.sesi') }}",
                            //     data: {
                            //         '_token': '<?php echo csrf_token(); ?>',
                            //         'sesi': $('#nomorSesi').attr('value')
                            //     },
                            //     success: function() {
                            //         // masuk pusher
                            //         // alert('success');

                            //         // tampilkan modal
                            //         $('#modalInfoTimer').modal('show');
                            //     },
                            //     error: function() {
                            //         alert('error');
                            //     }
                            // })
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
                            // $.ajax({
                            //     type: 'POST',
                            //     url: "{{ route('ganti.sesi') }}",
                            //     data: {
                            //         '_token': '<?php echo csrf_token(); ?>',
                            //         'sesi': $('#nomorSesi').attr('value')
                            //     },
                            //     success: function() {
                            //         // masuk pusher
                            //         // alert('success');

                            //         // tampilkan modal
                            //         $('#modalInfoTimer').modal('show');
                            //     },
                            //     error: function() {
                            //         alert('error');
                            //     }
                            // })
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
                // tampilkan modal
                $('#modalInfoTimer').modal('show');

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
                        // $.ajax({
                        //     type: 'POST',
                        //     url: "{{ route('ganti.sesi') }}",
                        //     data: {
                        //         '_token': '<?php echo csrf_token(); ?>',
                        //         'sesi': $('#nomorSesi').attr('value')
                        //     },
                        //     success: function() {
                        //         // masuk pusher
                        //         // alert('success');

                        //         // tampilkan modal
                        //         $('#modalInfoTimer').modal('show');
                        //     },
                        //     error: function() {
                        //         alert('error');
                        //     }
                        // })
                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }
            // kalau ganti sesi
            else if (condition == 'back') {
                // tampilkan modal
                $('#modalInfoTimer').modal('show');

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
                        // $.ajax({
                        //     type: 'POST',
                        //     url: "{{ route('ganti.sesi') }}",
                        //     data: {
                        //         '_token': '<?php echo csrf_token(); ?>',
                        //         'sesi': $('#nomorSesi').attr('value')
                        //     },
                        //     success: function() {
                        //         // masuk pusher
                        //         // alert('success');

                        //         // tampilkan modal
                        //         $('#modalInfoTimer').modal('show');
                        //     },
                        //     error: function() {
                        //         alert('error');
                        //     }
                        // })
                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }
        })

        window.Echo.channel('analisisChannel').listen('.analisis', (e) => {
            console.log(e.analisis.sesi);
            // $('#footer-analisis').html(
            //     '<button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">OK!</button>'
            // );

            if (e.analisis.status == true) {
                $('#analisis-status').text('dibuka');
                // if (e.analisis.sesi == "2") {
                //     $('#footer-analisis').html(
                //         `<a href="{{ route('analisis') }}" class="btn btn-secondary mdl-close" >OK!</a>`
                //     );
                // }
            } else {
                $('#analisis-status').text('ditutup');
            }

            $('#modalInfoAnalisis').modal('show');
        });


        //disable inspect
        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                return false;
            }
        }
    </script>
</body>

</html>
