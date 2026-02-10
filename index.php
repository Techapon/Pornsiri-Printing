<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Pornsiri Printing</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Kanit:wght@300;400;600;900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Dot Background Pattern */
        .bg-dots {
            background-image: radial-gradient(#000000 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            opacity: 0.15;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Glitch Text Effect */
        .glitch-text:hover {
            animation: glitch-anim 0.3s cubic-bezier(.25, .46, .45, .94) both infinite;
            color: #ef4444;
        }
        @keyframes glitch-anim {
            0% { transform: translate(0) }
            20% { transform: translate(-2px, 2px) }
            40% { transform: translate(-2px, -2px) }
            60% { transform: translate(2px, 2px) }
            80% { transform: translate(2px, -2px) }
            100% { transform: translate(0) }
        }

        /* Floating Animation */
        .float-slow {
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        /* Image Card Hover */
        .img-card {
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            filter: grayscale(100%) contrast(120%);
        }
        .img-card-container:hover .img-card {
            filter: grayscale(0%) contrast(100%);
            transform: scale(1.05) translateY(-10px);
        }

        /* Scroll Down Indicator */
        .scroll-indicator {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }
    </style>
</head>
<body class="relative">

    <!-- Background Layer -->
    <div class="fixed inset-0 bg-dots pointer-events-none"></div>

    <!-- SECTION 1: HERO (CENTERED) -->
    <section class="h-screen w-full flex flex-col items-center justify-center relative px-4 overflow-hidden">
        
        <!-- Random Floating Text Decoration -->
        <div class="absolute top-[15%] left-[10%] opacity-20 hidden md:block float-slow font-mono font-bold text-4xl rotate-12">หมึกหมดก็เติมเอง</div>
        <div class="absolute bottom-[20%] right-[15%] opacity-20 hidden md:block float-slow font-mono font-bold text-4xl -rotate-6">งานเร่ง...ส่งปีหน้า</div>
        
        <div class="z-10 text-center">
            <div class="inline-block relative">
                <h1 class="text-6xl md:text-9xl font-black tracking-tighter text-black uppercase glitch-text cursor-default">
                    PORNSIRI<br><span class="bg-black text-white px-2">PRINTING</span>
                </h1>
                <div class="absolute -top-10 -right-10 bg-red-600 text-white text-xs font-mono py-1 px-2 rotate-12 shadow-lg">
                    HOT! (มั้ง)
                </div>
            </div>
            
            <div class="mt-10 max-w-lg mx-auto">
                <p class="text-xl md:text-2xl font-bold text-gray-800 mb-2">
                    "รับพิมพ์ทุกอย่าง ยกเว้นแบงค์พัน"
                </p>
                <p class="text-gray-500 font-mono text-sm">
                    เรายินดีบริการคุณด้วยใจ... แต่ถ้าเรื่องมาก เราขอคิดเพิ่มสองเท่า <br>
                    งานพิมพ์คมชัดและละเอียด(ยิ่งกว่าเม็ดทราย) จนคุณต้องร้องว่า "ว้าว!"
                </p>
            </div>
        </div>

        <!-- Scroll Down Arrow -->
        <div class="absolute bottom-10 text-center scroll-indicator">
            <p class="font-mono text-xs mb-2 font-bold">เลื่อนลงไปดูทางเลือกชีวิต</p>
            <i data-lucide="chevron-down" class="w-8 h-8 mx-auto"></i>
        </div>
    </section>

    <!-- SECTION 2: CHOICES -->
    <section id="choices" class="min-h-screen w-full flex flex-col items-center justify-center py-20 bg-black text-white relative">
        
        <div class="mb-16 text-center z-10">
            <h2 class="text-4xl font-black mb-4 uppercase tracking-widest">เลือกให้ดี... ชะตาชีวิตอยู่ที่นี่</h2>
            <div class="h-1 w-24 bg-white mx-auto"></div>
        </div>

        <div class="flex flex-col md:flex-row justify-center items-center gap-12 md:gap-24 px-4 w-full max-w-6xl z-10">
            
            <!-- OPTION: SIGN UP (Fish Guy) -->
            <a href="auth/signup/signup.php" class="img-card-container group relative">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 z-20">
                    <div class="bg-blue-500 text-white px-4 py-2 rounded font-bold font-mono text-sm whitespace-nowrap shadow-xl">
                        "มาเป็นเหยื่อ เอ้ย ลูกค้าใหม่"
                    </div>
                </div>

                <div class="w-64 h-80 md:w-80 md:h-[450px] bg-white border-4 border-white shadow-[0px_0px_30px_rgba(255,255,255,0.2)] overflow-hidden relative transition-all group-hover:border-blue-500">
                    <img src="assets/2.png" alt="Sign Up" class="img-card w-full h-full object-cover">
                    
                    <div class="absolute bottom-0 left-0 w-full bg-blue-500 text-white py-4 font-black font-mono text-2xl tracking-tighter group-hover:bg-blue-600 transition-colors text-center">
                        SIGN UP
                    </div>
                </div>
                <div class="text-center mt-4 font-mono text-gray-500 group-hover:text-blue-400 transition-colors">ยังไม่มีรหัส? กดสิรออะไร</div>
            </a>

            <!-- VS (Decoration) -->
            <div class="hidden md:block text-6xl font-black font-mono text-gray-800 rotate-12">
                VS
            </div>

            <!-- OPTION: SIGN IN (Close Up Face) -->
            <a href="auth/signin/signin.php" class="img-card-container group relative">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 z-20">
                    <div class="bg-red-500 text-white px-4 py-2 rounded font-bold font-mono text-sm whitespace-nowrap shadow-xl">
                        "มองหน้าแบบนี้... ล็อกอินแล้วหรอ?"
                    </div>
                </div>

                <div class="w-64 h-80 md:w-80 md:h-[450px] bg-white border-4 border-white shadow-[0px_0px_30px_rgba(255,255,255,0.2)] overflow-hidden relative transition-all group-hover:border-red-500">
                    <img src="assets/1.png" alt="Sign In" class="img-card w-full h-full object-cover scale-110">
                    
                    <div class="absolute bottom-0 left-0 w-full bg-red-500 text-white py-4 font-black font-mono text-2xl tracking-tighter group-hover:bg-red-600 transition-colors text-center">
                        SIGN IN
                    </div>
                </div>
                <div class="text-center mt-4 font-mono text-gray-500 group-hover:text-red-400 transition-colors">ลูกค้าเก่า เจ้าประจำ</div>
            </a>

        </div>

        <!-- Decorative Text Overlay -->
        <div class="absolute inset-0 flex items-center justify-center opacity-5 select-none pointer-events-none overflow-hidden">
            <span class="text-[20vw] font-black text-white whitespace-nowrap">PORNSIRI PORNSIRI PORNSIRI</span>
        </div>
    </section>

    <!-- Marquee Footer -->
    <div class="fixed bottom-0 w-full bg-yellow-400 text-black py-2 overflow-hidden border-t-2 border-black z-50">
        <div class="whitespace-nowrap animate-marquee inline-block font-mono font-bold">
            • รวดเร็ว • แม่นยำ • พิมพ์ผิดไม่รับคืน • จ่ายก่อนงานเริ่ม • ยินดีต้อนรับสู่ PORNSIRI PRINTING • บริการด้วยความงง • 
            • รวดเร็ว • แม่นยำ • พิมพ์ผิดไม่รับคืน • จ่ายก่อนงานเริ่ม • ยินดีต้อนรับสู่ PORNSIRI PRINTING • บริการด้วยความงง • 
        </div>
    </div>

    <style>
        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
    </style>

    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Simple scroll reveal for the choices
        window.addEventListener('scroll', () => {
            const section = document.getElementById('choices');
            const pos = section.getBoundingClientRect().top;
            const winH = window.innerHeight;
            if (pos < winH) {
                // Section is visible
            }
        });
    </script>
</body>
</html>