<?php
 require_once '../connection/connect.php';

 class Theme {
    public $theme_id;
    public $them_name;
    public $them_desc;
    public $them_date;
    private $pdo;

    function __construct(){
      $connection = new DBconnect();
      $this->pdo = $connection->connectpdo();
    }

    function ajouterTheme($them_name, $them_desc){
      $this->them_name = $them_name;
      $this->them_desc = $them_desc;

      $sql = "INSERT INTO theme VALUES(:name, :description, CURDATE())";

      $stmt = $this->pdo->prepare($sql);

      $stmt->bindParam(':nom', $this->them_name);
      $stmt->bindParam(':description', $this->them_desc);
      $stmt->bindParam(':date_creation', $this->them_date);

      if($stmt->execute()){
        header('Location: ../profils/dashboardClient.php');
        exit();
      }

    }

    function showTheme(){
      $sql = "SELECT * FROM theme";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      if ($stmt->rowCount() > 0){
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
    }

 }