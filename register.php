<?php
session_start();
include '../config/database.php';

// ตรวจสอบการเข้าสู่ระบบ
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$translations = include("../lang/$lang.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $translations['register']; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2><?php echo $translations['register']; ?></h2>
    <form action="../controllers/auth.php" method="POST">
        <input type="text" name="username" placeholder="<?php echo $translations['username']; ?>" required>
        <input type="email" name="email" placeholder="<?php echo $translations['email']; ?>" required>
        <input type="password" name="password" placeholder="<?php echo $translations['password']; ?>" required>
        <button type="submit" name="register"><?php echo $translations['submit']; ?></button>
    </form>
</body>
</html>
