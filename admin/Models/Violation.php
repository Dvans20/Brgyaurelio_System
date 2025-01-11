<?php 

class Violation {


    public $id;

    public $violation;

    public $description;

    // 1=pay_only 2=service_only 3=pay_or_service 4=both_pay_and_service
    public $penaltyType;

    public $payableAmount;

    public $service;

    

    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `violations` (`violation`, `description`, `penaltyType`, `payableAmount`, `service`) VALUES (?,?,?,?,?)";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ssids",
                $this->violation,
                $this->description,
                $this->penaltyType,
                $this->payableAmount,
                $this->service
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

        $query = "UPDATE `violations` SET `violation`=?, `description`=?, `penaltyType`=?, `payableAmount`=?, `service`=? WHERE `id`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "ssidsi",
                $this->violation,
                $this->description,
                $this->penaltyType,
                $this->payableAmount,
                $this->service,
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

    public function delete()
    {
        $db = new Database();

        $query = "DELETE FROM `violations` WHERE `id`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "i",
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

        $query = "SELECT * FROM `violations` WHERE `id`=?";

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

                    $violation = new Violation();

                    $violation->id = $row['id'];
                    $violation->violation = $row['violation'];
                    $violation->description = $row['description'];
                    $violation->penaltyType = $row['penaltyType'];
                    $violation->payableAmount = $row['payableAmount'];
                    $violation->service = $row['service'];
                    
                    $r = $violation;
                }
            }


            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function findAll()
    {
        $r = null;

        $query = "SELECT * FROM `violations`";

        $db = new Database();


        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $violations = array();

                if ($rs->num_rows <= 0) {
                    $r = null;
                } else {
                    
                    while($row = $rs->fetch_assoc())
                    {

                        $violation = new Violation();

                        $violation->id = $row['id'];
                        $violation->violation = $row['violation'];
                        $violation->description = $row['description'];
                        $violation->penaltyType = $row['penaltyType'];
                        $violation->payableAmount = $row['payableAmount'];
                        $violation->service = $row['service'];

                        array_push($violations, $violation);
                    }

                    
                    $r = $violations;
                }
            }


            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }




}