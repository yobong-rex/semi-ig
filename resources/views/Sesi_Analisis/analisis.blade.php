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

        @media (max-width:800px) {

            .dana,
            .label_dana {
                text-align: center;
            }
        }

        @media (max-width:1000px) {

            .dana,
            .label_dana {
                font-size: 25px;
            }
        }
    </style>
    {{-- DOKUMENTASI ID --}}
    {{-- proses_{nomor proses produksi}_{urutan ke}
    button_{nomor proses produksi} --}}

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">

        @if (session('status'))
            <div class="alert alert-success" id="status">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" id="status">
                {{ session('error') }}
            </div>
        @endif



        <div class="row spacing"></div>

        <h1>Sesi Analisis</h1>

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
                <div class="col-md-3 label_dana">
                    <h1>Dana :</h1>
                </div>
                <div class="col-md-8 dana">
                    <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1>
                </div>
            </div>
        </div>

        <div class="row spacing"></div>
        {{-- tabel analisis --}}
        <form action="">
            <div class="table-responsive">
                <table class="table table-bordered" style="vertical-align: middle;">
                    <thead class="thead">
                        <tr>
                            <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center">Nomor</th>
                            <th scope="col" colspan="9" style="text-align:center;">Urutan Produksi Produk</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;width:80px;">
                                Konfirmasi</th>
                        </tr>
                        <tr>
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
                                                    time='{{ $m->cycleTime }}'>{{ $m->nama }}</option>
                                            @endforeach
                                            <option value="Idle" kapasitas="" time="6">Idle</option>
                                            <option value="Delay" kapasitas="" time="7">Delay</option>
                                        </select>
                                    </td>
                                @endfor
                                <td style="vertical-align: middle;text-align: center">
                                    <button type="button" id="button_{{ $i }}" class="btn btn-success"
                                        value="{{ $i }}">Konfirmasi</button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </form>

        {{-- Modal --}}
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
            function setProses($nomer, $proses) {
                let triger = 1;
                let splitProses = $proses.split(";")
                $.each(splitProses, function(key, value) {
                    console.log(value);
                    $('#proses_' + $nomer + '_' + triger).val(value);
                    triger += 1;
                })
            }

            $(document).ready(function() {
                let proses1 = "<?php echo $proses1; ?>";
                let proses2 = "<?php echo $proses2; ?>";
                let proses3 = "<?php echo $proses3; ?>";

                if (proses1 != '') {
                    setProses(1, proses1);
                }
                if (proses2 != '') {
                    setProses(2, proses2);
                }
                if (proses3 != '') {
                    setProses(3, proses3);
                }

            });

            $('.btn').click(function() {
                var arrProses = [];
                let arrKapasitas = [];
                let arrCycle = [];
                var prosesInsert = '';
                for (var x = 1; x <= 9; x++) {
                    var proses = $("#proses_" + $(this).val() + "_" + x).val();
                    var kapasitas = $('option:selected', "#proses_" + $(this).val() + "_" + x).attr('kapasitas');
                    var cycle = $('option:selected', "#proses_" + $(this).val() + "_" + x).attr('time');
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
                        'produksi': $(this).val(),
                        'panjang': panjang,
                        'proses': prosesInsert,
                        'kapasitas': arrKapasitas,
                        'cycle': arrCycle,
                        'arrProses': arrProses1
                    },
                    success: function(data) {
                        if (data.msg == 'Dana Tidak Mencukupi') {
                            $('#notifUpgrade').text(data.msg);
                            $('#Notif').modal('show');
                        } else if (data.msg == 'x') {
                            $('#notifUpgrade').html('Proses Kurang Panjang<br>Minimal Proses = 4');
                            $('#Notif').modal('show');
                        } else {
                            $('#dana').html(data.user[0].dana);

                            if (data.status == 'false') {
                                $('#notifUpgrade').text('Not Efficient');
                                $('#Notif').modal('show');
                            } else if (data.status == 'true') {
                                $('#notifUpgrade').text('Efficient');
                                $('#Notif').modal('show');
                            } else if (data.status == 'half') {
                                $('#notifUpgrade').text('Wrong Order');
                                $('#Notif').modal('show');
                            }
                        }
                    },
                    error: function() {
                        // alert('error');
                    }
                });
            });
        </script>
    </body>
@endsection
