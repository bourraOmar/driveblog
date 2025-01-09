<?php 
require_once '../connection/connect.php';

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
        $connection = new DBconnect();
        return $connection->connectpdo();
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

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':theme_id', $this->theme_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':article_image', $article_img);
        $stmt->bindParam(':content', $this->content);
        
        $stmt->execute();
        $this->article_id = $this->pdo->lastInsertId();
        return 202;
    }

    static function getAllArticles_Tags(){
        $sql = "SELECT * from article";
       
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
}
?>