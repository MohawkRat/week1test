<?php

require_once("utils.php");

class sql {

    private PDO $conn;

    //Runs one time, when an instance is made.
    public function __construct() {
        $json = file_get_contents('info.json');
        $jsonData = json_decode($json);
        

        $host = 'mi-linux.wlv.ac.uk';
        $dbname = $jsonData->dbname;
        $username = $jsonData->user;
        $password = $jsonData->pass;

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //Function checking the email does not already exist.
    public function checkEmail($email) {
        try {
            $stmt = $this->conn->prepare("SELECT Email from CareProUsers WHERE Email = :email");
            $stmt->execute(array('email'=> $email));
            $user = $stmt->fetch();
            if ($user) {
                return "email exists";
            }
            return false;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function registerUser($username, $email, $password) {
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $sessionId = utils::generateSessionId();
        try {
            $stmt = $this->conn->prepare("INSERT INTO CareProUsers(Username, Email, Password_Hash, Staff, Session_ID) VALUES (:username, :email, :password_hash, 0, :sessionid)");
            $stmt->execute(array('username'=> $username, 'email'=> $email, 'password_hash'=> $passHash, 'sessionid' => $sessionId));  
            setcookie("sessionid", $sessionId);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function login($email, $password) {
        if ($this->checkEmail($email) == "email exists") {
            try {
                $stmt = $this->conn->prepare("SELECT User_ID, Email, Password_Hash FROM CareProUsers WHERE Email = :email");
                $stmt->execute(array('email' => $email));
                $user = $stmt->fetch();
                if (password_verify($password, $user['Password_Hash'])) {
                    $sessionId = utils::generateSessionId();
                    $stmt = $this->conn->prepare("UPDATE CareProUsers SET Session_ID = :session WHERE User_ID = :userid");
                    $stmt->execute(array('session'=> $sessionId, 'userid'=> $user['User_ID']));
                    
                    setcookie("sessionid", $sessionId, time() + 2600, '/');
                    return true;
                }
                return false;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public function getCookie($sessionId) {
        try {
            $stmt = $this->conn->prepare("SELECT Username, Staff, Session_ID FROM CareProUsers WHERE Session_ID = :sessionid;");
            $stmt->execute(array('sessionid'=> $sessionId));
            $result = $stmt->fetch();
            if ($result) {
                return $result;
            }
            return false;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}