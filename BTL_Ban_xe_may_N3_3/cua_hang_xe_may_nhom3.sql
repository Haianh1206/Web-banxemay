-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 23, 2024 lúc 02:17 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cua_hang_xe_may_nhom3`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky`
--

CREATE TABLE `dangky` (
  `makh` int(9) NOT NULL,
  `tentk` varchar(30) NOT NULL,
  `tendn` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sdt` varchar(20) NOT NULL,
  `diachi` varchar(50) NOT NULL,
  `matkhau` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky`
--

INSERT INTO `dangky` (`makh`, `tentk`, `tendn`, `email`, `sdt`, `diachi`, `matkhau`) VALUES
(2, 'Nguyễn Anh Chiến', 'nguyenanhchien', 'nachien@gmail.com', '0324256778', 'Hà Nội', 'chien1234'),
(3, 'Nguyễn Hải Anh', 'nguyenhaianh', 'nhanh@gmail.com', '0345924432', 'Hà Nội', 'anh1234'),
(4, 'Vũ Thanh Hùng', 'vuthanhhung', 'vthung@gmail.com', '0323424593', 'Hà Nội', 'hung1234'),
(5, 'Nguyễn Trần Huy', 'nguyentranhuy', 'nthuy@gmail.com', '0952435663', 'Hà Nội', 'huy1234');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `magiohang` int(9) NOT NULL,
  `makh` int(9) NOT NULL,
  `masp` int(9) NOT NULL,
  `mauchon` varchar(30) NOT NULL,
  `soluong` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`magiohang`, `makh`, `masp`, `mauchon`, `soluong`) VALUES
(10, 2, 2, 'Đen', 7),
(11, 3, 8, 'Trắng', 5),
(12, 2, 11, 'Đỏ', 6),
(13, 3, 21, 'Đen', 10),
(17, 3, 5, 'Đen', 4),
(51, 2, 10, 'Trắng', 2),
(56, 5, 6, 'Đen', 3),
(57, 5, 5, 'Trắng', 1),
(58, 5, 10, 'Đen', 3),
(59, 5, 22, 'Đỏ', 4),
(60, 4, 2, 'Đen', 1),
(61, 4, 2, 'Đen', 1),
(62, 4, 2, 'Đen', 1),
(63, 4, 2, 'Đen', 1),
(64, 4, 2, 'Đen', 1),
(65, 4, 2, 'Đen', 1),
(66, 4, 2, 'Đen', 1),
(67, 4, 2, 'Đen', 1),
(68, 4, 2, 'Đen', 1),
(69, 4, 2, 'Đen', 1),
(70, 4, 2, 'Đen', 1),
(71, 3, 7, 'Đen', 3),
(72, 3, 19, 'Đen', 2),
(73, 3, 18, 'Đen', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lienhe`
--

CREATE TABLE `lienhe` (
  `maykien` int(9) NOT NULL,
  `makh` int(9) NOT NULL,
  `ykien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lienhe`
--

INSERT INTO `lienhe` (`maykien`, `makh`, `ykien`) VALUES
(8, 3, '     ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtindathang`
--

CREATE TABLE `thongtindathang` (
  `madh` int(9) NOT NULL,
  `makh` int(9) NOT NULL,
  `tenkh` varchar(50) NOT NULL,
  `diachi` varchar(50) NOT NULL,
  `sdt` varchar(15) NOT NULL,
  `donmua` varchar(255) NOT NULL,
  `ngaydat` date NOT NULL,
  `phuongthuc` varchar(50) NOT NULL,
  `thanhtien` decimal(18,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtindathang`
--

INSERT INTO `thongtindathang` (`madh`, `makh`, `tenkh`, `diachi`, `sdt`, `donmua`, `ngaydat`, `phuongthuc`, `thanhtien`) VALUES
(6, 2, '', '', '', 'EXCITER 155 x 6, CUP 50CC x 2', '2024-11-12', 'Thanh toán khi nhận hàng', 318000000),
(7, 2, '', '', '', 'CUP 50CC x 2', '2024-11-12', 'Thanh toán khi nhận hàng', 30000000),
(8, 2, '', '', '', 'CUP 50CC x 2', '2024-11-12', 'PayPal', 30000000),
(9, 2, '', '', '', 'EXCITER 155 x 6, CUP 50CC x 2', '2024-11-12', 'PayPal', 318000000),
(10, 3, '', '', '', 'REBEL 1100 x 1', '2024-11-23', 'Thẻ tín dụng', 500000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongtinsanpham`
--

CREATE TABLE `thongtinsanpham` (
  `masp` int(9) NOT NULL,
  `anhsp` char(255) NOT NULL,
  `tensp` varchar(50) NOT NULL,
  `namsx` int(9) NOT NULL,
  `noisx` varchar(30) NOT NULL,
  `kichthuoc` varchar(30) NOT NULL,
  `phankhoi` decimal(18,0) NOT NULL,
  `trongluong` decimal(18,0) NOT NULL,
  `dungtichxang` decimal(18,0) NOT NULL,
  `dongco` varchar(60) NOT NULL,
  `tocdo` decimal(18,0) NOT NULL,
  `baohanh` varchar(10) NOT NULL,
  `mausac` varchar(20) NOT NULL,
  `gia` decimal(18,0) NOT NULL,
  `mota` varchar(255) NOT NULL,
  `daban` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thongtinsanpham`
--

INSERT INTO `thongtinsanpham` (`masp`, `anhsp`, `tensp`, `namsx`, `noisx`, `kichthuoc`, `phankhoi`, `trongluong`, `dungtichxang`, `dongco`, `tocdo`, `baohanh`, `mausac`, `gia`, `mota`, `daban`) VALUES
(1, 'assets/img/ab160.png', 'AIR BLADE 160', 2024, 'Việt Nam', '1890 x 686 x 1116 mm', 157, 114, 4, '156.9cc, 1 xi-lanh, làm mát bằng dung dịch.', 160, '3 năm', 'Đỏ, Đen, Trắng', 56490000, 'Xe có động cơ 4 kỳ, 1 xi lanh, làm mát bằng dung d', 23),
(2, 'assets/img/africatwin2024.png', 'AFRICA TWIN 2024', 2024, 'Nhật Bản', '2.30 x 0.92 x 1.45 m', 1084, 226, 19, '1084cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 200, '3 năm', 'Đỏ, Đen, Trắng', 650000000, 'Xe Honda Africa Twin 2024 với thiết kế mạnh mẽ, độ', 45),
(3, 'assets/img/cb1000r2023.jpg', 'CB1000R 2023', 2023, 'Nhật Bản', '2.12 x 0.79 x 1.06 m', 1000, 212, 16, '998cc, 4 xi-lanh thẳng hàng, làm mát bằng dung dịch.', 250, '2 năm', 'Đỏ, Đen, Trắng', 350000000, 'Xe Honda CB1000R 2023 với thiết kế naked bike thể ', 12),
(4, 'assets/img/cb350hness.png', 'CB350 H\'NESS', 2023, 'Nhật Bản', '2.10 x 0.80 x 1.10 m', 348, 180, 15, '348cc, 2 xi-lanh, làm mát bằng không khí.', 120, '2 năm', 'Đỏ, Đen, Trắng', 150000000, 'Xe Honda CB350 H\'ness với thiết kế cổ điển, động c', 76),
(5, 'assets/img/cb500hornet.png', 'CB500 HORNET', 2023, 'Nhật Bản', '2.07 x 0.79 x 1.06 m', 500, 190, 17, '471cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 185, '2 năm', 'Đỏ, Đen, Trắng', 220000000, 'Xe Honda CB500 Hornet với thiết kế mạnh mẽ, động c', 58),
(6, 'assets/img/cbr1000rr_r.png', 'CBR1000RR-R', 2023, 'Nhật Bản', '2.06 x 0.75 x 1.14 m', 1000, 201, 16, '999cc, 4 xi-lanh thẳng hàng, làm mát bằng dung dịch.', 300, '2 năm', 'Đỏ, Đen, Trắng', 1000000000, 'Xe Honda CBR1000RR-R với thiết kế thể thao, động c', 19),
(7, 'assets/img/cbr150r.png', 'CBR150R', 2023, 'Việt Nam', '1.98 x 0.71 x 1.14 m', 150, 135, 12, '149cc, 1 xi-lanh, làm mát bằng dung dịch.', 135, '2 năm', 'Đỏ, Đen, Trắng', 80000000, 'Xe CBR150R với thiết kế thể thao, động cơ mạnh mẽ ', 34),
(8, 'assets/img/cbr500r2024.png', 'CBR500R 2023', 2023, 'Nhật Bản', '2.07 x 0.77 x 1.14 m', 500, 192, 17, '471cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 185, '2 năm', 'Đỏ, Đen, Trắng', 180000000, 'Xe CBR500R 2023 với thiết kế thể thao, động cơ mạn', 89),
(9, 'assets/img/cbr650r2024.png', 'CBR650R', 2023, 'Nhật Bản', '2.10 x 0.79 x 1.14 m', 650, 202, 15, '649cc, 4 xi-lanh thẳng hàng, làm mát bằng dung dịch.', 220, '2 năm', 'Đỏ, Đen, Trắng', 280000000, 'Xe Honda CBR650R với thiết kế thể thao, động cơ mạ', 11),
(10, 'assets/img/cub50cc.jpg', 'CUP 50CC', 2023, 'Việt Nam', '1.80 x 0.65 x 1.00 m', 50, 75, 4, '49cc, 1 xi-lanh, làm mát bằng không khí.', 45, '2 năm', 'Đỏ, Đen, Trắng', 15000000, 'Xe máy Cup 50cc, kiểu dáng cổ điển, tiết kiệm nhiê', 92),
(11, 'assets/img/exciter155.jpg', 'EXCITER 155', 2023, 'Việt Nam', '1.96 x 0.71 x 1.10 m', 155, 131, 5, '155cc, 1 xi-lanh, làm mát bằng dung dịch.', 140, '2 năm', 'Đỏ, Đen, Trắng', 48000000, 'Xe Exciter 155 với thiết kế thể thao, động cơ mạnh', 15),
(12, 'assets/img/future125fi.png', 'FUTURE 125CC FI 2024', 2024, 'Việt Nam', '1939 x 711 x 1092 mm', 125, 105, 5, '124cc, 1 xi-lanh, làm mát bằng không khí.', 100, '3 năm', 'Đỏ, Đen, Trắng', 34000000, 'Xe Future 125cc FI 2024 trang bị động cơ tiết kiệm', 41),
(13, 'assets/img/goldwing2024.png', 'GOLD WING 2024', 2024, 'Nhật Bản', '2.50 x 0.95 x 1.45 m', 1833, 379, 21, '1833cc, 6 xi-lanh, làm mát bằng dung dịch.', 180, '3 năm', 'Đỏ, Đen, Trắng', 750000000, 'Xe Honda Gold Wing 2024 với thiết kế sang trọng, đ', 68),
(14, 'assets/img/blade.png', 'BLADE', 2023, 'Việt Nam', '1.95 x 0.68 x 1.05 m', 110, 100, 4, '109cc, 1 xi-lanh, làm mát bằng không khí.', 95, '2 năm', 'Đỏ, Đen, Trắng', 30000000, 'Xe Honda Blade với thiết kế thể thao, động cơ mạnh', 24),
(15, 'assets/img/jupiter.png', 'JUPITER', 2023, 'Việt Nam', '1.92 x 0.70 x 1.10 m', 115, 100, 4, '115cc, 1 xi-lanh, làm mát bằng không khí.', 100, '2 năm', 'Đỏ, Đen, Trắng', 35000000, 'Xe Jupiter với thiết kế năng động, tiết kiệm nhiên', 37),
(16, 'assets/img/leadabs.png', 'LEAD', 2023, 'Việt Nam', '1.86 x 0.70 x 1.13 m', 125, 112, 7, '125cc, 1 xi-lanh, làm mát bằng dung dịch.', 90, '2 năm', 'Đỏ, Đen, Trắng', 40000000, 'Xe Lead với thiết kế sang trọng, không gian chứa đ', 53),
(17, 'assets/img/nx500.png', 'NX500', 2023, 'Nhật Bản', '2.12 x 0.85 x 1.18 m', 500, 189, 15, '471cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 175, '2 năm', 'Đỏ, Đen, Trắng', 200000000, 'Xe Honda NX500 với thiết kế thể thao và động cơ mạ', 30),
(18, 'assets/img/rebel11002023.png', 'REBEL 1100', 2023, 'Nhật Bản', '2.25 x 0.84 x 1.10 m', 1100, 226, 14, '1084cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 180, '2 năm', 'Đỏ, Đen, Trắng', 500000000, 'Xe Honda Rebel 1100 với thiết kế chopper cổ điển, ', 27),
(19, 'assets/img/waversx.png', 'WAVE RSX', 2023, 'Việt Nam', '1919x709x1080 mm', 110, 100, 4, '109cc, 1 xi-lanh, làm mát bằng không khí.', 90, '3 năm ', 'Đỏ, Đen, Trắng', 20490000, 'Xe có thiết kế thể thao, hệ thống phun xăng điện t', 94),
(20, 'assets/img/shmode125.png', 'SH MODE 125', 2023, 'Việt Nam', '1.89 x 0.68 x 1.10 m', 125, 100, 5, '124cc, 1 xi-lanh, làm mát bằng dung dịch.', 90, '2 năm', 'Đỏ, Đen, Trắng', 55000000, 'Xe Honda SH Mode 125 với thiết kế thanh lịch, động', 82),
(21, 'assets/img/sh160i.png', 'SH160I', 2024, 'Việt Nam', '2090x739x1129 mm', 157, 134, 8, '156.9cc, 1 xi-lanh, làm mát bằng dung dịch.', 0, '3 năm', 'Đỏ, Đen, Trắng', 92500000, 'Thiết kế đèn LED, ABS 2 kênh, HSTC, Start & Stop', 61),
(22, 'assets/img/sh350i.png', 'SH350I', 2023, 'Việt Nam', '2.10 x 0.75 x 1.14 m', 350, 169, 9, '329.6cc, 1 xi-lanh, làm mát bằng dung dịch.', 130, '3 năm', 'Đỏ, Đen, Trắng', 100000000, 'Xe Honda SH350i với thiết kế sang trọng, động cơ m', 39),
(23, 'assets/img/siriusRC.jpg', 'SIRIUS 50CC', 2024, 'Nhật Bản', '1,940 x 715 x 1,075', 50, 96, 4, '49cc, 1 xi-lanh, làm mát bằng không khí.', 90, '3 năm', 'Đỏ, Đen, Trắng', 18100000, 'Xe Yamaha Sirius 50cc, kiểu dáng thể thao, tiết ki', 73),
(24, 'assets/img/supercubc125.png', 'SUPER CUP C125', 2023, 'Việt Nam', '1.90 x 0.69 x 1.06 m', 125, 108, 4, '125cc, 1 xi-lanh, làm mát bằng không khí.', 100, '2 năm', 'Đỏ, Đen, Trắng', 55000000, 'Xe Super Cup C125 với thiết kế cổ điển, động cơ mạ', 56),
(25, 'assets/img/suzukiraider.jpg', 'RAIDER R150', 2023, 'Việt Nam', '1.95 x 0.68 x 1.06 m', 150, 130, 4, '150cc, 1 xi-lanh, làm mát bằng dầu và dung dịch.', 140, '2 năm', 'Đỏ, Đen, Trắng', 55000000, 'Xe Suzuki Raider R150 với thiết kế thể thao, động ', 48),
(26, 'assets/img/symgalaxy.png', 'SYM GALAXY', 2023, 'Đài Loan', '1.86 x 0.68 x 1.10 m', 125, 100, 5, '115cc, 1 xi-lanh, làm mát bằng không khí.', 100, '2 năm', 'Đỏ, Đen, Trắng', 38000000, 'Xe SYM Galaxy với thiết kế hiện đại, tiện ích tối ', 20),
(27, 'assets/img/transalp.jpg', 'TRANSALP', 2023, 'Nhật Bản', '2.20 x 0.85 x 1.25 m', 755, 205, 18, '755 cc, 2 xi-lanh song song, làm mát bằng dung dịch.', 190, '2 năm', 'Đỏ, Đen, Trắng', 600000000, 'Xe Honda Transalp với thiết kế đa năng, động cơ mạ', 70),
(28, 'assets/img/vario160.png', 'VARIO 160', 2023, 'Việt Nam', '1.92 x 0.69 x 1.06 m', 150, 112, 6, '160cc, 1 xi-lanh, làm mát bằng dung dịch.', 120, '2 năm', 'Đỏ, Đen, Trắng', 45000000, 'Xe Vario với thiết kế thể thao, động cơ mạnh mẽ và', 65),
(29, 'assets/img/vespasprint.jpg', 'VESPA SPRINT 2023', 2023, 'Ý', '1.90 x 0.74 x 1.14 m', 125, 130, 9, '125cc hoặc 150cc, 1 xi-lanh, làm mát bằng không khí.', 95, '3 năm', 'Đỏ, Đen, Trắng', 90000000, 'Xe Vespa Sprint 2023 với thiết kế cổ điển, phong c', 33),
(30, 'assets/img/vision.png', 'VISION 2024', 2024, 'Việt Nam', '1871 x 686 x 1101 mm', 110, 96, 5, '110cc, 1 xi-lanh, làm mát bằng không khí.', 7, '3 năm', 'Đỏ, Đen, Trắng', 31113818, 'Honda Vision 2024 thiết kế trẻ trung, thời trang, ', 14),
(31, 'assets/img/wavealpha110.png', 'WAVE ALPHA 2024', 2024, 'Việt Nam', '1914 x 688 x 1075 mm', 109, 97, 4, '110cc, 1 xi-lanh, làm mát bằng không khí.', 85, '3 năm ', 'Đỏ, Đen, Trắng', 17860000, 'Xe có thiết kế nhỏ gọn, tiết kiệm nhiên liệu, phù ', 77),
(32, 'assets/img/winnerx.jpg', 'WINNER X', 2023, 'Việt Nam', '1.98 x 0.72 x 1.12 m', 150, 125, 5, '150cc, 1 xi-lanh, làm mát bằng dung dịch.', 130, '2 năm', 'Đỏ, Đen, Trắng', 45000000, 'Xe Winner X với thiết kế thể thao, động cơ mạnh mẽ', 42),
(33, 'assets/img/yamahagrande.jpg', 'GRANDE', 2023, 'Việt Nam', '1.84 x 0.70 x 1.14 m', 125, 115, 4, '125cc, 1 xi-lanh, làm mát bằng không khí.', 90, '2 năm', 'Đỏ, Đen, Trắng', 45000000, 'Xe Yamaha Grande với thiết kế thanh lịch, tiết kiệ', 60),
(34, 'assets/img/yamahajanus.jpg', 'YANUS', 2023, 'Việt Nam', '1.81 x 0.67 x 1.07 m', 125, 100, 4, '125cc, 1 xi-lanh, làm mát bằng không khí.', 100, '2 năm', 'Đỏ, Đen, Trắng', 42000000, 'Xe Yamaha Yanus với thiết kế trẻ trung, hiện đại v', 85);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dangky`
--
ALTER TABLE `dangky`
  ADD PRIMARY KEY (`makh`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`magiohang`),
  ADD KEY `masp` (`masp`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  ADD PRIMARY KEY (`maykien`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `thongtindathang`
--
ALTER TABLE `thongtindathang`
  ADD PRIMARY KEY (`madh`),
  ADD KEY `makh` (`makh`);

--
-- Chỉ mục cho bảng `thongtinsanpham`
--
ALTER TABLE `thongtinsanpham`
  ADD PRIMARY KEY (`masp`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dangky`
--
ALTER TABLE `dangky`
  MODIFY `makh` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `magiohang` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  MODIFY `maykien` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `thongtindathang`
--
ALTER TABLE `thongtindathang`
  MODIFY `madh` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `thongtinsanpham`
--
ALTER TABLE `thongtinsanpham`
  MODIFY `masp` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`masp`) REFERENCES `thongtinsanpham` (`masp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`makh`) REFERENCES `dangky` (`makh`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lienhe`
--
ALTER TABLE `lienhe`
  ADD CONSTRAINT `lienhe_ibfk_1` FOREIGN KEY (`makh`) REFERENCES `dangky` (`makh`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thongtindathang`
--
ALTER TABLE `thongtindathang`
  ADD CONSTRAINT `thongtindathang_ibfk_1` FOREIGN KEY (`makh`) REFERENCES `dangky` (`makh`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
