<?php
session_start();

// ถ้าไม่มีการล็อกอิน ให้เด้งไปหน้า login.php
if (!isset($_SESSION['user_id'])) {
    // ตรวจสอบว่ามี Cookie หรือไม่ (Remember Me)
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role']; // กำหนด role จาก Cookie
    } else {
        header("Location: login.php");
        exit();
    }
}

if ($_SESSION['role'] === 'admin') {
    echo "Welcome Admin, " . htmlspecialchars($_SESSION['username']);
    // ส่วนของ Admin
    echo "<br>Admin Dashboard";
} else {
    echo "Welcome User, " . htmlspecialchars($_SESSION['username']);
    // ส่วนของ User
    echo "<br>User Dashboard";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ระบบจัดการสมาชิก</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-color: #1f2937;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
        }

        .dashboard {
            display: flex;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--card-bg);
            min-height: 100vh;
            padding: 2rem;
            position: fixed;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--bg-color);
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }

        .nav-menu {
            margin-top: 2rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-item i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--primary-color);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        /* Recent Activity */
        .recent-activity {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th,
        .activity-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--bg-color);
        }

        .activity-table th {
            font-weight: 600;
            color: #6b7280;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-success {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .logout-btn {
            width: 100%;
            padding: 1rem;
            margin-top: 2rem;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="profile-image">
                    <i class="fas fa-user"></i>
                </div>
                <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                <p><?php echo $_SESSION['role'] === 'admin' ? 'ผู้ดูแลระบบ' : 'สมาชิก'; ?></p>
            </div>

            <nav class="nav-menu">
                <a href="#" class="nav-item active">
                    <i class="fas fa-home"></i>
                    แดชบอร์ด
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-user"></i>
                    โปรไฟล์
                </a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i>
                    จัดการสมาชิก
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    ตั้งค่าระบบ
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    รายงาน
                </a>
                <?php endif; ?>
            </nav>

            <button class="logout-btn" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
            </button>
        </aside>

        <main class="main-content">
            <div class="header">
                <div class="welcome-text">
                    สวัสดี, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </div>
                <div class="date">
                    <?php echo date('d F Y'); ?>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div class="stat-value">2,451</div>
                    <div class="stat-label">จำนวนสมาชิกทั้งหมด</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                    <div class="stat-value">128</div>
                    <div class="stat-label">สมาชิกใหม่เดือนนี้</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                    <div class="stat-value">85%</div>
                    <div class="stat-label">อัตราการเติบโต</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div class="stat-value">24</div>
                    <div class="stat-label">การเข้าสู่ระบบวันนี้</div>
                </div>
            </div>

            <div class="recent-activity">
                <div class="activity-header">
                    <h3>กิจกรรมล่าสุด</h3>
                    <a href="#" style="color: var(--primary-color); text-decoration: none;">
                        ดูทั้งหมด <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>วันที่/เวลา</th>
                            <th>ผู้ใช้</th>
                            <th>กิจกรรม</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>09 ก.พ. 2567 15:30</td>
                            <td>user123</td>
                            <td>เข้าสู่ระบบ</td>
                            <td><span class="status-badge status-success">สำเร็จ</span></td>
                        </tr>
                        <tr>
                            <td>09 ก.พ. 2567 14:45</td>
                            <td>admin</td>
                            <td>อัปเดตข้อมูลสมาชิก</td>
                            <td><span class="status-badge status-success">สำเร็จ</span></td>
                        </tr>
                        <tr>
                            <td>09 ก.พ. 2567 13:20</td>
                            <td>newuser</td>
                            <td>ลงทะเบียน</td>
                            <td><span class="status-badge status-pending">รอยืนยัน</span></td>
                        </tr>
                        <tr>
                            <td>09 ก.พ. 2567 12:15</td>
                            <td>member456</td>
                            <td>แก้ไขโปรไฟล์</td>
                            <td><span class="status-badge status-success">สำเร็จ</span></td>
                        </tr>
                        <tr>
                            <td>09 ก.พ. 2567 11:30</td>
                            <td>user789</td>
                            <td>เปลี่ยนรหัสผ่าน</td>
                            <td><span class="status-badge status-success">สำเร็จ</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Toggle Sidebar on Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.createElement('button');
            menuButton.innerHTML = '<i class="fas fa-bars"></i>';
            menuButton.style.cssText = `
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
                padding: 0.5rem;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 0.5rem;
                cursor: pointer;
                display: none;
            `;

            document.body.appendChild(menuButton);

            menuButton.addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            // Show/hide menu button based on screen size
            function handleResize() {
                if (window.innerWidth <= 768) {
                    menuButton.style.display = 'block';
                } else {
                    menuButton.style.display = 'none';
                    document.querySelector('.sidebar').classList.remove('active');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial check
        });
    </script>
</body>
</html>