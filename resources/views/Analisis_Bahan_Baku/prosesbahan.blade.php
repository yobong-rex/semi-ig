@php
session_start();

$product = array();
$product['Scooter'] = array('Steel', 'SBR Rubber', 'PVA Glue');
$product['RC Car'] = array('Iron', 'ABS Plastic', 'SBR Rubber');
$product['Trampoline'] = array('Steel', 'Aluminium Alloy', 'PU Rubber');
$product['Rubber Ball'] = array('PU Rubber', 'NBR Rubber', 'Silicone');
$product['Fidget Spinner'] = array('Iron', 'PP Plastic', 'NBR Rubber');
$product['Playstation'] = array('Aluminium Alloy', 'ABS Plastic', 'Cable');
$product['Robot'] = array('Iron', 'PC Plastic', 'Cable');
$product['Action Figure'] = array('PU Rubber', 'Acrylic', 'EVA Glue');
$product['Skateboard'] = array('Steel', 'Aluminium Alloy', 'SBR Rubber');
$product['Bicycle'] = array('Steel', 'Aluminium Alloy', 'SBR Rubber');
$product['Air Soft Gun'] = array('Aluminium Alloy', 'PP Plastic', 'Silicone');
$product['Hoverboard'] = array('Steel', 'SBR Rubber', 'EVA Glue');
$product['RC Helicopter'] = array('Iron', 'PC Plastic', 'PVA Glue');
$product['Bowling Set'] = array('ABS Plastic', 'PU Rubber', 'NBR Rubber');
$product['Claw Machine'] = array('Iron', 'ABS Plastic', 'Acrylic');
// print_r($product);

$produk =  $_GET['produk'];
// echo $produk."<br>";

$resource0 = $_GET['resource0'];
// echo $resource0."<br>";

$resource1 = $_GET['resource1'];
// echo $resource1."<br>";

$resource2 = $_GET['resource2'];
// echo $resource2."<br>";

// print_r($product[$produk]);
// echo "<br>";
// print_r($arrGuess = array($resource0, $resource1, $resource2));

if(isset($_GET['produk']) && isset($_GET['resource0']) && isset($_GET['resource1']) && isset($_GET['resource2'])){
    $arrBahan = $product[$produk];
    $arrGuess = array($resource0, $resource1, $resource2);
    $_SESSION['status'] = "FALSE";
    $_SESSION['produk'] = $produk;
    $_SESSION['resource0'] = $resource0;
    $_SESSION['resource1'] = $resource1;
    $_SESSION['resource2'] = $resource2;
    foreach( $arrBahan as $x => $bahan){
         foreach($arrGuess as $y => $tebak){
             if($bahan === $tebak){
                 unset($arrBahan[$x]);
                 unset($arrGuess[$y]);
             }
         }
    }
    if(count($arrBahan) === 0){
        $_SESSION['status'] = "TRUE";
    }
    // echo $_SESSION['status'];
    header("Location: bahan?session=1");
    exit();
}else {
    header("Location: bahan?error=0");
    exit();
}
@endphp