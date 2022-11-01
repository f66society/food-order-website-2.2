<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload'])) //Checking whether the session is set or not
            {
                echo $_SESSION['upload']; //Displaying session message
                unset($_SESSION['upload']); //Removing session message
            }
        ?>

        <br><br>

        <!-- Add Food Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <slect name="Category">

                            <?php
                                //create php coded to display categories from database
                                //1.create SQL Query to get all active categories from database
                                $sql="SELECT*FROM tbl_categpory WHERE active='Yes'";

                                //Executing Query
                                $res=mysqli_query($conn,$sql);

                                //count rows to check whether we have categories or not
                                $count=mysqli_num_rows($res);

                                //if count is greater than zero,we have categories esle we do not have categories
                                if($count>0)
                                {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $id=$row['id'];
                                        $title=$row['title'];
                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not have categories
                                    ?>
                                    <option value="0">No category Found</option>
                                    <?php

                                }

                                //2.Display on dropdown
                                ?>

                            </select>        
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add Food Form Ends -->

        <?php

        //check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //add the food in database
            //echo "Button Clicked";

            //1.Get the data from form
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $category=$_POST['category'];

            //check whether radio buttton for featured and active is checked or not
            if(isset($_POST['featured']))
            {
                $featued=$_POST['featured'];
            }
            else
            {
                $featured="No"; //set the default value
            }

            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {   
                $active="No"; //set the default value
            }
            
            //2.Upload the image if selected
            //check whether the select image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                //get the details of the selected image
                $image_name=$_FILE['image']['name'];

                //check whether the image is selected or not and upload image only if selected
                if($image_name!="")
                {

                    //image is selected
                    //A. rename the image
                    //Get the extension of selected image (jpg,png,gif,etc) "Ian Kimori.jpg" Ian-Kimori jpg
                    $ext=end(explode('.',$image_name));

                    //create new name for image
                    $image_name="Food-Name".rand(000,999).'.'.$ext; //new image name maybe "Food-Name-657.jpg"

                    //B.upload the image
                    //get the src path and destination path

                    //source path is the current loaction of the image
                    $src=$_FILE['image']['tmp_name'];

                    //destination path for the image to be uploaded
                    $dst="../images/food/".$image_name;

                    //Finally upload the food image
                    $upload=move_uploaded_file($src,$dst);

                    //check whether the image is uploaded or not
                    if($upload==false)
                    {
                        //Failed to upload the image
                        //redirect to Add Food page with error message
                        $_SESSION[upload]="<div class='error'>Failed to upload image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //stop the process
                        die();
                    }
                }
            }
            else
            {
                $image_name=""; //setting default value as blank
            }

            //3.Insert into database

            //create a SQL Query to save or add food
            //for numerical we do not need to pass value inside qoutes '' but for string value it is compulsory to add quotes
            $sql2="INSERT INTO tbl_food SET
                title='$title',
                description=$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'
                ";

            //Execute the Query
            $res2=mysqli_query($conn,$sql2);

            //Check whether the data is inserted or not
            //4.redirect with message to Manage Food page
            if($res2==TRUE)
            {
                //Data inserted successfully
                $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
                header("location:".SITEURL.'admin/manage-food.php');
            }
            else
            {
                //Failed to insert data
                $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                header("location:".SITEURL.'admin/manage-food.php');
            }

        }
    
    ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>