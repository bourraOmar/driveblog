<?php 
require_once '../classes/conn.php';

class Vehicule {
    protected $modele;
    protected $marque;
    protected $prix;
    protected $status;
    protected $Vehicule_image;
    protected $Categorie_id;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function AjouterVehicule($modele, $marque, $prix, $Vehicule_image, $Categorie_id){
        $this->modele = $modele;
        $this->marque = $marque;
        $this->prix = $prix;
        $this->Categorie_id = $Categorie_id;

        if(isset($Vehicule_image)) {
            $uploadDir = '../uploads/';
            $fileName = basename($Vehicule_image['name']);
            $targetFilePath = $uploadDir . $fileName;
    
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            if (move_uploaded_file($Vehicule_image['tmp_name'], $targetFilePath)) {
                $this->Vehicule_image = $targetFilePath;
            } else {
                die("Error uploading the image file.");
            }
        } else {
            die("Error: Invalid image file.");
        }

        $sql = "INSERT INTO vehicule (modele, marque, prix, status, vehicule_image, Categorie_id)
                VALUES (:model, :marque, :prix, 'active', :vehicule_image, :Categorie_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':model', $modele);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':vehicule_image', $this->Vehicule_image);
        $stmt->bindParam(':Categorie_id', $Categorie_id);

        if($stmt->execute()){
            header('Location: ../pages/dashboard.php');
            exit();
        }
    }

    function verifierDisponibilite($vehicule_id){
        $checkDisposql = "UPDATE vehicule
                          SET status = 'Reserved'
                          WHERE status = 'Active' AND vehicule_id = :vehicule_id";
        $checkdispoStmt = $this->pdo->prepare($checkDisposql);
        $checkdispoStmt->bindParam(":vehicule_id", $vehicule_id);

        $checkdispoStmt->execute();

    }

    function showAllVehicule(){
        $sql = "SELECT * FROM showAllVehicule";
        
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function showSpiceficAllVehicule($selectedvehiculeID){
        $sql = "SELECT v.*, c.nom
                FROM vehicule v
                LEFT JOIN Categorie c
                ON v.Categorie_id = c.Categorie_id
                WHERE vehicule_id = :selectedvehiculeID";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':selectedvehiculeID', $selectedvehiculeID);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVehiculesByCategorie($categoryId) {
        $sql = "SELECT v.*, c.nom
            FROM vehicule v
            LEFT JOIN Categorie c ON v.Categorie_id = c.Categorie_id
            WHERE v.Categorie_id = :category_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchForVehicules($searchData){
        $sql = "SELECT v.*, c.nom
                FROM vehicule v
                LEFT JOIN Categorie c ON v.Categorie_id = c.Categorie_id
                WHERE marque LIKE :searchdata";
        $stmt = $this->pdo->prepare($sql);

        $likedata = "%". $searchData ."%" ;

        $stmt->bindParam(":searchdata", $likedata);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeVehicule($Vehicule_id){
        $sql = "DELETE FROM vehicule 
                WHERE vehicule_id = :vehicule_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':vehicule_id', $Vehicule_id);
        $stmt->execute();
    }

    public function EditVehiculeInfos($modele, $marque, $prix, $Vehicule_image, $Categorie_id, $Vehicule_id) {

        if (empty($Vehicule_image['name'])) {
            
            $stmt = $this->pdo->prepare("SELECT vehicule_image FROM vehicule WHERE vehicule_id = :Vehicule_id");
            $stmt->bindParam(':Vehicule_id', $Vehicule_id);
            $stmt->execute();

            $oldImage = $stmt->fetchColumn();

            $Vehicule_image = $oldImage;

        }else{
            $uploadDir = '../uploads/';
            $fileName = basename($Vehicule_image['name']);
            $targetFilePath = $uploadDir . $fileName;
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
        
            if (move_uploaded_file($Vehicule_image['tmp_name'], $targetFilePath)) {
                $Vehicule_image = $targetFilePath;
            } else {
                die("Error uploading the image file.");
            }
        }
    
        $sql = "UPDATE vehicule 
            SET modele = :modele, marque = :marque, prix = :prix, vehicule_image = :vehicule_image, Categorie_id = :Categorie_id
            WHERE vehicule_id = :Vehicule_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':modele', $modele);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':vehicule_image', $Vehicule_image);
        $stmt->bindParam(':Categorie_id', $Categorie_id);
        $stmt->bindParam(':Vehicule_id', $Vehicule_id);

        if($stmt->execute()){
            header('Location: ../pages/dashboard.php');
            exit();
        }else{
            echo "lalalalal";
        }
        
    }

    public function fetchdataforcurrentpage($startIn, $VehiculesParPage) {
        $sql = "SELECT v.*, c.nom
                FROM vehicule v
                LEFT JOIN Categorie c
                ON v.Categorie_id = c.Categorie_id 
                LIMIT :startIn, :VehiculesParPage";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':startIn', $startIn, PDO::PARAM_INT);
        $stmt->bindParam(':VehiculesParPage', $VehiculesParPage, PDO::PARAM_INT);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPagesForPagination(){
        $totalRecordsQuery = "SELECT COUNT(*) AS total FROM vehicule";
        $totalRecordsResult = $this->pdo->prepare($totalRecordsQuery);
    
        $totalRecordsResult->execute();
    
        $totalRecordsRow = $totalRecordsResult->fetch(PDO::FETCH_ASSOC);
    
        return $totalRecordsRow['total'];
    }
    
}

if (isset($_POST['editVehicle_submit']) && isset($_POST['vehiculeId'])) {

    $vehiculeId = $_POST['vehiculeId']; 
    $modele = $_POST['editmodele']; 
    $marque = $_POST['editmarque']; 
    $prix = $_POST['editprice'];
    $Categorie_id = $_POST['editCategory'];
    $vehicule_image = $_FILES['editVehicle_Image']; 

    $vehicule = new Vehicule();

    $vehicule->EditVehiculeInfos($modele, $marque, $prix, $vehicule_image, $Categorie_id, $vehiculeId);

}

?>