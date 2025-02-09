<?php
include '../config/database.php';

if (isset($_POST['forgot_password'])) {
    $email = trim($_POST['email']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->execute([$token, $expiry, $email]);

        // ส่งอีเมล (ในที่นี้จะแสดงลิงก์เท่านั้น)
        $reset_link = "http://yourdomain.com/views/reset_password.php?token=" . $token;
        echo "Reset link: " . $reset_link;
    } else {
        echo "Email not found!";
    }
}
?>
