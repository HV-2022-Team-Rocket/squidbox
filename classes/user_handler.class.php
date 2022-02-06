<?php

class register_info
{
    public $userUid;
    public $name;
    public $email;
    public $pass;
    public $pass2;

    public function __construct($post)
    {
        $this->name = $post["name"];
        $this->userUid = $post["uid"];
        $this->email = $post["email"];
        $this->pass = $post["pwd"];
        $this->pass2 = $post["pwd2"];
    }

    public function validateData()
    {
        $result = "none";

        //Null data fields
        if (empty($this->name) || empty($this->userUid) || empty($this->email) || empty($this->pass) || empty($this->pass2))
        {
            $result = "null_fields";
        }

        //Invalid UID format
        else if (strlen($this->userUid) < 4 || is_numeric(substr($this->userUid, 0, 1)) || !preg_match("/^[a-zA-Z0-9]*$/", $this->userUid))
        {
            $result = "invalid_uid";
        }

        //Invalid email format
        else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $result = "invalid_email";
        }

        //Invalid pass format
        else if (!preg_match('~[0-9]+~', $this->pass) || strlen($this->pass) < 8)
        {
            $result = "invalid_pass";
        }

        //Non-matching pass
        else if ($this->pass !== $this->pass2)
        {
            $result = "pass_match";
        }
        
        return $result;
    }
};

class login_info
{
    public $login;
    public $pass;

    public function __construct($post)
    {
        $this->login = $post["login"];
        $this->pass = $post["pwd"];
    }

    public function validateData()
    {
        $result = "none";

        //Null data fields
        if (empty($this->login) || empty($this->pass))
        {
            $result = "null_fields";
        }

        return $result;
    }
}

class user_handler
{
    public static function registerNewUser($user, $conn)
    {
        $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        $hashPass = password_hash($user->pass, PASSWORD_DEFAULT);
    
        mysqli_stmt_bind_param($stmt, "ssss", $user->name, $user->email, $user->userUid, $hashPass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        header("location: ../login.php?signup=true");
    }

    public static function loginUser($user, $conn)
    {
        $loginExists = user_handler::loginExists($user->login, $user->login, $conn);

        if ($loginExists == false)
        {
            return false;
            exit();
        }

        $hashPass = $loginExists["usersPwd"];

        if (password_verify($user->pass, $hashPass))
        {
            session_start();

            $_SESSION["userId"] = $loginExists["usersId"];
            $_SESSION["userUid"] = $loginExists["usersUid"];
            $_SESSION["userEmail"] = $loginExists["usersEmail"];
            $_SESSION["userName"] = $loginExists["usersName"];

            return true;
            exit();
        }

        return false;
        exit();
    }

    public static function userAddScore($amount, $score, $id, $conn)
    {
        $sum = $amount + $score;

        $sql = "UPDATE users SET usersScore = ? WHERE usersId = ?";
        $stmt = mysqli_stmt_init($conn->getHandle());

        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }

        mysqli_stmt_bind_param($stmt, "ii", $sum, $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        exit();
    }

    public static function loginExists($uid, $email, $conn)
    {
        $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }
    
        return false;
        mysqli_stmt_close($stmt);
    }

    public static function uidExists($userUid, $conn)
    {
        $sql = "SELECT * FROM users WHERE usersUid = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());

        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }

        mysqli_stmt_bind_param($stmt, "s", $userUid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }

        return false;
        mysqli_stmt_close($stmt);
    }

    public static function emailExists($email, $conn)
    {
        $sql = "SELECT * FROM users WHERE usersEmail = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());

        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }

        return false;
        mysqli_stmt_close($stmt);
    }

    private static function throwDbError()
    {
        header("location: ../login.php?error=db_fail");
        exit();
    }
}