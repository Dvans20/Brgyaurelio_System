<?php 

class Transparency {

    public $id;
    public $documentTitle;
    public $documentType;
    public $calendarYear;

    public $quarter; // 0=whole year, 1=1st qtr, 2=2nd qtr, 3=3rd qtr, 4=4th qtr.
    
    public $pdfFile;
    public $dateTime;

    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `transparency` (`documentTitle`, `documentType`, `calendarYear`, `quarter`, `pdfFile`, `dateTime`) 
        VALUES (?,?,?,?,?,?);";

        $return = false;

        $this->dateTime = date('Y-m-d H:i:s');

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siisss", $this->documentTitle, $this->documentType, $this->calendarYear, $this->quarter, $this->pdfFile, $this->dateTime);

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

        $query = "UPDATE `transparency` SET `documentTitle`=?, `documentType`=?, `calendarYear`=?, `quarter`=?, `pdfFile`=? WHERE `id`=?";

        $return = false;

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("siissi", $this->documentTitle, $this->documentType, $this->calendarYear, $this->quarter, $this->pdfFile, $this->id);

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
        $db = new Database();

        $return = false;

        $query = "DELETE FROM `transparency` WHERE id=?";

        try {

            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            $stmt->execute();

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

        $return = null;

        $query = "SELECT * FROM `transparency` WHERE id=?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $result = null;
                } else {

                    $row = $result->fetch_assoc();

                    $transparency = new Transparency();
                    $transparency->id = $row['id'];
                    $transparency->documentTitle = $row['documentTitle'];
                    $transparency->documentType = $row['documentType'];
                    $transparency->calendarYear = $row['calendarYear'];
                    $transparency->quarter = $row['quarter'];
                    $transparency->pdfFile = $row['pdfFile'];
                    $transparency->dateTime = $row['dateTime'];

                    $return = $transparency;
                }
            }

            $stmt->close();
            $conn->close();

        } catch(Exception $e) {
            $return = $e->getMessage();
        }

        return $return;
    }

    public static function find($page, $limit, $search, $documentType, $calendarYear, $quarter, $except = 0)
    {
        $return = null;

        $db = new Database();

        $conn = $db->connect();

        $initialPage = ($page-1) * $limit; 

        $search = "%".$search."%";

        if (empty($documentType)) {
            $documentTypeQuery = "";
        } else {
            $conn->real_escape_string($documentType);
            $documentTypeQuery = " AND `documentType` = '{$documentType}'";
        }

        if (empty($calendarYear)) {
            $calendarYearQuery = "";
        } else {
            $conn->real_escape_string($calendarYear);
            $calendarYearQuery = " AND `calendarYear` = '{$calendarYear}'";
        }

        if (empty($quarter)) {
            $quarterQuery = "";
        } else {
            $conn->real_escape_string($quarter);
            $quarterQuery = " AND `quarter` = '{$quarter}'";
        }

        $query = "SELECT * FROM `transparency` WHERE `documentTitle` LIKE ?" . $documentTypeQuery . $calendarYearQuery . $quarterQuery . " AND `id` != ? ORDER BY `dateTime` DESC LIMIT ?, ?;";

        try {

            $stmt = $conn->prepare($query);

            $stmt->bind_param("siii", $search, $except, $initialPage, $limit);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();
                
                $transparencies = array();

                if ($result->num_rows <= 0) {
                    $return = $transparencies;
                } else {

                    while($row = $result->fetch_assoc()) {
                        $transparency = new Transparency();

                        $transparency->id = $row['id'];
                        $transparency->documentTitle = $row['documentTitle'];
                        $transparency->documentType = $row['documentType'];
                        $transparency->calendarYear = $row['calendarYear'];
                        $transparency->quarter = $row['quarter'];
                        $transparency->pdfFile = $row['pdfFile'];
                        $transparency->dateTime = $row['dateTime'];

                        array_push($transparencies, $transparency);
                    }

                    $return = $transparencies;
                }
            }

            $stmt->close();


        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        $conn->close();
        return $return;
    }

    public static function countAll($search, $documentType, $calendarYear, $quarter, $except = 0)
    {
        $db = new Database();

        $conn = $db->connect();

        $search = "%".$search."%";

        if (empty($documentType)) {
            $documentTypeQuery = "";
        } else {
            $conn->real_escape_string($documentType);
            $documentTypeQuery = " AND `documentType` = '{$documentType}'";
        }

        if (empty($calendarYear)) {
            $calendarYearQuery = "";
        } else {
            $conn->real_escape_string($calendarYear);
            $calendarYearQuery = " AND `calendarYear` = '{$calendarYear}'";
        }

        if (empty($quarter)) {
            $quarterQuery = "";
        } else {
            $conn->real_escape_string($quarter);
            $quarterQuery = " AND `quarter` = '{$quarter}'";
        }

        $query = "SELECT * FROM `transparency` WHERE `documentTitle` LIKE ?" . $documentTypeQuery . $calendarYearQuery . $quarterQuery . " AND `id` != ?;";

        $return = null;

        try {

            $stmt = $conn->prepare($query);

            $stmt->bind_param("si", $search, $except);

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $result = $stmt->get_result();
                
                $return = $result->num_rows;
            }

            $stmt->close();


        } catch (Exception $e) {
            $return = $e->getMessage();
        }

        $conn->close();
        return $return;
    }


}