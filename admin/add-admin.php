<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
                    if(isset($_SESSION['add'])) //Checking whether the session is set or not
                    {
                        echo $_SESSION['add']; //Displaying session message
                        unset($_SESSION['add']); //Removing session message
                    }
                ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>

                <tr>
                    <td colsapn="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php
    //prcocess the value form and save it in database

    //check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Clicked
        //echo "Button Clicked";

        //1.Get the data from form
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']);//Password Encription with md5

        //2.SQL Query to save the data into database
        $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
        //3.Executing Query and saving data into database    
        $res=mysqli_query($conn,$sql) or die(mysqli_error());

        //4.Check whether the (Query is Executed) data is inserted or not and dispaly appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //create a session variable to display message
            $_SESSION['add']="<div class='success'>Admin Added Successfully.</div>";
            //redirect page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Failed to insert Data
            //echo "Failed to Insert Data";
            //create a session variable to display message
            $_SESSION['add']="Failed to Add Admin";
            //redirect page to Add Admin
            header("location:".SITEURL/'admin/add-admin.php');
        }

    }
 
?>