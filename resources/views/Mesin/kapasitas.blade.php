@extends('layouts.template')

@section('title', 'Upgrade Kapasitas')

@section('content')
    <style>
        table,
        tr,
        th,
        td {
            border: 1px solid black;
        }
    </style>

    <body>
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
        <table>
            <thead>
                <tr>
                    <th scope="col">Mesin</th>
                    <th scope="col">Level</th>
                    <th scope="col">Kapasitas</th>
                    <th scope="col">Upgrade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($arrProses as $proses)
                <tr>
                    <td>
                        {{$proses}}
                    </td>
                    <td>level</td>
                    <td>kapasitas</td>
                    <td>
                        <button type='button' id='upgrade_{{$proses}}'>Upgrade</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    <script>
        $('#upgrade_Sorting').click(function(){
            $.ajax({
                type: 'POST',
                url: "{{route('upgrade.kapasitas')}}",
                data: {
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(){
                    alert('success');
                },
                error: function(){
                    alert('error');
                }
            })
        })
    </script>
@endsection
