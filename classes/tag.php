
<?php 
require_once '../connection/connect.php';

class Tag {
    public $tag_id;
    public $name;
    public $CreatedDate;
    private $pdo;

    function __construct(){
        $connection = new DBconnect();
        $this->pdo = $connection->connectpdo();
    }

    function createTag($name){
        $sql = "INSERT INTO tag(name)
                VALUE (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    function addMultipleTags($tags) {
        $stmt_check = $this->pdo->prepare("SELECT * FROM tag WHERE name = :tag_name");
        $stmt_insert = $this->pdo->prepare("INSERT INTO tag (name, date_creation) VALUES (:tag_name, CURDATE())");
    
        foreach ($tags as $tag) {
            $stmt_check->bindParam(':tag_name', $tag);
            $stmt_check->execute();

            if ($stmt_check->rowCount() == 0) {
                $stmt_insert->bindParam(':tag_name', $tag);
                $stmt_insert->execute();
                
            }
            $lastinert[]=  $this->pdo->lastInsertId();
        }
        return $lastinert;
       
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


