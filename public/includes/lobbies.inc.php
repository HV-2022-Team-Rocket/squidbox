<?php

session_start();

if (!isset($_SESSION["userId"]))
{
    header("location: ../login.php");
    exit();
}

if (isset(_GET["new"]))
{
    //generate new game
}