<?php
require_once '../classes/vehicule_class.php';

$vehiculs = new Vehicule();

if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
   
    if ($categoryId == "all") {
        $vehicles = $vehiculs->showAllVehicule();
    } else {
        $vehicles = $vehiculs->getVehiculesByCategorie($categoryId);
    }

    echo json_encode($vehicles);
}
?>