<?php 

use phpDocumentor\Reflection\DocBlock\StandardTagFactory;


class Violator {


    public $id;
    public $citizenId;

    // 2=non_citizen 1=citizen
    public $citizenship;

    public $nonCitizenName;
    public $nonCitizenAddress;
    public $nonCitizenBDate;
    public $nonCitizenContactNo;
    public $nonCitizenEmail;

    public $violationId;

    // 0=no_action 1=partailly_done_payment 2=partailly_done_service 3=done 
    public $status;
    public $dateOccured;



    // join
    public $violation;
    public $citizen;


    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `violators` (`citizenId`, `citizenship`, `nonCitizenName`, `nonCitizenAddress`, `nonCitizenBDate`, `nonCitizenContactNo`, `nonCitizenEmail`, `violationId`, `status`, `dateOccured`) VALUES (?,?,?,?,?,?,?,?,?,?)";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "iisssssiis",
                $this->citizenId,
                $this->citizenship,
                $this->nonCitizenName,
                $this->nonCitizenAddress,
                $this->nonCitizenBDate,
                $this->nonCitizenContactNo,
                $this->nonCitizenEmail,
                $this->violationId,
                $this->status,
                $this->dateOccured,
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

        $query = "UPDATE `violators` SET `citizenId`=?, `citizenship`=?, `nonCitizenName`=?, `nonCitizenAddress`=?, `nonCitizenBDate`=?, `nonCitizenContactNo`=?, `nonCitizenEmail`=?, `violationId`=?, `status`=?, `dateOccured`=? WHERE `id`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "iisssssiisi",
                $this->citizenId,
                $this->citizenship,
                $this->nonCitizenName,
                $this->nonCitizenAddress,
                $this->nonCitizenBDate,
                $this->nonCitizenContactNo,
                $this->nonCitizenEmail,
                $this->violationId,
                $this->status,
                $this->dateOccured,
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

        $query = "DELETE FROM `violators` WHERE `id`=?";

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



    public static function findByViolationId($violationId)
    {
        $r = null;
        $db = new Database();

        $query = "SELECT * FROM `violators` WHERE violationId=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "i",
                $violationId
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $violators = array();

                while ($row = $rs->fetch_assoc()) {

                    $v = new Violator();

                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];
                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];
                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];
                    
                    array_push($violators, $v);

                }

                $r = $violators;
            }

           
            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function findByV($violationId, $citizenId, $dateOccured) {

        $r = null;
        $db = new Database();

        $query = "SELECT * FROM `violators` WHERE `violationId`=? AND `citizenId`=? AND `dateOccured`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "iis",
                $violationId,
                $citizenId,
                $dateOccured
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                if ($rs->num_rows <= 0) {
                    $r = null;
                } else {

                    $row = $rs->fetch_assoc();

                    $v = new Violator();
    
                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];
                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];
                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];
    
                    $r = $v;
                }


            }

           
            $conn->close();
            $stmt->close();


        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function findAll($search, $violationId, $page, $limit) 
    {

        $r = null;


        $initalPage = ($page - 1) * $limit;

        $search = "%" . $search . "%";

        if (empty($violationId)) {
            $violationOerator = "!=";
        } else {
            $violationOerator = "=";
        }


        $query = "SELECT cv.*, c.name as cname, v.violation as violation 
        FROM violators cv 
        INNER JOIN citizens c ON c.id = cv.citizenId 
        INNER JOIN violations v ON v.id = cv.violationId 
        WHERE (c.name LIKE ? OR v.violation LIKE ?) AND cv.violationId {$violationOerator} ? 
        ORDER BY cv.id DESC 
        LIMIT ?,?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssiii",
                $search,
                $search,
                $violationId,
                $initalPage,
                $limit
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $violators = array();

                while ($row = $rs->fetch_assoc()) {

                    $v = new Violator();

                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];

                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];

                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];

                    $v->citizen = Citizen::findById($row['citizenId']);
                    $v->violation = Violation::findById($row['violationId']);


                    array_push($violators, $v);

                }

                $r = $violators;
            }

            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }
        

        return $r;
    }

    public static function countAll($search, $violationId) 
    {

        $r = null;

        $search = "%" . $search . "%";

        if (empty($violationId)) {
            $violationOerator = "!=";
        } else {
            $violationOerator = "=";
        }


        $query = "SELECT cv.*, c.name as cname, v.violation as violation 
        FROM violators cv 
        INNER JOIN citizens c ON c.id = cv.citizenId 
        INNER JOIN violations v ON v.id = cv.violationId 
        WHERE (c.name LIKE ? OR v.violation LIKE ?) AND cv.violationId {$violationOerator} ? 
        ORDER BY cv.id DESC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssi",
                $search,
                $search,
                $violationId
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $r = $rs->num_rows;
            }

            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }
        

        return $r;
    }

    public static function findById($id)
    {
        $r = null;


        $query = "SELECT * FROM `violators` WHERE id=?;";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",
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

                    $v = new Violator();

                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];

                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];

                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];

                    $v->citizen = Citizen::findById($row['citizenId']);
                    $v->violation = Violation::findById($row['violationId']);


                    $r = $v;


                }
        
            }

            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }
        

        return $r;
    }

    public static function findViolatorsWithpay($search, $page, $limit)
    {
        $r = null;


        $initalPage = ($page - 1) * $limit;

        $search = "%" . $search . "%";



        $query = "SELECT cv.*, c.name as cname, v.violation as violation 
        FROM violators cv 
        INNER JOIN citizens c ON c.id = cv.citizenId 
        INNER JOIN violations v ON v.id = cv.violationId 
        WHERE (c.name LIKE ? OR v.violation LIKE ?) 
        AND (v.penaltyType = 1 OR v.penaltyType = 3 OR v.penaltyType = 4) 
        AND (cv.status = 0 OR cv.status = 2) 
        ORDER BY cv.id DESC 
        LIMIT ?,?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssii",
                $search,
                $search,
                $initalPage,
                $limit
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                $violators = array();

                while ($row = $rs->fetch_assoc()) {

                    $v = new Violator();

                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];

                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];

                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];

                    $v->citizen = Citizen::findById($row['citizenId']);
                    $v->violation = Violation::findById($row['violationId']);


                    array_push($violators, $v);

                }

                $r = $violators;
            }

            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }
        

        return $r;
    }

    public static function findActiveViolation($citizenId)
    {
        $r = null;


        $query = "SELECT * FROM `violators` WHERE citizenId=? AND `status`!=3;";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",
                $citizenId
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $rs = $stmt->get_result();

                if ($rs->num_rows <= 0) {
                    $r = null;
                } else {
                    $row = $rs->fetch_assoc();

                    $v = new Violator();

                    $v->id = $row['id'];
                    $v->citizenId = $row['citizenId'];
                    $v->citizenship = $row['citizenship'];

                    $v->nonCitizenName = $row['nonCitizenName'];
                    $v->nonCitizenAddress = $row['nonCitizenAddress'];
                    $v->nonCitizenBDate = $row['nonCitizenBDate'];
                    $v->nonCitizenContactNo = $row['nonCitizenContactNo'];
                    $v->nonCitizenEmail= $row['nonCitizenEmail'];

                    $v->violationId = $row['violationId'];
                    $v->status = $row['status'];
                    $v->dateOccured = $row['dateOccured'];

                    $v->citizen = Citizen::findById($row['citizenId']);
                    $v->violation = Violation::findById($row['violationId']);


                    $r = $v;


                }
        
            }

            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }
        

        return $r;
    }

}