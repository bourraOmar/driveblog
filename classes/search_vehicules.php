<?php 
require_once '../classes/vehicule_class.php';

$vehicules = new Vehicule();

if(isset($_GET['carModel'])){
    $vehiculeName = $_GET['carModel'];

    if($vehiculeName == ""){
        $car = $vehicules->showAllVehicule();
    }else{
        $car = $vehicules->searchForVehicules($vehiculeName);
    }

    echo json_encode($car);
}

?>