<?php 

require_once "../Controllers/RequestsController.php";

$action = $_GET['action'];

if ($action == "newRequestCertificate")
{
    RequestsController::newRequestCertificate($_POST);
    // echo json_encode($_POST);
}
else if ($action === "getRequests")
{
    RequestsController::getRequests($_GET);
}
else if ($action === "getRequest")
{
    RequestsController::getRequest($_GET['id']);
}
else if ($action === "updateRequestStatus") 
{
    RequestsController::updateRequestStatus($_POST);
}
else if ($action === "rescheduleRequest")
{
    RequestsController::rescheduleRequest($_POST);
}
else if ($action === "deleteRequest")
{
    RequestsController::deleteRequest($_POST['id']);
}
else if ($action === "getRequestsCount") 
{
    RequestsController::getRequestsCount($_GET);
}