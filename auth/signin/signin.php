<?php
    session_start();
    include "../../server.php";

    // ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
    if (isset($_POST["signin"])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        echo "yeah";
        try {
            // ค้นหาผู้ใช้ในฐานข้อมูล
            $stmt = $conn->prepare("SELECT id, username, password ,role FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch();

            // // ตรวจสอบว่าพบผู้ใช้และรหัสผ่านถูกต้องหรือไม่
            if ( $user['password'] == $password) {


                switch ($user['role']) {
                    // General user
                    case 0:
                        // Login สำเร็จ
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        header("Location: ../../user/user_orders.php");
                        exit();
                        break;
                    // Admin
                    case 1:
                        // Login สำเร็จ
                        $_SESSION['admin_id'] = $user['id'];
                        $_SESSION['admin_name'] = $user['username'];
                        header("Location: ../../admin/orders_mng.php");
                        exit();
                        break;
                }
            } else {
                // Login ไม่สำเร็จ
                $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
                header("Location: signin.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $e->getMessage();
            header("Location: signin.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pornsiri Printing</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Kanit & JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f4f5;
            overflow-x: hidden;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Paper Shadow Effect */
        .paper-shadow {
            box-shadow: 10px 10px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }
        .paper-shadow:active {
            box-shadow: 2px 2px 0px 0px rgba(0,0,0,1);
            transform: translate(4px, 4px);
        }

        /* Dot Background Pattern */
        .bg-dots {
            background-image: radial-gradient(#000000 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            opacity: 0.05;
        }

        /* Error Popup Animation */
        @keyframes popup-show {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .popup-animate {
            animation: popup-show 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        
        .hidden { display: none !important; }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center p-4">

    <!-- Error Popup: จะแสดงผลเฉพาะเมื่อมี $_SESSION['error'] -->
    <?php if (isset($_SESSION['error'])) : ?>
    <div id="errorPopup" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white border-4 border-black p-8 max-w-sm w-full relative paper-shadow popup-animate">
            <!-- Decorative Tape -->
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-24 h-8 bg-red-500/80 rotate-2 border border-black z-10"></div>
            
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-4 border-2 border-black">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-black mb-2 font-mono uppercase">พบข้อผิดพลาด!</h3>
                <p class="text-gray-600 mb-6"><?php echo $_SESSION['error']; ?></p>
                <button onclick="closeErrorPopup()" 
                        class="w-full bg-black text-white font-mono font-bold py-3 border-2 border-black hover:bg-red-600 transition-colors">
                    รับทราบ (จะตั้งสติใหม่)
                </button>
            </div>
        </div>
    </div>
    <?php 
        // เคลียร์ error ทันทีหลังจากแสดงผล เพื่อไม่ให้มันค้างตอนรีเฟรชหน้า
        unset($_SESSION['error']); 
    ?>
    <?php endif; ?>

    <!-- Background Layer -->
    <div class="fixed inset-0 bg-dots pointer-events-none"></div>

    <div class="w-full max-w-md mx-auto z-10">
        <!-- Header Text -->
        <div class="mb-8 text-center">
            <div class="inline-block relative">
                <h1 class="text-4xl font-bold tracking-tighter mb-2 relative inline-block">
                    PORNSIRI
                    <span class="absolute -right-4 -top-2 text-xs bg-black text-white px-1 font-mono transform rotate-12">PRINTING</span>
                </h1>
            </div>
            <p id="funMessage" class="text-gray-500 font-mono text-sm mt-2">
                กลับมาทำไม... เอ้ย ยินดีต้อนรับกลับครับ
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-white border-2 border-black p-6 md:p-10 relative paper-shadow">
            <!-- Decorative Tape -->
            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-gray-200/50 backdrop-blur-sm rotate-2 border border-gray-300"></div>

            <form id="loginForm" class="space-y-6" action="signin.php" method="POST">
                <label class="block text-3xl font-bold mb-1 font-mono">
                    Sign in <span class="text-gray-400 font-light text-xl">(ชำระกรรม..)</span>
                </label>

                <div class="relative group">
                    <label class="block text-sm font-bold mb-1 font-mono group-hover:text-red-600 transition-colors">
                        USERNAME
                    </label>
                    <input type="text" id="username" name="username" required
                        class="w-full bg-gray-50 border-2 border-black focus:border-red-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                        placeholder="your_name_here">
                </div>

                <div class="relative group">
                    <div class="flex justify-between items-end mb-1">
                        <label class="block text-sm font-bold font-mono group-hover:text-red-600 transition-colors">
                            PASSWORD
                        </label>
                        <a href="#" class="text-[10px] text-gray-400 hover:text-black font-mono">ลืมรหัส? สมน้ำหน้า</a>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full bg-gray-50 border-2 border-black focus:border-red-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                        placeholder="••••••••">
                </div>

                <button type="submit" name="signin" id="submitBtn"
                    class="w-full bg-black text-white font-mono font-bold py-4 px-6 text-lg uppercase tracking-widest border-2 border-black transition-all transform paper-shadow hover:bg-white hover:text-black hover:-translate-y-1 active:translate-y-0 active:shadow-none">
                    เข้าไปรับชะตากรรม
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-xs font-mono text-gray-400 mb-2">ยังไม่มีพวก? (ไม่มีไอดี)</p>
                <a href="../signup/signup.php" class="inline-block bg-yellow-300 border-2 border-black px-4 py-1 font-bold text-sm hover:bg-white transition-colors">
                    ไปสมัครใหม่ซะ
                </a>
            </div>
        </div>
    </div>

    <script>
        const funMessage = document.getElementById('funMessage');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');

        function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            if(popup) popup.classList.add('hidden');
        }

        // Typing effects
        usernameInput.addEventListener('focus', () => {
            funMessage.innerText = "พิมพ์ชื่อให้ถูกนะ ผมจ้องคุณอยู่";
        });

        passwordInput.addEventListener('focus', () => {
            funMessage.innerText = "แอบดูรหัสผ่านแป๊บ... อ้อ ไม่เห็นหรอก";
        });

        lucide.createIcons();
    </script>
</body>
</html>