@extends('layouts.template')

@section('title', 'Admin')

@section('content')

    <body>
        <h1>Admin Sesi</h1>
        <h3>Angka Sesi : <span id="sesi"></span></h3>
        <h3>Sesi : <span id="nomorSesi" value="{{ $sesi[0]->sesi }}"> {{ $sesi[0]->nama }} </span></h3>
        <button type="button" class="btn btn-success" id="button_gantiSesi">Ganti Sesi</button>
        <button type="button" class="btn btn-success" id="button_back">Back Sesi</button>
    </body>

    <script>
        /* Ajax */
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
