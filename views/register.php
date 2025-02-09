<?php include '../config/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Authentication</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-color: #1f2937;
            --input-border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--bg-color);
            background-image: 
                radial-gradient(at 40% 20%, rgba(79, 70, 229, 0.1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, rgba(59, 130, 246, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 50%, rgba(236, 72, 153, 0.1) 0px, transparent 50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
                        0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .auth-container:hover {
            transform: translateY(-5px);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        h2 {
            color: var(--text-color);
            text-align: center;
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--input-border);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--card-bg);
            color: var(--text-color);
        }

        input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background: var(--primary-hover);
        }

        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-container {
            animation: fadeIn 0.6s ease-out;
        }

        @media (max-width: 640px) {
            .auth-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <i class="fas fa-user-plus"></i>
        </div>
        <h2>ลงทะเบียน</h2>
        <form action="../controllers/auth.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="อีเมล" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="รหัสผ่าน" required>
            </div>
            <button type="submit" name="register">ลงทะเบียน</button>
            <div class="auth-links">
                <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
            </div>
        </form>
    </div>
</body>
</html>