
<?php

    session_start();
    include "../server.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/signin/signin.php");
        exit();
    }

    // Add order --
    if (isset($_POST["add_order"])) {
        $link = $_POST["link"];
        $message = $_POST["message"];
        $paper_type = $_POST["paper_type"];
        $size = $_POST["size"];
        $quantity = $_POST["quantity"];

        $user_id = $_SESSION["user_id"];

        // echo "<pre>";   
        // print_r($_POST);
        // echo "</pre>";
        // exit();


        $stmt = $conn->prepare("INSERT INTO orders (user_id, status,link, message, paper_type, size,quantity) VALUES (:user_id, 'pending', :link, :message, :paper_type, :size, :quantity)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':paper_type', $paper_type);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();

        if ($stmt) {
            $_SESSION["success"] = ["เพิ่มออเดอร์เรียบร้อยแล้ว",'สั่งงานสำเร็จ วะฮ่าฮ่าฮ่า!',"รู้เรื่อง (จะรอจ่ายตังค์แต่โดยดี)"];
            header("Location: user_orders.php");
            exit();
        } else {
            $_SESSION["error"] = ["เกิดข้อผิดพลาดในการเพิ่มออเดอร์",'พบข้อผิดพลาด!',"ช่วยลองใหม่อีกที!!"];
            header("Location: user_orders.php");
            exit();
        }
    }

    //  save the edit
    if (isset($_POST["save_edit"])) {
        $link = $_POST["link"];
        $paper_type = $_POST["paper_type"];
        $size = $_POST["size"];
        $quantity = $_POST["quantity"];
        $message = $_POST["message"];

        $order_id = $_POST["save_edit"];

        $user_id = $_SESSION["user_id"];


        $stmt = $conn->prepare("UPDATE orders SET link = :link, message = :message, paper_type = :paper_type, size = :size, quantity = :quantity WHERE order_id = :order_id");
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':paper_type', $paper_type);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        if ($stmt) {
            $_SESSION["success"] = ["แก้ไขออเดอร์เรียบร้อยแล้ว","แต่จ่ายเงินเหมือนเดิมนะ","รอจ่ายตัังค์ ฮุฮุฮุ"];
            header("Location: user_orders.php");
            exit();
        } else {
            $_SESSION["error"] = ["เกิดข้อผิดพลาดในการแก้ไขออเดอร์ แย่แล้ว","นี้ชั้น จะเสียลูกค้าหรือนี้","ลองอีกทีนะ ได้โปรดดด!!"];
            header("Location: user_orders.php");
            exit();
        }
    }

    // Cancel Order
    if (isset($_POST["cancel_order"])) {
        $order_id = $_POST["cancel_order"];
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        if ($stmt) {
            $_SESSION["success"] = ["ยกเลิกออเดอร์เรียบร้อยแล้ว","แย่ชะมัด","ปิด >:("];
            header("Location: user_orders.php");
            exit();
        } else {
            $_SESSION["error"] = ["เกิดข้อผิดพลาดในการยกเลิกออเดอร์ อิอิ :>","ยกเลิกไม่สำเร็จ! ลองใหม่อีกทีนะ","ลองอีกทีนะ อิอิ :>"];
            header("Location: user_orders.php");
            exit();
        }
    }



?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Pornsiri Printing</title>
    
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
        .paper-shadow:hover {
            transform: translate(-2px, -2px);
            box-shadow: 10px 10px 0px 0px rgba(0,0,0,1);
        }
        .paper-shadow:active {
            transform: translate(4px, 4px);
            box-shadow: 2px 2px 0px 0px rgba(0,0,0,1);
        }

        .bg-dots {
            background-image: radial-gradient(#000000 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.05;
        }

        /* สำหรับ Accordion Detail */
        .order-details {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .order-item.active .order-details {
            max-height: 500px;
        }
        .order-item.active .chevron-icon {
            transform: rotate(180deg);
        }

        input, select, textarea {
            border: 2px solid black !important;
        }

        .hidpop { display: none !important; }

        /* Noti Popup Animation */
        @keyframes popup-show {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .popup-animate {
            animation: popup-show 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
    </style>
</head>
<body class="min-h-screen pb-20">

    <!-- Confirm Cancel Popup -->
    <div id="CancelPop" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-white border-4 border-black p-8 max-w-sm w-full relative paper-shadow">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-4 border-2 border-black">
                    <i data-lucide="trash-2" class="w-8 h-8"></i>
                </div>
                <h3 class="text-2xl font-black mb-2 font-mono uppercase">ยกเลิกออเดอร์?</h3>
                <p class="text-gray-600 mb-6 font-mono text-sm">คุณแน่ใจนะว่าจะทิ้งกัน? ออเดอร์ที่ยกเลิกแล้วกู้คืนไม่ได้นะจ๊ะ</p>
                <div class="flex flex-col space-y-2">
                    <form action="user_orders.php" method="post">                               
                        <button name = "cancel_order" id="ComfirmCancel" value = "" class="w-full bg-red-500 text-white font-mono font-bold py-3 border-2 border-black hover:bg-black transition-colors uppercase">
                            ยืนยันการยกเลิก
                        </button>
                    </form>
                    <button onclick="closeNotiPopup()" class="w-full bg-white text-black font-mono font-bold py-3 border-2 border-black hover:bg-gray-100 transition-colors uppercase">
                        เปลี่ยนใจแล้ว
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Notification Popup: จะแสดงผลเฉพาะเมื่อมี $_SESSION['success'] หรือ  $_SESSION['error']-->
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])) : ?>
        <div id="NotiPopup" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div class="bg-white border-4 border-black p-8 max-w-sm w-full relative paper-shadow popup-animate">
                <!-- Decorative Tape -->
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-24 h-8 bg-<?php if(isset($_SESSION['success'])) echo 'green'; else echo 'red'; ?>-500/80 rotate-2 border border-black z-10"></div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-<?php if(isset($_SESSION['success'])) echo 'green'; else echo 'red'; ?>-100 text-<?php if(isset($_SESSION['success'])) echo 'green'; else echo 'red'; ?>-600 rounded-full mb-4 border-2 border-black">
                        <i data-lucide="<?php if(isset($_SESSION['success'])) echo 'badge-check'; else echo 'shield-alert'; ?>" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-black mb-2 font-mono uppercase"><?php if(isset($_SESSION['success'])) echo $_SESSION['success'][0]; else echo $_SESSION['error'][0]; ?></h3>
                    <p class="text-gray-600 mb-6"><?php if(isset($_SESSION['success'])) echo $_SESSION['success'][1]; else echo $_SESSION['error'][1]; ?></p>
                    <button onclick="closeNotiPopup()" 
                        class="w-full bg-black text-white font-mono font-bold py-3 border-2 border-black hover:bg-<?php if(isset($_SESSION['success'])) echo 'green'; else echo 'red'; ?>-600 transition-colors">
                        <?php if(isset($_SESSION['success'])) echo $_SESSION['success'][2]; else echo $_SESSION['error'][2]; ?>
                    </button>
                </div>
            </div>
        </div>
    <?php 
        // เคลียร์ error ทันทีหลังจากแสดงผล เพื่อไม่ให้มันค้างตอนรีเฟรชหน้า
        unset($_SESSION['error']); 
        unset($_SESSION['success']);
    ?>
    <?php endif; ?>

    <div class="fixed inset-0 bg-dots pointer-events-none"></div>

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white border-b-4 border-black p-4 mb-8">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black font-mono tracking-tighter uppercase">
                PORNSIRI <span class="bg-black text-white px-1">DASHBOARD</span>
            </h1>
            <div class="flex items-center space-x-4">
                <span class="text-xs font-mono hidden md:block">USER: <?php echo ucfirst($_SESSION['username']) ?></span>
                <a href="../logout.php">
                    <button class="bg-red-500 text-white border-2 border-black p-1 hover:bg-black transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 space-y-12 relative">
        
        <!-- Section 1: Add Order -->
        <section id="add-order" class="relative">
            <div class="flex items-center mb-6">
                <i data-lucide="plus-square" class="mr-2"></i>
                <h2 class="text-2xl font-bold uppercase font-mono">สั่งพิมพ์งานใหม่</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Form -->
                <div class="md:col-span-2 bg-white border-4 border-black p-6 md:p-8 paper-shadow relative">
                    <!-- Decorative Tape -->
                    <div class="absolute -top-4 left-10 w-20 h-8 bg-yellow-300/80 rotate-3 border border-black z-10"></div>
                    
                    <form id="orderForm" class="space-y-4" action="user_orders.php" method="POST">
                        <div>
                            <label class="block text-sm font-bold font-mono mb-1">LINK OF FILE (ลิ้งก์ไฟล์งาน)</label>
                            <input type="url" name="link" required class="w-full p-3 font-mono text-sm focus:bg-blue-50 outline-none" placeholder="https://drive.google.com/...">
                        </div>

                        <div>
                            <label class="block text-sm font-bold font-mono mb-1">MESSAGE (สั่งอะไรเพิ่มไหม?)</label>
                            <textarea rows="3" name="message" class="w-full p-3 font-mono text-sm focus:bg-blue-50 outline-none" maxlength="300" placeholder="เช่น ปริ้นสีหน้าเดียว, ฝากเขียนชื่อด้วยครับ..."></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold font-mono mb-1">PAPER TYPE</label>
                                <select name="paper_type" class="w-full p-3 font-mono text-sm outline-none">
                                    <option>กระดาษธรรมดา (80gsm)</option>
                                    <option>กระดาษอาร์ตมัน (120gsm)</option>
                                    <option>กระดาษสติกเกอร์</option>
                                    <option>กระดาษคราฟท์</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold font-mono mb-1">SIZE</label>
                                <select name="size" class="w-full p-3 font-mono text-sm outline-none">
                                    <option>A4</option>
                                    <option>A3</option>
                                    <option>A5</option>
                                    <option>นามบัตร</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold font-mono mb-1">QUANTITY (จำนวนชุด)</label>
                            <input type="number" name="quantity" min="1" value="1" required class="w-full p-3 font-mono text-sm outline-none">
                        </div>

                        <button type="submit" name="add_order" class="w-full bg-black text-white font-mono font-bold py-4 text-xl border-2 border-black hover:bg-white hover:text-black transition-all uppercase tracking-widest mt-4">
                            ADD ORDER (จัดไป!)
                        </button>
                    </form>
                </div>

                <!-- Decoration Side -->
                <div class="hidden md:block space-y-4">
                    <div class="bg-white border-2 border-black p-4 rotate-2 paper-shadow">
                        <img src="../assets/4.png" alt="Fresh Fish" class="w-full grayscale hover:grayscale-0 transition-all duration-500">
                        <p class="text-[10px] font-mono mt-2 text-center text-gray-500 italic">งานระดับเทพเหมือนพนักงาน!</p>
                    </div>
                    <div class="bg-black text-white p-4 -rotate-1 text-center font-mono text-xs">
                        ตรวจสอบลิ้งก์ไฟล์ให้ดี <br> ถ้าเปิดไม่ได้ <br> เราจะไม่อ่านข้อความคุณ!
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Orders List -->
        <section id="orders-list">
            <div class="flex items-center mb-6">
                <i data-lucide="list" class="mr-2"></i>
                <h2 class="text-2xl font-bold uppercase font-mono">ประวัติการสั่ง (ORDERS)</h2>
            </div>

            <div class="space-y-4" id="ordersContainer">
                <!-- Order Item 1 -->
                <?php
                    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_id DESC");
                    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                    $stmt->execute();
                    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $order_id;
                    $status;
                    $date;
                    $link;
                    $message;
                    $paper_type;
                    $size;
                    $count;

                    $sordOrders = [];

                    // Const data

                    $priority = ['pending', 'waiting', 'completed', 'cancelled'];

                    $status_dict = [
                        "pending" => [
                            "text" => "รอการตอบกลับ",
                            "color" => "bg-gray-200",
                        ],
                        "waiting" => [
                            "text" => "รอคิวปริ้น",
                            "color" => "bg-yellow-300"
                        ],
                        "completed" => [
                            "text" => "ปริ้นสำเร็จ",
                            "color" => "bg-green-300"
                        ],
                        "rejected" => [
                            "text" => "ถูกปฎิเสธ",
                            "color" => "bg-red-300"
                        ]
                    ];

                    //------------------------

                    // sord orders
                    foreach ($priority as $status) {
                        foreach ($orders as $key => $order) {
                            if ($order["status"] == $status) {
                                $sordOrders[] = $order;
                                unset($orders[$key]);
                            }
                        }
                    }

                    foreach ($sordOrders as $order) {
                        $order_id = $order['order_id'];
                        $status = $order['status'];
                        $date = $order['date'];
                        $link = $order['link'];
                        $message = $order['message'];
                        $paper_type = $order['paper_type'];
                        $size = $order['size'];
                        $quantity = $order['quantity'];
                        $respone = $order['respone'];

                        
                        // element ux
                        $status_color;
                        $status_text;

                        $status_color = $status_dict[$status]["color"];
                        $status_text = $status_dict[$status]["text"];

                        $opacity = "100";
                        if ($status != "pending") $opacity = "75";

                        ?>
                        
                        <!-- Order Item 1 -->
                        <div class="order-item bg-white border-2 border-black overflow-hidden paper-shadow  opacity-<?=$opacity?>" id="order-<?=$order_id?>">
                            <div onclick="toggleOrder(this)" class=" p-4 flex flex-wrap items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors ">
                                <div class="flex items-center space-x-4">
                                    <span class="font-mono font-bold text-lg">#<?=$order_id?></span>
                                    <div class="hidden sm:block">
                                        <p class="text-[10px] text-gray-400 font-mono uppercase">FILE LINK</p>
                                        <p class="text-xs truncate max-w-[150px] font-mono"><?=$link?></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-gray-400 font-mono uppercase">DATE</p>
                                        <p class="text-xs font-mono"><?=$date?></p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="<?=$status_color?> border border-black px-2 py-0.5 text-[10px] font-bold"><?=$status_text?></span>
                                    <i data-lucide="chevron-down" class="chevron-icon transition-transform"></i>
                                </div>
                            </div>
                            
                            <!-- Details (Expandable Content) -->
                            <div class="order-details bg-gray-50 border-t-2 border-black">
                                <!-- View State -->
                                <div id="view-state-<?=$order_id?>" class="p-6 grid md:grid-cols-2 gap-6">
                                    <div class=" space-y-3">
                                        <?php if ($respone != "") { ?>
                                            <div class="flex items-center space-x-2 font-mono mb-4">
                                                <i data-lucide="circle-alert" class="text-sm text-red-500"></i>
                                                <p class="font-bold">ข้อความจากทางร้าน : <span class = "text-sm text-red-500"><?=$respone?></span></p>
                                            </div>
                                        <?php } ?>
                
                                        <p class="text-sm font-mono"><span class="font-bold">ลิ้งก์ไฟล์:</span> <span class="text-blue-500 underline"><?=$link?></span></p>
                                        <p class="text-sm font-mono"><span class="font-bold">ประเภทกระดาษ:</span> <span><?=$paper_type?></span></p>
                                        <p class="text-sm font-mono"><span class="font-bold">ขนาด:</span> <span><?=$size?></span></p>
                                        <p class="text-sm font-mono"><span class="font-bold">จำนวน:</span> <span><?=$quantity?></span> ชุด</p>
                                        <p class="text-sm font-mono text-gray-500 italic border-l-4 border-black pl-3"><?=$message?></p>
                                    </div>
                                    <div class="flex flex-col justify-end space-y-2">
                                        <?php if ($status == "pending") { ?>
                                            <button onclick="enableEdit('<?=$order_id?>')" class=" w-full border-2 border-black py-2 font-mono text-xs bg-white hover:bg-black hover:text-white transition-all">
                                                <i data-lucide="edit-3" class="inline w-3 h-3 mr-1"></i> แก้ไขรายการ
                                            </button>
                                        <?php } ?>
                                        <button onclick="CancelOrder('<?=$order_id?>')" class="w-full border-2 border-red-500 text-red-500 py-2 font-mono text-xs hover:bg-red-500 hover:text-white transition-all">
                                            <i data-lucide="trash-2" class="inline w-3 h-3 mr-1"></i> ยกเลิกออเดอร์
                                        </button>
                                    </div>
                                </div>
                                
                                <?php if ($status == "pending") { ?>
                                <!-- Edit State (Form) -->
                                <div id="edit-state-<?=$order_id?>" class="p-6 hidden">
                                    <div class="bg-blue-50 border-2 border-blue-500 p-4 mb-4">
                                        <p class="text-xs font-mono font-bold text-blue-600 mb-4 uppercase">กำลังแก้ไขรายการ #<?=$order_id?></p>
                                        <form action="user_orders.php" method="POST" class="space-y-4">
                                            <div>
                                                <label class="block text-[10px] font-bold font-mono mb-1">FILE LINK</label>
                                                <input name = "link" type="url" id="edit-link-<?=$order_id?>" value="<?=$link?>" data-original="<?=$link?>" class="w-full p-2 font-mono text-xs outline-none">
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-[10px] font-bold font-mono mb-1">PAPER TYPE</label>
                                                    <select name = "paper_type" id="edit-paper-<?=$order_id?>" data-original="<?=$paper_type?>" class="w-full p-2 font-mono text-xs outline-none">
                                                        <option <?= $paper_type == 'กระดาษธรรมดา (80gsm)' ? 'selected' : '' ?>>กระดาษธรรมดา (80gsm)</option>
                                                        <option <?= $paper_type == 'กระดาษอาร์ตมัน (120gsm)' ? 'selected' : '' ?>>กระดาษอาร์ตมัน (120gsm)</option>
                                                        <option <?= $paper_type == 'กระดาษสติกเกอร์' ? 'selected' : '' ?>>กระดาษสติกเกอร์</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold font-mono mb-1">SIZE</label>
                                                    <select name = "size" id="edit-size-<?=$order_id?>" data-original="<?=$size?>" class="w-full p-2 font-mono text-xs outline-none">
                                                        <option <?= $size == 'A4' ? 'selected' : '' ?>>A4</option>
                                                        <option <?= $size == 'A3' ? 'selected' : '' ?>>A3</option>
                                                        <option <?= $size == 'A5' ? 'selected' : '' ?>>A5</option>
                                                        <option <?= $size == 'นามบัตร' ? 'selected' : '' ?>>นามบัตร</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-[10px] font-bold font-mono mb-1">QUANTITY</label>
                                                    <input name = "quantity" type="number" id="edit-quantity-<?=$order_id?>" value="<?=$quantity?>" data-original="<?=$quantity?>" class="w-full p-2 font-mono text-xs outline-none">
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold font-mono mb-1">MESSAGE</label>
                                                    <input name = "message" type="text" id="edit-message-<?=$order_id?>" value="<?=$message?>" data-original="<?=$message?>" class="w-full p-2 font-mono text-xs outline-none">
                                                </div>
                                            </div>
                                            <div class="flex space-x-2 pt-2">
                                                <button name = "save_edit" value="<?=$order_id?>" class="flex-1 bg-blue-500 text-white border-2 border-black py-2 font-mono text-xs hover:bg-black transition-all">
                                                    บันทึก (SAVE)
                                                </button>
                                                <div onclick="disableEdit('<?=$order_id?>')" class="flex-1 text-center bg-white text-black border-2 border-black py-2 font-mono text-xs hover:bg-gray-100 transition-all">
                                                    ยกเลิก (CANCEL)
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                        </div>


                    <?php } ?>
                </div>  
            </div>  
        </section>
    </main>

    <footer class="mt-20 p-10 border-t-4 border-black bg-white text-center font-mono">
        <p class="text-sm">PORNSIRI PRINTING © 2026 - สั่งงานวันนี้ ได้งานชาติหน้า (หยอกๆ)</p>
    </footer>

    <script>

        // --- Core Functions ---
        function toggleOrder(element) {
            const item = element.parentElement;
            if (item.classList.contains('editing')) return; // ห้ามย่อถ้ากำลังแก้ไขอยู่
            
            const isActive = item.classList.contains('active');
    
            if (!isActive) {
                item.classList.add('active');
            }else {
                item.classList.remove('active');
            }
        }

        // --- Editing Logic ---
        function enableEdit(id) {
            const item = document.getElementById('order-' + id);
            item.classList.add('editing', 'editing-mode');
            document.getElementById('view-state-' + id).classList.add('hidden');
            document.getElementById('edit-state-' + id).classList.remove('hidden');
        }

        function disableEdit(id) {
            const item = document.getElementById('order-' + id);
            item.classList.remove('editing', 'editing-mode');
            document.getElementById('view-state-' + id).classList.remove('hidden');
            document.getElementById('edit-state-' + id).classList.add('hidden');

            // Reset all input values to their original PHP values
            const linkInput = document.getElementById('edit-link-' + id);
            const paperSelect = document.getElementById('edit-paper-' + id);
            const sizeSelect = document.getElementById('edit-size-' + id);
            const quantityInput = document.getElementById('edit-quantity-' + id);
            const messageInput = document.getElementById('edit-message-' + id);

            if (linkInput) linkInput.value = linkInput.dataset.original;
            if (paperSelect) paperSelect.value = paperSelect.dataset.original;
            if (sizeSelect) sizeSelect.value = sizeSelect.dataset.original;
            if (quantityInput) quantityInput.value = quantityInput.dataset.original;
            if (messageInput) messageInput.value = messageInput.dataset.original;
        }


        // --- Cancellation Logic ---
        function CancelOrder(id) {
            document.getElementById('ComfirmCancel').value = id;
            document.getElementById('CancelPop').classList.remove('hidden');
        }
        
        function closeNotiPopup() {
            document.getElementById('NotiPopup').classList.add('hidden');
            document.getElementById('Cancelpop').classList.add('hidden');
            console.log('closeNotiPopup');
        }

        lucide.createIcons();
    </script>
</body>
</html>