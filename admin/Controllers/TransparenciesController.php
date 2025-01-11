<?php 

require_once "../Utilities/Database.php";
require_once "../Models/Transparency.php";

require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "../Models/DocumentType.php";


class TransparenciesController {

    public static function saveNewTransparency($datas, $pdfFile)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'msg' => "",
            'status' => 2,
        ];

        if (empty($documentTitle) || empty($documentType) || empty($year) || empty($quarter) || $pdfFile['error'] != 0) {
            $response['msg'] = "All fields are required.";
        } else if (Transparency::countAll($documentTitle, $documentType, $year, $quarter) > 0) {
            $response['msg'] = "Document Already Exist.";
        } else {
            $directory = "../Media/pdf/";

            try {
                if (isset($pdfFile) && $pdfFile['error'] == 0) {
                    $fileTmpPath = $pdfFile['tmp_name'];
                    $fileName = 'transparency'.uniqid() . time() . $pdfFile['name'];
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

            $transparency = new Transparency();

            $transparency->documentTitle = $documentTitle;
            $transparency->documentType = $documentType;
            $transparency->calendarYear = $year;
            $transparency->quarter = $quarter;
            $transparency->pdfFile = $pdfFile['name'];

            $transparency->save();

            Log::saveNewActivity("Added", "Added a transparency document.");


            $response['status'] = 3;
            $response['msg'] = "Transparency Document Successfully saved.";
          
        }

        echo json_encode($response);
    }

    public static function updateTransparency($datas, $pdfFile)
    {
        foreach ($datas as $k => $v)
        {
            $$k = $v;
        }

        $response = [
            'msg' => "",
            'status' => 2,
        ];

        if (empty($documentTitle) || empty($documentType) || empty($year) || empty($quarter)) {
            $response['msg'] = "All fields are required.";
        } else if (Transparency::countAll($documentTitle, $documentType, $year, $quarter, $id) > 0) {
            $response['msg'] = "Document Already Exist.";
        } else {
            $directory = "../Media/pdf/";

            $transparency = Transparency::findById($id);


            try {
                if (isset($pdfFile) && $pdfFile['error'] == 0) {
                    $fileTmpPath = $pdfFile['tmp_name'];
                    $fileName = 'transparency'.uniqid() . time() . $pdfFile['name'];
                    $pdfFile['name'] = $fileName;
                    // $fileSize = $_FILES['pdfFile']['size'];
                    // $fileType = $_FILES['pdfFile']['type'];
                    // $fileNameCmps = explode(".", $fileName);
                    // $fileExtension = strtolower(end($fileNameCmps));

                    if (!empty($transparency->pdfFile)) {
                        if (file_exists($directory.$transparency->pdfFile)) {
                            unlink($directory.$transparency->pdfFile);
                        }
                    }
    
                    move_uploaded_file($fileTmpPath, $directory.$pdfFile['name']);

                    $transparency->pdfFile = $pdfFile['name'];

                }
            }  catch(Exception $e) {
                $response['msg'] = $e;
            }


            $transparency->documentTitle = $documentTitle;
            $transparency->documentType = $documentType;
            $transparency->calendarYear = $year;
            $transparency->quarter = $quarter;

            $transparency->update();

            Log::saveNewActivity("Updated", "Updated a transparency document.");


            $response['status'] = 3;
            $response['msg'] = "Transparency Document Successfully Updated.";
        }

        echo json_encode($response);
    }

    public static function getTransparencies($datas) 
    {
        foreach($datas as $k => $v)
        {
            $$k = $v;
        }

        $transparencies = Transparency::find($page, $limit, $search, $documentType, $calendarYear, $quarter);

        $response = [
            'transparencies' => $transparencies,
            'totalPages' => ceil(Transparency::countAll($search, $documentType, $calendarYear, $quarter) / $limit),
            'documentTypes' => DocumentType::findBySearch("")
        ];

        echo json_encode($response);
    }

    public static function getTransparency($id)
    {
        echo json_encode(Transparency::findById($id));
    }

    public static function deleteTransparency($id)
    {
        $transparency = Transparency::findById($id);

        $transparency->delete();

        $response = [
            'status' => 3,
            'msg' => "Document Successfully Deleted."
        ];

        echo json_encode($response);
    }


}