<?php 

require_once "../Controllers/LogsController.php";


$action = $_GET['action'];


if ($action == "get")
{
    LogsController::get($_GET);
}