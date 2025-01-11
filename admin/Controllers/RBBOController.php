<?php 

require_once "../Utilities/Database.php";
require_once "../Models/RBBO.php";
require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";

require_once "../Models/Mailer.php";

class RBBOController {
    

    public static function saveRBBO($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        $year = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr = 2;
        } else {
            $qtr = 4;
        }

        $emptyValidator = false;

        if ($existency != 1) {
            // new RBBO
            $emptyValidator = empty($purok) || empty($onwnersName) || empty($residenceAddress) || empty($businessName) || empty($category) || empty($type) || empty($contactNo) || empty($email) || empty($passKey);
        } else {
            $emptyValidator = empty($purok) || empty($onwnersName) || empty($residenceAddress) || empty($businessName) || empty($category) || empty($type) || empty($contactNo) || empty($email) || empty($passKey);
        }

        if ($emptyValidator) {
            $response['msg'] = "All fields are required.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['msg'] = "Inavlid Email.";
        } else if (RBBO::findByEmail($email, $year, $qtr) != null) {
            $response['msg'] = "Your email is already in use. Please use another email.";
        } else if (RBBO::findByContactNo($contactNo, $year, $qtr) != null) {
            $response['msg'] = "Your contact no. is already in use. Please use another contact no.";
        } else if (!preg_match($pattern, $passKey) && empty($busNo)) {
            $response['msg'] = "Pass key must contain a lowercase, uppercase, number, any special character and at least 8 characters.";
        } else {
            
            $rbbo = new RBBO();
            $rbbo->purok = $purok;
            $rbbo->onwnersName = $onwnersName;
            $rbbo->residenceAddress =$residenceAddress;
            $rbbo->businessName = $businessName;
            $rbbo->category = $category;
            $rbbo->type = $type;
            $rbbo->contactNo = $contactNo;
            $rbbo->email = $email;

            $rbbo->passKey = $passKey;

            if ($existency == 1) {
                $rbbo->busNo = $busNo;
            } else {
                $rbbo->busNo = 0;
            }
            
            $rbbo->year = $year;
            $rbbo->qtr = $qtr;
            $rbbo->status = 0;

            $rbbo->save();

            $response['status']  = 3;
            $response['msg'] = "<strong>Thank You</strong> <br> Your information is currently being processed. We appreciate your patience and will notify you shortly with an update.";
        }
 
        echo json_encode($response);
    }

    public static function getRBBOByKey($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $web = WebSetting::get();

        $response = [
            'status' => 2,
            'msg' => "",
            'rbbo' => $datas
        ];

        $year = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr = 2;
        } else {
            $qtr = 4;
        }

        $rbbo = RBBO::findByKey($existingBONo, $existingPassKey);

        if ($rbbo == null) {
            $response['msg'] = "Incorrect Credentials.";
        } else if ($rbbo->year == $year && $rbbo->qtr == $qtr && $rbbo->status == 0) {
            $response['status'] = 5;
            $response['msg'] = "<strong>Thank You</strong> <br> Your information is currently being processed. We appreciate your patience and will notify you shortly with an update.";
        } else if ($rbbo->year == $year && $rbbo->qtr == $qtr && $rbbo->status == 1) {
            $response['status'] = 5;
            $response['msg'] = "Your information has already been verified and aproved. If you have any questions or need further assistance, please don't hesitate to reach out to us. <br> Thank you for your cooperation!";
        } else if ($rbbo->year == $year && $rbbo->qtr == $qtr && $rbbo->status == 2) {
            $response['status'] = 5;
            $response['msg'] = "Your information update/registration has been declined due to the following reasons.";
            $response['msg'] .= "<ul>";

            foreach (unserialize($rbbo->statusMsg) as $reason) {
                $response['msg'] .= "<li>". $reason ."</li>";
            }

            $response['msg'] .= "</ul>";


            $response['msg'] .= "<p>Please retry the registraion/update process or you may contact us ". $web->contactNo ." or email as ". $web->email .". You can also visit us at ". $web->address .".</p>";

            $response['msg'] .= "<p><b>Thank You And Mabuhay</b></p>";
        } else {
            $response['status'] = 3;
            $response['msg'] = "Welcome Back!";
            $response['rbbo'] = $rbbo;
        }

        echo json_encode($response);
    }

    public static function getRBBO($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $rbbos = RBBO::findAll($search, $purok, $year, $qtr, $category, $type, $status, $page, $limit);

        $count = RBBO::countAll($search, $purok, $year, $qtr, $category, $type, $status);

        $response = [
            'rbbos' => $rbbos,
            'totalPages' => ceil($count / $limit)
        ];

        echo json_encode($response);
    }

    public static function generateBusNo()
    {
        echo json_encode(RBBO::generateNo());
    }

  public static function approveRBBO($datas)
{
    foreach ($datas as $k => $v) {
        $$k = $v;
    }

    $response = [
        'status' => 2,
        'msg' => "",
        'datas' => $datas
    ];

    // Validate required inputs
    if (empty($id)) {
        $response['msg'] = "ID is required.";
        echo json_encode($response);
        return;
    }

    if (empty($busNo)) {
        $response['msg'] = "Business No. is required.";
        echo json_encode($response);
        return;
    }

    if (!is_numeric($busNo)) {
        $response['msg'] = "Invalid Business No.";
        echo json_encode($response);
        return;
    }

    $rbbo = RBBO::findById($id);

    if (!$rbbo) {
        $response['msg'] = "RBBO record not found.";
        echo json_encode($response);
        return;
    }

    $year = date('Y');
    $qtr = (date('m') <= 6) ? 2 : 4;

    if (RBBO::findByBusNo($busNo, 1, $year, $qtr) !== null) {
        $response['msg'] = "Business No. already taken.";
        echo json_encode($response);
        return;
    }

    try {
        $rbbo->busNo = $busNo;
        $rbbo->status = 1;
        $rbbo->update();

        // Mail
        $mailer = new Mailer();
        $mailer->recipientAddress = $rbbo->email;
        $mailer->isHTML = true;
        $mailer->subject = "Your Business Registration/Update";
        $mailer->body = '<div style="max-width: 300px; margin: auto; text-align: center;">
            <p><b>Your Business Registration/Update has been Approved.</b></p>
            <p>Bus No. ' . htmlspecialchars($rbbo->busNo) . '</p>
            <p>Thank You!</p>
        </div>';
        $mailer->send();

        // SMS
        $api_key = '4162cacedc9e175d6fabff020260271b';
        $sender_name = 'Aurelio';
        $url = 'https://api.semaphore.co/api/v4/messages';
        $message = "Your Business Registration/Update has been Approved.\n\nBusiness Number: " . $rbbo->busNo . "\n\nFrom Brgy Aurelio. Thank you!";
        $postData = [
            'apikey' => $api_key,
            'number' => $rbbo->contactNo,
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

        Log::saveNewActivity("Approved", "Approved the business registration/update of " . $rbbo->ownersName . ".");

        $response['status'] = 3;
        $response['msg'] = "RBBO registration/update approved.";
    } catch (Exception $e) {
        $response['status'] = 3;
        $response['msg'] = "RBBO registration/update approved.";
    }

    echo json_encode($response);
}


  public static function declineRBBO($datas)
{
    foreach ($datas as $k => $v) {
        $$k = $v;
    }

    $web = WebSetting::get();
    $year = date('Y');
    $qtr = (date('m') / 1 <= 6) ? 2 : 4;

    $response = [
        'status' => 2,
        'msg' => "",
        'datas' => $datas
    ];

    if (empty($reasons) || empty($id)) {
        $response['msg'] = "Please select a reason for declining.";
    } else {
        $rbbo = RBBO::findById($id);
        if (!is_array($reasons)) {
            $response['msg'] = "Invalid reasons format.";
            echo json_encode($response);
            return;
        }

        $rbbo->status = 2;
        $rbbo->statusMsg = serialize($reasons);
        $rbbo->update();

        // Send Email
        $mailer = new Mailer();
        $mailer->recipientAddress = $rbbo->email;
        $mailer->isHTML = true;
        $mailer->subject = "Your Business Registration/Update";
        $mailer->body = "<p>Your Business Registration/Update has been declined due to the following reasons:</p><ul>";
        foreach ($reasons as $reason) {
            $mailer->body .= "<li>" . $reason . "</li>";
        }
        $mailer->body .= "</ul><p>Please retry or contact us: " . $web->contactNo . " or " . $web->email . "</p>";
        $mailer->body .= "<p><b>Thank You and Mabuhay</b></p>";
        $mailer->send();

        // Send SMS
        $api_key = '4162cacedc9e175d6fabff020260271b';
        $sender_name = 'Aurelio';
        $url = 'https://api.semaphore.co/api/v4/messages';
        $message = "Please retry the registration/update process or contact us at " . $web->contactNo . " or email " . $web->email . ". Visit us at " . $web->address . "\n\Please check your email for more information:\n\nThank you";

        $postData = [
            'apikey' => $api_key,
            'number' => $rbbo->contactNo,
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
            $response['msg'] = "SMS sending failed: " . curl_error($ch);
            echo json_encode($response);
            return;
        }
        curl_close($ch);

        // Log Activity
        Log::saveNewActivity("Declined", "Declined the business registration/update of " . $rbbo->onwnersName . ".");

        $response['status'] = 3;
        $response['msg'] = "RBBO registration/update Declined.";
    }

    echo json_encode($response);
}


    public static function deleteRBBO($id)
    {

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        $rbbo = RBBO::findById($id);

        $rbbo->delete();

        Log::saveNewActivity("Deleted", "Deleted the business registration/update of " . $rbbo->onwnersName . ".");


        $response['status'] = 3;
        $response['msg'] = "RBBO registration/update Deleted.";

        echo json_encode($response);
    }
}