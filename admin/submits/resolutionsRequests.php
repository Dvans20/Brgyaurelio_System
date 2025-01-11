<?php 

require_once "../Controllers/ResolutionsController.php";

$action = $_GET['action'];


if ($action == "addNewResolution")
{
    if (empty($_POST['resolutionId'])) {
        ResolutionsController::addNewResolution($_POST, $_FILES['pdfFile']);
    } else {
        ResolutionsController::updateResolution($_POST, $_FILES['pdfFile']);
    }
}
else if ($action == "getResolutions")
{
    ResolutionsController::getResolutions($_GET);
}
else if ($action == "getResolution")
{
    ResolutionsController::getResolution($_GET['id']);
}
else if ($action == "deleteResolution") 
{
    ResolutionsController::deleteResolution($_POST['id']);
}


