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
    $del = DELETE($conn,'tb_groups',"id_group = $id");
    if($del)
    {
        alert('ลบหมวดหมู่สินค้านี้เรียบร้อยแล้ว','admin_group.php');
    }
    else
    {
        alert('เกิดข้อผิดพลาดในการลบหมวดหมู่นี้!','admin_.php');
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
            <a href="add_group.php" class="btn btn-primary">เพิ่มหมวดหมู่</a>
            <a href="admin.php" class="btn btn-danger">กลับสู่หน้าหลัก</a>
        </div>
        <div class="col-lg-3">
            <form action="admin_group.php" method="get">
            <input type="text" name="search" class="form-control" placeholder="ค้นหาหมวดหมู่จาก ชื่อหมวดหมุ่ ที่ใกล้เคียง">
            <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></button>
        </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading text-center">หมวดหมู่สินค้า</div>
                <table class="table table-hover">
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-center" >ชื่อหมวดหมู่</th>
                        <th class="text-center" >จัดการ</th>
                    </tr>
                    <?php

                        if(!empty($_GET['search']))
                        {
                            $search = $_GET['search'];
                            $sql_product = "SELECT * FROM tb_groups WHERE name_group LIKE '%$search%'";
                        }
                        else
                        {
                            $sql_product = "SELECT * FROM tb_groups";
                        }
                        $query_product = $conn->query($sql_product);
                        $no=1;
                        while($product = $query_product->fetch_assoc())
                        {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $no++;?></td>
                        <td><?php echo $product['name_group'];?></td>
                        <td>
                            <a href="admin_group.php?id=<?php echo $product['id_group'];?>" onclick="return confirm('คุณต้องการลบหมวดหมู่นี้ ใช่ หรือ ไม่')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            <a href="edit_group.php?id=<?php echo $product['id_group'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
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