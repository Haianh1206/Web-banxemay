<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    // Lấy thông tin từ session và dữ liệu POST
    $makh = $_SESSION['user']['makh'];
    $donmua = '';
    foreach ($data['products'] as $product) {
        $donmua .= $product['tensp'] . ' x ' . $product['soluong'] . ', ';
    }
    $tentk1 = $data['tentk1'];
    $diachi1 = $data['diachi1'];
    $sdt1 = $data['sdt1'];
    $email1 = $data['email1'];
    $donmua = rtrim($donmua, ', ');
    $ngaydat = date("Y-m-d H:i:s");
    $phuongthuc = $data['paymentMethod'];
    $thanhtien = $data['totalAmount'];

    // Kết nối cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'cua_hang_xe_may_nhom3');

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu']);
        exit;
    }

    $sql = "INSERT INTO thongtindathang (makh,tentk1,diachi1,sdt1,email1, donmua, ngaydat, phuongthuc, thanhtien) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssi", $makh,$tentk1, $diachi1, $sdt1, $email1, $donmua, $ngaydat, $phuongthuc, $thanhtien);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
}
?>
