<?php 

require_once "../Controllers/NewsController.php";

$action = $_GET['action'];

if ($action == "saveNewNews")
{
    if (empty($_POST['id'])) {
        NewsController::saveNewNews($_POST);
    } else {
        NewsController::updateNews($_POST);
    }
}
else if ($action == "getNews")
{
    NewsController::getNews($_POST);
}
else if ($action == "getSingleNews")
{
    NewsController::getSingleNews($_GET['id']);
} 
else if ($action == "getSingleNewsWithCategories")
{
    NewsController::getSingleNewsWithCategories($_GET['id']);
}
else if ($action == "deleteNews")
{
    NewsController::deleteNews($_POST['id']);
}