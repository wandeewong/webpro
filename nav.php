

<ul class="breadcrumb">
    <li><a href="index.php">หน้าแรก</a></li>
    <?php
    if(isset($_SESSION['id']))
    {
    ?>
    <li><a href="order.php">รายการสั่งซื้อ</a></li>
    <?php
    }
    ?>
    
    <li><a href="promotion.php">โปรโมชั่น</a></li>
    <li><a href="howtobuy.php">วิธีการสั่งซื้อ</a></li>
    <li><a href="howtopayment.php">ช่องทางการชำระเงิน</a></li>
    <li><a href="contact.php">ติดต่อเรา</a></li>
    <?php
    if(isset($_SESSION['id'],$_SESSION['status']) && $_SESSION['status'] == "admin")
    {
    ?>
    <li><a href="admin.php">ระบบหลังบ้าน</a></li>
    <?php
    }
    ?>

</ul>