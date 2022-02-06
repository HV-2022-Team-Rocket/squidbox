<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test: Onboarding</title>
</head>
<body>
    <form action="../includes/onboard.inc.php" method="post">
        <label for="uid">Username:</label>
        <input type="text" name="uid"><br>
        <label for="name">Name:</label>
        <input type="text" name="name"><br>
        <label for="email">Email:</label>
        <input type="text" name="email"><br>
        <label for="pwd">Pass:</label>
        <input type="password" name="pwd"><br>
        <label for="pwd2">Repeat Pass:</label>
        <input type="password" name="pwd2"><br>
        <button type="submit" name="submit">Register</button>
    </form>
    <form action="../includes/onboard.inc.php" method="post">
        <label for="login">Username or email:</label>
        <input type="text" name="login"><br>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd"><br>
        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>

<style>
    label
    {
        float: left;
    }

    input
    {
        float: right;
        margin-left: 30px;
    }

    form
    {
        border: 2px solid black;
        border-radius: 10px;
        margin: 0 auto;
        margin-top: 20px;
        padding: 5px;
        width: 350px;
    }

    button
    {
        width: 100%;
    }
</style>