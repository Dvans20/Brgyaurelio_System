<?php 


require_once "../Utilities/Database.php";
require_once "../Models/HouseHold.php";
require_once "../Models/Citizen.php";
require_once "../Models/WebSetting.php";

class AppController {

    public static function isExist($array, $value) {
        $isExist = false;

        foreach ($array as $val) {
            if ($val == $value) {
                $isExist = true;
                break;
            }
        }

        return $isExist;
    }

    public static function getPopulations($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        $citizens = Citizen::countAll("", "", 1, $year, $qtr);
        $households = HouseHold::countAll("", "", 1, $year, $qtr);

        $response = [
            'citizens' => $citizens,
            'households' => $households,
            'datas' => $datas
        ];
        
        echo json_encode($response);

    }

    public static function getPopulationsByPurok($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }
        
        $chartColors = [
            "rgba(150,170,180, .6)",
            "#dc3545",
            "#0d6efd",
            "#00aba9",
            '#714e92',
            '#c9cc8f',
            '#98930a',
            '#59b02f',
            '590046',
            '#b54131',
            '#c76218',
            '#d46c4f',
            '#162790',
            '#de4d52',
            '#1dc932',
            '#fd7c0d',
            '#6506dd',
            "#20c997",
            "#fd7e14",
            "#198754",
            "#495057",
            '#6f594b',
            '#c657da',
            '#1d8857',
        ];

        function isExist($array, $value)  {
            $isExist = false;

            if (is_array($array)) {

                foreach ($array as $val) {
                    if ($val == $value) {
                        $isExist = true;
                        break;
                    }
                }

            } 
            return $isExist;
        }

        $web = WebSetting::get();

        $labels  = $web->puroks;
        $dataSets = array();

        $dataSetPwd = [
            'label' => 'PWD',
            'data' => array(),
            'backgroundColor' => $chartColors[2],
            'stack' => 'Stack 4',
        ];
        $dataSetchild = [
            'label' => 'Children',
            'data' => array(),
            'backgroundColor' => 'orange',
            'stack' => 'Stack 1',
        ];
        $dataSetSp = [
            'label' => 'Solo Parent',
            'data' => array(),
            'backgroundColor' => $chartColors[3],
            'stack' => 'Stack 2',
        ];
        $dataSetSc = [
            'label' => 'Senior Citizen',
            'data' => array(),
            'backgroundColor' => $chartColors[4],
            'stack' => 'Stack 3',
        ];
        $dataSetAll = [
            'label' => 'Population',
            'data' => array(),
            'backgroundColor' => $chartColors[0],
            'grouped' => false,
        ];
        foreach ($labels as $label) {
            $pwds = Citizen::countByAdvanceFilter($label, 1, $year, $qtr, "", null, null, null, ['All'],null);

            array_push($dataSetPwd['data'], $pwds);

            $child = Citizen::countByAdvanceFilter($label, 1, $year, $qtr, "", null, null, null, null,['All']);

            array_push($dataSetchild['data'], $child);

            $sp = Citizen::countByAdvanceFilter($label, 1, $year, $qtr, 1, null, null, null, null,null);

            array_push($dataSetSp['data'], $sp);

            $sc = Citizen::countByAdvanceFilter($label, 1, $year, $qtr, "", null, ['All'], null, null,null);

            array_push($dataSetSc['data'], $sc);

            $all = Citizen::countAll("", $label, 1, $year, $qtr);
            array_push($dataSetAll['data'], $all);
        }

        array_push($dataSets, $dataSetPwd);
        array_push($dataSets, $dataSetchild);
        array_push($dataSets, $dataSetSp);
        array_push($dataSets, $dataSetSc);
        array_push($dataSets, $dataSetAll);



        $response = [
            'labels' => $labels,
            'datasets' => $dataSets
        ];

        echo json_encode($response);
    }
}