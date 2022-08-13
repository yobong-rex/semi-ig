@extends('layouts.template')

@section('title', 'Admin')

@section('admin')

    <body>
        <h1>Admin Sesi</h1>
        <h3>Sesi : <span id="nomorSesi" value="{{ $sesi[0]->sesi }}"> {{ $sesi[0]->nama }} </span></h3>
        <h3>Detail : <span id="detailSesi">{{ $detail }}</span></h3>
        <h3>Status : <span id="status"></span></h3>
        <div class="col-md-2 flex text-center align-self-end timer rounded-2" style="font-family:TT Norms Regular;">
            <h4>Server Time</h4>
            <h4 id="timer">- - : - -</h4>
        </div>
        <button type="button" class="btn btn-success" id="button_start">Start</button>
        <button type="button" class="btn btn-success" id="button_pause" data-bs-toggle="modal"
            data-bs-target="#pause">Pause</button>
        <button type="button" class="btn btn-danger" id="button_stop" data-bs-toggle="modal"
            data-bs-target="#stop">Stop</button><br><br>
        <button type="button" class="btn btn-success" id="button_back" data-bs-toggle="modal" data-bs-target="#back">Back
            Sesi</button>
        <button type="button" class="btn btn-success" id="button_ganti" data-bs-toggle="modal"
            data-bs-target="#ganti">Ganti Sesi</button>

        {{-- Modal --}}
        {{-- Konfirmasi Pause --}}
        <div class="modal fade" id="pause" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="pauseLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pauseLabel">Pause Game</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin ingin Pause Game?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        {{-- button konfirmasi pause --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_pause"
                            data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfirmasi Stop --}}
        <div class="modal fade" id="stop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="stopLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stopLabel">Stop Game</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin ingin Stop Game?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        {{-- button konfirmasi upgrade --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_stop"
                            data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfirmasi Ganti Sesi --}}
        <div class="modal fade" id="ganti" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="gantiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="gantiLabel">Ganti Sesi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin ingin Ganti Sesi?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        {{-- button konfirmasi upgrade --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_ganti"
                            data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konfirmasi Back Sesi --}}
        <div class="modal fade" id="back" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="backLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="backLabel">Back Sesi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin ingin Back Sesi?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        {{-- button konfirmasi upgrade --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_back"
                            data-bs-dismiss="modal">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="../js/app.js"></script>
    <script>
        let x = null;

        /* Ajax */
        $(document).ready(function() {
            let condition = localStorage.getItem('condition');
            console.log(condition);

            if (condition == 'start') {
                $status = 'Started';
                $('#status').text($status);

                /* Timer */
                clearInterval(x);
                console.log('masuk start');

                // variable used to continue timer
                var timeInMs = localStorage.getItem('timer');
                console.log(timeInMs);

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
                        localStorage.setItem('timer', distance);
                        console.log(localStorage.getItem('timer'));

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
            } else if (condition == 'pause') {
                clearInterval(x);

                $status = 'Paused';
                $('#status').text($status);
            } else if (condition == 'stop') {
                clearInterval(x);

                $status = 'Stopped';
                $('#status').text($status);
            }
        })

        /* Pusher */
        window.Echo.channel('sesiPusher').listen('.sesi', (e) => {
            // setting sesi
            $('#nomorSesi').attr('value', e.id);
            $('#nomorSesi').text(e.sesi);
            $('#detailSesi').text(e.detailSesi);
        })


        // buat start sesi
        $('#button_start').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('start.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    // alert('success');
                    $('#status').text(data.status);

                    clearInterval(x);
                    localStorage.setItem('condition', 'start');
                    console.log('masuk start');

                    let timer = null;
                    let countdownTimer = null;

                    var timeInMs = localStorage.getItem('timer');

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
                            // console.log(now);
                            let distance = countdownTimer - now;
                            // console.log(distance);

                            // jadikan minutes : second
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 *
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

                            // tamplikan ke halaman user pakai pusher
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('timer') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'minute': minutes,
                                    'second': seconds
                                },
                                success: function() {
                                    // alert('success');
                                },
                                error: function() {
                                    alert('error');
                                }
                            })

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem('timer', distance);
                            console.log(localStorage.getItem('timer'));

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
                        timer = data.waktu * 1000;
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

                            // tamplikan ke halaman user pakai pusher
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('timer') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'minute': minutes,
                                    'second': seconds
                                },
                                success: function() {
                                    // alert('success');
                                },
                                error: function() {
                                    alert('error');
                                }
                            })

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem('timer', distance);
                            console.log(localStorage.getItem('timer'));

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
                },
                error: function() {
                    alert('error');
                }
            })
        });

        // buat pause sesi
        $('#konfirmasi_pause').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('pause.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    // alert('success');
                    $('#status').text(data.status);
                    localStorage.setItem('condition', 'pause');

                    clearInterval(x);
                },
                error: function() {
                    alert('error');

                }
            })
        });

        // buat stop sesi
        $('#konfirmasi_stop').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('stop.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    // alert('success');
                    $('#status').text(data.status);
                    localStorage.setItem('condition', 'stop');

                    clearInterval(x);

                    // reset timer
                    localStorage.removeItem('timer');
                    console.log(localStorage.getItem('timer'));

                    // ganti timer ke default
                    $('#timer').text('- - : - -');

                    // tamplikan ke halaman user pakai pusher
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('timer') }}",
                        data: {
                            '_token': '<?php echo csrf_token(); ?>',
                            'minute': '- - ',
                            'second': ' - -'
                        },
                        success: function() {
                            // alert('success');
                        },
                        error: function() {
                            alert('error');
                        }
                    })
                },
                error: function() {
                    alert('error');

                }
            })
        });

        // buat ganti sesi
        $('#konfirmasi_ganti').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('ganti.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'sesi': $('#nomorSesi').attr('value')
                },
                success: function(data) {
                    if (data.msg == 'Sesi Sudah Max Woe!!') {
                        alert(data.msg);
                    } else {
                        $('#nomorSesi').attr('value', data.sesi[0].sesi);
                        $('#nomorSesi').text(data.sesi[0].nama);
                        $('#detailSesi').text(data.d2etail);
                        $('#status').text(data.status);

                        // tampilkan modal 1 kali
                        // $('#modalInfoTimer').modal('show');
                        let status = 'ganti';

                        // set condition supaya waktu reload masih jalan
                        localStorage.setItem('condition', 'start');

                        clearInterval(x);
                        console.log('masuk ganti');

                        timer = data.waktu * 1000;

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

                            // tamplikan ke halaman user pakai pusher
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('timer') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'minute': minutes,
                                    'second': seconds,
                                    'status': status
                                },
                                success: function() {
                                    // alert('success');
                                },
                                error: function() {
                                    alert('error');
                                }
                            })

                            status = '';

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem('timer', distance);
                            console.log(localStorage.getItem('timer'));

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
                    // alert('success');
                },
                error: function() {
                    alert('error')
                }
            });
        });

        // buat back sesi
        $('#konfirmasi_back').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('back.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'sesi': $('#nomorSesi').attr('value')
                },
                success: function(data) {
                    if (data.msg == 'Sesi Sudah Gabisa Kurang Woe!!') {
                        alert(data.msg);
                    } else {
                        $('#nomorSesi').attr('value', data.sesi[0].sesi);
                        $('#nomorSesi').text(data.sesi[0].nama);
                        $('#detailSesi').text(data.detail);
                        $('#status').text(data.status);

                        // tampilkan modal 1 kali
                        // $('#modalInfoTimer').modal('show');
                        let status = 'back';

                        // set condition supaya waktu reload masih jalan
                        localStorage.setItem('condition', 'start');

                        clearInterval(x);
                        console.log('masuk ganti');

                        timer = data.waktu * 1000;

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

                            // tamplikan ke halaman user pakai pusher
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('timer') }}",
                                data: {
                                    '_token': '<?php echo csrf_token(); ?>',
                                    'minute': minutes,
                                    'second': seconds,
                                    'status': status
                                },
                                success: function() {
                                    // alert('success');
                                },
                                error: function() {
                                    alert('error');
                                }
                            })

                            status = '';

                            // masukkan timer dan tanggal sekarang ke localStorage per detik
                            localStorage.setItem('timer', distance);
                            console.log(localStorage.getItem('timer'));

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
                    // alert('success');
                },
                error: function() {
                    alert('error')
                }
            });
        });
    </script>
@endsection
