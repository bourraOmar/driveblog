<?php 
require_once '../classes/conn.php';

class Theme {
    public $theme_id;
    public $name;
    public $description;
    public $CreatedDate;
    private $pdo;

    static function getConnection(){
        $connection = new DBconnection();
        return $connection->PDOconnect();
    }

    function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
    }

    function createTheme(){
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

    static function getAllThemes(){
        $sql = "SELECT * FROM theme LIMIT 4";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    static function getThemeNmme($themeID){
        $sql = "SELECT * FROM theme
                WHERE theme_id = :themeID";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':themeID', $themeID);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if(isset($_POST['Theme_submit'])){
    $theme_name = $_POST['theme_name'];
    $theme_desc = $_POST['theme_desc'];

    $theme = new Theme($theme_name, $theme_desc);

    $theme->createTheme();
}
?>