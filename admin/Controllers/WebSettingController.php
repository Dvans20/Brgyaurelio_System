<?php 

require_once "../Utilities/Database.php";
require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";

class WebSettingController {

    public static function getSetting()
    {

        $webSetting = WebSetting::get();

        if ($webSetting == null) {
            $ws = new WebSetting();
            $ws->newWeb();

            $webSetting = WebSetting::get();
        } 

        echo json_encode($webSetting);
    }

    public static function updateAbout($about)
    {

        $response = [
            'status' => 2,
            'msg' => "",
            'webSetting' => null
        ];

        if (empty($about)) {
            $response['msg'] = "About field is required.";
        } else {
            $webSetting = WebSetting::get();

            $webSetting->about = $about;

            $webSetting->update();

            Log::saveNewActivity("Updated", "Updated the about description of the website.");

            $webSetting->about = nl2br($about);


            $response['msg'] = "About Info Updated.";
            $response['status'] = 3;
            $response['webSetting'] = $webSetting;


        }

        echo json_encode($response);

        
    }

    public static function updateSiteLogo($logo)
    {

        $folderPath = "../Media/images/";

        $webSetting = WebSetting::get();

        try {

            if ($logo != null && $logo != "") {
                $logo_image_parts = explode(";base64,", $logo);
                $logo_image_type_aux = explode("image/", $logo_image_parts[0]);
                $logo_image_type = $logo_image_type_aux[1];
                $logo_image_base64 = base64_decode($logo_image_parts[1]);
                $logo_file = strtolower(str_replace(" ", "-", $webSetting->brgy)).'.png';
    
                file_put_contents($folderPath.$logo_file, $logo_image_base64);

                Log::saveNewActivity("Updated", "Updated the Website Logo.");

                
            }
    
            $response = [
                'msg' => "Site Logo Successfully Updated.",
                'status' => 3,
                'logo' => $logo_file
            ];  
        } catch(Exception $e) {
            $response = [
                'msg' => $e,
                'status' => 1,
            ];  
        }

       

        echo json_encode($response);
    }

    public static function updateSiteUrl($siteUrl)
    {

        $response = [
            'msg' => "",
            'status' => "",
            'webSetting' => "",
        ];
         $webSetting = WebSetting::get();

         $webSetting->siteUrl = $siteUrl;

         $webSetting->update();

         Log::saveNewActivity("Updated", "Updated the Website URL");


        $response['msg'] = "Site URL Updated.";
        $response['status'] = 3;
        $response['webSetting'] = $webSetting;

        echo json_encode($response);

    }

    public static function updateBrgyInfo($datas)
    {
        foreach ($datas as $k=>$v)
        {
            $$k = $v;
        }

        $response = [
            'msg' => "",
            'status' => 2
        ];

        if (empty($brgy) || empty($address) || empty($contact_no) || empty($email) || empty($tagline)) {
            $response['msg'] = "All fields are required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['msg'] = "Invalid Email";
        } else {
            
            $webSetting = WebSetting::get();

            $folderPath = "../Media/images/";

            rename($folderPath.strtolower(str_replace(" ","-",$webSetting->brgy.'.png')), $folderPath.strtolower(str_replace(" ","-",$brgy.'.png')));

            $webSetting->brgy = $brgy;
            $webSetting->address = $address;
            $webSetting->contactNo = $contact_no;
            $webSetting->email = $email;
            $webSetting->tagline = $tagline;
            
            $webSetting->update();

            Log::saveNewActivity("Updated", "Updated the Website Info");

            $response['msg'] = "Website Info Successfully Updated";
            $response['status'] = 3;
            
        }



        echo json_encode($response);
    }

    public static function updateEmbeddedMap($embeddedMap)
    {
        $response = [
            'status'=> 2,
            'msg' => ""
        ];

        if (empty($embeddedMap))
        {
            $response['msg'] = "Embedded Code is required";
        } else 
        {
            $web = WebSetting::get();

            $web->embeddedMap = $embeddedMap;

            $web->update();

            Log::saveNewActivity("Updated", "Updated the Website Map");

            $response['msg'] = "Map successfully updated.";
            $response['status'] = 3;

        }

        echo json_encode($response);
    }

    public static function editAboutPage($content)
    {

        $response = [
            'msg' => "",
            'status' => 2,
        ];


        

        if (empty($content)) {
            $response['msg'] = "Please do not submit an empty content.";
        } else {
            $webSetting = WebSetting::get();
            $webSetting->aboutPage = $content;

            $webSetting->update();

            Log::saveNewActivity("Updated", "Updated the about description of the website.");


            $response['msg'] = "About description Updated.";
            $response['status'] = 3;

        }

        echo json_encode($response);

    }

    public static function updateCoverImage($datas)
    {
        foreach ($datas as $k=>$v)
        {
            $$k = $v;
        }

        $folderPath = "../Media/images/";

        switch ($cover) {
            case "home":
                $cover_file = "home_cover.jpg";
                break;
            case "about":
                $cover_file = "about_cover.jpg";
                break;
            case "news":
                $cover_file = "news_cover.jpg";
                break;
            case "resolutions":
                $cover_file = "resolutions_cover.jpg";
                break;
            case "transparencies":
                $cover_file = "transparencies_cover.jpg";
                break;
            default:
                $cover_file = null;
                break;
        }

        try {

            if ($image != null && $image != "") {
                $cover_image_parts = explode(";base64,", $image);
                $cover_image_type_aux = explode("image/", $cover_image_parts[0]);
                $cover_image_type = $cover_image_type_aux[1];
                $cover_image_base64 = base64_decode($cover_image_parts[1]);
                // $cover_file = strtolower(str_replace(" ", "-", $webSetting->brgy)).'.png';
    
                file_put_contents($folderPath.$cover_file, $cover_image_base64);

                Log::saveNewActivity("Updated", "Updated the " . ucwords($cover) . " page Cover Image");

                
            }
    
            $response = [
                'msg' =>  ucwords($cover) . " Cover Image Successfully Updated.",
                'status' => 3,
                'cover_file' => $cover_file,
                'cover' => $cover
            ];  
        } catch(Exception $e) {
            $response = [
                'msg' => $e->getMessage(),
                'status' => 1,
            ];  
        }

        echo json_encode($response);
    }

    public static function addPurok($purok)
    {
        $webSetting = WebSetting::get();

        $response = [
            'status' => 2,
            'msg' => "",
            'puroks' => null
        ];

        if (empty($purok)) {
            $response['msg'] = "Do not submit an empty field.";
        } else {
            if ($webSetting->puroks == null) {
                $webSetting->puroks = serialize([$purok]);
                
            } else {
                array_push($webSetting->puroks, $purok);
                $webSetting->puroks = serialize($webSetting->puroks);
            }

            $webSetting->update();
            $response['status'] = 3;
            $response['msg'] = "Purok Added.";
            $response['puroks'] = unserialize($webSetting->puroks);

            Log::saveNewActivity("Added", "Added a Purok.");

        }


        echo json_encode($response);

    }

    public static function deletePurok($purok)
    {
        $webSetting = WebSetting::get();

        $newPuroks = array();

        foreach ($webSetting->puroks as $oldPurok) {
            if ($oldPurok != $purok) {
                array_push($newPuroks, $oldPurok);
            }
        }

        $webSetting->puroks = serialize($newPuroks);

        $webSetting->update();

        $response = [
            'status' => 3,
            'msg' => "Purok Deleted.",
            'puroks' => $newPuroks,
        ];

        Log::saveNewActivity("Deleted", "Deleted a Purok.");

        echo json_encode($response);
    }

    public static function editDesignaturies($datas)
    {
        foreach ($datas as $k=>$v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        if (empty($brgySecretaryName) || empty($brgyCaptainName) || empty($brgyTreasurerName) || empty($skChairmanName)) {
            $response['msg'] = "The name of Secretary, Treasurer, Captain and SK Chairman is required.";
        } else {
            $web = WebSetting::get();

            $web->brgyCaptainName = $brgyCaptainName;
            $web->brgySecretaryName = $brgySecretaryName;
            $web->brgyTreasurerName = $brgyTreasurerName;
            $web->skChairmanName = $skChairmanName;

            $web->update();

            Log::saveNewActivity("Updated", "Updated the name of brgy. secretary, treasurer, captain and SK Chairman.");

            $response['status'] = 3;
            $response['msg'] = "Names Updated";
        }

        echo json_encode($response);
    }

    public static function saveCouncilor($datas)
    {
        foreach ($datas as $k=>$v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        if (empty($name) || empty($designation)) {
            $response['msg'] = "Name and Designation is required.";
        } else {
            $councilor = [
                'name' => $name,
                'designation' => $designation,
                'id' => uniqid().time(),
            ];

            $web = WebSetting::get();

            if ($web->councilors == null) {
                $web->councilors = array($councilor);
            } else {
                array_push($web->councilors, $councilor);
            }

            $web->update();

            Log::saveNewActivity("Added", "Added a new Brgy. Councilor.");

            $response['status'] = 3;
            $response['msg'] = "Councilor Saved.";


        }

        echo json_encode($response);
    }

    public static function updateCouncilor($datas)
    {
        foreach ($datas as $k=>$v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        if (empty($name) || empty($designation)) {
            $response['msg'] = "Name and Designation is required.";
        } else {
            $councilor = [
                'name' => $name,
                'designation' => $designation,
                'id' => $id
            ];

            $web = WebSetting::get();

            $councilors = array();

            foreach ($web->councilors as $cc) {
                if ($cc['id'] == $id) {
                    $cc = $councilor;
                }

                array_push($councilors, $cc);
            }

            $web->councilors = $councilors;

            
            $web->update();

            Log::saveNewActivity("Updated", "Updated a Brgy. Councilor's Info.");

            $response['status'] = 3;
            $response['msg'] = "Councilor Updated.";


        }

        echo json_encode($response);
    }

    public static function getCouncilors()
    {
        $web = WebSetting::get();

        echo json_encode($web->councilors);

    }

    public static function getCouncilor($id)
    {
        $web = WebSetting::get();

        $councilor = null;

        if ($web->councilors != null) {
            foreach ($web->councilors as $cc) {
                if ($cc['id'] == $id) {
                    $councilor = $cc;
                    break;
                }
            }
        }

        echo json_encode($councilor);
    }

    public static function deleteCouncilor($id)
    {
        $web = WebSetting::get();

        
        $response = [
            'status' => 2,
            'msg' => "",
        ];

        if ($web->councilors == null) {
            $response['msg'] = "Something went wrong. Unable to find Data.";
        } else {

            $councilors = array();

            foreach($web->councilors as $councilor) {
                if ($councilor['id'] != $id) {
                    array_push($councilors, $councilor);
                }
            }

            $web->councilors = $councilors;

            $web->update();

            Log::saveNewActivity("Deleted", "Deleted a Brgy. Councilor.");

            $response['status'] = 3;
            $response['msg'] = "Councilor Removed.";

        }   

        echo json_encode($response);
    }

}