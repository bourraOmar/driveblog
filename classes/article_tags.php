<?php 
require_once '../connection/connect.php';

class ArticleTag {
    public $article_id;
    public $tag_id;
    public $CreatedDate;
    private $pdo;

    static function getConnection(){
        $connection = new DBconnect();
        return $connection->connectpdo();
    }

    function __construct($tag_ids, $article_id){
    $connection = new DBconnect();
    $this->pdo = $connection->connectpdo();
    $this->article_id = $article_id;
    $this->tag_id = $tag_ids;
    }

    function addTagToArticle(){
        $sql = "INSERT INTO article_tag (article_id, tag_id, CreatedDate)
                VALUES (:article_id, :tag_id, CURDATE())";
        $pdo = self::getConnection();
        $stmtt = $pdo->prepare($sql);
    
        $stmtt->bindParam(':article_id', $this->article_id);
        $stmtt->bindParam(':tag_id', $this->tag_id);
    
        $stmtt->execute();
    }

    function filtrerParTag(){
        
    }
}

?>