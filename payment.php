<?php
    session_start();
    require('connect.php');
    require('function.php');
    
    if(!isset($_SESSION['id']))
    {
        header("Location:index.php");
    }
    if(empty($_GET['id']))
    {
        header("Location:index.php");
    }

    $id_order = $_GET['id'];
    $id_user = $_SESSION['id'];
    $check = SELECT_ID($conn,"tb_orders","id_order = '$id_order' AND id_member ='$id_user'");
    if($check->num_rows == 0)
    {
        header("Location:index.php");
    }

    if(isset($_POST['login']))
    {
        $payment = $_POST['payment'];
        $date = $_POST['date'];
        $image_real = pathinfo(basename($_FILES['image_order']['name']),PATHINFO_EXTENSION);
        $image_encode = "Img_".uniqid().'.'.$image_real;
        $image_path = "Images/Orders/";
        $image_success = $image_path.$image_encode;

        $success = move_uploaded_file($_FILES['image_order']['tmp_name'],$image_success);
        if($success == FALSE)
        {
            alert('เกิดข้อผิดพลาดในการอัพโหลดรูป',"order.php");
        }

        $sql_user = SELECT_ID($conn,"tb_members","id_member = '$id_user'");
        $user = $sql_user->fetch_assoc();

        $name = "BICYCLESHOP NEW PAYMENT";
        $mes =  "คุณ: ".$user['firstname'].' ได้แจ้งชำระเงิน! ผ่านช่องทาง'.$payment.'เป็นเวลา '.$date;
        $mail = mail("admin6@shoptest.com",$name,$mes,"from: user6@shoptest.com");

        $UPDATE = UPDATE($conn,"tb_orders","payment='$payment',date_payment='$date',image_order='$image_encode', status_order = 'รอตรวจสอบ'","id_order = '$id_order'");
        if($UPDATE && $mail)
        {
            alert("แจ้งชำระเงินเสร็จสิ้น","order.php");
        }
        else
        {
            alert("เกิดข้อผิดพลาดในการแจ้งชำระเงิน","order.php");
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
    

    <form action="payment.php?id=<?php echo $id_order; ?>" method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="panel panel-primary" style="margin:0 auto;width: 500px; margin-top: 20px; margin-bottom: 20px;">
            <div class="panel-heading text-center">แจ้งชำระเงิน</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="payment">ช่องทางในการชำระเงิน</label>
                    <select name="payment" class="form-control" required id="payment">
                        <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย เลขบัญชี 9821773389 วรรณดี วงค์ไพศาล</option>
                        <option value="ธนาคารกรุงทพ">ธนาคารกสิกรไทย เลขบัญชี 5304842728 วรรณดี วงค์ไพศาล</option>
                        <option value="True Wallet">True Wallet เบอร์ 065-460-0837 วรรณดี วงค์ไพศาล</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">วันเวลาในการโอนเงิน</label>
                    <input type="datetime-local" name="date" required class="form-control" id="date">
                </div>
                <div class="form-group">
                    <label for="image_order">หลักฐานในการโอนเงิน</label>
                    <input type="file" name="image_order" accept="image/*" required class="form-control" id="image_order">
                </div>
              
            </div>
            <div class="panel-footer text-center">
                <input type="submit" class="btn btn-success" name="login" onclick="return confirm('คุณต้องการที่จะ แจ้งชำระเงิน ใช่ หรือ ไม่ ?');" value="แจ้งชำระเงิน">
                <a href="order.php" class="btn btn-danger">กลับ</a>
            </div>
        </div>
    </div>
</form>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>