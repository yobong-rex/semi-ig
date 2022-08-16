@extends('layouts.template')

@section('title', 'IG Markets')

@section('content')
    <style>
        .spacing {
            margin: 15px;
            padding: 10px;
        }

        .heading {
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
            padding: 5px;
            color: #ea435e;
        }

        .dana {
            text-align: right;
        }

        .timer {
            background-color: #77dd77;
            /* misal waktu habis background jadi #ea435e */
            width: 150px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, .08);
            color: #000000;
        }


        .nomor_bahan {
            width: 50px;
            text-align: center;
        }
        thead{
            position: sticky;
            padding-top:25px;;
        }
        thead {
            inset-block-start: 0; /* "top" */
        }
        .totalPembelianStyling{
            font-size: 1.25em;
            color: #198754;
        }
    </style>
    @php
    $namaTeam = 'apapun namanya';
    $nomorSesi = 1;
    $dana = 10000;
    $timer = '00:00';
    $biayaPengiriman = 1500;
    $totalPembelian = 1500;
    @endphp

    {{-- DOKUMENTASI ID --}}
    {{-- namaTeam : nama masing-masing team
    timer : string timer
    nomorSesi : nomor sesi
    dana : dana masing-masing team
    stok_{nomor bahan} : stok tiap bahan
    harga_{nomor bahan} : harga per paket tiap bahan
    input_{nomor bahan} : textbox input pembelian tiap bahan
    subtotal_{nomor bahan} : harga * input tiap bahan
    biaya_pengiriman : biaya pengiriman keseluruhan
    total : total pembelian semua bahan
    button_PopupModal : button untuk menampilkan modal konfirmasi
    konfirmasi_pembelian : button konfirmasi pembelian --}}

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">

        <div class="row spacing"></div>

        {{-- Card List Kelompok --}}
        <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
            <div class="row align-items-center">
                <div class="col-1">
                    <h5> Team : </h5>
                 </div>
                <div class="col-5">
                    <select id='selectedTeam' name="selectedTeam">
                        <option value="" hidden>Pilih Team</option>
                        @foreach ($team as $t)
                            <option value="{{ $t->idteam }}">{{ $t->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row-12">
            <!-- {{-- Card Dana --}}

                        <div class="card-header rounded" style="background-color:#faf0dc;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
                            <div class="row align-items-center">
                                <div class="col-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                                    <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                </svg>
                                </div>
                                <div class="col-2 label_dana">
                                    <h1>Dana : </h1>
                                </div>
                                <div class="col-9 dana">
                                    {{-- <h1><span id="dana">{{ number_format($user[0]->dana) }}</span> TC</h1> --}}
                                </div>
                            </div>
                        </div> -->
        </div>

        <div class="row spacing"></div>

        <div class="alert alert-success" role="alert">Selamat Datang di IG Market! <span style="font-size: 24px;">&#128591;</span></br> Selamat Berbelanja</div>

        <div class="row spacing"></div>

        <div class="card-body rounded" style="background-color:#ffffff;box-shadow: 0 6px 10px rgba(0, 0, 0, .08);">
            <h2>&#x1F6D2;Daftar belanja:</h2>
            <div class="table-responsive">
                    {{-- market table --}}
                    <table class="table table-striped table-bordered" style="vertical-align: middle;">
                        <thead class="table-dark thead" style="background-color: #ffffff;">
                            <tr>
                                <th class="nomor_bahan" scope="col">No.</th>
                                <th scope="col">Bahan Baku</th>
                                <th style="text-align: center;" scope="col">Isi / Paket</th>
                                <th style="text-align: center;" scope="col">Stok</th>
                                <th style="text-align: center;" scope="col">Harga Paket</th>
                                <th scope="col">Pembelian per paket</th>
                                <th scope="col">Sub-Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomer = 1; ?>
                            @foreach ($data as $d)
                                <input type="hidden" id="item_{{ $nomer }}" value="{{ $d->idig_markets }}">
                                <tr>
                                    <th class="nomor_bahan" scope="row">{{ $nomer }}</th>
                                    <td id="bahan_{{ $nomer }}">{{ $d->bahan_baku }}</td>
                                    <td style="text-align: center;" id="isi_{{ $nomer }}">{{ $d->isi }}</td>
                                    <td style="text-align: center;" id="stok_{{ $d->idig_markets }}">{{ $d->stok }}</td>
                                    <td style="text-align: center;" id="harga_{{ $nomer }}">{{ $d->harga }}</td>
                                    <td><input style="max-width: 200px;" class="form-control quantity" id="input_{{ $nomer }}" type="number"
                                            min="0"
                                            oninput="this.value =
                                    !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                    placeholder=0>
                                    </td>
                                    <td><span id="subtotal_{{ $nomer }}">0</span> TC</td>
                                </tr>
                                <?php $nomer += 1; ?>
                            @endforeach
                            <tr>
                                <td colspan="6">Biaya Pengiriman:</td>
                                <td><span id="biaya_pengiriman">150</span> TC</td>
                            </tr>
                            <tr>
                                <td colspan="6">Total Pembelian:</td>
                                {{-- button konfirmasi show pop up --}}
                                <td><span id="total" class="totalPembelianStyling">0</span> TC</td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align:right;">
                                    <button type="button" class="btn btn-success" id="button_PopupModal" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop" style="width:140px;">Konfirmasi</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>

        </div>
        <div class="row spacing"></div>

        {{-- Pop Up Konfirmasi --}}
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembelian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex">
                        Apakah anda yakin untuk melakukan pembelian sebesar <span id='mdlTotal' class="totalPembelianStyling"></span> TC?
                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        {{-- button konfirmasi akhir --}}
                        <button type="button" class="btn btn-success" id="konfirmasi_pembelian">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal pemberitahuan -->
        <div class="modal fade" id="mdlPemberitahuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembelian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body flex" id="body-konfir">

                    </div>
                    <div class="modal-footer">
                        {{-- button cancel --}}
                        <button type="button" id='reload' class="btn btn-secondary"
                            data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="../../js/app.js"></script>
            <script>
                let item = [];
                let count = 0;
                let totalItem = 0;

                window.Echo.channel('stockChannel').listen('.market', (e) => {
                    $.each(e.market, function(key, value) {
                        $('#stok_'+value.idItem).text(value.stock);
                    });
                })
                $(document).on('change', '.quantity', function() {
                    let quantity = $(this).val();
                    let id = $(this).attr('id');
                    let split_id = id.split('_');
                    let harga = $("#harga_" + split_id[1]).text();
                    let subtotal = parseInt(harga) * quantity;
                    $('#subtotal_' + split_id[1]).text(subtotal);
                    total();
                })

            function total() {
                item = [];
                let total = 0;
                count = 0;
                totalItem = 0;
                for (let i = 1; i <= 14; i++) {
                    let subtotal = parseInt($('#subtotal_' + i).text())
                    total += subtotal;
                    if (subtotal !== 0) {
                        count += parseInt($('#input_' + i).val());
                        item.push({
                            'item': $('#item_' + i).val(),
                            'nama': $('#bahan_'+i).text(),
                            'quantity': $('#input_' + i).val(),
                            'subtotal': $('#subtotal_' + i).text(),
                            'isi': $('#isi_' + i).text()
                        });
                        totalUnit = (parseInt($('#input_' + i).val()) * parseInt($('#isi_' + i).text()));
                        totalItem += totalUnit;
                    }
                }
                console.log(item)

                if(count > 75){
                    $('#body-konfir').text("Maaf, maksimal membeli 75 paket dalam 1 transaksi");
                    $('#mdlPemberitahuan').modal('show');
                    return
                }
                let temp = count - 50;

                total += parseInt(150);

                if (temp >= 0) {

                    let kirim = temp * 4

                    let pengiriman = 150 + kirim;
                    $('#biaya_pengiriman').text(pengiriman);
                    total += kirim;
                } else {
                    $('#biaya_pengiriman').text('150');
                }
                $('#total').text(total);
            }

            $(document).on('click', '#button_PopupModal', function() {
                let total = $('#total').text();
                $('#mdlTotal').text(total);
            })

                $(document).on('click', '#konfirmasi_pembelian', function() {
                    let total = $('#total').text();
                    let idteam = $('#selectedTeam').val();
                    // console.log(idteam)
                    let sesi = $('sesi').text();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('market.beli') }}",
                        data: {
                            '_token': '<?php echo csrf_token(); ?>',
                            'item': item,
                            'total': total,
                            'team': idteam,
                            'total_bahan': count,
                            'sesi': sesi,
                            'totalItem': totalItem
                        },
                        success: function(data) {
                            $('#staticBackdrop').modal('hide');
                            $('#body-konfir').text(data.msg);
                            $('#mdlPemberitahuan').modal('show');
                        }
                    });
                })

                $(document).on('click', '#reload', function() {
                    // let value = $(this).val();
                    location.reload()
                })
            </script>
    </body>
@endsection
