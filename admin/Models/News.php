<?php 

class News {

    public $id;
    public $newsTitle;
    public $newsContent;
    public $featureImage;
    public $categories;
    public $status;
    public $datePublished;
    public $dateSaved;

    public function save()
    {
        $db = new Database();

        $query = "INSERT INTO `news` (`newsTitle`, `newsContent`, `featureImage`, `categories`, `status`, `datePublished`, `dateSaved`) VALUES (?,?,?,?,?,?,?);";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssiss",
                $this->newsTitle,
                $this->newsContent,
                $this->featureImage,
                $this->categories,
                $this->status,
                $this->datePublished,
                $this->dateSaved
            );


            if ($stmt->execute()) {
                $this->id = $stmt->insert_id;
                $r = "Good";
            } else {
                return $stmt->error;
            }


            
            $stmt->close();
            $conn->close();

            return $r;

        }
        catch (Exception $e)
        {
            return $e;
        }
    }

    public function update()
    {
        $db = new Database();

        $query = "UPDATE `news` SET `newsTitle`=?, `newsContent`=?, `featureImage`=?, `categories`=?, `status`=?, `datePublished`=? WHERE id=?";

        try {

            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("ssssisi",
                $this->newsTitle,
                $this->newsContent,
                $this->featureImage,
                $this->categories,
                $this->status,
                $this->datePublished,
                $this->id
            );

            $stmt->execute();

            $stmt->close();

            return true;

        }
        catch (Exception $e)
        {
            echo $e;
            return false;
        }
    }

    public function delete()
    {
        $db = new Database();

        $query = "DELETE FROM `news` WHERE id=?";

        try {
            $conn = $db->connect();
            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",
                $this->id
            );

            $stmt->execute();

            $stmt->close();

            return true;

        }
        catch (Exception $e)
        {
            echo $e;
            return false;
        }
    }

    public static function get($search, $categories, $page, $limit, $status = null)
    {
        $db = new Database();

        $categoryFilter = "";



        $query = "SELECT * FROM `news` ";

        if (!empty($categories)) {

            foreach ($categories as $category)
            {
                if (empty($categoryFilter)) {
                    $categoryFilter .= " AND (`categories` LIKE '%|{$category}|%'";
                } else {
                    $categoryFilter .= " OR `categories` LIKE '%|{$category}|%'";
                }

            }

            $categoryFilter .= ")";
        }

        $searchQuery = "WHERE `newsTitle` LIKE ?";

        if ($status != null) {
            $statusQuery = " AND (`status` = '{$status}')";
        } else {
            $statusQuery = "";
        }



        $initialPage = ($page-1) * $limit; 

        

        $query .= $searchQuery . $categoryFilter . $statusQuery . " ORDER BY `dateSaved` DESC LIMIT ?, ?";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sii",
                $search,
                $initialPage,
                $limit
            );

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                $newses = array();

                while($row = $result->fetch_assoc()) {
                    $news = new News();

                    $news->id = $row['id'];
                    $news->newsTitle = $row['newsTitle'];
                    $news->newsContent = $row['newsContent'];
                    $news->featureImage = $row['featureImage'];
                    $news->categories = $row['categories'];
                    $news->status = $row['status'];
                    $news->datePublished = $row['datePublished'];
                    $news->dateSaved = $row['dateSaved'];

                    array_push($newses, $news);
                }

                return $newses;
            } else {
                return $stmt->error;
            }

            


        }
        catch (Exception $e)
        {
            return $e;
        }
    }

    public static function countAll($search, $categories, $status = null)
    {
        $db = new Database();

        $categoryFilter = "";
        $parameters = array();

        $query = "SELECT * FROM `news` ";

        if (!empty($categories)) {

            foreach ($categories as $category)
            {
                if (empty($categoryFilter)) {
                    $categoryFilter .= " AND (`categories` LIKE '%|{$category}|%'";
                } else {
                    $categoryFilter .= " OR `categories` LIKE '%|{$category}|%'";
                }
            }

            $categoryFilter .= ")";
        }

        $searchQuery = "WHERE `newsTitle` LIKE ?";

        if ($status != null) {
            $statusQuery = " AND (`status` = '{$status}')";
        } else {
            $statusQuery = "";
        }

        $query .= $searchQuery . $categoryFilter . $statusQuery . " ORDER BY `dateSaved` DESC";

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("s",
                $search
            );

            if (!$stmt->execute()) {
                return $stmt->error;
            } else {
                $result = $stmt->get_result();
                return $result->num_rows;
            }
        }
        catch (Exception $e)
        {
            return $e;
        }
    }

    public static function findById($id)
    {
        $db = new Database();

        $query = "SELECT * FROM `news` WHERE id = ?";

        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                return $stmt->error;
            } else {

                $result = $stmt->get_result();

                if ($result->num_rows <= 0) {
                    return null;
                } else {
                    $row = $result->fetch_assoc();

                    $news = new News();

                    $news->id = $row['id'];
                    $news->newsTitle = $row['newsTitle'];
                    $news->newsContent = $row['newsContent'];
                    $news->featureImage = $row['featureImage'];
                    $news->categories = $row['categories'];
                    $news->status = $row['status'];

                    if (!empty($row['datePublished'])) {
                        $news->datePublished = date("M d, Y h:i a", strtotime($row['datePublished']));
                    } else {
                        $news->datePublished = "Post has not been published.";
                    }
                    $news->dateSaved = date("M d, Y h:i a", strtotime($row['dateSaved']));

                    return $news;
                }
            }



        } catch (Exception $e) {
            return $e;
        }
    }

    
}