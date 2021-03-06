<?php include_once("header.php") ?>

<div class="container">
    <div class="col-xl-5 col-md-8">
        <form class="bg-dark" action="includes/onboard.inc.php" method="post"> <!--onboard php post-->
            <!--login form begin--> 
            <!--email input-->
            <div class="form-outline mb-4">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="text" id="form-email" class="form-control">
            </div>
            <!--Password input-->
            <div class="form-outline mb-4">
                <label for="login" class="form-label">Password</label>
                <input name="login" type="password" id="form-pwd" class="form-control">
            </div>
            <!--Forgot pwd & Sign up-->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <div class="col text-center">
                        <!-- forgot password -->
                        <a href="">Forgot password?</a>
                    </div>
                    <div class="col text-center">
                        <!-- link to register page -->
                        <a href="">New User?</a>
                    </div>
            <!--Sign In Button-->
                   <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </div>
        </form>
        <!--register form-->
        <form class="bg-dark" action="includes/onboard.inc.php" method="post">
            <!--name input-->
            <div class="form-outline mb-4">
                <label for="name" class="form-label">Name</label>
                <input name="name" type="text" id="form-email" class="form-control">
            </div>
            <!--uid input-->
            <div class="form-outline mb-4">
                <label for="uid" class="form-label">Username</label>
                <input name="uid" type="text" id="form-uid" class="form-control">
            </div>
             <!--email input-->
             <div class="form-outline mb-4">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="text" id="form-email" class="form-control">
            </div>
            <!--Password input-->
            <div class="form-outline mb-4">
                <label for="pwd" class="form-label">Password</label>
                <input name="pwd" type="password" id="form-pwd" class="form-control">
            </div>
            <!--Password confirm-->
            <div class="form-outline mb-4">
                <label for="pwd2" class="form-label">Confirm Password</label>
                <input name="pwd2" type="password" id="form-pwd" class="form-control">
            </div>
            <!--Sign up button-->
            <div class="row mb-4">
                <div class="col d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
</div>
