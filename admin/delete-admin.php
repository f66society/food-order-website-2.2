<?php
    //iclude constants.php file here
    include('../config/constants.php');

    //1.get the ID of Admin to be deleted
    $id=$_GET['id'];

    //2.create SQL Query to delete Admin
    $sql="DELETE FROM tbl_admin WHERE id=$id";

    //execute the Query
    $res=mysqli_query($conn,$sql);

    //check whether the query executed successfully or not
    if($res==true)
    {
        //Query executed successfully and admin deleted
        //echo "Admin Deleted";
        //create session variable to display message
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully";
        //redirect to Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //Failed to Delete Admin
        //echo "Failed to Delete Admin";

        $_SESSION['delete']="<div class='error'>Failed to Delete Admin.Try Again Later.";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3.redirect to Manage Admin page with message(success/error)
    
?>