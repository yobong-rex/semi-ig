@extends('layouts.app')

@section('title', 'Sesi Analisis')

@section('content')
    <style>
        .nomor {
            width: 50px;
            text-align: center;
        }

        .penomoran {
            width: 110px;
            text-align: center;
        }
    </style>
    @php
    $notEff1 = ['Sorting', 'Cutting', 'Drilling', 'Assembling', 'Cutting', 'Assembling', 'Sorting', 'Wrapping', 'Packing'];
    $notEff2 = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Assembling', 'Wrapping', 'Packing'];
    $notEff3 = ['Sorting', 'Molding', 'Assembling', 'Sorting', 'Wrapping', 'Packing'];
    $eff1 = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];
    $eff2 = ['Sorting', 'Cutting', 'Drilling', 'Assembling', 'Packing'];
    $eff3 = ['Sorting', 'Molding', 'Assembling', 'Packing'];
    @endphp
    {{-- DOKUMENTASI ID --}}
    {{-- proses_{nomor proses produksi}_{urutan ke}
    button_{nomor proses produksi} --}}

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        <div class="container px-4 py-5" style="font-family:TT Norms Bold;">

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
                                            <option value="-">-Select-</option>
                                            <option value="Sorting">Sorting</option>
                                            <option value="Cutting">Cutting</option>
                                            <option value="Bending">Bending</option>
                                            <option value="Assembling">Assembling</option>
                                            <option value="Packing">Packing</option>
                                            <option value="Drilling">Drilling</option>
                                            <option value="Molding">Molding</option>
                                            <option value="Wrapping">Wrapping</option>
                                        </select>
                                    </td>
                                @endfor
                                <td><button class="btn btn-success" id="button_{{ $i }}">Konfirmasi</button></td>
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

        function coba_konfirmasi(produksi, length) {
            console.log(produksi);
            console.log(length);
            // $.ajax({
            //     type: "POST",
            //     url: "{{ route('coba') }}",
            //     data:{
            //         '_token': '<?php echo csrf_token(); ?>'
            //     },
            //     success: function(data){
            //         1;
            //     }
            // });
        }

        function konfirmasi(produksi, length) {
            console.log(produksi);
            console.log(length);
            // $.ajax({
            //     type: "POST",
            //     url: "{{ route('coba') }}",
            //     data:{
            //         '_token': '<?php echo csrf_token(); ?>',
            //         'produksi': produksi,
            //         'length': length
            //     },
            //     success: function(data){

            //     }
            // });
        }
        $(document).on('click', '#button_1', function())
        $('#button_1').click(function() {
            $.ajax({
                type: "POST",
                url: "{{ route('coba') }}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function() {
                    var notEfficient = ['Sorting', 'Cutting', 'Drilling', 'Assembling', 'Cutting',
                        'Assembling', 'Sorting', 'Wrapping', 'Packing'
                    ];
                    var efficient = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing'];
                    var arrProses = [];
                    for (var j = 1; j <= 9; j++) {
                        var proses = $("#proses_1_" + j).val();
                        arrProses.push(proses);
                        console.log("proses_1_" + j + " = " + proses);
                    }

                    // console.log(arrProses);

                    arrProses = jQuery.grep(arrProses, function(value) {
                        return value != '-';
                    })

                    // console.log(arrProses);

                    var helper = true;
                    if (efficient.length == arrProses.length) {
                        for (var x = 0; x < efficient.length; x++) {
                            if (efficient[x] != arrProses[x]) {
                                // helper = false;
                            }
                        }
                        alert('Efficient');
                    } else if (notEfficient.length == arrProses.length) {
                        for (var x = 0; x < notEfficient.length; x++) {
                            if (efficient[x] != arrProses[x]) {
                                // helper = false;
                            }
                        }
                        alert('Not Efficient');
                    } else {
                        helper = false;
                        alert('Defected');
                    }

                    // console.log(helper);
                    // console.log(notEfficient);
                    // console.log(efficient);
                    // alert("You clicked button_1");
                }
            });
        });

        $('#button_2').click(function() {
            var notEfficient = ['Sorting', 'Cutting', 'Assembling', 'Drilling', 'Assembling', 'Wrapping',
                'Packing'
            ];
            var efficient = ['Sorting', 'Cutting', 'Drilling', 'Assembling', 'Packing'];
            var arrProses = [];
            for (var j = 1; j <= 9; j++) {
                var proses = $("#proses_2_" + j).val();
                arrProses.push(proses);
                console.log("proses_2_" + j + " = " + proses);
            }

            // console.log(arrProses);

            arrProses = jQuery.grep(arrProses, function(value) {
                return value != '-';
            })

            // console.log(arrProses);

            var helper = true;
            if (efficient.length == arrProses.length) {
                for (var x = 0; x < efficient.length; x++) {
                    if (efficient[x] != arrProses[x]) {
                        // helper = false;
                    }
                }
                alert('Efficient');
            } else if (notEfficient.length == arrProses.length) {
                for (var x = 0; x < notEfficient.length; x++) {
                    if (efficient[x] != arrProses[x]) {
                        // helper = false;
                    }
                }
                alert('Not Efficient');
            } else {
                // helper = false;
                alert('Defected');
            }

            // console.log(helper);
            // console.log(notEfficient);
            // console.log(efficient);
            // alert("You clicked button_2");
        });

        $('#button_3').click(function() {
            var notEfficient = ['Sorting', 'Molding', 'Assembling', 'Sorting', 'Wrapping', 'Packing'];
            var efficient = ['Sorting', 'Molding', 'Assembling', 'Packing'];
            var arrProses = [];
            for (var j = 1; j <= 9; j++) {
                var proses = $("#proses_3_" + j).val();
                arrProses.push(proses);
                console.log("proses_3_" + j + " = " + proses);
            }

            // console.log(arrProses);

            arrProses = jQuery.grep(arrProses, function(value) {
                return value != '-';
            })

            // console.log(arrProses);
            // console.log(efficient.length);
            // console.log(arrProses.length);
            // console.log(notEfficient.length);

            var helper = true;
            if (efficient.length == arrProses.length) {
                for (var x = 0; x < efficient.length; x++) {
                    if (efficient[x] != arrProses[x]) {
                        // helper = false;
                    }
                }
                alert("Efficient");
            } else if (notEfficient.length == arrProses.length) {
                for (var x = 0; x < notEfficient.length; x++) {
                    if (efficient[x] != arrProses[x]) {
                        // helper = false;
                    }
                }
                alert("Not Efficient");
            } else {
                // helper = false;
                alert("Defected");
            }

            // console.log(helper);
            // console.log(notEfficient);
            // console.log(efficient);
            // alert("You clicked button_3");
        });
    </script>
@endsection
