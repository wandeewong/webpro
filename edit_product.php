<?php
    require('connect.php');
    session_start();
    require('function.php');
   if(isset($_SESSION['status'],$_SESSION['id']) && $_SESSION['status'] != 'admin')
    {
        header('Location:index.php');
    } 
    
    if(empty($_GET['id']))
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

        $id = $_GET['id'];
        $insert = UPDATE($conn,'tb_products',"name_product='$name_product',stock_product='$stock_product',discount_product='$discount_product',price_product='$price_product',id_group='$id_group',detail_product='$detail_product'","id_product = $id");
        if($insert)
        {
            alert('แก้ไขรายการสินค้าสำเร็จ','admin_product.php');
        }
        else
        {
            alert('เกิดข้อผิดพลาดในการแก้ไขรายการสินค้า!','edit_product.php');
        }
    }
    $id = $_GET['id'];
    
    $query = "SELECT * FROM tb_products LEFT JOIN tb_groups ON tb_products.id_group = tb_groups.id_group WHERE id_product = '$id'";
    $sql_product =$conn->query($query);
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
            <div class="panel-heading text-center">แก้ไขรายการสินค้า</div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-product">
                        <label for="name_product">ชื่อสินค้า</label>
                        <input type="text" name="name_product" id="name_product" value="<?php echo $product['name_product'];?>" required placeholder="ชื่อของสินค้าที่ต้องการแก้ไข" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="stock_product">จำนวนสินค้า</label>
                        <input type="number" name="stock_product" id="stock_product" required value="<?php echo $product['stock_product'];?>" placeholder="จำนวนสินค้า(ชิ้น)" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="discount_product">ส่วนลด</label>
                        <input type="number" name="discount_product" oninput="vat();" id="discount_product" value="<?php echo $product['discount_product'];?>" required placeholder="ส่วนลดสินค้า(บาท)" class="form-control" >
                    </div>
                    <div class="form-product">
                        <label for="price_product">ราคาสินค้า</label>
                        <input type="number" name="price_product" id="price_product" oninput="vat();" value="<?php echo $product['price_product'];?>" required placeholder="ราคาของสินค้า" class="form-control" >
                        <p class="help-block" id="show"></p>
                    </div>
                    <div class="form-product">
                        <label for="id_group">หมวดหมู่สินค้า</label>
                        <select name="id_group" id="id_group" class="form-control">
                        <option value="<?php echo $product['id_group'];?>"><?php echo $product['name_group'];?></option>
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
                        <textarea name="detail_product" id="detail_product" cols="10" rows="5" class="form-control"><?php echo $product['detail_product'];?></textarea>
                    </div>
            </div>
            <div class="panel-footer text-center">
                    <a href="admin_product.php" class="btn btn-danger">กลับ</a>
                    <input type="submit" class="btn btn-success" value="แก้ไขรายการสินค้า" name="add" id="add" onclick="return confirm('คุณต้องการแก้ไขรายการสินค้า ใช่ หรือ ไม่')">
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