<?php 

require_once "../Utilities/Database.php";
require_once "../Models/Resolution.php";

require_once "../Models/Log.php";
require_once "../Models/User.php";


class ResolutionsController {

    public static function addNewResolution($datas, $pdfFile)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'msg' => "",
            'status' => 2,
            'datas' => $datas,
            'file' => $pdfFile,
            'stat'=> "Update"
        ];


        if (empty($resolutionTitle) || empty($resolutionNo) || empty($yearSeries) || empty($dateApproved) || empty($approvedBy) ||  $pdfFile['error'] != 0) {
            $response['msg'] = "All fields are required.";
        
        } else if (Resolution::findByNo($resolutionNo, $yearSeries, 0) != null) {
            $response['msg'] = "Resolution already Exist.";
        } else {

            $directory = "../Media/pdf/";

            try {
                if (isset($pdfFile) && $pdfFile['error'] == 0) {
                    $fileTmpPath = $pdfFile['tmp_name'];
                    $fileName = uniqid() . time() . $pdfFile['name'];
                    $pdfFile['name'] = $fileName;
                    // $fileSize = $_FILES['pdfFile']['size'];
                    // $fileType = $_FILES['pdfFile']['type'];
                    // $fileNameCmps = explode(".", $fileName);
                    // $fileExtension = strtolower(end($fileNameCmps));
    
                    move_uploaded_file($fileTmpPath, $directory.$pdfFile['name']);
                }
            }  catch(Exception $e) {
                $response['msg'] = $e;
            }

           

            $resolution = new Resolution();

            $resolution->resolutionTitle = $resolutionTitle;
            $resolution->resolutionNo = $resolutionNo;
            $resolution->description = $description;
            $resolution->yearSeries = $yearSeries;
            $resolution->dateApproved = $dateApproved;
            $resolution->approvedBy = $approvedBy;
            $resolution->authors = $authors;
            $resolution->pdfFile =  $pdfFile['name'];
            $resolution->dateTime = date('Y-m-d H:i:s');

            $resolution->save();

            $response['msg'] = "Resolution successfully Saved.";
            $response['status'] = 3;

            Log::saveNewActivity("Added", "Added a new Resolution.");
        }

        echo json_encode($response);
    }

    public static function updateResolution($datas, $pdfFile)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'msg' => "",
            'status' => 2,
            'datas' => $datas,
            'file' => $pdfFile,
            'stat'=> "Update"
        ];


        if (empty($resolutionTitle) || empty($resolutionNo) || empty($yearSeries) || empty($dateApproved) || empty($approvedBy)) {
            $response['msg'] = "All fields are required.";
        } else if (Resolution::findByNo($resolutionNo, $yearSeries, $resolutionId) != null) {
            $response['msg'] = "Resolution already Exist.";
        } else {

            $directory = "../Media/pdf/";
            $resolution = Resolution::findById($resolutionId);


            try {
                if (isset($pdfFile) && $pdfFile['error'] == 0) {
                    $fileTmpPath = $pdfFile['tmp_name'];
                    $fileName = uniqid() . time() . $pdfFile['name'];
                    $pdfFile['name'] = $fileName;
                    // $fileSize = $_FILES['pdfFile']['size'];
                    // $fileType = $_FILES['pdfFile']['type'];
                    // $fileNameCmps = explode(".", $fileName);
                    // $fileExtension = strtolower(end($fileNameCmps));
    
                    if (!empty($resolution->pdfFile)) {
                        if (file_exists($directory.$resolution->pdfFile)) {
                            unlink($directory.$resolution->pdfFile);
                        }
                    }
                    
                    $resolution->pdfFile =  $pdfFile['name'];
                    move_uploaded_file($fileTmpPath, $directory.$pdfFile['name']);
                }
            }  catch(Exception $e) {
                $response['msg'] = $e;
            }

            $resolution->resolutionTitle = $resolutionTitle;
            $resolution->resolutionNo = $resolutionNo;
            $resolution->description = $description;
            $resolution->yearSeries = $yearSeries;
            $resolution->dateApproved = $dateApproved;
            $resolution->approvedBy = $approvedBy;
            $resolution->authors = $authors;
            
            $resolution->dateTime = date('Y-m-d H:i:s');

            $resolution->update();

            $response['msg'] = "Resolution successfully Saved.";
            $response['status'] = 3;

            Log::saveNewActivity("Updated", "Updated a Resolution.");
        }

        echo json_encode($response);
    }


    public static function getResolutions($datas)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'resolutions' => Resolution::find($search, $resolutionTitle, $year, $page, $limit),
            'totalPages' => ceil(Resolution::countAll($search, $resolutionTitle, $year) / $limit),
        ];

        echo json_encode($response);
    }

    public static function getResolution($id)
    {
        echo json_encode(Resolution::findById($id));
    }

    public static function deleteResolution($id)
    {
        $response = [
            'msg' => "Resolution Deleted",
            'status' => 3,
            'stat'=> "Delete"
        ];

        $resolution = Resolution::findById($id);
        $resolution->delete();

        Log::saveNewActivity("Deleted", "Deleted a Resolution.");


        echo json_encode($response);

    }


}