<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการสมาชิก</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5 0%, #10b981 100%);
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .content {
            max-width: 800px;
            text-align: center;
            color: white;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            font-size: 4rem;
            margin-bottom: 2rem;
            color: white;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .feature {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature i {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-primary {
            background: white;
            color: #4f46e5;
        }

        .btn-primary:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>ยินดีต้อนรับสู่ระบบจัดการสมาชิก</h1>
            <p>ระบบที่ช่วยให้คุณจัดการข้อมูลได้อย่างมีประสิทธิภาพและปลอดภัย</p>
            
            <div class="features">
                <div class="feature">
                    <i class="fas fa-lock"></i>
                    <h3>ความปลอดภัยสูง</h3>
                    <p>ระบบรักษาความปลอดภัยที่ได้มาตรฐาน</p>
                </div>
                <div class="feature">
                    <i class="fas fa-tachometer-alt"></i>
                    <h3>ใช้งานง่าย</h3>
                    <p>อินเตอร์เฟซที่เรียบง่ายและเป็นมิตร</p>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-line"></i>
                    <h3>ประสิทธิภาพสูง</h3>
                    <p>รวดเร็วและเสถียรในการใช้งาน</p>
                </div>
            </div>

            <div class="buttons">
                <a href="views/login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ
                </a>
                <a href="views/register.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> ลงทะเบียน
                </a>
            </div>
        </div>
    </div>
</body>
</html>