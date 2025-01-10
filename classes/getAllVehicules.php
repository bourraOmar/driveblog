<?php
require_once '../classes/vehicule_class.php';

$vehicule = new Vehicule();

if($_GET['vehicule_id']){
    $vehicule_id = $_GET['vehicule_id'];
    $vehicle = $vehicule->showSpiceficAllVehicule($vehicule_id);
    echo json_encode($vehicle);
}
?>