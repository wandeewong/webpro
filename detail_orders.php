<?php
    session_start();
    require('connect.php');
    require('function.php');

    if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
{
    header('Location:index.php');
}
if(empty($_GET['id']))
{
    header('Location:index.php');
}

$id_order = $_GET['id'];
$sql_order = SELECT_ID($conn,"tb_orders","id_order = '$id_order' ORDER BY id_order DESC");
$order = $sql_order->fetch_assoc()
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
</style>
<body>
    

    <div class="container">
    <div class="panel panel-primary" style="margin-top:30px;">
                               <div class="panel-heading">หมายเลขสั่งซื้อ: <?php echo $id_order; ?></div>
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
                                        if($sql_order->num_rows == 0)
                                        {
                                            echo "<h1 class='text-center'>ไม่พบรายการสั่งซื้อ!</h1>";
                                        }
                                       ?>


                                       <tr>
                                           <th colspan="3" class="text-right">ราคารวม</th>
                                           <th class="text-center" ><?php echo number_format($order['total_order']); ?></th>
                                       </tr>

                                   </table>
                               </div>
                           </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>