<?php 


class WebSetting {

    public $id;
    public $about;

    public $siteUrl;

    public $brgy;
    public $address;
    public $contactNo;
    public $email;
    public $tagline;
    public $embeddedMap;
    public $aboutPage;
    public $puroks;

    public $brgyCaptainName;
    public $brgySecretaryName;
    public $brgyTreasurerName;

    public $skChairmanName;

    public $councilors;

    

    
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

        $query = "UPDATE `websetting` SET `about`=?, `siteUrl`=?, `brgy`=?, `address`=?, `contactNo`=?, `email`=?, `tagline`=?, embeddedMap=?, `aboutPage`=?, `puroks`=?, `brgyCaptainName`=?, `brgySecretaryName`=?, `brgyTreasurerName`=?, `skChairmanName`=?, `councilors`=?
        WHERE `id` = 1";

        if (is_array($this->puroks)) {
            $this->puroks = serialize($this->puroks);
        }

        if (is_array($this->councilors)) {
            $this->councilors = serialize($this->councilors);
        }

        try {
            $conn = $db->connect();
            
            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssssssssssssss", 
                $this->about,
                $this->siteUrl,
                $this->brgy,
                $this->address,
                $this->contactNo,
                $this->email,
                $this->tagline,
                $this->embeddedMap,
                $this->aboutPage,
                $this->puroks,
                $this->brgyCaptainName,
                $this->brgySecretaryName,
                $this->brgyTreasurerName,
                $this->skChairmanName,
                $this->councilors
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

                $isPuroksUnserializable = @unserialize($ws['puroks']);

                $isPuroksUnserializable = $isPuroksUnserializable !== false || $ws['puroks'] === 'b:0;';

                $isCouncilorsUnserializable = @unserialize($ws['councilors']);
                $isCouncilorsUnserializable = $isCouncilorsUnserializable !== false || $ws['councilors'] === 'b:0;';

                $webSetting = new WebSetting();
                $webSetting->id = $ws['id'];
                $webSetting->about = nl2br($ws['about']);
                $webSetting->siteUrl = $ws['siteUrl'];
                $webSetting->brgy = $ws['brgy'];
                $webSetting->address = $ws['address'];
                $webSetting->contactNo = $ws['contactNo'];
                $webSetting->email = $ws['email'];
                $webSetting->tagline = $ws['tagline'];
                $webSetting->embeddedMap = $ws['embeddedMap'];
                $webSetting->aboutPage = $ws['aboutPage'];
                $webSetting->brgyCaptainName = $ws['brgyCaptainName'];
                $webSetting->brgySecretaryName = $ws['brgySecretaryName'];
                $webSetting->brgyTreasurerName = $ws['brgyTreasurerName'];
                $webSetting->skChairmanName = $ws['skChairmanName'];
                // $webSetting->councilors = $ws['councilors'];
               

                if ($isPuroksUnserializable) {
                    $webSetting->puroks = unserialize($ws['puroks']);
                } else {
                    $webSetting->puroks = null;
                }

                if ($isCouncilorsUnserializable) {
                    $webSetting->councilors = unserialize($ws['councilors']);
                } else {
                    $webSetting->councilors = null;
                }

                if (substr($webSetting->siteUrl, -1) != "/")  {
                    $webSetting->siteUrl .= "/";
                }

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