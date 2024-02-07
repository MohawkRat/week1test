<?php

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
        try {
            $stmt = $this->conn->prepare("INSERT INTO CareProUsers(Username, Email, Password_Hash, Staff, Session_ID) VALUES (:username, :email, :password_hash, 0, 0)");
            $stmt->execute(array('username'=> $username, 'email'=> $email, 'password_hash'=> $passHash));
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

}