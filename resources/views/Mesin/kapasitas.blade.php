@extends('layouts.template')

@section('title', 'Upgrade Kapasitas')

@section('content')
    <style>
        .heading{
        box-shadow: 0 6px 10px rgba(0,0,0,.08);
        padding:5px;
        }
        .nama_team{
            color:#ea435e;
        }
        .kapasitas {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }
        .upgrade{
            background-color: #ffc107;
            border: 1px #ffc107;
            border-radius: 5px;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-right: 12px;
            padding-left: 12px;
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

            {{--Nama Team dan Timer--}}
            <div class="row align-items-center rounded heading">
                <div class="col-9 nama_team">
                    <h1 id="namaTeam">Team {{--{{$user[0] -> nama}}--}}</h1> 
                </div>
                <div class="col-1"><h3 id="nomorSesi">Sesi {{--{{$nomorSesi}}--}}</h3></div>
            </div>

            <div class="row spacing"></div>

            {{-- Card Kapasitas --}}
            <div class="card-body kapasitas rounded">
                <table class="table table">
                    <thead class="thead">
                        <tr>
                            <th scope="col">Mesin</th>
                            <th scope="col" style="text-align:center;">Level</th>
                            <th class="class_kapasitasMesin" style="text-align:center;">Kapasitas</th>
                            <th scope="col" style="text-align:center;">Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td id='nama_mesin'>
                                    {{ $d->nama }}
                                </td>
                                <td id='level_kapasitas' style="text-align:center;">{{ $d->level }}</td>
                                <td id='kapasitas_kapasitas' style="text-align:center;">{{ $d->kapasitas }}</td>
                                <td style="text-align:center;vertical-align:center;">
                                    <button class='upgrade' value={{ $d->nama }}>Upgrade</button>
                                    {{-- <button type="button" class="btn btn-warning " value={{ $d->nama }}>Upgrade</button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    <script>
        $('.upgrade').click(function() {
            // alert($(this).val());
            $.ajax({
                type: 'POST',
                url: "{{ route('upgrade.kapasitas') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'namaMesin': $(this).val()
                },
                success: function(data) {
                    if (data.msg == 'Level Maxed') {
                        alert(data.msg);
                    }
                    $.each(data.data, function(key, value){
                        $('#nama_mesin').html(data.data[key].nama);
                        $('#level_kapasitas').html(data.data[key].level);
                        $('#kapasitas_kapasitas').html(data.data[key].kapasitas);
                    });
                    // location.reload()
                },
                error: function() {
                    
                    // location.reload();
                }
            })
        })
    </script>
@endsection
