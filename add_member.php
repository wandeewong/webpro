<?php
    session_start();
    require('connect.php');
    require('function.php');
    
    if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
    {
        header('Location:index.php');
    }

    if(isset($_POST['register']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $status = $_POST['status'];

        $check = SELECT_ID($conn,"tb_members","username = '$username'");
        if($check->num_rows == 0)
        {
            $password_encode = hash_hmac('sha256',$password,"as1d56asd1as56d1as56d1as56d1gre561g5fds6");
            $INSERT = INSERT($conn,"tb_members","username,password,firstname,lastname,address,tel,status","'$username','$password_encode','$firstname','$lastname','$address','$tel','$status'");
            if($INSERT)
            {
                alert("เพิ่มสมาชิกเสร็จสิ้น!","admin_member.php");
            }
            else
            {
                alert("เกิดข้อผิดพลาดในการเพิ่มสมาชิก!","add_member.php");
            }
        }
        else
        {
            alert("ชื่อผู้ใช้นี้ถูกใช้งานแล้ว!","add_member.php");
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
            <div class="panel-heading text-center">เพิ่มสมาชิก</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="email" name="username" placeholder="Text@gmail.com" required class="form-control" id="username">
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" pattern=".{8,}" name="password" placeholder="รหัสผ่าน ต้องมีจำนวน 8 ตัวขึ้นไป" required class="form-control" id="password">
                </div>
                <div class="form-group">
                    <label for="firstname">ชื่อจริง</label>
                    <input type="text" name="firstname" placeholder="ชื่อจริง" required class="form-control" id="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">นามสกุล</label>
                    <input type="text" name="lastname" placeholder="นามสกุล" required class="form-control" id="lastname">
                </div>
                <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <textarea name="address" id="address" cols="5" class="form-control" rows="5" placeholder="ที่อยู่ของท่าน" required></textarea>
                </div>
                <div class="form-group">
                    <label for="tel">เบอร์โทร</label>
                    <input type="text" name="tel" pattern="[0-9]{10}" placeholder="เบอร์โทร (08XXXXXXXX)" required class="form-control" id="tel">
                </div>
                <div class="form-group">
                    <label for="status">สถานะ</label>
                    <input type="radio" name="status" id="member" value="member">
                    <label for="member">Member</label>
                    <input type="radio" name="status" id="admin" value="admin">
                    <label for="admin">Admin</label>
                    
                </div>
            </div>
            <div class="panel-footer text-center">
                <input type="submit" class="btn btn-success" name="register" onclick="return confirm('คุณต้องการที่จะเพิ่มสมาชิก ใช่ หรือ ไม่ ?');" value="เพิ่มสมาชิก">
                <a href="admin_member.php" class="btn btn-danger">กลับ</a>
            </div>
        </div>
    </div>
</form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>