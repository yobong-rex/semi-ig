@extends('layouts.template')

@section('title', 'Test Timer')

@section('content')

    <body>
        <p id="timer"></p>
        <script>
            let waktu = 120;

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
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 * 60));
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
                        localStorage.setItem('now', Date.now());
                        // console.log(localStorage.getItem(key));
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
                        let minutes = Math.floor((timer % (1000 * 60 * 60)) / (1000 * 60));
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
                        localStorage.setItem('now', Date.now());
                        // console.log(localStorage.getItem(key));
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
        </script>
    </body>
@endsection
