<?php
 require_once '../connection/connect.php';

 class Theme {
    protected $them_name;
    protected $them_desc;
    protected $them_date;
    private $pdo;

    function __construct(){
      $connection = new DBconnect();
      $this->pdo = $connection->connectpdo();
    }

    function ajouterTheme($them_name, $them_desc, $them_date){
      $this->them_name = $them_name;
      $this->them_desc = $them_desc;
      $this->them_date = $them_date;

      $sql = "INSERT INTO theme VALUES(name, description, date_creation)";

      $stmt = $this->pdo->prepare($sql);

      $stmt->bindParam(':nom', $them_name);
      $stmt->bindParam(':description', $them_desc);
      $stmt->bindParam(':date_creation', $them_date);

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