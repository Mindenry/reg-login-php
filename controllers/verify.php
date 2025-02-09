<?php
session_start();
include '../config/database.php';

// รับค่า token จาก URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // ตรวจสอบ token ในฐานข้อมูล
    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ตรวจสอบว่าอีเมลยังไม่ได้ยืนยัน
        if ($user['email_verified'] == 0) {
            // อัพเดตสถานะการยืนยันอีเมล
            $stmt = $pdo->prepare("UPDATE users SET email_verified = 1 WHERE verification_token = ?");
            if ($stmt->execute([$token])) {
                echo "ยืนยันอีเมลสำเร็จ! ตอนนี้คุณสามารถเข้าสู่ระบบได้.";
            } else {
                echo "เกิดข้อผิดพลาดในการยืนยันอีเมล!";
            }
        } else {
            echo "อีเมลนี้ได้ยืนยันแล้ว!";
        }
    } else {
        echo "ไม่พบข้อมูลผู้ใช้!";
    }
} else {
    echo "ไม่มี token สำหรับยืนยันอีเมล!";
}
?>
