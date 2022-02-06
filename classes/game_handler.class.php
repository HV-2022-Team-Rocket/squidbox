<?php

class game_info
{
    private $gameId;

    public function __construct()
    {
        //something something gameId
    }
}

class game_handler
{
    public static function generateGame($conn)
    {
        $sql = "INSERT INTO games (gamesCid, gamesBegun, gamesTimer, gamesPlayers) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "iiis", 1, 0, 180, "");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $last_id = $conn->getHandle()->insert_id;
    }

    public static function advanceGame($gameId, $gameCid, $conn)
    {
        $sql = "UPDATE games SET gamesCid = ?, gamesBegun = ?, gamesTimer = ?, gamesPlayers = ? WHERE gamesId = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "iiis", $gameCid, 1, 180, game_handler::getPlayers($gameId, true));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function submitAnswer($userId, $gameId, $conn)
    {

    }
}