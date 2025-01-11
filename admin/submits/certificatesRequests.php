<?php 


require_once "../Controllers/CertificatesController.php";

$action = $_GET['action'];

if ($action == "getCitizens")
{
    CertificatesController::getCitizens($_GET);
}
else if ($action == "getCitizen")
{
    CertificatesController::getCitizen($_GET['id']);
}
else if ($action == "getCitizensByHouseholdId") 
{
    CertificatesController::getCitizenByHouseholdId($_GET);
}
else if ($action == "getBusinessOwners")
{
    CertificatesController::getBusinessOwners($_GET);
}
else if ($action == "getBusinessOwner")
{
    CertificatesController::getBusinessOwner($_GET['id']);
}