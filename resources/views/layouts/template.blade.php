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
        .navbar{

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

        .buttonNav {
            padding-left: 0.5
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

            .nav-link:focus,
            .nav-link:hover,
            .nav-link:active {
                transition: all 0.2s ease;
            }
        }

        @media (max-width:1000px) {
            .coloumn_sesi {
                max-width: fit-content;
            }

            .nav-link:focus,
            .nav-link:hover,
            .nav-link:active {
                transition: all 0.2s ease;
            }
        }
    </style>

    {{-- CSS Tambahan Internal --}}
    @yield('css')

</head>

{{-- <body oncontextmenu="return false"> --}}

<body>
    {{-- NavBar --}}
    <nav class="navbar navbar-expand-lg sticky-top" style="background-color: #ffff; box-shadow: 5px 0px 5px rgba(0, 0, 0, 0.3);">
        <div class="container-fluid gap-5">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('assets') }}/logo/Logo_IG_Header.png" alt="Logo IGXXX" style="max-height: 40px">
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                        <path
                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                    </svg></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse" style="justify-content:">

                
                <ul class="navbar-nav mb-2 mb-lg-0 gap-4">
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                            href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if($valueSesi != 0)
                        @can('isMarketing')
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('komponen') }}">Mesin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('kapasitas') }}">Kapasitas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('demand') }}">Demand</a>
                            </li>
                        @elsecan('isResearcher')
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('bahan') }}">Analisis Bahan</a>
                            </li>
                        @elsecan('isProduction_Manager')
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('produksi') }}">Produksi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                                    href="{{ route('analisis') }}">Analisis Produksi</a>
                            </li>
                        @endcan
                    @endif
                    <!-- <li class="nav-item">
                        <a class="nav-link active" style="padding-left:0.5em" aria-current="page"
                            href="{{ route('leaderboard') }}">Leaderboard</a>
                    </li> -->
                </ul>
                <div class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-light nav-link active logOut" aria-current="page"
                            style="text-decoration:none;padding-left:0.5em;">
                            {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                        </form>
                    </li>
                </div>
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
                    @can('isProduction_Manager')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary mdl-close">OK!</a>
                    @elsecan('isMarketing')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary mdl-close">OK!</a>
                    @elsecan('isResearcher')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary mdl-close">OK!</a>
                    @else
                        <button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">OK!</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <!-- end modal info timer-->


    <!-- modal info analisis-->
    <div class="modal fade" id="modalInfoAnalisis" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
        /*$(document).ready(function() {
            let condition = localStorage.getItem('condition');

            // kalau game sudah start
            if (condition == 'start') {

                clearInterval(x);
                console.log('masuk start');

                // variable used to continue timer
                const key = 'timer';
                var timeInMs = localStorage.getItem(key);
                // console.log(timeInMs);

                // kalau sudah pernah buka web ini
                if (timeInMs) {
                    // timer lanjut dari waktu sebelum reload
                    let timer = parseInt(timeInMs);
                    // console.log(timer);

                    // set destinasi stop
                    let nowAwal = new Date().getTime();
                    // console.log(nowAwal);
                    let countdownTimer = nowAwal + timer;
                    // console.log(countdownTimer);

                    x = setInterval(function() {
                        let now = new Date().getTime();
                        // console.log(now);
                        let distance = countdownTimer - now;
                        // console.log(distance);

                        // jadikan minutes : second
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // kalau tidak double digit jadikan double digit
                        if (minutes < 10) {
                            minutes = '0' + minutes;
                        }
                        if (seconds < 10) {
                            seconds = '0' + seconds;
                        }

                        // tampilkan timer
                        $('#timer').text(minutes + " : " + seconds);

                        // masukkan timer dan tanggal sekarang ke localStorage per detik
                        localStorage.setItem(key, distance);
                        console.log(localStorage.getItem(key));

                        // kalau sudah habis, maka selesai
                        if (distance < 0) {
                            // hapus timer sekarang
                            clearInterval(x);
                            localStorage.clear();
                            $('#timer').text('00 : 00');

                            // lanjut sesi berikutnya

                        }
                    }, 1000)
                }
            }
            //  kalau game pause
            else if (condition == 'pause') {
                clearInterval(x);
                console.log('masuk pause');
            }
            //  kalau game stop
            else if (condition == 'stop') {
                clearInterval(x);
                console.log('masuk stop');
            }
        })*/


        window.Echo.channel('sesiPusher').listen('.sesi', (e) => {
            console.log(e.id);
            console.log(e.sesi);
            console.log(e.waktu);
            console.log(e.condition);

            // setting sesi
            $('#nomorSesi').attr('value', e.id);
            $('#sesi').text(e.sesi);

            // setting timer
            /*let waktu = e.waktu;
            let timer = null;
            // console.log(timer);
            let countdownTimer = null;
            // console.log(countdownTimer);

            // set condition: start; pause; stop; ganti; back
            localStorage.setItem('condition', e.condition);
            let condition = localStorage.getItem('condition');
            // console.log(condition);


            // variable buat continue timer
            const key = 'timer';
            var timeInMs = localStorage.getItem(key);
            // console.log(timeInMs);

            // kalau game berjalan
            if (condition == 'start') {
                clearInterval(x);
                console.log('masuk start');

                // kalau sudah pernah buka web ini
                if (timeInMs) {
                    // timer lanjut dari waktu sebelum reload
                    timer = parseInt(timeInMs);
                    // console.log(timer);

                    // set destinasi stop
                    let nowAwal = new Date().getTime();
                    // console.log(nowAwal);
                    countdownTimer = nowAwal + timer;
                    // console.log(countdownTimer);

                    x = setInterval(function() {
                        let now = new Date().getTime();
                        console.log(now);
                        let distance = countdownTimer - now;
                        // console.log(distance);

                        // jadikan minutes : second
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // kalau tidak double digit jadikan double digit
                        if (minutes < 10) {
                            minutes = '0' + minutes;
                        }
                        if (seconds < 10) {
                            seconds = '0' + seconds;
                        }

                        // tampilkan timer
                        $('#timer').text(minutes + " : " + seconds);

                        // masukkan timer dan tanggal sekarang ke localStorage per detik
                        localStorage.setItem(key, distance);
                        console.log(localStorage.getItem(key));

                        // kalau sudah habis, maka selesai
                        if (distance < 0) {
                            // hapus timer sekarang
                            clearInterval(x);
                            localStorage.clear();
                            $('#timer').text('00 : 00');

                            // lanjut sesi berikutnya

                        }
                    }, 1000)
                }
                // kalau belum pernah buka web ini
                else {
                    timer = waktu * 1000;
                    // console.log(timer);

                    // set destinasi stop
                    let nowAwal = new Date().getTime();
                    // console.log(nowAwal);
                    countdownTimer = nowAwal + timer;
                    // console.log(countdownTimer);

                    // buat timer baru
                    x = setInterval(function() {
                        let now = new Date().getTime();
                        // console.log(now);
                        let distance = countdownTimer - now;
                        // console.log(distance);

                        // jadikan minutes : second
                        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (
                            1000 *
                            60));
                        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // kalau tidak double digit jadikan double digit
                        if (minutes < 10) {
                            minutes = '0' + minutes;
                        }
                        if (seconds < 10) {
                            seconds = '0' + seconds;
                        }

                        // tampilkan timer
                        $('#timer').text(minutes + " : " + seconds);

                        // masukkan timer dan tanggal sekarang ke localStorage per detik
                        localStorage.setItem(key, distance);
                        console.log(localStorage.getItem(key));

                        // kalau sudah habis, maka selesai
                        if (distance < 0) {
                            // hapus timer sekarang
                            clearInterval(x);
                            localStorage.clear();
                            $('#timer').text('00 : 00');

                            // lanjut sesi berikutnya

                        }
                    }, 1000)
                }
            }
            //  kalau game pause
            else if (condition == 'pause') {
                clearInterval(x);
                console.log('masuk pause');
            }
            //  kalau game stop
            else if (condition == 'stop') {
                clearInterval(x);

                // reset timer
                localStorage.removeItem(key);
                console.log(localStorage.getItem(key));

                // ganti timer ke default
                $('#timer').text('- - : - -');
                console.log('masuk stop');
            }
            // kalau ganti sesi
            else if (condition == 'ganti') {
                // tampilkan modal
                $('#modalInfoTimer').modal('show');

                clearInterval(x);
                console.log('masuk ganti');

                timer = waktu * 1000;

                // set destinasi stop
                let nowAwal = new Date().getTime();
                countdownTimer = nowAwal + timer;

                // buat timer baru
                x = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = countdownTimer - now;

                    // jadikan minutes : second
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (
                        1000 *
                        60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // kalau tidak double digit jadikan double digit
                    if (minutes < 10) {
                        minutes = '0' + minutes;
                    }
                    if (seconds < 10) {
                        seconds = '0' + seconds;
                    }

                    // tampilkan timer
                    $('#timer').text(minutes + " : " + seconds);

                    // masukkan timer dan tanggal sekarang ke localStorage per detik
                    localStorage.setItem(key, distance);
                    console.log(localStorage.getItem(key));

                    // kalau sudah habis, maka selesai
                    if (distance < 0) {
                        // hapus timer sekarang
                        clearInterval(x);
                        localStorage.clear();
                        $('#timer').text('00 : 00');

                        // lanjut sesi berikutnya

                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }
            // kalau back sesi
            else if (condition == 'back') {
                // tampilkan modal
                $('#modalInfoTimer').modal('show');

                clearInterval(x);
                console.log('masuk back');

                timer = waktu * 1000;

                // set destinasi stop
                let nowAwal = new Date().getTime();
                countdownTimer = nowAwal + timer;

                // buat timer baru
                x = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = countdownTimer - now;

                    // jadikan minutes : second
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (
                        1000 *
                        60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // kalau tidak double digit jadikan double digit
                    if (minutes < 10) {
                        minutes = '0' + minutes;
                    }
                    if (seconds < 10) {
                        seconds = '0' + seconds;
                    }

                    // tampilkan timer
                    $('#timer').text(minutes + " : " + seconds);

                    // masukkan timer dan tanggal sekarang ke localStorage per detik
                    localStorage.setItem(key, distance);
                    console.log(localStorage.getItem(key));

                    // kalau sudah habis, maka selesai
                    if (distance < 0) {
                        // hapus timer sekarang
                        clearInterval(x);
                        localStorage.clear();
                        $('#timer').text('00 : 00');

                        // lanjut sesi berikutnya

                    }
                }, 1000)

                // set condition supaya waktu reload masih jalan
                localStorage.setItem('condition', 'start');
            }*/
        })

        window.Echo.channel('timePusher').listen('.time', (e) => {
            console.log(e.minute);
            console.log(e.second);
            console.log(e.status);

            if (e.status == 'ganti' || e.status == 'back') {
                $('#modalInfoTimer').modal('show');
            }

            $('#timer').text(e.minute + " : " + e.second);
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
        // document.onkeydown = function(e) {
        //     if(event.keyCode == 123) {
        //         return false;
        //     }
        //     if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        //         return false;
        //     }
        //     if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        //         return false;
        //     }
        //     if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        //         return false;
        //     }
        //     if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        //         return false;
        //     }
        // }
    </script>
</body>

</html>
