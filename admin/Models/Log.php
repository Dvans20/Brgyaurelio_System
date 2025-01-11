
<?php


class Log {

    public $id;
    public $userId;
    public $userInfo;
    public $ip;
    public $action;
    public $actionDescription;
    public $device;
    public $geoLoc;
    public $dateTime;


    protected function save() 
    {
        $db = new Database();
        

        try {

            $conn = $db->connect();

            $stmt = $conn->prepare("INSERT INTO `logs`(`userId`, `userInfo`, `ip`, `action`, `actionDescription`, `device`, `dateTime`, `geoLoc`) VALUES (?,?,?,?,?,?,?,?);");

            $stmt->bind_param("isssssss", 
                $this->userId, 
                $this->userInfo,
                $this->ip, 
                $this->action,
                $this->actionDescription,
                $this->device,
                $this->dateTime,
                $this->geoLoc
            );


            $stmt->execute();

            $this->id = $stmt->insert_id;

            $conn->close();

            $stmt->close();


            return true;

        } catch(Exception $e) {
            return false;
        }
    }

    public static function findAll($page, $limit, $search, $dateTimeFrom, $dateTimeTo) {

        date_default_timezone_set("Asia/Manila");

        $db = new Database();
        $conn = $db->connect();

        $search  = "%".$search."%";
        
        $beginAt = ($page-1) * ($limit);

        if ($dateTimeFrom == "") {
            $dateTimeFrom = strtotime("0001-01-01 00:00:00");
        } else {
            $dateTimeFrom = strtotime($dateTimeFrom);
        }

        if ($dateTimeTo == "") {
            $dateTimeTo = strtotime("9999-12-30 24:59:59");
        } else {
            $dateTimeTo = strtotime($dateTimeTo);
        }



        try {

            $stmt = $conn->prepare("SELECT * FROM logs WHERE 
                (`userInfo` LIKE ? OR `actionDescription` LIKE ? OR `action` LIKE ?)
                AND (unix_timestamp(dateTime) >= ? AND unix_timestamp(dateTime) <= ?)
                ORDER BY unix_timestamp(`dateTime`) DESC LIMIT ?, ?");

            $stmt->bind_param("sssiiii",
            $search, $search, $search,
            $dateTimeFrom, $dateTimeTo,
            $beginAt, $limit
            );

            $stmt->execute();

            $result = $stmt->get_result();

            $logs = array();

            if ($result->num_rows < 1) {
                return $logs;
            } else {
                while ($row = $result->fetch_assoc()) {
                    $log = new Log();
                    $log->id = $row["id"];
                    $log->userId = $row["userId"];
                    $log->userInfo = $row["userInfo"];
                    $log->ip = $row["ip"];
                    $log->action = $row["action"];
                    $log->actionDescription = $row["actionDescription"];
                    $log->device = unserialize($row['device']);
                    $log->dateTime = date('M d, Y h:i a', strtotime($row["dateTime"]));

                    array_push($logs, $log);
                }

                return $logs;
            }

        } catch(Exception $e) {
            return null;
        }
    }

    public static function saveNewActivity($action, $actionDescription, $userId = 0)
    {
        
        date_default_timezone_set("Asia/Manila");

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        function getOS() { 

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $os_platform  = "Unknown OS Platform";

            $os_array = array(
                '/windows nt 10/i'      =>  'Windows 10',
                '/windows nt 6.3/i'     =>  'Windows 8.1',
                '/windows nt 6.2/i'     =>  'Windows 8',
                '/windows nt 6.1/i'     =>  'Windows 7',
                '/windows nt 6.0/i'     =>  'Windows Vista',
                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                '/windows nt 5.1/i'     =>  'Windows XP',
                '/windows xp/i'         =>  'Windows XP',
                '/windows nt 5.0/i'     =>  'Windows 2000',
                '/windows me/i'         =>  'Windows ME',
                '/win98/i'              =>  'Windows 98',
                '/win95/i'              =>  'Windows 95',
                '/win16/i'              =>  'Windows 3.11',
                '/macintosh|mac os x/i' =>  'Mac OS X',
                '/mac_powerpc/i'        =>  'Mac OS 9',
                '/linux/i'              =>  'Linux',
                '/ubuntu/i'             =>  'Ubuntu',
                '/iphone/i'             =>  'iPhone',
                '/ipod/i'               =>  'iPod',
                '/ipad/i'               =>  'iPad',
                '/android/i'            =>  'Android',
                '/blackberry/i'         =>  'BlackBerry',
                '/webos/i'              =>  'Mobile'
            );

            foreach ($os_array as $regex => $value) {
                if (preg_match($regex, $user_agent)) $os_platform = $value;
            }

            return $os_platform;
        }

        function getBrowser() {

            $user_agent = $_SERVER['HTTP_USER_AGENT'];

            $browser = "Unknown Browser";

            $browser_array = array(
                '/msie/i'      => 'Internet Explorer',
                '/firefox/i'   => 'Firefox',
                '/safari/i'    => 'Safari',
                '/chrome/i'    => 'Chrome',
                '/edge/i'      => 'Edge',
                '/opera/i'     => 'Opera',
                '/netscape/i'  => 'Netscape',
                '/maxthon/i'   => 'Maxthon',
                '/konqueror/i' => 'Konqueror',
                '/mobile/i'    => 'Handheld Browser'
            );

            foreach ($browser_array as $regex => $value) {
                if (preg_match($regex, $user_agent)) $browser = $value;
            }
            return $browser;
        }
        
       

        if (isset($_SESSION['brgyAurelioUser'])) {
            $loggedInUser = User::findById($_SESSION['brgyAurelioUser']);
        } else {
            $loggedInUser = User::findById($userId);
        }

        $device = [
            'browser' => getBrowser(),
            'os' => getOS()
        ];
        
        $log = new Log();
        $log->userId = $loggedInUser->id;
        $log->userInfo = $loggedInUser->name;
        $log->ip = $_SERVER['REMOTE_ADDR'];
        $log->action = $action;
        $log->actionDescription = $actionDescription;
        $log->device = serialize($device);
        $log->dateTime = date('Y-m-d H:i:s');
        $log->geoLoc = "";

        $log->save();

    }

    public static function countAll($search, $dateTimeFrom, $dateTimeTo)
    {
        date_default_timezone_set("Asia/Manila");

        $db = new Database();
        $conn = $db->connect();

        $search  = "%".$search."%";

        if ($dateTimeFrom == "") {
            $dateTimeFrom = strtotime("0001-01-01 00:00:00");
        } else {
            $dateTimeFrom = strtotime($dateTimeFrom);
        }

        if ($dateTimeTo == "") {
            $dateTimeTo = strtotime("9999-12-30 24:59:59");
        } else {
            $dateTimeTo = strtotime($dateTimeTo);
        }



        try {

            $stmt = $conn->prepare("SELECT * FROM logs WHERE 
                (`userInfo` LIKE ? OR `actionDescription` LIKE ? OR `action` LIKE ?)
                AND (unix_timestamp(dateTime) >= ? AND unix_timestamp(dateTime) <= ?)
                ORDER BY unix_timestamp(`dateTime`) DESC");

            $stmt->bind_param("sssii",
            $search, $search, $search,
            $dateTimeFrom, $dateTimeTo
            );

            $stmt->execute();

            $result = $stmt->get_result();

            return $result->num_rows;

        } catch(Exception $e) {
            return 0;
        }
    }
}