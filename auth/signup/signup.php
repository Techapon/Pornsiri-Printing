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

                <form id="registerForm" class="space-y-4" novalidate>
                    
                    <label class="block text-3xl font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                        Sign up <span class="text-gray-400 font-light text-xl">(สร้างตัวตนจ้าา)</span>
                    </label>
                    <!-- Username -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            USERNAME <span class="text-gray-400 font-light text-xs">(ชื่อที่แม่ภูมิใจ)</span>
                        </label>
                        <input type="text" id="username" name="username"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="somchai_inwza007">
                        <p id="error-username" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Password -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            PASSWORD <span class="text-gray-400 font-light text-xs">(อย่าตั้ง 1234 นะขอร้อง)</span>
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="••••••••">
                        <p id="error-password" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative group">
                        <label class="block text-sm font-bold mb-1 font-mono group-hover:text-blue-600 transition-colors">
                            CONFIRM PASSWORD <span class="text-gray-400 font-light text-xs">(ทวนความจำ)</span>
                        </label>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            class="w-full bg-gray-50 border-2 border-black focus:border-blue-500 p-3 font-mono outline-none transition-all placeholder-gray-300"
                            placeholder="••••••••">
                        <p id="error-confirmPassword" class="text-red-500 text-xs mt-1 font-bold hidden"></p>
                    </div>

                    <!-- Checkbox -->
                    <div class="flex items-start space-x-3 pt-2">
                        <div class="flex items-center h-5">
                            <input id="terms" type="checkbox" class="w-5 h-5 border-2 border-black rounded-none focus:ring-0 text-black cursor-pointer appearance-none bg-white checked:bg-black checked:border-black relative checked:after:content-['✓'] checked:after:absolute checked:after:text-white checked:after:text-sm checked:after:left-1 checked:after:-top-0.5" required>
                        </div>
                        <label htmlFor="terms" class="text-xs text-gray-500 cursor-pointer select-none">
                            ข้าพเจ้ายอมรับเงื่อนไขว่า Pornsiri Printing คือที่สุดในย่านนี้ และจะไม่ฟ้องร้องถ้างานสวยเกินไป
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn"
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
               <button onclick="window.location.reload()"
                   class="w-full bg-black text-white font-mono font-bold py-3 hover:bg-gray-800 transition-all paper-shadow border-2 border-transparent active:border-black">
                   เริ่มจ่าย เอ้ย!! ใช้งานกันเลย!!
               </button>
           </div>
        </div>

    </div>

    <script>
        // --- Configuration ---
        const messages = {
            idle: "พร้อมจะเป็นหนี้... เอ้ย ลูกค้าเราหรือยัง?",
            typing_user: "ชื่อเท่ๆ นะ เอาแบบไม่อายใคร",
            typing_pass: "ตั้งยากๆ หน่อย เดี๋ยวโดนแฮกแล้วร้องไห้",
            typing_confirm: "จำรหัสเมื่อกี้ได้ป่าว? หรือลืมแล้ว?",
            error_mismatch: "พิมพ์ไม่เหมือนกัน สตินิดนึงครับพี่",
            success: "ยินดีด้วย คุณได้ไปต่อ (ในหน้า Login)"
        };

        // --- Elements ---
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const funMessageEl = document.getElementById('funMessage');
        const registerView = document.getElementById('registerView');
        const successView = document.getElementById('successView');
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

        // --- Event Listeners for Typing Fun Messages ---
        inputs.username.addEventListener('focus', () => funMessageEl.innerText = messages.typing_user);
        inputs.password.addEventListener('focus', () => funMessageEl.innerText = messages.typing_pass);
        inputs.confirmPassword.addEventListener('focus', () => funMessageEl.innerText = messages.typing_confirm);
        
        // Clear errors on input
        Object.keys(inputs).forEach(key => {
            inputs[key].addEventListener('input', () => {
                inputs[key].classList.remove('input-error');
                errors[key].classList.add('hidden');
                errors[key].innerText = '';
            });
        });

        // --- Form Submission Logic ---
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset Errors
            let isValid = true;
            Object.values(errors).forEach(el => el.classList.add('hidden'));
            Object.values(inputs).forEach(el => el.classList.remove('input-error'));

            // Validation Rules
            // 1. Username
            if (!inputs.username.value.trim()) {
                showError('username', "ไม่ใส่ชื่อแล้วจะรู้ไหมใคร");
                isValid = false;
            } else if (inputs.username.value.length < 3) {
                showError('username', "ชื่อสั้นไป ใจเย็นๆ พิมพ์เพิ่มหน่อย");
                isValid = false;
            }

            // 2. Password
            if (!inputs.password.value) {
                showError('password', "รหัสผ่านหายไปไหน?");
                isValid = false;
            } else if (inputs.password.value.length < 6) {
                showError('password', "รหัสสั้นไป เดี๋ยวโดนแฮกง่ายๆ");
                isValid = false;
            }

            // 3. Confirm Password
            if (inputs.password.value !== inputs.confirmPassword.value) {
                showError('confirmPassword', "รหัสไม่ตรงกัน ความจำสั้นนะเรา");
                funMessageEl.innerText = messages.error_mismatch;
                isValid = false;
            }

            if (!document.getElementById('terms').checked) {
                alert("กดยอมรับเงื่อนไขก่อนสิครับพี่!");
                isValid = false;
            }

            // If Valid
            if (isValid) {
                setLoading(true);
                funMessageEl.innerText = "กำลังส่งข้อมูลไปจักรวาลนฤมิต...";

                // Simulate Network Request
                setTimeout(() => {
                    setLoading(false);
                    showSuccess();
                }, 2000);
            } else {
                // Shake effect logic could go here
            }
        });

        // --- Helper Functions ---
        function showError(field, message) {
            inputs[field].classList.add('input-error');
            errors[field].innerText = `⚠️ ${message}`;
            errors[field].classList.remove('hidden');
        }

        function setLoading(isLoading) {
            if (isLoading) {
                submitBtn.disabled = true;
                submitBtn.innerText = "กำลังโหลด (ใจร่มๆ)...";
            } else {
                submitBtn.disabled = false;
                submitBtn.innerText = "ยอมรับชะตากรรม";
            }
        }

        function showSuccess() {
            funMessageEl.innerText = messages.success;
            registerView.classList.add('hidden');
            successView.classList.remove('hidden');
            // Re-initialize icons for the new view
            lucide.createIcons();
        }

        // Initialize Icons
        lucide.createIcons();
    </script>
</body>
</html>