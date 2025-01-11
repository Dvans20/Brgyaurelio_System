<?php 

require_once "../Utilities/Database.php";
// require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "../Models/Violation.php";
require_once "../Models/Violator.php";

class ViolationsController {


    public static function saveViolation($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];


        if (empty($violation) || empty($description) || empty($penaltyType)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 1 && empty($payableAmount)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 1 && empty($payableAmount)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 2 && empty($service)) {
            $response['msg'] = "All fields are required.";
        } else if (($penaltyType == 3 || $penaltyType == 4) && (empty($service) || empty($payableAmount))) {
            $response['msg'] = "All fields are required.";
        } else if (($penaltyType == 1 || $penaltyType == 3 || $penaltyType == 4) && !is_numeric($payableAmount)) {
            $response['msg'] = "Invalid Payable Amount.";
        } else {

            $v = new Violation();

            $v->violation = $violation;
            $v->description = $description;
            $v->penaltyType = $penaltyType;
            $v->payableAmount = $payableAmount;
            $v->service = $service;


            $v->save();


            Log::saveNewActivity("Added", "Added a violation.");




            $response['status'] = 3;
            $response['msg'] = "Violation Saved.";
        }


        echo json_encode($response);
    }

    public static function updateViolation($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];


        if (empty($violation) || empty($description) || empty($penaltyType)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 1 && empty($payableAmount)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 1 && empty($payableAmount)) {
            $response['msg'] = "All fields are required.";
        } else if ($penaltyType == 2 && empty($service)) {
            $response['msg'] = "All fields are required.";
        } else if (($penaltyType == 3 || $penaltyType == 4) && (empty($service) || empty($payableAmount))) {
            $response['msg'] = "All fields are required.";
        } else if (($penaltyType == 1 || $penaltyType == 3 || $penaltyType == 4) && !is_numeric($payableAmount)) {
            $response['msg'] = "Invalid Payable Amount.";
        } else {

            $v = Violation::findById($id);

            $v->violation = $violation;
            $v->description = $description;
            $v->penaltyType = $penaltyType;
            $v->payableAmount = $payableAmount;
            $v->service = $service;


            $v->update();


            Log::saveNewActivity("Updated", "Updated a violation.");




            $response['status'] = 3;
            $response['msg'] = "Violation Updated.";
        }


        echo json_encode($response);
    }

    public static function getViolations ()
    {
        echo json_encode(Violation::findAll());
    }

    public static function getViolation($id)
    {
        echo json_encode(Violation::findById($id));
        
    }

    public static function deleteViolation($id)
    {
        $violators = Violator::findByViolationId($id);

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        if (count($violators) >= 1) {
            $response['msg'] = "Violation Already in use.";
        } else {
            $violation = Violation::findById($id);
            $violation->delete();

            $response['status'] =3;
            $response['msg'] = "Violation Deleted.";

            Log::saveNewActivity("Deleted", "Deleted a violation.");

        }

        echo json_encode($response);
    }
}