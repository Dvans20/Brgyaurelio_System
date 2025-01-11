<?php 



// $ch = curl_init();
// $parameters = array(
    
//     // 'apikey' => '4162cacedc9e175d6fabff020260271b', //Your API KEY
//     'apikey' => 'bda0b79d292c97ba038c8c05d4b4875f', //Your API KEY
//     'number' => '09102404609',
//     'message' => 'I just sent my first message with Semaphore',
//     'sendername' => 'SEMAPHORE'
// );
// curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
// curl_setopt( $ch, CURLOPT_POST, 1 );

// //Send the parameters set above with the request
// curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

// // Receive response from server
// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
// $output = curl_exec( $ch );
// curl_close ($ch);

// //Show the server response
// echo $output;


$uri = $_SERVER['REQUEST_URI'];

$currentUri = explode("?", $uri)[0];

$currentUri = str_replace("/aurelio/", "", $currentUri);

// if ($currentUri != '') {
//     if ($currentUri[-1] == "/") {
//         $currentUri = substr($currentUri, 0, -1) . "";
    
//     }
// }

$linkExt = "";

for ($i = 0; $i < substr_count($currentUri, '/'); $i++) {
    $linkExt .= "../";
}

// echo ($currentUri);

function isExist($array, $value){
    $isExisted = false;

    if (is_array($array)) {

        for($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $value) {
                $isExisted = true;
                break;
            }
        }
    }

    return $isExisted;
}

$URIs = [
    '',
    'home',
    'about',
    'news',
    'resolutions',
    'transparencies',
    'rbim',
    'rbbo',
    'rbim_status',
    'rbbo_status',
    'requestAuth',
    'certificate_request',
];

$unFolderedUris = [
    "",
    "home",
    "about",
    "rbim",
    "rbim_status",
    "rbbo",
    "rbbo_status",
    "requestAuth",
    'certificate_request',
];

$currentUri = str_replace("/", "", $currentUri);
// echo $currentUri;
// echo '<br>';

if (!isExist($URIs, $currentUri)) {
    require_once "admin/Utilities/Database.php";
    require_once "admin/Models/WebSetting.php";
    $web = WebSetting::get();
    require_once "notFound.php";
} else if (!isExist($unFolderedUris, $currentUri)) {
    // echo ($currentUri . "/index.php");
    require_once $currentUri . "/index.php";
} else if ($currentUri != "") {
    $linkExt = "";
    // echo ($currentUri . ".php");
    require_once $currentUri . ".php";
} else {
    $linkExt = "";
    // echo ("home.php");
    require_once "home.php";
}

