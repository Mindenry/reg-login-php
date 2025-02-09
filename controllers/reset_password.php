<?php
include '../config/database.php';

if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
        $stmt->execute([$new_password, $user['id']]);
        echo "Password updated successfully!";
        header("Location: ../login.php");
        exit();
    } else {
        echo "Invalid or expired token!";
    }
}
?>
