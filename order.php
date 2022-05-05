<?php
    session_start();
    require('connect.php');
    require('function.php');

    if(!isset($_SESSION['id']))
    {
        header("Location:index.php");
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
            alert('ยกเลิกรายการเสร็จสิ้น!',"order.php");
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการลบ!',"order.php");
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
        width:95%;
    }
    .breadcrumb{
        background-color: #337ab7;
    }
    .breadcrumb a{
        color:white;
    }
    .dropdown:hover .dropdown-menu
    {
        display: block;
        margin-top: 0;
    }
</style>
<body>
    
    <?php include('navbar.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <?php include('group.php'); ?>
            </div>
            <div class="col-lg-9">
                    <?php include('nav.php'); ?>

                    <div class="panel panel-primary" style="margin-top: 20px;">
                        <div class="panel-heading">รายการสั่งซื้อ</div>
                        <div class="panel-body">
                           <?php
                           $id_user = $_SESSION['id'];
                           $sql_order = SELECT_ID($conn,"tb_orders","id_member = '$id_user' ORDER BY id_order DESC");
                           $no=1;
                           while($order = $sql_order->fetch_assoc())
                           {                           
                               $id_order = $order['id_order'];
                           ?>
                           <div class="panel panel-primary">
                               <div class="panel-heading">หมายเลขสั่งซื้อ: <?php echo $no++; ?></div>
                               <div class="panel-body">
                                   <table class="table">
                                       <tr>
                                           <th class="text-center" width="5%">ลำดับ</th>
                                           <th class="text-center">ชื่อสินค้า</th>
                                           <th class="text-center" width="20%">จำนวน</th>
                                           <th class="text-center" width="20%">ราคา</th>
                                       </tr>


                                       <?php
                                       $sql_order_a = "SELECT * FROM tb_detail_orders LEFT JOIN tb_products ON tb_detail_orders.id_product = tb_products.id_product WHERE id_order = '$id_order'";
                                       $query_order = $conn->query($sql_order_a);
                                       $i=0;
                                       while($product = $query_order->fetch_assoc())
                                       {
                                           $i++;
                                       ?>
                                       <tr class="text-center">
                                           <td><?php echo $i;?></td>
                                           <td><?php echo $product['name_product'];?></td>
                                           <td><?php echo  number_format($product['qty']);;?></td>
                                           <td><?php echo number_format($product['price']);?></td>
                                       </tr>
                                       <?php
                                        }
                                       ?>


                                       <tr>
                                           <th colspan="3" class="text-right">ราคารวม</th>
                                           <th class="text-center" ><?php echo number_format($order['total_order']); ?></th>
                                       </tr>
                                       <tr>
                                           <th colspan="3" class="text-right">สถานะ</th>
                                           <th class="text-center" ><?php echo $order['status_order']; ?></th>
                                       </tr>
                                       <?php
                                       if(!empty($order['tacking_number']))
                                       {
                                       ?>
                                       <tr>
                                           <th colspan="3" class="text-right">หมายเลขพัสดุ</th>
                                           <th class="text-center" ><?php echo $order['tacking_number']; ?></th>
                                       </tr>
                                       <?php
                                        }
                                       ?>

                                   </table>
                               </div>
                               <div class="panel-footer text-center">
                                   <?php
                                   if($order['status_order'] == 'รอชำระเงิน')
                                   {
                                   ?>
                                   <a href="order.php?id=<?php echo $id_order; ?>" class="btn btn-danger">ยกเลิก</a>
                                   <a href="payment.php?id=<?php echo $id_order; ?>" class="btn btn-success">แจ้งชำระเงิน</a>
                                   <?php
                                   }
                                   ?>
                                   <a href="print.php?id=<?php echo $id_order; ?>" target="_blank" class="btn btn-warning"><span class="glyphicon glyphicon-print"></span></a>
                               </div>
                           </div>
                           <?php
                           }
                           if($sql_order->num_rows == 0)
                            {
                                echo "<h1 class='text-center'>ไม่พบรายการสินค้า!</h1>";
                            }
                           ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
