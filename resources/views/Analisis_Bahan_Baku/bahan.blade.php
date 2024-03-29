@extends('layouts.template')

@section('title', 'Analisis Bahan Baku')

@section('content')
    @php
    if (isset($_GET['session'])) {
        if ($_GET['session'] == 1) {
            session_start();
        }
    }
    @endphp

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

        .tabelbahan {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

        table {
            padding: 5px;
        }

        @media (max-width:580px) {

            .dana,
            .label_dana {
                text-align: center;
                padding-left: 24px;
            }
        }

        @media (max-width:800px) and (min-width:580px) {

            .dana,
            .label_dana {
                text-align: center;
                padding-left: 24px;
            }
        }

        @media (max-width:1000px) and (min-width:800px) {

            .dana,
            .label_dana {
                font-size: 25px;
                padding-left: 24px;
            }
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
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

        <div class="card-body tabelbahan rounded">
            <h1>Analisis Bahan Baku</h1>
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            {{-- Tulisan Bahan Baku --}}
                            <th class="header_bahanbaku" scope="col" colspan="2">Bahan Baku</th>

                            {{-- combobox di kanan atas yang isinya produk --}}
                            <th>
                                <select name="produk" id="produk" class="product">
                                    @for ($x = 0; $x < count($product); $x++)
                                        <option value='{{ $product[$x]->nama }}'>{{ $product[$x]->nama }}</option>
                                    @endfor
                                </select>
                            </th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- 3 combobox di bawah yang isinya resource/bahan baku --}}
                            @for ($i = 1; $i <= 3; $i++)
                                <td>
                                    @php
                                        $arrResource = ['Steel', 'Iron', 'Aluminium Alloy', 'ABS Plastic', 'PP Plastic', 'PC Plastic', 'SBR Rubber', 'PU Rubber', 'NBR Rubber', 'Silicone', 'Acrylic', 'Cable', 'EVA Glue', 'PVA Glue'];
                                    @endphp
                                    <select name="resource{{ $i }}" id="resource{{ $i }}"
                                        class="resource">
                                        @foreach ($arrResource as $key => $resource)
                                            <option value='{{ $resource }}'>{{ $resource }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            @endfor
                            {{-- Table kosong di kanan bawah buat tempat True/False --}}
                            <td>
                                <span id="status"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Button Submit --}}
            <button id='analisisBahan' class="btn btn-primary" type="submit" value="submit">Submit</button>
        </div>

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
            $('#analisisBahan').click(function() {
                // alert($('#produk').val());
                // alert($('#resource1').val());
                // alert($('#resource2').val());
                // alert($('#resource3').val());
                $.ajax({
                    type: 'POST',
                    url: "{{ route('analisis.bahan') }}",
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'produk': $('#produk').val(),
                        'resource1': $('#resource1').val(),
                        'resource2': $('#resource2').val(),
                        'resource3': $('#resource3').val()
                    },
                    success: function(data) {
                        // alert('success');
                        if (data.msg == 'Dana Tidak Mencukupi') {
                            $('#notifUpgrade').text(data.msg);
                            $('#Notif').modal('show');
                        } else {
                            $('#dana').html(data.user[0].dana);
                            $('#status').text(data.status);
                        }
                    },
                    error: function() {
                        alert('error');
                    }
                });
            });

            $('.resource').change(function() {
                $('#status').text('');
            });

            $('.product').change(function() {
                $('#status').text('');
            });
        </script>
    </body>

@endsection
