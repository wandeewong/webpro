<?php
    require('connect.php');
    session_start();
    require('function.php');
   if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
    {
        header('Location:index.php');
    }

    if(isset($_POST['add']))
    {
        $name_group = $_POST['name_group'];


        $id = $_GET['id'];
        $insert = UPDATE($conn,'tb_groups',"name_group='$name_group'","id_group = $id");
        if($insert)
        {
            alert('แก้ไขหมวดหมู่สินค้าสำเร็จ','admin_group.php');
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการแก้ไขหมวดหมู่สินค้า!','edit_group.php');
        }
    }

    $id = $_GET['id'];
    $sql_group = SELECT_ID($conn,'tb_groups',"id_group = $id");
    $groups= $sql_group->fetch_assoc();
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
            <div class="panel-heading text-center">แก้ไขหมวดหมู่สินค้า</div>
            <div class="panel-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name_group">หมวดหมู่สินค้า</label>
                        <input type="text" name="name_group" id="name_group" required placeholder="ชื่อของหมวดหมู่สินค้าที่ต้องการแก้ไข" value="<?php echo $groups['name_group'];?>" class="form-control" >
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="admin_group.php" class="btn btn-danger">กลับ</a>
                    <input type="submit" class="btn btn-success" value="แก้ไขหมวดหมู่สินค้า" name="add" id="add" onclick="return confirm('คุณต้องการแก้ไขหมวดหมู่สินค้า ใช่ หรือ ไม่')">
                </form>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>