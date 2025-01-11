<?php 

require_once '../Controllers/UsersController.php';

$action = $_GET['action'];

// if ($action == "login") 
// {
//     UsersController::login($_POST);
// }
// else if ($action == "userForm") 
// {
//     if ($_POST['id'] == "") {
//         UsersController::saveUser($_POST);
//     } else {
//         UsersController::updateUser($_POST);
//     }
// }
// else if ($action == 'updateSessionTime')



switch ($action) {
    case "login":
        UsersController::login($_POST);
        break;
    case "userForm":
        if ($_POST['id'] == "") {
            UsersController::saveUser($_POST);
        } else {
            UsersController::updateUser($_POST);
        }
        break;
    case "updateSessionTime": 
        UsersController::updateUserSessionTime();
        break;
    case "logOut":
        UsersController::logOut();
        break;
    case "getLOggedInUser" :
        UsersController::getLOggedInUser();
        break;
    case "updateUser":
        UsersController::updateUser($_POST);
        break;
    case "changePassword":
        UsersController::changePassword($_POST);
        break;
    case "getUsers":
        UsersController::getUsers($_GET);
        break;
    case "getUser":
        UsersController::getUser($_GET['id']);
        break;
    case "updateAccessType":
        UsersController::updateAccessType($_POST);
        break;
    case "deleteUser":
        UsersController::deleteUser($_POST);
        break;
}
