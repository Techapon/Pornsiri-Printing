
<?php

    session_start();
    include "../../server.php";

    $messages = [
        "error_name" => "ชื่อสั้นไป ใจเย็นๆ พิมพ์เพิ่มหน่อย ขอ4ตัวอักษร",
        "error_exit_name" => "ชื่อนี้มีคนใช้แล้ว อย่าก็อปๆ",
        "error_password" => "ตั้งยากๆ หน่อย เดี๋ยวโดนแฮกแล้วร้องไห้ ขอ 6 ตัวอักษร",
        "error_mismatch" => "พิมพ์ไม่เหมือนกัน สตินิดนึงครับพี่",
        "error_condition" => "กดยอมรับเงื่อนไขก่อนสิครับพี่!",
    ];

    if (isset($_POST["signup"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $confirmPassword = trim($_POST["confirmPassword"]);
        $condition = $_POST["condition"];

        // remember session structure
        $remem_session = [
            "username" => $username,
            "password" => $password,
            "confirmPassword" => $confirmPassword,
        ];

        $_SESSION["remem_data"] = $remem_session;

        // error session structure
        $error = [
            "target" => "",
            "message" => ""
        ];

        // username validation
        if (strlen($username) < 4) {
            $error["target"] = "username";
            $error["message"] = $messages["error_name"];
            $_SESSION["error"] = $error;

            header("Location: signup.php");
            exit();
        }

        $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $username_check = $stmt->fetch();

        if ($username_check != null) {
            $error["target"] = "username";
            $error["message"] = $messages["error_exit_name"];

            $_SESSION["error"] = $error;
            header("Location: signup.php");
            exit();
        }

        // password & comfirm password validation
        if ((strlen($password) < 6) || (strlen($confirmPassword) < 6)) {
            $error["target"] = "password";
            $error["message"] = $messages["error_password"];

            $_SESSION["error"] = $error;
            header("Location: signup.php");
            exit();
        }

        if ($password != $confirmPassword) {
            $error["target"] = "confirmpassword";
            $error["message"] = $messages["error_mismatch"];

            $_SESSION["error"] = $error;
            header("Location: signup.php");
            exit();
        }

        // condition validation
        if ($condition != "on") {
            $error["target"] = "condition";
            $error["message"] = $messages["error_condition"];

            $_SESSION["error"] = $error;
            header("Location: signup.php");
            exit();
        }

        // try to Signup
        unset($_SESSION["remem_data"]);
        
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
    
            $_SESSION["success"] = "success";
            header("Location: signup.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error_ontry'] = "เอะ!! เกิดข้อผิดพลาด: " . $e->getMessage();
            header("Location: signup.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pornsiri Printing</title>
    
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
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* Paper Shadow Effect */
        .paper-shadow {
            box-shadow: 10px 10px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }
        .paper-shadow:active {
            box-shadow: 2px 2px 0px 0px rgba(0,0,0,1);
            transform: translate(4px, 4px);
        }

        /* Utility for hiding elements */
        .hidden { display: none !important; }
        
        /* Input Error State */
        .input-error {
            border-color: #ef4444 !important;
            background-color: #fef2f2 !important; /* red-50 */
        }

        /* Dot Background Pattern */
        .bg-dots {
            background-image: radial-gradient(#000000 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            opacity: 0.05;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex items-center justify-center p-4">
    
    <!-- Error Popup: จะแสดงผลเฉพาะเมื่อมี $_SESSION['error'] -->
    <?php if (isset($_SESSION['error_ontry'])) : ?>
    <div id="errorPopup" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white border-4 border-black p-8 max-w-sm w-full relative paper-shadow popup-animate">
            <!-- Decorative Tape -->
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-24 h-8 bg-red-500/80 rotate-2 border border-black z-10"></div>
            
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-4 border-2 border-black">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-black mb-2 font-mono uppercase">พบข้อผิดพลาด!</h3>
                <p class="text-gray-600 mb-6"><?php echo $_SESSION['error_ontry']; ?></p>
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

    <div class="w-full max-w-md mx-auto">
        
        <!-- View 1: Register Form -->
        <div id="registerView">
            <!-- Header Text -->
            <div class="mb-8 text-center">
                <div class="inline-block relative">
                    <h1 class="text-4xl font-bold tracking-tighter mb-2 relative inline-block">
                        PORNSIRI
                        <span class="absolute -right-4 -top-2 text-xs bg-black text-white px-1 font-mono transform rotate-12">PRINTING</span>
                    </h1>
                </div>
                <p id="funMessage" class="text-gray-500 font-mono text-sm mt-2">
                    พร้อมจะเป็นหนี้... เอ้ย ลูกค้าเราหรือยัง?
                </p>
            </div>

            <!-- Card -->
            <div class="bg-white border-2 border-black p-6 md:p-10 relative paper-shadow">
                
                <!-- Decorative Tape -->
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-6 bg-gray-200/50 backdrop-blur-sm rotate-1 border border-gray-300"></div>
                
                <form action="signup.php" method="POST" id="registerForm" class="space-y-4" >
                        
                    <label class="block text-3xl font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                        Sign up <span class="text-gray-400 font-light text-xl">(สร้างตัวตนจ้าา)</span>
                    </label>
                    <!-- Username -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            USERNAME <span class="text-gray-400 font-light text-xs">(ชื่อที่แม่ภูมิใจ)</span>
                        </label>
                        <input type="text" id="username" name="username"
                            value = "<?php if (isset($_SESSION["remem_data"])) { echo $_SESSION["remem_data"]["username"]; } ?>"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="somchai_inwza007"
                            require>
                        <p id="error-username" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Password -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            PASSWORD <span class="text-gray-400 font-light text-xs">(อย่าตั้ง 1234 นะขอร้อง)</span>
                        </label>
                        <input type="password" id="password" name="password"
                            value = "<?php if (isset($_SESSION["remem_data"])) { echo $_SESSION["remem_data"]["password"]; } ?>"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="••••••••"
                            require>
                        <p id="error-password" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            CONFIRM PASSWORD <span class="text-gray-400 font-light text-xs">(ทวนความจำ)</span>
                        </label>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            value = "<?php if (isset($_SESSION["remem_data"])) { echo $_SESSION["remem_data"]["confirmPassword"]; } ?>"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="••••••••"
                            requires>
                        <p id="error-confirmPassword" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Checkbox -->
                    <div class="flex items-start space-x-3 pt-2">
                        <div class="flex items-center h-5">
                            <input id="terms" name="condition" type="checkbox" class="w-5 h-5 border-2 border-black rounded-none focus:ring-0 text-black cursor-pointer appearance-none bg-white checked:bg-black checked:border-black relative checked:after:content-['✓'] checked:after:absolute checked:after:text-white checked:after:text-sm checked:after:left-1 checked:after:-top-0.5" required>
                        </div>
                        <label htmlFor="terms" class="text-xs text-gray-500 cursor-pointer select-none">
                            ข้าพเจ้ายอมรับเงื่อนไขว่า Pornsiri Printing คือที่สุดในย่านนี้ และจะไม่ฟ้องร้องถ้างานสวยเกินไป
                        </label>
                    </div>

                    <?php unset($_SESSION["remem_data"]); ?>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" name="signup"
                        class="w-full bg-black text-white font-mono font-bold py-4 px-6 text-lg uppercase tracking-widest border-2 border-black transition-all transform paper-shadow hover:bg-white hover:text-black hover:-translate-y-1 active:translate-y-0 active:shadow-none disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed disabled:shadow-none disabled:translate-y-0">
                        ยอมรับชะตากรรม
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-6 text-center">
                    <a href="../signin/signin.php" class="text-xs font-mono text-gray-400 hover:text-black hover:underline decoration-wavy">
                        มีไอดีแล้ว? ก็ไป Login สิ จะรออะไร
                    </a>
                </div>
            </div>
            
        </div>

        <!-- View 2: Success Message (Hidden by default) -->
        <div id="successView" class="hidden">
            <div class="bg-white border-2 border-black p-8 w-full text-center paper-shadow relative">
                <div class="absolute -top-6 -left-6 transform -rotate-12 bg-yellow-300 border-2 border-black px-4 py-1 font-mono font-bold">
                   SUCCESS!
               </div>
               <div class="mb-6 flex justify-center">
                   <i data-lucide="printer" class="w-24 h-24 text-black animate-bounce"></i>
               </div>
               <h2 class="text-3xl font-bold mb-2 font-mono">ลงทะเบียนเสร็จแล้ว!</h2>
               <p class="text-gray-600 mb-8">ข้อมูลของคุณถูกบันทึก (และอาจจะถูกนินทา) เรียบร้อยแล้ว</p>
               <button onclick="window.location.href = '../signin/signin.php'"
                   class="w-full bg-black text-white font-mono font-bold py-3 hover:bg-gray-800 transition-all paper-shadow border-2 border-transparent active:border-black">
                   เริ่มจ่าย เอ้ย!! ใช้งานกันเลย!!
               </button>
           </div>
        </div>

    </div>

    <script>
        

        // --- Elements ---
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const registerView = document.getElementById('registerView');
        const successView = document.getElementById('successView');

        // Element sets
        const inputs = {
            username: document.getElementById('username'),
            password: document.getElementById('password'),
            confirmPassword: document.getElementById('confirmPassword')
        };
        const errors = {
            username: document.getElementById('error-username'),
            password: document.getElementById('error-password'),
            confirmPassword: document.getElementById('error-confirmPassword')
        };

        function closeErrorPopup() {
            const popup = document.getElementById('errorPopup');
            if(popup) popup.classList.add('hidden');
        }
        
        // --- Detect Session ---

        <?php if (isset($_SESSION["error"])) { ?>
            showError('<?php echo $_SESSION["error"]["target"]; ?>', '<?php echo $_SESSION["error"]["message"]; ?>');
            <?php unset($_SESSION["error"]); ?>
        <?php }else if (isset($_SESSION["success"])) { ?>
            showSuccess();
            <?php unset($_SESSION["success"]); ?>
        <?php } ?>

        // --- Errors---
        function showError(field, message) {
            inputs[field].classList.add('input-error');
            errors[field].innerText = `⚠️ ${message}`;
            errors[field].classList.remove('hidden');
        }

        // --- Success ---
        function showSuccess() {
            registerView.classList.add('hidden');
            successView.classList.remove('hidden');
            
            lucide.createIcons();
        }

        // Initialize Icons
        lucide.createIcons();
    </script>
</body>
</html>