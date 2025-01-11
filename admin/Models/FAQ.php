<?php 

class FAQ {

    public $id;
    public $no;

    public $question;
    public $answer;
    public $created;
    public $updated;

    public function save() 
    {
        $db = new Database();
        $query = "INSERT INTO faqs (`no`, `question`, `answer`) VALUES (?,?,?)";
        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("iss",
                $this->no,
                $this->question,
                $this->answer
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

    public function update()
    {
        $this->updated = date('Y-m-d H:i:s');
        $db = new Database();
        $query = "UPDATE faqs SET `no`=?, `question`=?, `answer`=?, updated=? WHERE id=?";
        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("isssi",
                $this->no,
                $this->question,
                $this->answer,
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
        $query = "DELETE FROM faqs WHERE `id`=?";
        try {
            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $stmt->bind_param("i",
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

    public static function getAll()
    {
        $db = new Database();
        $query = "SELECT * FROM faqs ORDER BY `no` ASC";
        try {

            $conn = $db->connect();

            $stmt = $conn->prepare($query);

            $result = $stmt->get_result();

            $conn->close();

            $stmt->close();

            $faqs = array();

            if ($result->num_rows < 1) {
                return $faqs;
            } else {

                while($row = $result->fetch_assoc()) {

                    $faq = new FAQ();

                    $faq->id = $row['id'];
                    $faq->no = $row['no'];
                    $faq->question = $row['question'];
                    $faq->answer = $row['answer'];
                    $faq->created = $row['created'];
                    $faq->updated = $row['updated'];


                    array_push($faqs, $faq);
    

                }

                return $faqs;

            }



        } catch (Exception $e) {
            echo $e;
            return null;
        }
    }
}