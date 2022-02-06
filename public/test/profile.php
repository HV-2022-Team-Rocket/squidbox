<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test: profile</title>

    <?php 

        if (!isset($_SESSION["userId"]))
        {
            header("location: onboard.php");
        }

        else
        {
            echo "<h1>".$_SESSION["userUid"]."</h1>";
        }
    ?>
</head>
<body>
</body>
</html>