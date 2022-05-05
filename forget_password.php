<?php
    session_start();
    require('connect.php');
    require('function.php');

    
    if(empty($_GET['id']))
    {
        header("Location:index.php");
    }
    if(isset($_SESSION['id']))
    {
        header("Location:index.php");
    }

    if(isset($_POST['login']))
    {
        $username = $_GET['id'];
        $number = $_POST['number'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if($password1 == $password2)
        {
            $check = SELECT_ID($conn,"tb_members","username = '$username' AND reset_number = '$number'");
            if($check->num_rows == 1)
            {
                $password_encode = hash_hmac('sha256',$password2,"as1d56asd1as56d1as56d1as56d1gre561g5fds6");
                $UPDATE = UPDATE($conn,"tb_members","password = '$password_encode'","username= '$username'");
                if($UPDATE)
                {
                    $UPDATE = UPDATE($conn,"tb_members","reset_number = ''","username= '$username'");
                    alert("เปลื่ยนรหัสผ่านเสร็จสิ้น!","login.php");
                }
                else
                {
                    alert("เกิดข้อผิดพลาดในการเปลื่ยนรหัสผ่าน!","forget_password.php?id=".$username);
                }
            }
            else
            {
                alert("หมายเลขไม่ถูกต้อง!","forget_password.php?id=".$username);
            }
        }
        else
        {
            alert("รหัสผ่านไม่ตรงกัน!","forget_password.php?id=".$username);

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
    

    <form action="" method="post">
    <div class="container">
        <div class="panel panel-primary" style="margin:0 auto;width: 500px; margin-top: 20px; margin-bottom: 20px;">
            <div class="panel-heading text-center">กู้คืนรหัสผ่าน</div>
            <div class="panel-body">
            <div class="form-group">
                    <label for="number">หมายเลขยืนยัน</label>
                    <input type="text" pattern="[0-9]{4}" name="number" placeholder="หมายเลขยืนยันต้องมีจำนวน 4 ตัวเท่านั้น" required class="form-control" id="number">
                </div>
            <div class="form-group">
                    <label for="password1">รหัสผ่าน ใหม่</label>
                    <input type="password" pattern=".{8,}" name="password1" placeholder="รหัสผ่าน ต้องมีจำนวน 8 ตัวขึ้นไป" required class="form-control" id="password1">
                </div>
            <div class="form-group">
                    <label for="password2">ยืนยันรหัสผ่าน</label>
                    <input type="password" pattern=".{8,}" name="password2" placeholder="รหัสผ่าน ต้องมีจำนวน 8 ตัวขึ้นไป" required class="form-control" id="password2">
                </div>
                <input type="submit" onclick="return confirm('คุณต้องการที่จะเปลื่ยนรหัสผ่าน ใช่ หรือ ไม่?');" class="btn btn-success btn-block" name="login" value="ยืนยัน">
                <a href="forget.php" class="btn btn-danger btn-block">กลับ</a>
            </div>
        </div>
    </div>
</form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>