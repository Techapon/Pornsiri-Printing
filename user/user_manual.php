<?php
    session_start();
    include "../server.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/signin/signin.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>คู่มือการใช้งาน - Pornsiri Printing</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background-color: #f4f4f5;
        }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        .paper-shadow {
            box-shadow: 8px 8px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }

        .bg-dots {
            background-image: radial-gradient(#000000 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.05;
        }

        /* .step-line::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: -16px;
            width: 2px;
            background-color: black;
        } */

        .step-line:last-child::before {
            display: none;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeInUp 0.4s ease forwards;
        }
        .fade-in-delay-1 { animation-delay: 0.05s; opacity: 0; }
        .fade-in-delay-2 { animation-delay: 0.10s; opacity: 0; }
        .fade-in-delay-3 { animation-delay: 0.15s; opacity: 0; }
        .fade-in-delay-4 { animation-delay: 0.20s; opacity: 0; }
    </style>
</head>
<body class="min-h-screen pb-20">

    <div class="fixed inset-0 bg-dots pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white border-b-4 border-black p-4 mb-8">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black font-mono tracking-tighter uppercase">
                PORNSIRI <span class="bg-black text-white px-1">MANUAL</span>
            </h1>
            <div class="flex items-center space-x-4">
                <a href="user_orders.php" class="flex items-center space-x-1 text-xs font-mono border-2 border-black px-3 py-1 hover:bg-black hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-3 h-3"></i>
                    <span>กลับหน้าหลัก</span>
                </a>
                <span class="text-xs font-mono hidden md:block">USER: <?php echo ucfirst($_SESSION['username']) ?></span>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 space-y-10 relative">

        <!-- Hero -->
        <div class="fade-in fade-in-delay-1 bg-black text-white border-4 border-black p-8 paper-shadow relative overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="flex items-center space-x-4 mb-4">
                <div class="bg-white text-black p-3 border-2 border-white">
                    <i data-lucide="book-open" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="font-mono text-xs text-gray-400 uppercase tracking-widest">PORNSIRI PRINTING</p>
                    <h2 class="text-3xl font-black font-mono uppercase tracking-tight">คู่มือการใช้งาน</h2>
                </div>
            </div>
            <p class="font-mono text-sm text-gray-300 max-w-lg">
                ทุกสิ่งที่คุณต้องรู้เกี่ยวกับการสั่งพิมพ์ผ่าน PORNSIRI PRINTING — ตั้งแต่ขั้นตอนสั่งงาน จนถึงการรับงาน
            </p>
        </div>

        <!-- Section 1: วิธีสั่งพิมพ์ -->
        <section class="fade-in fade-in-delay-2">
            <div class="flex items-center mb-6">
                <i data-lucide="mouse-pointer-click" class="mr-2 w-5 h-5"></i>
                <h2 class="text-xl font-bold uppercase font-mono">วิธีสั่งพิมพ์งาน</h2>
            </div>

            <div class="space-y-4">

                <!-- Step 1 -->
                <div class="relative step-line bg-white border-2 border-black p-5">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-black text-white flex items-center justify-center font-mono font-bold text-lg border-2 border-black">1</div>
                        <div>
                            <h3 class="font-bold font-mono text-base mb-1">เตรียมไฟล์งาน</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                อัปโหลดไฟล์งานของคุณไปยัง <span class="font-bold">Google Drive</span> หรือบริการคลาวด์อื่นๆ
                                จากนั้นตั้งค่าการแชร์ไฟล์เป็น <span class="bg-yellow-200 px-1 font-bold">"ทุกคนที่มีลิ้งก์"</span> สามารถเปิดดูได้
                            </p>
                            <div class="mt-3 bg-yellow-50 border-l-4 border-yellow-400 p-3">
                                <p class="text-xs font-mono text-yellow-800">
                                    ⚠️ ถ้าไฟล์เปิดไม่ได้ เราจะไม่สามารถดำเนินการสั่งพิมพ์ให้ได้นะ!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative step-line bg-white border-2 border-black p-5">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-black text-white flex items-center justify-center font-mono font-bold text-lg border-2 border-black">2</div>
                        <div>
                            <h3 class="font-bold font-mono text-base mb-1">กรอกข้อมูลการสั่งพิมพ์</h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-3">กรอกรายละเอียดในฟอร์ม "สั่งพิมพ์งานใหม่" ให้ครบถ้วน</p>
                            <div class="grid sm:grid-cols-2 gap-2">
                                <div class="bg-gray-50 border border-black p-3">
                                    <p class="text-xs font-mono font-bold mb-1">📎 LINK OF FILE</p>
                                    <p class="text-xs text-gray-600">วางลิ้งก์ไฟล์ที่แชร์แล้ว</p>
                                </div>
                                <div class="bg-gray-50 border border-black p-3">
                                    <p class="text-xs font-mono font-bold mb-1">💬 MESSAGE</p>
                                    <p class="text-xs text-gray-600">ระบุรายละเอียดเพิ่มเติม เช่น ปริ้นสี, หน้าเดียว</p>
                                </div>
                                <div class="bg-gray-50 border border-black p-3">
                                    <p class="text-xs font-mono font-bold mb-1">📄 PAPER TYPE</p>
                                    <p class="text-xs text-gray-600">เลือกประเภทกระดาษที่ต้องการ</p>
                                </div>
                                <div class="bg-gray-50 border border-black p-3">
                                    <p class="text-xs font-mono font-bold mb-1">📐 SIZE & QUANTITY</p>
                                    <p class="text-xs text-gray-600">เลือกขนาดและจำนวนชุดที่ต้องการ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative step-line bg-white border-2 border-black p-5">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-black text-white flex items-center justify-center font-mono font-bold text-lg border-2 border-black">3</div>
                        <div>
                            <h3 class="font-bold font-mono text-base mb-1">กด ADD ORDER และรอการยืนยัน</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                หลังกดส่งคำสั่ง ระบบจะสร้างออเดอร์ให้โดยอัตโนมัติ รอให้ทางร้านตรวจสอบและเปลี่ยนสถานะเป็น
                                <span class="bg-yellow-300 border border-black px-1 text-xs font-bold">รอคิวปริ้น</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative bg-white border-2 border-black p-5">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-400 text-black flex items-center justify-center font-mono font-bold text-lg border-2 border-black">4</div>
                        <div>
                            <h3 class="font-bold font-mono text-base mb-1">รับงานเมื่อสถานะเป็น "ปริ้นสำเร็จ"</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                เมื่อสถานะออเดอร์เปลี่ยนเป็น <span class="bg-green-300 border border-black px-1 text-xs font-bold">ปริ้นสำเร็จ</span> แสดงว่างานพร้อมให้รับแล้ว
                                มารับงานได้ที่ร้านได้เลย!
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Section 2: สถานะออเดอร์ -->
        <section class="fade-in fade-in-delay-3">
            <div class="flex items-center mb-6">
                <i data-lucide="badge-info" class="mr-2 w-5 h-5"></i>
                <h2 class="text-xl font-bold uppercase font-mono">สถานะออเดอร์</h2>
            </div>

            <div class="bg-white border-4 border-black paper-shadow">
                <div class="border-b-2 border-black p-4 bg-black text-white">
                    <p class="font-mono text-sm font-bold uppercase">ความหมายของแต่ละสถานะ</p>
                </div>
                <div class="divide-y-2 divide-black">
                    <div class="flex items-center p-4 space-x-4">
                        <span class="bg-gray-200 border border-black px-3 py-1 text-xs font-bold font-mono whitespace-nowrap">รอการตอบกลับ</span>
                        <p class="text-sm text-gray-700">ออเดอร์ถูกส่งแล้ว รอทางร้านตรวจสอบ — คุณยังแก้ไขหรือยกเลิกได้</p>
                    </div>
                    <div class="flex items-center p-4 space-x-4">
                        <span class="bg-yellow-300 border border-black px-3 py-1 text-xs font-bold font-mono whitespace-nowrap">รอคิวปริ้น</span>
                        <p class="text-sm text-gray-700">ทางร้านรับออเดอร์แล้ว อยู่ในคิวระหว่างดำเนินการ</p>
                    </div>
                    <div class="flex items-center p-4 space-x-4">
                        <span class="bg-green-300 border border-black px-3 py-1 text-xs font-bold font-mono whitespace-nowrap">ปริ้นสำเร็จ</span>
                        <p class="text-sm text-gray-700">งานเสร็จและพร้อมให้รับแล้ว</p>
                    </div>
                    <div class="flex items-center p-4 space-x-4">
                        <span class="bg-red-300 border border-black px-3 py-1 text-xs font-bold font-mono whitespace-nowrap">ถูกปฎิเสธ</span>
                        <p class="text-sm text-gray-700">ออเดอร์ถูกปฏิเสธ ตรวจสอบข้อความจากร้านในรายการออเดอร์</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: ประเภทกระดาษ -->
        <section class="fade-in fade-in-delay-4">
            <div class="flex items-center mb-6">
                <i data-lucide="layers" class="mr-2 w-5 h-5"></i>
                <h2 class="text-xl font-bold uppercase font-mono">ประเภทกระดาษ & ขนาด</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Paper Types -->
                <div class="bg-white border-4 border-black paper-shadow">
                    <div class="border-b-2 border-black p-4 bg-black text-white">
                        <p class="font-mono text-sm font-bold uppercase">ประเภทกระดาษ</p>
                    </div>
                    <div class="divide-y divide-black">
                        <div class="p-4">
                            <p class="font-bold font-mono text-sm">กระดาษธรรมดา (80gsm)</p>
                            <p class="text-xs text-gray-500 mt-1">กระดาษ A4 มาตรฐาน ราคาประหยัด เหมาะกับเอกสารทั่วไป</p>
                        </div>
                        <div class="p-4">
                            <p class="font-bold font-mono text-sm">กระดาษอาร์ตมัน (120gsm)</p>
                            <p class="text-xs text-gray-500 mt-1">กระดาษเคลือบมัน สีสดใส เหมาะกับงานสี รูปภาพ และโบรชัวร์</p>
                        </div>
                        <div class="p-4">
                            <p class="font-bold font-mono text-sm">กระดาษสติกเกอร์</p>
                            <p class="text-xs text-gray-500 mt-1">พิมพ์แล้วลอกติดได้เลย เหมาะกับสติกเกอร์และป้ายฉลาก</p>
                        </div>
                        <div class="p-4">
                            <p class="font-bold font-mono text-sm">กระดาษคราฟท์</p>
                            <p class="text-xs text-gray-500 mt-1">กระดาษสีน้ำตาล ให้ความรู้สึก minimal เหมาะกับงาน vintage</p>
                        </div>
                    </div>
                </div>

                <!-- Sizes -->
                <div class="bg-white border-4 border-black paper-shadow">
                    <div class="border-b-2 border-black p-4 bg-black text-white">
                        <p class="font-mono text-sm font-bold uppercase">ขนาดที่รองรับ</p>
                    </div>
                    <div class="divide-y divide-black">
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-8 h-11 border-2 border-black bg-gray-50 flex items-center justify-center text-xs font-mono font-bold">A4</div>
                            <div>
                                <p class="font-bold font-mono text-sm">A4</p>
                                <p class="text-xs text-gray-500">210 × 297 mm — มาตรฐาน</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-10 h-14 border-2 border-black bg-gray-50 flex items-center justify-center text-xs font-mono font-bold">A3</div>
                            <div>
                                <p class="font-bold font-mono text-sm">A3</p>
                                <p class="text-xs text-gray-500">297 × 420 mm — ใหญ่กว่า A4 สองเท่า</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-6 h-8 border-2 border-black bg-gray-50 flex items-center justify-center text-[9px] font-mono font-bold">A5</div>
                            <div>
                                <p class="font-bold font-mono text-sm">A5</p>
                                <p class="text-xs text-gray-500">148 × 210 mm — ครึ่งหนึ่งของ A4</p>
                            </div>
                        </div>
                        <div class="p-4 flex items-center space-x-3">
                            <div class="w-10 h-6 border-2 border-black bg-gray-50 flex items-center justify-center text-[9px] font-mono font-bold leading-tight text-center">นาม<br>บัตร</div>
                            <div>
                                <p class="font-bold font-mono text-sm">นามบัตร</p>
                                <p class="text-xs text-gray-500">85 × 55 mm — มาตรฐานนามบัตร</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4: FAQ -->
        <section>
            <div class="flex items-center mb-6">
                <i data-lucide="help-circle" class="mr-2 w-5 h-5"></i>
                <h2 class="text-xl font-bold uppercase font-mono">คำถามที่พบบ่อย (FAQ)</h2>
            </div>

            <div class="space-y-3">
                <details class="group bg-white border-2 border-black">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                        <span>แก้ไขออเดอร์ได้เมื่อไหร่?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="border-t-2 border-black p-4 bg-gray-50">
                        <p class="text-sm text-gray-700">สามารถแก้ไขได้เฉพาะออเดอร์ที่มีสถานะ <span class="bg-gray-200 border border-black px-1 text-xs font-bold">รอการตอบกลับ</span> เท่านั้น เมื่อทางร้านรับออเดอร์แล้วจะไม่สามารถแก้ไขได้</p>
                    </div>
                </details>

                <details class="group bg-white border-2 border-black">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                        <span>ยกเลิกออเดอร์ได้ไหม?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="border-t-2 border-black p-4 bg-gray-50">
                        <p class="text-sm text-gray-700">สามารถยกเลิกได้ทุกสถานะ โดยกดปุ่ม "ยกเลิกออเดอร์" ในรายการ แต่ถ้างานเสร็จแล้วกรุณาติดต่อร้านโดยตรง</p>
                    </div>
                </details>

                <details class="group bg-white border-2 border-black">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                        <span>ออเดอร์ถูกปฏิเสธ ต้องทำอะไร?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="border-t-2 border-black p-4 bg-gray-50">
                        <p class="text-sm text-gray-700">ดูข้อความเหตุผลจากทางร้านในรายการออเดอร์ แล้วสร้างออเดอร์ใหม่พร้อมแก้ไขตามที่ร้านแนะนำ</p>
                    </div>
                </details>

                <details class="group bg-white border-2 border-black">
                    <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                        <span>ไฟล์รองรับฟอร์แมตอะไรบ้าง?</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="border-t-2 border-black p-4 bg-gray-50">
                        <p class="text-sm text-gray-700">แนะนำ PDF สำหรับงานที่ต้องการความแม่นยำของเลย์เอาต์ หรือ JPG/PNG สำหรับรูปภาพ หากไม่แน่ใจสามารถระบุในช่อง Message ได้เลย</p>
                    </div>
                </details>
            </div>
        </section>

        <!-- Footer CTA -->
        <div class="bg-black text-white border-4 border-black p-8 text-center paper-shadow">
            <p class="font-mono font-bold text-lg mb-2">พร้อมสั่งพิมพ์แล้วใช่ไหม?</p>
            <p class="text-sm text-gray-400 font-mono mb-6">กลับหน้าหลักเพื่อสั่งงานได้เลย!</p>
            <a href="user_orders.php" class="inline-flex items-center space-x-2 bg-white text-black font-mono font-bold py-3 px-8 border-2 border-white hover:bg-gray-100 transition-colors uppercase tracking-widest">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>กลับหน้า Dashboard</span>
            </a>
        </div>

    </main>

    <footer class="mt-20 p-10 border-t-4 border-black bg-white text-center font-mono">
        <p class="text-sm">PORNSIRI PRINTING © 2026 - สั่งงานวันนี้ ได้งานชาติหน้า (หยอกๆ)</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
