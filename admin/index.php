<html>
    <body>
        <?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>
                <br><br>
                <?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br><br>

                <div class="col-4 text-center">

                <?php
                    //SQL Query
                    $sql="SELECT*FROM tbl_category";
                    //Execute the Query
                    $res=mysqli_query($conn,$sql);
                    //Count rows
                    $count=mysqli_num_rows($res);
                ?>
                    <h1><?php echo $count; ?></h1>
                    <br/>
                    Categories
                </div>

                <div class="col-4 text-center">

                <?php
                    //SQL Query
                    $sql2="SELECT*FROM tbl_food";
                    //Execute the Query
                    $res2=mysqli_query($conn,$sql2);
                    //Count rows
                    $count2=mysqli_num_rows($res2);
                ?>
                    <h1><?php echo $count2; ?></h1>
                    <br/>
                    Foods
                </div>

                <div class="col-4 text-center">

                <?php
                    //SQL Query
                    $sql3="SELECT*FROM tbl_order";
                    //Execute the Query
                    $res3=mysqli_query($conn,$sql3);
                    //Count rows
                    $count3=mysqli_num_rows($res3);
                ?>
                    <h1><?php echo $count3; ?></h1>
                    <br/>
                    Total Orders
                </div>

                <div class="col-4 text-center">

                <?php
                    //Create SQL Query to get total revenue generated
                    //Aggregate function in SQL
                    $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

                    //Execute the Query
                    $res4=mysqli_query($conn,$sql4);

                    //Get the value
                    $row4=mysqli_fetch_assoc($res4);

                    //Get the Total revenue
                    $total_revenue=$row4['Total'];

                ?>
                    <h1>$<?php echo $total_revenue; ?></h1>
                    <br/>
                    Revenue Generated
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main Content Section Ends -->

        <?php include('partials/footer.php'); ?>
    </body>
</html>