<?php
 require_once '../connection/connect.php';

 class Theme {
    protected $them_nam;
    protected $them_date;
    private $pdo;

    function __construct(){
      $connection = new DBconnect();
      $this->pdo = $connection->connectpdo();
    }

    function ajouterTheme($them_nam, $them_date){
      $this->them_nam = $them_nam;

    }

 }