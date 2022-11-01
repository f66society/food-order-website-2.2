<?php include('partials/menu.php'); ?>

<?php
    //check whether the ID is set or not
    if(isset($_GET['id'])) //Checking whether the session is set or not
    {
        //get all the details
        $id=$_GET['id'];

        //SQL Query to get the Food
        $sql2="SELECT*FROM tbl_food WHERE id=$id";
        //execute the Query
        $res2=mysqli_query($conn,$sql2);

        //get the value based on query executed
        $row2=mysqli_fetch_assoc($res2);

        //get the individual values of selected Food
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['current_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];

    }
    else
    {
        //redirect to Mange Food
        header('location'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <!-- Update Food Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description ?>"</textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                                if($current_image="")
                                {
                                    //image not available
                                    echo "<div class='error'>Image Not Available.</div>";
                                }
                                else
                                {
                                    //image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                    <?php
                                    echo <"div class='error'>Image Not Added</div>";
                                }
                            ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                        <?php
                            //Query to get active categories
                            $sql="SELECT*FROM tbl_category WHERE active+'Yes'";
                            //execute the Query
                            $res=mysqli_query($conn,$sql2);
                            //count the rows
                            $count=mysqli_num_rows($res);

                            //check whether category available or not
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title=$row['title'];
                                    $category_id=$row['id'];

                                    //echo "<option value='$category_title'>$category_title</option>";
                                    ?>
                                    option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>;
                                    <?php
                                }
                               
                            }
                            else
                            {
                                //category not available
                                echo "<option value='0'>Category Not Available</option>"
                                //redirect to Manage Category with session messsage
                                $_SESSION['no-category-found']="<div class='error>Category Not Found.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                            }
                        ?>
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featuted" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Update Food Form Ends -->

        <?php

        if(isset($_POST['submit']))
        {
            //echo "Button Clicked";

            //1.get all the details from the form
            $id=$_POST['id'];
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $current_image=$_POST['current_image'];
            $category=$_POST['category'];

            $featured=$_POST['featured'];
            $active=$_POST['active'];

            //2.upload the image if selected

            //check whether upload button is clicked or not
            if(isset($_FILES['image']['name']))
            {
                //upload button clicked
                $image_name=$_FILE['image']['name'];

                //check whether the file is availble or not
                if($image_name!="")
                {
                    //image iis available
                    //A.uploading new image
                    //Get the extension of our image (jpg,png,gif,etc) e.g. "food1.jpg"
                    $ext=end(explode('.',$image_name));

                    //Rename the image
                    $image_name="Food_Name".rand(000,999).'.'.$ext; //this will be renamed image

                    //get the source path and destination path
                    $src_path=$_FILE['image']['tmp_name'];
                    $dst_path="../images/food/".$image_name;

                    //upload the image
                    $upload=move_uploaded_file($src_path,$dst_path);

                    //check whether the image is uploaded or not
                    if($upload==false)
                    {
                        //fail to upload
                        $_SESSION[upload]="<div class='error'>Failed to upload new image.</div>";
                        //redirect to Add Food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                        //stop the process
                        die();
                    }
                    
                    //3.Remove the image if new image is uploaded and current image exists
                    //B.remove current image if available
                    if($current_image!="")
                    {
                        //current image is available
                        $remove_path="../images/food".$current_image;

                        $remove=unlink($remove_path);

                        //check whether the image is removed or not
                        if($remove==false)
                        {
                            //failed to remove image
                            $_SESSION['remove-failed']="<div class='error'>Failed to remove current image.</div>";
                            //redirect to Manage Food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name=$current_image; //default image when image is not selected
                }
            }
            else
            {
                $image_name=$current_image;  //default image when button is not clicked
            }

            //4.update the Food in database
            $sql3="UPDATE tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category'
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";
                //execute the SQL Query
                $res3=mysqli_query($conn,$sql3);

                //check whether the query is executed or not
                if($res3==true)
                {
                    //Query executed and Food Updated
                    $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update Food
                    $_SESSION['add']="<div class='error'>Failed to Update Food.</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }

        }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>