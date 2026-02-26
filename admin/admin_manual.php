<?php
    session_start();
    include "../server.php";

    if(!isset($_SESSION['admin_id'])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manual - Pornsiri Printing</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Kanit', sans-serif; background-color: #f1f5f9; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .admin-shadow { 
            box-shadow: 4px 4px 0px 0px rgba(0,0,0,1); 
            transition: all 0.2s ease;
        }

        .paper-shadow {
            box-shadow: 8px 8px 0px 0px rgba(0,0,0,1);
            transition: all 0.2s ease;
        }

        .bg-dots {
            background-image: radial-gradient(#000000 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.05;
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

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white border-r-4 border-black hidden lg:block p-6 z-40">
        <div class="mb-10 text-center">
            <h1 class="text-2xl font-black font-mono tracking-tighter italic">PORNSIRI<br><span class="bg-black text-white px-2">ADMIN</span></h1>
        </div>
        <nav class="space-y-2">
            <a href="orders_mng.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all text-gray-600 hover:text-black">
                <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i> ORDERS
            </a>
            <a href="admin_manual.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all bg-black text-white">
                <i data-lucide="book-open" class="w-4 h-4 mr-2"></i> MANUAL
            </a>
            <a href="../logout.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all mt-20 text-red-500">
                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> LOGOUT
            </a>
        </nav>
    </aside>

    <main class="lg:ml-64 p-4 md:p-8">
        <header class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black uppercase font-mono italic">Admin Manual</h2>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-yellow-400 border-2 border-black rounded-full flex items-center justify-center font-bold"><?=strtoupper($_SESSION['admin_name'][0])?></div>
                <span class="font-mono text-sm hidden sm:block uppercase"><?=ucfirst($_SESSION['admin_name'])?></span>
            </div>
        </header>

        <div class="mx-6">
            <div class="space-y-10 relative mx-3 ">
    
                <!-- Hero -->
                <div class="fade-in fade-in-delay-1 bg-black text-white border-4 border-black p-8 paper-shadow relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-white text-black p-3 border-2 border-white">
                            <i data-lucide="shield-check" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="font-mono text-xs text-gray-400 uppercase tracking-widest">SYSTEM ADMINISTRATION</p>
                            <h2 class="text-3xl font-black font-mono uppercase tracking-tight">คู่มือการจัดการระบบร้าน</h2>
                        </div>
                    </div>
                    <p class="font-mono text-sm text-gray-300 max-w-lg">
                        เอกสารนี้รวบรวมข้อมูลและวิธีการใช้งานระบบจัดการออเดอร์สำหรับแอดมิน เพื่อให้การทำงานราบรื่นและมีประสิทธิภาพสูงสุด
                    </p>
                </div>
                    
                </div>
    
                <!-- Section 1: วิธีจัดการออเดอร์ -->
                <section class="fade-in fade-in-delay-2">
                    <div class="flex items-center my-6">
                        <i data-lucide="mouse-pointer-click" class="mr-2 w-5 h-5"></i>
                        <h2 class="text-xl font-bold uppercase font-mono">การจัดการและเปลี่ยนสถานะออเดอร์</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Action: Accept -->
                        <div class="bg-white border-2 border-black p-5 admin-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold font-mono text-base">รับงาน (Accept)</h3>
                                <button class="btn-action bg-yellow-300 text-black border-2 border-black px-2 py-1 text-[10px] font-bold uppercase">รับงาน</button>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">
                                ใช้สำหรับออเดอร์ที่อยู่ในสถานะ <span class="bg-gray-200 border border-black px-1 text-xs">รอการตอบกลับ</span> และจะรับงานนี้
                            </p>
                            <p class="text-xs text-gray-500 bg-gray-50 p-2 border border-dashed border-gray-300">
                                <strong>ผลลัพธ์:</strong> ออเดอร์จะเปลี่ยนสถานะเป็น "รอคิวปริ้น" และถูกจัดเรียงนำไปต่อท้ายคิวปัจจุบันอัตโนมัติ
                            </p>
                        </div>
    
                        <!-- Action: Completed -->
                        <div class="bg-white border-2 border-black p-5 admin-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold font-mono text-base">ปริ้นสำเร็จ (Completed)</h3>
                                <button class="btn-action bg-green-400 text-black border-2 border-black px-2 py-1 text-[10px] font-bold uppercase">ปริ้นสำเร็จ</button>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">
                                ใช้เมื่อคุณปริ้นงานเสร็จเรียบร้อยแล้วและพร้อมให้ลูกค้ามารับงาน
                            </p>
                            <p class="text-xs text-gray-500 bg-gray-50 p-2 border border-dashed border-gray-300">
                                <strong>ผลลัพธ์:</strong> เปลี่ยนสถานะเป็น "ปริ้นสำเร็จ" และออเดอร์นี้จะถูกนำออกจากระบบคิว (คิว = 0)
                            </p>
                        </div>
    
                        <!-- Action: Reject -->
                        <div class="bg-white border-2 border-black p-5 admin-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold font-mono text-base">ปฏิเสธ (Reject)</h3>
                                <button class="btn-action bg-red-500 text-white border-2 border-black px-2 py-1 text-[10px] font-bold uppercase">ปฏิเสธ</button>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">
                                หากเปิดไฟล์ไม่ได้, ไฟล์ไม่ชัด, หรือทำตามที่ลูกค้าส่งมาไม่ได้
                            </p>
                            <p class="text-xs text-gray-500 bg-gray-50 p-2 border border-dashed border-gray-300">
                                <strong>ผลลัพธ์:</strong> ระบบจะให้คุณกรอกเหตุผลที่ปฏิเสธ (เพื่อแจ้งให้ลูกค้าทราบ) หากปฏิเสธแล้วออเดอร์จะถูกปัดตกไปเป็นสถานะล้มเหลว
                            </p>
                        </div>
    
                        <!-- Action: Cancel -->
                        <div class="bg-white border-2 border-black p-5 admin-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold font-mono text-base">ยกเลิก/รีเซ็ต (Cancel)</h3>
                                <button class="btn-action bg-white text-red-500 border-2 border-black px-2 py-1 text-[10px] font-bold uppercase">ยกเลิก</button>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">
                                หากกดเปลี่ยนสถานะพลาด หรือลูกค้าขอยกเลิกงานพิมพ์ชั่วคราว
                            </p>
                            <p class="text-xs text-gray-500 bg-gray-50 p-2 border border-dashed border-gray-300">
                                <strong>ผลลัพธ์:</strong> ยกเลิกสถานะปัจจุบันและดึงออเดอร์กลับไปเป็นสถานะตั้งต้นคือ "รอการตอบกลับ"
                            </p>
                        </div>
                    </div>
                </section>
    
                <!-- Section 2: สถานะออเดอร์ -->
                <section class="fade-in fade-in-delay-3">
                    <div class="flex items-center my-6">
                        <i data-lucide="badge-info" class="mr-2 w-5 h-5"></i>
                        <h2 class="text-xl font-bold uppercase font-mono">ลำดับความสำคัญของสถานะออเดอร์</h2>
                    </div>
    
                    <div class="bg-white border-4 border-black paper-shadow">
                        <div class="border-b-2 border-black p-4 bg-black text-white">
                            <p class="font-mono text-sm font-bold uppercase">ลำดับการแสดงผลในหน้า Dashboard</p>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-700 mb-4 font-mono">ระบบจัดการหน้าโต๊ะจะเรียงลำดับออเดอร์ (Sort) โดยให้ความสำคัญตามนี้ เพื่อให้แอดมินทำงานง่ายที่สุด:</p>
                            
                            <div class="space-y-4">
                                <!-- Rule 1 -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border-2 border-black flex items-center justify-center font-bold shrink-0">1</div>
                                    <div>
                                        <h4 class="font-bold font-mono text-sm mb-1 uppercase tracking-wide flex items-center">
                                            <span class="bg-gray-200 border border-black px-2 py-0.5 text-[10px] mr-2">รอการตอบกลับ</span> Pending
                                        </h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            จะถูกนำขึ้นมาแสดง <strong class="text-black">ด้านบนสุดเสมอ</strong> เพื่อให้แอดมินเห็นงานใหม่ที่เพิ่งเข้ามาทันที และกด "รับงาน" หรือ "ปฏิเสธ" ได้อย่างรวดเร็ว
                                        </p>
                                    </div>
                                </div>
    
                                <!-- Rule 2 -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border-2 border-black flex items-center justify-center font-bold shrink-0">2</div>
                                    <div>
                                        <h4 class="font-bold font-mono text-sm mb-1 uppercase tracking-wide flex items-center">
                                            <span class="bg-yellow-300 border border-black px-2 py-0.5 text-[10px] mr-2">รอคิวปริ้น</span> Waiting
                                        </h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            เป็นออเดอร์ที่ถูกกดยอมรับแล้ว ระบบจะเรียงคิวตามลำดับก่อน-หลัง (1, 2, 3...) โดยอัตโนมัติ 
                                            แอดมินเพียงแค่ไล่ปริ้นตามคิวจากบนลงล่าง เมื่อเสร็จก็กด "ปริ้นสำเร็จ"
                                        </p>
                                    </div>
                                </div>
    
                                <!-- Rule 3 -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border-2 border-black flex items-center justify-center font-bold shrink-0">3</div>
                                    <div>
                                        <h4 class="font-bold font-mono text-sm mb-1 uppercase tracking-wide flex items-center">
                                            <span class="bg-green-400 border border-black px-2 py-0.5 text-[10px] mr-2">ปริ้นสำเร็จ</span> Completed
                                        </h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            ออเดอร์ที่ทำเสร็จแล้วจะถูกย้ายลงไปด้านล่าง เพื่อไม่ให้เกะกะสายตา หากลูกค้ามารับงานแล้ว สามารถลบทิ้งออกจากระบบได้
                                        </p>
                                    </div>
                                </div>
    
                                <!-- Rule 4 -->
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 border-2 border-black flex items-center justify-center font-bold shrink-0">4</div>
                                    <div>
                                        <h4 class="font-bold font-mono text-sm mb-1 uppercase tracking-wide flex items-center">
                                            <span class="bg-red-500 text-white border border-black px-2 py-0.5 text-[10px] mr-2">ปฏิเสธ</span> Rejected
                                        </h4>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            ออเดอร์ที่มีปัญหาจะอยู่ล่างสุดเช่นกัน แอดมินสามารถลบทิ้งได้เลยเมื่อลูกค้าทราบเหตุผลแล้ว หรือจะกด "ยกเลิก" เพื่อดึงกลับมาใหม่หากปัญหาถูกแก้ไข
                                        </p>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
                </section>
    
                 <!-- Section 3: FAQ -->
                <section class="fade-in fade-in-delay-4">
                    <div class="flex items-center my-6">
                        <i data-lucide="help-circle" class="mr-2 w-5 h-5"></i>
                        <h2 class="text-xl font-bold uppercase font-mono">คำถามที่พบบ่อย (FAQ สำหรับ Admin)</h2>
                    </div>
    
                    <div class="space-y-3">
                        <details class="group bg-white border-2 border-black">
                            <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                                <span>ฟิลเตอร์ปุ่มดำๆ ข้างบนตารางเอาไว้ทำอะไร?</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                            </summary>
                            <div class="border-t-2 border-black p-4 bg-gray-50">
                                <p class="text-sm text-gray-700">ใช้สำหรับกรองดูเฉพาะออเดอร์ตามสถานะที่เลือก เช่น ถ้าช่วงเที่ยงงานเยอะมาก คุณอาจจะกดดูเฉพาะ "ออร์เดอร์ทั่วไป" เพื่อเคลียร์ว่าใครได้ทำ ใครไม่ได้ทำ ก่อนจะปรับไปดู "รอคิวปริ้น" ล้วนๆ</p>
                            </div>
                        </details>
    
                        <details class="group bg-white border-2 border-black">
                            <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                                <span>จะดูลิงก์ไฟล์งานของลูกค้าได้ยังไง?</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                            </summary>
                            <div class="border-t-2 border-black p-4 bg-gray-50">
                                <p class="text-sm text-gray-700">คลิกที่แถวของออเดอร์ (Row) นั้นๆ แถบรายละเอียดด้านล่างจะเปิดออกมา (Dropdown) คุณจะเห็นทั้งลิ้งก์ไฟล์ ข้อความเพิ่มเติม และข้อมูลสเปกกระดาษ หากต้องการปิด ให้คลิกที่เดิมซ้ำอีกครั้ง</p>
                            </div>
                        </details>
    
                        <details class="group bg-white border-2 border-black">
                            <summary class="flex items-center justify-between p-4 cursor-pointer font-mono font-bold text-sm hover:bg-gray-50">
                                <span>ปุ่มลบ (Trash) จะลบตารางออกจาก Database เลยไหม?</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-open:rotate-180"></i>
                            </summary>
                            <div class="border-t-2 border-black p-4 bg-gray-50">
                                <p class="text-sm text-gray-700">ใช่ครับ การกดลบในหน้าสถานะ ปริ้นสำเร็จ/ปฏิเสธ จะเป็น<strong>การลบข้อมูลออเดอร์ออกจากระบบอย่างถาวร</strong> เพื่อเคลียร์พื้นที่ของตาราง แนะนำให้ลบเมื่อแน่ใจว่าลูกค้ามารับของหรือรับรู้การปฎิเสธแล้ว</p>
                            </div>
                        </details>
                    </div>
                </section>
            </div>   
        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
