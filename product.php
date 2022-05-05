<?php
    session_start();
    require('connect.php');
    require('function.php');

    if(empty($_GET['id']))
    {
        header("Location:index.php");
    }

    $id_product = $_GET['id'];
    $sql_product = SELECT_ID($conn,"tb_products","id_product = '$id_product'");
    $product = $sql_product->fetch_assoc();

    $view = $product['view_product']+1;
    UPDATE($conn,"tb_products","view_product = '$view'","id_product = '$id_product'");

    $_SESSION['product'] = $product['id_group'];
    $price_a = ($product['price_product']-$product['discount_product'])+($product['price_product']-$product['discount_product'])*7/100;




    if(isset($_POST['submit_comment']))
    {
        date_default_timezone_set('Asia/Bangkok');
        $comment = $_POST['comment'];
        $date = date("Y-m-d H:m:s");
        $id_member = $_SESSION['id'];

        $INSERT = INSERT($conn,"tb_comments","id_member,id_product,comment,date_comment","'$id_member','$id_product','$comment','$date'");
        if($INSERT)
        {
            alert("แสดงความคิดเห็นเรียบร้อยแล้ว!","product.php?id=".$id_product);
        }
        else
        {
            alert("เกิดข้อผิดพลาดในการแสดงความคิดเห็น!","product.php?id=".$id_product);
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
                        <div class="panel-heading"><?php echo $product['name_product']; ?></div>
                        <div class="panel-body">
                          <div class="col-lg-4">
                              <img src="Images/Products/<?php echo $product['image_product']; ?>" width="100%" alt="No Image">
                          </div>
                          <div class="col-lg-8">
                          <h3><b><?php echo $product['name_product']; ?></b></h3>
                                <?php
                                if($product['discount_product'] > 0)
                                {
                                ?>
                                <h4><span class="text-danger" style="text-decoration: line-through;">THB<?php echo number_format(($product['price_product']*7/100)+$product['price_product']); ?></span> <span><?php echo number_format(($product['discount_product']/$product['price_product'])*100);?>%</span></h4>
                                <?php
                                }
                                ?>
                                <h3>THB<b><?php echo number_format($price_a); ?></b></h3>
                                <?php
                                if($product['stock_product'] > 0)
                                {
                                ?>
                                <a onclick="return confirm('คุณต้องการเพิ่มสินค้านี้ ใช่ หรือ ไม่ ?');" href="cart.php?p_id=<?php echo $product['id_product']; ?>&status=add" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-shopping-cart">เพิ่มสินค้าลงตระกร้า</span></a>
                                <?php
                                }
                                else
                                {
                                ?>
                                <button disabled class="btn btn-danger btn-lg">สินค้าหมด</button>
                                <?php
                                }
                                ?>
                                <div style="margin-top:10px">
                                    <span class="glyphicon glyphicon-heart text-danger"><?php echo $product['like_product']; ?></span>
                                    <span class="glyphicon glyphicon-eye-open"><?php echo $product['view_product']; ?></span>
                                </div>
                          </div>
                        </div>
                        <div class="panel-footer">
                            <h4><?php echo $product['detail_product']; ?></h4>
                        </div>
                    </div>

                    <?php
                    if(isset($_SESSION['id']))
                    {
                    ?>
                    <form action="product.php?id=<?php echo $product['id_product']; ?>" method="post">
                    <div class="panel panel-primary" style="margin-top: 20px;">
                        <div class="panel-heading text-center">แสดงความคิดเห็น</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="comment">ความคิดเห็นของท่าน</label>
                                <textarea class="form-control" name="comment" id="comment" cols="5" rows="5" required placeholder="ความคิดเห็นของท่าน"></textarea>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <input type="submit" class="btn btn-success" value="แสดงความคิดเห็น" name="submit_comment">
                        </div>
                    </form>
                    </div>
                    <?php
                    }
                    ?>


                    <?php
                    $sql_comment = "SELECT * FROM tb_comments LEFT JOIN tb_members ON tb_comments.id_member = tb_members.id_member WHERE id_product = '$id_product' ORDER BY id_comment DESC";
                    $query_comment = $conn->query($sql_comment);
                    while($comment = $query_comment->fetch_assoc())
                    {
                    ?>
                    <div class="panel panel-primary" style="margin-top: 20px;">
                        <div class="panel-heading">คุณ | <?php echo $comment['firstname'].' '.$comment['lastname']; ?> 

                        <?php
                        $id_member = $comment['id_member'];
                        $id_product = $_GET['id'];
                        $check = "SELECT * FROM tb_orders LEFT JOIN tb_detail_orders ON tb_orders.id_order = tb_detail_orders.id_order WHERE id_member = '$id_member' AND tb_detail_orders.id_product='$id_product' AND status_order = 'ชำระเงินเสร็จสิ้น'";
                        $query_chec = $conn->query($check);
                        if($query_chec->num_rows == 1)
                        {
                            ?>
                            <span class="glyphicon glyphicon-star" style="color:#ffae00;">ซื้อแล้ว</span>
                          <?php 
                        }
                        ?>
                        </div>
                        <div class="panel-body">
                            <h4><?php echo $comment['comment']; ?></h4>
                        </div>
                        <div class="panel-footer">
                            เวลา: <?php echo $comment['date_comment'];?>
                        </div>
                    </form>
                    </div>
                    <?php
                    }
                    ?>

            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>