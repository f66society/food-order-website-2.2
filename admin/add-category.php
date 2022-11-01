<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_SESSION['add']; //Displaying session message
                unset($_SESSION['add']); //Removing session message
            }

            if(isset($_SESSION['upload'])) //Checking whether the session is set or not
            {
                echo $_SESSION['upload']; //Displaying session message
                unset($_SESSION['upload']); //Removing session message
            }
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colsapn="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add Category Form Ends -->

        <?php
        //prcocess the value form and save it in database

        //check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //Button Clicked
            //echo "Button Clicked";

            //1.Get the value from category form
            $title=$_POST['title'];

            //for radio input,we need to check whether the buttton is selected or not
            if(isset($_POST['featured']))
            {
                //get the value from form
                $featued=$_POST['featured'];
            }
            else
            {
                //set the default value
                $featured="No";
            }

            if(isset($_POST['active']))
            {
                //get the value from form
                $active=$_POST['active'];
            }
            else
            {
                //set the default value
                $active="No";
            }

            //check whether the image is selected or notand set the value of the image name accordingly
            //print_r($_FILES['image']);

            //die();//break the code here
            if(isset($_FILES['image']['name']))
            {
                //upload the image
                //to upload image wwe need need image name,source path and destination path
                $image_name=$_FILE['image']['name'];

                //upload the image only if image is selected
                if($image_name !="")
                {

                    //Auto rename our image
                    //Get the extension of our image (jpg,png,gif,etc) e.g. "food1.jpg"
                    $ext=end(explode('.',$image_name));

                    //Rename the image
                    $image_name="Food_Category_".rand(000,999).'.'.$ext; // e.g. Food_Category_834.jpg

                    $source_path=$_FILE['image']['tmp_name'];

                    $destination_path="../images/category/".$image_name;

                    //Finally upload the image
                    $upload=move_uploaded_file($source_path,$destination_path);

                    //check whether the image is uploaded or not
                    //if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload==false)
                    {
                        //set message
                        $_SESSION[upload]="<div class='error'>Failed to upload image.</div>";
                        //redirect to Add Category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop the process
                        die();
                    }
                }
            }
            else
            {
                //dont upload the image set the image value as blank
                $image_name="";
            }

            //2.Create SQL Query to insert Category into database
            $sql="INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                ";
            //3.Execute the Query and save in database    
            $res=mysqli_query($conn,$sql);

            //4.Check whether the (Query is Executed) data is inserted or not and dispaly appropriate message
            if($res==TRUE)
            {
                //Query executed and Category added
                $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                //redirect page to Manage Category
                header("location:".SITEURL.'admin/manage-category.php');
            }
            else
            {
                //Failed to add Category
                $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
                //redirect page to add Category
                header("location:".SITEURL.'admin/add-category.php');
            }

        }
    
    ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>


