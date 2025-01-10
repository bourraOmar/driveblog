<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once '../classes/conn.php';

class Avis {
    protected $Commentaire;
    protected $date_creation;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function ajouterAvis($commentaire, $user_id, $vehicule_id){
        $sql = "INSERT INTO avis(commentaire, date_creation,status, user_id, vehicule_id)
                VALUES (:commentaire, CURDATE(),'active' , :user_id, :vehicule_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':vehicule_id', $vehicule_id);

        if($stmt->execute()){
            $_SESSION['commentAdd'] = "Review added successfully!";
            header('Location: ../pages/reservation_page.php?vehiculeId='. $vehicule_id .'');
            exit();
        }else{
            $_SESSION['commentdontAdd'] = "An error on your review. please try again!";
            header('Location: ../pages/reservation_page.php?vehiculeId='. $vehicule_id .'');
            exit();
        }
    }

    function showAvis($vehicule_id){
        $sql = "SELECT u.nom, u.prenom, a.commentaire, a.date_creation, a.avis_id, a.user_id
                FROM user u 
                LEFT JOIN avis a
                ON a.user_id = u.user_id
                WHERE a.vehicule_id = :vehicule_id AND a.status = 'active'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":vehicule_id", $vehicule_id);

        $stmt->execute();

        $_SESSION['voiture_id'] = $vehicule_id;

        return $stmt->fetchAll(pdo::FETCH_ASSOC);

    }

    function modifierAvis($avis_id, $user_id, $new_commentaire){
        
    }

    function supprimerAvis($avis_id, $user_id){
        $sql = "UPDATE avis
                SET status = 'archived'
                WHERE user_id = :user_id AND avis_id = :avis_id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':avis_id', $avis_id);

        $stmt->execute();
    }
}

if(isset($_POST['DeleteAvisID'])){
    $user_id = $_SESSION['user_id'];
    $avis_id = $_POST['DeleteAvisID'];

    $avis = new Avis();

    if($avis->supprimerAvis($avis_id, $user_id)){
        $_SESSION['suppavissuccess'] = 'comment deleted success!';
        header('Location: ../pages/reservation_page.php?vehiculeId='. $_SESSION['voiture_id'] .'');
        exit();
    }else{
        $_SESSION['suppaviserror'] = 'comment deleted success!';
        header('Location: ../pages/reservation_page.php?vehiculeId='. $_SESSION['voiture_id'] .'');
        exit();
    }

}

?>