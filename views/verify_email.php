<?php
include '../config/database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // ตรวจสอบ Token และยืนยันอีเมล
    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // อัปเดตให้ผู้ใช้ได้รับการยืนยันอีเมล
        $stmt = $pdo->prepare("UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        echo "อีเมลของคุณได้รับการยืนยันแล้ว!";
    } else {
        echo "Token นี้ไม่ถูกต้อง!";
    }
}
?>
