<?php

session_start();

require_once('../../classes/db_handler.class.php');
require_once('../../classes/user_handler.class.php');
require_once('../../classes/poem_handler.class.php');

if (isset($_SESSION["UserId"]))
{
    $conn = new db_handler();
    if (isset($_GET["new"]))
    {  
        poem_handler::uploadPoem($_SESSION["userId"], $_GET["newpoem"], $_GET["title"], $conn);
        header("location: ../poem.php");
        exit();
    }

    conn->closeHandle();
}

else
{
    header("location: ../login.php");
    exit();
}