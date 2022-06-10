@extends('layouts.app')

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
        @endphp
        
    </body>
@endsection
