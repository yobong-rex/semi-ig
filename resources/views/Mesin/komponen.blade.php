@extends('layouts.app')

@section("title", "Mesin")

@section("content")
<body>
    @php
    $a = 1;
    $b = 1;
    $c = 1;
    $d = 1;

    $level = 1;
    $a_defect = -1;
    $b_defect = -1;
    $c_defect = -1;
    $d_defect = -1;

    // Check Level
    if ($a==10 && $b==10 && $c==10 && $d==10){
        $level = 6;
    }else if ($a>=8 && $b>=8 && $c>=8 && $d>=8){
        $level = 5;
    }else if ($a>=6 && $b>=6 && $c>=6 && $d>=6){
        $level = 4;        
    }else if ($a>=4 && $b>=4 && $c>=4 && $d>=4){
        $level = 3;
    }else if ($a>=2 && $b>=2 && $c>=2 && $d>=2){
        $level = 2;
    }

    // Check defect component A
    if($a>7){
        $a_defect = -3;
    } else if($a>3){
        $a_defect = -2;
    }

    // Check defect component B
    if($b>7){
        $b_defect = -3;
    } else if($b>3){
        $b_defect = -2;
    }

    // Check defect component C
    if($c>7){
        $c_defect = -3;
    } else if($c>3){
        $c_defect = -2;
    }

    // Check defect component D
    if($d>7){
        $d_defect = -3;
    } else if($d>3){
        $d_defect = -2;
    }

    echo "<p> Level = $level </p>";
    echo "<p> Defect A = $a_defect </p>";
    echo "<p> Defect B = $b_defect </p>";
    echo "<p> Defect C = $c_defect </p>";
    echo "<p> Defect D = $d_defect </p>";
    @endphp

    <button id="upgrade_a">Upgrade Komponen A</button>
    <button id="upgrade_b">Upgrade Komponen B</button>
    <button id="upgrade_c">Upgrade Komponen C</button>
    <button id="upgrade_d">Upgrade Komponen D</button>
</body>
@endsection