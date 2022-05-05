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
    $del = DELETE($conn,'tb_products',"id_product=$id");
    if($del)
    {
        alert('ลบรายการสินค้าเรียบร้อยแล้ว','admin_product.php');
    }
    else
    {
        alert('เกิดข้อผิดพลาดในการลบสินค้า!','admin_product.php');
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
            <a href="add_product.php" class="btn btn-primary">เพิ่มรายการสินค้า</a>
            <a href="admin.php" class="btn btn-danger">กลับสู่หน้าหลัก</a>
        </div>
        <div class="col-lg-3">
            <form action="admin_product.php" method="get">
            <input type="text" name="search" class="form-control" placeholder="ค้นหาสินค้าจาก ชื่อ ที่ใกล้เคียง">
            <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></button>
        </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading text-center">รายการสินค้า</div>
                <table class="table table-hover">
                    <tr>
                        <th class="text-center" width = 7%>ลำดับสินค้า</th>
                        <th class="text-center" >ชื่อสินค้า</th>
                        <th class="text-center" width = 10%>สินค้าคงคลัง</th>
                        <th class="text-center" width = 10%>ส่วนลด</th>
                        <th class="text-center" width = 10%>ราคาสินค้า</th>
                        <th class="text-center" width = 15%>รายระเอียดสินค้า</th>
                        <th class="text-center" width = 10%>รูปสินค้า</th>
                        <th class="text-center" width = 10%>ความคิดเห็น</th>
                        <th class="text-center" width = 10%>จัดการ</th>
                    </tr>
                    <?php

                        if(!empty($_GET['search']))
                        {
                            $search = $_GET['search'];
                            $sql_product = "SELECT * FROM tb_products WHERE name_product LIKE '%$search%' OR stock_product <= '$search'";
                        }
                        else
                        {
                            $sql_product = "SELECT * FROM tb_products";
                        }
                        $query_product = $conn->query($sql_product);
                        $no=1;
                        while($product = $query_product->fetch_assoc())
                        {
                            $image = $product['image_product'];
                            $id_product = $product['id_product'];
                    ?>

                    <tr class="text-center">
                        <td><?php echo $no++;?></td>
                        <td><?php echo $product['name_product'];?></td>
                        <td><?php echo number_format($product['stock_product']);?></td>
                        <td><?php echo number_format($product['discount_product']);?></td>
                        <td><?php echo number_format($product['price_product']);?></td>
                        <td><?php echo $product['detail_product'];?></td>
                        <td>
                        <button onclick="window.open('Images/Products/<?php echo $image; ?>','_blank','width=500px,height=500px');" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>
                        </td>
                        <td>
                        <button onclick="window.open('show_comment.php?id=<?php echo $id_product; ?>','_blank','width=500px,height=500px');" class="btn btn-success"><span class="glyphicon glyphicon-comment"></span></button>
                        </td>
                        <td>
                            <a href="admin_product.php?id=<?php echo $product['id_product'];?>" onclick="return confirm('คุณต้องการลบรายการสินค้านี้ ใช่ หรือ ไม่')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            <a href="edit_product.php?id=<?php echo $product['id_product'];?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
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