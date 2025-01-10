<?php 
require_once '../classes/conn.php';

class Favori {
    public $favori_id;
    public $user_id;
    public $article_id;
    public $CreationDate;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function AddToFavorite(){

    }

    function removeFromfavorite(){

    }

    function ShowFavoriteList(){

    }
}
?>