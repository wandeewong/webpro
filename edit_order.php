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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $status_order = $_POST['status_order'];
        $tacking = $_POST['tacking_number'];

        if($status_order == "รอตรวจสอบ")
        {
            $mail = @mail("user6@shoptest.com","BICYCLESHOP PAYMENT","หมายเลขสั่งซื้อ : ".$id."ต้องแจ้งชำระเงินใหม่!","from: admin6@shoptest.com");
        }
        else if($status_order == "ชำระเงินเสร็จสิ้น")
        {
            $mail = @mail("user6@shoptest.com","BICYCLESHOP PAYMENT","หมายเลขสั่งซื้อ : ".$id."ชำระเงินเสร็จสิ้น!","from: admin6@shoptest.com");
        }
        else if($status_order == "จัดส่งเสร็จสิ้น")
        {
            $mail = @mail("user6@shoptest.com","BICYCLESHOP PAYMENT","หมายเลขสั่งซื้อ ".$id."ได้ทำการจัดส่งสินค้าเสร็จสิ้น! หมายเลขพัสดุ :".$tacking,"from: admin6@shoptest.com");
        }
        else if($status_order == "เกิดข้อผิดพลาด")
        {
            $mail = @mail("user6@shoptest.com","BICYCLESHOP ERROR","หมายเลขสั่งซื้อ : ".$id."เกิดข้อผิดพลาด! กรุณาติดต่อแอดมิน","from: admin6@shoptest.com");
        }

        $id = $_GET['id'];
        $insert = UPDATE($conn,'tb_orders',"firstname='$firstname',lastname='$lastname',address='$address',tel='$tel',status_order='$status_order',tacking_number='$tacking'","id_order = $id");
        if($insert)
        {
            alert('แก้ไขรายการสั่งซื้อสินค้าสำเร็จ','admin_order.php');
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการแก้ไขรายการสั่งซื้อสินค้า!','edit_order.php');
        }
    }
    $id = $_GET['id'];
    $sql_product = SELECT_ID($conn,'tb_orders',"id_order = $id");
    $product = $sql_product->fetch_assoc();
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
            <div class="panel-heading text-center">แก้ไขรายการสั่งซื้อสินค้า</div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-product">
                        <label for="firstname">ชื่อจริง</label>
                        <input type="text" name="firstname" id="firstname" value="<?php echo $product['firstname'];?>" required placeholder="ชื่อจริง" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="lastname">นามสกุล</label>
                        <input type="text" name="lastname" id="lastname" required value="<?php echo $product['lastname'];?>" placeholder="นามสกุล" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="address">ที่อยู่</label>
                        <textarea name="address" id="address" cols="10" rows="5" class="form-control"><?php echo $product['address'];?></textarea>
                    </div>
                    <div class="form-product">
                        <label for="tel">เบอร์โทร</label>
                        <input type="text" name="tel" pattern="[0-9]{10}" placeholder="เบอร์โทร (08XXXXXXXX)" value="<?php echo $product['tel'];?>" required class="form-control" id="tel">
                    </div>
                    <div class="form-product">
                        <label for="status_order">สถานะ</label>
                        <select name="status_order" id="status_order" class="form-control">
                            <option value="<?php echo $product['status_order'];?>"><?php echo $product['status_order'];?></option>
                            <option value="รอชำระเงิน">รอชำระเงิน</option>
                            <option value="รอตรวจสอบ">รอตรวจสอบ</option>
                            <option value="ชำระเงินเสร็จสิ้น">ชำระเงินเสร็จสิ้น</option>
                            <option value="จัดส่งเสร็จสิ้น">จัดส่งเสร็จสิ้น</option>
                            <option value="เกิดข้อผิดพลาด">เกิดข้อผิดพลาด</option>
                        </select>
                    </div>
                    <div class="form-product">
                        <label for="tacking_number">หมายเลขพัสดุ</label>
                        <input type="text" name="tacking_number" id="tacking_number" value="<?php echo $product['tacking_number'];?>"   placeholder="หมายเลขพัสดุ 10 หลัก" class="form-control" >
                    </div>

            </div>
            <div class="panel-footer text-center">
                    <a href="admin_order.php" class="btn btn-danger">กลับ</a>
                    <input type="submit" class="btn btn-success" value="แก้ไขรายการสั่งซื้อ" name="add" id="add" onclick="return confirm('คุณต้องการแก้ไขรายการสั่งซื้อสินค้า ใช่ หรือ ไม่')">
                </form>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>