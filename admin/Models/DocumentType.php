<?php 

class DocumentType {
    public $id;
    public $name;


    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `documenttype` (`name`) 
        VALUES (?);";

        $return = false;

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("s", $this->name);

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

        $query = "UPDATE `documenttype` SET `name`=? WHERE `id`=?";

        $return = false;

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("si", $this->name, $this->id);

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

    public function delete()
    {
        $db = new Database();

        $query = "DELETE FROM `documenttype` WHERE `id`=?";

        $return = false;

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",$this->id);

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

    public static function findByName($name, $except = 0)
    {
        $db = new Database();

        $query = "SELECT * FROM `documenttype` WHERE `name`=? AND `id` !=?;";

        $return = null;

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("si", $name, $except);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    $row = $result->fetch_assoc();

                    $documentType = new DocumentType();
                    $documentType->id = $row['id'];
                    $documentType->name = $row['name'];
    
                    $return = $documentType;
                }
            }

            $stmt->close();
            $conn->close();
             
        } catch (Exception $e) {
            $return = $e->getMessage();
        }
        return $return;
    }

    public static function findBySearch($search)
    {
        $db = new Database();

        $query = "SELECT * FROM `documenttype` WHERE `name` LIKE ?;";

        $search = "%".$search."%";

        $return = null;

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("s", $search);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {

                
                $result = $stmt->get_result();

                
                if ($result->num_rows <= 0) {
                    $return = null;
                } else {
                    

                    $documentTypes = array();

                    while ($row = $result->fetch_assoc()) {
                        $documentType = new DocumentType();
                        $documentType->id = $row['id'];
                        $documentType->name = $row['name'];

                        array_push($documentTypes, $documentType);
                    }
                    $return = $documentTypes;
                }
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

        $query = "SELECT * FROM `documenttype` WHERE `id`=?;";

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

                    $documentType = new DocumentType();
                    $documentType->id = $row['id'];
                    $documentType->name = $row['name'];
    
                    $return = $documentType;
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