<?php 

require_once "../Controllers/ComplaintsController.php";

$action = $_GET['action'];

if ($action === "newComplaints")
{
    if (empty($_POST['id'])) {
        ComplaintsController::newComplaints($_POST);
    } else {
        // ComplaintsController::newComplaints($_POST);
    }
}
else if ($action === "getComplaints")
{
    ComplaintsController::getComplaints($_GET);
}
else if ($action === "setScheduleComplaints")
{
    ComplaintsController::setScheduleComplaints($_POST);
}
else if ($action === "setStatusComplaints")
{
    ComplaintsController::setStatusComplaints($_POST);
}
else if ($action === "getComplaint")
{
    ComplaintsController::getComplaint($_GET['id']);
}