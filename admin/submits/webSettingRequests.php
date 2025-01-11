<?php 

require_once "../Controllers/WebSettingController.php";
// webSettingRequests.php

$action = $_GET['action'];

if ($action == "get")
{
    WebSettingController::getSetting();
}
else if ($action == "updateAbout")
{
    WebSettingController::updateAbout($_POST['about']);
}
else if ($action == "updateSiteLogo")
{
    WebSettingController::updateSiteLogo($_POST['image']);
}
else if ($action == "updateSiteUrl")
{
    WebSettingController::updateSiteUrl($_POST['siteUrl']);
}
else if ($action == "updateBrgyInfo")
{
    WebSettingController::updateBrgyInfo($_POST);
}
else if ($action == "updateEmbeddedMap")
{
    WebSettingController::updateEmbeddedMap($_POST['embeddedMap']);
}
else if ($action =="editAboutPage") {
    WebSettingController::editAboutPage($_POST['content']);
}
else if ($action == "updateCoverImage")
{
    WebSettingController::updateCoverImage($_POST);
}
else if ($action == "addPurok") 
{
    WebSettingController::addPurok($_POST['purok']);
}
else if ($action == "deletePurok")
{
    WebSettingController::deletePurok($_POST['purok']);
}
else if ($action == "editDesignaturies")
{
    WebSettingController::editDesignaturies($_POST);
}
else if ($action == "saveCouncilor")
{
    if (empty($_POST['id'])) {
        WebSettingController::saveCouncilor($_POST);
    } else {
        WebSettingController::updateCouncilor($_POST);
    }
}
else if ($action == "getCouncilors") 
{
    WebSettingController::getCouncilors();
}
else if ($action == "getOneCouncilor") 
{
    WebSettingController::getCouncilor($_GET['id']);
}
else if ($action == "deleteCouncilor")
{
    WebSettingController::deleteCouncilor($_POST['id']);
}