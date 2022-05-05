
<nav class="navbar navbar-default">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#Navbar1" role="button" aria-expanded="false">
                    <span class="sr-only">Toggle</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php" class="navbar-brand" style=" margin-top : -25px">
                    <img src="Images/UI/logo4.png" height="78px" alt="No Image" >
                </a>
            </div>

            <div id="Navbar1" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> ตระกร้าสินค้า</a></li>
                    <?php
                    if(isset($_SESSION['id']))
                    {
                        $id_user = $_SESSION['id'];
$sql_user = SELECT_ID($conn,"tb_members","id_member = '$id_user'");
$user = $sql_user->fetch_assoc();
                    ?>
                    <li class="dropdown">
                        <a href="#" role="button"  class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"><span class="glyphicon glyphicon-user"></span> คุณ | <?php echo $user['firstname'].' '.$user['lastname']; ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="order.php">รายการสั่งซื้อ</a></li>
                            <li><a href="profile.php">แก้ไขข้อมูลส่วนตัว</a></li>
                            <?php
                            if(isset($_SESSION['id'],$_SESSION['status']) && $_SESSION['status'] == "admin")
                            {
                            ?>
                            <li><a href="admin.php">ระบบหลังบ้าน</a></li>
                            <?php
                            }
                            ?>
                            
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li><a href="login.php">เข้าสู่ระบบ</a></li>
                    <li><a href="register.php">สมัครสมาชิก</a></li>
                    <?php
                    }
                    ?>

                </ul>
                <form action="search.php" method="get" class="navbar-form navbar-right">
                    <input type="text" name="search" placeholder="ค้นหาสินค้าจาก ชื่อ หมวดหมู่สินค้า และ ราคาสินค้า ที่ใกล้เคียง" class="form-control">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div>
        </div>
    </div>
</nav>