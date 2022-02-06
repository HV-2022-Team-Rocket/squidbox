<?php

require_once('../../classes/game_handler.class.php');

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
    
        mysqli_stmt_bind_param($stmt, "iiis", 1, 0, 180, "none");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $last_id = $conn->getHandle()->insert_id;
    }

    public static function addPlayer($gameId, $userId)
    {
        $players = $game_handler::getPlayers($gameId);

        if ($players !== false)
        {
            $players = array(); 
        }

        $players[strval($userId)] = 0;
        game_handler::playersToGame($players);
    }

    public static function playersToGame($players, $gameId)
    {
        $playersSerial = serialize($players);

        $sql = "UPDATE games SET gamesPlayers = ? WHERE gamesId = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "si", $playersSerial, $gameId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function advanceGame($gameId, $conn)
    {
        $players = game_handler::getPlayers();

        if (count($players) <= 1)
        {
            game_handler::endGame();
            exit();
        }

        $gameRow = game_handler::getGameData($gameId);
        $sql = "UPDATE games SET gamesCid = ?, gamesBegun = ?, gamesTimer = ?, gamesPlayers = ? WHERE gamesId = ?;";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "iiis", $gameRow["gamesCid"] + 1, 1, 180, game_handler::getPlayers());
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public static function endGame($gameId, $players)
    {
        $playerIds = array_keys($players);

        foreach ($keys as $key) 
        {
            user_handler::userAddScore(180, user_handler::getUser(intval($get))["usersScore"], intval($key));
        }

        $sql = "DELETE FROM games WHERE gamesId = ?";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "i", $gameId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }

    public static function submitAnswer($response, $userId, $gameId, $conn)
    {
        $challenge = game_handler::getChallenge($gameId);
        
        if ($response == $challenge["testsKey"])
        {
            $gameRow = game_handler::getGameData();
        }
    }

    public static function getPlayers($gameId)
    {
        $players = array();
        $gameRow = game_handler::getGameData();
        $players = unserialize($gameRow["gamePlayers"]);

        if (!empty($players))
        {
            return players;
        }

        else
        {
            return false;
        }
    }

    public function getGameData($gameId)
    {
        $sql = "SELECT * from games WHERE gamesId = ?";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "i", $gameId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }
        
        mysqli_stmt_close($stmt);
    }

    public static function getChallenge($gameId)
    {
        $gameRow = game_handler::getGameData($gameId);

        $sql = "SELECT * from tests WHERE testsId = ?";
        $stmt = mysqli_stmt_init($conn->getHandle());
    
        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            user_handler::throwDbError();
        }
    
        mysqli_stmt_bind_param($stmt, "i", $gameRow["gamesCid"]);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result))
        {
            return $row;
        }
        
        mysqli_stmt_close($stmt);
    }
}