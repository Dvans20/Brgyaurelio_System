<?php 

require_once "../Controllers/TransparenciesController.php";

$action = $_GET['action'];

if ($action == "saveTransparency")
{
    if (empty($_POST['id'])) {
        TransparenciesController::saveNewTransparency($_POST, $_FILES['pdfFile']);
    } else {
        TransparenciesController::updateTransparency($_POST, $_FILES['pdfFile']);
    }
}
else if ($action == "getTransparencies")
{
    TransparenciesController::getTransparencies($_GET);
}
else if ($action == "getTransparency")
{
    TransparenciesController::getTransparency($_GET['id']);
}
else if ($action == "deleteTransparency")
{
    TransparenciesController::deleteTransparency($_POST['id']);
}