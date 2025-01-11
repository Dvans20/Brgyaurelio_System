<?php 


class Citizen {
    public $id;
    public $name;
    public $lastName;
    public $firstName;
    public $middleName;
    public $extName;
    public $sex;
    public $birthDate;
    public $birthPlace;

    public $civilStatus;
    public $religion;
    public $educationalAttainment;
    public $occupation;
    public $role;

    public $isSchooling;

    public $houseHoldId;

    public $qtr;
    public $year;
    public $isHead;

    public $soloParent;
    public $pwdId;
    public $disabilityType;

    public $dateSaved;


    // inner joins 
    public $purok;
    public $houseHoldNo;
    public $status;
    public $monthlyIncome;


    public function save() {

        $return = false;

        $db = new Database();

        $query = "INSERT INTO `citizens` (`name`, `lastName`, `firstName`, `middleName`, `extName`, `sex`, `birthDate`, `birthPlace`, `civilStatus`, `religion`, `educationalAttainment`, `occupation`, `role`, `houseHoldId`, `qtr`, `year`, `isHead`, `dateSaved`, `isSchooling`, `soloParent`, `pwdId`, `disabilityType`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssisssssssiiiisiiss",
                $this->name,
                $this->lastName,
                $this->firstName,
                $this->middleName,
                $this->extName,
                $this->sex,
                $this->birthDate,
                $this->birthPlace,
                $this->civilStatus,
                $this->religion,
                $this->educationalAttainment,
                $this->occupation,
                $this->role,
                $this->houseHoldId,
                $this->qtr,
                $this->year,
                $this->isHead,
                $this->dateSaved,
                $this->isSchooling,
                $this->soloParent,
                $this->pwdId,
                $this->disabilityType
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

    public function update()
    {
        $return = false;

        $db = new Database();

        $query = "UPDATE `citizens` SET `name`=?, `lastName`=?, `firstName`=?, `middleName`=?, `extName`=?, `sex`=?, `birthDate`=?, `birthPlace`=?, `civilStatus`=?, `religion`=?, `educationalAttainment`=?, `occupation`=?, `role`=?, `houseHoldId`=?, `qtr`=?, `year`=?, `isHead`=?, `isSchooling`=?, `soloParent`=?, `pwdId`=?, `disabilityType`=? WHERE `id`=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssisssssssiiiiiissi",
                $this->name,
                $this->lastName,
                $this->firstName,
                $this->middleName,
                $this->extName,
                $this->sex,
                $this->birthDate,
                $this->birthPlace,
                $this->civilStatus,
                $this->religion,
                $this->educationalAttainment,
                $this->occupation,
                $this->role,
                $this->houseHoldId,
                $this->qtr,
                $this->year,
                $this->isHead,
                $this->isSchooling,
                $this->soloParent,
                $this->pwdId,
                $this->disabilityType,
                $this->id,
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

        $query = "DELETE FROM `citizens` WHERE id=?";

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
        $db = new Database();

        $query = "SELECT c.*, h.houseHoldNo as houseHoldNo, h.monthLyIncome,h.numFamily, h.purok as purok FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id 
        WHERE c.id=?;";

        $return = null;

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

                    $citizen = new Citizen();

                    $citizen->id = $row['id'];
                    $citizen->name = $row['name'];
                    $citizen->lastName = $row['lastName'];
                    $citizen->firstName = $row['firstName'];
                    $citizen->middleName = $row['middleName'];
                    $citizen->extName = $row['extName'];
                    $citizen->sex = $row['sex'];
                    $citizen->birthDate = $row['birthDate'];
                    $citizen->birthPlace = $row['birthPlace'];
                    $citizen->civilStatus = $row['civilStatus'];
                    $citizen->religion = $row['religion'];
                    $citizen->educationalAttainment = $row['educationalAttainment'];
                    $citizen->occupation = $row['occupation'];
                    $citizen->role = $row['role'];
                    $citizen->isSchooling = $row['isSchooling'];
                    $citizen->houseHoldId = $row['houseHoldId'];
                    $citizen->houseHoldNo = $row['houseHoldNo'];
                    $citizen->purok = $row['purok'];
                    $citizen->numFamily = $row['numFamily'];
                    $citizen->qtr = $row['qtr'];
                    $citizen->year = $row['year'];
                    $citizen->isHead = $row['isHead'];


                    $citizen->soloParent = $row['soloParent'];
                    $citizen->pwdId = $row['pwdId'];

                    $citizen->monthlyIncome = $row['monthLyIncome'];

                    if (empty($row['disabilityType'])) {
                        $citizen->disabilityType = null;
                    } else {
                        $citizen->disabilityType = unserialize($row['disabilityType']);
                    }


                    $citizen->dateSaved = $row['dateSaved'];

                    $return = $citizen;
                }
            }

            $stmt->close();
            $conn->close();
             
        } catch (Exception $e) {
            $return = $e->getMessage();
        }
        return $return;
    }

    public static function findByInfo($lastName, $firstName, $middleName, $birthDate, $civilStatus, $sex, $status, $year, $qtr, $except = 0)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id
        WHERE c.lastName=? AND c.firstName=? AND c.middleName=? AND c.birthDate=? AND c.sex=? AND h.status=? AND c.year=? AND c.qtr=? AND c.id!=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssiiiii",
                $lastName,
                $firstName,
                $middleName,
                $birthDate,
                $sex,
                $status,
                $year,
                $qtr,
                $except
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $result = null;
                } else {
                    $row = $result->fetch_assoc();

                    $citizen = new Citizen();
    
                    $citizen->id = $row['id'];
                    $citizen->name = $row['name'];
                    $citizen->lastName = $row['lastName'];
                    $citizen->firstName = $row['firstName'];
                    $citizen->middleName = $row['middleName'];
                    $citizen->extName = $row['extName'];
    
                    $citizen->sex = $row['sex'];
                    $citizen->birthDate = $row['birthDate'];
                    $citizen->birthPlace = $row['birthPlace'];
    
                    $citizen->civilStatus = $row['civilStatus'];
                    $citizen->religion = $row['religion'];
                    $citizen->educationalAttainment = $row['educationalAttainment'];
                    $citizen->occupation = $row['occupation'];
                    $citizen->role = $row['role'];
                    $citizen->isSchooling = $row['isSchooling'];
                    $citizen->houseHoldId = $row['houseHoldId'];
                    $citizen->qtr = $row['qtr'];
                    $citizen->year = $row['year'];
                    $citizen->isHead = $row['isHead'];

                    $citizen->soloParent = $row['soloParent'];
                    $citizen->pwdId = $row['pwdId'];

                    if (empty($row['disabilityType'])) {
                        $citizen->disabilityType = null;
                    } else {
                        $citizen->disabilityType = unserialize($row['disabilityType']);
                    }

                    $citizen->dateSaved = $row['dateSaved'];
    
                    $return = $citizen;
                }

                
            }
            
            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findAll($search, $purok, $status, $year, $qtr, $page, $limit)
    {

        $search = "%" . $search . "%";

        $purok = "%" . $purok . "%";

        $initialPage = ($page-1) * $limit; 

        $return = null;

        $db = new Database();

        $query = "SELECT c.*, h.houseHoldNo, h.purok, h.numFamily, h.status FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id 
        WHERE (c.name LIKE ? OR h.houseHoldNo LIKE ?) AND (h.purok LIKE ? AND h.status=? AND c.year=? AND c.qtr=?) ORDER BY c.id ASC LIMIT ?, ?";
        
        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiiiii",
                $search, $search, $purok, $status, $year, $qtr, $initialPage, $limit
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $citizens = array();

                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = $citizens;
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $citizen = new Citizen();

                        $citizen->id = $row['id'];
                        $citizen->name = $row['name'];
                        $citizen->lastName = $row['lastName'];
                        $citizen->firstName = $row['firstName'];
                        $citizen->middleName = $row['middleName'];
                        $citizen->extName = $row['extName'];
                        $citizen->sex = $row['sex'];
                        $citizen->birthDate = $row['birthDate'];
                        $citizen->birthPlace = $row['birthPlace'];
                        $citizen->civilStatus = $row['civilStatus'];
                        $citizen->religion = $row['religion'];
                        $citizen->educationalAttainment = $row['educationalAttainment'];
                        $citizen->occupation = $row['occupation'];
                        $citizen->role = $row['role'];
                        $citizen->isSchooling = $row['isSchooling'];
                        $citizen->houseHoldId = $row['houseHoldId'];
                        $citizen->qtr = $row['qtr'];
                        $citizen->year = $row['year'];
                        $citizen->isHead = $row['isHead'];

                        $citizen->soloParent = $row['soloParent'];
                        $citizen->pwdId = $row['pwdId'];

                        if (empty($row['disabilityType'])) {
                            $citizen->disabilityType = null;
                        } else {
                            $citizen->disabilityType = unserialize($row['disabilityType']);
                        }

                        
                        $citizen->dateSaved = $row['dateSaved'];

                        $citizen->purok = $row['purok'];
                        $citizen->numFamily = $row['numFamily'];
                        $citizen->houseHoldNo = $row['houseHoldNo'];

                        array_push($citizens, $citizen);
                    }

                    $return = $citizens;

                }

            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function findByHousHoldId($houseHoldId)
    {
        $return = null;

        $db = new Database();

        $query = "SELECT * FROM `citizens` WHERE `houseHoldId`=? ORDER BY id ASC";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",
                $houseHoldId
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $citizens = array();

                while ($row = $result->fetch_assoc()) {
                    $citizen = new Citizen();

                    $citizen->id = $row['id'];
                    $citizen->name = $row['name'];
                    $citizen->lastName = $row['lastName'];
                    $citizen->firstName = $row['firstName'];
                    $citizen->middleName = $row['middleName'];
                    $citizen->extName = $row['extName'];

                    $citizen->sex = $row['sex'];
                    $citizen->birthDate = $row['birthDate'];
                    $citizen->birthPlace = $row['birthPlace'];

                    $citizen->civilStatus = $row['civilStatus'];
                    $citizen->religion = $row['religion'];
                    $citizen->educationalAttainment = $row['educationalAttainment'];
                    $citizen->occupation = $row['occupation'];
                    $citizen->role = $row['role'];
                    $citizen->isSchooling = $row['isSchooling'];
                    $citizen->houseHoldId = $row['houseHoldId'];
                    $citizen->qtr = $row['qtr'];
                    $citizen->year = $row['year'];
                    $citizen->isHead = $row['isHead'];

                    $citizen->soloParent = $row['soloParent'];
                    $citizen->pwdId = $row['pwdId'];

                    if (empty($row['disabilityType'])) {
                        $citizen->disabilityType = null;
                    } else {
                        $citizen->disabilityType = unserialize($row['disabilityType']);
                    }


                    $citizen->dateSaved = $row['dateSaved'];

                    array_push($citizens, $citizen);
                }

                $return = $citizens;
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
        $search = "%" . $search . "%";

        $purok = "%" . $purok . "%";

        $return = null;

        $db = new Database();

        $query = "SELECT c.*, h.houseHoldNo, h.purok, h.status FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id 
        WHERE (c.name LIKE ? OR h.houseHoldNo LIKE ?) AND (h.purok LIKE ? AND h.status=? AND c.year=? AND c.qtr=?)";
        
        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiii",
                $search, $search, $purok, $status, $year, $qtr
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $citizens = array();

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



    public static function findByAdvanceFilter($page, $limit, $purok, $status, $year, $qtr, $soloParentFilter, $studentFilter, $srCitizenFilter, $cyFilter, $pwdFilter)
    {

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

        $purok = "%" . $purok . "%";

        if ($soloParentFilter == 1) {
            $soloParentQuery = " AND c.soloParent=1";
        } else {
            $soloParentQuery = "";
        }

        $studentQuery = "";
        if ($studentFilter != null) {

            $studentQuery .= " AND ";

            if (isExist($studentFilter, "All")) {
                $studentQuery .= "c.isSchooling=1";
            } else {
                $studentQuery .= "c.isSchooling=1 AND ("; 
                $sLevelCount = 0;
                foreach($studentFilter as $level) {
                    if ($sLevelCount++ == 0) {
                        $studentQuery .= "c.educationalAttainment LIKE '%{$level}%'";
                    } else {
                        $studentQuery .= " OR c.educationalAttainment LIKE '%{$level}%'";
                    }
                }
                $studentQuery .= ")";
            }
        }

        $pwdQuery = "";
        if ($pwdFilter != null) {

            $pwdQuery .= " AND ";

            if (isExist($pwdFilter, "All")) {
                $pwdQuery .= "c.pwdId != 0";
            } else {
                $pwdQuery .= "c.pwdId != 0 AND (";
                $pwdTypeCount = 0;
                foreach ($pwdFilter as $disabilityType) {
                    if ($pwdTypeCount++ == 0) {
                        $pwdQuery .= "c.disabilityType LIKE '%{$disabilityType}%'";
                    } else {
                        $pwdQuery .= " OR c.disabilityType LIKE '%{$disabilityType}%'";
                    }
                }
                $pwdQuery .= ")";
            }
        }

        $srCitizenQuery = "";
        if ($srCitizenFilter != null) {
            $srCitizenQuery .= " AND ";
            if (isExist($srCitizenFilter, "All")) {
                $srCitizenQuery .= "DATEDIFF(CURDATE(), c.birthDate) / 365 >= 60";
            } else {
                $srCitizenQuery .= "(";
                $srCount = 0;
                foreach ($srCitizenFilter  as $ages) {
                    $minAge = explode("-", $ages)[0];
                    $maxAge = explode("-", $ages)[1];
                    if ($srCount++ == 0) {
                        $srCitizenQuery .= "(DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    } else {
                        $srCitizenQuery .= " OR (DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    }
                }
                $srCitizenQuery .= ")";
            }
        }

        $cyQuery = "";
        if ($cyFilter != null) {
            $cyQuery .= " AND ";
            if (isExist($cyFilter, "All")) {
                $cyQuery .= "DATEDIFF(CURDATE(), c.birthDate) / 365 <= 30";
            } else {
                $cyQuery .= "(";
                $cyCount = 0;
                foreach($cyFilter as $ages) {
                    $minAge = explode("-", $ages)[0];
                    $maxAge = explode("-", $ages)[1];

                    if ($cyCount++ == 0) {
                        $cyQuery .= "(DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    } else {
                        $cyQuery .= " OR (DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    }
                }
                $cyQuery .= ")";
            }
        }
        
        
        
        

        $query = "SELECT c.*, h.houseHoldNo, h.purok,h.numFamily, h.status FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id 
        WHERE (h.purok LIKE ? AND h.status=? AND c.year=? AND c.qtr=?) {$soloParentQuery}{$studentQuery}{$pwdQuery}{$srCitizenQuery}{$cyQuery}";

        // ""

        $limitQuery = " ORDER BY c.lastName ASC LIMIT ?,?";

        $query .= $limitQuery;

        $db = new Database;

        $return = null;

        $initialPage = ($page-1) * $limit; 



        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);



            $stmt->bind_param(
                "siiiii",
                $purok,
                $status,
                $year,
                $qtr,
                $initialPage,
                $limit
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $citizens = array();

                if ($result->num_rows <= 0) {
                    $return = $citizens;
                } else {
                    while ($row = $result->fetch_assoc()) {
                        $citizen = new Citizen();
                        
                        $citizen->id = $row['id'];
                        $citizen->name = $row['name'];
                        $citizen->lastName = $row['lastName'];
                        $citizen->firstName = $row['firstName'];
                        $citizen->middleName = $row['middleName'];
                        $citizen->extName = $row['extName'];
                        $citizen->sex = $row['sex'];
                        $citizen->birthDate = $row['birthDate'];
                        $citizen->birthPlace = $row['birthPlace'];
                        $citizen->civilStatus = $row['civilStatus'];
                        $citizen->religion = $row['religion'];
                        $citizen->educationalAttainment = $row['educationalAttainment'];
                        $citizen->occupation = $row['occupation'];
                        $citizen->role = $row['role'];
                        $citizen->isSchooling = $row['isSchooling'];
                        $citizen->houseHoldId = $row['houseHoldId'];
                        $citizen->qtr = $row['qtr'];
                        $citizen->year = $row['year'];
                        $citizen->isHead = $row['isHead'];

                        $citizen->soloParent = $row['soloParent'];
                        $citizen->pwdId = $row['pwdId'];

                        if (empty($row['disabilityType'])) {
                            $citizen->disabilityType = null;
                        } else {
                            $citizen->disabilityType = unserialize($row['disabilityType']);
                        }

                        
                        $citizen->dateSaved = $row['dateSaved'];

                        $citizen->purok = $row['purok'];
                        $citizen->numFamily = $row['numFamily'];
                        $citizen->houseHoldNo = $row['houseHoldNo'];

                        array_push($citizens, $citizen);
                    }
                    $return = $citizens;
                }
            
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        // $return = $query;

        return $return;
    }

    public static function countByAdvanceFilter($purok, $status, $year, $qtr, $soloParentFilter, $studentFilter, $srCitizenFilter, $cyFilter, $pwdFilter)
    {

        

        $purok = "%" . $purok . "%";

        if ($soloParentFilter == 1) {
            $soloParentQuery = " AND c.soloParent=1";
        } else {
            $soloParentQuery = "";
        }

        $studentQuery = "";
        if ($studentFilter != null) {

            $studentQuery .= " AND ";

            if (isExist($studentFilter, "All")) {
                $studentQuery .= "c.isSchooling=1";
            } else {
                $studentQuery .= "c.isSchooling=1 AND ("; 
                $sLevelCount = 0;
                foreach($studentFilter as $level) {
                    if ($sLevelCount++ == 0) {
                        $studentQuery .= "c.educationalAttainment LIKE '%{$level}%'";
                    } else {
                        $studentQuery .= " OR c.educationalAttainment LIKE '%{$level}%'";
                    }
                }
                $studentQuery .= ")";
            }
        }

        $pwdQuery = "";
        if ($pwdFilter != null) {

            $pwdQuery .= " AND ";

            if (isExist($pwdFilter, "All")) {
                $pwdQuery .= "c.pwdId != 0";
            } else {
                $pwdQuery .= "c.pwdId != 0 AND (";
                $pwdTypeCount = 0;
                foreach ($pwdFilter as $disabilityType) {
                    if ($pwdTypeCount++ == 0) {
                        $pwdQuery .= "c.disabilityType LIKE '%{$disabilityType}%'";
                    } else {
                        $pwdQuery .= " OR c.disabilityType LIKE '%{$disabilityType}%'";
                    }
                }
                $pwdQuery .= ")";
            }
        }

        $srCitizenQuery = "";
        if ($srCitizenFilter != null) {
            $srCitizenQuery .= " AND ";
            if (isExist($srCitizenFilter, "All")) {
                $srCitizenQuery .= "DATEDIFF(CURDATE(), c.birthDate) / 365 >= 60";
            } else {
                $srCitizenQuery .= "(";
                $srCount = 0;
                foreach ($srCitizenFilter  as $ages) {
                    $minAge = explode("-", $ages)[0];
                    $maxAge = explode("-", $ages)[1];
                    if ($srCount++ == 0) {
                        $srCitizenQuery .= "(DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    } else {
                        $srCitizenQuery .= " OR (DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    }
                }
                $srCitizenQuery .= ")";
            }
        }

        $cyQuery = "";
        if ($cyFilter != null) {
            $cyQuery .= " AND ";
            if (isExist($cyFilter, "All")) {
                $cyQuery .= "DATEDIFF(CURDATE(), c.birthDate) / 365 <= 30";
            } else {
                $cyQuery .= "(";
                $cyCount = 0;
                foreach($cyFilter as $ages) {
                    $minAge = explode("-", $ages)[0];
                    $maxAge = explode("-", $ages)[1];

                    if ($cyCount++ == 0) {
                        $cyQuery .= "(DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    } else {
                        $cyQuery .= " OR (DATEDIFF(CURDATE(), c.birthDate) / 365 >= '{$minAge}' AND DATEDIFF(CURDATE(), c.birthDate) / 365 <= '{$maxAge}')";
                    }
                }
                $cyQuery .= ")";
            }
        }
        
        
        
        

        $query = "SELECT c.*, h.houseHoldNo, h.purok,h.numFamily, h.status FROM citizens c 
        INNER JOIN households h ON c.houseHoldId = h.id 
        WHERE (h.purok LIKE ? AND h.status=? AND c.year=? AND c.qtr=?) {$soloParentQuery}{$studentQuery}{$pwdQuery}{$srCitizenQuery}{$cyQuery}";

        // ""

        $limitQuery = " ORDER BY c.lastName ASC";

        $query .= $limitQuery;

        $db = new Database;

        $return = null;



        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);



            $stmt->bind_param(
                "siii",
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

        // $return = $query;

        return $return;
    }

    public static function findBySearchAndRangeYear($search, $minYear, $maxYear, $qtr1, $qtr2, $limit, $page)
    {
        $return = null;

        $search = "%" . $search . "%";

        $query = "SELECT c.*, h.houseHoldNo, h.purok,h.numFamily, h.status, h.year as `year`, h.qtr as qtr FROM citizens c 
            INNER JOIN households h ON c.houseHoldId = h.id 
            WHERE c.name LIKE ? AND ((h.year=? AND h.qtr=?) OR (h.year=? AND h.qtr=?)) ORDER BY c.lastName ASC LIMIT ?, ?";


        $db = new Database();

        $initialPage = ($page-1) * $limit; 
        try {


            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("siiiiii", $search, $minYear, $qtr1, $maxYear, $qtr2, $initialPage, $limit);


            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $citizens = array();

                while ($row = $result->fetch_assoc()) {
                    $citizen = new Citizen();
                    $citizen->id = $row['id'];
                    $citizen->name = $row['name'];
                    $citizen->lastName = $row['lastName'];
                    $citizen->firstName = $row['firstName'];
                    $citizen->middleName = $row['middleName'];
                    $citizen->extName = $row['extName'];
                    $citizen->sex = $row['sex'];
                    $citizen->birthDate = $row['birthDate'];
                    $citizen->birthPlace = $row['birthPlace'];
                    $citizen->civilStatus = $row['civilStatus'];
                    $citizen->religion = $row['religion'];
                    $citizen->educationalAttainment = $row['educationalAttainment'];
                    $citizen->occupation = $row['occupation'];
                    $citizen->role = $row['role'];
                    $citizen->isSchooling = $row['isSchooling'];
                    $citizen->houseHoldId = $row['houseHoldId'];
                    $citizen->qtr = $row['qtr'];
                    $citizen->year = $row['year'];
                    $citizen->isHead = $row['isHead'];

                    $citizen->soloParent = $row['soloParent'];
                    $citizen->pwdId = $row['pwdId'];

                    if (empty($row['disabilityType'])) {
                        $citizen->disabilityType = null;
                    } else {
                        $citizen->disabilityType = unserialize($row['disabilityType']);
                    }

                    
                    $citizen->dateSaved = $row['dateSaved'];

                    $citizen->purok = $row['purok'];
                    $citizen->numFamily = $row['numFamily'];
                    $citizen->houseHoldNo = $row['houseHoldNo'];

                    array_push($citizens, $citizen);
                }

                $return = $citizens;

            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

      return $return;
    }

    public static function countFindBySearchAndRangeYear($search, $minYear, $maxYear, $qtr1, $qtr2)
    {
        $return = null;

        $search = "%" . $search . "%";

        $query = "SELECT c.*, h.houseHoldNo, h.purok,h.numFamily, h.status, h.year as `year`, h.qtr as qtr FROM citizens c 
            INNER JOIN households h ON c.houseHoldId = h.id 
            WHERE c.name LIKE ? AND h.status=1 AND ((h.year=? AND h.qtr=?) OR (h.year=? AND h.qtr=?)) ORDER BY c.lastName ASC";


        $db = new Database();

        try {


            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("siiii", $search, $minYear, $qtr1, $maxYear, $qtr2);


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
}

