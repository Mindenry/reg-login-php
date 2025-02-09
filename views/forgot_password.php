<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Forgot Password</h2>
    <form action="../controllers/forgot_password.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="forgot_password">Reset Password</button>
    </form>
</body>
</html>
