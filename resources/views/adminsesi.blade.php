@extends('layouts.template')

@section('title', 'Admin')

@section('content')

    <body>
        <h1>Admin Sesi</h1>
        <h3>Sesi : <span id="nomorSesi" value="{{ $sesi[0]->sesi }}"> {{ $sesi[0]->nama }} </span></h3>
        <h3>Detail : <span id="detailSesi">{{ $detail }}</span></h3>
        <h3>Status : <span id="status"></span></h3>
        <button type="button" class="btn btn-success" id="button_start">Start</button>
        <button type="button" class="btn btn-success" id="button_pause">Pause</button>
        <button type="button" class="btn btn-danger" id="button_stop" data-bs-toggle="modal"
            data-bs-target="#stop">Stop</button><br><br>
        <button type="button" class="btn btn-success" id="button_back" data-bs-toggle="modal" data-bs-target="#back">Back
            Sesi</button>
        <button type="button" class="btn btn-success" id="button_ganti" data-bs-toggle="modal"
            data-bs-target="#ganti">Ganti Sesi</button>

        {{-- Modal --}}
        {{-- Konfirmasi Stop --}}
        <div class="modal fade" id="stop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="KonfirmasiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="KonfirmasiLabel">Stop Game</h5>
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
            aria-labelledby="KonfirmasiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="KonfirmasiLabel">Ganti Sesi</h5>
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
            aria-labelledby="KonfirmasiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="KonfirmasiLabel">Back Sesi</h5>
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
        /* Pusher */
        window.Echo.channel('sesiPusher').listen('.sesi', (e) => {
            // setting sesi
            $('#nomorSesi').attr('value', e.id);
            $('#nomorSesi').text(e.sesi);
            $('#detailSesi').text(e.detailSesi);
        })

        /* Ajax */
        $(document).ready(function() {
            let condition = localStorage.getItem('condition');
            if (condition == 'start') {
                $status = 'Started';
            } else if (condition == 'pause') {
                $status = 'Paused';
            } else if (condition == 'stop') {
                $status = 'Stopped';
            }
            $('#status').text($status);
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
                },
                error: function() {
                    alert('error');

                }
            })
        });

        // buat pause sesi
        $('#button_pause').click(function() {
            $.ajax({
                type: 'POST',
                url: "{{ route('pause.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    // alert('success');
                    $('#status').text(data.status);

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
                        $('#detailSesi').text(data.detail);
                        $('#status').text(data.status);

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
