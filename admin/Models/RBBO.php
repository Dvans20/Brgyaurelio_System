<?php 


class RBBO {

    public $id;
    public $purok;
    public $onwnersName;
    public $residenceAddress;
    public $businessName;
    public $category;
    public $type;
    public $contactNo;
    public $email;
    public $busNo;
    public $passKey;
    public $year;
    public $qtr;
    public $status;
    public $statusMsg;
    public $dateSaved;

    public function save ()
    {
        $this->dateSaved = date('Y-m-d H:i:s');
        $return = false;

        $query = "INSERT INTO `rbbo` (
            `purok`, `onwnersName`, `residenceAddress`, `businessName`, `category`, `type`, `contactNo`, `email`, `passKey`, `year`, `qtr`, `status`, `dateSaved`, `busNo`
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssssssiiiss", 
                $this->purok, 
                $this->onwnersName, 
                $this->residenceAddress, 
                $this->businessName, 
                $this->category,
                $this->type,
                $this->contactNo,
                $this->email,
                $this->passKey,
                $this->year,
                $this->qtr,
                $this->status,
                $this->dateSaved,
                $this->busNo
            );

            if (!$stmt->execute()) {
                $return = false;
                echo $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            echo $e->getMessage();
            $return = false;
        }

        return $return;
    }

    public function update()
    {
        $return = false;

        if (is_array($this->statusMsg)) {
            $this->statusMsg = serialize($this->statusMsg);
        }

        $query = "UPDATE `rbbo` SET `purok`=?, `onwnersName`=?, `residenceAddress`=?, `businessName`=?, `category`=?, `type`=?, `contactNo`=?, `email`=?, `busNo`=?, `passKey`=?, `year`=?, `qtr`=?, `status`=?, `statusMsg`=? WHERE `id`=?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssssssssiiisi", 
                $this->purok, 
                $this->onwnersName, 
                $this->residenceAddress, 
                $this->businessName, 
                $this->category,
                $this->type,
                $this->contactNo,
                $this->email,
                $this->busNo,
                $this->passKey,
                $this->year,
                $this->qtr,
                $this->status,
                $this->statusMsg,
                $this->id
            );

            if (!$stmt->execute()) {
                $return = false;
                echo $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            echo $e->getMessage();
            $return = false;
        }

        return $return;
    }

    public function delete()
    {
        $return = false;

        $query = "DELETE FROM `rbbo` WHERE id=?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id
            );

            if (!$stmt->execute()) {
                $return = false;
                echo $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            echo $e->getMessage();
            $return = false;
        }

        return $return;
    }

    public static function findById($id)
    {
        $return = null;

        $query = "SELECT * FROM `rbbo` WHERE id=?";

        $db = new Database();

        try {
            
            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {

                    $row = $result->fetch_assoc();

                    $rbbo = new RBBO();

                    $rbbo->id = $row['id'];
                    $rbbo->purok = $row['purok'];
                    $rbbo->onwnersName = $row['onwnersName'];
                    $rbbo->residenceAddress = $row['residenceAddress'];
                    $rbbo->businessName = $row['businessName'];
                    $rbbo->category = $row['category'];
                    $rbbo->type = $row['type'];
                    $rbbo->contactNo = $row['contactNo'];
                    $rbbo->email = $row['email'];
                    $rbbo->busNo = $row['busNo'];
                    $rbbo->passKey = $row['passKey'];
                    $rbbo->year = $row['year'];
                    $rbbo->qtr = $row['qtr'];
                    $rbbo->status = $row['status'];
                    $rbbo->statusMsg = $row['statusMsg'];
                    $rbbo->dateSaved = $row['dateSaved'];
                    
                    $return = $rbbo;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByEmail($email, $year, $qtr, $except = 0) 
    {
        $return = null;

        $query = "SELECT * FROM `rbbo` WHERE `email`=? AND `year`=? AND `qtr`=? AND id!=?";

        $db = new Database();

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siii", $email, $year, $qtr, $except);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {

                    $row = $result->fetch_assoc();

                    $rbbo = new RBBO();

                    $rbbo->id = $row['id'];
                    $rbbo->purok = $row['purok'];
                    $rbbo->onwnersName = $row['onwnersName'];
                    $rbbo->residenceAddress = $row['residenceAddress'];
                    $rbbo->businessName = $row['businessName'];
                    $rbbo->category = $row['category'];
                    $rbbo->type = $row['type'];
                    $rbbo->contactNo = $row['contactNo'];
                    $rbbo->email = $row['email'];
                    $rbbo->busNo = $row['busNo'];
                    $rbbo->passKey = $row['passKey'];
                    $rbbo->year = $row['year'];
                    $rbbo->qtr = $row['qtr'];
                    $rbbo->status = $row['status'];
                    $rbbo->statusMsg = $row['statusMsg'];
                    $rbbo->dateSaved = $row['dateSaved'];
                    
                    $return = $rbbo;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByContactNo($contactNo, $year, $qtr, $except = 0) 
    {
        $return = null;

        $query = "SELECT * FROM `rbbo` WHERE `contactNo`=? AND `year`=? AND `qtr`=? AND id!=?";

        $db = new Database();

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siii", $contactNo, $year, $qtr, $except);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {

                    $row = $result->fetch_assoc();

                    $rbbo = new RBBO();

                    $rbbo->id = $row['id'];
                    $rbbo->purok = $row['purok'];
                    $rbbo->onwnersName = $row['onwnersName'];
                    $rbbo->residenceAddress = $row['residenceAddress'];
                    $rbbo->businessName = $row['businessName'];
                    $rbbo->category = $row['category'];
                    $rbbo->type = $row['type'];
                    $rbbo->contactNo = $row['contactNo'];
                    $rbbo->email = $row['email'];
                    $rbbo->busNo = $row['busNo'];
                    $rbbo->passKey = $row['passKey'];
                    $rbbo->year = $row['year'];
                    $rbbo->qtr = $row['qtr'];
                    $rbbo->status = $row['status'];
                    $rbbo->statusMsg = $row['statusMsg'];
                    $rbbo->dateSaved = $row['dateSaved'];
                    
                    $return = $rbbo;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByKey($busNo, $passKey)
    {

        $return = null;

        $query = "SELECT * FROM `rbbo` WHERE `busNo`=? AND `passKey`=? ORDER BY `id` DESC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $busNo, $passKey);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();

                    $rbbo = new RBBO();

                    $rbbo->id = $row['id'];
                    $rbbo->purok = $row['purok'];
                    $rbbo->onwnersName = $row['onwnersName'];
                    $rbbo->residenceAddress = $row['residenceAddress'];
                    $rbbo->businessName = $row['businessName'];
                    $rbbo->category = $row['category'];
                    $rbbo->type = $row['type'];
                    $rbbo->contactNo = $row['contactNo'];
                    $rbbo->email = $row['email'];
                    $rbbo->busNo = $row['busNo'];
                    $rbbo->passKey = $row['passKey'];
                    $rbbo->year = $row['year'];
                    $rbbo->qtr = $row['qtr'];
                    $rbbo->status = $row['status'];
                    $rbbo->statusMsg = $row['statusMsg'];
                    $rbbo->dateSaved = $row['dateSaved'];
                    
                    $return = $rbbo;

                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByBusNo($busNo, $status, $year, $qtr)
    {
        $return = null;

        $query = "SELECT * FROM `rbbo` WHERE `busNo`=? AND `status`=? AND `year`=? AND `qtr`=? ORDER BY `id` DESC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("siii", $busNo, $status, $year, $qtr);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();

                    $rbbo = new RBBO();

                    $rbbo->id = $row['id'];
                    $rbbo->purok = $row['purok'];
                    $rbbo->onwnersName = $row['onwnersName'];
                    $rbbo->residenceAddress = $row['residenceAddress'];
                    $rbbo->businessName = $row['businessName'];
                    $rbbo->category = $row['category'];
                    $rbbo->type = $row['type'];
                    $rbbo->contactNo = $row['contactNo'];
                    $rbbo->email = $row['email'];
                    $rbbo->busNo = $row['busNo'];
                    $rbbo->passKey = $row['passKey'];
                    $rbbo->year = $row['year'];
                    $rbbo->qtr = $row['qtr'];
                    $rbbo->status = $row['status'];
                    $rbbo->statusMsg = $row['statusMsg'];
                    $rbbo->dateSaved = $row['dateSaved'];
                    
                    $return = $rbbo;

                }
            }

            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }


        return $return;
    }

    public static function findAll($search, $purok, $year, $qtr, $category, $type, $status, $page, $limit)
    {
        $return = null;

        $search = "%".$search."%";
        $purok = "%".$purok."%";
        $category = "%".$category."%";
        $type = "%".$type."%";

        $initialPage = ($page-1) * ($limit);

        $query = "SELECT * FROM `rbbo` WHERE (`onwnersName` LIKE ? OR `businessName` LIKE ?) 
        AND (`purok` LIKE ? AND `year`=? AND `qtr`=? AND `category` LIKE ? AND `type` LIKE ? AND `status`=?) ORDER BY `businessName` ASC LIMIT ?,?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiissiii",
                $search, $search,
                $purok, $year, $qtr, $category, $type, $status,
                $initialPage, $limit
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $rbbos = array();

                if ($result->num_rows <= 0) {
                    $return = $rbbos;
                } else {
                    while($row = $result->fetch_assoc()) {
                        $rbbo = new RBBO();

                        $rbbo->id = $row['id'];
                        $rbbo->purok = $row['purok'];
                        $rbbo->onwnersName = $row['onwnersName'];
                        $rbbo->residenceAddress = $row['residenceAddress'];
                        $rbbo->businessName = $row['businessName'];
                        $rbbo->category = $row['category'];
                        $rbbo->type = $row['type'];
                        $rbbo->contactNo = $row['contactNo'];
                        $rbbo->email = $row['email'];
                        $rbbo->busNo = $row['busNo'];
                        $rbbo->passKey = $row['passKey'];
                        $rbbo->year = $row['year'];
                        $rbbo->qtr = $row['qtr'];
                        $rbbo->status = $row['status'];
                        $rbbo->statusMsg = $row['statusMsg'];
                        $rbbo->dateSaved = $row['dateSaved'];

                        array_push($rbbos, $rbbo);
                    }
                    $return = $rbbos;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }


        return $return;
    }

    public static function findBySearchRange($search, $minYear, $minQtr, $maxYear, $maxQtr, $page, $limit)
    {
        $return = null;

        $search = "%".$search."%";

        $initialPage = ($page-1) * ($limit);

        $query = "SELECT * FROM `rbbo` WHERE (`onwnersName` LIKE ? OR `businessName` LIKE ?) AND ((`year`=? AND `qtr`=?) OR (`year`=? AND `qtr`=?)) AND `status`=1 ORDER BY `businessName` ASC LIMIT ?,?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssiiiiii",
                $search, $search,
                $minYear, $minQtr,
                $maxYear, $maxQtr,
                $initialPage, $limit
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $rbbos = array();

                if ($result->num_rows <= 0) {
                    $return = $rbbos;
                } else {
                    while($row = $result->fetch_assoc()) {
                        $rbbo = new RBBO();

                        $rbbo->id = $row['id'];
                        $rbbo->purok = $row['purok'];
                        $rbbo->onwnersName = $row['onwnersName'];
                        $rbbo->residenceAddress = $row['residenceAddress'];
                        $rbbo->businessName = $row['businessName'];
                        $rbbo->category = $row['category'];
                        $rbbo->type = $row['type'];
                        $rbbo->contactNo = $row['contactNo'];
                        $rbbo->email = $row['email'];
                        $rbbo->busNo = $row['busNo'];
                        $rbbo->passKey = $row['passKey'];
                        $rbbo->year = $row['year'];
                        $rbbo->qtr = $row['qtr'];
                        $rbbo->status = $row['status'];
                        $rbbo->statusMsg = $row['statusMsg'];
                        $rbbo->dateSaved = $row['dateSaved'];

                        array_push($rbbos, $rbbo);
                    }
                    $return = $rbbos;
                }

            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function countAll($search, $purok, $year, $qtr, $category, $type, $status)
    {
        $return = null;

        $search = "%".$search."%";
        $purok = "%".$purok."%";
        $category = "%".$category."%";
        $type = "%".$type."%";

        $query = "SELECT * FROM `rbbo` WHERE (`onwnersName` LIKE ? OR `businessName` LIKE ?) 
        AND (`purok` LIKE ? AND `year`=? AND `qtr`=? AND `category` LIKE ? AND `type` LIKE ? AND `status`=?) ORDER BY `businessName` ASC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiissi",
                $search, $search,
                $purok, $year, $qtr, $category, $type, $status
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $return = $result->num_rows;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }


        return $return;
    }

    public static function generateNo()
    {
        $return = null;

        $db = new Database();

        $query = "SELECT MAX(busNo) AS busNo FROM `rbbo`";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $row = $result->fetch_assoc();

                

                if ($row['busNo'] == null) {
                    $return = "0001";
                } else {
                    $number = ($row['busNo'] / 1) + 1;
                    $return = sprintf('%04d', $number);
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }
    
}