<?php 
require_once '../classes/conn.php';

class Tag {
    public $tag_id;
    public $name;
    public $CreatedDate;
    private $pdo;

    function __construct(){
        $connection = new DBconnection();
        $this->pdo = $connection->PDOconnect();
    }

    function createTag($name){
        $sql = "INSERT INTO tag(name)
                VALUE (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    function updateTag(){

    }

    function deleteTag(){

    }

    function addMultipleTags($tags) {
        $stmt_check = $this->pdo->prepare("SELECT tag_id FROM tag WHERE name = :tag_name");
        $stmt_insert = $this->pdo->prepare("INSERT INTO tag (name, date_creation) VALUES (:tag_name, CURDATE())");
    
        $lastInsertIds = [];
    
        foreach ($tags as $tag) {
            $stmt_check->bindParam(':tag_name', $tag);
            $stmt_check->execute();
    
            if ($stmt_check->rowCount() == 0) {
                $stmt_insert->bindParam(':tag_name', $tag);
                $stmt_insert->execute();
                $lastInsertIds[] = $this->pdo->lastInsertId();
            } else {
                $existingTag = $stmt_check->fetch(PDO::FETCH_ASSOC);
                $lastInsertIds[] = $existingTag['tag_id'];
            }
        }
    
        return $lastInsertIds;
    }
    

    function showSeggTags($searchInput) {
        $sql = "SELECT * FROM tag WHERE name LIKE :searchInput";
    
        $stmt = $this->pdo->prepare($sql);
    
        $forlikeSearch = "%" . $searchInput . "%";
        $stmt->bindValue(':searchInput', $forlikeSearch, PDO::PARAM_STR);
    
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>