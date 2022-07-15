@extends('layouts.template')

@section('title', 'Admin')

@section('content')

    <body>
        <h1>Admin Sesi</h1>
        <h3>Sesi : <span id="nomorSesi" value="{{ $sesi[0]->sesi }}"> {{ $sesi[0]->nama }} </span></h3>
        <h3>Detail : <span id="detailSesi"></span></h3>
        <h3>Status : <span id="status">Paused</span></h3>
        <button type="button" class="btn btn-success" id="button_start">Start</button>
        <button type="button" class="btn btn-success" id="button_pause">Pause</button>
        <button type="button" class="btn btn-danger" id="button_stop" data-bs-toggle="modal"
            data-bs-target="#stop">Stop</button><br><br>
        <button type="button" class="btn btn-success" id="button_back">Back Sesi</button>
        <button type="button" class="btn btn-success" id="button_gantiSesi">Ganti Sesi</button>

        {{-- Modal --}}
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
    </body>

    <script>
        /* Ajax */
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
        $('#button_gantiSesi').click(function() {
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
                    }
                    // alert('success');
                },
                error: function() {
                    alert('error')
                }
            });
        });

        // buat back sesi
        $('#button_back').click(function() {
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
