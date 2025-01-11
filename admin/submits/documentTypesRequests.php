<?php 

require_once "../Controllers/DocumentTypesController.php";




$action = $_GET['action'];

if ($action == "newDocumentType")
{
    if (empty($_POST['documentTypeId'])) {
        DocumentTypesController::newDocumentType($_POST['documentTypeName']);
    } else {
        DocumentTypesController::updateDocumentType($_POST['documentTypeId'], $_POST['documentTypeName']);
    }
}
else if ($action == "getDocumentTypes")
{
    DocumentTypesController::getDocumentTypes($_GET['search']);
}
else if ($action == "deleteDocumentType")
{
    DocumentTypesController::deleteDocumentType($_POST['id']);
}