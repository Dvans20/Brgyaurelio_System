<?php 


require_once '../Utilities/Database.php';

require_once '../Models/User.php';
require_once '../Models/Log.php';
require_once '../Models/WebSetting.php';

class UsersController extends User {


    public static function login($datas)
    {

        $response = [
            'status' => 2,
            'msg' => "",
        ];

        $email = $datas['email'];
        $password = $datas['password'];

        $user = User::findByEmail($email);

        if (empty($email) || empty($password)) {
            $response['msg'] = "All fields are required.";
        } else if ($user == null) {
            $response['msg'] = "User not found.";
        } else  if (!password_verify($password, $user->password)) {
            $response['msg'] = "Incorrect Credentials.";
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['brgyAurelioUser'] = $user->id;

            Log::saveNewActivity("Logged In", "Logged In");

            $response['status'] = 3;
            $response['msg'] = "Login Success";
        }


        echo json_encode($response);
    }

    public static function logOut()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = User::findById($_SESSION['brgyAurelioUser']);

        session_unset();
        session_destroy();

        Log::saveNewActivity("Logged Out", "Logged Out", $user->id);


        $response = [
            'status' => 3,
            'msg' => "Logged Out"
        ];

        echo json_encode($response);
    }

    public static function getLOggedInUser()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['brgyAurelioUser'])) {
            $response = User::findById($_SESSION['brgyAurelioUser']);
        } else {
            $response = null;
        }

        echo json_encode($response);

    }

    public static function saveUser($datas)
    {

        $response = [
            'status' => 2,
            'msg' => "",
        ];

        foreach ($datas as $k => $v) 
        {
            $$k = $v;
        }

        if (empty($name) || empty($email) || empty($accessType) || empty($password) || empty($confirmPassword)) {
            $response['msg'] = "All fields are required.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['msg'] = "Invalid Email.";
        } else if (User::findByEmail($email, 0) != null) {
            $response['msg'] = "Email already taken.";
        } else if (!preg_match("/^(?=.*[a-z])/", $password)) {
            $response['msg'] = "Password must contain a lowercase letter.";
        } else if (!preg_match("/^(?=.*[A-Z])/", $password)) {
            $response['msg'] = "Password must contain an uppercase letter.";
        } else if (!preg_match("/^(?=.*\d)/", $password)) {
            $response['msg'] = "Password must contain a number.";
        } else if (!preg_match("/.{6,}/", $password)) {
            $response['msg'] = "Password must contain atleast 6 characters.";
        } else if ($password != $confirmPassword) {
            $response['msg'] = "Password do not match.";
        } else {

            $user = new User();

            $user->name = $name;
            $user->email = $email;
            $user->accessType = $accessType;
            $user->password = password_hash($password, PASSWORD_DEFAULT);

            if ( $user->save()) {
                $response['status'] = 3;
                $response['msg'] = "User successfully saved.";
                Log::saveNewActivity("saved", "Added a new User.");
            } else {
                $response['status'] = 1;
                $response['msg'] = "Something went wrong.";
            }

        }

        echo json_encode($response);
    }

    public static function updateUser($datas)
    {

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        
        if (isset($_SESSION['brgyAurelioUser'])) {
            $user = User::findById($_SESSION['brgyAurelioUser']);
        } else {
            $user = null;
        }

        if ($user == null) {
            $response['status'] = 3;
            $response['msg'] = "Something Went Wrong";
        } else if (empty($newName) || empty($newEmail)) {
            $response['status'] = 2;
            $response['msg'] = "All fields are required.";
        } else if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 2;
            $response['msg'] = "Invalid Email.";
        } else if (User::findByEmail($newEmail, $user->id) != null) {
            $response['status'] = 2;
            $response['msg'] = "Email already taken.";
        } else {
            $user->name = $newName;
            $user->email = $newEmail;
            $user->update();

            $response['status'] = 3;
            $response['msg'] = "User Updated.";

            Log::saveNewActivity("Updated", "Updated his/her own info.");
        }

        echo json_encode($response);


    }

    public static function changePassword($datas)
    {
        $response = [
            'status' => 2,
            'msg' => ""
        ];

        foreach ($datas as $k => $v) {
            $$k = $v;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        
        if (isset($_SESSION['brgyAurelioUser'])) {
            $user = User::findById($_SESSION['brgyAurelioUser']);
        } else {
            $user = null;
        }

        if ($user == null) {
            $response['status'] = 3;
            $response['msg'] = "Something Went Wrong";
        } else if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
            $response['status'] = 2;
            $response['msg'] = "All fields are required.";
        } else if (!password_verify($currentPassword, $user->password)) {
            $response['status'] = 2;
            $response['msg'] = "Incorrect Password.";

        } else if (!preg_match("/^(?=.*[a-z])/", $newPassword)) {
            $response['msg'] = "Password must contain a lowercase letter.";
        } else if (!preg_match("/^(?=.*[A-Z])/", $newPassword)) {
            $response['msg'] = "Password must contain an uppercase letter.";
        } else if (!preg_match("/^(?=.*\d)/", $newPassword)) {
            $response['msg'] = "Password must contain a number.";
        } else if (!preg_match("/.{6,}/", $newPassword)) {
            $response['msg'] = "Password must contain atleast 6 characters.";
        } else if ($newPassword != $confirmNewPassword) {
            $response['msg'] = "Password do not match.";
        } else {
            
            $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
            $user->update();

            $response['status'] = 3;
            $response['msg'] = "Password Updated.";

            Log::saveNewActivity("Updated", "Updated his/her password.");
        }

        echo json_encode($response);
    }

    public static function updateUserSessionTime()
    {

        date_default_timezone_set("Asia/Manila");

        $response = [
            'web' => WebSetting::get()
        ];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['brgyAurelioUser'])) {
            $response['msg'] = "Not Logged In.";
        }  else {
            $user = User::findById($_SESSION['brgyAurelioUser']);
            $user->sessionTime = time();
            $user->updateSessionTime();

            $response['msg'] = $user->sessionTime;
        }

        echo json_encode($response);
    }

    public static function getUsers($datas)
    {
        foreach ($datas as $k => $v) 
        {
            $$k = $v;
        }

        $users = User::findAll($search, $limit, $page);

        $response = [
            'users' => $users, 
            'totalPages' => ceil(User::countAll($search) / $limit)
        ];

        echo json_encode($response);
    }

    public static function getUser($id)
    {
        $user = User::findById($id);

        echo json_encode($user);
    }

    public static function updateAccessType($datas)
    {

        $response = [
            'status' => 2,
            'msg' => ""
        ];

        foreach($datas as $k=>$v)
        {
            $$k = $v;
        }

        if (empty($id) || empty($accessType)) {
            $response['msg'] = "User Type is required";
        } else {
            $user = User::findById($id);

            $user->accessType = $accessType;

            if (!$user->update()) {
                $response['msg'] = "Something went wrong.";
                $response['status'] = 1;
            } else {
                Log::saveNewActivity("Updated", "Updated " . $user->name . " user type.");

                $response['msg'] = "Access Type Updated.";
                $response['status'] = 3;
            }
        }


        echo json_encode($response);
    }

    public static function deleteUser($datas) 
    {
        $response = [
            'status' => 2,
            'msg' => ""
        ];

        foreach($datas as $k=>$v)
        {
            $$k = $v;
        }

 

        $loggedInUser;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['brgyAurelioUser'])) {
            $loggedInUser = User::findById($_SESSION['brgyAurelioUser']);
        } else {
            $loggedInUser = null;
        }



        if ($loggedInUser == null) {
            $response['msg'] = "Something went wrong.";
        } else if (empty($id) || empty($password)) {
            $response['msg'] = "Password is required.";
        } else if (!password_verify($password, $loggedInUser->password)) {
            $response['msg'] = "Incorrect Password.";
        } else {

            $user = User::findById($id);
           

            if ($user->delete()) {
                Log::saveNewActivity("Deleted", "Deleted a user named: " . $user->name);

                $response['msg'] = "User deleted.";
                $response['status'] = 3;
            } else {
                $response['msg'] = "Something went wrong.";
            }
        }

        echo json_encode($response);
    }
}