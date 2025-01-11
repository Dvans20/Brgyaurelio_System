<?php 

require_once "../Controllers/HouseHoldsController.php";

$action = $_GET['action'];

if ($action == "saveInfo")
{
    HouseHoldsController::saveInfo($_POST);
}
else if ($action == "getRBIM") 
{
    HouseHoldsController::getRBIM($_GET);
}
else if ($action == "getHousHold") 
{
    HouseHoldsController::getHousHold($_GET['id']);
}
else if ($action == "declineHouseholdUpdate") 
{
    HouseHoldsController::declineHouseholdUpdate($_POST);
}
else if ($action == "deleteHouseholdUpdate")
{
    HouseHoldsController::deleteHouseholdUpdate($_POST['id']);
}
else if ($action == "approveHouseholdUpdate")
{
    HouseHoldsController::approveHouseholdUpdate($_POST['id'], $_POST['houseHoldNo']);
}
else if ($action == "generateHouseholdNo") 
{
    HouseHoldsController::generateHouseholdNo();
}
else if ($action == "getHouseholdNoAndKey")
{
    HouseHoldsController::getHouseholdNoAndKey($_GET);
}
else if ($action == "authenticateRequest") 
{
    HouseHoldsController::authenticateRequest($_POST);
}