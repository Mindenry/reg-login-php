<?php
include '../config/database.php';

if (!isset($_GET['token'])) {
    die("Invalid token!");
}

$token = $_GET['token'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Invalid or expired token!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Reset Password</h2>
    <form action="../controllers/reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="reset_password">Update Password</button>
    </form>
</body>
</html>
