<?php

require_once('../../classes/db_handler.class.php');
require_once('../../classes/user_handler.class.php');

if (isset($_POST["submit"]))
{
    $conn = new db_handler();

    if (isset($_POST["login"]))
    {
        $user = new login_info($_POST);
        $resp = $user->validateData();

        if ($resp !== "none")
        {
            header("location: ../login.php?error=".$resp);
        }

        else if (user_handler::loginUser($user, $conn) === true)
        {
            header("location: ../index.phplol");
        }
    
        else
        {
            header("location: ../login.php?error=invalid_login");
        }
    }

    else if (isset($_POST["uid"]))
    {
        $user = new register_info($_POST);
        $resp = $user->validateData();

        if ($resp !== "none")
        {
            header("location: ../login.php?error=".$resp);
        }

        else if (user_handler::uidExists($user->userUid, $conn) !== false)
        {
            header("location: ../login.php?error=uid_exists");
        }
    
        else if (user_handler::emailExists($user->email, $conn) !== false)
        {
            header("location: ../login.php?error=email_exists");
        }

        else
        {
            user_handler::registerNewUser($user, $conn);
            header("location: ../login.php?signup=true");
        }
    }

    $conn::closeHandle();
    exit();
}

else if (isset($_GET["logout"]) && $_GET["logout"] == "true")
{
    session_start();
    session_unset();
    session_destroy();

    header("location: ../index.php");
    exit();
}

else
{
    session_start();

    if (isset($_SESSION["userId"]))
    {
        header("location: ../index.php");
        exit();
    }

    else
    {
        session_unset();
        session_destroy();
        
        header("location: ../login.php");
        exit();
    }
}