<?php 

require_once "../Utilities/Database.php";
require_once "../Models/Complain.php";

require_once "../Models/User.php";
require_once "../Models/Log.php";
require_once "../Models/Mailer.php";
require_once "../Models/WebSetting.php";

class ComplaintsController {


    public static function newComplaints($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        if (empty($complainants) || (empty($defendants) || empty($complaints)) || empty($dateFiled)) {
            $response['msg'] = "All fields are required.";
        } else {
            $complain = new Complain();
            $complain->complainants = serialize($complainants);
            $complain->defendants = serialize($defendants);
            $complain->dateFiled = $dateFiled;
            $complain->complaints = $complaints;
            $complain->status = "Case Pending";
            $complain->hearingSchedule = $hearingSchedule;

            $complain->save();

            $response['status'] = 3;
            $response['msg'] = "Complain Saved.";
        }

        echo json_encode($response);
    }

    public static function getComplaints($datas)
    {   
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $complaints = Complain::findAll($page, $limit, $search, $status);

        $count = Complain::countAll($search, $status);

        $response = [
            'complaints' => $complaints,
            'totalPages' => ceil($count / $limit),
            'datas' => $datas,
            'dateTimeNow' => date('Y-m-d H:i:s')
        ];

        echo json_encode($response);
    }

    public static function getComplaint($id)
    {
        echo json_encode(Complain::findById($id));
    }

    public static function setScheduleComplaints($datas)
    {
        
        date_default_timezone_set("Asia/Manila");
        $web = WebSetting::get();

        foreach ($datas as $k => $v) {
            $$k = $v;
        }
        
        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        if (empty($schedule) || empty($id)) {
            $response['msg'] = "Schedule date and time is required.";
        } else if (strtotime($schedule) <= strtotime(date('Y-m-d H:i:s'))) {
            $response['msg'] = "Invalid Schedule.";
        } else {
            $complain = Complain::findById($id);
            $complain->hearingSchedule = $schedule;

            $complain->update();


            Log::saveNewActivity("Updated", "Updated a Complaint Schedule.");
            $response['msg'] = "Schedule successfully set";
            $response['status'] = 3;
        }

        echo json_encode($response);
    }

    public static function setStatusComplaints($datas)
    {
        date_default_timezone_set("Asia/Manila");

        foreach ($datas as $k => $v) {
            $$k = $v;
        }
        
        $response = [
            'status' => 2,
            'msg' => "",
            'datas' => $datas
        ];

        if (empty($status) || empty($id)) {
            $response['msg'] = "Status is required.";
        } else {
            $complain = Complain::findById($id);
            $complain->status = $status;

            $complain->update();

            Log::saveNewActivity("Updated", "Updated a Complaint Status.");
            $response['msg'] = "Status successfully updated";
            $response['status'] = 3;
        }

        echo json_encode($response);
    }
}