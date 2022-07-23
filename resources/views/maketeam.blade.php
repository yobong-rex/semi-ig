@extends('layouts.template')

@section('title', 'Test Make Team')

@section('admin')

    <body>
        <input id='namaTeam' type="text">
        <button id='maketeam'>Make Team</button>
    </body>
    <script>
        $('#maketeam').click(function() {
            // alert($('#namaTeam').val());
            $.ajax({
                type: 'POST',
                url: "{{ route('makeTeam') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'namaTeam': $('#namaTeam').val()
                },
                success: function(data) {
                    if (data.msg == 'Nama Team Harus Diisi!!!') {
                        alert(data.msg);
                    } else if (data.msg == 'Nama Team Sudah Terpakai') {
                        alert(data.msg);
                    } else if (data.msg == 'berhasil') {
                        alert(data.msg);
                    }
                    // alert('success');
                },
                error: function() {
                    alert('error');
                }
            })
        });
    </script>
@endsection
