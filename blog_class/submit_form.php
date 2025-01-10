<?php
session_start();

require_once '../blog_class/tag_class.php';
require_once '../blog_class/artcile_class.php';
require_once '../blog_class/ArticleTag_class.php';




if(isset($_POST['article_submited'])){
    
    $tags = explode(',', $_POST['tags-input']);
    
    $user_id = $_SESSION['user_id'];
    $article_name = $_POST['artcile_titre'];
    $theme_id = $_POST['article_theme'];
    $article_content = $_POST['article_content'];
    $article_image = $_FILES['article_photo'];

    $article = new Article($user_id, $theme_id, $article_name, $article_image, $article_content);
    $tag = new Tag();

    $article->CreateArticle();
    $tag_id = $tag->addMultipleTags($tags);
    
    foreach($tag_id as $tagID){
        
        $articleTag = new ArticleTag($tagID, $article->getId());
        $articleTag->addTagToArticle();
    }
    

    header('Location: ../blog/create_article.php');
    exit();
}
?>