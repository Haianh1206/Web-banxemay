<?php

session_start();
// Khởi tạo kết nối cơ sở dữ liệu
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "cua_hang_xe_may_nhom3";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

header("Content-Type: application/json");

if (isset($_POST['selectedItems']) && isset($_SESSION['user']['makh'])) {
    $selectedItems = json_decode(file_get_contents('php://input'))->selectedItems;
    $makh = $_SESSION['user']['makh'];

    // Lấy thông tin khách hàng
    $customerQuery = "SELECT tenkh, diachi, sdt, email FROM dangky WHERE makh = $makh";
    $customerResult = $conn->query($customerQuery);
    $customer = $customerResult->fetch_assoc();

    // Lấy thông tin các sản phẩm đã chọn
    $orderItems = [];
    foreach ($selectedItems as $magiohang) {
        $sql = "SELECT thongtinsanpham.tensp AS name, thongtinsanpham.anhsp AS image, giohang.mauchon AS color, giohang.soluong AS quantity, thongtinsanpham.gia AS price
                FROM giohang
                JOIN thongtinsanpham ON giohang.masp = thongtinsanpham.masp
                WHERE giohang.magiohang = $magiohang AND giohang.makh = $makh";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                $item['totalPrice'] = number_format($item['price'] * $item['quantity'], 0, ',', '.');
                $orderItems[] = $item;
            }
        }
    }

    echo json_encode([
        "customer" => [
            "name" => $customer['tenkh'],
            "address" => $customer['diachi'],
            "phone" => $customer['sdt'],
            "email" => $customer['email']
        ],
        "orderItems" => $orderItems
    ]);
} else {
    echo json_encode(["error" => "No items selected or not logged in."]);
}
?>
