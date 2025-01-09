<?php 
require_once '../classes/connect.php';

class Theme {
    public $theme_id;
    public $name;
    public $description;
    public $CreatedDate;
    private $pdo;

    function __construct() {
        $connection = new DBconnect();
        $this->pdo = $connection->connectpdo();
    }

    function createTheme($name, $description){
        $this->name = $name;
        $this->description = $description;
        

        $sql = "INSERT INTO theme(name, description, date_creation)
                VALUES (:name, :description, CURDATE())";
        
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('description', $this->description);

        if($stmt->execute()){
            header('Location: ../pages/blog_dashboard.php');
            exit();
        }
    }

    function updateTheme(){

    }

    function deleteTheme(){

    }

    function getAllThemes(){
        $sql = "SELECT * FROM theme";
        $stmt = $this->pdo->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

if(isset($_POST['Theme_submit'])){
    $theme_name = $_POST['theme_name'];
    $theme_desc = $_POST['theme_desc'];

    $theme = new Theme();

    $theme->createTheme($theme_name, $theme_desc);
}
?>