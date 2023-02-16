-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: db
-- Thời gian đã tạo: Th2 16, 2023 lúc 07:44 AM
-- Phiên bản máy phục vụ: 8.0.32
-- Phiên bản PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mydb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `user_email`, `user_password`, `user_name`, `user_active`) VALUES
(1, 'example@gmail.com', '$2y$10$iN7RlXhrCwvGMS/TWmxBCeXNRAo3bnW.RJunHc6NMzbPV8fHsTHWe', 'example', 'Y');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `works`
--

CREATE TABLE `works` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `work_name` varchar(255) NOT NULL,
  `work_content` text,
  `work_start_date` datetime NOT NULL,
  `work_end_date` datetime NOT NULL,
  `work_insert_date` datetime NOT NULL,
  `work_status` enum('planning','doing','complete') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `works`
--

INSERT INTO `works` (`id`, `user_id`, `work_name`, `work_content`, `work_start_date`, `work_end_date`, `work_insert_date`, `work_status`) VALUES
(3, 1, 'Work Name', 'Work Name', '2023-02-03 19:23:00', '2023-02-25 21:23:00', '2023-02-16 00:00:00', 'planning'),
(4, 1, 'Work Name', 'qưeqwe', '2023-02-15 14:35:00', '2023-02-18 14:35:00', '2023-02-16 00:00:00', 'planning'),
(5, 1, 'Work Name', 'Work Content', '2023-02-01 14:37:00', '2023-02-18 14:37:00', '2023-02-16 00:00:00', 'planning'),
(6, 1, 'Work Name', 'Work Content', '2023-02-02 14:37:00', '2023-02-12 14:37:00', '2023-02-16 00:00:00', 'planning');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `works`
--
ALTER TABLE `works`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
