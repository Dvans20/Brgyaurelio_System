<?php 

class Categories {

    public $id;
    public $type;
    public $categories;



    public function update()
    {
        $db = new Database();

        $query = "UPDATE `categories` SET `categories`=?
        WHERE `type` = ?";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $this->categories, $this->type);


            $stmt->execute();

            $stmt->close();
            $conn->close();

        }
        catch (Exception $e)
        {
            echo $e;
            return false;
        }

        
    }

    public static function findByType($type)
    {
        $db = new Database();

        $query = "SELECT * FROM `categories` WHERE `type`=?";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("s", $type);

            $stmt->execute();

            $result = $stmt->get_result();

            $conn->close();
            $stmt->close();

            if ($result->num_rows <= 0) {
                return null;
            } else {
                $c = $result->fetch_assoc();
                $cat = new Categories();
                $cat->id = $c['id'];
                $cat->type = $c['type'];
                $cat->categories = $c['categories'];

                return $cat;
            }

            
        }
        catch(Exception $e)
        {
            echo $e;
            return null;
        }
    }
}