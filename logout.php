<?php
    session_start();

    // ทำลาย session ทั้งหมด
    session_unset();
    session_destroy();

    // ลบ cookie session (ถ้ามี)
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }

    // Redirect กลับไปหน้า login
    header("Location: auth/signin/signin.php");
    exit();
?>
