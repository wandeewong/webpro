<?php
    session_start();
    require('connect.php');
    require('function.php');
    ob_start();
    if(!isset($_SESSION['id']))
    {
        header('Location:index.php');
    }
    if(empty($_SESSION['cart']))
    {
        header('Location:index.php');
    }
    $id_user = $_SESSION['id'];
$sql_user = SELECT_ID($conn,"tb_members","id_member = '$id_user'");
$user = $sql_user->fetch_assoc();
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
    <div class="container">
        <div class="panel panel-primary" style="margin-top:20px">
            <div class="panel-heading text-center">รายการสั่งซื้อ</div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th class="text-center" width="5%">ลำดับ</th>
                        <th class="text-center">ชื่อสินค้า</th>
                        <th class="text-center" width="10%">ราคา/หน่วย</th>
                        <th class="text-center" width="10%">จำนวน</th>
                        <th class="text-center" width="15%">ราคารวม</th>
                        <th class="text-center" width="5%"></th>
                    </tr>


                    <?php
                    $i = 0;
                    $total = 0;
                    if(!empty($_SESSION['cart']))
                    {
                        foreach($_SESSION['cart'] as $p_id => $qty)
                        {
                            $sql_product = SELECT_ID($conn,"tb_products","id_product = '$p_id'");
                            $product = $sql_product->fetch_assoc();
                            $price = ($product['price_product']-$product['discount_product'])+($product['price_product']-$product['discount_product'])*7/100;
                            $total += $price*$qty;
                            $i++;
                    ?>
                    <tr class="text-center">
                        <td><?php echo $i;?></td>
                        <td><?php echo $product['name_product'];?></td>
                        <td><?php echo number_format($price);?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo number_format($price*$qty);?></td>
                        <td></td>
                    </tr>
                    <?php
                        }
                    }
                    else
                    {
                        echo "<td  colspan='6' class='text-center' > ไม่พบสินค้าในตระกร้า! </td>";
                    }
                    ?>

                    <tr>
                        <th colspan="4" class="text-right">ภาษี (ตำนวนออกมาจากราคาเต็ม)</th>
                        <th class="text-center  "><?php echo number_format($total*7/107);?></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">ค่าจัดส่ง</th>
                        <th class="text-center">100</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-right">ราคาสุทธิ</th>
                        <th class="text-center"><?php echo number_format($total+100);?></th>
                        <th class="text-center">บาท</th>
                    </tr>
                </table>
            </div>
        </div>

        <form action="confirm.php" method="post">
        <div class="panel panel-primary" style="margin:0 auto; width:500px; margin-bottom:20px;">
        <div class="panel-heading text-center">ข้อมูลผู้รับ</div>
        <div class="panel-body">
        <div class="form-group">
                    <label for="firstname">ชื่อจริง</label>
                    <input type="text" name="firstname" placeholder="ชื่อจริง" value="<?php echo$user['firstname']; ?>" required class="form-control" id="firstname">
                </div>
                <div class="form-group">
                    <label for="lastname">นามสกุล</label>
                    <input type="text" name="lastname" placeholder="นามสกุล" value="<?php echo$user['lastname']; ?>" required class="form-control" id="lastname">
                </div>
                <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <textarea name="address" id="address" cols="5" class="form-control" rows="5" placeholder="ที่อยู่ของท่าน" required><?php echo$user['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="tel">เบอร์โทร</label>
                    <input type="text" name="tel" pattern="[0-9]{10}" placeholder="เบอร์โทร (08XXXXXXXX)" value="<?php echo$user['tel']; ?>" required class="form-control" id="tel">
                </div>
        </div>
        <div class="panel-footer text-center">
            <input type="submit" onclick="return confirm('คุณต้องการสั่งซื้อ ใช่ หรือ ไม่ ?');" class="btn btn-success" name="submit" value="ยืนยันการสั่งซื้อ">
            <a href="cart.php" class="btn btn-danger">กลับ</a>
        </div>
        </div>
    </div>
    </form>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>


<?php


if(isset($_POST['submit']))
{
    date_default_timezone_set('Asia/Bangkok');
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];
    $date = date('Y-m-d H:m:s');

    $total_all = $total+100;
    $INSERT1 = INSERT($conn,"tb_orders","id_member,firstname,lastname,address,tel,date_order,total_order","'$id_user','$firstname','$lastname','$address','$tel','$date','$total_all'");
    $SELECT1 = SELECT_ID($conn,"tb_orders","id_member = '$id_user' ORDER BY id_order DESC");
    $order = $SELECT1->fetch_assoc();
    $id_order =$order['id_order'];


    foreach($_SESSION['cart'] as $p_id => $qty)
    {
        $sql_product = SELECT_ID($conn,"tb_products","id_product = '$p_id'");
        $product = $sql_product->fetch_assoc();
        $price = ($product['price_product']-$product['discount_product'])+($product['price_product']-$product['discount_product'])*7/100;

        $stock = $product['stock_product']-$qty;
        $like = $product['like_product']+1;
        $INSERT2 = INSERT($conn,"tb_detail_orders","id_order,id_product,qty,price","'$id_order','$p_id','$qty','$price'");
        $UPDATE1 = UPDATE($conn,"tb_products","stock_product='$stock',like_product='$like'","id_product = '$p_id'");
    }

    if($INSERT1 && $INSERT2 && $UPDATE1)
    {
        alert("สั่งซื้อเสร็จสิ้น!","order.php");
        unset($_SESSION['cart']);
    }
    else
    {
        alert("เกิดข้อผิดพลาดในการสั่งซื้อ!","confirm.php");
    }
}
?>