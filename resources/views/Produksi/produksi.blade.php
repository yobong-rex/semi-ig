@extends('layouts.template')

@section('title', 'Produksi')

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

        .kartu_Home {
            background-color: #faf0dc;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
        }

        .inputJumlahProduk {
            width: 70px;
        }

        .urutanProduksi {
            width: 100px;
        }
    </style>

    @php
    $sesi = 1;
    $dana = 10000;
    $namaTeam = 'apapun namanya';
    $nomorSesi = 1;
    $timer = '00:00';
    @endphp

    {{-- DOKUMENTASI ID --}}
    {{-- namaTeam : nama masing-masing team 
    timer : string timer
    dana : dana masing-masing team
    nomorSesi : nomor sesi
    cycleTime : cycle time
    totalDefect : jumlah akhir defect --}}

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
        <div class="px-4 py-5" style="font-family:TT Norms Bold;">

            {{-- Nama Team dan Timer --}}
            <div class="row align-items-center rounded heading">
                <div class="col-9 nama_team">
                    <h1 id="namaTeam">Team {{ $user[0]->nama }}</h1>
                </div>
                <div class="col-1">
                    <h3 id="nomorSesi">Sesi {{$sesi1}}</h3>
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

            <h1>Produksi</h1>
            <div class="alert alert-danger" role="alert">Pastikan untuk MEMILIH Jenis Produk dan MENGINPUT Jumlah Produk SEBELUM Konfirmasi</div>
            {{-- Form produksi --}}
            <form action="{{ route('produksi.buat') }}" method='post'>
                <input type="hidden" id='sesi' value='{{ $sesi1 }}' name='sesi'>
                <input type="hidden" id='team' value='{{ $user[0]->idteam }}' name='team'>
                @csrf
                <table class="table table-bordered" style="vertical-align: middle;">
                    <thead class="thead">
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col"> </th>
                            <th scope="col" colspan="10" style="text-align:center;">Urutan Produksi Produk</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;">Konfirmasi</th>
                        </tr>
                        <tr>
                            <th scope="col" rowspan="2" style="vertical-align: middle;text-align:center;">Produk</th>
                            <th scope="col" class="inputJumlahProduk" rowspan="2"
                                style="vertical-align: middle;text-align:center;">Jumlah Produk</th>
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
                                @if ($i == 1)
                                    <input type="hidden" id='defect_{{ $i }}' name='defect_{{ $i }}' value='{{ $defect1 }}'>
                                @elseif ($i == 2)
                                    <input type="hidden" id="defect_{{ $i }}" name='defect_{{ $i }}' value='{{ $defect2 }}'>
                                @else
                                    <input type="hidden" id='defect_{{ $i }}' name='defect_{{ $i }}' value='{{ $defect3 }}'>
                                @endif
                                <td>
                                    <select name="produk_{{ $i }}" id="produk_{{ $i }}">
                                        <option value="">pilih produk</option>
                                        @if ($i == 1)
                                            <option value="1">Scooter</option>
                                            <option value="12">Hoverboard</option>
                                            <option value="9">Skateboard</option>
                                            <option value="10">Bicycle</option>
                                            <option value="15">Claw Machine</option>
                                        @elseif ($i == 2)
                                            <option value="2">RC Car</option>
                                            <option value="13">RC Helicopter</option>
                                            <option value="3">Trampoline</option>
                                            <option value="7">Robot</option>
                                            <option value="11">Airsoft Gun</option>
                                            <option value="6">Playstation</option>
                                        @else
                                            <option value="4">Rubber Ball</option>
                                            <option value="5">Fidget Spiner</option>
                                            <option value="14">Bowling Set</option>
                                            <option value="8">Action Figure</option>
                                        @endif
                                    </select>
                                </td>
                                <td><input class="inputJumlahProduk" type="number" name='jumlah_{{ $i }}'
                                        id='jumlahProduk_{{ $i }}' min="0" oninput="this.value =
                                !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" placeholder=0>
                                </td>
                                <th class="nomor" scope="row">Proses Produksi {{ $i }}</th>
                                @for ($j = 1; $j <= 9; $j++)
                                    <td>
                                        @if ($i == 1)
                                            <input class="urutanProduksi" type="text" value='{{ $splitProses1[$j - 1] }}'
                                                disabled>
                                        @elseif ($i == 2)
                                            <input class="urutanProduksi" type="text" value='{{ $splitProses2[$j - 1] }}'
                                                disabled>
                                        @else
                                            <input class="urutanProduksi" type="text" value='{{ $splitProses3[$j - 1] }}'
                                                disabled>
                                        @endif
                                    </td>
                                @endfor
                                <td>
                                    {{--Button Tampilin modal--}}
                                    <button type="button" class="btn btn-success " id="button_PopupModal" btn='{{$i}}' data-bs-toggle="modal" data-bs-target="#staticBackdrop">Konfirmasi</button>

                                    {{--Button asli--}}
                                    {{--<button class="btn btn-success" name='submit' value='{{ $i }}' id="button_{{ $i }}">Konfirmasi</button>--}}

                                </td> 
                            </tr>
                            
                        @endfor
                    </tbody>
                </table>
            </form>

            <div class="row spacing"></div>

            {{-- Pop Up Konfirmasi --}}
            <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Produksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex">
                                Apakah anda yakin untuk melakukan produksi <span id='no-konfrim'></span> ?
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancel</button>
 
                                <button class="btn btn-success btn-modal" name='button'>Konfirmasi</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal info -->
                <div class="modal fade" id="modalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Informasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body flex" id='info-body'>
                                
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal info -->

            {{-- Kartu bawah --}}
            <!-- <div class="row">
                {{-- Card Cycle Time --}}
                <div class="col">
                    <div class="card-body rounded text-center kartu_Home">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                              </svg>
                        </div>
                        <div class="col">
                            <h2>Cycle Time</h2>
                        </div>
                        <div class="col">
                            <h3 id="cycleTime">00:00</h3>
                        </div>
                    </div>
                </div>
        
                {{-- Card Defect --}}
                <div class="col">
                    <div class="card-body rounded text-center kartu_Home">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                              </svg>
                        </div>
                        <div class="col">
                            <h2>Jumlah Defect</h2>
                        </div>
                        <div class="col">
                            <h3 id="totalDefect">0</h3>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>

        <script>
            let btn = '';
            $(document).on('click','#button_PopupModal', function(){
                btn = $(this).attr('btn');
                $('#no-konfrim').text(btn);
            })

            $(document).on('click','.btn-modal', function(){
                // alert(btn);
                let defect = $('#defect_'+btn).attr('value');
                let sesi = $('#sesi').attr('value');
                let team = $('#team').attr('value');
                let product = $('#produk_'+btn).val();
                let product_name = $('#produk_'+btn+" option:selected").text();
                let jumlah = $('#jumlahProduk_'+btn).val();
                console.log(product_name);
                // alert(product_name)
                $.ajax({
                type: "POST",
                url: "{{ route('produksi.buat') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'sesi': sesi,
                    'team': team,
                    'defect' : defect,
                    'produk' : product,
                    'jumlah' : jumlah,
                    'name'  : product_name,
                    'btn'   : btn
                },
                success: function(data) {
                    $('#staticBackdrop').modal('hide');
                    $('#info-body').text(data.msg);
                    $('#modalInfo').modal('show');
                    $('#produk_'+btn).val("").change();
                    $('#jumlahProduk_'+btn).val(0);
                },
                error: function() {
                    // alert('error');
                }
            });
            })
        </script>
    </body>
@endsection
 