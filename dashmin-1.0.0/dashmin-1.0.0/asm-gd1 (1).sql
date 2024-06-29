-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 29, 2024 lúc 04:26 AM
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
-- Cơ sở dữ liệu: `asm-gd1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(15, 'Áo'),
(16, 'Quần'),
(17, 'Điện thoại'),
(18, 'Đồng Hồ'),
(19, 'Giày dép'),
(20, 'Phụ kiện'),
(21, 'Xe máy'),
(22, 'Bách hóa'),
(23, 'Thể Thao'),
(24, 'Sách');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `code`, `quantity`, `discount`, `startDate`, `endDate`) VALUES
(1, 'sale 6.6', 'sale6666', 5, 50.00, '2024-06-12', '2024-06-14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `coupon_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `payment_method`, `total_amount`, `discount`, `coupon_code`, `created_at`, `status`, `user_id`) VALUES
(11, 'Nguyễn e1231', 'nguyenvu.cusue@gmail.com', '123123123', '1231231', 'COD', 150000.00, 0.00, NULL, '2024-06-12 14:10:07', 4, 23),
(12, 'e1231 3123', 'admin@gmail.com', '123123', '12312312', 'COD', 225000.00, 0.00, NULL, '2024-06-12 14:10:49', 5, 23),
(13, 'Nguyễn A', 'admin@gmail.com', '0923123321', 'VNA', 'COD', 240000.00, 0.00, NULL, '2024-06-13 05:23:22', 3, 26),
(14, 'asd sdfds', 'admin@gmail.com', '0923123321', 'VNA', 'COD', 120000.00, 0.00, NULL, '2024-06-13 06:23:44', 4, 23),
(15, '123123 sale 6.6', 'admin@gmail.comad', '0923123321', 'VNA', 'COD', 150000.00, 0.00, NULL, '2024-06-20 07:37:19', 5, 23),
(16, ' ', '', '', '', 'VNPAY', 0.00, 0.00, NULL, '2024-06-20 08:31:44', 1, 22),
(17, '123123 sale 6.6', 'nguyenvu.cusue@gmail.com', '0923123321', 'asd', 'COD', 178000.00, 0.00, NULL, '2024-06-20 09:00:36', 1, 23),
(18, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', 'COD', 270000.00, 0.00, NULL, '2024-06-21 08:21:04', 1, 23),
(19, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', 'COD', 270000.00, 0.00, NULL, '2024-06-21 08:22:24', 1, 23),
(20, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', 'COD', 300000.00, 0.00, NULL, '2024-06-21 08:40:42', 2, 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_name`, `quantity`, `price`, `total`, `total_amount`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `created_at`) VALUES
(13, 9, 'Áo Thun', 3, 150000.00, 0.00, 0.00, 'abc a', 'admin@gmail.com', '0923123321', 'VNA', '2024-06-12 13:47:53'),
(14, 10, 'Áo Thun', 1, 150000.00, 150000.00, 0.00, '123123 NguyenVu19', 'admin@gmail.com', '0923123321', 'VNA', '2024-06-12 14:06:01'),
(15, 11, 'Áo Thun', 2, 150000.00, 300000.00, 150000.00, 'Nguyễn e1231', 'nguyenvu.cusue@gmail.com', '123123123', '1231231', '2024-06-12 14:10:07'),
(16, 12, 'Áo Thun', 3, 150000.00, 450000.00, 225000.00, 'e1231 3123', 'admin@gmail.com', '123123', '12312312', '2024-06-12 14:10:49'),
(17, 13, 'Quần dài', 2, 120000.00, 240000.00, 240000.00, 'Nguyễn A', 'admin@gmail.com', '0923123321', 'VNA', '2024-06-13 05:23:22'),
(18, 14, 'Quần dài', 1, 120000.00, 120000.00, 120000.00, 'asd sdfds', 'admin@gmail.com', '0923123321', 'VNA', '2024-06-13 06:23:44'),
(19, 15, 'Áo Thun', 1, 150000.00, 150000.00, 150000.00, '123123 sale 6.6', 'admin@gmail.comad', '0923123321', 'VNA', '2024-06-20 07:37:19'),
(20, 17, 'Sách - The Magic Phép màu', 1, 178000.00, 178000.00, 178000.00, '123123 sale 6.6', 'nguyenvu.cusue@gmail.com', '0923123321', 'asd', '2024-06-20 09:00:36'),
(21, 18, 'Áo Thun', 1, 150000.00, 150000.00, 270000.00, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', '2024-06-21 08:21:04'),
(22, 18, 'Quần Đùi', 1, 120000.00, 120000.00, 270000.00, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', '2024-06-21 08:21:04'),
(23, 19, 'Áo Thun', 1, 150000.00, 150000.00, 270000.00, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', '2024-06-21 08:22:24'),
(24, 19, 'Quần Đùi', 1, 120000.00, 120000.00, 270000.00, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', '2024-06-21 08:22:24'),
(25, 20, 'Áo Thun', 2, 150000.00, 300000.00, 300000.00, 'Nguyen  Vu', 'nguyenvu.cusue@gmail.com', '0915094887', 'VNA', '2024-06-21 08:40:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
(15, 'Áo Thun', '...', 150000.00, 'uploads/021204.webp', 15),
(16, 'Quần Đùi', '...', 120000.00, 'uploads/tải xuống.jpg', 16),
(17, 'Điện thoại iPhone 14', 'Màn hình:\r\n\r\nOLED6.7\"Super Retina XDR\r\nHệ điều hành:\r\n\r\niOS 16\r\nCamera sau:\r\n\r\nChính 48 MP & Phụ 12 MP, 12 MP\r\nCamera trước:\r\n\r\n12 MP\r\nChip:\r\n\r\nApple A16 Bionic\r\nRAM:\r\n\r\n6 GB\r\nDung lượng lưu trữ:\r\n\r\n1 TB\r\nSIM:\r\n\r\n1 Nano SIM & 1 eSIMHỗ trợ 5G\r\nPin, Sạc:\r\n\r\n4323 mAh20 W\r\nHãng\r\n\r\niPhone (Apple). Xem thông tin hãng', 41900000.00, 'uploads/iphone-14-pro-max-purple-1.jpg', 17),
(18, 'Sách - The Magic Phép màu', 'Thương hiệu\r\nRhonda Byrne\r\nNhập khẩu/ trong nước\r\nTrong nước\r\nNgôn ngữ\r\nTiếng Việt\r\nLoại nắp\r\nBìa cứng\r\nLoại phiên bản\r\nPhiên bản thông thường\r\nNăm xuất bản\r\n2022\r\nKho hàng\r\n171\r\nGửi từ\r\nHà Nội', 178000.00, 'uploads/302e18e4f4810810a5c2e055b9012698.jfif', 24),
(19, 'Áo Bóng Đá CLB Real Marid, Áo Đá Banh Real Marid 2324 - Chuẩn Mẫu Thi Đấu - Vải Polyester Gai Thái', 'Giới tính\r\nUnisex\r\nLoại hình thể thao\r\nBóng đá ngoài trời & trong nhà\r\nĐội bóng đá\r\nReal Madrid\r\nKho hàng\r\n16635\r\nGửi từ\r\nHà Nội', 159000.00, 'uploads/vn-11134207-7r98o-lu8q8wg7irkv47.jfif', 23),
(20, 'Đồng hồ nữ dây kim loại chính hãng Casio LA670WA-7DF', 'Thương hiệu\r\nCASIO\r\nMặt đồng hồ\r\nKỹ thuật số\r\nKiểu đồng hồ\r\nCông việc, Thời trang, Thể thao\r\nLoại bảo hành\r\nBảo hành nhà sản xuất\r\nKiểu vỏ đồng hồ\r\nVuông\r\nChất liệu vỏ đồng hồ\r\nNhựa\r\nKiểu khóa đồng hồ\r\nKhóa gài/móc\r\nChất liệu dây đeo\r\nThép không gỉ\r\nTính năng\r\nBáo Thức, Ngày\r\nĐộ sâu chống nước\r\n30m - 50m\r\nKính đồng hồ\r\nNhựa\r\nXuất xứ\r\nKhác\r\nHạn bảo hành\r\n12 tháng\r\nKho hàng\r\n47\r\nGửi từ\r\nTP. Hồ Chí Minh', 908000.80, 'uploads/vn-11134207-7r98o-loxqyjawozta30.jfif', 18),
(21, 'Kẹp Điện Thoại Dán Lên Mặt Đồng Hồ Xe Máy, Có Đế Cài Dễ Tháo Lắp (Kèm Miếng Dán 3M Siêu Dính)-PHỤ KIỆN BEN', 'Kẹp Điện Thoại Dán Lên Mặt Đồng Hồ Xe Máy, Có Đế Cài Dễ Tháo Lắp (Kèm Miếng Dán 3M Siêu Dính)-PHỤ KIỆN BEN\r\n- Sản phẩm là loại đế cài có thể dễ dàng tháo lắp phần kẹp điện thoại chỉ để đế chờ, tiện lợi khi không sử dụng đến kẹp hoặc có thể cài 1 số thiết bị tương thích như camera gopro..., hoặc khi không sử dụng các bạn có thể tháo đầu kẹp cất đi để có thể tăng độ bền cho kẹp lâu hơn(vì đầu kẹp là bằng nhựa nên sẽ bị tác động bởi các yếu tố vật lý hóa học khi dính nắng mưa...)\r\n- Phần đế được sử dụng băng dính 2 mặt chính hãng 3m nên dính siêu chắc, không lo bong tróc khi sử dụng\r\n- Phần thân của kẹp có ốc điều chỉnh góc nhìn để phù hợp với từng loại xe và người điểu khiển xe\r\n- Phần thân kẹp được lót đệm mút cực êm không lo trầy xước máy, phù hợp với các điện thoại có chiều rộng thân máy 5.5-8.5cm\r\n\r\nLưu ý: sản phẩm có 2 loại đế dán shop có chia thành 2 phân loại khi đặt hàng, quý khách đặt hàng hãy chọn loại phù hợp với bề mặt xe của mình nhé\r\n- 1 loại mặt dán là đế phẳng: dùng cho các bề mặt xe để dán là mặt phẳng\r\n- 1 loại mặt dán là đế cong: dùng cho các bề mặt xe để dán lên là mặt cong\r\nNếu có thắc mắc cần tư vấn về sản phẩm trước khi đặt hàng, hoặc cách sử dụng sau khi nhận hàng thì quý khách hãy liên hệ cho shop để được hỗ trợ nhé ạ', 2500.00, 'uploads/fe2268bdc24dd5a2e59a7d34119bf37a.png', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 0,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `address`, `phone`, `otp_code`, `status`) VALUES
(22, 'admin', 'nguyenvu.cusue@gmail.com', '$2y$10$BYT0wL9ettN2g4qtYSYTE.v0UykR1IGQ70M22pdA9iWwS2I3qle.W', 1, 'VNA', '0923123321', '200604', 0),
(23, 'vu', 'hoailxpk03594@gmail.com', '$2y$10$cP.7bv7L0YPwhaApN27Qjuj33W2UyMTFzbAMFd4dWZLGY30ywYpF2', 0, 'VNA', '0923123331', NULL, 0),
(25, 'admin2', 'athethoikhoidat@gmail.com', '$2y$10$sMv3G6QEd5dGYP3WwkgxwulnzjRHgUwYeocqjn0uh10o5ZZjnD97G', 0, 'VNA', '0915094887', NULL, 0),
(26, 'vu2', '123123@gmail.com', '$2y$10$VMyJnsX82HtDW.ravVXNOeUo4PiFilZTjod48hJ25tCjZOxA3Lu9a', 0, 'VNA', '0923123321', NULL, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
