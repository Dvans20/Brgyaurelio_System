<?php 


require_once "../Controllers/AppController.php";

$action = $_GET['action'];

if ($action == "getPopulations")
{
    AppController::getPopulations($_GET);
} 
else if ($action == "getPopulationsByPurok")
{
    AppController::getPopulationsByPurok($_GET);
}