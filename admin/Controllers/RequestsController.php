<?php 

require_once "../Utilities/Database.php";
require_once "../Models/Request.php";
require_once "../Models/Mailer.php";
require_once "../Models/SMS.php";
require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";

require_once "../Models/Mailer.php";


class RequestsController {

    public static function newRequestCertificate($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        } 

        $response = [
            'msg' => "",
            'status' => 2,
            'datas' => $datas,
            'someErr' => "",
            'name' => ""
        ];


        $web = WebSetting::get();


        if (empty($name) || empty($address)) {
            $response['msg'] = "Name, email or contact number, and address is required.";
        } else if (empty($email) && empty($contactNumber)) {
            $response['msg'] = "Email or contact number is required.";
        } else if  ($reptMethod == "Send through email" && empty($email)) {
            $response['msg'] = "Email is required.";
        } else if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['msg'] = "Invalid Email.";
        } else if (!isset($certificates)) {
            $response['msg'] = "Please select a certificate.";
        } else {

            if ($contactNumber[0] == "0") {
                $contactNumber = "+63" . substr($contactNumber, 1);
            }
            $request = new Request();

            $request->name = $name;
            $request->email = $email;
            $request->contactNumber = $contactNumber;
            $request->address = $address;
            $request->certificate = serialize($certificates);
            $request->reptMethod = $reptMethod;
            $request->description = $description;

            $request->save();

            // email code here

            if (!empty($email)) {
                $mailer = new Mailer();
                $mailer->recipientAddress = $email;

                $mailer->isHTML = true;

                $mailer->subject = "Your Certification Request.";

                if ($request->reptMethod == "Send through email") {
                    $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center;"><p><b>Your Request is being processed.</b></p> <br> <p>Thank You!!</p>';
                } else {
                    $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center;"><p><b>Your Request is being processed.</b></p> <br> <p>Thank You!!</p>';
                }



                $mailer->send();

                
            }

            // email code here



            // sms code here

            if (!empty($contactNumber)) {
                $sms = new SMS();

                $brgy = ucwords($web->brgy);

                $sms->msg = "From Brgy. {$brgy} Your Request is being processed.";
                $sms->recipient = $contactNumber;

                $response['someErr'] = $sms->send();

            }

            // sms code here

            $response['status'] = 3;
            $response['msg'] = "Request Successfully Sent.";
        }
       




        echo json_encode($response);
    }
    public static function getRequests($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $requests = Request::findAll($status, $search, $page, $limit);

        $count = Request::countAll($status, $search);

        $response = [
            'requests' => $requests,
            'datas' => $datas,
            'totalPages' => ceil($count / $limit)
        ];

        echo json_encode($response);
    }

    public static function getRequestsCount($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }
        $count = Request::countAll($status, $search);

        echo json_encode($count);
    }

    public static function getRequest($id)
    {
       $request = Request::findById($id);

       echo json_encode($request);

    }

    public static function updateRequestStatus($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        } 

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas,
        ];

        if ($status == 1 && empty($dateTimeAppointed)) {
            $response['msg'] = "Schedule of appointment is required.";
        } else {
            $request = Request::findById($id);

            $request->status = $status;

            $request->dateTimeAppointed = $dateTimeAppointed;

            $request->update();

            if ($status == 1) {
                Log::saveNewActivity("Approved", "Approved the request of " . $request->name);
                $response['msg'] = "Request Approved.";
                $stat = "Approved";
            } else if ($status == 2) {
                Log::saveNewActivity("Declined", "Declined the request of " . $request->name);
                $response['msg'] = "Request Declined.";
                $stat = "Declined";
            }

            // email code here

            if (!empty($request->email)) {
                $mailer = new Mailer();
                $mailer->recipientAddress = $request->email;

                $mailer->isHTML = true;

                $mailer->subject = "Your Certification Request.";

                if ($status == 1) {
                    $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center; padding: 1rem;"><p><b>Your Request has been '.$stat.'. and Scheduled on '.date('M d, Y h:i a', strtotime($request->dateTimeAppointed)).'</b></p> <br> <p>Thank You!!</p>';
                } else {
                    $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center; padding: 1rem;"><p><b>We are sorry to inform you but your request has been '.$stat.'.</b></p> <br> <p>Thank You!!</p>';
                }

                



                $mailer->send();

                
            }

            // email code here


 
 
            $response['status'] = 3;
        }

        echo json_encode($response);
    }

    public static function rescheduleRequest($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        } 

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas,
            'req' => null
        ];

        if (empty($dateTimeAppointed) || empty($id)) {

            $response['msg'] = "Date and time of appointment is required.";

        } else {

            $request = Request::findById($id);
            $request->dateTimeAppointed = $dateTimeAppointed;

            $certificatesArr = $request->certificate;

            $request->update();

            Log::saveNewActivity("Rescheduled", "Rescheduled the request of " . $request->name);

            // email code here

            if (!empty($request->email)) {
                $mailer = new Mailer();
                $mailer->recipientAddress = $request->email;

                $mailer->isHTML = true;

                $mailer->subject = "Your Certification Request.";


                $certificates = "";
                $certificatesAdded = 0;

                foreach($certificatesArr as $certificate)
                {
                    $certificatesAdded++;

                    if (empty($certificates)) {
                        $certificates .= $certificate;
                    } else if ($certificatesAdded >= count($certificatesArr)) {
                        $certificates .= ", and " . $certificate;
                    } else {
                        $certificates .= ", " . $certificate;
                    }

                }

               

                $mailer->body = '<div style="max-width: 300px; width: 100%; display: block; margin: auto; border: 1px solid rgba(0,0,0,.3); border-radius: 30px; text-align: center; padding: 1rem;"><p><b>Your request for '.$certificates.' has been rescheduled on '.date('M d, Y h:i a', strtotime($request->dateTimeAppointed)).'.</b></p> <br> <p>Thank You!!</p>';



                $mailer->send();

                
            }

            // email code here


            $response['msg'] = "Request Rescheduled.";
            $response['status'] = 3;
        }

        echo json_encode($response);
    }

    public static function deleteRequest($id)
    {
        $request = Request::findById($id);

        $response = [
            'msg' => "Request Deleted.",
            'status' => 3,
            'req' => $request
        ];

        $request->delete();

        $response = [
            'msg' => "Request Deleted.",
            'status' => 3,
            'req' => $request
        ];

        Log::saveNewActivity("Deleted", "Deleted the request of " . $request->name);

        echo json_encode($response);
        
    }
}