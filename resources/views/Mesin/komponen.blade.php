@extends('layouts.template')

@section('title', 'Mesin')

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

        .noLevel {
            width: 60px;
            text-align: center;
            vertical-align: middle;
        }

        .namaKomponen {
            width: 140px;
            vertical-align: middle;
        }

        .class_kapasitasMesin {
            text-align: center;
            vertical-align: middle;
        }

        .class_defectMesin {
            text-align: center;
            vertical-align: middle;
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
                        <h1> <span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                    </div>
                </div>
            </div>

            <div class="row spacing"></div>

            {{-- Table Komponen --}}
            <table class="table" style="width:fit-content;">
                {{-- Heading --}}
                <thead class="thead">
                    <th>
                        <h4>Mesin : </h4>
                    </th>
                    <th style="vertical-align:middle;">
                        <select id='mesin' name="mesin">
                            @php
                                $arrMesin = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing', 'Drilling', 'Molding'];
                            @endphp
                            @foreach ($arrMesin as $mesin)
                                <option value="{{ $mesin }}">{{ $mesin }}</option>
                            @endforeach
                        </select>
                    </th>
                </thead>
                <tbody>
                    <tr style="background-color:#faf0dc;">
                        <td>Level Mesin : </td>
                        <td class="noLevel" id="levelMesin_">{{ $levelMesin[0]->level }}</td>
                    </tr>
                    @for ($x = 0; $x < count($data); $x++)
                        <tr>
                            <td id="nama_komponen_{{ $x }}" class="namaKomponen" style="width:150px;">
                                {{ $data[$x]->nama_komponen }} : </td>
                            <td id="komponen_{{ $x }}" class='noLevel'> {{ $data[$x]->level }} </td>
                            <td><button type="button" id="upgrade_{{ $x }}" class="upgrade"
                                    value='{{ $data[$x]->nama_komponen }}'>Upgrade</button></td>
                            {{-- <td><button type="button" class="btn btn-warning" id="upgradeA_mesin">Upgrade</button></td> --}}
                        </tr>
                    @endfor
                    {{-- Jangan dihapus dulu sapatau perlu buat template --}}
                    {{-- <tr>
                        <td class='namaKomponen' id="nama_komponen_0">{{ $data[0]->nama_komponen }} : </td>
                        <td id="komponen_0">{{ $data[0]->level }}</td>
                        <td><button type="button" class="upgrade" id="upgrade_0"
                                value='{{ $data[0]->nama_komponen }}'>Upgrade</button></td>
                        <td><button type="button" class="btn btn-warning" id="upgradeA_mesin">Upgrade</button></td>
                    </tr>
                    <tr>
                        <td class='namaKomponen' id="nama_komponen_1">{{ $data[1]->nama_komponen }} : </td>
                        <td id="komponen_1">{{ $data[1]->level }}</td>
                        <td><button type="button" class="upgrade" id="upgrade_1"
                                value='{{ $data[1]->nama_komponen }}'>Upgrade</button></td>
                        <td><button type="button" class="btn btn-warning" id="upgradeB_mesin">Upgrade</button></td>
                    </tr>
                    <tr>
                        <td class='namaKomponen' id="nama_komponen_2">{{ $data[2]->nama_komponen }} : </td>
                        <td id="komponen_2">{{ $data[2]->level }}</td>
                        <td><button type="button" class="upgrade" id="upgrade_2"
                                value='{{ $data[2]->nama_komponen }}'>Upgrade</button></td>
                        <td><button type="button" class="btn btn-warning" id="upgradeC_mesin">Upgrade</button></td>
                    </tr>
                    <tr>
                        <td class='namaKomponen' id="nama_komponen_3">{{ $data[3]->nama_komponen }} : </td>
                        <td id="komponen_3">{{ $data[3]->level }}</td>
                        <td><button type="button" class="upgrade" id="upgrade_3"
                                value='{{ $data[3]->nama_komponen }}'>Upgrade</button></td>
                        <td><button type="button" class="btn btn-warning" id="upgradeD_mesin">Upgrade</button></td>
                    </tr> --}}
                </tbody>
            </table>

            {{-- Informasi Mesin + Upgrade Kapasitas --}}
            <table class="table table-bordered" style="width:fit-content;">
                {{-- Heading --}}
                {{-- <thead class="thead">
                    <th>Nama Mesin</th>
                    <th>Level</th>
                    <th class="class_defectMesin">Defect</th>
                    <th class="class_kapasitasMesin">Kapasitas</th>
                    <th style="text-align:center;">Konfirmasi</th>
                </thead>
                <tbody>
                    @for ($x = 0; $x < count($listMesin); $x++)
                        <tr class="rowMesin">
                            <td id="namaMesin_{{ $x }}">{{ $listMesin[$x]->nama_mesin }}</td>
                            <td id="levelMesin_{{ $x }}" class="noLevel">{{ $listMesin[$x]->level }}
                            </td>
                            <td id="defect_mesin_{{ $x }}" class="class_defectMesin">0</td>
                            <td id="kapasitas_mesin_{{ $x }}" class="class_kapasitasMesin">
                                {{ $listMesin[$x]->kapasitas }}</td>
                            <td><button type="button" class="btn btn-success" id="button_{{$x}}">Konfirmasi</button></td>
                        </tr>
                    @endfor
                    <tr class="rowMesin">
                        <td id="namaMesin">Sorting</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">50</td>
                        <td><button type="button" class="btn btn-success" id="button_2">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Cutting</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">55</td>
                        <td><button type="button" class="btn btn-success" id="button_2">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Bending</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">50</td>
                        <td><button type="button" class="btn btn-success" id="button_3">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Assembling</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">50</td>
                        <td><button type="button" class="btn btn-success" id="button_4">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Packing</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">55</td>
                        <td><button type="button" class="btn btn-success" id="button_5">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Drilling</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">50</td>
                        <td><button type="button" class="btn btn-success" id="button_6">Konfirmasi</button></td>
                    </tr>
                    <tr class="rowMesin">
                        <td id="namaMesin">Molding</td>
                        <td class="noLevel" id="levelMesin_">1</td>
                        <td class="class_defectMesin" id="defect_mesin">0</td>
                        <td class="class_kapasitasMesin" id="kapasitas_mesin">50</td>
                        <td><button type="button" class="btn btn-success" id="button_7">Konfirmasi</button></td>
                    </tr>
                </tbody> --}}
            </table>
        </div>
        @php
            // Check Level
            // if ($a == 10 && $b == 10 && $c == 10 && $d == 10) {
            //     $level = 6;
            // } elseif ($a >= 8 && $b >= 8 && $c >= 8 && $d >= 8) {
            //     $level = 5;
            // } elseif ($a >= 6 && $b >= 6 && $c >= 6 && $d >= 6) {
            //     $level = 4;
            // } elseif ($a >= 4 && $b >= 4 && $c >= 4 && $d >= 4) {
            //     $level = 3;
            // } elseif ($a >= 2 && $b >= 2 && $c >= 2 && $d >= 2) {
            //     $level = 2;
            // }
        @endphp
        <script>
            $('#mesin').change(function() {
                // alert($('#mesin').val());
                $.ajax({
                    type: 'GET',
                    url: "{{ route('komponen.ajax') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'namaMesin': $('#mesin').val()
                    },
                    success: function(data) {
                        $.each(data.data, function(key, value) {
                            $('#nama_komponen_' + key).html(data.data[key].nama_komponen + ' :');
                            $('#komponen_' + key).html(data.data[key].level);
                            $('#upgrade_' + key).attr('value', data.data[key].nama_komponen);
                        });
                        $('#levelMesin_').html(data.levelMesin[0].level);
                    },
                    error: function() {

                    }
                })
            })

            $('.upgrade').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('upgrade.komponen') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'namaMesin': $('#mesin').val(),
                        'namaKomponen': $(this).val()
                    },
                    success: function(data) {
                        if (data.msg == 'Level Maxed') {
                            alert(data.msg);
                        } else if (data.msg == 'Dana tidak mencukupi') {
                            alert(data.msg);
                        } else {
                            $.each(data.data, function(key, value) {
                                $('#komponen_' + key).html(data.data[key].level);
                            });
                            $('#levelMesin_').html(data.levelMesin[0].level);
                            $('#dana').html(data.user[0].dana);
                        }
                        // alert('success');
                    },
                    error: function() {
                        // alert('error');
                    }
                })
            })
        </script>
    </body>
@endsection
