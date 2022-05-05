<?php
    session_start();
    require('connect.php');
    require('function.php');

    $p_id = '';
    $status = '';
    if(!empty($_GET['p_id']))
    {
        $p_id=  $_GET['p_id'];
    }
    if(!empty($_GET['status']))
    {
        $status=  $_GET['status'];
    }

    if(!empty($p_id) && $status == "add")
    {
        if(isset($_SESSION['cart'][$p_id]))
        {
            $_SESSION['cart'][$p_id]++;
        }
        else
        {
            $_SESSION['cart'][$p_id] = 1;
        }
    }
    if(!empty($p_id) && $status == "remove")
    {
        unset($_SESSION['cart'][$p_id]);
    }

    if(isset($_POST['reprice']))
    {
        if(!empty($_SESSION['cart']))
        {
            $amount_array = $_POST['amount'];
            foreach($amount_array as $p_id => $amount)
            {
                $_SESSION['cart'][$p_id] = $amount; 
            }    
        }
        else
        {
            alert("ไม่พบสินค้าในตระกร้า!","cart.php");
        }
    }
    if(isset($_POST['confirm']))
    {
        if(!empty($_SESSION['cart']))
        {
            $amount_array = $_POST['amount'];
            foreach($amount_array as $p_id => $amount)
            {
                $_SESSION['cart'][$p_id] = $amount; 
            }    
            if(isset($_SESSION['id']))
            {
                header("Location:confirm.php");
            }
            else
            {
                alert("กรุณาเข้าสู่ระบบก่อน!","login.php");
            }
        }
        else
        {
            alert("ไม่พบสินค้าในตระกร้า!","cart.php");
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
</style>
<body>

    <form action="cart.php" method="post">
    <div class="container">
        <div class="panel panel-primary" style="margin-top:20px">
            <div class="panel-heading text-center">ตระกร้าสินค้า</div>
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
                        <td><input type="number" min="1" max="<?php echo $product['stock_product']; ?>" require value="<?php echo $qty?>" class="form-control" name="amount[<?php echo $p_id; ?>]"></td>
                        <td><?php echo number_format($price*$qty);?></td>
                        <td><a href="cart.php?p_id=<?php echo $p_id; ?>&status=remove" onclick="return confirm('คุณต้องการที่จะลบรายการนี้ ใช่ หรือ ไม่?'); " class="text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
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
            <div class="panel-footer text-center">
                <input type="submit" class="btn btn-warning" name="reprice" value="คำนวนราคาใหม่">
                <input type="submit" class="btn btn-success" name="confirm" value="สั่งซื้อ">
                <a href="index.php" class="btn btn-danger">กลับ</a>
            </div>
        </div>
    </div>
    </form>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>