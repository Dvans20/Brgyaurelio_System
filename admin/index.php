<?php 

    date_default_timezone_set("Asia/Manila");
    // error_reporting(0);

    session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
    $uri = $_SERVER['REQUEST_URI'];

    $url = "";

    if (isset($_SERVER['HTTPS_HOST'])) {
        $url = "https://" . $_SERVER['HTTPS_HOST'];
    } else {
        $url = "http://" . $_SERVER['HTTP_HOST'];
    }

    // use this if deployed.
    $url .= "/"; 

    // use this if localhost.
    // $url .= "/aurelio/admin/"; 


    // to change
    $currentUri = explode("?", $uri)[0];
    // to change 
    // remove if deployed
    $currentUri = trim($currentUri, "/");
      

    // chane index to 0 if deployed 2 in localhost
    if (count(explode("/", $currentUri)) > 0) { 
        $currentUri = explode("/", $currentUri)[0];
    } else {
        $currentUri = "";
    }




    $extLink = "";

    for ($i = 0; $i < substr_count($currentUri, '/'); $i++) {
        $extLink .= "../";
    }

    

    // && strpos($currentUri, "login") == false


    require_once 'Utilities/Database.php';
    require_once 'Models/WebSetting.php';
    $web = WebSetting::get();

    // echo ($extLink);

    
    if (isset($_SESSION['brgyAurelioUser'])) {
       
        require_once 'Models/User.php';

        $loggedInUser = User::findById($_SESSION['brgyAurelioUser']);
    }

    if (!file_exists("Views/" . $currentUri . ".php") && $currentUri != "") {

        if (!isset($_SESSION['brgyAurelioUser'])) {
            header("Location: login");
            exit();
        } else {
            require_once 'Views/notFound.php';
            exit();
        }
        
    } else {

        if ($currentUri == "") {
            if (!isset($_SESSION['brgyAurelioUser'])) {
                header("Location: login");
                exit();
            } else {
                require_once 'Utilities/Database.php';
                require_once 'Models/User.php';

                $loggedInUser = User::findById($_SESSION['brgyAurelioUser']);

                require_once "Views/dashboard.php";
                exit();
            }
        } else {
            if (!isset($_SESSION['brgyAurelioUser']) && $currentUri != "login") {

                header("Location: login");
                exit();
            } else if (isset($_SESSION['brgyAurelioUser']) && $currentUri == "login") {
                header("Location: dashboard");
                exit();
            
            } else {
               
                if ($currentUri == "login") {
                    require_once "Views/" . $currentUri . ".php";
                    exit();
                } else if (($currentUri == "users" || $currentUri == "logs") && $loggedInUser->accessType != 1) {
                    header("Location: dashboard");
                    exit();
                } else if ($loggedInUser->accessType == 2 && ($currentUri == "transparency" || $currentUri == "payments")) {
                    header("Location: dashboard");
                    exit();
                } else if ($loggedInUser->accessType == 3 && ($currentUri == "rbim" || $currentUri == "news" || $currentUri == "resolutions" || $currentUri == "websiteSettings" || $currentUri == "complaints")) {
                    header("Location: dashboard");
                    exit();
                } else {
                    require_once "Views/" . $currentUri . ".php";
                    exit();
                }

                
            }
            
        }

    }

   

    

