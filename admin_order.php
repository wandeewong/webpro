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
    $sql1 = "SELECT * FROM tb_detail_orders LEFT JOIN tb_products ON tb_detail_orders.id_product = tb_products.id_product WHERE id_order = '$id'";
    $query1 = $conn->query($sql1);
    while($product = $query1->fetch_assoc())
    {
        $id_product = $product['id_product'];
        $stock = $product['stock_product']+$product['qty'];
        $UPDATE1 = UPDATE($conn,"tb_products","stock_product='$stock'","id_product = '$id_product'");
    }

    $DELETE1 = DELETE($conn,"tb_detail_orders","id_order = '$id'");
    $DELETE2 = DELETE($conn,"tb_orders","id_order = '$id'");
    if($UPDATE1 && $DELETE1 && $DELETE2)
    {
        alert('ลบรายการสั่งซื้อนี้เรียบร้อยแล้ว','admin_order.php');
    }
    else
    {
        alert('เกิดข้อผิดพลาดในการลบรายสั่งซื้อนี้!','admin_order.php');
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
    .container
    {
        width:95%
    }
</style>
<body>

    <div class="container">
        <div class="text-right" style="margin-top: 10px;">
            <a href="admin.php" class="btn btn-danger">กลับสู่หน้าหลัก</a>
        </div>
        <div class="col-lg-3">
            <form action="admin_order.php" method="get">
            <input type="text" name="search" class="form-control" placeholder="ค้นหาคำสั่งซื้อจาก ชื่อจริง และนามสกุล ที่ใกล้เคียง">
            <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span></button>
        </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading text-center">รายชื่อสมาชิก</div>
                <table class="table table-hover">
                    <tr>
                        <th class="text-center" width = 5%>ลำดับ</th>
                        <th class="text-center" width = 5%>ชื่อจริง</th>
                        <th class="text-center" width = 5%>นามสกุล</th>
                        <th class="text-center" width = 10%>ที่อยู่</th>
                        <th class="text-center" width = 5%>เบอร์โทร</th>
                        <th class="text-center" width = 10%>ธนาคาร</th>
                        <th class="text-center" width = 10%>วันที่ชำระเงิน</th>
                        <th class="text-center" width = 10%>ราคา</th>
                        <th class="text-center" width = 5%>หลักฐาน</th>
                        <th class="text-center" width = 7%>รายละเอียด</th>
                        <th class="text-center" width = 7%>สถานะ</th>
                        <th class="text-center" width = 10%>หมายเลขพัสดุ</th>
                        <th class="text-center" width = 20%>จัดการ</th>
                    </tr>
                    <?php

                        if(!empty($_GET['search']))
                        {
                            $search = $_GET['search'];
                            $sql_product = "SELECT * FROM tb_orders WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
                        }
                        else
                        {
                            $sql_product = "SELECT * FROM tb_orders";
                        }
                        $query_product = $conn->query($sql_product);
                        $no=1;
                        while($product = $query_product->fetch_assoc())
                        {
                            $image = $product['image_order'];
                            $id_a = $product['id_order'];

                    ?>
                    <tr class="text-center">
                        <td><?php echo $no++;?></td>
                        <td><?php echo $product['firstname'];?></td>
                        <td><?php echo $product['lastname'];?></td>
                        <td><?php echo $product['address'];?></td>
                        <td><?php echo $product['tel'];?></td>
                        <td><?php echo $product['payment'];?></td>
                        <td><?php echo $product['date_payment'];?></td>
                        <td><?php echo number_format($product['total_order']);?></td>
                        <td>
                        <button onclick="window.open('Images/Orders/<?php echo $image; ?>','_blank','width=500px,height=500px');" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>
                        
                    </td>
                    <td>
                            <button onclick="window.open('detail_orders.php?id=<?php echo $id_a;?>','_blank','width=500px,height=500px');" class="btn btn-success"><span class="glyphicon glyphicon-comment"></span></button>

                        </td>
                        <td><?php echo $product['status_order'];?></td>
                        <td><?php echo $product['tacking_number'];?></td>
                        <td>
                            <a href="admin_order.php?id=<?php echo $product['id_order'];?>" onclick="return confirm('คุณต้องการลบชื่อผู้ใช้นี้ ใช่ หรือ ไม่')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            <a href="edit_order.php?id=<?php echo $product['id_order'];?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="print.php?id=<?php echo $product['id_order']; ?>" target="_blank" class="btn btn-warning"><span class="glyphicon glyphicon-print"></span></a>
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