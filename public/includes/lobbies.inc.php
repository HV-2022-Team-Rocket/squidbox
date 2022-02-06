<?php

session_start();

require_once('../../classes/db_handler.class.php');
require_once('../../classes/user_handler.class.php');
require_once('../../classes/game_handler.class.php');

if (!isset($_SESSION["userId"]))
{
    header("location: ../login.php");
    exit();
}

if (isset($_GET["new"]))
{
    $conn = new db_handler();

    $gameId = game_handler::generateGame($conn);
    header("location: ../test/lobby.php?gameId=".$gameId);

    $conn::closeHandle();
    exit();
}