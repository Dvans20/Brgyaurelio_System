
<?php 

require_once "../Utilities/Database.php";
// require_once "../Models/WebSetting.php";
require_once "../Models/Log.php";
require_once "../Models/User.php";
require_once "../Models/Violation.php";
require_once "../Models/Violator.php";
require_once "../Models/Citizen.php";
require_once "../Models/Payment.php";

class  PaymentsController {

 
  public static function newPayment($datas)
{
    foreach ($datas as $k => $v) {
        $$k = $v;
    }

    $response = [
        'status' => 2,
        'msg' => "",
        'datas' => $datas
    ];

    if (empty($natureOfCollection) || empty($description) || empty($citizenId) || empty($orNo) || empty($date) || empty($amount) || empty($paymentType)) {
        $response['msg'] = "All fields are required.";
    } else if ($natureOfCollection == 99 && empty($natureOfCollectionIn)) {
        $response['msg'] = "All fields are required.";
    } else if ($natureOfCollection != 2 && Violator::findActiveViolation($citizenId) != null) {
        $response['msg'] = "This citizen currently has an unsettled violation.";
    } else {
        switch ($natureOfCollection) {
            case 1:
                $natureOfCollection = "Cedula";
                break;
            case 2:
                $natureOfCollection = "Penalty";

                // Process multiple violatorIds if provided
                if (!empty($violatorId)) {
                    $violatorIds = explode(',', $violatorId);  // Split concatenated violatorIds by comma

                    foreach ($violatorIds as $violatorId) {
                        $violator = Violator::findById($violatorId);

                        if ($violator && $violator->violation) {
                            // Check and update violator status based on penalty type
                            if ($violator->violation->penaltyType == 1 || $violator->violation->penaltyType == 3) {
                                $violator->status = 3;
                            } else if ($violator->violation->penaltyType == 4) {
                                $violator->status = ($violator->status == 0) ? 1 : 3;
                            }

                            $violator->update();  // Save updated violator status
                        }
                    }
                }

                break;
            case 3:
                $natureOfCollection = "Certification";
                break;
            case 4:
                $natureOfCollection = "Brgy. Clearance";
                break;
            case 5:
                $natureOfCollection = "Brgy. Clearance for Businesses";
                break;
            case 99:
                $natureOfCollection = $natureOfCollectionIn;
                break;
        }

        // Create a new payment entry
        $payment = new Payment();
        $payment->date = $date;
        $payment->orNo = $orNo;
        $payment->natureOfCollection = $natureOfCollection;
        $payment->description = $description;
        $payment->amount = $amount;
        $payment->citizenId = $citizenId;
        $payment->paymentType = $paymentType;
        $payment->save();

        $response['status'] = 3;
        $response['msg'] = "Payment Saved.";

        Log::saveNewActivity("Saved", "Saved new Payment.");
    }

    echo json_encode($response);
}


    public static function gePayments($datas)
    {
        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        
        $payments = Payment::findAll($search, $natureOfCollection, $limit, $page);

        $count = Payment::countAll($search, $natureOfCollection);

        $response = [
            'payments' => $payments,
            'totalPages' => ceil($count / $limit)
        ];

        echo json_encode($response);
    }

    public static function gePayment($id)
    {
        echo json_encode(Payment::findById($id));
    }

}