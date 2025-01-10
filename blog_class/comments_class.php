<?php
require_once '../classes/conn.php';

class Comments {
    public $Comments_id;
    public $content;
    public $Createddate;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function createComment(){

    }

    function updateComments(){

    }

    function deleteComments(){

    }

    function allCommentsByArticle(){
        
    }
}
?>