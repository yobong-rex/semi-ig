@extends('layouts.template')

@section('title', 'Upgrade Kapasitas')

@section('content')
    <style>
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

        .dana {
            text-align: right;
        }

        .kapasitas {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

        .upgrade,
        .upgrade:focus {
            background-color: #ffc107;
            border: 1px #ffc107;
            border-radius: 5px;
            padding: 6px 12px 6px 12px;
            transition: all 0.2s ease;
        }

        .upgrade:hover {
            -webkit-transform: scale(1.07);
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

            {{-- Nama Team dan Timer --}}
            <div class="row align-items-center rounded heading">
                <div class="col-9 nama_team">
                    <h1 id="namaTeam">Team {{ $user[0]->nama }}</h1>
                </div>
                <div class="col-1">
                    <h3 id="nomorSesi">Sesi {{ $sesi[0]->sesi }}</h3>
                </div>
                <div class="col-1 text-center align-self-end timer rounded-2" style="font-family:TT Norms Regular;">
                    <h3>Timer</h3>
                    <h4 id="timer">- - : - -</h4>
                </div>
            </div>

            <div class="row spacing"></div>

            {{-- Card Dana --}}
            <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
                <div class="row align-items-center">
                    <div class="col-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-wallet2" viewBox="0 0 16 16">
                            <path
                                d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                        </svg>
                    </div>
                    <div class="col-2 label_dana">
                        <h1>Dana : </h1>
                    </div>
                    <div class="col-9 dana">
                        <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                    </div>
                </div>
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
                        @for ($x = 0; $x < count($data); $x++)
                            <tr style="vertical-align:middle;">
                                <td id='nama_mesin'>
                                    {{ $data[$x]->nama }}
                                </td>
                                <td id='level_kapasitas_{{ $data[$x]->nama }}' style="text-align:center;">
                                    {{ $data[$x]->level }}</td>
                                <td id='kapasitas_kapasitas_{{ $data[$x]->nama }}' style="text-align:center;">
                                    {{ $data[$x]->kapasitas }}</td>
                                <td style="text-align:center;vertical-align:center;">
                                    <button class='upgrade' value={{ $data[$x]->nama }}>Upgrade</button>
                                </td>
                            </tr>
                        @endfor
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
                    } else if (data.msg == 'Dana tidak mencukupi') {
                        alert(data.msg);
                    }
                    $.each(data.data, function(key, value) {
                        // $('#nama_mesin').html(data.data[key].nama);
                        $('#level_kapasitas_' + data.data[key].nama).html(data.data[key].level);
                        $('#kapasitas_kapasitas_' + data.data[key].nama).html(data.data[key].kapasitas);
                    });
                    $('#dana').html(data.user[0].dana);
                    // alert(data.user[0].dana);
                    // location.reload()
                },
                error: function() {

                    // location.reload();
                }
            })
        })
    </script>
@endsection
