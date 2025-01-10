<?php 
require_once '../classes/conn.php';

class Article {
    public $article_id;
    public $user_id;
    public $theme_id;
    public $title;
    public $article_image;
    public $content;
    public $Approved;
    public $CreatedDate;
    private $pdo;

    static function getConnection(){
        $connection = new DBconnection();
        return $connection->PDOconnect();
    }

    function __construct($user_id, $theme_id, $title, $article_image, $content){
        $this->pdo = self::getConnection();
        $this->user_id = $user_id;
        $this->title = $title;
        $this->theme_id = $theme_id;
        $this->article_image = $article_image;
        $this->content = $content;
    }

    function getId(){
        return $this->article_id;
    }

    function CreateArticle(){
        $sql = "INSERT INTO article (user_id, theme_id, title, article_image, content, Approved, date_creation)
                VALUES (:user_id, :theme_id, :title, :article_image, :content, 'waiting', CURDATE())";
        $stmt = $this->pdo->prepare($sql);

        if(isset($this->article_image)) {
            $uploadDir = '../uploads/';
            $fileName = basename($this->article_image['name']);
            $targetFilePath = $uploadDir . $fileName;
    
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            if (move_uploaded_file($this->article_image['tmp_name'], $targetFilePath)) {
                $article_img = $targetFilePath;
            } else {
                die("Error uploading the image file.");
            }
        } else {
            die("Error: Invalid image file.");
        }

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':theme_id', $this->theme_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':article_image', $article_img);
        $stmt->bindParam(':content', $this->content);
        
        $stmt->execute();
        $this->article_id = $this->pdo->lastInsertId();
        return 202;
    }

    function UpdateArticle(){

    }

    function deleteArticle(){

    }

    static function ApprouverArticle($article_id){
        $sql = "UPDATE article
                SET Approved = 'approved'
                WHERE article_id = :article_id";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':article_id', $article_id);

        $stmt->execute();

    }

    static function RefuseArticle($article_id){
        $sql = "UPDATE article
        SET Approved = 'refused'
        WHERE article_id = :article_id";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':article_id', $article_id);

        $stmt->execute();
    }

    function searchByTitle(){

    }

    static function getallArticles(){
        $sql = "SELECT a.*, u.nom, u.prenom
                FROM article a
                LEFT JOIN user u ON a.user_id = u.user_id";
       
        $pdo = self::getConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getAllArticles_Tags(){
        $sql = "SELECT a.*, u.nom, u.prenom
                FROM article a
                LEFT JOIN user u ON a.user_id = u.user_id
                WHERE Approved = 'approved'";
       
        $pdo = self::getConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function gettagsForArticle($article_id){
        $sql = "SELECT t.* from tag t INNER join article_tag art on art.tag_id = t.tag_id where art.article_id = :article_id";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
    }

    function ArticlesPagination(){

    }

    static function getArticlesByTheme($theme_id){
        $sql = "SELECT a.*, t.*
                FROM article a
                LEFT JOIN theme t ON a.theme_id = t.theme_id
                WHERE t.theme_id = :theme_id AND Approved = 'approved'";

        $pdo = self::getConnection();

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':theme_id', $theme_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getSpecifiqueVehicule($article_id){
        $sql = "SELECT * FROM article WHERE article_id = :article_id";
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':article_id', $article_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>