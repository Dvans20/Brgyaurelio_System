<?php 

class User {

    public int $id;
    public string $name;
    public string $email;
    protected string $password;
    public int $accessType;
    public string $created;
    public string $updated;

    public string $sessionTime;

    protected function save()
    {
        $db = new Database();

        $query = "INSERT INTO `users` (`name`, `email`, `password`, `accessType`) VALUES (?,?,?,?)";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);


            $stmt->bind_param(
                "sssi",
                $this->name,
                $this->email,
                $this->password,
                $this->accessType
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

    protected function updateSessionTime()
    {
        $db = new Database();

        $query = "UPDATE `users` SET `sessionTime`=? WHERE id=?";

        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);
            $stmt->bind_param(
                "si",
                $this->sessionTime,
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

    protected function update() 
    {
        $db = new Database();
        $this->updated = date("Y-m-d H:i:s");

        $query = "UPDATE `users` SET `name`=?, `email`=?, `password`=?, `accessType`=?, `updated`=? WHERE id=?";

        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);
            $stmt->bind_param(
                "sssisi",
                $this->name,
                $this->email,
                $this->password,
                $this->accessType,
                $this->updated,
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
        $query = "DELETE FROM `users` WHERE `id` = ?";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            $stmt->execute();

            $stmt->close();
            $conn->close();

            return true;

        } catch (Exception $e) {
            echo $e;
            return false;
        }
    }




    public static function findById($id)
    {
        $db = new Database();

        $query = "SELECT * FROM `users` WHERE id=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            $conn->close();
            $stmt->close();

            if ($result->num_rows <= 0) {
                return null;
            } else {

                $row = $result->fetch_assoc();

                $user = new User();
                
                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->accessType = $row['accessType'];
                $user->created = $row['created'];
                $user->updated = $row['updated'];

                return $user;
                
            }   

        } catch (Exception $e) {
            echo $e;
            return null;
        }
    }

    public static function findByEmail($email, $exceptId = 0)
    {
        $db = new Database();

        $query = "SELECT * FROM `users` WHERE `email` = ? AND `id` != ?";

        try {

            $conn = $db->connect();
            $stmt= $conn->prepare($query);
            $stmt->bind_param("si", $email, $exceptId);

            $stmt->execute();

            $result = $stmt->get_result();

            $conn->close();
            $stmt->close();

            if  ($result->num_rows <= 0) {
                return null;
            } else {

                $row = $result->fetch_assoc();

                $user = new User();

                $user->id = $row['id'];
                $user->name = $row['name'];
                $user->email = $row['email'];
                $user->password = $row['password'];
                $user->accessType = $row['accessType'];
                $user->created = $row['created'];
                $user->updated = $row['updated'];

                return $user;
            }

        } catch (Exception $e) {
            echo $e;
            return null;
        }

    }

    public static function findAll($search, $limit, $page)
    {
        $db = new Database();

        $search = "%".$search."%";

        $initialPage = ($page-1) * $limit; 

        $query = "SELECT * FROM `users` WHERE `email` LIKE ? OR `name` LIKE ? ORDER BY `name` ASC LIMIT ?, ?";

        try {

            $conn = $db->connect();
            $stmt= $conn->prepare($query);
            $stmt->bind_param(
                "ssii", 
                $search,
                $search,
                $initialPage,
                $limit
            );

            $stmt->execute();

            $result = $stmt->get_result();

            $conn->close();
            $stmt->close();

            $users = array();

            if  ($result->num_rows <= 0) {
                return $users;
            } else {

                while ($row = $result->fetch_assoc()) {
                    $user = new User();

                    $user->id = $row['id'];
                    $user->name = $row['name'];
                    $user->email = $row['email'];
                    // $user->password = $row['password'];
                    $user->accessType = $row['accessType'];
                    $user->created = $row['created'];
                    $user->updated = $row['updated'];
    
                    array_push($users, $user);
                }
                
                return $users;
            }

        } catch (Exception $e) {
            echo $e;
            return null;
        }
    }


    public static function countAll($search)
    {
        $db = new Database();

        $search = "%".$search."%";

        $query = "SELECT * FROM `users` WHERE `email` LIKE ? OR `name` LIKE ? ORDER BY `name` ASC";

        try {

            $conn = $db->connect();
            $stmt= $conn->prepare($query);
            $stmt->bind_param(
                "ss", 
                $search,
                $search,
            );

            $stmt->execute();

            $result = $stmt->get_result();

            $conn->close();
            $stmt->close();

            return $result->num_rows / 1;

        } catch (Exception $e) {
            echo $e;
            return 0;
        }
    }

}