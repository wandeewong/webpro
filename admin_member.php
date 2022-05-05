<?php
require('connect.php');
session_start();
require('function.php');
if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
{
    header('Location:index.php');
}
if(!empty($_GET['id']))
{
    $id = $_GET['id'];
    $del = DELETE($conn,'tb_members',"id_member=$id");
    if($del)
    {
        alert('ลบผู้ใช้นี้เรียบร้อยแล้ว','admin_member.php');
    }
    else
    {
        alert('เกิดข้อผิดพลาดในการลบผู้ใช้นี้!','admin_member.php');
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
    .container{
        width:95%;
    }
</style>
<body>

    <div class="container">
        <div class="text-right" style="margin-top: 10px;">
            <a href="add_member.php" class="btn btn-primary">เพิ่มสมาชิก</a>
            <a href="admin.php" class="btn btn-danger">กลับสู่หน้าหลัก</a>
        </div>
        <div class="col-lg-3">
            <form action="admin_member.php" method="get">
            <input type="text" name="search" class="form-control" placeholder="ค้นหาผู้ใช้จาก ชื่อผู้ใช้ ชื่อจริง และนามสกุล ที่ใกล้เคียง">
            <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></button>
        </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading text-center">รายชื่อสมาชิก</div>
                <table class="table table-hover">
                    <tr>
                        <th class="text-center" width = 7%>ลำดับ</th>
                        <th class="text-center" width = 10%>ชื่อผู้ใช้</th>
                        <th class="text-center" width = 10%>ชื่อจริง</th>
                        <th class="text-center" width = 10%>นามสกุล</th>
                        <th class="text-center" width = 15%>ที่อยู่</th>
                        <th class="text-center" width = 10%>เบอร์โทรศัพท์</th>
                        <th class="text-center" width = 10%>สถานะ</th>
                        <th class="text-center" width = 10%>จัดการ</th>
                    </tr>
                    <?php

                        if(!empty($_GET['search']))
                        {
                            $search = $_GET['search'];
                            $sql_product = "SELECT * FROM tb_members WHERE username LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
                        }
                        else
                        {
                            $sql_product = "SELECT * FROM tb_members";
                        }
                        $query_product = $conn->query($sql_product);
                        $no=1;
                        while($product = $query_product->fetch_assoc())
                        {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $no++;?></td>
                        <td><?php echo $product['username'];?></td>
                        <td><?php echo $product['firstname'];?></td>
                        <td><?php echo $product['lastname'];?></td>
                        <td><?php echo $product['address'];?></td>
                        <td><?php echo $product['tel'];?></td>
                        <td><?php echo $product['status'];?></td>
                        <td>
                            <a href="admin_member.php?id=<?php echo $product['id_member'];?>" onclick="return confirm('คุณต้องการลบชื่อผู้ใช้นี้ ใช่ หรือ ไม่')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            <a href="edit_member.php?id=<?php echo $product['id_member'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
    

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>