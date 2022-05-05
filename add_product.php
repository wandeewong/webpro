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
        $name_product = $_POST['name_product'];
        $stock_product = $_POST['stock_product'];
        $discount_product = $_POST['discount_product'];
        $price_product = $_POST['price_product'];
        $id_group = $_POST['id_group'];
        $detail_product = $_POST['detail_product'];
        if(empty($_FILES['image_product']['name']))
        {
            $image_encode = 'empty.png';
        }
        else
        {
            $real_image = pathinfo(basename($_FILES['image_product']['name']),PATHINFO_EXTENSION);
            $image_encode = 'img_'.uniqid().'.'.$real_image;
            $image_path = 'Images/Products/';
            $image_success = $image_path.$image_encode;
            $success = move_uploaded_file($_FILES['image_product']['tmp_name'],$image_success);
            if($success == FALSE)
            {
                echo "<script> alert('เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ!'); </script>";
                header("Refash:0; url=add_product.php");
            }
            
        }
    

        $insert = INSERT($conn,'tb_products','name_product,stock_product,discount_product,price_product,id_group,detail_product,image_product',"'$name_product','$stock_product','$discount_product','$price_product','$id_group','$detail_product','$image_encode'");
        if($insert)
        {
            alert('เพิ่มรายการสินค้าสำเร็จ','add_product.php');
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการเพิ่มรายการสินค้า!','add_product.php');
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
    <div class="contanier">
        <div class="panel panel-primary" style="margin: 0 auto; width: 500px; margin-top: 50px;">
            <div class="panel-heading text-center">เพิ่มรายการสินค้า</div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-product">
                        <label for="name_product">ชื่อสินค้า</label>
                        <input type="text" name="name_product" id="name_product" required placeholder="ชื่อของสินค้าที่ต้องการเพิ่ม" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="stock_product">จำนวนสินค้า</label>
                        <input type="number" name="stock_product" id="stock_product" required placeholder="จำนวนสินค้า(ชิ้น)" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="discount_product">ส่วนลด</label>
                        <input type="number" name="discount_product" oninput="vat();" id="discount_product" required placeholder="ส่วนลดสินค้า(บาท)" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="price_product">ราคาสินค้า</label>
                        <input type="number" name="price_product" oninput="vat();" id="price_product" required placeholder="ราคาของสินค้า" class="form-control" >
                        <p class="help-block" id="show"></p>
                    </div>
                    <div class="form-product">
                        <label for="id_group">หมวดหมู่สินค้า</label>
                        <select name="id_group" id="id_group" class="form-control">
                            <?php
                                $sql_group = SELECT($conn,'tb_groups');
                                while($group = $sql_group->fetch_assoc())
                                {
                            ?>
                            <option value="<?php echo $group['id_group'];?>"><?php echo $group['name_group'];?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-product">
                        <label for="detail_product">รายระเอียดสินค้า</label>
                        <textarea name="detail_product" id="detail_product" cols="10" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-product">
                        <label for="image_product">รูปถ่ายสินค้า</label>
                        <input type="file" name="image_product" id="image_product" accept="image/*" >
                    </div>
            </div>
            <div class="panel-footer text-center">
                    <a href="admin_product.php" class="btn btn-danger">กลับ</a>
                    <input type="submit" class="btn btn-success" value="เพิ่มรายการสินค้า" name="add" id="add" onclick="return confirm('คุณต้องการเพิ่มรายการสินค้า ใช่ หรือ ไม่')">
                </form>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        function vat()
        {
        var price = parseInt(document.getElementById('price_product').value);
        var discount = parseInt(document.getElementById('discount_product').value);
        var total = (price-discount)+(price-discount)*7/100;
        if(!isNaN(price) && !isNaN(discount))
        {
            document.getElementById('show').innerHTML = "ราคาสินค้า (รวมส่วนลดและภาษีแล้ว) = "+total;
        }
        else
        {
            document.getElementById('show').innerHTML = "";
        }
    }
    </script>
</body>
</html>