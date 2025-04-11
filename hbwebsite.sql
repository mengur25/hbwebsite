-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 12:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hbwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--
CREATE DATABASE IF NOT EXISTS hbwebsite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'ynwebdev', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(54, 58, 'Luxury Room', 200, 400, 'a4', 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(55, 59, 'Deluxe Room', 170, 680, NULL, 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(61, 65, 'Single Room', 45, 135, 'a1', 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(62, 66, 'Deluxe Room', 170, 510, NULL, 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(63, 67, 'Luxury Room', 200, 400, 'a3', 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(64, 68, 'Single Room', 45, 180, NULL, 'Duong Ngoc Khoi Nguyen', '124778324', '123, abc'),
(65, 69, 'Deluxe Room', 170, 510, 'a6', 'nd', '124778324', '123, abc'),
(66, 70, 'Deluxe Room', 170, 340, NULL, 'nd', '124778324', '123, abc'),
(67, 71, 'Luxury Room', 200, 200, 'a8', 'nd', '124778324', '123, abc'),
(68, 72, 'Luxury Room', 200, 600, 'a7', 'nd', '124778324', '123, abc'),
(69, 73, 'Single Room', 45, 45, NULL, 'Bui Thi Thanh Ngan', '1242838221', '123, xyz'),
(70, 74, 'Single Room', 45, 90, NULL, 'Bui Thi Thanh Ngan', '1242838221', '123, xyz'),
(71, 75, 'Single Room', 45, 90, NULL, 'nd', '124778324', '123, abc'),
(72, 76, 'Luxury Room', 200, 800, NULL, 'nd', '124778324', '123, abc'),
(73, 77, 'Deluxe Room', 170, 510, NULL, 'nd', '124778324', '123, abc'),
(74, 78, 'Single Room', 45, 225, NULL, 'nd', '124778324', '123, abc'),
(75, 79, 'Deluxe Room', 170, 340, NULL, 'nd', '124778324', '123, abc'),
(76, 80, 'Deluxe Room', 170, 510, NULL, 'nd', '124778324', '123, abc'),
(77, 81, 'Luxury Room', 200, 200, NULL, 'nd', '124778324', '123, abc'),
(78, 82, 'Luxury Room', 200, 200, NULL, 'nd', '124778324', '123, abc'),
(79, 83, 'Luxury Room', 200, 400, NULL, 'nd', '124778324', '123, abc'),
(80, 84, 'Luxury Room', 200, 200, NULL, 'nd', '124778324', '123, abc'),
(81, 85, 'Single Room', 45, 360, NULL, 'nd', '124778324', '123, abc'),
(82, 86, 'Luxury Room', 200, 200, NULL, 'nd', '124778324', '123, abc'),
(83, 87, 'Luxury Room', 200, 600, NULL, 'nd', '124778324', '123, abc'),
(84, 88, 'Deluxe Room', 170, 340, NULL, 'nd', '124778324', '123, abc'),
(85, 89, 'Single Room', 45, 495, NULL, 'nd', '124778324', '123, abc'),
(86, 90, 'Single Room', 45, 135, NULL, 'nd', '124778324', '123, abc'),
(87, 91, 'Single Room', 45, 90, NULL, 'nd', '124778324', '123, abc'),
(88, 92, 'Single Room', 45, 135, NULL, 'nd', '124778324', '123, abc'),
(89, 93, 'Single Room', 45, 180, NULL, 'nd', '124778324', '123, abc'),
(90, 94, 'Single Room', 45, 135, NULL, 'nd', '124778324', '123, abc'),
(91, 95, 'Luxury Room', 200, 400, NULL, 'Bui Thi Thanh Ngan', '1242838221', '123, xyz'),
(92, 96, 'Single Room', 45, 45, NULL, 'nd', '124778324', '123, abc'),
(93, 97, 'Single Room', 45, 45, NULL, 'nd', '124778324', '123, abc'),
(94, 98, 'Single Room', 45, 45, NULL, 'nd', '124778324', '123, abc'),
(95, 99, 'Single Room', 45, 45, NULL, 'nd', '124778324', '123, abc');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'pending',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amt` int(11) NOT NULL,
  `trans_status` varchar(150) NOT NULL DEFAULT 'pending',
  `trans_resp_msg` varchar(200) DEFAULT NULL,
  `rate_review` int(11) DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_msg`, `rate_review`, `datentime`) VALUES
(58, 11, 3, '2025-03-29', '2025-03-31', 0, 1, 'cancelled', 'ORD_11_76426', 'COD_ORD_11_76426', 10000000, '0', 'Payment on COD', NULL, '2025-03-29 07:28:30'),
(59, 11, 4, '2025-03-29', '2025-04-02', 0, 1, 'cancelled', 'ORD_11_42556', '14877468', 17000000, '00', 'Giao dịch VNPAY thành công', NULL, '2025-03-29 07:29:00'),
(65, 11, 6, '2025-03-29', '2025-04-01', 0, 1, 'cancelled', 'ORD_11_20868', '14877478', 3375000, '00', 'Giao dịch VNPAY thành công', NULL, '2025-03-29 07:47:38'),
(66, 11, 4, '2025-03-30', '2025-04-02', 0, NULL, 'failed', 'ORD_11_36439', '0', 12750000, '24', 'Người dùng hủy giao dịch', NULL, '2025-03-29 19:59:00'),
(67, 11, 3, '2025-03-29', '2025-03-31', 1, NULL, 'booked', 'ORD_11_15761', 'COD_ORD_11_15761', 10000000, '0', 'Payment on COD', 1, '2025-03-29 21:15:42'),
(68, 11, 6, '2025-03-30', '2025-04-03', 0, 1, 'cancelled', 'ORD_11_37140', 'COD_ORD_11_37140', 4500000, '0', 'Payment on COD', NULL, '2025-03-30 10:02:17'),
(69, 11, 4, '2025-04-02', '2025-04-05', 1, NULL, 'booked', 'ORD_11_32486', 'COD_ORD_11_32486', 12750000, '0', 'Payment on COD', 1, '2025-03-31 19:18:22'),
(70, 11, 4, '2025-04-01', '2025-04-03', 0, 1, 'cancelled', 'ORD_11_56227', 'COD_ORD_11_56227', 8500000, '0', 'Payment on COD', NULL, '2025-03-31 19:22:26'),
(71, 11, 3, '2025-04-02', '2025-04-03', 0, NULL, 'booked', 'ORD_11_76181', '14882599', 5000000, '00', 'Giao dịch VNPAY thành công', NULL, '2025-03-31 19:27:04'),
(72, 11, 3, '2025-04-01', '2025-04-04', 1, NULL, 'booked', 'ORD_11_88763', 'COD_ORD_11_88763', 15000000, '0', 'Payment on COD', 1, '2025-03-31 19:29:11'),
(73, 15, 6, '2025-04-11', '2025-04-12', 0, NULL, 'pending', 'ORD_15_94243', '', 1125000, '0', '', NULL, '2025-04-02 09:01:56'),
(74, 15, 6, '2025-04-10', '2025-04-12', 0, 1, 'cancelled', 'ORD_15_99965', 'COD_ORD_15_99965', 2250000, '0', 'Payment on COD', NULL, '2025-04-02 09:02:34'),
(75, 11, 6, '2025-04-08', '2025-04-10', 0, NULL, 'pending', 'ORD_11_84084', '', 2250000, '0', '', NULL, '2025-04-02 09:47:50'),
(76, 11, 3, '2025-04-05', '2025-04-09', 0, NULL, 'pending', 'ORD_11_72982', '', 20000000, '0', '', NULL, '2025-04-05 07:38:03'),
(77, 11, 4, '2025-04-05', '2025-04-08', 0, NULL, 'pending', 'ORD_11_29858', '', 12750000, '0', '', NULL, '2025-04-05 07:39:06'),
(78, 11, 6, '2025-04-11', '2025-04-16', 0, 0, 'cancelled', 'ORD_11_65620', 'COD_ORD_11_65620', 5625000, '0', 'Payment on COD', NULL, '2025-04-05 07:41:40'),
(79, 11, 4, '2025-04-05', '2025-04-07', 0, NULL, 'pending', 'ORD_11_16864', '', 8500000, '0', '', NULL, '2025-04-05 07:47:07'),
(80, 11, 4, '2025-04-05', '2025-04-08', 0, NULL, 'pending', 'ORD_11_18366', '', 12750000, '0', '', NULL, '2025-04-05 07:51:49'),
(81, 11, 3, '2025-04-06', '2025-04-07', 0, NULL, 'pending', 'ORD_11_13361', '', 5000000, '0', '', NULL, '2025-04-05 08:05:47'),
(82, 11, 3, '2025-04-07', '2025-04-08', 0, NULL, 'pending', 'ORD_11_87881', '', 5000000, '0', '', NULL, '2025-04-05 08:08:45'),
(83, 11, 3, '2025-04-07', '2025-04-09', 0, NULL, 'pending', 'ORD_11_79302', '', 10000000, '0', '', NULL, '2025-04-05 08:15:02'),
(84, 11, 3, '2025-04-06', '2025-04-07', 0, NULL, 'pending', 'ORD_11_28348', '', 5000000, '0', '', NULL, '2025-04-05 08:25:01'),
(85, 11, 6, '2025-04-08', '2025-04-16', 0, NULL, 'pending', 'ORD_11_35411', '', 9000000, '0', '', NULL, '2025-04-05 08:30:53'),
(86, 11, 3, '2025-04-07', '2025-04-08', 0, NULL, 'pending', 'ORD_11_66402', '', 5000000, '0', '', NULL, '2025-04-05 08:31:34'),
(87, 11, 3, '2025-04-05', '2025-04-08', 0, NULL, 'pending', 'ORD_11_22868', '', 15000000, '0', '', NULL, '2025-04-05 09:05:03'),
(88, 11, 4, '2025-04-05', '2025-04-07', 0, NULL, 'pending', 'ORD_11_16498', '', 8500000, '0', '', NULL, '2025-04-05 09:39:52'),
(89, 11, 6, '2025-04-05', '2025-04-16', 0, NULL, 'pending', 'ORD_11_85135', '', 12375000, '0', '', NULL, '2025-04-05 09:42:48'),
(90, 11, 6, '2025-04-05', '2025-04-08', 0, NULL, 'pending', 'ORD_11_98059', '', 3375000, '0', '', NULL, '2025-04-05 09:58:39'),
(91, 11, 6, '2025-04-06', '2025-04-08', 0, NULL, 'pending', 'ORD_11_94178', '', 2250000, '0', '', NULL, '2025-04-05 10:01:40'),
(92, 11, 6, '2025-04-06', '2025-04-09', 0, NULL, 'pending', 'ORD_11_47519', '', 3375000, '0', '', NULL, '2025-04-05 10:03:02'),
(93, 11, 6, '2025-04-05', '2025-04-09', 0, NULL, 'pending', 'ORD_11_77486', '', 4500000, '0', '', NULL, '2025-04-05 10:05:37'),
(94, 11, 6, '2025-04-05', '2025-04-08', 0, NULL, 'pending', 'ORD_11_84254', '', 3375000, '0', '', NULL, '2025-04-05 10:06:02'),
(95, 15, 3, '2025-04-06', '2025-04-08', 0, NULL, 'pending', 'ORD_15_80193', '', 10000000, '0', '', NULL, '2025-04-05 13:02:11'),
(96, 11, 6, '2025-04-06', '2025-04-07', 0, NULL, 'pending', 'ORD_11_54509', '', 1125000, '0', '', NULL, '2025-04-05 14:01:28'),
(97, 11, 6, '2025-04-07', '2025-04-08', 0, NULL, 'booked', 'ORD_11_55360', '14891185', 1125000, '00', 'Giao dịch VNPAY thành công', NULL, '2025-04-05 14:07:24'),
(98, 11, 6, '2025-04-06', '2025-04-07', 0, NULL, 'pending', 'ORD_11_58063', '', 1125000, '0', '', NULL, '2025-04-05 16:01:14'),
(99, 11, 6, '2025-04-08', '2025-04-09', 0, NULL, 'booked', 'ORD_11_77246', '14895360', 1125000, '00', 'Giao dịch VNPAY thành công', NULL, '2025-04-08 15:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(3, 'IMG_81534.png'),
(4, 'IMG_20332.png'),
(5, 'IMG_58560.png'),
(6, 'IMG_95856.png'),
(7, 'IMG_61298.png'),
(8, 'IMG_96364.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gmap` varchar(100) NOT NULL,
  `pn1` varchar(30) NOT NULL,
  `pn2` varchar(30) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `tiktok` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `iframe` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `tiktok`, `facebook`, `instagram`, `iframe`) VALUES
(1, 'XYZ, Thanh Khe, Da Nang', 'https://maps.app.goo.gl/4CQgmFHTYSmZeYnb7', '84 913268937', '84 913627204', 'ask@ynwebdev.com', 'https://www.tiktok.com/', 'https://web.facebook.com/', 'https://www.instagram.com/', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d245374.12686233877!2d107.91381949002366!3d16.067008501823576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219c792252a13:0x1df0cb4b86727e06!2zxJDDoCBO4bq1bmcsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1741011957626!5m2!1svi!2s');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `icon`, `description`) VALUES
(7, 'Wifi', 'IMG_41393.svg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!'),
(8, 'Air-Condition', 'IMG_76765.svg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!'),
(9, 'Heater', 'IMG_75841.svg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!'),
(10, 'Spa', 'IMG_25040.svg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!'),
(11, 'TV', 'IMG_48917.svg', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(5, 'Bedrooms'),
(7, 'Balcony'),
(8, 'Kitchen');

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(1, 72, 3, 11, 5, 'Very good', 0, '2025-04-09 14:52:58'),
(2, 69, 4, 11, 5, 'Very good.', 0, '2025-04-09 14:55:04'),
(3, 67, 3, 11, 5, 'hahaaa', 0, '2025-04-09 14:59:01');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(1, 'Simple Room', 123, 125, 56, 5, 2, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!', 1, 1),
(2, 'Single Room', 123, 123, 56, 4, 3, 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem sint sequi aliquam animi soluta!', 1, 1),
(3, 'Luxury Room', 120, 200, 2, 8, 6, 'This is the most luxury room in our hotel.', 1, 0),
(4, 'Deluxe Room', 100, 170, 8, 6, 4, 'Our Deluxe room.', 1, 0),
(5, 'Single Room', 80, 150, 12, 5, 3, 'This is our Single Room.', 1, 1),
(6, 'Single Room', 56, 45, 12, 4, 4, 'This is our single room', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(24, 4, 7),
(25, 4, 8),
(26, 4, 10),
(27, 4, 11),
(41, 6, 7),
(42, 6, 8),
(43, 6, 11),
(44, 3, 7),
(45, 3, 8),
(46, 3, 9),
(47, 3, 10),
(48, 3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(13, 4, 5),
(14, 4, 7),
(15, 4, 8),
(22, 6, 5),
(23, 6, 7),
(24, 3, 5),
(25, 3, 7),
(26, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`sr_no`, `room_id`, `image`, `thumb`) VALUES
(15, 3, 'IMG_93465.png', 0),
(16, 3, 'IMG_82399.jpg', 0),
(18, 4, 'IMG_57234.png', 1),
(19, 4, 'IMG_32709.png', 0),
(22, 4, 'IMG_38311.png', 0),
(23, 3, 'IMG_15862.png', 1),
(24, 6, 'IMG_38641.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'YN HOTEL', 'About us. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et praesentium quia tempore, facere distinctio maxime exercitationem corporis, ut possimus temporibus id? Delectus accusantium amet exercitationem', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_details`
--

INSERT INTO `team_details` (`sr_no`, `name`, `picture`) VALUES
(39, 'mui mui', 'IMG_92920.jpg'),
(40, 'ken', 'IMG_86190.jpg'),
(41, 'phay phay', 'IMG_38909.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datentime`) VALUES
(11, 'nd', 'nguyenduong939705@gmail.com', '123, abc', '124778324', '123', '2005-12-04', 'IMG_21900.png', '$2y$10$0kvhw70S14Z4QaylXFteEuxENJ.pR4rsMOirlKY1H7yNTDS0KloUq', 1, NULL, '0000-00-00', 1, '2025-03-23 17:28:20'),
(15, 'Bui Thi Thanh Ngan', 'buithithanhngan13579@gmail.com', '123, xyz', '1242838221', '1234', '2005-04-05', 'IMG_35539.png', '$2y$10$z/Hdc8/OTVP2CbnFzTi/KOml.2FdglR4Grl/hRVx8/w5Mc.HcL7um', 1, '3f48a306817a527c65fd6e9c8162ef26', '0000-00-00', 1, '2025-03-25 13:19:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `date`, `seen`) VALUES
(33, 'ppp', 'email@gmail.com', 'abc', 'qwertyuioppoiuytrew', '2025-03-07', 1),
(34, 'da', 'ask@ynwebdev.com', 'abc', 'sdfhjkdsnhfsld', '2025-03-07', 1),
(35, 'ttt', 'ask@ynwebdev.com', 'wert', 'qwerty876543', '2025-03-09', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room id` (`room_id`),
  ADD KEY `facilities id` (`facilities_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `rm id` (`room_id`),
  ADD KEY `features id` (`features_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
