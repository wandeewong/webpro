<?php
session_start();
require('function.php');

if(session_destroy())
{
    alert("ออกจากระบบเสร็จสิ้น!","index.php");
}
else
{
    alert("เกิดข้อผิดพลาดในการออกจากระบบ!","index.php");
}
?>