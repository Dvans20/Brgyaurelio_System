<?php 

class Complain {


    public $id;
    public $complainants;
    public $defendants;
    public $complaints;
    public $dateFiled;
    public $hearingSchedule;
    public $status;
    public $dateTime;
    
    public function save()
    {
        $return = false;

        if (is_array($this->defendants)) {
            $this->defendants = serialize($this->defendants);
        }

        if (is_array($this->complainants)) {
            $this->complainants = serialize($this->complainants);
        }

        $query = "INSERT INTO `complaints` (`complainants`, `defendants`, `complaints`, `dateFiled`, `hearingSchedule`, `status`, `dateTime`) VALUES (?,?,?,?,?,?,?);";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssss", 
                $this->complainants, 
                $this->defendants, 
                $this->complaints, 
                $this->dateFiled,
                $this->hearingSchedule,
                $this->status,
                $this->dateTime,
            );

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $return = true;

                $this->id = $stmt->insert_id;
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

        
        if (is_array($this->defendants)) {
            $this->defendants = serialize($this->defendants);
        }

        if (is_array($this->complainants)) {
            $this->complainants = serialize($this->complainants);
        }

        $query = "UPDATE `complaints` SET `complainants`=?, `defendants`=?, `complaints`=?, `dateFiled`=?, `hearingSchedule`=?, `status`=? WHERE id=?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssssi", 
                $this->complainants, 
                $this->defendants, 
                $this->complaints, 
                $this->dateFiled, 
                $this->hearingSchedule, 
                $this->status,
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

    public static function findById($id)
    {
        $return = null;

        $query = "SELECT * FROM `complaints` WHERE id=?";

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

                    $complain = new Complain();

                    $complain->id = $row['id'];
                    $complain->complainants = unserialize($row['complainants']);
                    $complain->defendants = unserialize($row['defendants']);
                    $complain->complaints = nl2br($row['complaints']);
                    $complain->dateFiled = $row['dateFiled'];
                    $complain->hearingSchedule = $row['hearingSchedule'];
                    $complain->status = $row['status'];
                    $complain->dateTime = $row['dateTime'];

                    $return = $complain;
                }
            }


            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }


        return $return;
    }

    public static function findAll($page, $limit, $search, $status)
    {

        $return = null;


        // $hearingScheduleQuery = "";

        $search = "%" . $search . "%";
        $status = "%" . $status . "%";
        $initialPage = ($page-1) * $limit; 

        $query = "SELECT * FROM `complaints` WHERE `status` LIKE ? AND (complainants LIKE ? OR defendants LIKE ?) ORDER BY `id` DESC LIMIT ?, ?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssii", $status, $search, $search, $initialPage, $limit);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $complaints = array();

                if ($result->num_rows <= 0) {
                    $return = $complaints;
                } else {

                    while ($row = $result->fetch_assoc()) {
                        $complain = new Complain();

                        $complain->id = $row['id'];
                        $complain->complainants = unserialize($row['complainants']);
                        $complain->defendants = unserialize($row['defendants']);
                        $complain->complaints = nl2br($row['complaints']);
                        $complain->dateFiled = $row['dateFiled'];
                        $complain->hearingSchedule = $row['hearingSchedule'];
                        $complain->status = $row['status'];
                        $complain->dateTime = $row['dateTime'];
    
    
                        array_push($complaints, $complain);
                    }

                    $return = $complaints;
                }
            }


            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        // $return = $hearingSchedule;

        return $return;
    }

    public static function countAll($search, $status)
    {

        $return = null;

        $search = "%" . $search . "%";
        $status = "%" . $status . "%";

        $query = "SELECT * FROM `complaints` WHERE `status` LIKE ? AND (complainants LIKE ? OR defendants LIKE ?) ORDER BY `id` DESC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sss", $status, $search, $search);

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