<!-- code sử lý thêm vào giỏ hàng database -->
	<?php
		

		session_start();
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cua_hang_xe_may_nhom3";

		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Kết nối thất bại: " . $conn->connect_error);
		}

		$response = "";

		if (!isset($_SESSION['user'])) {
		    $response = "Bạn chưa đăng nhập!";
		} else {
		    $makh =(int) $_SESSION['user']['makh'];
		    $masp = $_POST['masp'] ;
		    $mauchon = $_POST['mauchon'];
		    $soluong = $_POST['soluong'];

		    $sql7 = "INSERT INTO giohang (makh, masp, mauchon, soluong) VALUES ('$makh', '$masp', '$mauchon', '$soluong')";
		    
		    if ($conn->query($sql7) === TRUE) {
		        $response = "Sản phẩm đã được thêm vào giỏ hàng.";
		    } else {
		        $response = "Lỗi: " . $conn->error;
		    }
		}

		$conn->close();
		echo $response;


		
	?>