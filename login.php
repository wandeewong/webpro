<?php
    session_start();
    require('connect.php');
    require('function.php');
    
    if(isset($_SESSION['id']))
    {
        header("Location:index.php");
    }

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_encode = hash_hmac('sha256',$password,"as1d56asd1as56d1as56d1as56d1gre561g5fds6");
        $sql = "SELECT id_member,status FROM tb_members WHERE username=? AND password=?";
        $prepare = $conn->prepare($sql);
        $prepare->bind_param('ss',$username,$password_encode);
        $prepare->execute();

        $result_user = $prepare->get_result();

            if($result_user->num_rows == 1)
            {
                $user = $result_user->fetch_assoc();
                $_SESSION['id'] = $user['id_member'];
                $_SESSION['status'] = $user['status'];
                if($user['status'] == "admin")
                {
                    alert("เข้าสู่ระบบเสร็จสิ้น!","admin.php");
                }
                else
                {
                    alert("เข้าสู่ระบบเสร็จสิ้น!","index.php");
                }
            }
            else
            {
                alert("ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง!","login.php");
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
            <div class="panel-heading text-center">เข้าสู่ระบบ</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="email" name="username" placeholder="Text@gmail.com" required class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" pattern=".{8,}" name="password" placeholder="รหัสผ่าน ต้องมีจำนวน 8 ตัวขึ้นไป" required class="form-control" id="password">
                </div>
                <input type="submit" class="btn btn-success btn-block" name="login" value="เข้าสู่ระบบ">
                <a href="index.php" class="btn btn-danger btn-block">กลับ</a>
            </div>
            <div class="panel-footer text-center">
             <a href="register.php">สมัครสมาชิก</a>
             หรือ
             <a href="forget.php">ลืมรหัสผ่าน</a>
            </div>
        </div>
    </div>
</form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>