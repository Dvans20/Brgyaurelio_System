<?php 


require_once "../Utilities/Database.php";
require_once "../Models/Log.php";


class LogsController {

    

    public static function get($datas)
    {
        foreach($datas as $k=>$v) {
            $$k = $v;
        }

    

        $logs = Log::findAll($page, $limit, $search, $dateTimeFrom, $dateTimeTo);


        $response = [
            'logs' => $logs,
            'totalPages' => ceil(Log::countAll($search, $dateTimeFrom, $dateTimeTo) / $limit)
        ];

        echo json_encode($response);
        
    }

}