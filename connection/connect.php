
<?php 
class DBconnect {

    protected $dsn = 'mysql:host=localhost;dbname=DriveBlog';
    protected $user = 'root';
    protected $pass = "";
    public $pdo;

    function connectpdo(){
        try{
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass);
            return $this->pdo;
        }
        catch(PDOException $e){
            echo 'errer :' . $e->getMessage();
        }
    }
}
?>
