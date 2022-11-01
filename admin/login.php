<?php include('../config/constants.php'); ?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>

        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form Starts Here -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Starts Here -->
            
            <p class="text-center">Created By - <a href="www.iankimori.com">Ian Kimori</a></p>
        </div>

    </body>
</html>

<?php

    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for Login
        //1.get the data from login form
        //$username=$_POST['username'];
        //$password=md5($_POST['password']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);

        $raw_password=md5($_POST['password']);
        $password=mysqli_real_escape_string($conn,$raw_password);

        //2.SQL to check whether the user with username and password exist or not
        $sql="SELECT*FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3.execute the query
        $res=mysqli_query($conn,$sql);

        //4.count rows to check whether the user exist or not
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            //user available and login success
            $_SESSION['login']="<div class='success'>Login Successful.</div>";
            $_SESSION['user']=$username; //to check whether the user is logged in or not and logout will unset it

            //redirect to Home page/Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available and login fail
            $_SESSION['login']="<div class='error text-center'>Username or Password did not match.</div>";
            //redirect to Home page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }

    }
?>