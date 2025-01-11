<?php 


class HouseHold {
    public $id;

    public $purok;
    public $houseOwnershipStatus;
    public $electricity;
    public $waterSources;
    public $sanitaryToilet;
    public $contactNo;
    public $email;
    public $monthLyIncome;
    public $houseHoldKey;
    public $houseHoldNo;

    public $year;
    public $qtr;

    public $status;
    public $statusMsg;
    public $dateSaved;

    public $familyMembers;

    

    public function save()
    {
        $db = new Database();
ini_set('display_errors', 1);
error_reporting(E_ALL);
        $query = "INSERT INTO `households` (`purok`, `houseOwnershipStatus`, `electricity`, `waterSources`, `sanitaryToilet`, `contactNo`, `email`, `monthLyIncome`, `houseHoldKey`, `houseHoldNo`, `year`, `qtr`, `status`,`numFamily`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        
        $return = false;

        try  {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siisisssssiiii",
                $this->purok,
                $this->houseOwnershipStatus,
                $this->electricity,
                $this->waterSources,
                $this->sanitaryToilet,
                $this->contactNo,
                $this->email,
                $this->monthLyIncome,
                $this->houseHoldKey,
                $this->houseHoldNo,
                $this->year,
                $this->qtr,
                $this->status,
                $this->numFamily
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $this->id = $stmt->insert_id;
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public function update()
    {
        $db = new Database();

        $query = "UPDATE `households` SET `purok`=?, `houseOwnershipStatus`=?, `electricity`=?, `waterSources`=?, `sanitaryToilet`=?, `contactNo`=?, `email`=?, `monthLyIncome`=?, `houseHoldKey`=?, `houseHoldNo`=?, `year`=?, `qtr`=?, `status`=?, `statusMsg`=? WHERE id=?";
        
        $return = false;

        if (is_array($this->waterSources)) {
            $this->waterSources = serialize($this->waterSources);
        }

        if (is_array($this->statusMsg)) {
            $this->statusMsg = serialize($this->statusMsg);
        }

        try  {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siisisssssiiisi",
                $this->purok,
                $this->houseOwnershipStatus,
                $this->electricity,
                $this->waterSources,
                $this->sanitaryToilet,
                $this->contactNo,
                $this->email,
                $this->monthLyIncome,
                $this->houseHoldKey,
                $this->houseHoldNo,
                $this->year,
                $this->qtr,
                $this->status,
                $this->statusMsg,
                $this->id
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public function delete()
    {
        $return = false;

        $db = new Database();

        $query = "DELETE FROM `households` WHERE id=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findById($id)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM `households` WHERE id=?;";

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
                    
                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = unserialize($row['waterSources']);
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->houseHoldKey = $row['houseHoldKey'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->status = $row['status'];
                    $houseHold->statusMsg = $row['statusMsg'];
                    $houseHold->dateSaved = $row['dateSaved'];

                    $houseHold->familyMembers = Citizen::findByHousHoldId($houseHold->id);

                    $return = $houseHold;
                }
            }

            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByHouseholdNo($householdNo, $status, $year, $qtr) 
    {
        $return = null;

        $householdNo /= 1;

        $db = new Database();

        $query = "SELECT * FROM households WHERE CAST(`houseHoldNo` AS INT) = ? AND `status`=? AND `year`=? AND `qtr`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("iiii", $householdNo, $status, $year, $qtr);
            

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();
                    
                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = unserialize($row['waterSources']);
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->houseHoldKey = $row['houseHoldKey'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->status = $row['status'];
                    $houseHold->statusMsg = $row['statusMsg'];
                    $houseHold->dateSaved = $row['dateSaved'];

                    $houseHold->familyMembers = Citizen::findByHousHoldId($houseHold->id);

                    $return = $houseHold;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByEmail($email, $year, $qtr)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM `households` WHERE `email`=? AND `year`=? AND `qtr`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sii", $email, $year, $qtr);

            if (!$stmt->execute()) {
                $return = $stmt->error; 
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();
                    
                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = $row['waterSources'];
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldKey = $row['houseHoldKey'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->dateSaved = $row['status'];
                    $houseHold->status = $row['dateSaved'];
                    $houseHold->statusMsg = $row['statusMsg'];

                    $return = $houseHold;
                }
            }

            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByContactNo($contactNo, $year, $qtr)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM `households` WHERE `contactNo`=? AND `year`=? AND `qtr`=?;";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sii", $contactNo, $year, $qtr);

            if (!$stmt->execute()) {
                $return = $stmt->error; 
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();
                    
                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = $row['waterSources'];
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldKey = $row['houseHoldKey'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->dateSaved = $row['status'];
                    $houseHold->statusMsg = $row['statusMsg'];
                    $houseHold->status = $row['dateSaved'];

                    $return = $houseHold;
                }
            }

            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findAll($search, $purok, $houseOwnershipStatus, $electricity, $sanitaryToilet, $monthLyIncome, $status, $year, $qtr, $page, $limit)
    {
        $return = null;

        $db = new Database();

        $search = "%" . $search . "%";
        $purok = "%" . $purok . "%";

        $initialPage = ($page-1) * $limit; 

        if ($houseOwnershipStatus == 1) {
            $houseOwnershipStatus = 2;
        } else if ($houseOwnershipStatus == 2) {
            $houseOwnershipStatus = 1;
        } else {
            $houseOwnershipStatus = 0;
        }

        if ($electricity == 1) {
            $electricity = 2;
        } else if ($electricity == 2) {
            $electricity = 1;
        } else {
            $electricity = 0;
        }

        if ($sanitaryToilet == 1) {
            $sanitaryToilet = 2;
        } else if ($sanitaryToilet == 2) {
            $sanitaryToilet = 1;
        } else {
            $sanitaryToilet = 0;
        }

        $leastIncome = explode("-", $monthLyIncome)[0];
        $greaterIncome = explode("-", $monthLyIncome)[1];

        $query = "SELECT h.*, c.name FROM households h 
        INNER JOIN citizens c ON c.houseHoldId = h.id AND c.isHead = 1 
        WHERE (c.name LIKE ? OR h.houseHoldNo LIKE ?) AND (h.purok LIKE ? AND h.status=? AND h.year=? AND h.qtr=? AND h.houseOwnershipStatus!=? AND h.electricity!=? AND h.sanitaryToilet!=? AND h.monthLyIncome >=? AND h.monthLyIncome<?) 
        ORDER BY h.id ASC LIMIT ?, ?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiiiiiiiiii",
                $search,
                $search,
                $purok,
                $status,
                $year,
                $qtr,
                $houseOwnershipStatus,
                $electricity,
                $sanitaryToilet,
                $leastIncome,
                $greaterIncome,
                $initialPage,
                $limit
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $houseHolds = array();

                while($row = $result->fetch_assoc()) {
                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = unserialize($row['waterSources']);
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->status = $row['status'];
                    $houseHold->statusMsg = $row['statusMsg'];
                    $houseHold->dateSaved = $row['dateSaved'];

                    $houseHold->familyMembers = Citizen::findByHousHoldId($houseHold->id);

                    array_push($houseHolds, $houseHold);
                }

                $return = $houseHolds;
            }


            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }


        return $return;
    }

    public static function countAll($search, $purok, $status, $year, $qtr)
    {
        $return = null;

        $db = new Database();

        $search = "%" . $search . "%";
        $purok = "%" . $purok . "%";

        $query = "SELECT h.*, c.name FROM households h 
        INNER JOIN citizens c ON c.houseHoldId = h.id AND c.isHead = 1 
        WHERE (c.name LIKE ? OR h.houseHoldNo LIKE ?) AND (h.purok LIKE ? AND h.status=? AND h.year=? AND h.qtr=?) 
        ORDER BY h.id ASC";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiii",
                $search,
                $search,
                $purok,
                $status,
                $year,
                $qtr
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

        $query = "SELECT MAX(houseHoldNo) AS householdNo FROM `households`";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $row = $result->fetch_assoc();

                

                if ($row['householdNo'] == null) {
                    $return = "0001";
                } else {
                    $number = ($row['householdNo'] / 1) + 1;
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

    public static function findByHouseholdKey($householdNo, $householdKey)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM `households` WHERE `houseHoldNo`=? AND `houseHoldKey`=? ORDER BY `id` DESC;";

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $householdNo, $householdKey);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();

                    $houseHold = new HouseHold();

                    $houseHold->id = $row['id'];
                    $houseHold->purok = $row['purok'];
                    $houseHold->numFamily = $row['numFamily'];
                    $houseHold->houseOwnershipStatus = $row['houseOwnershipStatus'];
                    $houseHold->electricity = $row['electricity'];
                    $houseHold->waterSources = unserialize($row['waterSources']);
                    $houseHold->sanitaryToilet = $row['sanitaryToilet'];
                    $houseHold->contactNo = $row['contactNo'];
                    $houseHold->email = $row['email'];
                    $houseHold->monthLyIncome = $row['monthLyIncome'];
                    $houseHold->houseHoldNo = $row['houseHoldNo'];
                    $houseHold->houseHoldKey = $row['houseHoldKey'];
                    $houseHold->year = $row['year'];
                    $houseHold->qtr = $row['qtr'];
                    $houseHold->status = $row['status'];
                    $houseHold->statusMsg = $row['statusMsg'];
                    $houseHold->dateSaved = $row['dateSaved'];

                    $houseHold->familyMembers = Citizen::findByHousHoldId($houseHold->id);

                    $return = $houseHold;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {

        }

        return $return;
    }
}