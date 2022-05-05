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

$id_product = $_GET['id'];
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
    <?php
                    $sql_comment = "SELECT * FROM tb_comments LEFT JOIN tb_members ON tb_comments.id_member = tb_members.id_member WHERE id_product = '$id_product' ORDER BY id_comment DESC";
                    $query_comment = $conn->query($sql_comment);
                    while($comment = $query_comment->fetch_assoc())
                    {
                    ?>
                    <div class="panel panel-primary" style="margin-top: 20px;">
                        <div class="panel-heading">คุณ | <?php echo $comment['firstname'].' '.$comment['lastname']; ?></div>
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
                    if($query_comment->num_rows == 0)
                    {
                        echo "<h1 class='text-center text-success'>ไม่มีความคิดเห็น</h1>";
                    }
                    ?>

    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>