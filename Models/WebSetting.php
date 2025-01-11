<?php 


class WebSetting {

    public $id;
    public $about;

    

    
    public function newWeb()
    {

        $db = new Database();

        $query = "INSERT INTO `websetting` (`about`) VALUES (?);";
        try {
            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("s",
                $this->about
            );

            $stmt->execute();

            $stmt->close();
            $conn->close();

            return true;
            
        }
        catch (Exception $e)
        {
            echo($e);
            return false;
        }
    }

    public function update()
    {

        $db = new Database();

        $query = "UPDATE `websetting` SET `about` = ? WHERE `id` = 1";

        try {
            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("s", $this->about);

            $stmt->execute();

            $stmt->close();
            $conn->close();

            return true;
            
        }
        catch (Exception $e)
        {
            echo($e);
            return false;
        }
    }

    public static function get()
    {
        $db = new Database();

        $query = "SELECT * FROM `websetting` WHERE `id` = 1;";

        try {
            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            // $stmt->bind_param();

            $stmt->execute();

            $result = $stmt->get_result();

            $stmt->close();
            $conn->close();

            if ($result->num_rows <= 0) {
                return null;
            } else {
                
                $ws = $result->fetch_assoc();

                $webSetting = new WebSetting();
                $webSetting->id = $ws['id'];
                $webSetting->about = nl2br($ws['about']);

                return $webSetting;

            }

            
        }
        catch (Exception $e)
        {
            echo($e);
            return false;
        }
    }



}