<?php 


class Payment {

    public $id;
    public $date;

    public $orNo;
    public $natureOfCollection;
    public $description;
    public $amount;
    public $citizenId;
    public $paymentType;



    // inner joins

    public $payor;


    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `payments` (`date`, `orNo`, `natureOfCollection`, `description`, `amount`, `citizenId`, `paymentType`) VALUES (?,?,?,?,?,?,?)";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ssssdis",
                $this->date,
                $this->orNo,
                $this->natureOfCollection,
                $this->description,
                $this->amount,
                $this->citizenId,
                $this->paymentType,
            );

            $stmt->execute();

            $this->id = $stmt->insert_id;

            $conn->close();
            $stmt->close();

            return true;

        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }
    public function update()
    {
        $db = new Database();

        $query = "UPDATE `payments` SET `date`=?, `orNo`=?, `natureOfCollection`=?, `description`=?, `amount`=?, `paymentType`=? WHERE id=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ssssdsi",
                $this->date,
                $this->orNo,
                $this->natureOfCollection,
                $this->description,
                $this->paymentType,
                $this->id
            );

            $stmt->execute();

            $conn->close();
            $stmt->close();

            return true;

        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    public static function findById($id)
    {
        $r = null;

        $query = "SELECT * FROM `payments` WHERE `id`=?";

        $db = new Database();


        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "i",
                $id
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                if ($rs->num_rows <= 0) {
                    $r = null;
                } else {
                    
                    $row = $rs->fetch_assoc();

                    $payment = new Payment();
                    $payment->id = $row['id'];
                    $payment->date = $row['date'];
                    $payment->orNo = $row['orNo'];
                    $payment->natureOfCollection = $row['natureOfCollection'];
                    $payment->description = nl2br($row['description']);
                    $payment->amount = $row['amount'];
                    $payment->citizenId = $row['citizenId'];
                    $payment->paymentType = $row['paymentType'];

                    $payment->payor = Citizen::findById($payment->citizenId);
                    
                    $r = $payment;
                }
            }


            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function findAll($search, $natureOfCollection, $limit, $page)
    {
        $r = null;

        $initialPage = ($page - 1) * $limit;

        $search = "%". $search . "%";
        $natureOfCollection = "%". $natureOfCollection . "%";

        $query = "SELECT p.* FROM payments p 
        INNER JOIN citizens c ON c.id = p.citizenId 
        WHERE c.name LIKE ? AND p.natureOfCollection LIKE ? 
        ORDER BY p.date DESC LIMIT ?, ?";

        $db = new Database();


        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ssii",
                $search, $natureOfCollection, $initialPage, $limit
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $payments = array();

                if ($rs->num_rows <= 0) {
                    $r = $payments;
                } else {

                    

                    while ($row = $rs->fetch_assoc()) {

                        $payment = new Payment();
                        $payment->id = $row['id'];
                        $payment->date = $row['date'];
                        $payment->orNo = $row['orNo'];
                        $payment->natureOfCollection = $row['natureOfCollection'];
                        $payment->description = $row['description'];
                        $payment->amount = $row['amount'];
                        $payment->citizenId = $row['citizenId'];
                        $payment->paymentType = $row['paymentType'];
    
                        $payment->payor = Citizen::findById($payment->citizenId);


                        array_push($payments, $payment);

                    }
                    
                    
                    $r = $payments;
                }
            }


            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function countAll($search, $natureOfCollection)
    {
        $r = null;

        $search = "%". $search . "%";
        $natureOfCollection = "%". $natureOfCollection . "%";

        $query = "SELECT p.* FROM payments p 
        INNER JOIN citizens c ON c.id = p.citizenId 
        WHERE c.name LIKE ? AND p.natureOfCollection LIKE ? 
        ORDER BY p.date DESC";

        $db = new Database();


        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ss",
                $search, $natureOfCollection
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $r = $rs->num_rows;

                
            }


            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }


}