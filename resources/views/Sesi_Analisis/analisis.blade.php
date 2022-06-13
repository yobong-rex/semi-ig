@extends('layouts.template')

@section('title', 'Sesi Analisis')

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

        .nomor {
            width: 50px;
            text-align: center;
        }

        .penomoran {
            width: 110px;
            text-align: center;
        }
    </style>
    {{-- DOKUMENTASI ID --}}
    {{-- proses_{nomor proses produksi}_{urutan ke}
    button_{nomor proses produksi} --}}

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
            <h1>Sesi Analisis</h1>

            {{-- tabel analisis --}}
            <form action="">
                <table class="table table-bordered" style="vertical-align: middle;">
                    <thead class="thead">
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col" colspan="9" style="text-align:center;">Urutan Produksi Produk</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;">Konfirmasi</th>
                        </tr>
                        <tr>
                            <th class="nomor" scope="col">Nomor</th>
                            @for ($i = 1; $i <= 9; $i++)
                                <th class="penomoran" scope="col">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        {{-- id proses_(prosesId) --}}
                        @for ($i = 1; $i <= 3; $i++)
                            <tr id="tr_{{ $i }}">
                                <th class="nomor" scope="row">Proses Produksi {{ $i }}</th>
                                @for ($j = 1; $j <= 9; $j++)
                                    <td>
                                        <select name="proses" id="proses_{{ $i }}_{{ $j }}">
                                            <option value="">-Select-</option>
                                            @foreach ($mesin as $m)
                                                <option value='{{ $m->nama }}' kapasitas='{{ $m->kapasitas }}'
                                                    time='{{ $m->cycle }}'>{{ $m->nama }}</option>
                                            @endforeach
                                            <option value="Idle" kapasitas="0" time="0">Idle</option>
                                            <option value="Delay" kapasitas="0" time="0">Delay</option>
                                        </select>
                                    </td>
                                @endfor
                                <td><button type="button" id="button_{{ $i }}" class="btn btn-success"
                                        value="{{ $i }}">Konfirmasi</button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </form>
        </div>
    </body>
@endsection

@section('ajaxquery')
    <script>
        function coba_coba() {
            $.ajax({
                type: "POST",
                url: "{{ route('coba') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    $.each(data.mesin, function(key, value) {
                        $('#coba-text').html(data.mesin[key].nama)
                    });
                }
            });
        }

        $('#button_1').click(function() {
            // alert($(this).val());
            var arrProses = [];
            let arrKapasitas = [];
            let arrCycle = [];
            var prosesInsert = '';
            for (var x = 1; x <= 9; x++) {
                var proses = $("#proses_1_" + x).val();
                var kapasitas = $('option:selected', "#proses_1_" + x).attr('kapasitas');
                var cycle = $('option:selected', "#proses_1_" + x).attr('time');
                arrProses.push(proses);
                arrKapasitas.push(kapasitas);
                arrCycle.push(cycle);
            }

            arrProses1 = jQuery.grep(arrProses, function(value) {
                return value != '';
            });

            for (var x = 0; x < arrProses.length; x++) {
                prosesInsert += arrProses[x] + ";";
            }
            var panjang = arrProses1.length;

            $.ajax({
                type: "POST",
                url: "{{ route('analisis.proses') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'produksi': 1,
                    'panjang': panjang,
                    'proses': prosesInsert,
                    'kapasitas': arrKapasitas,
                    'cycle': arrCycle
                },
                success: function(data) {
                    if (data.msg == 'Dana Tidak Mencukupi') {
                        alert(data.msg);
                    } else if (data.msg == 'Proses Kurang Panjang, Minimal Proses = 4') {
                        alert(data.msg);
                    } else {
                        $('#dana').html(data.user[0].dana);
                        var notEfficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Delay',
                            'Cutting', 'Assembling', 'Sorting', 'Packing'
                        ];
                        var efficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];

                        var status = true;
                        if (efficient.length == panjang) {
                            for (var x = 0; x < efficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else if (notEfficient.length == panjang) {
                            for (var x = 0; x < notEfficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else {
                            status = false;
                        }

                        if (status == false) {
                            alert('Not Efficient');
                        } else {
                            alert('Efficient');
                        }
                    }
                },
                error: function() {
                    alert('error');
                }
            });
        });

        $('#button_2').click(function() {
            var arrProses = [];
            let arrKapasitas = [];
            let arrCycle = [];
            var prosesInsert = '';
            for (var x = 1; x <= 9; x++) {
                var proses = $("#proses_2_" + x).val();
                var kapasitas = $('option:selected', "#proses_2_" + x).attr('kapasitas');
                var cycle = $('option:selected', "#proses_2_" + x).attr('time');
                arrProses.push(proses);
                arrKapasitas.push(kapasitas);
                arrCycle.push(cycle);
            }

            arrProses1 = jQuery.grep(arrProses, function(value) {
                return value != '';
            });

            for (var x = 0; x < arrProses.length; x++) {
                prosesInsert += arrProses[x] + ";";
            }
            var panjang = arrProses1.length;

            $.ajax({
                type: "POST",
                url: "{{ route('analisis.proses') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'produksi': 2,
                    'panjang': panjang,
                    'proses': prosesInsert,
                    'kapasitas': arrKapasitas,
                    'cycle': arrCycle
                },
                success: function(data) {
                    if (data.msg == 'Dana Tidak Mencukupi') {
                        alert(data.msg);
                    } else if (data.msg == 'Proses Kurang Panjang, Minimal Proses = 4') {
                        alert(data.msg);
                    } else {
                        $('#dana').html(data.user[0].dana);
                        var notEfficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Delay',
                            'Cutting', 'Assembling', 'Idle', 'Packing'
                        ];
                        var efficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Packing'];

                        var status = true;
                        if (efficient.length == panjang) {
                            for (var x = 0; x < efficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else if (notEfficient.length == panjang) {
                            for (var x = 0; x < notEfficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else {
                            status = false;
                        }

                        if (status == false) {
                            alert('Not Efficient');
                        } else {
                            alert('Efficient');
                        }
                    }
                },
                error: function() {
                    alert('error');
                }
            });
        });

        $('#button_3').click(function() {
            var arrProses = [];
            let arrKapasitas = [];
            let arrCycle = [];
            var prosesInsert = '';
            for (var x = 1; x <= 9; x++) {
                var proses = $("#proses_3_" + x).val();
                var kapasitas = $('option:selected', "#proses_3_" + x).attr('kapasitas');
                var cycle = $('option:selected', "#proses_3_" + x).attr('time');
                arrProses.push(proses);
                arrKapasitas.push(kapasitas);
                arrCycle.push(cycle);
            }

            arrProses1 = jQuery.grep(arrProses, function(value) {
                return value != '';
            });

            for (var x = 0; x < arrProses.length; x++) {
                prosesInsert += arrProses[x] + ";";
            }
            var panjang = arrProses1.length;

            $.ajax({
                type: "POST",
                url: "{{ route('analisis.proses') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'produksi': 3,
                    'panjang': panjang,
                    'proses': prosesInsert,
                    'kapasitas': arrKapasitas,
                    'cycle': arrCycle
                },
                success: function(data) {
                    if (data.msg == 'Dana Tidak Mencukupi') {
                        alert(data.msg);
                    } else if (data.msg == 'Proses Kurang Panjang, Minimal Proses = 4') {
                        alert(data.msg);
                    } else {
                        $('#dana').html(data.user[0].dana);
                        var notEfficient = ['Sorting', 'Molding', 'Idle', 'Assembling', 'Sorting',
                            'Delay',
                            'Assembling', 'Packing'
                        ];
                        var efficient = ['Sorting', 'Molding', 'Assembling', 'Packing'];

                        var status = true;
                        if (efficient.length == panjang) {
                            for (var x = 0; x < efficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else if (notEfficient.length == panjang) {
                            for (var x = 0; x < notEfficient.length; x++) {
                                if (efficient[x] != arrProses[x]) {
                                    status = false;
                                }
                            }
                        } else {
                            status = false;
                        }

                        if (status == false) {
                            alert('Not Efficient');
                        } else {
                            alert('Efficient');
                        }
                    }

                },
                error: function() {
                    alert('error');
                }
            });
        });

        // $('.btn').click(function() {
        //     // alert($(this).val());
        //     var arrProses = [];
        //     let arrKapasitas = [];
        //     let arrCycle = [];
        //     var prosesInsert = '';
        //     for (var x = 1; x <= 9; x++) {
        //         var proses = $("#proses_1_" + x).val();
        //         var kapasitas = $('option:selected', "#proses_1_" + x).attr('kapasitas');
        //         var cycle = $('option:selected', "#proses_1_" + x).attr('time');
        //         arrProses.push(proses);
        //         arrKapasitas.push(kapasitas);
        //         arrCycle.push(cycle);
        //     }

        //     arrProses1 = jQuery.grep(arrProses, function(value) {
        //         return value != '';
        //     });

        //     for (var x = 0; x < arrProses.length; x++) {
        //         prosesInsert += arrProses[x] + ";";
        //     }
        //     var panjang = arrProses1.length;

        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('analisis.proses') }}",
        //         data: {
        //             '_token': '<?php echo csrf_token(); ?>',
        //             'produksi': $(this).val(),
        //             'panjang': panjang,
        //             'proses': prosesInsert,
        //             'kapasitas': arrKapasitas,
        //             'cycle': arrCycle
        //         },
        //         success: function(data) {
        //             if (data.msg == 'Dana Tidak Mencukupi') {
        //                 alert(data.msg);
        //             } else {
        //                 $('#dana').html(data.user[0].dana);
        //                 var notEfficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Delay',
        //                     'Cutting', 'Assembling', 'Sorting', 'Packing'
        //                 ];
        //                 var efficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];

        //                 var status = true;
        //                 if (efficient.length == panjang) {
        //                     for (var x = 0; x < efficient.length; x++) {
        //                         if (efficient[x] != arrProses[x]) {
        //                             status = false;
        //                         }
        //                     }
        //                 } else if (notEfficient.length == panjang) {
        //                     for (var x = 0; x < notEfficient.length; x++) {
        //                         if (efficient[x] != arrProses[x]) {
        //                             status = false;
        //                         }
        //                     }
        //                 } else {
        //                     status = false;
        //                 }

        //                 if (status == false) {
        //                     alert('Not Efficient');
        //                 } else {
        //                     alert('Efficient');
        //                 }
        //             }
        //         },
        //         error: function() {
        //             alert('error');
        //         }
        //     });
        // });
    </script>
@endsection
