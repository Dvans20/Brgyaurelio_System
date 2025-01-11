<?php 


require_once "../Utilities/Database.php";
// require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "../Models/Violation.php";
require_once "../Models/Violator.php";
require_once "../Models/Citizen.php";


class ViolatorsController {
    

    public static function saveViolator($datas)
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

        if (empty($citizenId) || empty($violationId) || empty($dateOccured)) {
            $response['msg'] = "All fields are required.";
        } else if (Violator::findByV($violationId, $citizenId, $dateOccured) != null) {
            $response['msg'] = "Violation Already Exist.";
        } else {
            
            $violator = new Violator();

            $violator->citizenId = $citizenId;
            $violator->citizenship = 1;
            $violator->violationId = $violationId;
            $violator->status = 0;
            $violator->dateOccured = $dateOccured;

            $violator->save();


            Log::saveNewActivity("Added", "Added a new Violator.");

            $response['status'] = 3;
            $response['msg'] = "Violator Saved.";
        }



        echo json_encode($response);
    }


    public static function getViolators($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        
        $response = [
            'violators' => 2,
            'totalPages' => 0,
            'datas' => $datas
        ];

        $response['violators'] = Violator::findAll($search, $violation, $page, $limit);
        $response['totalPages'] = ceil(Violator::countAll($search, $violation) / $limit);


        echo json_encode($response);
    }

    public static function getViolator($id)
    {
        echo json_encode(Violator::findById($id));
    }

    public static function updateStatusViolator($datas)
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

        if (empty($status)) {
            $response['msg'] = "Check the box if the person has completed their service.";
        } else {
            $violator = Violator::findById($statusViolatorId);

            $violator->status = $status;

            $violator->update();

            $response['status'] = 3;
            $response['msg'] = "Status Updated.";
            Log::saveNewActivity("Updated", "Updated a Violator's status.");

        }

        echo json_encode($response);

    }

    public static function getViolatorsWithpay($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        
        $response = [
            'violators' => 2,
            'totalPages' => 0,
            'datas' => $datas
        ];

        $response['violators'] = Violator::findViolatorsWithpay($search, $page, $limit);
        $response['totalPages'] = ceil(Violator::countAll($search, $violation) / $limit);


        echo json_encode($response);
    }


}