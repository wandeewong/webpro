<?php
    session_start();
    require('connect.php');
    require('function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BICYCLESHOP | good quality - fast delivery</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<style>
    html,body
    {
        background-color: rgb(100, 148, 161);
    }
    .container
    {
        width:95%;
    }
    .breadcrumb{
        background-color: #337ab7;
    }
    .breadcrumb a{
        color:white;
    }
    .dropdown:hover .dropdown-menu
    {
        display: block;
        margin-top: 0;
    }
</style>
<body>
    
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php include('group.php'); ?>
            </div>
            <div class="col-lg-9">
                    <?php include('nav.php'); ?>

                    <div class="panel panel-primary" style="margin-top: 20px;">
                        <div class="panel-heading">วิธีสั่งซื้อ</div>
                        <div class="panel-body">
                           <div class="text-center">
                               <img src="Images/UI/cont.jpg" alt="No Image" width="500px">
                           </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>