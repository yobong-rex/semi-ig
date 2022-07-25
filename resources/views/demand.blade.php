@extends('layouts.template')

@section('title', 'Demand')

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

        .nomor_demand {
            width: 50px;
            text-align: center;
        }

        .pemenuhan {
            background-color: #ffffff;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
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

    @php
    $sesi = 1;
    // $dana={{ $teams->dana }};
    // $namaTeam={{ $teams->nama }};
    $nomorSesi = 1;

    $timer = '00:00';
    @endphp

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">


        <div class="row spacing"></div>

        {{-- Card Dana --}}
        <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
            <div class="row align-items-center">
                <div class="col-md-1 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                        class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
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

        <div class="alert alert-danger" role="alert"> Setiap produk hanya bisa dimasukkan 1x !!! </br> Jika salah
            lakukan refresh halaman.</div>

        <div class="card-body pemenuhan rounded">
            <h1>Pemenuhan Demand</h1>

            {{-- Table Pemenuhan Demand --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="nomor_demand" scope="col">No.</th>
                        <th scope="col">Produk</th>
                        <th scope="col" style="text-align:center;">Memenuhi Demand</th>
                        <th scope="col" style="width:165px;">Total</th>
                        <th scope="col" style="width:165px;">Sisa</th>
                    </tr>
                </thead>
                <tbody>

                @php
                    $i=1
                @endphp
                @foreach ($produk as $p)
                    <tr>
                        <td class="nomor_demand" scope="row">{{$i++}}</td>
                        <td>{{$p->nama}}</td>
                        <td class="inputDemand"><input type="number" class='demand' id='input_{{$p->idproduk}}'min="0" oninput="this.value =
                            !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0></td>
                        <td id='total_{{$p->idproduk}}' class="demand-total">
                            @if (count($data) == 0)
                                0
                            @else
                                <?php $triger = 0; ?>
                                @foreach ($data as $d)
                                    @if ($p->idproduk == $d->idproduk)
                                        {{ $d->jumlah }}
                                        <?php $triger += 1; ?>
                                    @endif
                                @endforeach
                                @if ($triger == 0)
                                    {{ $triger }}
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (count($data) == 0)
                                3
                            @else
                                <?php $triger = 0; ?>
                                @foreach ($data as $d)
                                    @if ($p->idproduk == $d->idproduk)
                                        {{ $d->sisa }}
                                        <?php $triger += 1; ?>
                                    @endif
                                @endforeach
                                @if ($triger == 0)
                                    3
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal" >Pemuhi Demand</button>
            <button type="button" class="btn btn-danger" id='btn-clear' >Clear</button>

            <!-- Modal -->
                <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Produksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex">
                                Apakah anda yakin untuk melakukan pemenuhan demand ?
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancel</button>

                                <button class="btn btn-success btn-modal" id="konfrim" name='button'>Konfirmasi</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end modal -->

            <!-- modal info -->
                <div class="modal fade" id="modalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                                <button type="button" class="btn-close mdl-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex" id='info-body'>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mdl-close" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end modal info -->




            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>

                let arrDemand = [];

                $(document).on('change', '#selectedTeam', function() {
                    let id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('demand.getDemand') }}",
                        data: {
                            '_token': '<?php echo csrf_token(); ?>',
                            'team': id,
                            'sesi': $('#nomorSesi').attr('value'),
                        },
                        success: function(data) {
                            if (data.list.length > 0) {
                                $.each(data.list, function(key, value) {
                                    $('#total_' + data.list[key].idproduk).text(data.list[key].jumlah);
                                });
                            } else {
                                $('.demand-total').text('0');
                            }
                        }
                    });
                });

                $(document).on('change', '.demand', function() {
                    let val = parseInt($(this).val());
                    let id = $(this).attr('id');
                    let id_split = id.split('_');
                    let total = parseInt($('#total_' + id_split[1]).text());
                    total += val;
                    $('#total_' + id_split[1]).text(total);
                    $(this).attr("disabled", true);
                    arrDemand.push({
                        'produk': id_split[1],
                        'total': $(this).val()
                    });
                    console.log(arrDemand);
                });


                $(document).on('click','#konfrim',function(){
                    $.ajax({
                        type: "POST",
                        url: "{{route('demand.konfrim')}}",
                        data:{
                            '_token': '<?php echo csrf_token()?>',
                            'demand' : arrDemand,
                        },
                        success: function(data){
                            $("#modal").modal('hide');
                            $('#info-body').text(data.msg);
                            $('#modalInfo').modal('show');

                        }
                    });
                });

                $(document).on('click','.mdl-close',function(){
                   location.reload();
                })

                $(document).on('click','#btn-clear', function(){
                    $('.demand').val('0');
                    $('.demand').prop('disabled', false);
                    $('.demand-total').text('0');
                })
            </script>
        </div>
        </div>
    </body>
@endsection
