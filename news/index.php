<?php 
    $linkExt = "../";
    require_once "../Utilities/config.php";

    require_once "../admin/Models/News.php";

    if (isset(($_GET['news']))) {
        $newsId = $_GET['news'];
        require_once "news.php";
    } else {
        require_once "newsList.php";
    }