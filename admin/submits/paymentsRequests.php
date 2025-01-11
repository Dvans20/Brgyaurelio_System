<?php 

require_once "../Controllers/PaymentsController.php";

$action = $_GET['action'];


if ($action === "newPayment")
{
    PaymentsController::newPayment($_POST);
}
else if ($action === "gePayments") 
{
    PaymentsController::gePayments($_GET);
}
else if ($action === "gePayment")
{
    PaymentsController::gePayment($_GET['id']);
}