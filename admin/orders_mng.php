<?php
    session_start();
    include "../server.php";

    if(!isset($_SESSION['admin_id'])){
        header("Location: index.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_id DESC");
    $stmt->execute();
    $orders = $stmt->fetchAll();

    $sordOrders = [];

    // Const data
    $priority = ['pending', 'waiting', 'completed', 'rejected'];

    $action_dict = [
        "accept" => [
            "mean" => "accept",
            "text" => "รับงาน",
            "color" => "bg-yellow-300",
            "text_color" => "text-black"
        ],
        "reject" => [
            "mean" => "reject",
            "text" => "ปฏิเสธ",
            "color" => "bg-red-500",
            "text_color" => "text-white"
        ],
        "completed" => [
            "mean" => "completed",
            "text" => "ปริ้นสำเร็จ",
            "color" => "bg-green-400",
            "text_color" => "text-black"
        ],
        "cancelled" => [
            "mean" => "cancelled",
            "text" => "ยกเลิก",
            "color" => "bg-white",
            "text_color" => "text-red-500"
        ],
        "delete" => [
            "mean" => "delete",
            "text" => "ลบ",
            "color" => "bg-red-500",
            "text_color" => "text-black",
            "icon" => "trash-2"
        ]
    ];

    $status_dict = [
        "pending" => [
            "mean" => "pending",
            "text" => "รอการตอบกลับ",
            "color" => "bg-gray-200",
            "action" => [
                "accept" => $action_dict["accept"],
                "reject" => $action_dict["reject"]
            ]
        ],
        "waiting" => [
            "mean" => "waiting",
            "text" => "รอคิวปริ้น",
            "color" => "bg-yellow-300",
            "action" => [
                "completed" => $action_dict["completed"],
                "cancelled" => $action_dict["cancelled"]
            ]
        ],
        "completed" => [
            "mean" => "completed",
            "text" => "ปริ้นสำเร็จ",
            "color" => "bg-green-400",
            "action" => [
                "delete" => $action_dict["delete"]
            ]
        ],
        "rejected" => [
            "mean" => "rejected",
            "text" => "ปฎิเสธ",
            "color" => "bg-red-500",
            "action" => [
                "delete" => $action_dict["delete"],
                "cancelled" => $action_dict["cancelled"]
            ]
        ]
    ];

    // Count 
    $total = count($orders);
    
    $pending = 0;
    $waiting = 0;
    $completed = 0;
    $rejected = 0;
        
    $count_status = [
        "pending" => $pending,
        "waiting" => $waiting,
        "completed" => $completed,
        "rejected" => $rejected
    ];

    // sord orders
    foreach ($priority as $status) {
        foreach ($orders as $key => $order) {
            if ($order["status"] == $status) {
    
                $stmt = $conn->prepare("SELECT username FROM users WHERE id = :order_user_id");
                $stmt->bindParam(":order_user_id", $order["user_id"]);
                $stmt->execute();
                $user = $stmt->fetchAll();
                
                $order["username"] = $user[0]["username"];

                $count_status[$status]++;
                                
                $sordOrders[] = $order;

                unset($orders[$key]);   
            }
        }
    }

    $replace_start_index = null;
    $replace_end_index = null;

    $waiting_list = [];

    foreach ($sordOrders as $key => $order) {
        if ($order["status"] == $status_dict["waiting"]["mean"]) {

            if ($replace_start_index === null) {    
                $replace_start_index = $key;
            }
            $replace_end_index = $key;

            $waiting_list[] = $order;
            usort($waiting_list, function($a, $b) {
                return $a["queue"] <=> $b["queue"];
            });
        }
    }

    // replace old waiting orders 
    if ($waiting_list != []) {
        array_splice(
            $sordOrders,
            $replace_start_index,
            $replace_end_index,
            $waiting_list
        );
    }
    
    // for action btn
    if (isset($_POST["accept"])) {
        $id = $_POST["accept"];

        $stmt = $conn->prepare("UPDATE orders SET status = 'waiting', queue = (SELECT MAX(queue) FROM orders) + 1 WHERE order_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location: orders_mng.php");
        exit();
    }

    if (isset($_POST["reject"])) {
        $id = $_POST["reject"];
        $stmt = $conn->prepare("UPDATE orders SET status = 'rejected' WHERE order_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: orders_mng.php");
        exit();
    }

    if (isset($_POST["completed"])) {
        $id = $_POST["completed"];
        $stmt = $conn->prepare("UPDATE orders SET status = 'completed', queue = 0 WHERE order_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: orders_mng.php");
        exit();
    }

    if (isset($_POST["cancelled"])) {
        $id = $_POST["cancelled"];
        $stmt = $conn->prepare("UPDATE orders SET status = 'pending', queue = 0 WHERE order_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: orders_mng.php");
        exit();
    }

    if (isset($_POST["delete"])) {
        $id = $_POST["delete"];
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: orders_mng.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pornsiri Printing Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Kanit', sans-serif; background-color: #f1f5f9; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .admin-shadow { 
            box-shadow: 4px 4px 0px 0px rgba(0,0,0,1); 
            transition: all 0.2s ease;
        }
        
        .stats-card { position: relative; overflow: hidden; }

        .filter-active { background-color: black !important; color: white !important; transform: scale(1.05); }
        .status-badge { border: 2px solid black; padding: 2px 8px; font-size: 10px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        
        /* Status Colors */
        .bg-general { background-color: #e2e8f0; }
        .bg-pending { background-color: #fde047; }
        .bg-completed { background-color: #4ade80; }
        .bg-rejected { background-color: #f87171; }

        input, textarea { border: 2px solid black !important; outline: none; }

        /* Row Expand Logic */
        .order-row { cursor: pointer; transition: background-color 0.2s; }
        .order-row:hover { background-color: #f8fafc; }
        .order-row.active { background-color: #eff6ff; }
        
        .details-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background-color: #fafafa;
        }
        .order-row.active + tr .details-container {
            max-height: 500px;
            border-bottom: 2px solid black;
        }

        .chevron-icon { transition: transform 0.3s; }
        .order-row.active .chevron-icon { transform: rotate(180deg); }

        /* Animations */
        @keyframes success-pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); background-color: #4ade80; }
            100% { transform: scale(1); }
        }
        /* .row-updated { animation: success-pop 0.4s ease; } */
        
        .order-row.hidden, .order-row.hidden + tr { display: none !important; }

        /* Action buttons style */
        .btn-action {
            border: 2px solid black;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            transition: all 0.2s;
            text-transform: uppercase;
        }
        .btn-action:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Reject Confirmation Modal -->
    <div id="rejectModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-sm">
        <div class="bg-white border-4 border-black p-6 max-w-sm w-full admin-shadow">
            <h3 class="text-xl font-black font-mono mb-4 uppercase">ระบุเหตุผลที่ปฏิเสธ</h3>
            <textarea id="rejectReason" class="w-full p-2 font-mono text-sm mb-4 focus:bg-red-50" maxlength="200" rows="3" placeholder="เช่น ไฟล์ไม่ชัดเจน, ลิงก์เข้าไม่ได้..."></textarea>
            <div class="flex space-x-2">
                <form action="orders_mng.php" method="POST">
                    <button value = "0" id="confirm_relect_btn" name="reject" class="flex-1 bg-red-500 text-white border-2 border-black py-2 px-3 font-bold hover:bg-black transition-all">ยืนยันการปฏิเสธ</button>
                </form>
                <button onclick="close_confirm();" class="flex-1 bg-white border-2 border-black py-2 font-bold hover:bg-gray-100 transition-all">ยกเลิก</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 hidden backdrop-blur-sm">
        <div class="bg-white border-4 border-black p-6 max-w-sm w-full admin-shadow">
            <h3 class="text-xl font-black font-mono mb-4 uppercase text-red-600">ลบข้อมูลถาวร?</h3>
            <p class="text-sm text-gray-600 mb-6 font-mono">คุณกำลังจะลบออเดอร์นี้ออกจากระบบอย่างถาวร ยืนยันหรือไม่?</p>
            <div class="flex space-x-2">
                <form action="orders_mng.php" method="POST">
                    <button value = "0" id="confirm_delete_btn" name="delete" class="flex-1 bg-black text-white border-2 border-black py-2 px-2 font-bold hover:bg-red-600 transition-all">ยืนยันการลบ</button>
                </form>
                <button onclick="close_confirm();" class="flex-1 bg-white border-2 border-black py-2 px-2 font-bold hover:bg-gray-100 transition-all">ยกเลิก</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 h-full w-64 bg-white border-r-4 border-black hidden lg:block p-6 z-40">
        <div class="mb-10 text-center">
            <h1 class="text-2xl font-black font-mono tracking-tighter italic">PORNSIRI<br><span class="bg-black text-white px-2">ADMIN</span></h1>
        </div>
        <nav class="space-y-2">
            <a href="orders_mng.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all bg-black text-white">
                <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i> ORDERS
            </a>
            <a href="admin_manual.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all text-gray-600 hover:text-black">
                <i data-lucide="book-open" class="w-4 h-4 mr-2"></i> MANUAL
            </a>
            <a href="../logout.php" class="flex items-center p-3 border-2 border-transparent hover:border-black font-mono font-bold transition-all mt-20 text-red-500">
                <i data-lucide="log-out" class="w-4 h-4 mr-2"></i> LOGOUT
            </a>
        </nav>
    </aside>

    <main class="lg:ml-64 p-4 md:p-8">
        <header class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black uppercase font-mono italic">Order Management</h2>
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-yellow-400 border-2 border-black rounded-full flex items-center justify-center font-bold"><?=strtoupper($_SESSION['admin_name'][0])?></div>
                <span class="font-mono text-sm hidden sm:block uppercase"><?=ucfirst($_SESSION['admin_name'])?></span>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="stats-card bg-white border-2 border-black p-4 admin-shadow">
                <p class="text-[10px] font-mono font-bold text-gray-400 uppercase">ทั้งหมด</p>
                <p class="text-2xl font-black counter" data-target="<?=$total?>">0</p>
            </div>
            <div class="stats-card bg-gray-200 border-2 border-black p-4 admin-shadow">
                <p class="text-[10px] font-mono font-bold uppercase text-gray-600">ทั่วไป</p>
                <p class="text-2xl font-black counter" data-target="<?=$count_status["pending"]?>">0</p>
            </div>
            <div class="stats-card bg-yellow-300 border-2 border-black p-4 admin-shadow">
                <p class="text-[10px] font-mono font-bold uppercase text-yellow-800">รอคิว</p>
                <p class="text-2xl font-black counter" data-target="<?=$count_status["waiting"]?>">0</p>
            </div>
            <div class="stats-card bg-green-400 border-2 border-black p-4 admin-shadow">
                <p class="text-[10px] font-mono font-bold uppercase text-green-800">สำเร็จ</p>
                <p class="text-2xl font-black counter" data-target="<?=$count_status["completed"]?>">0</p>
            </div>
            <div class="stats-card bg-red-400 border-2 border-black p-4 admin-shadow">
                <p class="text-[10px] font-mono font-bold uppercase text-red-800">ปฏิเสธ</p>
                <p class="text-2xl font-black counter" data-target="<?=$count_status["rejected"]?>">0</p>
            </div>
        </div>

        <!-- Filter Controls -->
        <div class="flex flex-wrap gap-2 mb-6" id="filter-container">
            <button id="btn-all" onclick="filterOrders('all', this)" class="px-4 py-2 border-2 border-black font-mono font-bold text-xs filter-active hover:bg-black hover:text-white transition-all uppercase">ออร์เดอร์ทั้งหมด</button>
            <button id="btn-general" onclick="filterOrders('pending', this)" class="px-4 py-2 border-2 border-black font-mono font-bold text-xs bg-white hover:bg-black hover:text-white transition-all uppercase">ออร์เดอร์ทั่วไป</button>
            <button id="btn-pending" onclick="filterOrders('waiting', this)" class="px-4 py-2 border-2 border-black font-mono font-bold text-xs bg-white hover:bg-black hover:text-white transition-all uppercase">รอคิวปริ้น</button>
            <button id="btn-completed" onclick="filterOrders('completed', this)" class="px-4 py-2 border-2 border-black font-mono font-bold text-xs bg-white hover:bg-black hover:text-white transition-all uppercase">ปริ้นสำเร็จ</button>
            <button id="btn-rejected" onclick="filterOrders('rejected', this)" class="px-4 py-2 border-2 border-black font-mono font-bold text-xs bg-white hover:bg-black hover:text-white transition-all uppercase">ออร์เดอร์ที่ปฏิเสธ</button>
        </div>

        <!-- Orders Table -->
        <div class="bg-white border-4 border-black admin-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 border-b-4 border-black font-mono uppercase text-xs">
                        <tr>
                            <th class="p-4 border-r-2 border-black w-20">ID</th>
                            <th class="p-4 border-r-2 border-black">Customer</th>
                            <th class="p-4 border-r-2 border-black">Status</th>
                            <th class="p-4 border-r-2 border-black w-48 text-center">Actions</th>
                            <th class="p-4 w-10"></th>
                        </tr>
                    </thead>
                    <tbody class="font-mono" id="orders-body">
                        <?php
                            // quese counter
                            $queue = 1;
                            // -------------
                            foreach ($sordOrders as $order) {
                                $order_id = $order["order_id"];
                                $order_user_name = $order["username"];
                                $order_date = $order["date"];
                                $order_status = $order["status"];

                                $order_link = $order["link"];
                                $order_paper_type = $order["paper_type"];
                                $order_size = $order["size"];
                                $order_qty = $order["quantity"];
                                $order_message = $order["message"];
                                $order_respone = $order["respone"];

                                $status_color = $status_dict[$order_status]["color"];
                                $status_text = $status_dict[$order_status]["text"];

                                ?>
                                
                                <!-- Main-->
                                <tr class="order-row border-b-2 border-black" data-status="<?=$order_status?>" id="row-2001" onclick="toggleRow(this)">
                                    <td class="p-4 border-r-2 border-black font-bold">
                                        <div class="flex">
                                            <?php if ($order_status == $status_dict["waiting"]["mean"])  { ?>
                                                <div class="flex justify-center bg-yellow-400 px-2 mr-2 border-2 border-black">
                                                    <span class="text-s font-bold text-black "><?= $queue?></span>
                                                    <?php $queue++; ?>
                                                </div>
                                            <?php } ?>
                                            <?php
                                                echo "#".$order_id;
                                            ?>
                                        </div>
                                    </td>
                                    <td class="p-4 border-r-2 border-black">
                                        <p class="text-xs font-bold"><?=$order_user_name?></p>
                                        <p class="text-[10px] text-gray-400"><?=$order_date?></p>
                                    </td>
                                    <td class="p-4 border-r-2 border-black ">
                                        <span class="status-badge bg-general <?=$status_color?>"><?=$status_text?></span>
                                    </td>
                                    <td class="p-4 border-r-2 border-black">
                                        <div class="flex justify-center space-x-2">
                                            <!-- <button onclick="event.stopPropagation(); updateStatus('2001', 'pending')" class="btn-action bg-yellow-300">รับงาน</button>
                                            <button onclick="event.stopPropagation(); openRejectModal('2001')" class="btn-action bg-red-400">ปฏิเสธ</button> -->
                                            <?php foreach ($status_dict as $action_btn) {
                 
                                                if ($order_status == $action_btn["mean"]) {
                                   
                                                    foreach ($action_btn["action"] as $action) {
                                                        $mean = $action["mean"];
                                                        
                                                        $confirm = ($mean == "delete") 
                                                        || ($mean == "reject") 
                                                        || ($mean == "cancelled");
             
                                                        // Pass string '$mean' (with quotes) to JS function
                                                        $onclick = "open_confirm($order_id, '$mean');";
                                                        
                                                       ?>   
                                                            <?php if (!$confirm) echo "<form action='orders_mng.php' method='POST'>"; ?>

                                                                <button name ="<?=$action['mean'];?>"  onclick ="event.stopPropagation(); <?php if ($confirm) echo $onclick; ?>"   value="<?=$order["order_id"]?>"   class=" flex btn-action <?=$action["color"]?> <?=$action["text_color"]?>">
                                                                    <?php if ($action["mean"] == "delete") { ?>
                                                                        <i data-lucide='<?=$action['icon']?>' class='w-3 h-3 mr-1'></i>
                                                                    <?php } ?>
            
                                                                    <?=$action["text"]?>
                                                                </button>

                                                            <?php if (!$confirm) echo "</form>"; ?>
                                                        <?php
                                                    }
                                                }
                                            } ?>
                                    
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <i data-lucide="chevron-down" class="chevron-icon w-4 h-4"></i>
                                    </td>
                                </tr>

                                <!-- Detail -->
                                <tr class="details-row" data-status="<?=$order_status?>">
                                    <td colspan="5" class="p-0 border-r-2 border-black">
                                        <div class="details-container">
                                            <div class="p-6 bg-white grid md:grid-cols-2 gap-8 border-t-2 border-black">
                                                <div class="space-y-4">
                                                    <?php if ($order_status == "rejected") { ?>
                                                        <div class="flex items-center space-x-2 font-mono mb-4">
                                                            <i data-lucide="circle-alert" class="text-sm text-red-500"></i>
                                                            <p class="font-bold">เหตุผลในการปฏิเสธงาน : <span class = "text-sm text-red-500"><?php if ($order_respone != "") { echo $order_respone; } else { echo "คุณไม่ได้บอกเหตุผลในการปฏิเสธงานไว้..."; } ?></span></p>
                                                        </div>
                                                    <?php } ?>

                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ลิ้งก์ไฟล์งาน</p>
                                                        <a href="#" class="inline-flex items-center text-blue-600 underline text-sm font-bold break-all">
                                                            <i data-lucide="external-link" class="w-3 h-3 mr-1"></i><?=$order_link?>
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ข้อมูลการพิมพ์ (SPECS)</p>
                                                        <div class="grid grid-cols-2 gap-2 text-xs">
                                                            <p><span class="text-gray-500">กระดาษ:</span> <?=$order_paper_type?></p>
                                                            <p><span class="text-gray-500">ขนาด:</span> <?=$order_size?></p>
                                                            <p><span class="text-gray-500">จำนวน:</span> <span class="font-bold"><?=$order_qty?></span> ชุด</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="space-y-2">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">ข้อความจากลูกค้า</p>
                                                    <div class="text-sm italic border-l-4 border-black pl-3 py-2 bg-gray-50 shadow-inner">
                                                        "<?=$order_message?>"
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <script>
        // --- Toggle Row Details ---
        function toggleRow(rowElement) {
            const isActive = rowElement.classList.contains('active');
            
            // ถ้าแถวที่กดไม่ได้ active อยู่ ให้เปิดมันซะ
            if (!isActive) {
                rowElement.classList.add('active');
            }else {
                rowElement.classList.remove('active');
            }
        }

        // --- Stats Counter Animation ---
        function initCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const increment = target / 20;
                let current = 0;
                
                const updateCounter = () => {
                    if (current < target) {
                        current = Math.ceil(current + increment);
                        counter.innerText = current;
                        setTimeout(updateCounter, 50);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCounter();
            });
        }

        // --- Filter Logic ---
        function filterOrders(status, btn) {
            const buttons = document.querySelectorAll('#filter-container button');
            buttons.forEach(b => b.classList.remove('filter-active'));
            btn.classList.add('filter-active');

            const rows = document.querySelectorAll('.order-row');
            const detailsRows = document.querySelectorAll('.details-row');

            rows.forEach((row, index) => {
                const details = detailsRows[index];
                if (status === 'all') {
                    row.classList.remove('hidden');
                    details.classList.remove('hidden');
                } else {
                    if (row.dataset.status === status) {
                        row.classList.remove('hidden');
                        details.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                        details.classList.add('hidden');
                        row.classList.remove('active');
                    }
                }
            });
        }


        // open confrim popup
        function open_confirm(id,action) {

            if (action == "reject") { 
                var confirm_parent = document.getElementById("rejectModal");
                var confirm_btn = document.getElementById("confirm_relect_btn");
            }else {
                var confirm_parent = document.getElementById("deleteModal");
                var confirm_btn = document.getElementById("confirm_delete_btn");
            
                // Set Titles based on action
                let title;
                let des;
                let btnText;

                if (action == "delete") {
                    title = "ลบข้อมูลถาวร?";
                    des = "คุณกำลังจะลบออเดอร์นี้ออกจากระบบอย่างถาวร ยืนยันหรือไม่?";
                    btnText = "ยืนยันการลบ";
                } else if (action == "cancelled") {
                    title = "ยกเลิกสถานะปัจจุบันของออเดอร์นี้?";
                    des = "คุณกำลังจะยกเลิกสถานะปัจจุบันของออเดอร์นี้ ยืนยันหรือไม่?";
                    btnText = "ยืนยันการยกเลิก";
                }

                const confirm_title = confirm_parent.querySelector("h3");
                const confirm_des = confirm_parent.querySelector("p");
    
                confirm_title.innerText = title;
                confirm_des.innerText = des;
                confirm_btn.innerText = btnText;
    
            }
            
            confirm_btn.value = id;
            confirm_btn.name = action; 

            confirm_parent.classList.remove('hidden');

        }

        // close confrim popup
        function close_confirm() {
            const confirm_delete = document.getElementById("deleteModal");
            const confirm_reject = document.getElementById("rejectModal");
            confirm_delete.classList.add('hidden');
            confirm_reject.classList.add('hidden');
        }

        // function executeReject() {
        //     const reason = document.getElementById('rejectReason').value;
        //     if (!reason) return;
            
        //     const row = document.getElementById('row-' + currentTargetId);
        //     const badge = row.querySelector('.status-badge');
        //     const actions = document.getElementById('actions-' + currentTargetId);
            
        //     row.dataset.status = 'rejected';
        //     badge.innerText = 'ปฏิเสธ';
        //     badge.className = 'status-badge bg-rejected';
        //     actions.innerHTML = `<button onclick="event.stopPropagation(); openDeleteModal('${currentTargetId}')" class="btn-action bg-white text-red-600 uppercase">ลบทิ้ง</button>`;
            
        //     closeModal('rejectModal');
        // }

        // function executeDelete() {
        //     const row = document.getElementById('row-' + currentTargetId);
        //     const detailRow = row.nextElementSibling;
            
        //     row.style.transform = 'translateX(20px)';
        //     row.style.opacity = '0';
        //     detailRow.style.opacity = '0';
            
        //     setTimeout(() => {
        //         row.remove();
        //         detailRow.remove();
        //     }, 300);
            
        //     closeModal('deleteModal');
        // }

        window.onload = () => {
            initCounters();
            lucide.createIcons();
        };
    </script>
</body>
</html>