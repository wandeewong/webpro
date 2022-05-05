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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $status = $_POST['status'];

        $id=$_GET['id'];
            $INSERT = UPDATE($conn,"tb_members","firstname='$firstname',lastname='$lastname',address='$address',tel='$tel',status='$status'","id_member = $id");
            if($INSERT)
            {
                alert("แก้ไขสมาชิกเสร็จสิ้น!","admin_member.php");
            }
            else
            {
                alert("เกิดข้อผิดพลาดในการแก้ไขสมาชิก!","admin_member.php");
            }
        
    }
    $id=$_GET['id'];
        $sql_profile= SELECT_ID($conn,'tb_members',"id_member = $id");
        $profile = $sql_profile->fetch_assoc();
        
    
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
            <div class="panel-heading text-center">แก้ไขข้อมูลสมาชิก</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="firstname">ชื่อจริง</label>
                    <input type="text" name="firstname" placeholder="ชื่อจริง" value="<?php echo $profile['firstname']; ?>" required class="form-control" id="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">นามสกุล</label>
                    <input type="text" name="lastname" placeholder="นามสกุล" value="<?php echo $profile['lastname']; ?>" required class="form-control" id="lastname">
                </div>
                <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <textarea name="address" id="address" cols="5" class="form-control" rows="5" placeholder="ที่อยู่ของท่าน" required><?php echo $profile['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="tel">เบอร์โทร</label>
                    <input type="text" name="tel" pattern="[0-9]{10}" placeholder="เบอร์โทร (08XXXXXXXX)" required class="form-control" value="<?php echo $profile['tel']; ?>" id="tel">
                </div>
                <div class="form-group">
                    <label for="status">สถานะ</label>
                    <select name="status" id="status" class="form-control" >
                        <option value="<?php echo $profile['status']; ?>"><?php echo $profile['status']; ?></option>
                        <option value="member">member</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
            </div>
            <div class="panel-footer text-center">
                <a href="admin_password.php?id=<?php echo $profile['id_member']; ?>" class="btn btn-info">แก้ไขรหัสผ่าน</a>
                <input type="submit" class="btn btn-success" name="register" onclick="return confirm('คุณต้องการที่จะแก้ไขข้อมูลสมาชิก ใช่ หรือ ไม่ ?');" value="แก้ไขข้อมูลสมาชิก">
                <a href="admin_member.php" class="btn btn-danger">กลับ</a>
            </div>
        </div>
    </div>
</form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>