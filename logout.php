<?php
session_start();

// ล้างค่า Session ทั้งหมด
session_unset();
session_destroy();

// ลบ Cookies (ถ้ามี)
setcookie('user_id', '', time() - 3600, "/");
setcookie('username', '', time() - 3600, "/");

// กลับไปหน้า Login
header("Location: login.php");
exit();
?>
