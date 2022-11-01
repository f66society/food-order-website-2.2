<?php
    //iclude constants.php file here
    include('../config/constants.php');

    // echo "Delete Page";
    //Check whether the id and image_name vlaue is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "Get value and delete";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the physical image file if available
        if($image_name !="")
        {
            //image is available so remove it
            $path="../images/category/".$iamge_name;
            //remove the image
            $remove=unlink($path);
            
            //if failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //set the session message
                $_SESSION['remove']="<div class='error'>Failed to remove category image</div>";
                //redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }

        //delete data from database
        //SQL Query to delete data from database
        $sql="DELETE FROM tbl_category WHERE id=$id";

        //execute th Query
        $res=mysqli_query($conn,$sql);

        //check whether the data is deleted from database or not
        if($res==true)
        {
            //set success message and redirect
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully";
            //redirect to Manage Admin page
            header('location:'.SITEURL.'admin/manage-category.php');
            
        }
        else
        {
            //set fail message and redirect
            $_SESSION['delete']="<div class='error'>Failed to Delete Category.";
            //redirect to Manage Admin page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }
?>