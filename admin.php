<?php
require('connect.php');
session_start();
require('function.php');
if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
{
    header('Location:index.php');
}



if(!empty($_GET['id']) && $_GET['status'] == "ok")
{
    $id = $_GET['id'];
    $mail = @mail("user6@shoptest.com","BICYCLESHOP PAYMENT","หมายเลขสั่งซื้อ : ".$id."ชำระเงินเสร็จสิ้น!","from: admin6@shoptest.com");
    $UPDATE = UPDATE($conn,"tb_orders","status_order = 'ชำระเงินเสร็จสิ้น'","id_order = '$id'");
    if($UPDATE && $mail)
    {
        alert("แก้ไขเสร็จสิ้น","admin.php");
    }
    else
    {
        alert("เกิดข้อผิดพลาดในการเปลื่ยนสถานะ","admin.php");
    }
}

if(!empty($_GET['id']) && $_GET['status'] == "no")
{
    $id = $_GET['id'];
    $mail = @mail("user6@shoptest.com","BICYCLESHOP PAYMENT","หมายเลขสั่งซื้อ : ".$id."ต้องแจ้งชำระเงินใหม่!","from: admin6@shoptest.com");
    $UPDATE = UPDATE($conn,"tb_orders","status_order = 'รอชำระเงิน'","id_order = '$id'");
    if($UPDATE && $mail)
    {
        alert("แก้ไขเสร็จสิ้น","admin.php");
    }
    else
    {
        alert("เกิดข้อผิดพลาดในการเปลื่ยนสถานะ","admin.php");
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
    .contanier
    {
        width : 95%
    }
</style>
<body>


    <?php
    date_default_timezone_set('Asia/Bangkok');
    $year = date('Y');
    $month = date('m');
    $day = date('d');
    $sql1 = "SELECT SUM(total_order) as total_order FROM tb_orders WHERE MONTH(date_order) LIKE $month AND YEAR(date_order) LIKE $year";
    $query1 = $conn->query($sql1);
    $show1 = $query1->fetch_assoc();

    $sql2 = "SELECT SUM(total_order) as total_order FROM tb_orders WHERE DAY(date_order) = $day AND MONTH(date_order) = $month AND YEAR(date_order) = $year";
    $query2 = $conn->query($sql2);
    $show2 = $query2->fetch_assoc();

    $sql3 = "SELECT SUM(stock_product) as stock_product FROM tb_products";
    $query3 = $conn->query($sql3);
    $show3 = $query3->fetch_assoc();

    $sql4 = "SELECT id_order FROM tb_orders WHERE DAY(date_order) = $day AND MONTH(date_order) = $month AND YEAR(date_order) = $year";
    $query4 = $conn->query($sql4);
    $show4 = $query4->num_rows;

    ?>
    <div class="contanier">
        <div class="text-right" style="margin-top: 10px;">
            <a href="index.php" class="btn btn-danger">กลับสู่หน้าหลัก</a>
        </div>
        <div class="col-lg-3" style="margin-top: 10px;">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">เมนู</div>
                <div class="list-group">
                    <a href="admin_member.php" class="list-group-item"><b>รายชื่อสมาชิก</b></a>
                    <a href="admin_product.php" class="list-group-item"><b>รายการสินค้า</b></a>
                    <a href="admin_group.php" class="list-group-item"><b>หมวดหมู่สินค้า</b></a>
                    <a href="admin_order.php" class="list-group-item"><b>รายการสั่งซื้อ</b></a>
                </div>
            </div>
        </div>
        <div class="col-lg-9" style="margin-top: 10px;">
            <div class="col-lg-12">
                <div class="col-lg-3">
                    <div class="panel panel-info text-center" >
                        <div class="panel-heading">รายการสั่งซื้อในวันนี้</div>
                        <div class="panel-body"><b><?php echo number_format($show4); ?></b></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-danger text-center" >
                        <div class="panel-heading">สินค้าคงคลัง</div>
                        <div class="panel-body"><b><?php echo number_format($show3['stock_product']); ?></b></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-warning text-center" >
                        <div class="panel-heading">ยอดขายรายวัน</div>
                        <div class="panel-body"><b><?php echo number_format($show2['total_order']); ?></b></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-success text-center" >
                        <div class="panel-heading">ยอดขายรายเดือน</div>
                        <div class="panel-body"><b><?php echo number_format($show1['total_order']); ?></b></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">รายการสั่งซื้อ</div>
                    <table class="table table-hover">
                        <tr>
                            <th class="text-center" width= 5%>ลำดับ</th>
                            <th class="text-center" width= 10%>ธนาคาร</th>
                            <th class="text-center" width= 10%>วันที่ชำระเงิน</th>
                            <th class="text-center" width= 5%>ราคา</th>
                            <th class="text-center" width= 10%>หลักฐาน</th>
                            <th class="text-center" width= 10%>จัดการ</th>
                        </tr>
                        <?php 
                            $sql_order = "SELECT * FROM tb_orders WHERE status_order = 'รอตรวจสอบ'";
                            $query_order = $conn->query($sql_order);
                            $no=1;
                            while($order = $query_order->fetch_assoc())
                            {
                               $image = $order['image_order'];
                        ?>
                        <tr class="text-center">
                            <td><?php  echo $no++;?></td>
                            <td><?php  echo $order['payment'];?></td>
                            <td><?php  echo $order['date_payment'];?></td>
                            <td><?php  echo number_format($order['total_order']);?></td>
                            <td>
                                <button onclick="window.open('Images/Orders/<?php echo $image; ?>','_blank','width=500px,height=500px');" class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>
                            </td>
                            <td>
                                <a href="admin.php?id=<?php echo $order['id_order']; ?>&status=no" class="btn btn-danger" ><span class="glyphicon glyphicon-trash"></span></a>
                                <a href="admin.php?id=<?php echo $order['id_order']; ?>&status=ok" class="btn btn-success" ><span class="glyphicon glyphicon-ok"></span></a>
                                <a href="print.php?id=<?php echo $order['id_order'];?>" target="_blank" class="btn btn-warning" ><span class="glyphicon glyphicon-print"></span></a>
                            </td>
                        </tr>
                        <?php
                           }
                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>