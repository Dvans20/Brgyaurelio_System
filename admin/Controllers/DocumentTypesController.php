<?php 


require_once "../Utilities/Database.php";
require_once "../Models/DocumentType.php";
require_once "../Models/Transparency.php";

require_once "../Models/Log.php";
require_once "../Models/User.php";

class DocumentTypesController {

    public static function newDocumentType($name)
    {
        $response = [
            'status' => 2,
            'msg' => ""
        ];

        if (empty($name)) {
            $response['msg'] = "Name of Document Type is required.";
        } else if (DocumentType::findByName($name)) {
            $response['msg'] = "Name of Document Type already Exist.";
        } else {
            $documentType = new DocumentType();
            $documentType->name = $name;
            $documentType->save();


            Log::saveNewActivity("Added", "Added a new document type.");


            $response['status'] = 3;
            $response['msg'] = "Document Type successfully saved.";

        }

        echo json_encode($response);
    }

    public static function updateDocumentType($id, $name)
    {
        $response = [
            'status' => 2,
            'msg' => ""
        ];

        if (empty($name)) {
            $response['msg'] = "Name of Document Type is required.";
        } else if (DocumentType::findByName($name, $id)) {
            $response['msg'] = "Name of Document Type already Exist.";
        } else {
            
            $documentType = DocumentType::findById($id);
            $documentType->name = $name;
            $documentType->update();


            Log::saveNewActivity("Updated", "Updated a document type.");


            $response['status'] = 3;
            $response['msg'] = "Document Type successfully updated.";

        }

        echo json_encode($response);
    }

    public static function getDocumentTypes($search)
    {
        $documentTypes = DocumentType::findBySearch($search);

        
        echo json_encode($documentTypes);
    }

    public static function deleteDocumentType($id)
    {
        $response = [
            'status' => 2,
            'msg' => ""
        ];

        if (Transparency::countAll("", $id, "", "") > 0) {
            $response['msg'] = "This Document Type is in use. Please update the document's with this document type before deleting it.";
        } else {
            $documentType = DocumentType::findById($id);

            $documentType->delete();

            $response['status'] = 3;
            $response['msg'] = "Documemt Type Deleted.";
        }

        echo json_encode($response);
    }
}