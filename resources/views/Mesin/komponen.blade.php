@extends('layouts.template')

@section('title', 'Mesin')

@section('content')
    <style>
        .heading,.kartu_tabel {
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
        .kartu_tabel{
            background-color: #ffffff;
            width: fit-content;
        }
        @media (max-width:800px){
            .dana, .label_dana{
                text-align: center;
            }
        }

        @media (max-width:1000px){
            .dana, .label_dana{
                font-size: 25px;
            }
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">


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
                </div>
            </div>
        </div>

            <div class="row spacing"></div>

            {{-- Card Dana --}}
            <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
                <div class="row align-items-center">
                    <div class="col-md-1 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-wallet2" viewBox="0 0 16 16">
                            <path
                                d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                        </svg>
                    </div>
                    <div class="col-md-2 label_dana text-center">
                        <h1>Dana :</h1> 
                    </div>
                    <div class="col-md-9 dana">
                        <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                    </div>
                </div>
            </div>

            <div class="row spacing"></div>

            <div class="card-body kartu_tabel">
                {{-- Table Komponen --}}
                <table class="table" style="width:fit-content;">
                    {{-- Heading --}}
                    <thead class="thead">
                        <th>
                            <h4>Mesin : </h4>
                        </th>
                        {{-- ComboBox Mesin --}}
                        <th style="vertical-align:middle;">
                            <select id='mesin' name="mesin">
                                @php
                                    $arrMesin = [];
                                    for ($a = 0; $a < count($namaMesin); $a++) {
                                        array_push($arrMesin, $namaMesin[$a]->nama);
                                    }
                                @endphp
                                @foreach ($arrMesin as $mesin)
                                    <option value="{{ $mesin }}">{{ $mesin }}</option>
                                @endforeach
                            </select>
                        </th>
                    </thead>
                    {{-- Nama-nama Komponen --}}
                    <tbody>
                        <tr style="background-color:#faf0dc;">
                            <td>Level Mesin : </td>
                            <td class="noLevel" id="levelMesin_">{{ $levelMesin[0]->level }}</td>
                        </tr>
                        @for ($x = 0; $x < count($data); $x++)
                            <tr>
                                <td id="nama_komponen_{{ $x }}" class="namaKomponen" style="width:150px;">
                                    {{ $data[$x]->nama_komponen }} :
                                </td>
                                <td id="komponen_{{ $x }}" class='noLevel'>
                                    {{ $data[$x]->level }}
                                </td>
                                <td>
                                    {{-- button Upgrade --}}
                                    <button type="button" id="upgrade_{{ $x }}" class="upgrade"
                                        value='{{ $data[$x]->nama_komponen }}' data-bs-toggle="modal"
                                        data-bs-target="#Konfirmasi">Upgrade</button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal --}}
        {{-- Modal Konfirmasi Upgrade --}}
        <div class="modal fade" id="Konfirmasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="KonfirmasiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="KonfirmasiLabel">Upgrade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin ingin Upgrade Komponen <b><span id='komponenNama'></span></b> dari Mesin <b><span
                                id='mesinNama'></span></b> ?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        {{-- button konfirmasi upgrade --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_upgrade"
                            data-bs-dismiss="modal">Upgrade</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Notif --}}
        <div class="modal fade" id="Notif" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="NotifLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="NotifLabel">Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        <h4><span id='notifUpgrade'></span></h4>
                    </div>
                    <div class="modal-footer">
                        {{-- button ok --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

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
                        // alert('error');
                    }
                })
            })

            let namaMesin = "";
            let namaKomponen = "";

            $('.upgrade').click(function() {
                namaMesin = $('#mesin').val();
                namaKomponen = $(this).val();
                $('#mesinNama').text(namaMesin);
                $('#komponenNama').text(namaKomponen);
            })

            $('#konfirmasi_upgrade').click(function() {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('upgrade.komponen') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'namaMesin': namaMesin,
                        'namaKomponen': namaKomponen
                    },
                    success: function(data) {
                        // alert('success');
                        if (data.msg == 'Level Maxed') {
                            $('#notifUpgrade').text(data.msg);
                            $('#Notif').modal('show');
                        } else if (data.msg == 'Dana Tidak Mencukupi') {
                            $('#notifUpgrade').text(data.msg);
                            $('#Notif').modal('show');
                        } else {
                            $('#notifUpgrade').text(data.msg);
                            $('#Notif').modal('show');
                            $.each(data.data, function(key, value) {
                                $('#komponen_' + key).html(data.data[key].level);
                            });
                            $('#levelMesin_').html(data.levelMesin[0].level);
                            $('#dana').html(data.user[0].dana);
                        }
                    },
                    error: function() {
                        alert('error');
                    }
                })
            })
        </script>
    </body>
@endsection
