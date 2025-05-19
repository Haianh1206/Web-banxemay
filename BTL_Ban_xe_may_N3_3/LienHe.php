<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Liên hệ</title>
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
			margin-bottom: 50px ;
		}
		.lienhe{
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
			margin: 20px 160px;
			display: flex;
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
		.btn_guiykien{
			padding: 5px 30px;
			background-color: #4eb541;
			color: #fff;
			font-size: 20px;
			border-radius: 15px;
			font-style: italic;
		}
		.btn_guiykien:hover{
			background-color:#88ce8b ;
		}
		.comeback{
			position: absolute;   /*để có thể tùy chỉnh vị trí của thẻ*/
			right: 50px;
			bottom: 40px;
			color: #fff;
			font-style:italic ;
			text-decoration: none;
		}
		.comeback:hover{
			color: #fa6b00;
		}
		.topic{
			margin-left: 30px;
			color: #fff;
			margin-bottom: 20px;
			font-size: 18px;
		}
		.infor{
			color: #fff;
			margin-bottom: 10px;
			margin-left: 30px;
		}
		.label{
			color: #fff;
			margin-left: 30px;
			margin-bottom: 10px;
		}
		.icon_info{
			margin-right: 10px;
		}
		.dangky textarea{
			font-style: italic;
		}
		.opinion{
			margin-left: 22px;
			border-radius: 5px;
			padding: 10px;
		}
		.thongbao1{
			text-align: center;
			font-style: italic;
			font-size: 20px ;
			color: #fff;
			font-weight: bold;
			margin-top: 45%;
		}
	</style>

</head>
<body>
	<?php
		// Khởi động session để lấy tên người dùng từ session
		session_start();
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

	?>

	<div class="background">
		<form id="opinionForm" method="POST" action="LienHe.php">
			<div class="lienhe">
			    <?php if (!isset($_SESSION['user'])): ?>
			        <!-- Hiển thị thông báo nếu chưa đăng nhập -->
			        <p class="thongbao1">Vui lòng đăng nhập để gửi ý kiến !</p>
			    <?php else: ?>
			    	<?php // Kiểm tra nếu người dùng nhấn nút gửi ý kiến
					    if (isset($_POST['input_guiykien'])) {
					        // Lấy nội dung từ textarea và tên tài khoản từ session
					        $nhap = $conn->real_escape_string($_POST['nhap']);
					        $makh = $conn->real_escape_string($_SESSION['user']['makh']); // mã kh từ session
					        $thongbao = "";
					        // Tạo câu lệnh SQL để chèn dữ liệu vào bảng lienhe
					        $sql = "INSERT INTO lienhe (makh, ykien) VALUES ('$makh', '$nhap')";

					        // Thực thi câu lệnh SQL
					        if (strlen($nhap) < 5 || strlen($nhap) > 255) {
					            $thongbao = "Độ dài văn bản tối thiểu 5 ký tự và tối đa 255 ký tự";
					        } else {
						        $conn->query($sql);
						    }
					    }
				    ?>
			        <!-- Nội dung khi người dùng đã đăng nhập -->
			        <h1 align="center">LIÊN HỆ</h1>
			        <p class="label">Nhập ý kiến</p>
			        <form method="POST" action="">
			            <textarea class="opinion" name="nhap" rows="8" cols="57" placeholder="Nhập vào ý kiến đóng góp của bạn" ></textarea>
			            <div class="nut">
			                <input onclick="send_idea()" class="btn_guiykien btn_submit" type="submit" name="input_guiykien" value="Gửi ý kiến">
			            </div>
			        </form>
			        
			        <div>
			            <p class="topic">Thông tin liên hệ</p> 
			            <div class="infor">
			                <i class="fa-solid fa-phone icon_info"></i>
			                <span> Hotline: 18001989</span>
			            </div>
			            <div class="infor">
			                <i class="fa-regular fa-envelope icon_info"></i>
			                <span> Email: AHCmotorbike@gmail.com</span>
			            </div>
			            <div class="infor">
			                <i class="fa-solid fa-location-dot icon_info"></i>
			                <span> Địa chỉ: 218 Lĩnh Nam, Hoàng Mai, Hà Nội</span>
			            </div>
			        </div>
			        <?php endif; ?>
			    	<?php $conn->close(); ?>
			        <a class="comeback" href="ChuongTrinh.php">Trở lại?</a>
			</div>
		</form>
		
	</div>
		

	<!-- script sử lý báo lỗi khi nhập k hợp lệ -->
	<script>
        function send_idea() {
            const opinionField = document.querySelector(".opinion");

            // Lấy độ dài ý kiến
            const length = opinionField.value.length;

            // Kiểm tra độ dài ý kiến (từ 5 đến 255 ký tự)
            if (length < 5 || length > 255) {
                alert("Nội dung có độ dài từ 5 đến 255 ký tự");
                return;
            } 
            else {
                var choice = confirm('xác nhận thông tin\n');
		        if(choice == 1){
		        	alert('Ý kiến đã được thành công');
		        }
            }
        };
    </script>
</body>
</html>