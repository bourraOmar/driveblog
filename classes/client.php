<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once '../classes/user.php';
require_once '../classes/conn.php';
require_once '../classes/vehicule_class.php';

class client extends User{
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function ReserverVehicule($date_debut, $date_fin, $client_id, $vehicule_id){
        $sql = "CALL ReserverVehicule(:date_debut, :date_fin, :client_id, :vehicule_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":date_debut", $date_debut);
        $stmt->bindParam(":date_fin", $date_fin);
        $stmt->bindParam(":client_id", $client_id);
        $stmt->bindParam(":vehicule_id", $vehicule_id);


        $stmt->execute();
            
    }

    function cancelReservation($reservation_id){
        $sql = "UPDATE reservation
                SET status = 'refuse'
                WHERE reservation_id = :reservation_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservation_id);
        if($stmt->execute()){
            header('Location: ../pages/reservation_hestorie.php');
            exit();
        }
    }

    function ShowAllClients(){
        $sql = "SELECT * FROM user";
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }


}


if (isset($_POST['reservation_submit']) && isset($_GET['vehicule_Id']) && isset($_GET['clientId'])) {
    
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $vehiculeId = $_GET['vehicule_Id'];
    $clientId = $_GET['clientId'];
    
    $client = new client();
    $vehicule = new Vehicule();
    
    if ($date_debut >= date("Y-m-d") && $date_fin > $date_debut) {
        $client->ReserverVehicule($date_debut, $date_fin, $clientId, $vehiculeId);
        $vehicule->verifierDisponibilite($vehiculeId);
        
        $_SESSION['success'] = "Reservation completed, wait for admin approval!";
    } else {
        $_SESSION['date_invalide'] = "Please enter a valid date!";
    }

    header('Location: ../pages/reservation_page.php?vehiculeId=' . $vehiculeId);
    exit();
}

if(isset($_POST['action']) && isset($_POST['reservation_id'])){
    $reservation_id = $_POST['reservation_id'];

    $client = new client();

    $client->cancelReservation($reservation_id);
}

?>