@extends('layouts.template')

@section('title', 'Admin')

@section('content')

    <body>
        <h1>Admin Sesi</h1>
        <h3>Sesi : <span id="nomorSesi" value='{{ $sesi[0]->sesi }}'> {{ $sesi[0]->sesi }} </span></h3>
        <button type="button" class="btn btn-success" id="button_gantiSesi">Ganti Sesi</button>
        <button type="button" class="btn btn-success" id="button_back">Back Sesi</button>
    </body>
    <script>
        $('#button_gantiSesi').click(function() {
            // alert($('#nomorSesi').html());
            $.ajax({
                type: 'POST',
                url: "{{ route('ganti.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'sesi': $('#nomorSesi').html()
                },
                success: function(data) {
                    if (data.msg == 'Sesi Sudah Max Woe!!') {
                        alert(data.msg);
                    } else {
                        $('#nomorSesi').attr('value', data.sesi[0].sesi);
                        $('#nomorSesi').html(data.sesi[0].sesi);
                    }
                    // alert('success');
                },
                error: function() {
                    alert('error')
                }
            });
        });

        $('#button_back').click(function() {
            // alert($('#nomorSesi').html());
            $.ajax({
                type: 'POST',
                url: "{{ route('back.sesi') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'sesi': $('#nomorSesi').html()
                },
                success: function(data) {
                    if (data.msg == 'Sesi Sudah Gabisa Kurang Woe!!') {
                        alert(data.msg);
                    } else {
                        $('#nomorSesi').attr('value', data.sesi[0].sesi);
                        $('#nomorSesi').html(data.sesi[0].sesi);
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
