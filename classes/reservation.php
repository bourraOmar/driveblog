<?php 
require_once '../classes/conn.php';

class reservation {
    protected $date_debut;
    protected $date_fin;
    protected $status;
    protected $price;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    public function getAllReservations() {
        $sql = "SELECT r.*, 
                       CONCAT(u.nom, ' ', u.prenom) as client_name,
                       CONCAT(v.marque, ' ', v.modele) as vehicle_name
                FROM reservation r
                JOIN user u ON r.user_id = u.user_id
                JOIN vehicule v ON r.vehicule_id = v.vehicule_id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateReservationStatus($reservation_id, $status) {
        $sql = "UPDATE reservation SET status = ? WHERE reservation_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $reservation_id]);
    }

    public function showClientReservations(){
       $user_id = $_SESSION['user_id'];

       $sql = "SELECT r.*, v.modele, v.marque, v.prix, v.vehicule_id 
              FROM reservation r 
              JOIN vehicule v ON r.vehicule_id = v.vehicule_id 
              WHERE r.user_id = ? ";
       $stmt = $this->pdo->prepare($sql);

       $stmt->bindParam(1, $user_id);

       $stmt->execute();

       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function reservationPriceCalule($date_debut, $date_fin, $car_id) {
        
        $sql = "SELECT DATEDIFF(:date_fin, :date_debut) AS days_difference,
                       prix,
                       (DATEDIFF(:date_fin, :date_debut) * prix) AS total_price
                FROM vehicule
                WHERE vehicule_id = :carid";
    
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(":date_debut", $date_debut);
        $stmt->bindParam(":date_fin", $date_fin);
        $stmt->bindParam(":carid", $car_id);
    
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['total_price'];
    }

}

?>