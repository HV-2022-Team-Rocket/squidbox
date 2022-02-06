<?php

class poem_handler
{
    public static function uploadPoem($userId, $poem, $title, $conn)
    {
        $sql = "INSERT INTO poems (poemsUid, poemsTitle, poemsBody) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "iss", $userId, $title, $poem);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function getPoems()
    {
        $sql = "SELECT * FROM poems";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
        
        mysqli_stmt_execute($stmt);
    
        $result = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }
    
        return false;
        mysqli_stmt_close($stmt);
    }
}