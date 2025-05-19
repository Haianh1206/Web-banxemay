<!-- code truyền thông tin người dùng sang trang chủ bằng session -->
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

$name_user = "";

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user'])) {
	$name_user = "Bạn chưa đăng nhập.";
} else {
	// Lấy tên đăng nhập từ session
	$session_username = $_SESSION['user']['tendn'];

	// Lấy thông tin từ cơ sở dữ liệu
	$sql2 = "SELECT tentk, tendn, email, sdt, diachi FROM dangky WHERE tendn = ?";
	$stmt = $conn->prepare($sql2);
	$stmt->bind_param("s", $session_username);
	$stmt->execute();
	$result2 = $stmt->get_result();

	if ($result2->num_rows > 0) {
		$user = $result2->fetch_assoc();

		// Kiểm tra nếu trường 'tendn' tồn tại trong mảng $user
		if (isset($user['tendn']) && $user['tendn'] === $session_username) {
			$name_user = "Chào mừng, " . htmlspecialchars($user['tentk']) . "!";
		} else {
			$name_user = "Tên đăng nhập trong session không khớp với bất kỳ bản ghi nào.";
		}
	} else {
		$name_user = "Không tìm thấy tên đăng nhập trong cơ sở dữ liệu.";
	}

	// Đóng statement
	$stmt->close();
}

// Đóng kết nối
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="TrangTri.css">
	<title>AHC motorbike</title>
	<link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.1.2-web/css/all.min.css">
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
			font-family: Arial, sans-serif;
		}

		body {
			background-color: #f4f4f4;
		}

		.header {
			display: block;
			background-color: #333;
			background-image: url(assets/img/background.jpg);
			background-size: cover;
			background-position: center;
			color: #fff;
			padding: 10px 20px;
			position: fixed;
			top: 0;
			z-index: 1000;
			width: 100%;
		}

		.header_row1 {
			display: flex;
			justify-content: space-between;
			margin-bottom: 10px;
		}

		.header_row2 {
			display: flex;
			align-items: center;
			width: 100%;
		}

		.logo {
			display: flex;
			align-items: center;
		}

		.logo img {
			width: 50px;
			height: 50px;
			margin-right: 10px;
		}

		.nav a {
			font-size: 15px;
			color: #fff;
			margin-left: 20px;
			text-decoration: none;
			transition: transform 0.3s ease, color 0.3s ease;
			/* Thời gian và hiệu ứng chuyển đổi */
		}

		.nav a:hover {
			transform: scale(1.2);
			/* Khi hover, chữ sẽ to lên 1.2 lần */
			color: #db4a3d;
			/* Khi hover, chữ đổi sang màu đỏ */
			background-color: #f7e7e3;
			padding: 10px;
			border-radius: 5px;
		}

		.search_bar {
			display: flex;
			padding: none;
			justify-content: normal;
			background-color: #fff;
			margin-left: 40px;
			border-radius: 5px;
			margin-right: 70px;
			display: flex;
		}

		.search_bar input {
			width: 70%;
			padding: 10px;
			border: none;
			border-radius: 5px;
		}

		.search_bar input:focus {
			outline: none;
		}

		.search_bar button {
			padding: 5px;
			background-color: #db4a3d;
			color: #fff;
			border: none;
			border-radius: 5px;
			font-size: 10px;
			height: 32px;
			width: 45px;
			margin: auto 2px;
		}

		.search_bar button:hover {
			cursor: pointer;
			background-color: #d66a62;
		}

		.cart_icon {
			display: flex;
			margin-right: 100px;
		}

		.cart_icon img {
			width: 30px;
			height: 30px;
			background-color: orange;
		}

		.cart_icon span {
			font-size: 14px;
			margin-left: 5px;
		}

		.cart_icon i:hover {
			cursor: pointer;
			color: #db673d;
			font-size: 20px;
		}

		.container {
			display: flex;
			margin: 20px;
			height: calc(100% - 50px);
			margin-top: 6.6%;
			margin-bottom: 110px;
		}

		.sidebar {
			position: fixed;
			left: 10px;
			height: 74%;
			width: 15%;
			padding: 10px;
			background-color: #eee;
			border-radius: 5px;
			box-shadow: 0.1px 0.1px 5px 0.1px rgba(0, 0, 0, 0.5);
			margin-top: 5px;
		}

		.sidebar h3 {
			margin: 20px 0 20px 20px;
		}

		.sidebar ul {
			list-style: none;
			margin-left: 50px;
		}

		.sidebar ul li {
			margin: 10px 0;
			transition: transform 0.8 ease;
		}

		.sidebar ul li:hover {
			transform: translateX(5px);
			color: red;
		}

		.sidebar ul li a {
			margin-bottom: 10px;
			text-decoration: none;
			/* Không gạch chân */
			color: black;
			/* Màu chữ ban đầu */
			font-size: 16px;
			/* Kích thước chữ ban đầu */
			position: relative;
			/* Để có thể đặt mũi tên */
			transition: color 0.3s, transform 0.3s;
			/* Hiệu ứng chuyển đổi cho màu sắc và kích thước */
		}

		.sidebar ul li a ::before {
			content: '→';
			/* Mũi tên phải */
			position: absolute;
			left: -30px;
			/* Vị trí của mũi tên trước chữ */
			opacity: 0;
			/* Ban đầu ẩn mũi tên */
			transition: opacity 0.3s ease, left 0.3s ease;
			/* Hiệu ứng chuyển mượt mà */
		}

		.sidebar ul li a:hover ::before {
			opacity: 1;
			/* Hiển thị mũi tên khi hover */
			left: -40px;
			/* Di chuyển mũi tên sang trái một chút khi hover */
		}

		.sidebar ul li a:hover {
			border-radius: 5px;
			padding: 5px;
			margin-bottom: 10px;
			background-color: #e0dede;
			color: red;
			transform: scale(1.2);
		}

		.product_section {
			width: 100%;
			margin-left: 230px;
		}

		.filter {
			box-shadow: 0.1px 0.1px 5px 0.1px rgba(0, 0, 0, 0.5);
			width: 82%;
			display: flex;
			position: fixed;
			background-color: #f4f4f4;
			margin-bottom: 20px;
			z-index: 1;
		}

		.filter button {
			margin-left: 30px;
			transition: transform 0.3 ease;
			cursor: pointer;
		}

		.filter button:hover {
			margin-right: 10px;
			color: #fff;
			transform: scale(1.2);
			background-color: #d66a62;
		}

		.filter select:hover {
			outline: 2px solid #e59b87;
			/* Thêm viền khi di chuột qua */
		}

		.filter select:focus {
			outline: none;
			/* Bỏ viền khi nhấn vào */
		}

		.filter select {
			margin-right: 30px;
			background-color: #000;
		}

		.filter button,
		.filter select {
			padding: 10px 20px;
			border: none;
			background-color: #f4f4f4;
			margin-top: 5px;
			margin-bottom: 5px;

		}

		.two_price {
			height: 50px;
			display: block;
			align-items: center;
			justify-content: center;
		}

		.old_price {
			text-decoration: line-through;
		}

		.price {
			font-style: italic;
			font-size: 20px;
		}

		.product_list {
			display: flex;
			justify-content: space-between;
			margin-top: 20px;
		}

		.product_detail {
			display: none;
			width: 100px;
			height: 100px;
			background-color: red;
		}

		/*Banner cho trang web*/
		.banner {
			margin-top: 40px;
		}

		.slideshow-container {
			position: relative;
			max-width: 100%;
			margin: auto;
			overflow: hidden;
		}

		.mySlides {
			display: none;
		}

		img {
			width: 100%;
			height: auto;
		}

		/* Hiệu ứng fade cho các hình ảnh khi chuyển đổi */
		.fade {
			animation-name: fade;
			animation-duration: 1.5s;
		}

		@keyframes fade {
			from {
				opacity: .4
			}

			to {
				opacity: 1
			}
		}

		/* Dấu chấm để chuyển đổi hình ảnh thủ công */
		.dot {
			height: 15px;
			width: 15px;
			margin: 0 2px;
			background-color: #bbb;
			border-radius: 50%;
			display: inline-block;
			transition: background-color 0.6s ease;
			cursor: pointer;
		}

		.active {
			background-color: #717171;
		}

		/* Căn giữa dấu chấm ở dưới */
		.dot-container {
			text-align: center;
			padding: 10px;
			background: #000;
			position: absolute;
			bottom: 0;
			width: 100%;
		}

		.prev,
		.next {
			cursor: pointer;
			position: absolute;
			top: 50%;
			width: auto;
			padding: 16px;
			margin-top: -22px;
			color: white;
			font-weight: bold;
			font-size: 18px;
			transition: 0.6s ease;
			border-radius: 0 3px 3px 0;
			user-select: none;
		}

		.next {
			right: 0;
			border-radius: 3px 0 0 3px;
		}

		/* Hiệu ứng khi di chuột lên các nút */
		.prev:hover,
		.next:hover {
			background-color: rgba(0, 0, 0, 0.8);
		}

		/*Phần danh sách sản phẩm*/
		.product_home {
			width: 99.7%;
			display: block;
		}

		.product {
			background-color: #fff;
			padding: 15px;
			text-align: center;
			border: 1px solid #ddd;
			width: 15%;
			/*sửa thành 23*/
			border-radius: 5px;
			position: relative;
			height: 310px;
		}

		.product h4 {
			margin-top: 10px;
			margin-bottom: 20px;
			font-size: 20px;
		}

		.product:hover {
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
		}

		.product img {
			width: 100px;
			height: 100px;
		}

		.edit_icon {
			margin-right: 5px;
		}

		.footer {
			background-color: #333;
			background-image: url(assets/img/background.jpg);
			background-size: cover;
			color: #fff;
			padding: 20px;
			position: fixed;
			bottom: 0;
			width: 100%;
			height: 10%;
			display: flex;
		}

		.footer_info p,
		.team h3,
		.team ul li {
			margin-bottom: 10px;
		}

		.logo {
			margin-left: 150px;
		}

		.footer_info {
			width: 290px;
			font-size: 10px;
			line-height: 0.7;
			text-shadow:
				-1px -1px 0 #000,
				1px -1px 0 #000,
				-1px 1px 0 #000,
				1px 1px 0 #000;
			/* Đặt các bóng ở các góc khác nhau để tạo viền */
		}

		.team {
			height: 60%;
			display: flex;
			text-shadow:
				-1px -1px 0 #000,
				1px -1px 0 #000,
				-1px 1px 0 #000,
				1px 1px 0 #000;
			/* Đặt các bóng ở các góc khác nhau để tạo viền */
			margin-left: 30px;
			margin-bottom: 10px;
			font-size: 10px;
			line-height: 0.7;
			position: absolute;
			bottom: 1px;
			right: 50px;
		}

		.team ul li {
			margin-left: 20px;
		}

		.divider {
			border: none;
			height: 1px;
			background-color: rgba(0, 0, 0, 0.5);
			/* Màu đen với độ mờ 20% */
			margin: 20px 0;
			/* Khoảng cách trên dưới của đường kẻ */
		}

		.column {
			opacity: 0.5;
		}

		.present_page {
			color: red;
		}

		.infor_product {
			margin: 10px 0;
		}

		.fa-solid {
			margin-right: 5px;
		}

		.link_product {
			text-decoration: none;
			color: black;
		}

		#prd_top {
			margin-top: 40px;
		}

		/*css cho trang chi tiết sản phẩm*/
		.detail_page {
			margin-bottom: -25px;
			display: none;
			margin-top: 40px;
			background: linear-gradient(to right, #525656, #EEEEEE);
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
		}

		.detail_page h1 {
			padding: 15px 0;
			background: linear-gradient(to right, #f2840e, #f2250e);
			text-align: center;
		}

		.detail_info {
			background: linear-gradient(to right, #525656, #EEEEEE);
			display: flex;
		}

		.product_info {
			gap: 20px;
			display: flex;
			flex-direction: column;
		}

		.product_info p {
			word-wrap: break-word;
			overflow-wrap: break-word;
			margin-left: 100px;
		}

		.detail_info img {
			border-radius: 5px;
			box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.3);
			width: 50%;
			margin-left: 10px;
		}

		.buy_info {
			background: linear-gradient(to right, #525656, #EEEEEE);
			padding: 30px 0 50px 0;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			gap: 15px
		}

		.buy_info input {
			padding: 5px 5px;
			width: 50px;
		}

		.buy_info button : hover {
			background-color: #e58f67;
		}

		.hidden_masp {
			text-align: center;
			color: #A9ABAB;
		}

		.buy_label {
			margin-right: 10px;
		}

		.buy_price {
			font-style: italic;
			color: #d63804;
			font-size: 30px;
		}

		.product_price {
			align-items: center;
		}

		.product_color {
			margin-top: 10px;
			align-items: center;
		}

		.quantity {
			margin: 10px 0;
			align-items: center;
		}

		.quantity input {
			border-radius: 5px;
			width: 65px;
			text-align: center;
		}

		.box_color:hover {
			box-shadow: 0 0 3px 1px rgba(0, 0, 0, 0.5);
		}

		.box_color {
			margin-right: 10px;
			height: 20px;
			width: 20px;
			border: 1px solid #000;
			cursor: pointer;
		}

		.red_color {
			background-color: red;
		}

		.black_color {
			background-color: black;
		}

		.white_color {
			background-color: white;
		}

		.one_info {
			display: flex;
		}

		#btn_add,
		.btn_back {
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			background-color: white;
			margin: 10px 10px;
			border: none;
			padding: 10px;
			height: 40px;
			width: 150px;
		}

		#btn_add {
			margin-left: 50px;
		}

		#btn_add:hover,
		.btn_back:hover {
			color: #fff;
			background-color: #e58f67;
		}

		/*Trang giỏ hàng*/
		.cart_page {
			width: 99.5%;
			margin-top: 35px;
			display: none;
		}

		.cart_info {
			width: 100%;
			background: linear-gradient(to right, #EEEEEE, #525656);
			margin-top: 20px;
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			padding: 20px;
			display: flex;
			align-items: center;
		}

		.cart_img {
			width: 20%;
		}

		.cart_img img {
			width: 90%;
		}

		.cart_color {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-right: 20px;
		}

		.increase_reduce {
			margin-right: 100px;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.button_in_cart {
			display: flex;
			width: 100%;
			justify-content: center;
			align-items: center;
			margin: 45px 0 0 0;
		}

		.button_in_cart button {
			font-weight: bold;
			border: none;
			color: #fff;
			border-radius: 3px;
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.3);
			padding: 20px;
			height: 70px;
			margin: 0 30px;
			width: 300px;
			background-color: #e57b39;
			cursor: pointer;
		}

		.button_in_cart button:hover {
			color: #000;
			background-color: #f2af85;
		}

		.btn_delete {
			font-weight: bold;
			color: #fff;
			border: none;
			border-radius: 3px;
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.3);
			padding: 20px;
			height: 70px;
			width: 100px;
			background-color: #e57b39;
			cursor: pointer;
			margin-left: 150px;
		}

		.btn_delete:hover {
			color: #000;
			background-color: #f2af85;
		}

		.select_buy {
			transform: scale(4);
			margin-left: 40px;
		}

		.select_buy:checked {
			background-color: #4CAF50;
		}

		.price_in_cart {
			text-shadow: 0.5px 0 1px black, 0.5px 0.5px 1px black;
			color: #cc432a;
			width: 20%;
			font-style: italic;
			font-weight: bold;
			font-size: 25px;
		}

		.group_color {
			margin-top: 20px;
			display: flex;
		}

		.cart_color p {
			margin-right: 10px;
		}

		.increase_reduce input {
			width: 30%;
			margin: 0 10px;
			padding: 5px 0;
			padding-left: 5px;
			text-align: center;
		}

		.increase_reduce button {
			padding: 5px 10px;
		}

		.label_in_cart {
			font-size: 20px;
			font-weight: bold;
		}

		/*điều hướng trang*/
		.turn_page {
			margin-top: 20px;
			padding: 30px 0 10px 0;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.turn_page button {
			margin: 0 10px;
			padding: 20px;
		}

		/*thông tin đặt hàng*/
		.book_info {
			margin-bottom: -25px;
			padding-bottom: 30px;
			border-radius: 5px;
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
			display: none;
			margin-top: 40px;
			background: linear-gradient(to bottom, #e0d9d5, #8e8986);
		}

		.book_info h1 {
			border-radius: 5px 5px 0 0;
			overflow: hidden;
			text-align: center;
			padding: 15px 0;
			background: linear-gradient(to right, orange, red);
		}

		.book_title {
			font-weight: bold;
			font-size: 25px;
			margin-bottom: 10px;
		}

		.form_oder_info {
			display: flex;
			margin: 20px 0;
		}

		.title_method {
			display: flex;
		}

		.title_method i {
			font-size: 25px;
		}

		.pay_method {
			margin: 0 0 20px 30px;
		}

		.pay_method input {
			transform: scale(1.5);
			/* Điều chỉnh số này để thay đổi kích cỡ radio*/
			margin-bottom: 10px;
		}


		.pay_money {
			width: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.pay_money>p:first-child {
			margin-top: 10px;
			margin-right: 10px;
		}

		.pay_money>p:nth-child(2) {
			text-shadow: 1px -1px 1px black;
			font-size: 35px;
			color: #db451c;
			font-style: italic;
		}

		.send_receive {
			background-color: transparent;
			margin-bottom: 20px;
			display: flex;
		}

		.btn_book_cancel {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.divider1 {
			margin-top: 10px;
			width: 100%;
			background-color: #000;
			/* Màu của đường phân cách */
			height: 1px;
			opacity: 0.2;
		}

		.divider2 {
			margin-top: 10px;
			width: 0.7px;
			background-color: #000;
			/* Màu của đường phân cách */
			height: 150px;
			opacity: 0.5;
		}

		.divider3 {
			margin: 5px 0 10px 0;
			width: 550px;
			background-color: #000;
			/* Màu của đường phân cách */
			height: 1px;
			opacity: 0.5;
		}

		.divider4 {
			text-align: center;
			background-color: transparent;
			margin: 0px 10px 20px 10px;
			width: 90%;
			background-color: #000;
			/* Màu của đường phân cách */
			height: 1px;
			opacity: 0.5;
		}

		.order_info {
			background-color: transparent;
			border-left: 10px;
			width: 50%;
			margin-left: 20px;
			margin-top: 20px;
		}

		.order_info li {
			display: flex;
		}

		.order_info li p {
			margin-right: 10px;
		}

		.btn_book_cancel {
			margin-top: 50px;
			width: 100%;
			display: block;
			text-align: center;
		}

		.btn_book_cancel button {
			align-items: center;
			border-radius: 5px;
			width: 50%;
			height: 40px;
			border: 1px solid gray;
			margin-bottom: 20px;
		}

		.btn_book_cancel button:hover {
			background-color: #f97c34;
			color: #fff;
		}

		/* Kiểu dáng cho thông báo tùy chỉnh */
		.modal {
			display: none;
			/* Ẩn modal mặc định */
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: white;
			padding: 20px;
			border: 1px solid #ccc;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}

		.modal2 {
			display: none;
			/* Ẩn modal mặc định */
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: white;
			padding: 20px;
			border: 1px solid #ccc;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}

		.modal3 {
			display: none;
			/* Ẩn modal mặc định */
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			background-color: white;
			padding: 20px;
			border: 1px solid #ccc;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
		}

		.overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
		}

		.overlay2 {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
		}

		.overlay3 {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
		}

		.btn-close {
			margin-left: 200px;
			margin-top: 10px;
			cursor: pointer;
			padding: 5px 10px;
			background-color: #ff5c5c;
			color: white;
			border: none;
			text-align: center;
		}

		.btn-close2 {
			cursor: pointer;
			padding: 5px 10px;
			background-color: #ff5c5c;
			color: white;
			margin-left: 200px;
			margin-top: 20px;
			border: none;
			text-align: center;
		}

		.btn-close3 {
			cursor: pointer;
			padding: 5px 10px;
			background-color: #ff5c5c;
			color: white;
			margin-left: 200px;
			margin-top: 20px;
			border: none;
			text-align: center;
		}

		.btn_user {
			position: relative;
		}

		.user_info ::after {
			content: "";
			position: absolute;
			top: -40px;
			/* Khoảng cách để mũi tên nằm ngay cạnh trên */
			right: 0;
			transform: translateX(-50%);
			border-width: 20px;
			border-style: solid;
			border-color: transparent transparent #494646 transparent;
			/* Màu tam giác theo màu nền thẻ */
			pointer-events: none;
			/* Ngăn mũi tên nhận sự kiện hover */
		}

		.user_info {
			margin-top: 10px;
			background: linear-gradient(to bottom, #494646, #847f7f);
			display: none;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			box-shadow: 0 0 5px 1px rgba(255, 255, 255, 0.5);
			border-radius: 10px;
			padding: 30px 70px 50px 70px;
			top: 50px;
			right: 20px;
			background-color: blue;
			position: absolute;
			z-index: 3;
		}

		.user_info h1 {
			font-size: 20ox;
			margin-bottom: 20px;
		}

		.user_info i {
			margin-bottom: 30px;
			font-size: 70px;
		}

		.user_info p {
			margin-bottom: 20px;
		}

		.user_info button {
			color: #fff;
			border: none;
			background-color: #db4a3d;
			box-shadow: 0 0 5px 1px rgba(0, 0, 0, 0.5);
			border-radius: 5px;
			margin-top: 10px;
			padding: 5px 10px;
		}

		.user_info button:hover {
			background-color: #d66a62;
		}

		.btn_like {
			background-color: transparent;
		}

		.btn_dislike {
			margin-left: 20px;
			font-size: 20px;
			border: none;
			background: transparent;
		}

		.icon_like {
			color: #c61111;
			display: none;
		}

		.icon_dislike {
			display: block;
		}

		.clear {
			clear: both;
		}

		.btn_add {
			margin-top: 10px;
			cursor: pointer;
			padding: 5px 10px;
			background-color: #ff5c5c;
			color: white;
			border: none;
		}

		.products_list {
			margin-top: 20px;
			display: flex;
			flex-wrap: wrap;
			gap: 20px;
			justify-content: center;
			align-items: center;
		}

		.numerical_page {
			position: absolute;
			right: 100px;
			display: flex;
		}

		.numerical_page p {
			font-size: 20px;
			margin-right: 5px;
		}

		.discount-label {
			background-color: red;
			color: white;
			font-weight: bold;
			padding: 5px 10px;
			position: absolute;
			top: 10px;
			left: 10px;
			border-radius: 5px;
		}

		.combo_info {
			width: 30%;
		}

		.no_products {
			margin-top: 10%;
			font-style: italic;
			text-align: center;
		}

		.img_in_order {
			display: flex;
			justify-content: center;
			align-items: center;
			width: 30%;
		}

		.img_in_order img {
			max-width: 80px;
			height: 80px;
		}
	</style>
</head>

<body>

	<?php
	/*code php hiển thị các sản phẩm*/
	// Kết nối tới cơ sở dữ liệu
	$servername = "localhost";
	$username = "root"; // Thay đổi theo thông tin đăng nhập của bạn
	$password = ""; // Thay đổi mật khẩu nếu có
	$dbname = "cua_hang_xe_may_nhom3"; // Tên cơ sở dữ liệu của bạn
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Kết nối thất bại: " . $conn->connect_error);
	}

	// Số sản phẩm trên mỗi trang
	$products_per_page = 35;  /*sửa thành 4*/

	// Trang hiện tại
	$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	if ($page < 1)
		$page = 1;


	// Kiểm tra nếu người dùng nhấn nút "Sản phẩm bán chạy"
	$isBestSelling = isset($_GET['bestselling']) && $_GET['bestselling'] == 'true';

	// Kiểm tra nếu người dùng nhấn nút "Sản phẩm mới"
	$isNewProduct = isset($_GET['newproducts']) && $_GET['newproducts'] == 'true';

	// Kiểm tra nếu người dùng nhấn nút "Sản phẩm giảm giá"
	$isDiscounted = isset($_GET['discounted']) && $_GET['discounted'] == 'true';

	// Kiểm tra nếu người dùng nhấn nút "Sắp xếp theo giá"
	$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : '';





	// Kiểm tra nếu có yêu cầu về phân khối
	$cylinder_condition = '';
	if (isset($_GET['cylinder'])) {
		$cylinder = $_GET['cylinder'];

		if ($cylinder === '50') {
			$cylinder_condition = ' WHERE phankhoi < 51';
		} elseif ($cylinder === '125') {
			$cylinder_condition = ' WHERE phankhoi < 125';
		} elseif ($cylinder === '500') {
			$cylinder_condition = ' WHERE phankhoi < 500';
		} elseif ($cylinder === '500_up') {
			$cylinder_condition = ' WHERE phankhoi > 500';
		}
	}

	// Tạo điều kiện truy vấn đếm tổng số sản phẩm
	$sql = "SELECT COUNT(*) AS total FROM thongtinsanpham" . $cylinder_condition;


	$total_result = $conn->query($sql);
	$total_products = $total_result->fetch_assoc()['total'];
	$total_pages = ceil($total_products / $products_per_page);

	// Kiểm tra nếu có từ khóa tìm kiếm
	$search = isset($_GET['search']) ? $_GET['search'] : '';

	// Lấy danh sách sản phẩm theo trang
	$start = ($page - 1) * $products_per_page;
	$sql = "SELECT * FROM thongtinsanpham" . $cylinder_condition;

	// Kiểm tra điều kiện tìm kiếm
	/*if (!empty($search)) {
			  // Nếu đã có điều kiện WHERE khác trước đó
			  if (strpos($sql, 'WHERE') !== false) {
				  $sql .= " AND tensp LIKE ?";
			  } else {
				  $sql .= " WHERE tensp LIKE ?";
			  }
		  }*/

	//thêm điều kiện
	if ($isBestSelling) {
		$sql .= " WHERE daban > 70";
	} elseif ($isNewProduct) {
		$sql .= " WHERE namsx = 2024"; // Lọc sản phẩm mới theo năm 2024
	} elseif ($isDiscounted) {
		$sql .= " WHERE masp % 3 = 1"; // Lọc các sản phẩm có mã là số lẻ
	}


	// Thêm điều kiện sắp xếp theo giá
	if ($sortOrder == 'asc') {
		$sql .= " ORDER BY gia ASC"; // Sắp xếp giá từ thấp đến cao
	} elseif ($sortOrder == 'desc') {
		$sql .= " ORDER BY gia DESC"; // Sắp xếp giá từ cao đến thấp
	}

	//giới hạn số lượng sản phẩm trên mỗi trang
	$sql .= " LIMIT $start, $products_per_page";
	$result = $conn->query($sql);


	// Chuẩn bị câu truy vấn (Prepared Statement)
	/*$stmt = $conn->prepare($sql);

		  // Gán giá trị tham số tìm kiếm nếu có
		  if (!empty($search)) {
			  $search_param = "%" . $search . "%";
			  $stmt->bind_param("sii", $search_param, $start, $products_per_page);
		  } else {
			  $stmt->bind_param("ii", $start, $products_per_page);
		  }

		  // Thực thi câu truy vấn
		  $stmt->execute();
		  $result = $stmt->get_result();*/



	/*code php lấy ra số trang hiện tại và tổng trang*/

	$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	if ($currentPage < 1)
		$currentPage = 1;

	// Kết nối tới cơ sở dữ liệu và lấy tổng sản phẩm
	$sql = "SELECT COUNT(*) AS total FROM thongtinsanpham";
	$result1 = $conn->query($sql);
	$row = $result1->fetch_assoc();
	$totalItems = $row['total'];

	$itemsPerPage = 8;
	$totalPages = ceil($totalItems / $itemsPerPage);




	/* code lấy ra số lượng sản phẩm trong giỏ hàng */

	// Kiểm tra xem người dùng đã đăng nhập hay chưa
	if (isset($_SESSION['user']) && isset($_SESSION['user']['makh'])) {
		$makh2 = $_SESSION['user']['makh'];

		// Lấy tổng số sản phẩm từ bảng giohang cho người dùng đã đăng nhập
		$sql5 = "SELECT COUNT(*) AS total_products FROM giohang WHERE giohang.makh = $makh2";
		$result5 = $conn->query($sql5);

		if ($result5 && $result5->num_rows > 0) {
			$row = $result5->fetch_assoc();
			$total_products = $row['total_products']; // Gán tổng số sản phẩm vào biến
		} else {
			$total_products = 0; // Nếu không có sản phẩm nào
		}
	} else {
		// Nếu không có session thì hiển thị 0
		$total_products = 0;
	}
	?>




	<!-- Header -->
	<div class="header">
		<!-- Headder1 -->
		<div class="header_row1">
			<span>Trang chủ AHC Motorbike</span>
			<div class="nav">
				<a href="ChuongTrinh.php"><i class="fa-solid fa-house edit_icon "></i>Trang Chủ</a>
				<a href="DangKy.php"><i class="fa-regular fa-registered edit_icon"></i>Đăng Ký</a>
				<a href="DangNhap.php"><i class="fa-solid fa-right-to-bracket edit_icon"></i>Đăng Nhập</a>
				<a href="LienHe.php"><i class="fa-regular fa-address-book edit_icon"></i>Liên Hệ</a>
				<a onclick="user_click()" href="#"><i class="fa-regular fa-user edit_icon btn_user"></i>Tài Khoản</a>
				<div class="arrow_down"></div>
				<div class="user_info">

					<h1>ACCOUNT</h1>
					<i class="fa-regular fa-user"></i>
					<?php
					// Kiểm tra nếu session tồn tại
					if (isset($_SESSION['user']) && isset($_SESSION['user']['makh'])):
						$user = $_SESSION['user']; // Giả sử session lưu trữ thông tin người dùng trong $_SESSION['user']
						?>
						<p><strong>Tên tài khoản:</strong> <?php echo htmlspecialchars($user['tentk']); ?></p>
						<p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
						<p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['sdt']); ?></p>
						<p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['diachi']); ?></p>
						<form action="Logout.php" method="POST">
							<button class="logout" type="submit">Đăng xuất</button>
						</form>
					<?php else: ?>
						<!-- Thông báo khi người dùng chưa đăng nhập -->
						<p>Bạn chưa đăng nhập !</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<!-- Header2 -->
		<div class="header_row2">
			<div class="logo">
				<img src="assets/img/LogoAHC.png" alt="AHC Motobike" width="400" , height="400">
				<h1 style="font-style: italic;">AHC</h1>
			</div>
			<!-- Search and Cart -->
			<div class="search_bar">
				<form action="" method="get" style="display: inline;">
					<input style="width: 850px;" type="text" name="search" placeholder="Nhập để tìm kiếm"
						value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>">
					<button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
				</form>
			</div>

			<div class="cart_icon">
				<i class="fa-solid fa-cart-shopping"></i>
				<span>(<?php echo $total_products; ?>)</span>
			</div>
		</div>

	</div>



	<!-- Categories and Products -->
	<div class="container">
		<aside class="sidebar">
			<h3>
				<i class="fa-solid fa-bars"></i>
				Danh mục
			</h3>
			<ul>
				<li><a href="?cylinder=50">Xe dưới 50cc</a></li>
				<li><a href="?cylinder=125">Xe dưới 125cc</a></li>
				<li><a href="?cylinder=500">Xe dưới 500cc</a></li>
				<li><a href="?cylinder=500_up">Xe trên 500cc </a></li>
			</ul>
		</aside>

		<!-- Product Section -->
		<section class="product_section">
			<div class="filter">
				<div class="option">
					<a href="#prd_top"> <!-- di chuyển trang đến vị trí thẻ prd_top -->
						<form action="" method="get" style="display: inline;">
							<!-- phương thức get lấy tất cả sản phẩm -->
							<button type="submit" class="btn-filter">Tất cả SP</button>
						</form>
					</a>
					<span class="column">|</span>
					<form action="" method="get" style="display: inline;"> <!-- get lấy sản phẩm có lượt bán > 50 -->
						<input type="hidden" name="newproducts" value="true">
						<button type="submit" class="btn_filter">SP mới</button>
					</form>

					<span class="column">|</span>

					<form action="" method="get" style="display: inline;"> <!-- get lấy sản phẩm có lượt bán > 50 -->
						<input type="hidden" name="bestselling" value="true">
						<button type="submit" class="btn-filter">SP bán chạy</button>
					</form>

					<span class="column">|</span>
					<form action="" method="get" style="display: inline;"> <!-- get lấy sản phẩm có lượt bán > 50 -->
						<input type="hidden" name="discounted" value="true">
						<button type="submit" class="btn_filter">SP giảm giá</button>
					</form>
					<form action="" method="get" style="display: inline;">
						<select name="sort" onchange="this.form.submit();">
							<option value="" disabled selected>Sắp xếp theo giá</option>
							<option value="asc" <?= ($sortOrder == 'asc') ? 'selected' : ''; ?>>Giá từ thấp đến cao
							</option>
							<option value="desc" <?= ($sortOrder == 'desc') ? 'selected' : ''; ?>>Giá từ cao đến thấp
							</option>
						</select>
						<?php if ($isBestSelling): ?>
							<input type="hidden" name="bestselling" value="true">
						<?php endif; ?>
						<?php if ($isNewProduct): ?>
							<input type="hidden" name="newproducts" value="true">
						<?php endif; ?>
						<?php if ($page): ?>
							<input type="hidden" name="page" value="<?= $page; ?>">
						<?php endif; ?>
					</form>

				</div>
				<div class="numerical_page">
					<p class="present_page"><?php echo $currentPage; ?></p>
					<p>/</p>
					<p class="sum_page"><?php echo $total_pages; ?></p>

				</div>
			</div>

			<!-- thẻ hr để tạo đường ngăn cách trên với dưới -->
			<hr class="divider">


			<!-- trang các sản phẩm -->
			<div class="product_home">
				<!-- Banner của trang web -->
				<div class="banner">
					<div class="slideshow-container">

						<!-- Các hình ảnh cho slideshow -->
						<div class="mySlides fade">
							<img src="assets/img/banner1.jpg" style="width:100%; height: 430px;  ">
						</div>

						<div class="mySlides fade">
							<img src="assets/img/banner2.jpg" style="width:100%; height: 430px;  ">
						</div>

						<div class="mySlides fade">
							<img src="assets/img/banner3.jpg" style="width:100%; height: 430px; ">
						</div>


						<!-- Dấu chấm để chuyển đổi hình ảnh thủ công -->
						<div style="text-align:center">
							<span class="dot"></span>
							<span class="dot"></span>
							<span class="dot"></span>
						</div>
					</div>
					<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
					<a class="next" onclick="plusSlides(1)">&#10095;</a>
				</div>


				<!-- danh sách sản phẩm -->
				<p id="prd_top">SẢN PHẨM</p>
				<div class="divider1"></div>


				<!-- Trang hiển thị các sản phẩm -->
				<div class="products_list">
					<?php if ($result->num_rows > 0): ?>
						<?php
						$counter = 0; // Đếm sản phẩm để chia hàng
						while ($product = $result->fetch_assoc()):
							?>
							<div class="product"
								onclick="showProductDetails('<?= $product['anhsp']; ?>', '<?= $product['tensp']; ?>', '<?= $product['namsx']; ?>', '<?= $product['noisx']; ?>', '<?= $product['kichthuoc']; ?>', '<?= $product['phankhoi']; ?>', '<?= $product['trongluong']; ?>', '<?= $product['dungtichxang']; ?>', '<?= $product['dongco']; ?>', '<?= $product['tocdo']; ?>', '<?= $product['baohanh']; ?>', '<?= $product['mausac']; ?>', '<?= number_format($product['gia'], 0, ',', '.'); ?> đ', '<?= $product['mota']; ?>', '<?= $product['masp']; ?>')">

								<!-- Nhãn giảm giá cho sản phẩm có mã từ 1 đến 10 -->
								<?php if ($product['masp'] % 3 == 1): ?>
									<div class="discount-label">Giảm 10%</div>
								<?php endif; ?>

								<a class="link_product" href="">
									<img src="<?= $product['anhsp']; ?>" alt="<?= $product['tensp']; ?>">
									<h4 class="infor_product"><?= $product['tensp']; ?></h4>

									<div class="two_price">
										<!-- Chỉ hiển thị giá cũ khi masp chia hết cho 3 -->
										<?php if ($product['masp'] % 3 == 1): ?>
											<p class="old_price">
												<?= number_format(($product['gia'] + $product['gia'] * 0.1), 0, ',', '.'); ?> đ</p>
										<?php else: ?>
											<p style="color: #fff;">no</p>
										<?php endif; ?>
										<p class="price infor_product"><?= number_format($product['gia'], 0, ',', '.'); ?> đ</p>
									</div>

									<p class="infor_product">Đã bán: <?= $product['daban']; ?></p>
									<p class="infor_product"><strong><?= $product['noisx']; ?></strong></p>
								</a>
							</div>
							<?php
							$counter++;
							if ($counter % 6/*sửa thành 4*/ == 0)
								echo '<div class="clear"></div>'; // Chèn dòng mới sau mỗi 4 sản phẩm
							?>
						<?php endwhile; ?>
						<div class="clear"></div> <!-- Xóa float sau các thẻ cuối cùng -->
					<?php else: ?>
						<p>Không có sản phẩm nào</p>
					<?php endif; ?>
				</div>
			</div>


			<!-- Trang chi tiết sản phẩm -->
			<div class="detail_page">
				<h1>THÔNG TIN CHI TIẾT SẢN PHẨM</h1>
				<!-- ngăn cách bằng đường kẻ ngang -->
				<div class="divider4"></div>
				<div class="detail_info">
					<img id="anhsp" src="" alt="Ảnh sản phẩm">
					<div class="product_info">
						<p id="tensp"></p>
						<p id="namsx"></p>
						<p id="noisx"></p>
						<p id="kichthuoc"></p>
						<p id="phankhoi"></p>
						<p id="trongluong"></p>
						<p id="dungtichxang"></p>
						<p id="dongco"></p>
						<p id="tocdo"></p>
						<p id="baohanh"></p>
						<p id="mausac"></p>
						<p id="mota"></p>
					</div>
				</div>
				<!-- thao tác chọn tiêu chí đặt hàng -->
				<div class="buy_info">
					<!-- ngăn cách bằng đường kẻ ngang -->
					<div class="divider4"></div>
					<form id="myForm" method="POST" action="ThemVaoGioHang.php" onsubmit="submitForm(event)">
						<!-- onsubmit="submitForm(event)" : //ngăn hành động tải lại trang-->
						<input class="hidden_masp" id="masp" name="masp" type="number"
							style="width: 150px;margin-left: 20%; background-color: transparent;  border: none; "
							readonly>
						<div class="one_info product_price">
							<p class="buy_label">Giá: </p>
							<p id="gia" class="buy_price"></p>
						</div>
						<div class="one_info product_color">
							<p class="buy_label">Màu sắc: </p>
							<div onclick="red_cl()" class="box_color red_color"></div>
							<div onclick="black_cl()" class="box_color black_color"></div>
							<div onclick="white_cl()" class="box_color white_color"></div>
							<input id="text_of_color"
								style="border-radius: 5px; width: 60px; margin-left: 5px; padding:5px 10px;"
								name="mauchon" type="text" placeholde="màu" readonly>
						</div>
						<div class="one_info quantity">
							<p class="buy_label">Số lượng muốn mua</p>
							<input id="soluong_mua" type="number" name="soluong" min="1" max="100">
						</div>
						<div class="one_info add_cart">
							<button type="submit" id="btn_add" class="buy_label">Thêm vào giỏ hàng</button>
							<button onclick="like()" class="btn_dislike">
								<i class="fa-regular fa-heart icon_dislike"></i>
								<i class="fa-solid fa-heart icon_like"></i>
							</button>
						</div>
					</form>
					<form method="POST" action="ChuongTrinh.php">
						<button type="submit" class="btn_back">Trở về trang chủ</button>
					</form>
				</div>
			</div>


			<!-- Trang hiển thị sản phẩm trong giỏ hàng -->
			<div class="cart_page">
				<?php
				if (isset($_SESSION['user']) && isset($_SESSION['user']['makh'])) {
					$makh1 = $_SESSION['user']['makh'];
					$sql6 = "SELECT giohang.magiohang, thongtinsanpham.anhsp, thongtinsanpham.tensp, giohang.masp, giohang.mauchon, giohang.soluong, thongtinsanpham.gia
			                 FROM giohang
			                 JOIN thongtinsanpham ON giohang.masp = thongtinsanpham.masp
			                 JOIN dangky ON dangky.makh = giohang.makh
			                 WHERE giohang.makh = $makh1";

					$result6 = $conn->query($sql6);
					if ($result6->num_rows > 0):
						while ($giohang = $result6->fetch_assoc()):
							$magiohang = $giohang['magiohang'];
							?>
							<div class="cart_info" data-id="<?= $magiohang; ?>">
								<div class="cart_img">
									<img src="<?= $giohang['anhsp'] ?>" alt="Ảnh sản phẩm">
								</div>
								<div class="combo_info">
									<p class="label_in_cart"><?= $giohang['tensp']; ?></p>
									<div class="group_color">
										<div class="cart_color">
											<p class="label_in_cart">Màu: </p>
											<p><?= $giohang['mauchon'] ?></p>
										</div>
										<div class="increase_reduce">
											<button onclick="decreaseValue(<?= $magiohang ?>)" class="reduce">-</button>
											<input id="quantity<?= $magiohang ?>" type="number" name="cart_soluong"
												value="<?= $giohang['soluong'] ?>" min="1" max="100">
											<button onclick="increaseValue(<?= $magiohang ?>)" class="btn_increase">+</button>
										</div>
									</div>
								</div>
								<p class="price_in_cart">Giá: <?= number_format($giohang['gia'], 0, ',', '.'); ?>đ</p>
								<input type="checkbox" name="select_buy" class="select_buy" data-id="<?= $magiohang; ?>"
									data-anhsp="<?= $giohang['anhsp']; ?>" data-tensp="<?= $giohang['tensp']; ?>"
									data-mauchon="<?= $giohang['mauchon']; ?>" data-soluong="<?= $giohang['soluong']; ?>"
									data-gia="<?= $giohang['gia']; ?>">
								<form method="post" action="XoaGioHang.php">
									<input type="hidden" name="delete_cart_item" value="<?= $magiohang; ?>">
									<button type="button" class="btn_delete" data-id="<?= $magiohang ?>">Xóa</button>
								</form>
							</div>
						<?php endwhile; ?>
						<div class="button_in_cart">
							<button class="btn_buy" data-id="<?= $magiohang ?>">Mua ngay</button>
							<form action="ChuongTrinh.php">
								<button class="btn_back1">Quay Lại</button>
							</form>
						</div>
					<?php endif;
				} else { ?>
					<div class="no_products">Bạn chưa đăng nhập!</div>
				<?php } ?>
			</div>


			<!-- Thông tin đơn hàng -->
			<div class="book_info">
				<h1>THÔNG TIN ĐẶT HÀNG</h1>
				<div class="send_receive">

					<!-- thông tin người nhận -->
					<div class="order_info receive">
						<p class="book_title">Thông tin người nhận</p>
						<div class="divider3"></div>
						<ul>
							<?php
							// Kiểm tra xem người dùng đã đăng nhập hay chưa
							if (isset($_SESSION['user']) && isset($_SESSION['user']['makh'])) {
								$makh = $_SESSION['user']['makh'];
								// Truy vấn để lấy thông tin người nhận từ bảng 'dangky'
								$sql = "SELECT tentk, diachi, sdt, email FROM dangky WHERE makh = ?";

								// Chuẩn bị truy vấn để tránh lỗi SQL Injection
								$stmt = $conn->prepare($sql);
								$stmt->bind_param("i", $makh);  // 'i' cho kiểu dữ liệu số nguyên (integer)
								$stmt->execute();
								$result = $stmt->get_result();

								// Hiển thị thông tin nếu có dữ liệu
								if ($result->num_rows > 0) {
									$row = $result->fetch_assoc();
									echo '<li><label for="tentk1">@ Tên người nhận:</label>';
									echo '<input type="text" id="tentk1" name="tentk1" value="' . htmlspecialchars($row['tentk']) . '" required></li>';

									echo '<li><label for="diachi1">@ Địa chỉ:</label>';
									echo '<input type="text" id="diachi1" name="diachi1" value="' . htmlspecialchars($row['diachi']) . '" required></li>';

									echo '<li><label for="sdt1">@ Số điện thoại:</label>';
									echo '<input type="text" id="sdt1" name="sdt1" value="' . htmlspecialchars($row['sdt']) . '" required></li>';

									echo '<li><label for="email1">@ Email:</label>';
									echo '<input type="text" id="email1" name="email1" value="' . htmlspecialchars($row['email']) . '" required></li>';
								} else {
									echo "<li>Không tìm thấy thông tin người nhận.</li>";
								}
								$stmt->close();
							} else {
								echo "<li>Bạn chưa đăng nhập!</li>";
							}
							?>
						</ul>
					</div>

					<!-- thông tin người nhận code moi-->

					<!-- <div class="order_info receive">
						<p class="book_title">Thông tin người nhận</p>
						<div class="divider3"></div>
						<ul>
						<?php
						// Kiểm tra xem người dùng đã đăng nhập hay chưa
						if (isset($_SESSION['user']) && isset($_SESSION['user']['makh'])) {
							$makh = $_SESSION['user']['makh'];
							// Truy vấn để lấy thông tin người nhận từ bảng 'dangky'
							$sql = "SELECT tentk, diachi, sdt, email FROM dangky WHERE makh = ?";

							// Chuẩn bị truy vấn để tránh lỗi SQL Injection
							$stmt = $conn->prepare($sql);
							$stmt->bind_param("i", $makh);  // 'i' cho kiểu dữ liệu số nguyên (integer)
							$stmt->execute();
							$result = $stmt->get_result();

							// Hiển thị thông tin nếu có dữ liệu
							if ($result->num_rows > 0) {
								$row = $result->fetch_assoc();
								echo '<li><label for="tentk1">@ Tên người nhận:</label>';
								echo '<input type="text" pattern="^[a-zA-ZÀ-ỹà-ỹ\s]+$"
              title="Họ tên chỉ bao gồm chữ cái (có thể có dấu) và khoảng trắng, không được để trống." 
              class="thongtinnguoinhan" id="tentk1" name="tentk1" 
              value="' . htmlspecialchars($row['tentk']) . '" required>';


								echo '<li><label for="diachi1">@ Địa chỉ:</label>';
								echo '<input type="text"  class = "thongtinnguoinhan" id="diachi1" name="diachi1" value="' . htmlspecialchars($row['diachi']) . '" required></li>';

								echo '<li><label for="sdt1">@ Số điện thoại:</label>';
								echo '<input type="text"  class = "thongtinnguoinhan" id="sdt1" name="sdt1" value="' . htmlspecialchars($row['sdt']) . '" required></li>';

								echo '<li><label for="email1">@ Email:</label>';
								echo '<input type="text"  class = "thongtinnguoinhan" id="email1" name="email1" value="' . htmlspecialchars($row['email']) . '" required></li>';
							} else {
								echo "<li>Không tìm thấy thông tin người nhận.</li>";
							}
							$stmt->close();
						} else {
							echo "<li>Bạn chưa đăng nhập!</li>";
						}
						?>
						</ul>
					</div> -->
					<!-- <p>" . htmlspecialchars($row['tentk']) . "</p> -->
					<!-- thẻ ngăn -->
					<div class="divider2"></div>

					<!-- thông tin đơn hàng -->
					<div class="order_info send">
						<p class="book_title">Thông tin đơn hàng</p>
						<div class="divider3"></div>
						<div class="list_form_oder_info" id="list_form_oder_info">

							<!-- thông tin 1 đơn hàng -->
							<div class="form_oder_info">
								<div class="img_in_order">
									<img src="assets/img/ab160.png" alt="Ảnh sản phẩm">
								</div>
								<ul>
									<li>
										<p> Tên sản phẩm: </p>
										<p>Airblade 160</p>
									</li>
									<li>
										<p> Màu sắc: </p>
										<p>Đen</p>
									</li>
									<li>
										<p>Số lượng: </p>
										<p>3</p>
									</li>
									<li>
										<p>Tổng Giá: </p>
										<p>126.000.000 đ</p>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</div>

				<!-- Phương thức thanh toán -->
				<div class="pay_method">
					<div class="title_method">
						<i class="fa-solid fa-dollar-sign"></i>
						<p class="book_title">Chọn phương thức thanh toán:</p>
					</div>

					<div>
						<input type="radio" id="creditCard" name="paymentMethod" value="Thẻ tín dụng" required>
						<label for="creditCard">Thẻ tín dụng</label>
						<i class="fa-solid fa-credit-card"></i>
					</div>

					<div>
						<input type="radio" id="paypal" name="paymentMethod" value="PayPal">
						<label for="paypal">PayPal</label>
						<i class="fa-brands fa-paypal"></i>
					</div>

					<div>
						<input type="radio" id="bankTransfer" name="paymentMethod" value="Chuyển khoản ngân hàng">
						<label for="bankTransfer">Chuyển khoản ngân hàng</label>
						<i class="fa-solid fa-building-columns"></i>
					</div>

					<div>
						<input type="radio" id="cod" name="paymentMethod" value="Thanh toán khi nhận hàng">
						<label for="cod">Thanh toán khi nhận hàng</label>
						<i class="fa-solid fa-handshake-simple"></i>
					</div>
				</div>
				<div class="pay_money">
					<p class="book_title">TỔNG THÀNH TIỀN: </p>
					<p class="sum_all_price"></p>
				</div>
				<div class="btn_book_cancel">
					<button id="btn-order" class="btn_book">Đặt hàng ngay</button>
					<button class="btn_cancel">Quay Lại</button>
				</div>
			</div>


			<!-- Nút điều hướng trang trái phải -->
			<div class="turn_page">
				<?php if ($page > 1): ?>
					<form action="" method="get" style="display: inline;">
						<input type="hidden" name="page" value="<?= $page - 1; ?>">

						<?php if ($isBestSelling): ?> <!-- sản phẩm bán chạy -->
							<input type="hidden" name="bestselling" value="true">
						<?php endif; ?>
						<?php if ($isNewProduct): ?> <!-- sản phẩm mới -->
							<input type="hidden" name="newproducts" value="true">
						<?php endif; ?>
						<?php if ($isDiscounted): ?>
							<input type="hidden" name="discounted" value="true">
						<?php endif; ?>
						<?php if ($sortOrder): ?>
							<input type="hidden" name="sort" value="<?= $sortOrder; ?>">
						<?php endif; ?>


						<button class="btn_left" type="submit"><i class="fa-solid fa-chevron-left"></i></button>
					</form>
				<?php else: ?>
					<button class="disabled" disabled><i class="fa-solid fa-chevron-left"></i></button>
					<!-- ẩn nút trái khi đầu trang -->
				<?php endif; ?>

				<?php if ($page < $total_pages): ?>
					<form action="" method="get" style="display: inline;">
						<input type="hidden" name="page" value="<?= $page + 1; ?>">

						<?php if ($isBestSelling): ?> <!-- sản phẩm bán chạy -->
							<input type="hidden" name="bestselling" value="true">
						<?php endif; ?>
						<?php if ($isNewProduct): ?> <!-- sản phẩm mới -->
							<input type="hidden" name="newproducts" value="true">
						<?php endif; ?>
						<?php if ($isDiscounted): ?>
							<input type="hidden" name="discounted" value="true">
						<?php endif; ?>
						<?php if ($sortOrder): ?>
							<input type="hidden" name="sort" value="<?= $sortOrder; ?>">
						<?php endif; ?>

						<button class="btn_right" type="submit"> <i class="fa-solid fa-angle-right"></i></button>
					</form>
				<?php else: ?>
					<button class="disabled" disabled><i class="fa-solid fa-angle-right"></i></button>
					<!-- ẩn nút phải khi cuối trang -->
				<?php endif; ?>
			</div>
			<?php
			// Đóng kết nối cơ sở dữ liệu
			$conn->close();
			?>


			<!-- Bảng thông báo đặt hàng thành công -->
			<div class="overlay" id="overlay"></div>
			<div class="modal" id="modal">
				<p>Đặt hàng thành công!</p>
				<button class="btn-close" id="close-btn">Đóng</button>
			</div>


			<!-- Bảng thông báo đặt thêm vào giỏ hàng thành công -->
			<div class="overlay2" id="overlay2"></div>
			<div class="modal2" id="modal2">
				<p>Sản phẩm đã được thêm vào giỏ hàng</p>
				<button class="btn-close2" id="close2-btn">Đóng</button>
			</div>


			<!-- Bảng thông báo chưa chọn màu và số lượng -->
			<div class="overlay3" id="overlay3"></div>
			<div class="modal3" id="modal3">
				<p>Bạn chưa chọn màu hoặc số lượng</p>
				<button class="btn-close3" id="close3-btn">Đóng</button>
			</div>

		</section>
	</div>


	<!-- Footer -->
	<div class="footer">
		<div class="footer_info">
			<p>@ Địa chỉ: 218 Lĩnh Nam, Hoàng Mai, Hà Nội</p>
			<p>Số điện thoại: 0369872935</p>
		</div>
		<div class="team">
			<h3>@ Thành viên của AHC Motobike : </h3>
			<ul>
				<li> Vũ Thanh Hùng - 21/12/2002</li>
				<li> Nguyễn Anh Chiến - 28/03/2003</li>
				<li> Nguyễn Hải Anh - 12/06/2003</li>
			</ul>
		</div>
	</div>


	<!-- code java script sử lý -->
	<script>
		//Lấy các thẻ tương ứng cần thao tác
		const dssp = document.querySelector('.product_home');
		const chitiet = document.querySelector('.detail_page');
		const traiphai = document.querySelector('.turn_page');
		const giohang = document.querySelector('.cart_icon');
		const tranggiohang = document.querySelector('.cart_page');
		const motsanpham = document.querySelector('.cart_info');
		const dathang = document.querySelector('.book_info');
		const xoa = document.querySelector('.btn_delete');
		const muangay = document.querySelector('.btn_buy');
		const dathangngay = document.querySelector('.btn_book');
		const huy = document.querySelector('.btn_cancel');
		const linksp = document.querySelectorAll('.product a');

		//gán sự kiện click cho mỗi thẻ a
		// Duyệt qua các thẻ a
		linksp.forEach(link => {
			//lắng nghe sự kiện click
			link.addEventListener('click', function (event) {
				//ngăn chặn chuyển trang nếu a có href
				event.preventDefault();
				//ẩn trang danh sách và thanh điều hướng
				dssp.style.display = 'none';
				traiphai.style.display = 'none';
				//hiện trang chi tiết
				chitiet.style.display = 'block';
			});
		});
		giohang.addEventListener("click", function (event) {
			event.preventDefault();
			dssp.style.display = 'none';
			traiphai.style.display = 'none';
			tranggiohang.style.display = 'block';
			chitiet.style.display = 'none';
			dathang.style.display = 'none';
		});

		// Xử Lý nút xóa cho từng sản phẩm
		document.querySelectorAll('.btn_delete').forEach(button => {
			button.addEventListener('click', function () {
				const cartItemId = this.getAttribute('data-id'); // Lấy ID của sản phẩm trong giỏ

				// Gửi yêu cầu AJAX để xóa sản phẩm
				fetch('XoaGioHang.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: `delete_cart_item=${cartItemId}`
				})
					.then(response => response.text())
					.then(data => {
						if (data.trim() === "success") { // Kiểm tra nếu xóa thành công
							// Xóa thẻ div của sản phẩm khỏi DOM
							document.querySelector(`.cart_info[data-id="${cartItemId}"]`).remove();
						} else {
							alert("Xóa sản phẩm thất bại!"); // Thông báo nếu xóa thất bại
						}
					})
					.catch(error => console.error('Lỗi:', error));
			});
		});

		// Xử lý nút "Mua ngay" cho từng sản phẩm
		document.querySelectorAll('.btn_buy').forEach(button => {
			button.addEventListener("click", function (event) {
				event.preventDefault();

				// Kiểm tra xem có checkbox nào được chọn không
				const selectedItems = document.querySelectorAll('.cart_info .select_buy:checked');
				const thongbao = "";
				if (selectedItems.length > 0) {
					// Nếu có ít nhất một ô checkbox được chọn
					const productId = this.getAttribute('data-id');

					// Ẩn các phần tử khi nhấn "Mua ngay"
					document.querySelector('.cart_page').style.display = 'none';
					document.querySelector('.book_info').style.display = 'block';

					// Thực hiện lệnh để đặt hàng hoặc chuyển sản phẩm sang trang đặt hàng
					fetch(`dathang.php?id=${productId}`, {
						method: 'GET'
					}).then(response => response.text())
						.then(data => console.log(data)) // Xử lý phản hồi (nếu cần)
						.catch(error => console.error('Error:', error));
				} else {
					// Hiển thị cảnh báo nếu không có sản phẩm nào được chọn
					thongbao = "Bạn chưa chọn sản phẩm!	"
				}
			});
		});

		//xử lý nút mua ngay trong giỏ hàng tiếp theo
		document.querySelector('.btn_buy').addEventListener('click', function () {
			// Tạo mảng để lưu thông tin sản phẩm đã chọn
			var selectedProducts = [];
			var totalAmount = 0; // Biến để lưu tổng giá của tất cả sản phẩm
			// Lặp qua tất cả các checkbox được chọn
			document.querySelectorAll('.select_buy:checked').forEach(function (checkbox) {
				var product = {
					id: checkbox.getAttribute('data-id'),
					anhsp: checkbox.getAttribute('data-anhsp'),
					tensp: checkbox.getAttribute('data-tensp'),
					mauchon: checkbox.getAttribute('data-mauchon'),
					soluong: checkbox.getAttribute('data-soluong'),
					gia: checkbox.getAttribute('data-gia')
				};
				selectedProducts.push(product);
				var productTotal = parseInt(product.gia) * parseInt(product.soluong);
				totalAmount += productTotal;
			});
			if (selectedProducts.length > 0) {
				// Hiển thị thông tin sản phẩm vào thẻ div
				var orderInfoDiv = document.getElementById('list_form_oder_info');
				orderInfoDiv.innerHTML = ''; // Xóa dữ liệu cũ nếu có

				selectedProducts.forEach(function (product) {
					var productHtml = `
					<div class="form_oder_info">
						<div class="img_in_order">
							<img src="${product.anhsp}" alt="Ảnh sản phẩm">
						</div>
						<ul>
							<li>
								<p>Tên sản phẩm: </p>
								<p>${product.tensp}</p>
							</li>
							<li>
								<p>Màu sắc: </p>
								<p>${product.mauchon}</p>
							</li>
							<li>
								<p>Số lượng: </p>
								<p>${product.soluong}</p>
							</li>
							<li>
								<p>Tổng Giá: </p>
								<p>${(parseInt(product.gia) * parseInt(product.soluong)).toLocaleString('vi-VN')} đ</p>
							</li>
						</ul>
					</div>
					`;
					orderInfoDiv.innerHTML += productHtml;
				});

				// Hiển thị tổng giá trị của tất cả sản phẩm vào phần tử .sum_all_price
				document.querySelector('.sum_all_price').textContent = totalAmount.toLocaleString('vi-VN') + ' đ';


				// Xử lý khi nhấn nút "Đặt hàng ngay"
				document.getElementById('btn-order').addEventListener('click', function () {
					// Kiểm tra xem đã chọn phương thức thanh toán chưa
					const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
					const tentk1 = document.getElementById('tentk1');
					const diachi1 = document.getElementById('diachi1');
					const sdt1 = document.getElementById('sdt1');
					const email1 = document.getElementById('email1');
					if (!paymentMethod) {
						alert('Bạn chưa chọn phương thức thanh toán!');
						return;
					}
					// Gửi dữ liệu qua AJAX đến PHP để lưu vào database
					fetch('place_order.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({
							tentk1: tentk1.value,
							diachi1: diachi1.value,
							sdt1: sdt1.value,
							email1: email1.value,
							products: selectedProducts,
							totalAmount: totalAmount,
							paymentMethod: paymentMethod.value
						})
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								document.getElementById('modal').style.display = 'block';
								document.getElementById('overlay').style.display = 'block';
							} else {
								alert('Có lỗi xảy ra khi đặt hàng: ' + data.message);
							}
						})
						.catch(error => console.error('Error:', error));
				});
			} else {
				alert('Bạn chưa chọn sản phẩm!');
			}
		});

		// Hiển thị modal khi nhấn nút "Đặt hàng"
		const modal = document.getElementById('modal');
		const overlay = document.getElementById('overlay');
		const closeButton = document.getElementById('close-btn');
		// Đóng modal khi nhấn nút "Đóng"
		closeButton.addEventListener('click', function () {
			modal.style.display = 'none';
			overlay.style.display = 'none';
		});
		// Đóng modal khi nhấn ra ngoài khu vực modal
		overlay.addEventListener('click', function () {
			modal.style.display = 'none';
			overlay.style.display = 'none';
		});


		//Sử lý nút hủy
		huy.addEventListener("click", function (event) {
			event.preventDefault();
			dssp.style.display = 'none';
			traiphai.style.display = 'none';
			tranggiohang.style.display = 'block';
			dathang.style = 'none';
		});


		// Phần js của banner
		let slideIndex = 0;
		showSlides();
		function showSlides() {
			let i;
			let slides = document.getElementsByClassName("mySlides");
			let dots = document.getElementsByClassName("dot");
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";  // Ẩn tất cả các slide
			}
			slideIndex++;
			if (slideIndex > slides.length) { slideIndex = 1 }  // Khi đến slide cuối, quay lại slide đầu tiên
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" active", "");  // Loại bỏ active khỏi tất cả các chấm
			}
			slides[slideIndex - 1].style.display = "block";  // Hiển thị slide hiện tại
			dots[slideIndex - 1].className += " active";     // Thêm class active cho chấm tương ứng
			setTimeout(showSlides, 3000); // Chuyển đổi slide sau mỗi 3 giây
		}
		function plusSlides(n) {
			slideIndex += n;
			if (slideIndex > slides.length) { slideIndex = 1; }
			if (slideIndex < 1) { slideIndex = slides.length; }
			showSlides();
		}


		// Hàm giảm số lượng
		function decreaseValue(counter) {
			var quantityInput = document.getElementById('quantity' + counter);
			var value = parseInt(quantityInput.value, 10);
			value = isNaN(value) ? 1 : value;
			value = value > 1 ? value - 1 : 1;
			quantityInput.value = value;
		}

		// Hàm tăng số lượng
		function increaseValue(counter) {
			var quantityInput = document.getElementById('quantity' + counter);
			var value = parseInt(quantityInput.value, 10);
			value = isNaN(value) ? 1 : value;
			value = value < 100 ? value + 1 : 100;
			quantityInput.value = value;
		}


		//nút tài khoản trên header
		function user_click() {
			const thongtinkh = document.querySelector(".user_info");
			// Kiểm tra trạng thái hiện tại để hiển thị hoặc ẩn
			if (thongtinkh.style.display === "none" || thongtinkh.style.display === "") {
				thongtinkh.style.display = "flex"; // Hiển thị thẻ div
			} else {
				thongtinkh.style.display = "none"; // Ẩn thẻ div
			}
			// Ngăn sự kiện click trên nút không kích hoạt sự kiện click bên ngoài
			event.stopPropagation();
		}


		//sự kiện ấn nút like sản phẩm
		function like() {
			const icon_dislike = document.querySelector(".icon_dislike");
			const icon_like = document.querySelector(".icon_like");
			if (icon_like.style.display === "none") {
				icon_like.style.display = "block";
				icon_dislike.style.display = "none";
			}
			else {
				icon_like.style.display = "none";
				icon_dislike.style.display = "block";
			}
		}


		//Sự kiện ấn vào sản phẩm thì chuyển thông tin sang trang chi tiết
		function showProductDetails(anh, ten, nam, noi, kich, phan, trong, dung, dong, toc, bao, mau, gia, mo, masp) {
			document.getElementById("anhsp").src = anh;
			document.getElementById("anhsp").alt = anh;
			document.getElementById("tensp").innerText = "Tên sản phẩm: " + ten;
			document.getElementById("namsx").innerText = "Năm sản xuất: " + nam;
			document.getElementById("noisx").innerText = "Nơi sản xuất: " + noi;
			document.getElementById("kichthuoc").innerText = "Kích thước: " + kich;
			document.getElementById("phankhoi").innerText = "Phân khối: " + phan + " cc";
			document.getElementById("trongluong").innerText = "Trọng lượng: " + trong + " kg";
			document.getElementById("dungtichxang").innerText = "Dung tích xăng: " + dung + " lit";
			document.getElementById("dongco").innerText = "Động cơ: " + dong;
			document.getElementById("tocdo").innerText = "Tốc độ: " + toc + " km/h";
			document.getElementById("baohanh").innerText = "Bảo hành: " + bao;
			document.getElementById("mausac").innerText = "Màu sắc: " + mau;
			document.getElementById("gia").innerText = gia;
			document.getElementById("mota").innerText = "Mô tả: " + mo;
			document.getElementById("masp").value = masp;

			// Hiển thị thẻ chi tiết sản phẩm
			document.getElementById("productDetails").style.display = "block";
		}

		//sử lý sự kiện click màu xe
		function red_cl() {
			document.getElementById("text_of_color").value = "Đỏ";
		}
		function black_cl() {
			document.getElementById("text_of_color").value = "Đen";
		}
		function white_cl() {
			document.getElementById("text_of_color").value = "Trắng";
		}


		// Hiển thị modal thêm thành công khi nhấn nút "Thêm vào giỏ hàng"
		const addButton = document.getElementById('btn_add');
		const mauchonField = document.getElementById("text_of_color");
		const soluongField = document.getElementById("soluong_mua");
		const modal2 = document.getElementById('modal2');
		const overlay2 = document.getElementById('overlay2');
		const closeButton2 = document.getElementById('close2-btn');
		const modal3 = document.getElementById('modal3');
		const overlay3 = document.getElementById('overlay3');
		const closeButton3 = document.getElementById('close3-btn');

		addButton.addEventListener('click', function (event) {
			const mauchon = mauchonField.value;
			const soluong = soluongField.value;

			// Kiểm tra nếu màu chọn hoặc số lượng trống
			if (!mauchon || !soluong) {
				event.preventDefault(); // Ngăn chặn hành động mặc định để không gửi form

				// Hiển thị modal thông báo lỗi
				modal3.style.display = 'block';
				overlay3.style.display = 'block';
			} else {
				// Ẩn modal lỗi (nếu có)
				modal3.style.display = 'none';
				overlay3.style.display = 'none';

				// Hiển thị modal xác nhận thêm thành công
				modal2.style.display = 'block';
				overlay2.style.display = 'block';
			}
		});
		// Đóng modal khi nhấn nút "Đóng" trên modal lỗi
		closeButton3.addEventListener('click', function () {
			modal3.style.display = 'none';
			overlay3.style.display = 'none';
		});
		// Đóng modal lỗi khi nhấn ra ngoài khu vực modal
		overlay3.addEventListener('click', function () {
			modal3.style.display = 'none';
			overlay3.style.display = 'none';
		});
		// Đóng modal khi nhấn nút "Đóng" trên modal thành công
		closeButton2.addEventListener('click', function () {
			modal2.style.display = 'none';
			overlay2.style.display = 'none';
		});
		// Đóng modal thành công khi nhấn ra ngoài khu vực modal
		overlay2.addEventListener('click', function () {
			modal2.style.display = 'none';
			overlay2.style.display = 'none';
		});


		//hàm ngăn chặn hành động chuyển trang khi nhấn submit
		function submitForm(event) {
			event.preventDefault(); // Ngăn hành động submit mặc định

			// Tạo FormData để lấy dữ liệu từ form
			const formData = new FormData(document.getElementById("myForm"));

			// Gửi dữ liệu đến server bằng fetch
			fetch('ThemVaoGioHang.php', {
				method: 'POST',
				body: formData
			})
				.then(response => response.text())
				.then(data => {
					document.getElementById('result').innerHTML = data; // Hiển thị phản hồi từ server
				})
				.catch(error => console.error('Lỗi:', error));
		}
	</script>
</body>

</html>

<!-- sửa đoạn -->
<!-- if ($counter % 6/*sửa thành 4*/ == 0) echo '<div class="clear"></div>'; // Chèn dòng mới sau mỗi 4 sản phẩm -->
<!-- $products_per_page = 35;  /*sửa thành 4*/ -->
<!-- width: 15%; /*sửa thành 23*/ -->