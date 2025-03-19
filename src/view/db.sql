-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 19, 2025 lúc 11:35 AM
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
-- Cơ sở dữ liệu: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line1`, `address_line2`, `city`, `state`, `postal_code`, `country`, `is_default`) VALUES
(1, 1, '123 Lý Thường Kiệt', NULL, 'Hà Nội', 'Hà Nội', '100000', 'Việt Nam', 1),
(2, 2, '456 Nguyễn Văn Cừ', NULL, 'TP.HCM', 'TP.HCM', '700000', 'Việt Nam', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-03-19 10:33:15', '2025-03-19 10:33:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Cà phê hạt', 'Các loại cà phê nguyên chất, chưa xay.'),
(2, 'Cà phê bột', 'Cà phê đã được xay sẵn, tiện lợi khi pha.'),
(3, 'Cà phê hòa tan', 'Cà phê đóng gói sẵn, dễ pha chế.'),
(4, 'Cà phê đặc sản', 'Các loại cà phê thượng hạng, chất lượng cao.'),
(5, 'Cà phê hữu cơ', 'Cà phê được trồng và chế biến theo phương pháp hữu cơ.'),
(6, 'Cà phê lạnh', 'Cà phê dạng pha lạnh, giữ được vị ngon nguyên bản.'),
(7, 'Cà phê phin', 'Loại cà phê dùng cho pha phin truyền thống.'),
(8, 'Cà phê espresso', 'Dành cho máy pha cà phê Espresso.'),
(9, 'Cà phê rang xay', 'Các loại cà phê rang xay sẵn, đa dạng hương vị.'),
(10, 'Cà phê decaf', 'Loại cà phê ít caffeine, phù hợp cho người nhạy cảm với caffeine.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `discount_percentage`, `valid_from`, `valid_to`, `usage_limit`) VALUES
(1, 'GIA50', 'Giảm 50k cho đơn hàng trên 500k', 10.00, '2024-03-01', '2024-06-30', 100),
(2, 'FREESHIP', 'Miễn phí vận chuyển cho đơn hàng trên 200k', 5.00, '2024-03-01', '2024-06-30', 200);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `inventory`
--

CREATE TABLE `inventory` (
  `product_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `inventory`
--

INSERT INTO `inventory` (`product_id`, `stock`, `last_updated`) VALUES
(1, 50, '2025-03-19 10:33:15'),
(2, 30, '2025-03-19 10:33:15'),
(3, 100, '2025-03-19 10:33:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','delivered') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 305000.00, 'pending', '2025-03-19 10:33:15'),
(2, 2, 55000.00, 'shipped', '2025-03-19 10:33:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 150000.00),
(2, 1, 2, 1, 130000.00),
(3, 2, 3, 1, 55000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('pending','shipped','delivered','cancelled') NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status_history`
--

INSERT INTO `order_status_history` (`id`, `order_id`, `status`, `changed_at`, `note`) VALUES
(1, 1, 'pending', '2025-03-19 10:33:15', 'Đơn hàng vừa được tạo'),
(2, 2, 'shipped', '2025-03-19 10:33:15', 'Đơn hàng đã được gửi đi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_method` enum('credit_card','paypal','bank_transfer') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `amount`, `payment_date`, `status`) VALUES
(1, 1, 'credit_card', 305000.00, '2025-03-19 10:33:15', 'completed'),
(2, 2, 'paypal', 55000.00, '2025-03-19 10:33:15', 'completed');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `type` enum('hat','bot','goi') NOT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `type`, `origin`, `category_id`, `supplier_id`) VALUES
(1, 'Cà phê Arabica Đà Lạt', 'Cà phê hạt Arabica chất lượng cao từ Đà Lạt.', 150000.00, 'arabica_dalat.jpg', 'hat', 'Việt Nam', 1, 1),
(2, 'Cà phê Robusta Buôn Ma Thuột', 'Cà phê Robusta nổi tiếng từ Tây Nguyên.', 130000.00, 'robusta_bmt.jpg', 'hat', 'Việt Nam', 1, 2),
(3, 'Cà phê hòa tan G7', 'Cà phê hòa tan tiện lợi, hương vị đậm đà.', 55000.00, 'g7_hoatan.jpg', 'goi', 'Việt Nam', 3, 3),
(4, 'Cà phê bột Espresso', 'Dành cho máy pha cà phê Espresso.', 170000.00, 'espresso_bot.jpg', 'bot', 'Ý', 2, 1),
(12, 'Cà phê Espresso', 'Dành cho máy pha cà phê Espresso.', 170000.00, 'espresso.jpg', 'bot', 'Ý', 8, 4),
(13, 'Cà phê Cold Brew', 'Cà phê pha lạnh, giữ vị nguyên bản.', 120000.00, 'coldbrew.jpg', 'goi', 'Việt Nam', 6, 5),
(14, 'Cà phê Phin', 'Cà phê phin truyền thống.', 90000.00, 'caphephin.jpg', 'bot', 'Việt Nam', 7, 6),
(15, 'Cà phê hữu cơ', 'Cà phê trồng theo phương pháp hữu cơ.', 200000.00, 'organic_coffee.jpg', 'hat', 'Colombia', 5, 7),
(16, 'Cà phê decaf', 'Cà phê ít caffeine.', 160000.00, 'decaf_coffee.jpg', 'bot', 'Mỹ', 10, 8),
(17, 'Cà phê Mocha', 'Cà phê vị sô cô la thơm ngon.', 180000.00, 'mocha.jpg', 'goi', 'Brazil', 4, 9),
(18, 'Cà phê Latte', 'Cà phê sữa kiểu Ý.', 175000.00, 'latte.jpg', 'bot', 'Ý', 4, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'Hương vị tuyệt vời, rất thơm!', '2025-03-19 10:33:15'),
(2, 3, 2, 4, 'Pha nhanh, vị hơi ngọt.', '2025-03-19 10:33:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `shipping_method` enum('standard','express','overnight') NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipped_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shipping`
--

INSERT INTO `shipping` (`id`, `order_id`, `shipping_method`, `shipping_cost`, `tracking_number`, `shipped_date`, `delivery_date`) VALUES
(1, 2, 'express', 30000.00, 'VN123456789', '2025-03-19 17:33:15', '2025-03-22 17:33:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_name` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_name`, `contact_email`, `phone`, `address`) VALUES
(1, 'Cà Phê Trung Nguyên', 'Nguyễn Văn Hùng', 'hung@trungnguyen.vn', '0905123456', '123 Lê Lợi, Quận 1, TP.HCM'),
(2, 'Highlands Coffee', 'Trần Minh Tuấn', 'tuan@highlands.vn', '0906789123', '456 Trần Hưng Đạo, Quận 5, TP.HCM'),
(3, 'Vinacafe', 'Lê Thanh Sơn', 'son@vinacafe.vn', '0912345678', '789 Nguyễn Trãi, Quận 3, TP.HCM'),
(4, 'Nestlé', 'Lý Thanh Bình', 'binh@nestle.vn', '0987654321', '234 Lạc Long Quân, Quận Tân Bình, TP.HCM'),
(5, 'Phúc Long', 'Vũ Thị Hạnh', 'hanh@phuclong.vn', '0975312468', '567 Nguyễn Thị Minh Khai, Quận 1, TP.HCM'),
(6, 'K-Coffee', 'Bùi Văn Nam', 'nam@kcoffee.vn', '0912456789', '789 Lý Thường Kiệt, Quận 10, TP.HCM'),
(7, 'King Coffee', 'Phan Hải An', 'an@kingcoffee.vn', '0901122334', '135 Bùi Viện, Quận 1, TP.HCM'),
(8, 'Coffee House', 'Lê Hoàng Lâm', 'lam@coffeehouse.vn', '0934567890', '222 Đinh Tiên Hoàng, Bình Thạnh, TP.HCM'),
(9, 'Amazon Coffee', 'Nguyễn Văn Tùng', 'tung@amazoncoffee.vn', '0923456781', '555 Tô Hiến Thành, Quận 10, TP.HCM'),
(10, 'TNI King Coffee', 'Đỗ Minh Hoàng', 'hoang@tnikingcoffee.vn', '0911223344', '666 Võ Văn Kiệt, Quận 5, TP.HCM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'nguyenvana', 'hashed_password_123', 'nguyenvana@gmail.com', 'customer'),
(2, 'tranthib', 'hashed_password_456', 'tranthib@yahoo.com', 'customer'),
(3, 'admin', 'hashed_admin_password', 'admin@coffee.vn', 'admin'),
(4, 'lethihuyen', 'hashed_password_234', 'lethihuyen@gmail.com', 'customer'),
(5, 'hoangminhduc', 'hashed_password_567', 'hoangminhduc@gmail.com', 'customer'),
(6, 'nguyenhuyenanh', 'hashed_password_890', 'nguyenhuyenanh@gmail.com', 'customer'),
(7, 'dangthuytrang', 'hashed_password_111', 'dangthuytrang@gmail.com', 'customer'),
(8, 'phanhoangnam', 'hashed_password_222', 'phanhoangnam@gmail.com', 'customer'),
(9, 'admin1', 'hashed_admin_password', 'admin1@coffee.vn', 'admin'),
(10, 'admin2', 'hashed_admin_password', 'admin2@coffee.vn', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `added_at`) VALUES
(1, 1, 1, '2025-03-19 10:33:15'),
(2, 1, 3, '2025-03-19 10:33:15');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Chỉ mục cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
