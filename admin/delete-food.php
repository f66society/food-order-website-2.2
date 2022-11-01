<?php
    //iclude constants.php file here
    include('../config/constants.php');

    //echo "Delete Food page";

    if(isset($_GET['id']) && isset($_GET['image_name'])) //either use '&&' or 'AND'
    {
        //process to delete
        //echo "process to delete";

        //1.get ID and image name
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //2.remove the image if available
        //check whether the image is available or not and delete only if available
        if($image_name!="")
        {
            //It has image and need to remove from folder
            //get the image path
            $path="../images/food/".$iamge_name;

            //remove the image file from folder
            $remove=unlink($path);
            
            //checker whether the image is removed or not 
            if($remove==false)
            {
                //failded to remove image
                $_SESSION['upload']=<"div class='error>Failed to Remove Image File</div>"
                //redirect to Mange Food Page
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process of deleting food
                die();
            }
        }

        //3.delete data from database
        $sql="DELETE FROM tbl_food WHERE id=$id";
        //execute th Query
        $res=mysqli_query($conn,$sql);

        //check whether the query executed or not and set the sesssion message respectively
        if($res==true)
        {
            //food deleted
            $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            
        }
        else
        {
            //failed to delete food
            $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        //redirect to Manage Food Page
        //echo "redirect";
        $_SESSION['unauthorize']="<div class='error'>Unauthorised Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>