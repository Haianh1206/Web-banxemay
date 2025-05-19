<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đăng Nhập</title>
    <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.1.2-web/css/all.min.css">
	<style >
		* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }


        /* Lớp phủ màu tối */
        .background::before  {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(25, 23, 22, 0.3); /* Lớp phủ màu đen, với độ trong suốt 50% */
        }
		body{
			display: flex;
			justify-content: center;
			align-items:center ;
			background-color: darkred;
			background-image: url(assets/img/background2.jpg);
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		}
		h1{
			color: #fff;
			margin: 15px auto;
			margin-bottom: 30px ;
		}
		.dangky{
			position: relative;
			background-color: rgb(2, 0, 0, 0.7);
			margin-top:50px;
			padding: 20px;
			border-radius: 5px;
			width: 500px;
			height: 600px;
			display: block;
			box-shadow: 0 0 3px 1px #fff;  /*đổ bóng ngang 0, dọc 0, độ tỏa 3, độ dày 1, màu fff*/
		}
		.input_container input{
			color: #fff;
			background-color: transparent;
			width: 90%;
			margin-bottom: 20px;
			padding: 10px 5px;
			border-radius: 5px;
			justify-content: center;
			margin-left: 22px;
			outline: none;
			border: 0.5px solid #fff;
		}

		.nut{
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.btn_submit{
			padding: 10px 50px;
			margin: 30px 20px;
			border-radius: 10px;
			cursor: pointer;
		}
		.input_container {
			position: relative;
		}
		.input_container i{
			color: #fff;
			position: absolute;
			right: 42px; /* Vị trí icon từ bên phải */
            top: 32%;
            transform: translateY(-50%); /* Để icon canh giữa theo chiều dọc */
            color: #888;
		}
		.btn_dangnhap{
			width: 50%;
			background-color: #4eb541;
			color: #fff;
			font-size: 20px;
		}
		.btn_dangnhap:hover{
			background-color:#88ce8b ;
		}
		.comeback{
			position: absolute;   /*để có thể tùy chỉnh vị trí của thẻ*/
			right: 220px;
			bottom: 50px;
			color: #fff;
			font-style:italic ;
			text-decoration: none;
		}
		.comeback:hover{
			color: #fa6b00;
		}
		.logo{
			margin-left: 160px;
			font-size: 100px;
			margin-bottom: 30px;
		}
		.change_page{
			margin: 0px 0 10px 0;
			align-items: center;
			justify-content: center;
			display: flex;
		}
		.change_page p{
			padding-right: 10px;
			color: #fff;
			justify-content: center;
			align-items: center;
		}
		.change_page a{
			font-style: italic;
			color: #af5aed;
		}
		.change_page a:hover{
			color: #c488ef;
		}
	</style>

</head>

<body>

	<?php
		session_start();
	
		// Kết nối cơ sở dữ liệu
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cua_hang_xe_may_nhom3";

		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Kết nối thất bại: " . $conn->connect_error);
		}

		// Biến để lưu thông báo lỗi
    	$error_message = "";
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tendn = $_POST['tendn'];
            $matkhau = $_POST['matkhau'];            

            $sql = "SELECT * FROM dangky WHERE tendn = ? AND matkhau = ?";  //lệnh lấy tất cả đối tượng có tendn và matkhau bằng với chuỗi sắp đc truyền vào tại dấu ?
            $stmt = $conn->prepare($sql);					//chuẩn bị cho câu lệnh sql
            $stmt->bind_param("ss", $tendn, $matkhau);		//gán biến tendn và matkhau từ ô input vào dấu ? , ss nghĩa là 2 đối tượng có kiểu string
            $stmt->execute();								//thực thi lệnh 
            $result = $stmt->get_result();					//lấy kết quả từ lệnh

            if ($result->num_rows > 0) {
                // Đăng nhập thành công
                $_SESSION['user'] = $result->fetch_assoc();	//lưu thông tin người dùng vào biến phiên $_SESSION['user'] để sử dụng cho các trang khác
                header("Location: ChuongTrinh.php");		//điều hướng đến trang ChuongTrinh.php
                exit;
            }
            else{
            	$error_message = "Tên đăng nhập hoặc mật khẩu không đúng! ";
            }

            $stmt->close();
        }

		$conn->close();
	?>
	<form method="POST" action="DangNhap.php">
		<div class="background">
			<div class="dangky">
				<h1 align="center">ĐĂNG NHẬP</h1>
				<div class="logo">
					<i class="fa-solid fa-motorcycle" style="color: #fff;"></i>
				</div>
				<div class="input_container">
					<input type="text" name="tendn" required placeholder="Tên đăng nhập">
					<i class="fa-regular fa-user"></i>
				</div>
				
				<div class="input_container">
					<input type="text" name="matkhau" required placeholder="Mật khẩu">
					<i class="fa-solid fa-lock"></i>
				</div>
				
				<div class="nut">
					<input onclick="dangnhap()" class="btn_dangnhap btn_submit" type="submit" name="input_dangnhap" value="Đăng Nhập">
				</div>
				<div class="change_page">
					<p>Bạn chưa có tài khoản ?</p>
					<a href="DangKy.php">Đăng Ký ngay!</a>
				</div>
				<a class="comeback" href="ChuongTrinh.php">Trở lại?</a>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		// Nếu có thông báo lỗi, hiển thị thông báo bằng alert
        <?php if ($error_message): ?>  //kiểm tra xem biến $error_message có chứa giá trị nào không (tức là nó không phải là null, false hoặc một chuỗi rỗng).
            alert("<?php echo $error_message; ?>");
        <?php endif; ?>   //cú pháp kết thúc của khối điều kiện if trong PHP
	</script>
</body>
</html>