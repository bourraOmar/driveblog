<?php
require_once '../connection/connect.php';

class Categorie
{
  protected $cat_nom;
  protected $cat_description;
  private $pdo;

  function __construct()
  {
    $connection = new DBconnect();
    $this->pdo = $connection->connectpdo();
  }
  // ajouter une categorie methode
  function ajouterCategorie($cat_name, $cat_desc)
  {
    $this->cat_nom = $cat_name;
    $this->cat_description = $cat_desc;

    $sql = "INSERT INTO categorie(nom, description)
                VALUES (:nom, :description)";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':nom', $cat_name);
    $stmt->bindParam(':description', $cat_desc);

    if ($stmt->execute()) {
      header('Location: ../pages/dashboard.php');
      exit();
    }
  }

  function showCategorie()
  {
    $sql = "SELECT * FROM categorie";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

}
