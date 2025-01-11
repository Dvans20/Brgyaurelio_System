<?php 

require_once '../Controllers/CategoriesController.php';

$action = $_GET['action'];


if ($action == "saveNewsCategory")
{
    CategoriesController::saveNewsCategory($_POST['type'], $_POST['category']);
}
else if ($action == "deleteCategories")
{
    if (!isset($_POST['categories'])) {
        $_POST['categories'] = array();
    }
    CategoriesController::deleteCategories($_POST['type'], $_POST['categories']);
}
else if ($action == "getCategories")
{
    CategoriesController::getCategories($_GET['type']);
}