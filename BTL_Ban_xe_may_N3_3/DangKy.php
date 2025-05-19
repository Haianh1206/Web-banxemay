<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đăng ký</title>
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
		}
		.dangky{
			position: relative;
			background-color: rgb(2, 0, 0, 0.7);
			margin:50px 0;
			padding: 20px;
			border-radius: 5px;
			width: 500px;
			height: 700px;
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
			margin-top: 10px;
			display: flex;
			justify-content: center;
		}
		.btn_submit{
			padding: 10px 50px;
			margin: 0 20px;
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
		.btn_dangky{
			background-color: #4eb541;
			width: 50%;
			color: #fff;
			font-size: 20px;
		}
		.btn_dangky:hover{
			background-color:#88ce8b ;
		}
		.comeback{
			position: absolute;   /*để có thể tùy chỉnh vị trí của thẻ*/
			left: 210px;
			color: #fff;
			font-style:italic ;
			text-decoration: none;
			margin-top: 20px;
		}
		.comeback:hover{
			color: #fa6b00;
		}
		.change_page{
			margin: 30px 0 10px 0;
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
		//session_start();
		
		// Kết nối đến cơ sở dữ liệu MySQL
		$servername = "localhost"; // Thay đổi nếu bạn có cấu hình khác
		$username = "root"; // Tên người dùng MySQL
		$password = ""; // Mật khẩu MySQL
		$dbname = "cua_hang_xe_may_nhom3"; // Tên cơ sở dữ liệu

		// Tạo kết nối
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Kiểm tra kết nối
		if ($conn->connect_error) {
		    die("Kết nối thất bại: " . $conn->connect_error);
		}

		// Kiểm tra khi form được gửi đi
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		    // Lấy dữ liệu từ form
		    $tentk = trim($_POST["tentk"]);
		    $tendn = trim($_POST["tendn"]);
		    $email = trim($_POST["email"]);
		    $sdt = trim($_POST["sdt"]);
		    $diachi = trim($_POST["diachi"]);
		    $matkhau = trim($_POST["matkhau"]);
		    $nhaplaimk = trim($_POST["nhaplaimk"]);

		     // Truy vấn để lấy tất cả các bản ghi từ cột 'tendn' trong bảng 'dangky'
			$sql2 = "SELECT tendn FROM dangky";
			$result2 = $conn->query($sql2);
			// Khởi tạo một mảng để chứa các giá trị
			$tendnArray = [];
			if ($result2->num_rows > 0) {
			    // Lặp qua tất cả các bản ghi và lưu vào mảng
			    while($row = $result2->fetch_assoc()) {
			        $tendnArray[] = $row['tendn'];
			    }
			}

			//chuyển mảng thành chuỗi để dùng so sánh ký tự vs chuỗi
			//$chuoi_tendn = implode(" ",$tendnArray);
			$chuoi_tendn = json_encode($tendnArray);


		    // Kiểm tra mật khẩu khớp, tendn, email, sdt hợp lệ
		    if (($matkhau !== $nhaplaimk) || (!filter_var($email, FILTER_VALIDATE_EMAIL)) || (!preg_match("/^[0-9]{9,10}$/", $sdt)) || (in_array($tendn,$tendnArray))) {
		    	header("Location: DangKy.php");
		        exit();
		    }
		    else{
			    $sql = "INSERT INTO dangky ( tentk, tendn, email, sdt, diachi, matkhau)
			            VALUES ( '$tentk', '$tendn', '$email', '$sdt', '$diachi', '$matkhau')";
			    $conn->query($sql);
		    }
		    $conn->close();
		}
	?>
	<form  method="POST" action="">
		<div id="registrationForm" class="background">
			<div class="dangky">
				<h1 align="center">ĐĂNG KÝ</h1>
				<div class="input_container">
					<input type="text" name="tentk" class="tentk" id="tentk" required placeholder="Tên tài khoản">
					<i class="fa-regular fa-user"></i>
				</div>
				<div class="input_container">
					<input type="text" name="tendn" class="tendn" id="tendn" required placeholder="Tên đăng nhập">
					<i class="fa-regular fa-user"></i>
				</div>
				<div class="input_container">
					<input type="email" name="email" class="email" id="email" required placeholder="Email">
					<i class="fa-regular fa-envelope"></i>
				</div>
				<div class="input_container">
					<input type="text" name="sdt" class="sdt" id="sdt" required placeholder="Số điện thoại">
					<i class="fa-solid fa-phone"></i>
				</div>
				<div class="input_container">
					<input type="text" name="diachi" class="diachi" id="diachi" required placeholder="Địa chỉ">
					<i class="fa-regular fa-address-book"></i>
				</div>
				<div class="input_container">
					<input type="password" name="matkhau" class="matkhau" id="matkhau" required placeholder="Mật khẩu">
					<i class="fa-solid fa-lock"></i>
				</div>
				<div class="input_container">
					<input type="password" name="nhaplaimk" class="nhaplaimk" id="nhaplaimk" required placeholder="Nhập lại mật khẩu">
					<i class="fa-solid fa-lock"></i>
				</div>
				<div class="nut">
					<input onclick="validateForm()" id="btn_dangky" class="btn_dangky btn_submit" type="submit" name="btn_dangky" value="Đăng ký ngay">
				</div>
				<div class="change_page">
					<p>Bạn đã có tài khoản ?</p>
					<a href="DangNhap.php">Đăng nhập!</a>
				</div>
				<a class="comeback" href="ChuongTrinh.php">Trở lại?</a>
			</div>
		</div>
	</form>
	<script>
		
         function validateForm() {
         	var tentk = document.getElementById('tentk').value;
         	var tendn = document.getElementById('tendn').value;
         	var diachi = document.getElementById('diachi').value;
	        var email = document.getElementById('email').value;
	        var sdt = document.getElementById('sdt').value;
	        var matkhau = document.getElementById('matkhau').value;
	        var nhaplaimk = document.getElementById('nhaplaimk').value;
	        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	        var phonePattern = /^[0-9]{10}$/;

	        
	        if(tentk == "" ||tendn =="" ||diachi=="" || sdt==""||email==""||matkhau==""||nhaplaimk==""	){
	        	alert('Vui lòng nhập đầy đủ thông tin');
	        	return;
	        }
	        // Kiểm tra email đúng định dạng
	        else if (!emailPattern.test(email)) {
	            alert("Vui lòng nhập đúng định dạng email.\n") ;
	            return;
	        }

	        // Kiểm tra số điện thoại đúng định dạng
	        else if (!phonePattern.test(sdt)) {
	            alert("Số điện thoại phải có 10 chữ số.\n") ;
	            return;
	        }

	        // Kiểm tra mật khẩu và nhập lại mật khẩu giống nhau
	        else if (matkhau !== nhaplaimk) {
	            alert("Mật khẩu và Nhập lại mật khẩu không khớp.\n") ;
	            return;
	        }

	        else{
	        	var choice = confirm('xác nhận thông tin\n');
		        if(choice == 1){
		        	alert('Đã gửi thông tin');
		        }
	        }
        	  
	        
			
			/*// Gán mảng PHP vào biến JavaScript dưới dạng JSON
			//var mangtendn = <?php echo $chuoi_tendn; ?>;
			let mangtendn = "vuthanhhung" ;	
			// Kiểm tra xem tên đăng nhập trong thẻ input có tồn tại trong mảng hay không
			if (mangtendn.includes(tendn)) {
			    alert('Tên đăng nhập đã tồn tại');
			    return;
			}*/
		}
    </script>
</body>
</html>