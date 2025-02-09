<?php
session_start(); // เริ่มต้น session
include '../config/database.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$pdo) {
    die("เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล!");
}

// ใช้ PHPMailer สำหรับการส่งอีเมลยืนยัน
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; // ต้องโหลดไฟล์ autoload ของ Composer

// สำหรับการสมัครสมาชิก (register)
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน
    $role = 'user'; // กำหนด role เป็น 'user' โดยอัตโนมัติ
    $verification_token = bin2hex(random_bytes(50)); // สร้าง token สำหรับการยืนยัน

    // ตรวจสอบว่าอีเมลหรือ username ซ้ำหรือไม่
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);

    if ($stmt->rowCount() > 0) {
        echo "Username หรือ Email นี้ถูกใช้งานแล้ว!";
        exit();
    }

    // บันทึกข้อมูลลงฐานข้อมูล
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, verification_token, email_verified) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $password, $role, $verification_token, 0])) {
        // ส่งอีเมลยืนยัน
        $verification_link = "http://yourdomain.com/views/verify.php?token=" . $verification_token;
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mindenrymmd@gmail.com'; // อีเมลของคุณ
            $mail->Password = 'vqiu pygl ainw ivfu';  // รหัสผ่านแอปจาก Google
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // ผู้ส่งและผู้รับ
            $mail->setFrom('admin@admin.com', 'Admin');
            $mail->addAddress($email);

            // เนื้อหาของอีเมล
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email';
            $mail->Body    = 'Click on the link to verify your email: ' . $verification_link;

            // ส่งอีเมล
            $mail->send();
            echo 'สมัครสมาชิกสำเร็จ! กรุณาตรวจสอบอีเมลเพื่อยืนยัน';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "เกิดข้อผิดพลาดในการสมัครสมาชิก!";
    }
}

// LOGIN (เข้าสู่ระบบ)
// LOGIN (เข้าสู่ระบบ)
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ตรวจสอบการยืนยันอีเมล
        if ($user['email_verified'] == 0) {
            echo "กรุณายืนยันอีเมลก่อนเข้าสู่ระบบ.";
            exit();
        }

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];  // เพิ่มการตั้งค่า role ใน Session

            // Remember Me (จดจำการเข้าสู่ระบบ)
            if (isset($_POST['remember'])) {
                setcookie('user_id', $user['id'], time() + (86400 * 30), "/"); // 30 วัน
                setcookie('username', $user['username'], time() + (86400 * 30), "/");
                setcookie('role', $user['role'], time() + (86400 * 30), "/");  // เก็บ role ลงใน Cookie
            }

            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "อีเมลหรือรหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        echo "ไม่พบผู้ใช้ในระบบ!";
    }
}

?>
