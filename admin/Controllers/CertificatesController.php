<?php 

require_once "../Utilities/Database.php";

require_once "../Models/Citizen.php";
require_once "../Models/HouseHold.php";
require_once "../Models/WebSetting.php";
require_once "../Models/RBBO.php";

class CertificatesController {


    public static function getCitizens($datas)
    {

        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $year1 = date('Y');
        $year2 = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr2 = 2;
            $qtr1 = 2;
        } else {
            $qtr2 = 4;
            $qtr1 = 4;
        } 

        if (date('m') <= 6) {
            $year1 = $year1 - 1;
            $qtr1 = 4;
        } else {
            $qtr1 = 2;
        }


        $citizens = Citizen::findBySearchAndRangeYear($search, $year1, $year2, $qtr1, $qtr2, $limit, $page);

        $count = Citizen::countFindBySearchAndRangeYear($search, $year1, $year2, $qtr1, $qtr2);

        $response = [
            'citizens' => $citizens,
            'totalPages' => ceil($count / $limit),
            'datas' => $datas
        ];

        echo json_encode($response);
    }

    public static function getCitizen($id)
    {
        $citizen = Citizen::findById($id);

        echo json_encode($citizen);
    }

    public static function getCitizenByHouseholdId($datas)
    {
        
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $citizens = Citizen::findByHousHoldId($houseHoldId);

        $response = [
            'citizens' => $citizens,
            'totalPages' => 0,
            'datas' => $datas
        ];

        echo json_encode($response);
    }

    public static function getBusinessOwners($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $year1 = date('Y');
        $year2 = date('Y');

        if (date('m') / 1 <= 6) {
            $qtr2 = 2;
            $qtr1 = 2;
        } else {
            $qtr2 = 4;
            $qtr1 = 4;
        } 

        if (date('m') <= 6) {
            $year1 = $year1 - 1;
            $qtr1 = 4;
        } else {
            $qtr1 = 2;
        }

        $rbbo = RBBO::findBySearchRange($search, $year1, $qtr1, $year2, $qtr2, $page, $limit);



        echo json_encode($rbbo);
    }

    public static function getBusinessOwner($id)
    {
        $rbbo = RBBO::findById($id);

        echo json_encode($rbbo);
    }

}