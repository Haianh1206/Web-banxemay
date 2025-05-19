<?php
session_start(); // Bắt đầu phiên làm việc

// Xóa tất cả các biến trong phiên
$_SESSION = array();

// Nếu cần, xóa cookie phiên
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cuối cùng, hủy phiên
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: DangNhap.php"); // Đổi `login.php` thành trang đăng nhập của bạn
exit;
?>
