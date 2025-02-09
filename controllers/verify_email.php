<?php
include '../config/database.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // ค้นหาผู้ใช้ที่มี token ที่ตรงกับในฐานข้อมูล
    $query = "SELECT * FROM users WHERE verification_token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    // ตรวจสอบว่าลิงก์ยืนยันหมดอายุหรือไม่
    $expiration_time = 3600; // 1 ชั่วโมง
    $current_time = time();
    $sent_time = strtotime($user['verification_sent_at']); // เวลาที่ส่งอีเมล

    if (($current_time - $sent_time) > $expiration_time) {
        echo "ลิงก์ยืนยันหมดอายุแล้ว.";
        exit();
    }


    if ($stmt->rowCount() > 0) {
        // ถ้า token ถูกต้อง, อัปเดตสถานะ email_verified เป็น 1
        $updateQuery = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = :token";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':token', $token);
        $updateStmt->execute();

        echo "ยืนยันอีเมลสำเร็จ! ตอนนี้คุณสามารถเข้าสู่ระบบได้.";
    } else {
        // ถ้าไม่พบ token ที่ตรงกันในฐานข้อมูล
        echo "ลิงก์ยืนยันไม่ถูกต้องหรือหมดอายุ.";
    }
} else {
    // ถ้าไม่มี token มาใน URL
    echo "ไม่มี token สำหรับการยืนยันอีเมล.";
}
?>
