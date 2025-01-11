<?php 

require_once "../Utilities/Database.php";

require_once "../Models/Citizen.php";
require_once "../Models/HouseHold.php";
require_once "../Models/WebSetting.php";

require_once "../Models/Log.php";
require_once "../Models/User.php";

require_once "../Models/Mailer.php";

class HouseHoldsController {

    public static function saveInfo($datas)  
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        $year = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr = 2;
        } else {
            $qtr = 4;
        }

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        if (empty($purok) || empty($status_of_house_ownership) || empty($electricity) || empty($source_of_water) || empty($sanitary_toilet) || empty($contactNo) || empty($email) || empty($monthLyIncome) || empty($familyMembers) || empty($passKey) || empty($existency)) {
            $response['msg'] = "All fields are required.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['msg'] = "Incorrect Email.";
        } else if (!is_numeric($monthLyIncome)) {
            $response['msg'] = "Invalid Monthly Income.";
        } else if (empty($head)) {
            $response['msg'] = "Please Select the head of the household.";
        } else if (HouseHold::findByEmail($email, $year, $qtr) != null) {
            $response['msg'] = "Your email is already in use. Please use another email.";
        } else if (HouseHold::findByContactNo($contactNo, $year, $qtr) != null) {
            $response['msg'] = "Your contact no. is already in use. Please use another contact no.";
        }else if (!preg_match($pattern, $passKey) && $existency == 2) {
            $response['msg'] = "Pass key must contain a lowercase, uppercase, number, any special character and at least 8 characters.";
        } else {
            
            $houseHold = new HouseHold();

            $houseHold->purok = $purok;
            $houseHold->numFamily = $numFamily;
            $houseHold->houseOwnershipStatus = $status_of_house_ownership;
            $houseHold->electricity = $electricity;
            $houseHold->waterSources = serialize($source_of_water);
            $houseHold->sanitaryToilet = $sanitary_toilet;

            $houseHold->contactNo = $contactNo;
            $houseHold->email = $email;
            $houseHold->monthLyIncome = $monthLyIncome;

            $houseHold->houseHoldKey = $passKey;

            if ($existency == 1) {
                $houseHold->houseHoldNo = $houseHoldNo;
            }

            $houseHold->status = 0;

            $houseHold->year = date('Y');

            if (date('m') / 1 <= 6) {
                $houseHold->qtr = 2;
            } else {
                $houseHold->qtr = 4;
            }

            $houseHoldSave = $houseHold->save();


            if (!is_bool($houseHoldSave) || $houseHoldSave != true) {
                $response['msg'] = $houseHoldSave;
            } else {
                foreach ($familyMembers as $familyMember) {
                    $citizen = new Citizen();

                    $name = "";

                    if (empty($familyMember['middleName'])) {
                        $name = $familyMember['firstName'] . " " . $familyMember['lastName'] . " " . $familyMember['extName'];
                    } else {
                        $name = $familyMember['firstName'] . " " . $familyMember['middleName'] . " " . $familyMember['lastName'] . " " . $familyMember['extName'];
                    }

                    $citizen->name = trim($name);
                    $citizen->lastName = $familyMember['lastName'];
                    $citizen->firstName = $familyMember['firstName'];
                    $citizen->middleName = $familyMember['middleName'];
                    $citizen->extName = $familyMember['extName'];
                    $citizen->sex = $familyMember['sex'];

                    $citizen->civilStatus = $familyMember['civilStatus'];
                    $citizen->religion = $familyMember['religion'];
                    $citizen->educationalAttainment = $familyMember['educationalAttainment'];

                    $citizen->birthDate = $familyMember['birthDate'];
                    $citizen->birthPlace = $familyMember['birthPlace'];
                    $citizen->occupation = $familyMember['occupation'];
                    $citizen->role = $familyMember['role'];
                    $citizen->isSchooling = $familyMember['isSchooling'];

                    $citizen->soloParent = $familyMember['soloParent'];
                    $citizen->pwdId = $familyMember['isPWD'];

                    if ($citizen->pwdId != 0 && is_array($familyMember['disabilityTypes'])) {
                        $citizen->disabilityType = serialize($familyMember['disabilityTypes']);
                    } else {
                        $citizen->disabilityType = serialize(array());
                    }

                    

                    $citizen->houseHoldId = $houseHold->id;
                    $citizen->qtr = $houseHold->qtr;
                    $citizen->year = $houseHold->year;

                    $citizen->isHead = $familyMember['isHead'];

                    $citizen->save();
                }

                $response['status']  = 3;
                $response['msg'] = "<strong>Thank You</strong> <br> Your household information is currently being processed. We appreciate your patience and will notify you shortly with an update.";
            }



        }

        echo json_encode($response);
    }

    public static function getRBIM($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        if (empty($grouped_by)) {
            HouseHoldsController::getCitizens($datas);
        } else {
            HouseHoldsController::getHouseHolds($datas);
        }
    }

    public static function getCitizens($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        // foreach ($advanceFilter as $k => $v) {
        //     $$k = $v;
        // }

        if ($advanceFilter != null) {

            if (isset($advanceFilter['soloParentFilter'])) {
                $soloParentFilter = $advanceFilter['soloParentFilter'];
            } else {
                $soloParentFilter = null;
            }

            if (isset($advanceFilter['studentFilter'])) {
                $studentFilter = $advanceFilter['studentFilter'];
            } else {
                $studentFilter = null;
            }

            if (isset($advanceFilter['srCitizenFilter'])) {
                $srCitizenFilter = $advanceFilter['srCitizenFilter'];
            } else {
                $srCitizenFilter = null;
            }

            if (isset($advanceFilter['cyFilter'])) {
                $cyFilter = $advanceFilter['cyFilter'];
            } else {
                $cyFilter = null;
            }
            
            if (isset($advanceFilter['pwdFilter'])) {
                $pwdFilter = $advanceFilter['pwdFilter'];
            } else {
                $pwdFilter = null;
            }

            $citizens = Citizen::findByAdvanceFilter($page, $limit, $purok, $status, $year, $qtr, $soloParentFilter, $studentFilter, $srCitizenFilter, $cyFilter, $pwdFilter);
            $response = [
                'groupedBy' => 0,
                'data' => $datas,
                'citizens' => $citizens,
                'totalPages' => ceil(Citizen::countByAdvanceFilter($purok, $status, $year, $qtr, $soloParentFilter, $studentFilter, $srCitizenFilter, $cyFilter, $pwdFilter) / $limit)
            ];
            echo json_encode($response);
            
        } else {
            $citizens = Citizen::findAll($search, $purok, $status, $year, $qtr, $page, $limit);

            $count = Citizen::countAll($search, $purok, $status, $year, $qtr);
    
            $response = [
                'groupedBy' => 0,
                'citizens' => $citizens,
                'totalPages' => ceil($count / $limit)
            ];
    
            echo json_encode($response);
        }

        
    }

    public static function getHouseHolds($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $houseHolds = HouseHold::findAll($search, $purok, $houseOwnershipStatus, $electricity, $sanitaryToilet, $monthLyIncome, $status, $year, $qtr, $page, $limit);

        $count = HouseHold::countAll($search, $purok, $status, $year, $qtr);


        $response = [
            'groupedBy' => 1,
            'houseHolds' => $houseHolds,
            'totalPages' => ceil($count / $limit),
        ];

        echo json_encode($response);

    }

    public static function getHousHold($id)
    {

        $houseHold = HouseHold::findById($id);

        echo json_encode($houseHold);
    }

    public static function declineHouseholdUpdate($datas)
    {
        $reasons = array();
        foreach ($datas as $k => $v) {
            $$k = $v;
        }


        $web = WebSetting::get();

        $response = [
            'status' => 2,
            'msg' => "",
            'reasons' => $reasons,
            'id' => $id
        ];

        if (empty($id) || empty($reasons)) {
            $response['msg'] = "Please select a reason for declining registration/update.";
        } else {


            $household = HouseHold::findById($id);
            $household->statusMsg = serialize($reasons);
            $household->status = 2;

            // Mail Here
            $mailer = new Mailer();
            $mailer->recipientAddress = $household->email;

            $mailer->isHTML = true;

            $mailer->subject = "Your Registration/Update for Inhabitant/Migrant.";

            $mailer->body = "<p>Your Registration/Update for Inhabitant/Migrant has been declined due to the following reasons.</p>";

            $mailer->body .= "<ul>";

            foreach ($reasons as $reason) {
                $mailer->body .= "<li>". $reason ."</li>";
            }

            $mailer->body .= "</ul>";


            $mailer->body .= "<p>Please retry the registraion/update process or you may contact us ". $web->contactNo ." or email as ". $web->email .". You can also visit us at ". $web->address .".</p>";

            $mailer->body .= "<p><b>Thank You And Mabuhay</b></p>";


          

            $mailer->send();
            // Mail Here

            // SMS
                $api_key = '4162cacedc9e175d6fabff020260271b';
                $sender_name = 'Aurelio';
                $url = 'https://api.semaphore.co/api/v4/messages';
                $message = "Please retry the registraion/update process or you may contact us " . $web->contactNo . " or email as ".  $web->email ." also visit us at ". $web->address ."\n\n Please check your Email for more info. \n\nFrom Brgy Aurelio. Thank you!";
                $postData = [
                    'apikey' => $api_key,
                    'number' => $household->contactNo,
                    'message' => $message,
                    'sendername' => $sender_name
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $smsResponse = curl_exec($ch);
                if (curl_errno($ch)) {
                    throw new Exception("SMS sending failed: " . curl_error($ch));
                }
                curl_close($ch);
            // SMS HERE



            $household->update();

            $head;

            foreach ($household->familyMembers as $fam) {
                if ($fam->isHead == 1) {
                    $head = $fam;
                }
            }

            Log::saveNewActivity("Declined", "Declined the registration/update of " . $head->name . ".");

            $response['status'] = 3;
            $response['msg'] = "Household registration/update Declined.";

        }

        echo json_encode($response);
    }

    public static function deleteHouseholdUpdate($id)
    {
        $household = HouseHold::findById($id);

        foreach ($household->familyMembers as $familyMember)
        {
            $familyMember->delete();
        }

        $household->delete();

        $response = [
            'status' => 3,
            'msg' => "Household registration/update deleted."
        ];

        Log::saveNewActivity("Deleted", "Deleted a registration/update.");

        echo json_encode($response);

    }

    public static function approveHouseholdUpdate($id, $houseHoldNo)
    {

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        $household = HouseHold::findById($id);

        if ($household->houseHoldNo != null) {
            $houseHoldNo = $household->houseHoldNo;
        }

        $isFamMemberConflict = false;

        $head = null;

        foreach ($household->familyMembers as $familyMember) {
            if (Citizen::findByInfo($familyMember->lastName, $familyMember->firstName, $familyMember->middleName, $familyMember->birthDate, $familyMember->civilStatus, $familyMember->sex, 1, $familyMember->year, $familyMember->qtr, $familyMember->id) != null) {
                $isFamMemberConflict = true;
            }

            if ($familyMember->isHead == 1) {
                $head = $familyMember;
            }
        }

        if (empty($houseHoldNo)) {
            $response['msg'] = "Please enter or generate a household no.";
        } else if ($isFamMemberConflict) {
            $response['msg'] = "It seem that one of the family member is already included in another household. <br> Please search the names of these house hold if it is already existed.";
        } else if (!is_numeric($houseHoldNo)) {
            $response['msg'] = "Invalid Household No.";
        } else if (HouseHold::findByHouseholdNo($houseHoldNo, 1, $household->year, $household->qtr)) {
            $response['msg'] = "Household No. already taken.";
        } else {
            $household->status = 1;

            $household->houseHoldNo = $houseHoldNo;
            $household->update();

            // Mail Here
            $mailer = new Mailer();
            $mailer->recipientAddress = $household->email;

            $mailer->isHTML = true;

            $mailer->subject = "Your Registration/Update for Inhabitant/Migrant.";

            // $mailer->body = "<p>Your Registration/Update for Inhabitant/Migrant has been approved due to the following reasons.</p>";

            $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center;"><p><b>Your Registration/Update for Inhabitant/Migrant has been Approved.</b></p> <br> <p>Household No.: '.$household->houseHoldNo.'</p> <br> <p>Thank You!!</p>';

            $mailer->send();
            // Mail Here
 
             // SMS
                $api_key = '4162cacedc9e175d6fabff020260271b';
                $sender_name = 'Aurelio';
                $url = 'https://api.semaphore.co/api/v4/messages';
                $message = "Your Registration/Update for Inhabitant/Migrant has been Approved.\n\nHousehold No.: " . $household->houseHoldNo . "\n\nFrom Brgy Aurelio. Thank you!";
                $postData = [
                    'apikey' => $api_key,
                    'number' => $household->contactNo,
                    'message' => $message,
                    'sendername' => $sender_name
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $smsResponse = curl_exec($ch);
                if (curl_errno($ch)) {
                    throw new Exception("SMS sending failed: " . curl_error($ch));
                }
                curl_close($ch);
            // SMS HERE




           Log::saveNewActivity("Approved", "Approved the registration/update of " . $head->name . ".");

            $response['status'] = 3;
            $response['msg'] = "Household registration/update Approved.";
        }

        echo json_encode($response);
    }

    public static function generateHouseholdNo()
    {
        $response = [
            'householdNo' => HouseHold::generateNo()
        ];  

        echo json_encode($response);
    }

    public static function getHouseholdNoAndKey($datas)
    {
        foreach ($datas as $k => $v) {
        
            $$k = $v;
        }

        $household = HouseHold::findByHouseholdKey($householdNo, $householdKey);

        $web = WebSetting::get();

        $response = [
            'status' => 2,
            'msg' => "",
            'household' => $household
        ];

        $year = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr = 2;
        } else {
            $qtr = 4;
        }


        if ($household == null) {
            $response['msg'] = "Invalid Credentials.";
        } else if ($household->year == $year && $household->qtr == $qtr && $household->status == 0) {
            $response['status'] = 5;
            $response['msg'] = "<strong>Thank You</strong> <br> Your household information is currently being processed. We appreciate your patience and will notify you shortly with an update.";
        } else if ($household->year == $year && $household->qtr == $qtr && $household->status == 1) {
            $response['status'] = 5;
            $response['msg'] = "Your household information has already been verified and aproved. If you have any questions or need further assistance, please don't hesitate to reach out to us. <br> Thank you for your cooperation!";
        } else if ($household->year == $year && $household->qtr == $qtr && $household->status == 2) {
            $response['status'] = 5;
            $response['msg'] = "Your household information update/registration has been declined due to the following reasons.";

            $response['msg'] .= "<ul>";

            foreach (unserialize($household->statusMsg) as $reason) {
                $response['msg'] .= "<li>". $reason ."</li>";
            }

            $response['msg'] .= "</ul>";


            $response['msg'] .= "<p>Please retry the registraion/update process or you may contact us ". $web->contactNo ." or email as ". $web->email .". You can also visit us at ". $web->address .".</p>";

            $response['msg'] .= "<p><b>Thank You And Mabuhay</b></p>";

        } else {
            $response['status'] = 4;
            $response['msg'] = "Welcome back";
        }


       echo json_encode($response);


    }




    public static function authenticateRequest($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        
        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        $household = HouseHold::findByHouseholdKey($householdNo, $householdKey);


        if (empty($householdNo) || empty($householdKey)) {
            $response['msg'] = "Please enter your Household No. and Key.";
        } else if ($household == null) {
            $response['msg'] = "Invalid Credentials.";
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['brgy_household_id'] = $household->id;

            $response['status'] = 3;
            $response['msg'] = "";
        }

        echo json_encode($response);
    }
}