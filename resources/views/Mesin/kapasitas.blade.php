@extends('layouts.template')

@section('title', 'Upgrade Kapasitas')

@section('content')
    <style>
.kapasitas{
            background-color:#ffffff;
            box-shadow: 0 6px 10px rgba(0,0,0,.08);
        }
    </style>

    <body style="background: url('{{ asset('assets') }}/background/Background.png') top / cover no-repeat;">
        @php
            $harga = ['200', '500', '1000', '2000', '3000'];
            // $harga = array();
            // $harga['Sorting'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Cutting'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Bending'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Assembling'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Packing'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Drilling'] = array('200', '500', '1000', '2000', '3000');
            // $harga['Molding'] = array('200', '500', '1000', '2000', '3000');
            $arrProses = ['Sorting', 'Cutting', 'Bending', 'Assembling', 'Packing', 'Drilling', 'Molding'];
        @endphp
            <div class="container px-4 py-5" style="font-family:TT Norms Bold;">
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
                            @foreach ($data as $d)
                                <tr>
                                    <td>
                                        {{ $d->nama }}
                                    </td>
                                    <td style="text-align:center;">{{$d->level}}</td>
                                    <td style="text-align:center;">{{$d->kapasitas}}</td>
                                    <td style="text-align:center;">
                                        <button class='upgrade' value={{$d->nama}}>Upgrade</button>
                                        <button type="button" class="btn btn-warning upgrade" value={{$d->nama}}>Upgrade</button>
                                    </td>
                                </tr>
                            @endforeach
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
                success: function() {
                    alert('success');
                },
                error: function() {
                    alert('error');
                }
            })
        })
    </script>
@endsection
