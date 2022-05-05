<?php
    session_start();
    require('connect.php');
    require('function.php');
    if(!isset($_SESSION['id'],$_SESSION['status']) && $_SESSION['status'] != "admin")
    {
        header("Location:index.php");
    } 

    if(isset($_POST['add']))
    {
        $name_group = $_POST['name_group'];

        $insert = INSERT($conn,'tb_groups','name_group',"'$name_group'");
        if($insert)
        {
            alert('เพิ่มหมวดหมู่สินค้าสำเร็จ','add_group.php');
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการเพิ่มหมวดหมู่สินค้า!','add_group.php');
        }
    }
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
</style>
<body>
    <div class="contanier">
        <div class="panel panel-primary" style="margin: 0 auto; width: 500px; margin-top: 50px;">
            <div class="panel-heading text-center">เพิ่มหมวดหมู่สินค้า</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name_group">หมวดหมู่สินค้า</label>
                        <input type="text" name="name_group" id="name_group" required placeholder="ชื่อของหมวดหมู่สินค้าที่ต้องการเพิ่ม" class="form-control" >
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="admin_group.php" class="btn btn-danger">กลับ</a>
                    <input type="submit" class="btn btn-success" value="เพิ่มหมวดหมู่สินค้า" name="add" id="add" onclick="return confirm('คุณต้องการเพิ่มหมวดหมู่สินค้า ใช่ หรือ ไม่')">
                </form>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>