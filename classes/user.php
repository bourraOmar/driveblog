<?php
require_once('../connection/connect.php');

class user
{
    private $conn;

    public function __construct()
    {
        $db = new DBconnect();
        $this->conn = $db->connectpdo();
    }

    public function register($nom, $prenom, $email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("INSERT INTO user (nom, prenom, email, password, role_id) VALUES (?, ?, ?, ?, 2)");
            $stmt->bindParam(1, $nom);
            $stmt->bindParam(2, $prenom);
            $stmt->bindParam(3, $email);
            $stmt->bindParam(4, $hashedPassword);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function authenticate($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM User WHERE email = ? ");
        $stmt->bindParam(1, $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {

                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["email"] = $user['email'];
                $_SESSION["role_id"] = $user['role_id'];
                $_SESSION["nom"] = $user['nom'];
                $_SESSION["prenom"] = $user['prenom'];

                if ($user['role_id'] == 1) {
                    header("Location: ../pages/dashboard.php");
                    exit();
                } else {
                    header("Location: ../index.php");
                    exit();
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function ReserverVehicule($date_debut, $date_fin, $client_id, $vehicule_id){
        $sql = "INSERT INTO reservation (date_debut, date_fin, status, user_id, vehicule_id)
                VALUES (:date_debut, :date_fin, 'waiting', :user_id, :vehicule_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":date_debut", $date_debut);
        $stmt->bindParam(":date_fin", $date_fin);
        $stmt->bindParam(":user_id", $client_id);
        $stmt->bindParam(":vehicule_id", $vehicule_id);

        if($stmt->execute()){
            $_SESSION['success'] = "Reservation completed, wait for admin approval!";
            header('Location: ../pages/reservation.php?vehiculeId=' . $vehicule_id);
            exit();
        }
    }

    function cancelReservation($reservation_id){
        $sql = "UPDATE reservation
                SET status = 'refuse'
                WHERE reservation_id = :reservation_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservation_id);
        if($stmt->execute()){
            header('Location: ../profils/client.php');
            exit();
        }
    }
}


if (isset($_POST['reservation_submit']) && isset($_GET['vehicule_Id']) && isset($_GET['clientId'])) {
    
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $vehiculeId = $_GET['vehicule_Id'];
    $clientId = $_GET['clientId'];

    $user = new user();

    if ($date_debut >= date("Y-m-d") && $date_fin > $date_debut) {
        $user->ReserverVehicule($date_debut, $date_fin, $clientId, $vehiculeId);
    } else {
        $_SESSION['date_invalide'] = "Please enter a valid date!";
        header('Location: ../pages/reservation.php?vehiculeId=' . $vehiculeId);
        exit();
    }
}

if(isset($_POST['action']) && isset($_POST['reservation_id'])){
    $reservation_id = $_POST['reservation_id'];

    $client = new user();

    $client->cancelReservation($reservation_id);
}
