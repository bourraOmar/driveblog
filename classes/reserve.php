
<?php 
require_once '../connection/connect.php';

class reservation {
    protected $date_debut;
    protected $date_fin;
    protected $status;
    protected $price;
    private $pdo;

    function __construct(){
        $connection = new DBconnect();
        $this->pdo = $connection->connectpdo();
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

    public function showClientReservations(){
       $user_id = $_SESSION['user_id'];

       $sql = "SELECT r.*, v.modele, v.marque, v.prix
              FROM reservation r 
              JOIN vehicule v ON r.vehicule_id = v.vehicule_id 
              WHERE r.user_id = ? ";
       $stmt = $this->pdo->prepare($sql);

       $stmt->bindParam(1, $user_id);

       $stmt->execute();

       return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateReservationStatus($reservation_id, $status) {
        $sql = "UPDATE reservation SET status = ? WHERE reservation_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $reservation_id]);
    }

    
}

?>
