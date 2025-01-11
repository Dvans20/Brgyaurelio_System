<?php 

class Resolution  {

    public $id;
    public $resolutionTitle;
    public $resolutionNo;
    public $description;
    public $yearSeries;
    public $dateApproved;
    public $approvedBy;
    public $authors;
    public $pdfFile;
    public $dateTime;


    public function save()
    {
        $db = new Database();
        
        $query = "INSERT INTO `resolutions` (`resolutionTitle`, `resolutionNo`, `description`, `yearSeries`, `dateApproved`, `approvedBy`, `authors`, `pdfFile`, `dateTime`) 
        VALUES (?,?,?,?,?,?,?,?,?);";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssisssss",
                $this->resolutionTitle,    
                $this->resolutionNo,    
                $this->description,    
                $this->yearSeries,    
                $this->dateApproved,    
                $this->approvedBy,    
                $this->authors,    
                $this->pdfFile,    
                $this->dateTime,    
            );

            $return = false;

            if (!$stmt->execute()) {
                $return =  $stmt->error;
            } else {
                $return = true;
            }
            $stmt->close();
            $conn->close();

            return $return;

        } catch (Exception $e) {
            return strval($e);
        }
    }

    public function update()
    {
        $db = new Database();
        
        $query = "UPDATE `resolutions` SET `resolutionTitle`=?, `resolutionNo`=?, `description`=?, `yearSeries`=?, `dateApproved`=?, `approvedBy`=?, `authors`=?, `pdfFile`=? WHERE id = ?";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssissssi",
                $this->resolutionTitle,
                $this->resolutionNo,
                $this->description,
                $this->yearSeries,
                $this->dateApproved,
                $this->approvedBy,
                $this->authors,
                $this->pdfFile,
                $this->id
            );

            $return = false;

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

            return $return;
 
        } catch (Exception $e) {
            return $e;
        }
    }

    public function delete()
    {
        $db = new Database();

        $query = "DELETE FROM `resolutions` WHERE id = ?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            $return = false;

            if (!$stmt->execute()) {
                $return = $stmt->error;
            } else {
                $return = true;
            }

            $stmt->close();
            $conn->close();

            return $return;
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function findById($id)
    {
        $db = new Database();

        $query = "SELECT * FROM `resolutions` WHERE `id` = ?";

        $r = null;

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                $r = null;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $r = null;
                } else {
                    $row = $result->fetch_assoc();

                    $resolution = new Resolution();

                    $resolution->id = $row['id'];
                    $resolution->resolutionTitle = $row['resolutionTitle'];
                    $resolution->resolutionNo = $row['resolutionNo'];
                    $resolution->description = $row['description'];
                    $resolution->yearSeries = $row['yearSeries'];
                    $resolution->dateApproved = date('Y-m-d', strtotime($row['dateApproved']));
                    $resolution->approvedBy = $row['approvedBy'];
                    $resolution->authors = $row['authors'];
                    $resolution->pdfFile = $row['pdfFile'];
                    $resolution->dateTime = $row['dateTime'];

                    $r = $resolution;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

    public static function findByNo($resolutionNo, $yearSeries, $except)
    {
        $db = new Database();

        $query = "SELECT * FROM `resolutions` WHERE `resolutionNo` = ? AND `yearSeries` = ? AND `id` != ?";

        $r = null;

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sii", 
                $resolutionNo,
                $yearSeries,
                $except
            );

            if (!$stmt->execute()) {
                $r = null;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $r = null;
                } else {
                    $row = $result->fetch_assoc();

                    $resolution = new Resolution();

                    $resolution->id = $row['id'];
                    $resolution->resolutionTitle = $row['resolutionTitle'];
                    $resolution->resolutionNo = $row['resolutionNo'];
                    $resolution->description = $row['description'];
                    $resolution->yearSeries = $row['yearSeries'];
                    $resolution->dateApproved = $row['dateApproved'];
                    $resolution->approvedBy = $row['approvedBy'];
                    $resolution->authors = $row['authors'];
                    $resolution->pdfFile = $row['pdfFile'];
                    $resolution->dateTime = $row['dateTime'];

                    $r = $resolution;
                }
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

    public static function find($search, $title, $year, $page, $limit)
    {
        $db = new Database();

        $initialPage = ($page-1) * $limit; 

        $search = "%".$search."%";

        if (empty($year)) {
            $year = 9999;
            $yearFilter = "`yearSeries` != ?";
        } else {
            $yearFilter = "`yearSeries` = ?";
        }

        $year /= 1;
        
        $title = "%" . $title . "%";

        $query = "SELECT * FROM `resolutions` WHERE `resolutionTitle` LIKE ? AND (`description` LIKE ? OR `resolutionNo` LIKE ?) AND {$yearFilter} ORDER BY `dateTime` DESC LIMIT ?, ?;";

        $r = $query;

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssiii",
            $title,
                $search,
                $search,
                $year,
                $initialPage,
                $limit
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    $r = null;
                } else {
                    $resolutions = array();
                    while($row = $result->fetch_assoc()) {
                        $resolution = new Resolution();
                        $resolution->id = $row['id'];
                        $resolution->resolutionTitle = $row['resolutionTitle'];
                        $resolution->resolutionNo = $row['resolutionNo'];
                        $resolution->description = nl2br($row['description']);
                        $resolution->yearSeries = $row['yearSeries'];
                        $resolution->dateApproved = date('M d, Y', strtotime($row['dateApproved']));
                        $resolution->approvedBy = $row['approvedBy'];
                        $resolution->authors = $row['authors'];
                        $resolution->pdfFile = $row['pdfFile'];
                        $resolution->dateTime = $row['dateTime'];

                        array_push($resolutions, $resolution);

                    }
                    $r = $resolutions;

                }
            }

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

    public static function countAll($search, $title, $year)
    {
        $db = new Database();

        $search = "%".$search."%";

        if (empty($year)) {
            $year = 9999;
            $yearFilter = "`yearSeries` != ?";
        } else {
            $yearFilter = "`yearSeries` = ?";
        }

        $year /= 1;

        $title = "%" . $title . "%";

        $query = "SELECT * FROM `resolutions` WHERE `resolutionTitle` LIKE ? AND (`description` LIKE ? OR `resolutionNo` LIKE ?) AND {$yearFilter} ORDER BY `dateTime` DESC";

        $r = null;

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssi",
            $title,
                $search,
                $search,
                $year,
            );

            if (!$stmt->execute()) {
                $r = $stmt->error;
            } else {
                $result = $stmt->get_result();

                $r = $result->num_rows;
            }

        } catch (Exception $e) {
            $r = $e;
        }

        return $r;
    }

}