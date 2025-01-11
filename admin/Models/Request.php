<?php 




class Request {
    public $id;
    public $name;
    public $email;
    public $contactNumber;
    public $address;
    public $certificate;
    public $reptMethod;
    public $description;
    public $status;
    public $dateTimeAppointed;
    public $dateTimeRequested;

    public function save()
    {
        date_default_timezone_set("Asia/Manila");

        $db = new Database();

        $this->dateTimeRequested = date('Y-m-d H:i:s');

        $query = "INSERT INTO `requests` (`name`, `email`, `contactNumber`, `address`, `certificate`, `reptMethod`, `description`, `dateTimeRequested`) VALUES (?,?,?,?,?,?,?,?);";

        $r = false;

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssssss",
                $this->name,
                $this->email,
                $this->contactNumber,
                $this->address,
                $this->certificate,
                $this->reptMethod,
                $this->description,
                $this->dateTimeRequested
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $this->id = $stmt->insert_id;
                $r = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

    public function update()
    {
        date_default_timezone_set("Asia/Manila");

        $db = new Database();

        if (is_array($this->certificate)) {
            $this->certificate = serialize($this->certificate);
        }

      
        $query = "UPDATE `requests` SET `name`=?, `email`=?, `contactNumber`=?,  `address`=?, `certificate`=?, `reptMethod`=?, `description`=?, `status`=?, `dateTimeAppointed`=? WHERE `id`=?;";

        $r = false;

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssssisi",
                $this->name,
                $this->email,
                $this->contactNumber,
                $this->address,
                $this->certificate,
                $this->reptMethod,
                $this->description,
                $this->status,
                $this->dateTimeAppointed,
                $this->id
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $this->id = $stmt->insert_id;
                $r = true;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

    public function delete()
    {
        $r = false;

        $query = "DELETE FROM `requests` WHERE id=?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            if (!$stmt->execute()){
                $r = $stmt->error;
            } else {
                $r = true;
            }

            $conn->close();
            $stmt->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }


        return $r;
    }

    public static function findById($id)
    {
        $r = null;

        $query = "SELECT * FROM `requests` WHERE id=?;";

        $db =  new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $result = $stmt ->get_result();

                $row = $result->fetch_assoc();


                $request = new Request();

                $request->id = $row['id'];
                $request->name = $row['name'];
                $request->email = $row['email'];
                $request->contactNumber = $row['contactNumber'];
                $request->address = $row['address'];
                $request->certificate = unserialize($row['certificate']);

                $request->description = nl2br($row['description']);
                $request->status = $row['status'];
                $request->dateTimeAppointed = $row['dateTimeAppointed'];
                $request->dateTimeRequested = $row['dateTimeRequested'];

                $r = $request;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $r = $e->getMessage();
        }

        return $r;
    }

    public static function findAll($status, $search, $page, $limit)
    {
        $return = null;

        $search = "%" . $search . "%";


        $initialPage = ($page - 1) * $limit;

        $query = "SELECT * FROM `requests` WHERE `status`=? AND `name` LIKE ? ORDER BY `id` DESC LIMIT ?,?";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("isii", $status, $search, $initialPage, $limit);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $requests = array();

                while($row = $result->fetch_assoc()) {

                    $req = new Request();

                    $req->id = $row['id'];
                    $req->name = $row['name'];
                    $req->email = $row['email'];
                    $req->contactNumber = $row['contactNumber'];
                    $req->address = $row['address'];
                    $req->certificate = unserialize($row['certificate']);
                    // $req->reptMethod = $row['reptMethod'];
                    $req->description = nl2br($row['description']);
                    $req->status = $row['status'];
                    $req->dateTimeAppointed = $row['dateTimeAppointed'];
                    $req->dateTimeRequested = $row['dateTimeRequested'];

                    array_push($requests, $req);

                }

                $return = $requests;
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function countAll($status, $search)
    {
        $return = null;

        $search = "%" . $search . "%";


        $query = "SELECT * FROM `requests` WHERE `status`=? AND `name` LIKE ? ORDER BY `id` DESC";

        $db = new Database();

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("is", $status, $search);

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