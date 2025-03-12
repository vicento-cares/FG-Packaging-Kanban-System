-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 01:31 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fg_packaging`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `name`, `role`, `date_updated`) VALUES
(1, 'admin', 'admin', 'Admin', 'Admin', '2023-03-07 13:36:00'),
(2, 'fg', 'fg', 'FG', 'FG', '2023-03-07 13:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `car_model`
--

CREATE TABLE `car_model` (
  `id` int(10) UNSIGNED NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_model`
--

INSERT INTO `car_model` (`id`, `car_model`, `date_updated`) VALUES
(1, 'Daihatsu', '2023-02-03 14:51:32'),
(2, 'Daihatsu D01L', '2023-02-03 14:51:32'),
(3, 'Daihatsu D92', '2023-02-03 14:51:32'),
(4, 'Honda', '2023-02-03 14:51:33'),
(5, 'Honda TKRA', '2023-02-03 14:51:33'),
(6, 'Honda T20A', '2023-02-03 14:51:33'),
(7, 'Honda TG7', '2023-02-03 14:51:33'),
(8, 'Honda 3M0A', '2023-02-03 14:51:33'),
(9, 'Honda 3TOA', '2023-02-03 14:51:33'),
(10, 'Honda 30AA', '2023-02-03 14:51:33'),
(11, 'Honda RDX', '2023-02-03 14:51:33'),
(12, 'Honda MDX', '2023-02-03 14:51:33'),
(13, 'Mazda', '2023-02-03 14:51:33'),
(14, 'Mazda J12', '2023-02-03 14:51:33'),
(15, 'Mazda Merge', '2023-02-03 14:51:33'),
(16, 'Mazda J30A', '2023-02-03 14:51:34'),
(17, 'Mazda J20E', '2023-02-03 14:51:34'),
(18, 'Nissan/Marelli', '2023-02-03 14:51:34'),
(19, 'Subaru', '2023-02-03 14:51:34'),
(20, 'Suzuki', '2023-02-03 14:51:34'),
(21, 'Suzuki Y2R', '2023-02-03 14:51:34'),
(22, 'Suzuki YD1', '2023-02-03 14:51:34'),
(23, 'Toyota', '2023-02-03 14:51:34'),
(24, 'Toyota 700B', '2023-02-03 14:51:34'),
(25, 'Yamaha', '2023-02-03 14:51:34'),
(26, 'Yamaha Y68', '2023-02-03 14:51:35'),
(27, 'FG', '2023-02-13 13:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `factory_area`
--

CREATE TABLE `factory_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `factory_area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `factory_area`
--

INSERT INTO `factory_area` (`id`, `factory_area`, `date_updated`) VALUES
(1, 'FAS 1', '2023-02-03 13:49:31'),
(2, 'FAS 2', '2023-02-03 13:49:31'),
(3, 'FAS 3', '2023-02-03 13:49:31'),
(4, 'Annex', '2023-02-03 13:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `safety_stock` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_no`, `item_name`, `storage_area`, `quantity`, `safety_stock`) VALUES
(1, '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 'FG Area', 995, 200),
(5, '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 'FG Area', 1884, 100),
(9, '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', 'FG Area', 2563, 100),
(13, '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 'FG Area', 1700, 100),
(17, '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 'FG Area', 200, 100),
(21, '00011', 'CARTON COVER (1180X1100X80mm)', 'FG Area', 1990, 10),
(25, '00012', 'Carton Cover with print L (1220x1150x80mm)', 'FG Area', 240, 10),
(29, '00013', 'Carton Cover with print M (1150x1150x80mm)', 'FG Area', 510, 10),
(33, '00014', 'Carton Cover with print XL (1395x980x90mm)', 'FG Area', 980, 10),
(37, '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 'FG Area', 6500, 500),
(41, '00016', 'Master Box DW BE Flute - Body', 'FG Area', 5630, 10),
(45, '00017', 'Master Box DW BE Flute - U-pad', 'FG Area', 4285, 25),
(49, '00018', 'Master Box with Print L (740x426x230mm)', 'FG Area', 500, 10),
(53, '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 'FG Area', 180, 10),
(57, '00020', 'Master Box with Print M (615x390x210mm)', 'FG Area', 445, 10),
(61, '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'FG Area', 4995, 10),
(65, '00023', 'Packaging Tape - Paramount -Size: 2\"', 'FG Area', 390, 6),
(69, '00024', 'Pads L (670x370mm)', 'FG Area', 2537, 50),
(73, '00025', 'Pads M (555x325mm)', 'FG Area', 1300, 50),
(77, '00026', 'Pads XL (845x420mm)', 'FG Area', 0, 50),
(81, '00028', 'PE Bag (700mmx930mm)', 'FG Area', 2853, 100),
(85, '00029', 'Plastic Buckles/Clip', 'FG Area', 32800, 200),
(89, '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', 'FG Area', 0, 1),
(93, '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'FG Area', 499, 1),
(97, '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'FG Area', 0, 1),
(101, '00033', 'Shipping Card Case 100mmx224mm', 'FG Area', 800, 100),
(105, '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'FG Area', 992, 4),
(109, '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 'FG Area', 2320, 10),
(113, '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'FG Area', 1243, 5),
(117, '00037', 'Pilot Body', 'FG Area', 499, 1),
(121, '00038', 'Pilot Cover', 'FG Area', 39, 1),
(125, '00039', 'Pilot Pallet', 'FG Area', 114, 1),
(129, '00040', 'Kraft Paper (515x1080)', 'FG Area', 1400, 200),
(133, '00041', 'Triwall Body (1330x1120x665mm)', 'FG Area', 35, 1),
(137, '00042', 'Kraft Paper (1320x1130mm)', 'FG Area', 800, 200),
(141, '00043', 'PE Plastic 12x18 100\'s', 'FG Area', 1500, 100),
(145, '00044', 'Ordinary Plastic (10x15)', 'FG Area', 2800, 100),
(149, '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'FG Area', 0, 1000),
(153, '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'FG Area', 980, 20),
(157, '00048', 'Master Box with Print (650x350x260mm) - RDX', 'FG Area', 0, 10),
(161, '00049', 'Master Box DW (820X360X210) - TUNDRA', 'FG Area', 0, 10),
(165, '00050', 'Pads (810X350mm) - TUNDRA', 'FG Area', 990, 10),
(169, '00051', 'Wood Pallet (1120x840x120) - TUNDRA', 'FG Area', 0, 1),
(173, '00052', 'MASTER BOX SMALL DW 465X355X230', 'FG Area', 100, 10),
(177, '00053', 'Pads S (400X290MM)', 'FG Area', 925, 50),
(181, '00054', 'Bubble Sheet (350x1200)', 'FG Area', 0, 100),
(185, '00055', 'Shipping Label Case (Blue)', 'FG Area', 0, 100),
(189, '00056', 'Polycard Case (White)', 'FG Area', 800, 100),
(193, '00057', 'Aguila 6x10', 'FG Area', 15700, 100);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dimension` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `size` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `color` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `pcs_bundle` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `req_quantity` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_no`, `item_name`, `dimension`, `size`, `color`, `pcs_bundle`, `req_quantity`, `date_updated`) VALUES
(1, '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', '150X140MMX9.6MM', 'N/A', 'Clear', '200 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(2, '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', '1400mmx1400mm, PBS 9.6mm, 2ply', 'L', 'Clear', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(3, '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', '1000mmx1200mm, PBS 9.6mm, 2ply', 'M', 'Clear', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(4, '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', '650mmx550mm, PBS 9.6mm, 2ply', 'S', 'Clear', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(5, '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', '410mmx300mm, PBS 9.6mm, 2ply', 'XS', 'Clear', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(6, '00011', 'CARTON COVER (1180X1100X80mm)', '1180X1100X80mm', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(7, '00012', 'Carton Cover with print L (1220x1150x80mm)', '1220x1150x80mm', 'L', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(8, '00013', 'Carton Cover with print M (1150x1150x80mm)', '1150x1150x80mm', 'M', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(9, '00014', 'Carton Cover with print XL (1395x980x90mm)', '1395x980x90mm', 'XL', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(10, '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', '570 x 650mm', 'N/A', 'N/A', '500 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(11, '00016', 'Master Box DW BE Flute - Body', 'N/A', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(12, '00017', 'Master Box DW BE Flute - U-pad', 'N/A', 'N/A', 'N/A', '25 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(13, '00018', 'Master Box with Print L (740x426x230mm)', '740x426x230mm', 'L', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(14, '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', '682x382x200mm', 'L', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(15, '00020', 'Master Box with Print M (615x390x210mm)', '615x390x210mm', 'M', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(16, '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', '542x352x180mm', 'M', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(17, '00023', 'Packaging Tape - Paramount -Size: 2\"', 'N/A', '2\"', 'N/A', '6 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(18, '00024', 'Pads L (670x370mm)', '670x370mm', 'L', 'N/A', '50 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(19, '00025', 'Pads M (555x325mm)', '555x325mm', 'M', 'N/A', '50 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(20, '00026', 'Pads XL (845x420mm)', '845x420mm', 'XL', 'N/A', '50 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(21, '00028', 'PE Bag (700mmx930mm)', '700mmx930mm', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(22, '00029', 'Plastic Buckles/Clip', 'N/A', 'N/A', 'N/A', '200 pcs', 'per bag', '2022-11-26 13:07:18'),
(23, '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', '1110 x 1180 x 130, 4-way entry', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(24, '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', '15.5mmx2500m', 'N/A', 'Yellow', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(25, '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'N/A', 'M', 'N/A', '1 kg', 'per kilo', '2022-11-26 13:07:18'),
(26, '00033', 'Shipping Card Case 100mmx224mm', '100mmx224mm', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(27, '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', '20micx500MMx300Mx3\"C', 'N/A', 'N/A', '4 pcs/box', 'per Pcs', '2022-11-26 13:07:18'),
(28, '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', '582x355x55mm', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(29, '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'N/A', '1x50\"', 'Clear', '5 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(30, '00037', 'Pilot Body', 'N/A', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(31, '00038', 'Pilot Cover', 'N/A', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(32, '00039', 'Pilot Pallet', 'N/A', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(33, '00040', 'Kraft Paper (515x1080)', '515x1080', 'N/A', 'N/A', '200 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(34, '00041', 'Triwall Body (1330x1120x665mm)', '1330x1120x665mm', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(35, '00042', 'Kraft Paper (1320x1130mm)', '1320x1130mm', 'N/A', 'N/A', '200 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(36, '00043', 'PE Plastic 12x18 100\'s', '12x18', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(37, '00044', 'Ordinary Plastic (10x15)', '10x15', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(38, '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'N/A', 'N/A', 'N/A', '1000 pcs/box', 'per box', '2022-11-26 13:07:18'),
(39, '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', '50mm x 50mm x 885mm x 5mm', 'N/A', 'N/A', '20 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(40, '00048', 'Master Box with Print (650x350x260mm) - RDX', '650x350x260mm', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(41, '00049', 'Master Box DW (820X360X210) - TUNDRA', '820X360X210', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(42, '00050', 'Pads (810X350mm) - TUNDRA', '810X350mm', 'N/A', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(43, '00051', 'Wood Pallet (1120x840x120) - TUNDRA', '1120x840x120', 'N/A', 'N/A', '1 pc', 'per Pcs', '2022-11-26 13:07:18'),
(44, '00052', 'MASTER BOX SMALL DW 465X355X230', '465X355X230', 'S', 'N/A', '10 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(45, '00053', 'Pads S (400X290MM)', '400X290MM', 'S', 'N/A', '50 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(46, '00054', 'Bubble Sheet (350x1200)', '350x1200', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(47, '00055', 'Shipping Label Case (Blue)', 'N/A', 'N/A', 'Blue', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(48, '00056', 'Polycard Case (White)', 'N/A', 'N/A', 'White', '100 pcs', 'per Pcs', '2022-11-26 13:07:18'),
(49, '00057', 'Aguila 6x10', '6x10', 'N/A', 'N/A', '100 pcs', 'per Pcs', '2022-11-26 13:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `kanban_history`
--

CREATE TABLE `kanban_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban_no` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `truck_no` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `requestor_id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scan_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `request_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `store_out_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `store_out_person` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kanban_history`
--

INSERT INTO `kanban_history` (`id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `truck_no`, `requestor_id_no`, `requestor_name`, `requestor`, `scan_date_time`, `request_date_time`, `store_out_date_time`, `store_out_person`, `status`, `is_read`) VALUES
(1, 'REQ:23020104ffc5e', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section1_5101_FA_200_00002_230201162213', 1, 'SN-a262300002c127c', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-01 16:49:17', '2023-02-01 16:49:18', '2023-02-01 16:49:52', 'Admin', 'Stored Out', 1),
(2, 'REQ:2302021108340', 'Aguila6x10_Section1_5101_FA_100_00057_230201162213', 1, 'SN-241ef0005741a8e', '00057', 'Aguila 6x10', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-02 11:30:50', '2023-02-02 11:30:51', '2023-02-02 14:07:32', 'Admin', 'Stored Out', 1),
(3, 'REQ:2302030972d87', 'KraftPaper/InterLayerSheet(570x650mm)140g_Section1_5101_FA_500_00015_230201162213', 1, 'SN-bca0600015273bc', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', '5101', 500, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 09:34:32', '2023-02-03 09:35:42', '2023-02-03 09:41:54', 'Admin', 'Stored Out', 1),
(4, 'REQ:2302030972d87', 'KraftPaper(515x1080)_Section1_5101_FA_200_00040_230201162213', 1, 'SN-98eaf000403dd1c', '00040', 'Kraft Paper (515x1080)', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 09:35:05', '2023-02-03 09:35:42', '2023-02-03 09:41:55', 'Admin', 'Stored Out', 1),
(5, 'REQ:2302030972d87', 'KraftPaper(1320x1130mm)_Section1_5101_FA_200_00042_230201162213', 1, 'SN-40372000428c1c8', '00042', 'Kraft Paper (1320x1130mm)', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 09:35:23', '2023-02-03 09:35:42', '2023-02-03 09:41:55', 'Admin', 'Stored Out', 1),
(6, 'REQ:23020310754fd', 'ShippingCardCase100mmx224mm_Section1_5101_FA_100_00033_230201162213', 1, 'SN-d8114000338c27d', '00033', 'Shipping Card Case 100mmx224mm', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 10:28:31', '2023-02-03 10:28:33', '2023-02-03 10:29:40', 'Admin', 'Stored Out', 1),
(7, 'REQ:23020310f26e5', 'OrdinaryPlastic(10x15)_Section1_5101_FA_100_00044_230201162213', 1, 'SN-a0e4500044c796a', '00044', 'Ordinary Plastic (10x15)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 10:33:46', '2023-02-03 10:33:47', '2023-02-03 10:35:01', 'Admin', 'Stored Out', 1),
(8, 'REQ:2302031058376', 'PEBag(700mmx930mm)_Section1_5101_FA_100_00028_230201162213', 1, 'SN-7685b0002874e45', '00028', 'PE Bag (700mmx930mm)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 10:52:28', '2023-02-03 10:52:38', '2023-02-04 14:34:00', 'Admin', 'Stored Out', 1),
(9, 'REQ:2302031058376', 'PlasticBuckles/Clip_Section1_5101_FA_200_00029_230201162213', 1, 'SN-7e3b2000293a857', '00029', 'Plastic Buckles/Clip', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 10:52:35', '2023-02-03 10:52:38', '2023-02-04 14:34:00', 'Admin', 'Stored Out', 1),
(10, 'REQ:230204014720e', 'MASTERBOXSMALLDW465X355X230_Section1_5101_FA_10_00052_230201162213', 1, 'SN-eb87c00052ee2a3', '00052', 'MASTER BOX SMALL DW 465X355X230', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 13:16:34', '2023-02-04 13:18:05', '2023-02-04 14:37:39', 'Admin', 'Stored Out', 1),
(11, 'REQ:230204014720e', 'PadsS(400X290MM)_Section1_5101_FA_50_00053_230201162213', 1, 'SN-a0fa500053d5da4', '00053', 'Pads S (400X290MM)', '5101', 50, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 13:18:03', '2023-02-04 13:18:05', '2023-02-04 14:37:39', 'Admin', 'Stored Out', 1),
(12, 'REQ:23020303af1e5', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00009_230201162213', 1, 'SN-7cd2a00009e3ee6', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-03 15:59:05', '2023-02-03 15:59:31', '2023-02-08 16:33:41', 'Admin', 'Stored Out', 1),
(13, 'REQ:23020209886e2', 'CartonCoverwithprintXL(1395x980x90mm)_Section1_5101_FA_10_00014_230201162213', 1, 'SN-3148b0001485f2f', '00014', 'Carton Cover with print XL (1395x980x90mm)', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-02 09:50:17', '2023-02-02 09:50:19', '2023-02-10 08:20:08', 'Admin', 'Stored Out', 1),
(14, 'REQ:230204035ff26', 'PadsL(670x370mm)_Section1_5101_FA_50_00024_230201162213', 1, 'SN-8331600024927ed', '00024', 'Pads L (670x370mm)', '5101', 50, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 15:41:14', '2023-02-04 15:42:05', '2023-02-10 08:24:26', 'Admin', 'Stored Out', 1),
(15, 'REQ:2302070259509', 'TOPCOVERKL(582x355x55mm)175#C/F_Section1_5101_FA_10_00035_230201162213', 1, 'SN-7336000035e3b17', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-07 14:45:17', '2023-02-07 14:45:54', '2023-02-10 08:24:46', 'Admin', 'Stored Out', 1),
(16, 'REQ:2302070259509', 'TriwallBody(1330x1120x665mm)_Section1_5101_FA_1_00041_230201162213', 1, 'SN-b9ef900041498f5', '00041', 'Triwall Body (1330x1120x665mm)', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-07 14:45:52', '2023-02-07 14:45:54', '2023-02-10 08:24:47', 'Admin', 'Stored Out', 1),
(17, 'REQ:230204035ff26', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 1, 'SN-4651100023b3bb6', '00023', 'Packaging Tape - Paramount -Size: 2\"', '5101', 2, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 15:35:22', '2023-02-04 15:42:05', '2023-02-10 08:39:39', 'Admin', 'Stored Out', 1),
(18, 'REQ:230204115a43c', 'PilotBody_Section1_5101_FA_1_00037_230201162213', 1, 'SN-d479800037c7793', '00037', 'Pilot Body', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 11:08:29', '2023-02-04 11:08:57', '2023-02-14 08:26:01', 'Admin', 'Stored Out', 1),
(19, 'REQ:230204115a43c', 'PilotCover_Section1_5101_FA_1_00038_230201162213', 1, 'SN-1998e000386e2e9', '00038', 'Pilot Cover', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 11:08:41', '2023-02-04 11:08:57', '2023-02-14 08:26:02', 'Admin', 'Stored Out', 1),
(20, 'REQ:230204115a43c', 'PilotPallet_Section1_5101_FA_1_00039_230201162213', 1, 'SN-5310c000393e0b6', '00039', 'Pilot Pallet', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-04 11:08:56', '2023-02-04 11:08:57', '2023-02-14 08:26:02', 'Admin', 'Stored Out', 1),
(21, 'REQ:23020804d03e4', 'ShippingCardCase100mmx224mm_Section1_5101_FA_100_00033_230201162213', 2, 'SN-d8114000338c27d', '00033', 'Shipping Card Case 100mmx224mm', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-08 16:36:51', '2023-02-08 16:37:13', '2023-02-14 08:26:16', 'Admin', 'Stored Out', 1),
(22, 'REQ:23020804d03e4', 'StretchFilm(20micx500MMx300Mx3\"C)_Section1_5101_FA_4_00034_230201162213', 1, 'SN-797f300034ceb19', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', '5101', 4, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-08 16:37:12', '2023-02-08 16:37:13', '2023-02-14 08:26:16', 'Admin', 'Stored Out', 1),
(23, 'REQ:2302080472ff1', 'MasterBoxDWBEFlute-Body_Section1_5101_FA_10_00016_230201162213', 1, 'SN-7daa300016739f5', '00016', 'Master Box DW BE Flute - Body', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-08 16:38:54', '2023-02-08 16:39:13', '2023-02-14 08:26:27', 'Admin', 'Stored Out', 1),
(24, 'REQ:2302080472ff1', 'MasterBoxDWBEFlute-U-pad_Section1_5101_FA_25_00017_230201162213', 1, 'SN-1538000017fb743', '00017', 'Master Box DW BE Flute - U-pad', '5101', 25, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-08 16:39:08', '2023-02-08 16:39:13', '2023-02-14 08:26:27', 'Admin', 'Stored Out', 1),
(25, 'REQ:23022110fbeac', 'CARTONCOVER(1180X1100X80mm)_Section1_5101_FA_10_00011_230201162213', 1, 'SN-7fb1300011a8731', '00011', 'CARTON COVER (1180X1100X80mm)', '5101', 5, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-21 10:48:48', '2023-02-21 10:49:28', '2023-02-21 11:39:55', 'Admin', 'Stored Out', 1),
(26, 'REQ:23021008b2340', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section1_5101_FA_200_00002_230201162213', 2, 'SN-a262300002c127c', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:27:24', '2023-02-10 08:30:53', '2023-02-21 11:43:50', 'Admin', 'Stored Out', 1),
(27, 'REQ:23021008b2340', 'KraftPaper/InterLayerSheet(570x650mm)140g_Section1_5101_FA_500_00015_230201162213', 2, 'SN-bca0600015273bc', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', '5101', 500, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:27:49', '2023-02-10 08:30:53', '2023-02-21 11:43:51', 'Admin', 'Stored Out', 1),
(28, 'REQ:23021008b2340', 'PEPlastic12x18100\'s_Section1_5101_FA_100_00043_230201162213', 1, 'SN-3181a0004301001', '00043', 'PE Plastic 12x18 100\'s', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:29:06', '2023-02-10 08:30:53', '2023-02-21 11:43:51', 'Admin', 'Stored Out', 1),
(29, 'REQ:23021008b2340', 'PEBag(700mmx930mm)_Section1_5101_FA_100_00028_230201162213', 2, 'SN-7685b0002874e45', '00028', 'PE Bag (700mmx930mm)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:29:30', '2023-02-10 08:30:53', '2023-02-21 11:43:51', 'Admin', 'Stored Out', 1),
(30, 'REQ:23021008b2340', 'OrdinaryPlastic(10x15)_Section1_5101_FA_100_00044_230201162213', 2, 'SN-a0e4500044c796a', '00044', 'Ordinary Plastic (10x15)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:30:45', '2023-02-10 08:30:53', '2023-02-21 11:43:52', 'Admin', 'Stored Out', 1),
(31, 'REQ:230210086dba8', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00007_230201162213', 1, 'SN-648cc00007130b4', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:35:08', '2023-02-10 08:35:28', '2023-02-21 13:26:58', 'Admin', 'Stored Out', 1),
(32, 'REQ:230211087ee0b', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00009_230201162213', 2, 'SN-7cd2a00009e3ee6', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:21:46', '2023-02-11 08:21:51', '2023-02-21 13:27:46', 'Admin', 'Stored Out', 0),
(33, 'REQ:230221015ff2d', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section1_5101_FA_200_00002_230201162213', 3, 'SN-a262300002c127c', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-21 13:58:00', '2023-02-21 13:58:09', '2023-02-23 13:03:45', 'Admin', 'Stored Out', 1),
(34, 'REQ:2302210227c39', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00004_230201162213', 1, 'SN-d8c5500004dc676', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', '5101', 50, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-21 14:01:27', '2023-02-21 14:03:46', '2023-02-24 10:32:50', 'Admin', 'Stored Out', 1),
(35, 'REQ:2302140865d6a', 'StretchFilm(20micx500MMx300Mx3\"C)_Section1_5101_FA_4_00034_230201162213', 2, 'SN-797f300034ceb19', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', '5101', 4, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-14 08:47:00', '2023-02-14 08:49:26', '2023-02-27 13:54:08', 'Admin', 'Stored Out', 1),
(36, 'REQ:2302140865d6a', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 2, 'SN-4651100023b3bb6', '00023', 'Packaging Tape - Paramount -Size: 2\"', '5101', 6, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-14 08:46:42', '2023-02-14 08:49:26', '2023-02-27 14:50:36', 'Admin', 'Stored Out', 1),
(37, 'REQ:2302140865d6a', 'ShippingCardCase100mmx224mm_Section1_5101_FA_100_00033_230201162213', 3, 'SN-d8114000338c27d', '00033', 'Shipping Card Case 100mmx224mm', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-14 08:46:19', '2023-02-14 08:49:26', '2023-02-27 14:51:05', 'Admin', 'Stored Out', 1),
(38, 'REQ:2302140865d6a', 'KraftPaper(515x1080)_Section1_5101_FA_200_00040_230201162213', 2, 'SN-98eaf000403dd1c', '00040', 'Kraft Paper (515x1080)', '5101', 200, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-14 08:45:57', '2023-02-14 08:49:26', '2023-02-27 14:53:59', 'Admin', 'Stored Out', 1),
(39, 'REQ:23022209eef4f', 'CARTONCOVER(1180X1100X80mm)_Section1_5101_FA_10_00011_230201162213', 2, 'SN-7fb1300011a8731', '00011', 'CARTON COVER (1180X1100X80mm)', '5101', 5, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-22 09:43:57', '2023-02-22 09:58:45', '2023-02-28 08:45:56', 'Admin', 'Stored Out', 1),
(40, 'REQ:230210086dba8', 'Aguila6x10_Section1_5101_FA_100_00057_230201162213', 2, 'SN-241ef0005741a8e', '00057', 'Aguila 6x10', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:33:14', '2023-02-10 08:35:28', '2023-02-28 08:56:00', 'Admin', 'Stored Out', 1),
(41, 'REQ:230210086dba8', 'MASTERBOXSMALLDW465X355X230_Section1_5101_FA_10_00052_230201162213', 2, 'SN-eb87c00052ee2a3', '00052', 'MASTER BOX SMALL DW 465X355X230', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:33:51', '2023-02-10 08:35:28', '2023-02-28 08:56:00', 'Admin', 'Stored Out', 1),
(42, 'REQ:230210086dba8', 'CartonCoverwithprintXL(1395x980x90mm)_Section1_5101_FA_10_00014_230201162213', 2, 'SN-3148b0001485f2f', '00014', 'Carton Cover with print XL (1395x980x90mm)', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:34:34', '2023-02-10 08:35:28', '2023-02-28 08:56:00', 'Admin', 'Stored Out', 1),
(43, 'REQ:230210086dba8', 'MasterBoxwithPrintLDW/BC-Flute(682x382x200mm)_Section1_5101_FA_10_00019_230201162213', 1, 'SN-863b000019f2627', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', '5101', 10, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:34:53', '2023-02-10 08:35:28', '2023-02-28 08:56:00', 'Admin', 'Stored Out', 1),
(44, 'REQ:230210086dba8', 'PolycardCase(White)_Section1_5101_FA_100_00056_230201162213', 1, 'SN-9911a00056a21b0', '00056', 'Polycard Case (White)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:35:25', '2023-02-10 08:35:28', '2023-02-28 08:56:00', 'Admin', 'Stored Out', 1),
(45, 'REQ:230211087ee0b', 'TriwallBody(1330x1120x665mm)_Section1_5101_FA_1_00041_230201162213', 2, 'SN-b9ef900041498f5', '00041', 'Triwall Body (1330x1120x665mm)', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:21:17', '2023-02-11 08:21:51', '2023-03-08 11:33:59', 'Admin', 'Stored Out', 0),
(46, 'REQ:23021008b2340', 'PolypropyleneStrappingBand15.5mmx2500mY_Section1_5101_FA_1_00031_230201162213', 1, 'SN-22fa400031a3e58', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', '5101', 1, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-10 08:30:24', '2023-02-10 08:30:53', '2023-03-15 08:32:10', 'Admin', 'Stored Out', 1),
(47, 'REQ:230223012bc84', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00007_230201162213', 2, 'SN-648cc00007130b4', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', '5101', 100, 'FG Area', 'Section 1', '2', 'N/A', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-23 13:01:57', '2023-02-23 13:02:27', '2023-03-21 11:08:33', 'Admin', 'Stored Out', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kanban_masterlist`
--

CREATE TABLE `kanban_masterlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `batch_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban_no` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `dimension` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `size` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `color` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT 'N/A',
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `req_limit` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `req_limit_qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `req_limit_time` time NOT NULL DEFAULT '08:00:00',
  `req_limit_date` date NOT NULL DEFAULT '2023-01-01',
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kanban_masterlist`
--

INSERT INTO `kanban_masterlist` (`id`, `batch_no`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `section`, `line_no`, `route_no`, `dimension`, `size`, `color`, `quantity`, `storage_area`, `req_limit`, `req_limit_qty`, `req_limit_time`, `req_limit_date`, `date_updated`) VALUES
(1, 'BAT:230201041b046', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section1_5101_FA_200_00002_230201162213', 3, 'SN-a262300002c127c', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 'Section 1', '5101', '2', '150X140MMX9.6MM', 'N/A', 'Clear', 200, 'FG Area', 600, 0, '08:00:00', '2023-01-01', '2023-02-21 16:19:53'),
(2, 'BAT:230201041b046', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00004_230201162213', 1, 'SN-d8c5500004dc676', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 'Section 1', '5101', '2', '1400mmx1400mm, PBS 9.6mm, 2ply', 'L', 'Clear', 100, 'FG Area', 100, 50, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(3, 'BAT:230201041b046', 'BubbleSheetM(1000mmx1200mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00006_230201162213', 0, 'SN-20b790000624b35', '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', 'Section 1', '5101', '2', '1000mmx1200mm, PBS 9.6mm, 2ply', 'M', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(4, 'BAT:230201041b046', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00007_230201162213', 2, 'SN-648cc00007130b4', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 'Section 1', '5101', '2', '650mmx550mm, PBS 9.6mm, 2ply', 'S', 'Clear', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(5, 'BAT:230201041b046', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00009_230201162213', 2, 'SN-7cd2a00009e3ee6', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 'Section 1', '5101', '2', '410mmx300mm, PBS 9.6mm, 2ply', 'XS', 'Clear', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(6, 'BAT:230201041b046', 'CARTONCOVER(1180X1100X80mm)_Section1_5101_FA_10_00011_230201162213', 2, 'SN-7fb1300011a8731', '00011', 'CARTON COVER (1180X1100X80mm)', 'Section 1', '5101', '2', '1180X1100X80mm', 'N/A', 'N/A', 10, 'FG Area', 10, 5, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(7, 'BAT:230201041b046', 'CartonCoverwithprintL(1220x1150x80mm)_Section1_5101_FA_10_00012_230201162213', 0, 'SN-3543f000129e0cf', '00012', 'Carton Cover with print L (1220x1150x80mm)', 'Section 1', '5101', '2', '1220x1150x80mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(8, 'BAT:230201041b046', 'CartonCoverwithprintM(1150x1150x80mm)_Section1_5101_FA_10_00013_230201162213', 0, 'SN-c13450001301fcc', '00013', 'Carton Cover with print M (1150x1150x80mm)', 'Section 1', '5101', '2', '1150x1150x80mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(9, 'BAT:230201041b046', 'CartonCoverwithprintXL(1395x980x90mm)_Section1_5101_FA_10_00014_230201162213', 2, 'SN-3148b0001485f2f', '00014', 'Carton Cover with print XL (1395x980x90mm)', 'Section 1', '5101', '2', '1395x980x90mm', 'XL', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(10, 'BAT:230201041b046', 'KraftPaper/InterLayerSheet(570x650mm)140g_Section1_5101_FA_500_00015_230201162213', 2, 'SN-bca0600015273bc', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 'Section 1', '5101', '2', '570 x 650mm', 'N/A', 'N/A', 500, 'FG Area', 500, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(11, 'BAT:230201041b046', 'MasterBoxDWBEFlute-Body_Section1_5101_FA_10_00016_230201162213', 1, 'SN-7daa300016739f5', '00016', 'Master Box DW BE Flute - Body', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(12, 'BAT:230201041b046', 'MasterBoxDWBEFlute-U-pad_Section1_5101_FA_25_00017_230201162213', 1, 'SN-1538000017fb743', '00017', 'Master Box DW BE Flute - U-pad', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 25, 'FG Area', 25, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(13, 'BAT:230201041b046', 'MasterBoxwithPrintL(740x426x230mm)_Section1_5101_FA_10_00018_230201162213', 0, 'SN-21d7300018cb4f3', '00018', 'Master Box with Print L (740x426x230mm)', 'Section 1', '5101', '2', '740x426x230mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(14, 'BAT:230201041b046', 'MasterBoxwithPrintLDW/BC-Flute(682x382x200mm)_Section1_5101_FA_10_00019_230201162213', 1, 'SN-863b000019f2627', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 'Section 1', '5101', '2', '682x382x200mm', 'L', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(15, 'BAT:230201041b046', 'MasterBoxwithPrintM(615x390x210mm)_Section1_5101_FA_10_00020_230201162213', 0, 'SN-9d98500020dee8b', '00020', 'Master Box with Print M (615x390x210mm)', 'Section 1', '5101', '2', '615x390x210mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(16, 'BAT:230201041b046', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_Section1_5101_FA_10_00021_230201162213', 0, 'SN-c78ad000215a981', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'Section 1', '5101', '2', '542x352x180mm', 'M', 'N/A', 10, 'FG Area', 10, 5, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(17, 'BAT:230201041b046', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 2, 'SN-4651100023b3bb6', '00023', 'Packaging Tape - Paramount -Size: 2\"', 'Section 1', '5101', '2', 'N/A', '2\"', 'N/A', 6, 'FG Area', 6, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(18, 'BAT:230201041b046', 'PadsL(670x370mm)_Section1_5101_FA_50_00024_230201162213', 1, 'SN-8331600024927ed', '00024', 'Pads L (670x370mm)', 'Section 1', '5101', '2', '670x370mm', 'L', 'N/A', 50, 'FG Area', 50, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(19, 'BAT:230201041b046', 'PadsM(555x325mm)_Section1_5101_FA_50_00025_230201162213', 0, 'SN-113ce000255a3e3', '00025', 'Pads M (555x325mm)', 'Section 1', '5101', '2', '555x325mm', 'M', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(20, 'BAT:230201041b046', 'PadsXL(845x420mm)_Section1_5101_FA_50_00026_230201162213', 0, 'SN-c7d4100026f9dc7', '00026', 'Pads XL (845x420mm)', 'Section 1', '5101', '2', '845x420mm', 'XL', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(21, 'BAT:230201041b046', 'PEBag(700mmx930mm)_Section1_5101_FA_100_00028_230201162213', 2, 'SN-7685b0002874e45', '00028', 'PE Bag (700mmx930mm)', 'Section 1', '5101', '2', '700mmx930mm', 'N/A', 'N/A', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(22, 'BAT:230201041b046', 'PlasticBuckles/Clip_Section1_5101_FA_200_00029_230201162213', 1, 'SN-7e3b2000293a857', '00029', 'Plastic Buckles/Clip', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 200, 'FG Area', 200, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(23, 'BAT:230201041b046', 'PlywoodPallet:1110x1180x130,4-wayentry_Section1_5101_FA_1_00030_230201162213', 0, 'SN-7b7350003060ee9', '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', 'Section 1', '5101', '2', '1110 x 1180 x 130, 4-way entry', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(24, 'BAT:230201041b046', 'PolypropyleneStrappingBand15.5mmx2500mY_Section1_5101_FA_1_00031_230201162213', 1, 'SN-22fa400031a3e58', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'Section 1', '5101', '2', '15.5mmx2500m', 'N/A', 'Yellow', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(25, 'BAT:230201041b046', 'RubberStopperSize:Medium(30kgs/bag)_Section1_5101_FA_1_00032_230201162213', 0, 'SN-a5387000320d294', '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'Section 1', '5101', '2', 'N/A', 'M', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(26, 'BAT:230201041b046', 'ShippingCardCase100mmx224mm_Section1_5101_FA_100_00033_230201162213', 3, 'SN-d8114000338c27d', '00033', 'Shipping Card Case 100mmx224mm', 'Section 1', '5101', '2', '100mmx224mm', 'N/A', 'N/A', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(27, 'BAT:230201041b046', 'StretchFilm(20micx500MMx300Mx3\"C)_Section1_5101_FA_4_00034_230201162213', 2, 'SN-797f300034ceb19', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'Section 1', '5101', '2', '20micx500MMx300Mx3\"C', 'N/A', 'N/A', 4, 'FG Area', 4, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(28, 'BAT:230201041b046', 'TOPCOVERKL(582x355x55mm)175#C/F_Section1_5101_FA_10_00035_230201162213', 1, 'SN-7336000035e3b17', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 'Section 1', '5101', '2', '582x355x55mm', 'N/A', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(29, 'BAT:230201041b046', 'ClearTape-Size:1x50\"-Brand:CROCODILE_Section1_5101_FA_5_00036_230201162213', 0, 'SN-f696d00036d43ad', '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'Section 1', '5101', '2', 'N/A', '1x50\"', 'Clear', 5, 'FG Area', 5, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(30, 'BAT:230201041b046', 'PilotBody_Section1_5101_FA_1_00037_230201162213', 1, 'SN-d479800037c7793', '00037', 'Pilot Body', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(31, 'BAT:230201041b046', 'PilotCover_Section1_5101_FA_1_00038_230201162213', 1, 'SN-1998e000386e2e9', '00038', 'Pilot Cover', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(32, 'BAT:230201041b046', 'PilotPallet_Section1_5101_FA_1_00039_230201162213', 1, 'SN-5310c000393e0b6', '00039', 'Pilot Pallet', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(33, 'BAT:230201041b046', 'KraftPaper(515x1080)_Section1_5101_FA_200_00040_230201162213', 2, 'SN-98eaf000403dd1c', '00040', 'Kraft Paper (515x1080)', 'Section 1', '5101', '2', '515x1080', 'N/A', 'N/A', 200, 'FG Area', 200, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(34, 'BAT:230201041b046', 'TriwallBody(1330x1120x665mm)_Section1_5101_FA_1_00041_230201162213', 2, 'SN-b9ef900041498f5', '00041', 'Triwall Body (1330x1120x665mm)', 'Section 1', '5101', '2', '1330x1120x665mm', 'N/A', 'N/A', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(35, 'BAT:230201041b046', 'KraftPaper(1320x1130mm)_Section1_5101_FA_200_00042_230201162213', 1, 'SN-40372000428c1c8', '00042', 'Kraft Paper (1320x1130mm)', 'Section 1', '5101', '2', '1320x1130mm', 'N/A', 'N/A', 200, 'FG Area', 200, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(36, 'BAT:230201041b046', 'PEPlastic12x18100\'s_Section1_5101_FA_100_00043_230201162213', 1, 'SN-3181a0004301001', '00043', 'PE Plastic 12x18 100\'s', 'Section 1', '5101', '2', '12x18', 'N/A', 'N/A', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(37, 'BAT:230201041b046', 'OrdinaryPlastic(10x15)_Section1_5101_FA_100_00044_230201162213', 2, 'SN-a0e4500044c796a', '00044', 'Ordinary Plastic (10x15)', 'Section 1', '5101', '2', '10x15', 'N/A', 'N/A', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(38, 'BAT:230201041b046', 'GunTackerStaplewire3/81000pcs_Section1_5101_FA_1000_00045_230201162213', 0, 'SN-200f30004564670', '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'Section 1', '5101', '2', 'N/A', 'N/A', 'N/A', 1000, 'FG Area', 1000, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(39, 'BAT:230201041b046', 'AngleProtector(50mmx50mmx885mmx5mm)_Section1_5101_FA_20_00047_230201162213', 0, 'SN-e55c300047c9205', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'Section 1', '5101', '2', '50mm x 50mm x 885mm x 5mm', 'N/A', 'N/A', 20, 'FG Area', 20, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(40, 'BAT:230201041b046', 'MasterBoxwithPrint(650x350x260mm)-RDX_Section1_5101_FA_10_00048_230201162213', 0, 'SN-f464b00048870b0', '00048', 'Master Box with Print (650x350x260mm) - RDX', 'Section 1', '5101', '2', '650x350x260mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(41, 'BAT:230201041b046', 'MasterBoxDW(820X360X210)-TUNDRA_Section1_5101_FA_10_00049_230201162213', 0, 'SN-33bf600049da726', '00049', 'Master Box DW (820X360X210) - TUNDRA', 'Section 1', '5101', '2', '820X360X210', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(42, 'BAT:230201041b046', 'Pads(810X350mm)-TUNDRA_Section1_5101_FA_10_00050_230201162213', 0, 'SN-ba9be000505bd7c', '00050', 'Pads (810X350mm) - TUNDRA', 'Section 1', '5101', '2', '810X350mm', 'N/A', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(43, 'BAT:230201041b046', 'WoodPallet(1120x840x120)-TUNDRA_Section1_5101_FA_1_00051_230201162213', 0, 'SN-7e41c000512fc4e', '00051', 'Wood Pallet (1120x840x120) - TUNDRA', 'Section 1', '5101', '2', '1120x840x120', 'N/A', 'N/A', 1, 'FG Area', 1, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(44, 'BAT:230201041b046', 'MASTERBOXSMALLDW465X355X230_Section1_5101_FA_10_00052_230201162213', 2, 'SN-eb87c00052ee2a3', '00052', 'MASTER BOX SMALL DW 465X355X230', 'Section 1', '5101', '2', '465X355X230', 'S', 'N/A', 10, 'FG Area', 10, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(45, 'BAT:230201041b046', 'PadsS(400X290MM)_Section1_5101_FA_50_00053_230201162213', 1, 'SN-a0fa500053d5da4', '00053', 'Pads S (400X290MM)', 'Section 1', '5101', '2', '400X290MM', 'S', 'N/A', 50, 'FG Area', 50, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(46, 'BAT:230201041b046', 'BubbleSheet(350x1200)_Section1_5101_FA_100_00054_230201162213', 0, 'SN-b07f200054312a9', '00054', 'Bubble Sheet (350x1200)', 'Section 1', '5101', '2', '350x1200', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(47, 'BAT:230201041b046', 'ShippingLabelCase(Blue)_Section1_5101_FA_100_00055_230201162213', 0, 'SN-cd3dc000554da31', '00055', 'Shipping Label Case (Blue)', 'Section 1', '5101', '2', 'N/A', 'N/A', 'Blue', 100, 'FG Area', 100, 50, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(48, 'BAT:230201041b046', 'PolycardCase(White)_Section1_5101_FA_100_00056_230201162213', 1, 'SN-9911a00056a21b0', '00056', 'Polycard Case (White)', 'Section 1', '5101', '2', 'N/A', 'N/A', 'White', 100, 'FG Area', 100, 0, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(49, 'BAT:230201041b046', 'Aguila6x10_Section1_5101_FA_100_00057_230201162213', 2, 'SN-241ef0005741a8e', '00057', 'Aguila 6x10', 'Section 1', '5101', '2', '6x10', 'N/A', 'N/A', 100, 'FG Area', 100, 50, '08:00:00', '2023-01-01', '2023-02-01 16:22:13'),
(50, 'BAT:230203096401c', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section2_4110_FA_200_00002_230203093130', 0, 'SN-e150a00002f7f41', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 'Section 2', '4110', '1', '150X140MMX9.6MM', 'N/A', 'Clear', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(51, 'BAT:230203096401c', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_Section2_4110_FA_100_00004_230203093130', 0, 'SN-4a2820000441fe5', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 'Section 2', '4110', '1', '1400mmx1400mm, PBS 9.6mm, 2ply', 'L', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(52, 'BAT:230203096401c', 'BubbleSheetM(1000mmx1200mm,PBS9.6mm,2plyclear)_Section2_4110_FA_100_00006_230203093130', 0, 'SN-fe22c00006c27e2', '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', 'Section 2', '4110', '1', '1000mmx1200mm, PBS 9.6mm, 2ply', 'M', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(53, 'BAT:230203096401c', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_Section2_4110_FA_100_00007_230203093130', 0, 'SN-19f45000077ae3b', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 'Section 2', '4110', '1', '650mmx550mm, PBS 9.6mm, 2ply', 'S', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(54, 'BAT:230203096401c', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_Section2_4110_FA_100_00009_230203093130', 0, 'SN-d4e76000098d388', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 'Section 2', '4110', '1', '410mmx300mm, PBS 9.6mm, 2ply', 'XS', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(55, 'BAT:230203096401c', 'CARTONCOVER(1180X1100X80mm)_Section2_4110_FA_10_00011_230203093130', 0, 'SN-0208000011066f2', '00011', 'CARTON COVER (1180X1100X80mm)', 'Section 2', '4110', '1', '1180X1100X80mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(56, 'BAT:230203096401c', 'CartonCoverwithprintL(1220x1150x80mm)_Section2_4110_FA_10_00012_230203093130', 0, 'SN-0a7920001214b66', '00012', 'Carton Cover with print L (1220x1150x80mm)', 'Section 2', '4110', '1', '1220x1150x80mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(57, 'BAT:230203096401c', 'CartonCoverwithprintM(1150x1150x80mm)_Section2_4110_FA_10_00013_230203093130', 0, 'SN-730b50001318f47', '00013', 'Carton Cover with print M (1150x1150x80mm)', 'Section 2', '4110', '1', '1150x1150x80mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(58, 'BAT:230203096401c', 'CartonCoverwithprintXL(1395x980x90mm)_Section2_4110_FA_10_00014_230203093130', 0, 'SN-8323900014dadc6', '00014', 'Carton Cover with print XL (1395x980x90mm)', 'Section 2', '4110', '1', '1395x980x90mm', 'XL', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(59, 'BAT:230203096401c', 'KraftPaper/InterLayerSheet(570x650mm)140g_Section2_4110_FA_500_00015_230203093130', 0, 'SN-047f5000152dd40', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 'Section 2', '4110', '1', '570 x 650mm', 'N/A', 'N/A', 500, 'FG Area', 500, 500, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(60, 'BAT:230203096401c', 'MasterBoxDWBEFlute-Body_Section2_4110_FA_10_00016_230203093130', 0, 'SN-fca0500016abc70', '00016', 'Master Box DW BE Flute - Body', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(61, 'BAT:230203096401c', 'MasterBoxDWBEFlute-U-pad_Section2_4110_FA_25_00017_230203093130', 0, 'SN-1d9b10001782eca', '00017', 'Master Box DW BE Flute - U-pad', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 25, 'FG Area', 25, 25, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(62, 'BAT:230203096401c', 'MasterBoxwithPrintL(740x426x230mm)_Section2_4110_FA_10_00018_230203093130', 0, 'SN-f0df10001805e9d', '00018', 'Master Box with Print L (740x426x230mm)', 'Section 2', '4110', '1', '740x426x230mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(63, 'BAT:230203096401c', 'MasterBoxwithPrintLDW/BC-Flute(682x382x200mm)_Section2_4110_FA_10_00019_230203093130', 0, 'SN-dbbde00019c76dc', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 'Section 2', '4110', '1', '682x382x200mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(64, 'BAT:230203096401c', 'MasterBoxwithPrintM(615x390x210mm)_Section2_4110_FA_10_00020_230203093130', 0, 'SN-e0ea80002003a5d', '00020', 'Master Box with Print M (615x390x210mm)', 'Section 2', '4110', '1', '615x390x210mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(65, 'BAT:230203096401c', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_Section2_4110_FA_10_00021_230203093130', 0, 'SN-2dbb8000214308e', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'Section 2', '4110', '1', '542x352x180mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(66, 'BAT:230203096401c', 'PackagingTape-Paramount-Size:2\"_Section2_4110_FA_6_00023_230203093130', 0, 'SN-81de40002321fd6', '00023', 'Packaging Tape - Paramount -Size: 2\"', 'Section 2', '4110', '1', 'N/A', '2\"', 'N/A', 6, 'FG Area', 6, 6, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(67, 'BAT:230203096401c', 'PadsL(670x370mm)_Section2_4110_FA_50_00024_230203093130', 0, 'SN-37a2000024e64f9', '00024', 'Pads L (670x370mm)', 'Section 2', '4110', '1', '670x370mm', 'L', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(68, 'BAT:230203096401c', 'PadsM(555x325mm)_Section2_4110_FA_50_00025_230203093130', 0, 'SN-1ab3200025ecc9b', '00025', 'Pads M (555x325mm)', 'Section 2', '4110', '1', '555x325mm', 'M', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(69, 'BAT:230203096401c', 'PadsXL(845x420mm)_Section2_4110_FA_50_00026_230203093130', 0, 'SN-0d76900026dc3c3', '00026', 'Pads XL (845x420mm)', 'Section 2', '4110', '1', '845x420mm', 'XL', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(70, 'BAT:230203096401c', 'PEBag(700mmx930mm)_Section2_4110_FA_100_00028_230203093130', 0, 'SN-2d720000281f606', '00028', 'PE Bag (700mmx930mm)', 'Section 2', '4110', '1', '700mmx930mm', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(71, 'BAT:230203096401c', 'PlasticBuckles/Clip_Section2_4110_FA_200_00029_230203093130', 0, 'SN-2723000029f970c', '00029', 'Plastic Buckles/Clip', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(72, 'BAT:230203096401c', 'PlywoodPallet:1110x1180x130,4-wayentry_Section2_4110_FA_1_00030_230203093130', 0, 'SN-e4bc8000304ef9c', '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', 'Section 2', '4110', '1', '1110 x 1180 x 130, 4-way entry', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(73, 'BAT:230203096401c', 'PolypropyleneStrappingBand15.5mmx2500mY_Section2_4110_FA_1_00031_230203093130', 0, 'SN-563cd00031d5f6a', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'Section 2', '4110', '1', '15.5mmx2500m', 'N/A', 'Yellow', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(74, 'BAT:230203096401c', 'RubberStopperSize:Medium(30kgs/bag)_Section2_4110_FA_1_00032_230203093130', 0, 'SN-909bc00032950b9', '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'Section 2', '4110', '1', 'N/A', 'M', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(75, 'BAT:230203096401c', 'ShippingCardCase100mmx224mm_Section2_4110_FA_100_00033_230203093130', 0, 'SN-b891200033a0890', '00033', 'Shipping Card Case 100mmx224mm', 'Section 2', '4110', '1', '100mmx224mm', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(76, 'BAT:230203096401c', 'StretchFilm(20micx500MMx300Mx3\"C)_Section2_4110_FA_4_00034_230203093130', 0, 'SN-d52bb00034456eb', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'Section 2', '4110', '1', '20micx500MMx300Mx3\"C', 'N/A', 'N/A', 4, 'FG Area', 4, 4, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(77, 'BAT:230203096401c', 'TOPCOVERKL(582x355x55mm)175#C/F_Section2_4110_FA_10_00035_230203093130', 0, 'SN-933de00035f7a1b', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 'Section 2', '4110', '1', '582x355x55mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(78, 'BAT:230203096401c', 'ClearTape-Size:1x50\"-Brand:CROCODILE_Section2_4110_FA_5_00036_230203093130', 0, 'SN-fb4340003605602', '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'Section 2', '4110', '1', 'N/A', '1x50\"', 'Clear', 5, 'FG Area', 5, 5, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(79, 'BAT:230203096401c', 'PilotBody_Section2_4110_FA_1_00037_230203093130', 0, 'SN-ac9e600037123b5', '00037', 'Pilot Body', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(80, 'BAT:230203096401c', 'PilotCover_Section2_4110_FA_1_00038_230203093130', 0, 'SN-25a0600038c24c1', '00038', 'Pilot Cover', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(81, 'BAT:230203096401c', 'PilotPallet_Section2_4110_FA_1_00039_230203093130', 0, 'SN-e091c00039b4169', '00039', 'Pilot Pallet', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(82, 'BAT:230203096401c', 'KraftPaper(515x1080)_Section2_4110_FA_200_00040_230203093130', 0, 'SN-6b033000403c666', '00040', 'Kraft Paper (515x1080)', 'Section 2', '4110', '1', '515x1080', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(83, 'BAT:230203096401c', 'TriwallBody(1330x1120x665mm)_Section2_4110_FA_1_00041_230203093130', 0, 'SN-26e7a0004142018', '00041', 'Triwall Body (1330x1120x665mm)', 'Section 2', '4110', '1', '1330x1120x665mm', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(84, 'BAT:230203096401c', 'KraftPaper(1320x1130mm)_Section2_4110_FA_200_00042_230203093130', 0, 'SN-eab4000042f5281', '00042', 'Kraft Paper (1320x1130mm)', 'Section 2', '4110', '1', '1320x1130mm', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(85, 'BAT:230203096401c', 'PEPlastic12x18100\'s_Section2_4110_FA_100_00043_230203093130', 0, 'SN-89c6a00043edb6c', '00043', 'PE Plastic 12x18 100\'s', 'Section 2', '4110', '1', '12x18', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(86, 'BAT:230203096401c', 'OrdinaryPlastic(10x15)_Section2_4110_FA_100_00044_230203093130', 0, 'SN-6510a00044ef14c', '00044', 'Ordinary Plastic (10x15)', 'Section 2', '4110', '1', '10x15', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(87, 'BAT:230203096401c', 'GunTackerStaplewire3/81000pcs_Section2_4110_FA_1000_00045_230203093130', 0, 'SN-808bb00045d187f', '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'Section 2', '4110', '1', 'N/A', 'N/A', 'N/A', 1000, 'FG Area', 1000, 1000, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(88, 'BAT:230203096401c', 'AngleProtector(50mmx50mmx885mmx5mm)_Section2_4110_FA_20_00047_230203093130', 0, 'SN-fb9de000475bbc0', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'Section 2', '4110', '1', '50mm x 50mm x 885mm x 5mm', 'N/A', 'N/A', 20, 'FG Area', 20, 20, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(89, 'BAT:230203096401c', 'MasterBoxwithPrint(650x350x260mm)-RDX_Section2_4110_FA_10_00048_230203093130', 0, 'SN-3822800048df82c', '00048', 'Master Box with Print (650x350x260mm) - RDX', 'Section 2', '4110', '1', '650x350x260mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(90, 'BAT:230203096401c', 'MasterBoxDW(820X360X210)-TUNDRA_Section2_4110_FA_10_00049_230203093130', 0, 'SN-a862100049ac614', '00049', 'Master Box DW (820X360X210) - TUNDRA', 'Section 2', '4110', '1', '820X360X210', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(91, 'BAT:230203096401c', 'Pads(810X350mm)-TUNDRA_Section2_4110_FA_10_00050_230203093130', 0, 'SN-2757700050e9a8b', '00050', 'Pads (810X350mm) - TUNDRA', 'Section 2', '4110', '1', '810X350mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(92, 'BAT:230203096401c', 'WoodPallet(1120x840x120)-TUNDRA_Section2_4110_FA_1_00051_230203093130', 0, 'SN-42b74000517c6f4', '00051', 'Wood Pallet (1120x840x120) - TUNDRA', 'Section 2', '4110', '1', '1120x840x120', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(93, 'BAT:230203096401c', 'MASTERBOXSMALLDW465X355X230_Section2_4110_FA_10_00052_230203093130', 0, 'SN-936010005269260', '00052', 'MASTER BOX SMALL DW 465X355X230', 'Section 2', '4110', '1', '465X355X230', 'S', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(94, 'BAT:230203096401c', 'PadsS(400X290MM)_Section2_4110_FA_50_00053_230203093130', 0, 'SN-fedba00053c8b24', '00053', 'Pads S (400X290MM)', 'Section 2', '4110', '1', '400X290MM', 'S', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(95, 'BAT:230203096401c', 'BubbleSheet(350x1200)_Section2_4110_FA_100_00054_230203093130', 0, 'SN-bc6e30005429079', '00054', 'Bubble Sheet (350x1200)', 'Section 2', '4110', '1', '350x1200', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(96, 'BAT:230203096401c', 'ShippingLabelCase(Blue)_Section2_4110_FA_100_00055_230203093130', 0, 'SN-49685000553482a', '00055', 'Shipping Label Case (Blue)', 'Section 2', '4110', '1', 'N/A', 'N/A', 'Blue', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(97, 'BAT:230203096401c', 'PolycardCase(White)_Section2_4110_FA_100_00056_230203093130', 0, 'SN-4e2a80005684db9', '00056', 'Polycard Case (White)', 'Section 2', '4110', '1', 'N/A', 'N/A', 'White', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(98, 'BAT:230203096401c', 'Aguila6x10_Section2_4110_FA_100_00057_230203093130', 0, 'SN-b7c6e00057325fd', '00057', 'Aguila 6x10', 'Section 2', '4110', '1', '6x10', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-03 09:31:30'),
(99, 'BAT:2302130128a4a', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_FG_FG_FA_200_00002_230213135859', 0, 'SN-5d903000025cda0', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 'FG', 'FG', 'N/A', '150X140MMX9.6MM', 'N/A', 'Clear', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(100, 'BAT:2302130128a4a', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_FG_FG_FA_100_00004_230213135859', 0, 'SN-67ad4000043acc1', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 'FG', 'FG', 'N/A', '1400mmx1400mm, PBS 9.6mm, 2ply', 'L', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(101, 'BAT:2302130128a4a', 'BubbleSheetM(1000mmx1200mm,PBS9.6mm,2plyclear)_FG_FG_FA_100_00006_230213135859', 0, 'SN-b33f1000069c3e9', '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', 'FG', 'FG', 'N/A', '1000mmx1200mm, PBS 9.6mm, 2ply', 'M', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(102, 'BAT:2302130128a4a', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_FG_FG_FA_100_00007_230213135859', 0, 'SN-b2860000075252e', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 'FG', 'FG', 'N/A', '650mmx550mm, PBS 9.6mm, 2ply', 'S', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(103, 'BAT:2302130128a4a', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_FG_FG_FA_100_00009_230213135859', 0, 'SN-47840000097f04d', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 'FG', 'FG', 'N/A', '410mmx300mm, PBS 9.6mm, 2ply', 'XS', 'Clear', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(104, 'BAT:2302130128a4a', 'CARTONCOVER(1180X1100X80mm)_FG_FG_FA_10_00011_230213135859', 0, 'SN-34d2e0001164a00', '00011', 'CARTON COVER (1180X1100X80mm)', 'FG', 'FG', 'N/A', '1180X1100X80mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(105, 'BAT:2302130128a4a', 'CartonCoverwithprintL(1220x1150x80mm)_FG_FG_FA_10_00012_230213135859', 0, 'SN-cb61a00012e51a3', '00012', 'Carton Cover with print L (1220x1150x80mm)', 'FG', 'FG', 'N/A', '1220x1150x80mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(106, 'BAT:2302130128a4a', 'CartonCoverwithprintM(1150x1150x80mm)_FG_FG_FA_10_00013_230213135859', 0, 'SN-ebf3d00013ad888', '00013', 'Carton Cover with print M (1150x1150x80mm)', 'FG', 'FG', 'N/A', '1150x1150x80mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(107, 'BAT:2302130128a4a', 'CartonCoverwithprintXL(1395x980x90mm)_FG_FG_FA_10_00014_230213135859', 0, 'SN-f571600014451e0', '00014', 'Carton Cover with print XL (1395x980x90mm)', 'FG', 'FG', 'N/A', '1395x980x90mm', 'XL', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(108, 'BAT:2302130128a4a', 'KraftPaper/InterLayerSheet(570x650mm)140g_FG_FG_FA_500_00015_230213135859', 0, 'SN-a46520001547e6b', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 'FG', 'FG', 'N/A', '570 x 650mm', 'N/A', 'N/A', 500, 'FG Area', 500, 500, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(109, 'BAT:2302130128a4a', 'MasterBoxDWBEFlute-Body_FG_FG_FA_10_00016_230213135859', 0, 'SN-0374800016cc857', '00016', 'Master Box DW BE Flute - Body', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(110, 'BAT:2302130128a4a', 'MasterBoxDWBEFlute-U-pad_FG_FG_FA_25_00017_230213135859', 0, 'SN-7214c000174d748', '00017', 'Master Box DW BE Flute - U-pad', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 25, 'FG Area', 25, 25, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(111, 'BAT:2302130128a4a', 'MasterBoxwithPrintL(740x426x230mm)_FG_FG_FA_10_00018_230213135859', 0, 'SN-3bd160001897c59', '00018', 'Master Box with Print L (740x426x230mm)', 'FG', 'FG', 'N/A', '740x426x230mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(112, 'BAT:2302130128a4a', 'MasterBoxwithPrintLDW/BC-Flute(682x382x200mm)_FG_FG_FA_10_00019_230213135859', 0, 'SN-a017600019fbdd0', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 'FG', 'FG', 'N/A', '682x382x200mm', 'L', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(113, 'BAT:2302130128a4a', 'MasterBoxwithPrintM(615x390x210mm)_FG_FG_FA_10_00020_230213135859', 0, 'SN-78fc5000201e55f', '00020', 'Master Box with Print M (615x390x210mm)', 'FG', 'FG', 'N/A', '615x390x210mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(114, 'BAT:2302130128a4a', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_FG_FG_FA_10_00021_230213135859', 0, 'SN-dc95e0002143136', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'FG', 'FG', 'N/A', '542x352x180mm', 'M', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(115, 'BAT:2302130128a4a', 'PackagingTape-Paramount-Size:2\"_FG_FG_FA_6_00023_230213135859', 0, 'SN-e2d6100023ad7a3', '00023', 'Packaging Tape - Paramount -Size: 2\"', 'FG', 'FG', 'N/A', 'N/A', '2\"', 'N/A', 6, 'FG Area', 6, 6, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(116, 'BAT:2302130128a4a', 'PadsL(670x370mm)_FG_FG_FA_50_00024_230213135859', 0, 'SN-ce25d00024fe76b', '00024', 'Pads L (670x370mm)', 'FG', 'FG', 'N/A', '670x370mm', 'L', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(117, 'BAT:2302130128a4a', 'PadsM(555x325mm)_FG_FG_FA_50_00025_230213135859', 0, 'SN-4e97000025a24ba', '00025', 'Pads M (555x325mm)', 'FG', 'FG', 'N/A', '555x325mm', 'M', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(118, 'BAT:2302130128a4a', 'PadsXL(845x420mm)_FG_FG_FA_50_00026_230213135859', 0, 'SN-9e7c2000265a2fd', '00026', 'Pads XL (845x420mm)', 'FG', 'FG', 'N/A', '845x420mm', 'XL', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(119, 'BAT:2302130128a4a', 'PEBag(700mmx930mm)_FG_FG_FA_100_00028_230213135859', 0, 'SN-e9c330002858ffd', '00028', 'PE Bag (700mmx930mm)', 'FG', 'FG', 'N/A', '700mmx930mm', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(120, 'BAT:2302130128a4a', 'PlasticBuckles/Clip_FG_FG_FA_200_00029_230213135859', 0, 'SN-9b05c0002995a35', '00029', 'Plastic Buckles/Clip', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(121, 'BAT:2302130128a4a', 'PlywoodPallet:1110x1180x130,4-wayentry_FG_FG_FA_1_00030_230213135859', 0, 'SN-271ea00030f1846', '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', 'FG', 'FG', 'N/A', '1110 x 1180 x 130, 4-way entry', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(122, 'BAT:2302130128a4a', 'PolypropyleneStrappingBand15.5mmx2500mY_FG_FG_FA_1_00031_230213135859', 0, 'SN-60787000317de47', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'FG', 'FG', 'N/A', '15.5mmx2500m', 'N/A', 'Yellow', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(123, 'BAT:2302130128a4a', 'RubberStopperSize:Medium(30kgs/bag)_FG_FG_FA_1_00032_230213135859', 0, 'SN-f9dc4000329f588', '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'FG', 'FG', 'N/A', 'N/A', 'M', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(124, 'BAT:2302130128a4a', 'ShippingCardCase100mmx224mm_FG_FG_FA_100_00033_230213135859', 0, 'SN-9427700033273a0', '00033', 'Shipping Card Case 100mmx224mm', 'FG', 'FG', 'N/A', '100mmx224mm', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(125, 'BAT:2302130128a4a', 'StretchFilm(20micx500MMx300Mx3\"C)_FG_FG_FA_4_00034_230213135859', 0, 'SN-e5a3600034501a4', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'FG', 'FG', 'N/A', '20micx500MMx300Mx3\"C', 'N/A', 'N/A', 4, 'FG Area', 4, 4, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(126, 'BAT:2302130128a4a', 'TOPCOVERKL(582x355x55mm)175#C/F_FG_FG_FA_10_00035_230213135859', 0, 'SN-ffd6600035f11f7', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 'FG', 'FG', 'N/A', '582x355x55mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(127, 'BAT:2302130128a4a', 'ClearTape-Size:1x50\"-Brand:CROCODILE_FG_FG_FA_5_00036_230213135859', 0, 'SN-8862f00036ca804', '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'FG', 'FG', 'N/A', 'N/A', '1x50\"', 'Clear', 5, 'FG Area', 5, 5, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(128, 'BAT:2302130128a4a', 'PilotBody_FG_FG_FA_1_00037_230213135859', 0, 'SN-1eb1f00037138c4', '00037', 'Pilot Body', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(129, 'BAT:2302130128a4a', 'PilotCover_FG_FG_FA_1_00038_230213135859', 0, 'SN-0a3a3000380572f', '00038', 'Pilot Cover', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(130, 'BAT:2302130128a4a', 'PilotPallet_FG_FG_FA_1_00039_230213135859', 0, 'SN-b9330000390196c', '00039', 'Pilot Pallet', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(131, 'BAT:2302130128a4a', 'KraftPaper(515x1080)_FG_FG_FA_200_00040_230213135859', 0, 'SN-e945e000404e2c4', '00040', 'Kraft Paper (515x1080)', 'FG', 'FG', 'N/A', '515x1080', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(132, 'BAT:2302130128a4a', 'TriwallBody(1330x1120x665mm)_FG_FG_FA_1_00041_230213135859', 0, 'SN-05427000413a6b3', '00041', 'Triwall Body (1330x1120x665mm)', 'FG', 'FG', 'N/A', '1330x1120x665mm', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(133, 'BAT:2302130128a4a', 'KraftPaper(1320x1130mm)_FG_FG_FA_200_00042_230213135859', 0, 'SN-b931a000426f5b1', '00042', 'Kraft Paper (1320x1130mm)', 'FG', 'FG', 'N/A', '1320x1130mm', 'N/A', 'N/A', 200, 'FG Area', 200, 200, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(134, 'BAT:2302130128a4a', 'PEPlastic12x18100\'s_FG_FG_FA_100_00043_230213135859', 0, 'SN-d3383000439fbbe', '00043', 'PE Plastic 12x18 100\'s', 'FG', 'FG', 'N/A', '12x18', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(135, 'BAT:2302130128a4a', 'OrdinaryPlastic(10x15)_FG_FG_FA_100_00044_230213135859', 0, 'SN-fc6b3000440d475', '00044', 'Ordinary Plastic (10x15)', 'FG', 'FG', 'N/A', '10x15', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(136, 'BAT:2302130128a4a', 'GunTackerStaplewire3/81000pcs_FG_FG_FA_1000_00045_230213135859', 0, 'SN-5ca9e0004564ada', '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'N/A', 1000, 'FG Area', 1000, 1000, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(137, 'BAT:2302130128a4a', 'AngleProtector(50mmx50mmx885mmx5mm)_FG_FG_FA_20_00047_230213135859', 0, 'SN-470dc00047640a2', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'FG', 'FG', 'N/A', '50mm x 50mm x 885mm x 5mm', 'N/A', 'N/A', 20, 'FG Area', 20, 20, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(138, 'BAT:2302130128a4a', 'MasterBoxwithPrint(650x350x260mm)-RDX_FG_FG_FA_10_00048_230213135859', 0, 'SN-f7ef9000480b5ff', '00048', 'Master Box with Print (650x350x260mm) - RDX', 'FG', 'FG', 'N/A', '650x350x260mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(139, 'BAT:2302130128a4a', 'MasterBoxDW(820X360X210)-TUNDRA_FG_FG_FA_10_00049_230213135859', 0, 'SN-90c6e00049d5b30', '00049', 'Master Box DW (820X360X210) - TUNDRA', 'FG', 'FG', 'N/A', '820X360X210', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(140, 'BAT:2302130128a4a', 'Pads(810X350mm)-TUNDRA_FG_FG_FA_10_00050_230213135859', 0, 'SN-815e700050dbca1', '00050', 'Pads (810X350mm) - TUNDRA', 'FG', 'FG', 'N/A', '810X350mm', 'N/A', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(141, 'BAT:2302130128a4a', 'WoodPallet(1120x840x120)-TUNDRA_FG_FG_FA_1_00051_230213135859', 0, 'SN-615bb00051d5b4f', '00051', 'Wood Pallet (1120x840x120) - TUNDRA', 'FG', 'FG', 'N/A', '1120x840x120', 'N/A', 'N/A', 1, 'FG Area', 1, 1, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(142, 'BAT:2302130128a4a', 'MASTERBOXSMALLDW465X355X230_FG_FG_FA_10_00052_230213135859', 0, 'SN-b405e000524ef66', '00052', 'MASTER BOX SMALL DW 465X355X230', 'FG', 'FG', 'N/A', '465X355X230', 'S', 'N/A', 10, 'FG Area', 10, 10, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(143, 'BAT:2302130128a4a', 'PadsS(400X290MM)_FG_FG_FA_50_00053_230213135859', 0, 'SN-18c7e00053d93c8', '00053', 'Pads S (400X290MM)', 'FG', 'FG', 'N/A', '400X290MM', 'S', 'N/A', 50, 'FG Area', 50, 50, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(144, 'BAT:2302130128a4a', 'BubbleSheet(350x1200)_FG_FG_FA_100_00054_230213135859', 0, 'SN-6c21f00054d05e8', '00054', 'Bubble Sheet (350x1200)', 'FG', 'FG', 'N/A', '350x1200', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(145, 'BAT:2302130128a4a', 'ShippingLabelCase(Blue)_FG_FG_FA_100_00055_230213135859', 0, 'SN-5439a0005569f97', '00055', 'Shipping Label Case (Blue)', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'Blue', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(146, 'BAT:2302130128a4a', 'PolycardCase(White)_FG_FG_FA_100_00056_230213135859', 0, 'SN-726ec0005682edd', '00056', 'Polycard Case (White)', 'FG', 'FG', 'N/A', 'N/A', 'N/A', 'White', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(147, 'BAT:2302130128a4a', 'Aguila6x10_FG_FG_FA_100_00057_230213135859', 0, 'SN-3afa500057e30c8', '00057', 'Aguila 6x10', 'FG', 'FG', 'N/A', '6x10', 'N/A', 'N/A', 100, 'FG Area', 100, 100, '08:00:00', '2023-01-01', '2023-02-13 13:58:59'),
(246, 'BAT:23021601de84d', 'BUBBLESHEET(150X140MMX9.6MM)2PLYCLEAR_Section7_3168_FA_200_00002_230216133331', 0, 'SN-7116500002fe73f', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 'Section 7', '3168', '4', '150X140MMX9.6MM', 'N/A', 'Clear', 200, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(247, 'BAT:23021601de84d', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_Section7_3168_FA_100_00004_230216133331', 0, 'SN-5c58e00004d86f0', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 'Section 7', '3168', '4', '1400mmx1400mm, PBS 9.6mm, 2ply', 'L', 'Clear', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(248, 'BAT:23021601de84d', 'BubbleSheetM(1000mmx1200mm,PBS9.6mm,2plyclear)_Section7_3168_FA_100_00006_230216133331', 0, 'SN-f27c900006fbe3a', '00006', 'Bubble Sheet M (1000mmx1200mm, PBS 9.6mm, 2ply clear)', 'Section 7', '3168', '4', '1000mmx1200mm, PBS 9.6mm, 2ply', 'M', 'Clear', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(249, 'BAT:23021601de84d', 'BubbleSheetS(650mmx550mm,PBS9.6mm,2plyclear)_Section7_3168_FA_100_00007_230216133331', 0, 'SN-35a49000076a055', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 'Section 7', '3168', '4', '650mmx550mm, PBS 9.6mm, 2ply', 'S', 'Clear', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(250, 'BAT:23021601de84d', 'BubbleSheetXS(410mmx300mm,PBS9.6mm,2plyclear)_Section7_3168_FA_100_00009_230216133331', 0, 'SN-777520000907890', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 'Section 7', '3168', '4', '410mmx300mm, PBS 9.6mm, 2ply', 'XS', 'Clear', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(251, 'BAT:23021601de84d', 'CARTONCOVER(1180X1100X80mm)_Section7_3168_FA_10_00011_230216133331', 0, 'SN-b8b9a000119b8d0', '00011', 'CARTON COVER (1180X1100X80mm)', 'Section 7', '3168', '4', '1180X1100X80mm', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(252, 'BAT:23021601de84d', 'CartonCoverwithprintL(1220x1150x80mm)_Section7_3168_FA_10_00012_230216133331', 0, 'SN-46f13000129458a', '00012', 'Carton Cover with print L (1220x1150x80mm)', 'Section 7', '3168', '4', '1220x1150x80mm', 'L', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(253, 'BAT:23021601de84d', 'CartonCoverwithprintM(1150x1150x80mm)_Section7_3168_FA_10_00013_230216133331', 0, 'SN-43498000133f52d', '00013', 'Carton Cover with print M (1150x1150x80mm)', 'Section 7', '3168', '4', '1150x1150x80mm', 'M', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(254, 'BAT:23021601de84d', 'CartonCoverwithprintXL(1395x980x90mm)_Section7_3168_FA_10_00014_230216133331', 0, 'SN-6f92200014ffe0b', '00014', 'Carton Cover with print XL (1395x980x90mm)', 'Section 7', '3168', '4', '1395x980x90mm', 'XL', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(255, 'BAT:23021601de84d', 'KraftPaper/InterLayerSheet(570x650mm)140g_Section7_3168_FA_500_00015_230216133331', 0, 'SN-11f4200015d8068', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 'Section 7', '3168', '4', '570 x 650mm', 'N/A', 'N/A', 500, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(256, 'BAT:23021601de84d', 'MasterBoxDWBEFlute-Body_Section7_3168_FA_10_00016_230216133331', 0, 'SN-6cf800001653135', '00016', 'Master Box DW BE Flute - Body', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(257, 'BAT:23021601de84d', 'MasterBoxDWBEFlute-U-pad_Section7_3168_FA_25_00017_230216133331', 0, 'SN-3663000017c314c', '00017', 'Master Box DW BE Flute - U-pad', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 25, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(258, 'BAT:23021601de84d', 'MasterBoxwithPrintL(740x426x230mm)_Section7_3168_FA_10_00018_230216133331', 0, 'SN-17f190001881285', '00018', 'Master Box with Print L (740x426x230mm)', 'Section 7', '3168', '4', '740x426x230mm', 'L', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(259, 'BAT:23021601de84d', 'MasterBoxwithPrintLDW/BC-Flute(682x382x200mm)_Section7_3168_FA_10_00019_230216133331', 0, 'SN-4622100019d1e9f', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 'Section 7', '3168', '4', '682x382x200mm', 'L', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(260, 'BAT:23021601de84d', 'MasterBoxwithPrintM(615x390x210mm)_Section7_3168_FA_10_00020_230216133331', 0, 'SN-6c47b0002092e1b', '00020', 'Master Box with Print M (615x390x210mm)', 'Section 7', '3168', '4', '615x390x210mm', 'M', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(261, 'BAT:23021601de84d', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_Section7_3168_FA_10_00021_230216133331', 0, 'SN-d47fb00021de243', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'Section 7', '3168', '4', '542x352x180mm', 'M', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(262, 'BAT:23021601de84d', 'PackagingTape-Paramount-Size:2\"_Section7_3168_FA_6_00023_230216133331', 0, 'SN-b827d000239cea3', '00023', 'Packaging Tape - Paramount -Size: 2\"', 'Section 7', '3168', '4', 'N/A', '2\"', 'N/A', 6, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(263, 'BAT:23021601de84d', 'PadsL(670x370mm)_Section7_3168_FA_50_00024_230216133331', 0, 'SN-5ce1e000248d85c', '00024', 'Pads L (670x370mm)', 'Section 7', '3168', '4', '670x370mm', 'L', 'N/A', 50, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(264, 'BAT:23021601de84d', 'PadsM(555x325mm)_Section7_3168_FA_50_00025_230216133331', 0, 'SN-cfbf1000252af8b', '00025', 'Pads M (555x325mm)', 'Section 7', '3168', '4', '555x325mm', 'M', 'N/A', 50, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(265, 'BAT:23021601de84d', 'PadsXL(845x420mm)_Section7_3168_FA_50_00026_230216133331', 0, 'SN-a06470002635973', '00026', 'Pads XL (845x420mm)', 'Section 7', '3168', '4', '845x420mm', 'XL', 'N/A', 50, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(266, 'BAT:23021601de84d', 'PEBag(700mmx930mm)_Section7_3168_FA_100_00028_230216133331', 0, 'SN-4ec0800028a7f91', '00028', 'PE Bag (700mmx930mm)', 'Section 7', '3168', '4', '700mmx930mm', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(267, 'BAT:23021601de84d', 'PlasticBuckles/Clip_Section7_3168_FA_200_00029_230216133331', 0, 'SN-de17c0002997f02', '00029', 'Plastic Buckles/Clip', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 200, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31');
INSERT INTO `kanban_masterlist` (`id`, `batch_no`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `section`, `line_no`, `route_no`, `dimension`, `size`, `color`, `quantity`, `storage_area`, `req_limit`, `req_limit_qty`, `req_limit_time`, `req_limit_date`, `date_updated`) VALUES
(268, 'BAT:23021601de84d', 'PlywoodPallet:1110x1180x130,4-wayentry_Section7_3168_FA_1_00030_230216133331', 0, 'SN-6304200030cea48', '00030', 'Plywood Pallet : 1110 x 1180 x 130, 4-way entry', 'Section 7', '3168', '4', '1110 x 1180 x 130, 4-way entry', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(269, 'BAT:23021601de84d', 'PolypropyleneStrappingBand15.5mmx2500mY_Section7_3168_FA_1_00031_230216133331', 0, 'SN-9376500031151b7', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'Section 7', '3168', '4', '15.5mmx2500m', 'N/A', 'Yellow', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(270, 'BAT:23021601de84d', 'RubberStopperSize:Medium(30kgs/bag)_Section7_3168_FA_1_00032_230216133331', 0, 'SN-c1f3700032e2f56', '00032', 'Rubber Stopper Size: Medium (30kgs/bag)', 'Section 7', '3168', '4', 'N/A', 'M', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(271, 'BAT:23021601de84d', 'ShippingCardCase100mmx224mm_Section7_3168_FA_100_00033_230216133331', 0, 'SN-492ec000335e4de', '00033', 'Shipping Card Case 100mmx224mm', 'Section 7', '3168', '4', '100mmx224mm', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(272, 'BAT:23021601de84d', 'StretchFilm(20micx500MMx300Mx3\"C)_Section7_3168_FA_4_00034_230216133331', 0, 'SN-cc4bd00034e0471', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'Section 7', '3168', '4', '20micx500MMx300Mx3\"C', 'N/A', 'N/A', 4, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(273, 'BAT:23021601de84d', 'TOPCOVERKL(582x355x55mm)175#C/F_Section7_3168_FA_10_00035_230216133331', 0, 'SN-71c0300035a3ee3', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 'Section 7', '3168', '4', '582x355x55mm', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(274, 'BAT:23021601de84d', 'ClearTape-Size:1x50\"-Brand:CROCODILE_Section7_3168_FA_5_00036_230216133331', 0, 'SN-cd45400036e9352', '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', 'Section 7', '3168', '4', 'N/A', '1x50\"', 'Clear', 5, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(275, 'BAT:23021601de84d', 'PilotBody_Section7_3168_FA_1_00037_230216133331', 0, 'SN-af2bd00037d1c63', '00037', 'Pilot Body', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(276, 'BAT:23021601de84d', 'PilotCover_Section7_3168_FA_1_00038_230216133331', 0, 'SN-5277b000380dae3', '00038', 'Pilot Cover', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(277, 'BAT:23021601de84d', 'PilotPallet_Section7_3168_FA_1_00039_230216133331', 0, 'SN-ca4620003950298', '00039', 'Pilot Pallet', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(278, 'BAT:23021601de84d', 'KraftPaper(515x1080)_Section7_3168_FA_200_00040_230216133331', 0, 'SN-921be0004099c44', '00040', 'Kraft Paper (515x1080)', 'Section 7', '3168', '4', '515x1080', 'N/A', 'N/A', 200, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(279, 'BAT:23021601de84d', 'TriwallBody(1330x1120x665mm)_Section7_3168_FA_1_00041_230216133331', 0, 'SN-9a8aa000412da13', '00041', 'Triwall Body (1330x1120x665mm)', 'Section 7', '3168', '4', '1330x1120x665mm', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(280, 'BAT:23021601de84d', 'KraftPaper(1320x1130mm)_Section7_3168_FA_200_00042_230216133331', 0, 'SN-c40ae0004297ef2', '00042', 'Kraft Paper (1320x1130mm)', 'Section 7', '3168', '4', '1320x1130mm', 'N/A', 'N/A', 200, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(281, 'BAT:23021601de84d', 'PEPlastic12x18100\'s_Section7_3168_FA_100_00043_230216133331', 0, 'SN-adeb900043cca3c', '00043', 'PE Plastic 12x18 100\'s', 'Section 7', '3168', '4', '12x18', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(282, 'BAT:23021601de84d', 'OrdinaryPlastic(10x15)_Section7_3168_FA_100_00044_230216133331', 0, 'SN-dfa6800044399f7', '00044', 'Ordinary Plastic (10x15)', 'Section 7', '3168', '4', '10x15', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(283, 'BAT:23021601de84d', 'GunTackerStaplewire3/81000pcs_Section7_3168_FA_1000_00045_230216133331', 0, 'SN-efa34000453b2f7', '00045', 'Gun Tacker Staple wire 3/8 1000pcs', 'Section 7', '3168', '4', 'N/A', 'N/A', 'N/A', 1000, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(284, 'BAT:23021601de84d', 'AngleProtector(50mmx50mmx885mmx5mm)_Section7_3168_FA_20_00047_230216133331', 0, 'SN-d560d000470bb41', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'Section 7', '3168', '4', '50mm x 50mm x 885mm x 5mm', 'N/A', 'N/A', 20, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(285, 'BAT:23021601de84d', 'MasterBoxwithPrint(650x350x260mm)-RDX_Section7_3168_FA_10_00048_230216133331', 0, 'SN-b810600048cb39d', '00048', 'Master Box with Print (650x350x260mm) - RDX', 'Section 7', '3168', '4', '650x350x260mm', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(286, 'BAT:23021601de84d', 'MasterBoxDW(820X360X210)-TUNDRA_Section7_3168_FA_10_00049_230216133331', 0, 'SN-658250004965d50', '00049', 'Master Box DW (820X360X210) - TUNDRA', 'Section 7', '3168', '4', '820X360X210', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(287, 'BAT:23021601de84d', 'Pads(810X350mm)-TUNDRA_Section7_3168_FA_10_00050_230216133331', 0, 'SN-803b000050e16a8', '00050', 'Pads (810X350mm) - TUNDRA', 'Section 7', '3168', '4', '810X350mm', 'N/A', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(288, 'BAT:23021601de84d', 'WoodPallet(1120x840x120)-TUNDRA_Section7_3168_FA_1_00051_230216133331', 0, 'SN-baf9a00051471b0', '00051', 'Wood Pallet (1120x840x120) - TUNDRA', 'Section 7', '3168', '4', '1120x840x120', 'N/A', 'N/A', 1, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(289, 'BAT:23021601de84d', 'MASTERBOXSMALLDW465X355X230_Section7_3168_FA_10_00052_230216133331', 0, 'SN-9ba2600052480a6', '00052', 'MASTER BOX SMALL DW 465X355X230', 'Section 7', '3168', '4', '465X355X230', 'S', 'N/A', 10, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(290, 'BAT:23021601de84d', 'PadsS(400X290MM)_Section7_3168_FA_50_00053_230216133331', 0, 'SN-75d9000053d33f8', '00053', 'Pads S (400X290MM)', 'Section 7', '3168', '4', '400X290MM', 'S', 'N/A', 50, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(291, 'BAT:23021601de84d', 'BubbleSheet(350x1200)_Section7_3168_FA_100_00054_230216133331', 0, 'SN-e603d000543ea47', '00054', 'Bubble Sheet (350x1200)', 'Section 7', '3168', '4', '350x1200', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(292, 'BAT:23021601de84d', 'ShippingLabelCase(Blue)_Section7_3168_FA_100_00055_230216133331', 0, 'SN-a11d10005572909', '00055', 'Shipping Label Case (Blue)', 'Section 7', '3168', '4', 'N/A', 'N/A', 'Blue', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(293, 'BAT:23021601de84d', 'PolycardCase(White)_Section7_3168_FA_100_00056_230216133331', 0, 'SN-ac595000566aecc', '00056', 'Polycard Case (White)', 'Section 7', '3168', '4', 'N/A', 'N/A', 'White', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-02-16 13:33:31'),
(294, 'BAT:23021601de84d', 'Aguila6x10_Section7_3168_FA_100_00057_230216133331', 0, 'SN-8056a00057b9707', '00057', 'Aguila 6x10', 'Section 7', '3168', '4', '6x10', 'N/A', 'N/A', 100, 'FG Area', 2000, 2000, '08:00:00', '2023-01-01', '2023-05-24 08:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `notification_count`
--

CREATE TABLE `notification_count` (
  `id` int(10) UNSIGNED NOT NULL,
  `interface` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pending` int(10) UNSIGNED NOT NULL,
  `ongoing` int(10) UNSIGNED NOT NULL,
  `store_out` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_count`
--

INSERT INTO `notification_count` (`id`, `interface`, `pending`, `ongoing`, `store_out`) VALUES
(1, 'ADMIN-FG', 0, 0, 0),
(2, 'Section 1', 0, 0, 0),
(3, 'Section 2', 0, 0, 0),
(4, 'Section 3', 0, 0, 0),
(5, 'Section 4', 0, 0, 0),
(6, 'Section 5', 0, 0, 0),
(7, 'Section 6', 0, 0, 0),
(8, 'Section 7', 0, 0, 0),
(9, 'Section 8', 0, 0, 0),
(10, 'QA', 0, 0, 0),
(11, 'QA Final', 0, 0, 0),
(12, 'FG', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requestor_account`
--

CREATE TABLE `requestor_account` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requestor_account`
--

INSERT INTO `requestor_account` (`id`, `id_no`, `name`, `section`, `car_model`, `line_no`, `factory_area`, `requestor`, `date_updated`) VALUES
(1, '22-08675', 'Developer', 'Section 1', 'Suzuki', '5101', 'FAS 1', 'PD1-SEC1', '2023-02-02 15:20:29'),
(4, '22-08676', 'Developer2', 'Section 2', 'Toyota', '4110', 'FAS 1', 'PD2-SEC2', '2023-02-02 15:20:35'),
(5, '21-08675', 'Developer3', 'QA Final', 'Honda', '3170', 'FAS 3', 'QA-QA FINAL', '2022-11-17 14:34:22'),
(6, '22-60604', 'Dev Test 1', 'Section 7', 'Honda', '3122', 'FAS 3', 'PD2-SEC7', '2023-02-02 15:21:06'),
(7, '22-01016', 'FG Personnel 1', 'FG', 'FG', 'FG', 'FAS 3', 'FG', '2023-02-13 15:55:17'),
(8, '22-08674', 'DeveloperCopy', 'Section 1', 'Suzuki', '5101', 'FAS 1', 'PD1-SEC1', '2023-04-01 09:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `requestor_remarks`
--

CREATE TABLE `requestor_remarks` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban_no` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scan_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `request_date_time` datetime DEFAULT NULL,
  `requestor_remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestor_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `requestor_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requestor_remarks`
--

INSERT INTO `requestor_remarks` (`id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `section`, `scan_date_time`, `request_date_time`, `requestor_remarks`, `requestor_date_time`, `requestor_status`) VALUES
(1, 'REQ:230204035ff26', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 1, 'SN-4651100023b3bb6', 'Section 1', '2023-02-04 15:35:22', '2023-02-04 15:42:05', 'TEST REQ', '2023-02-04 15:41:52', 'History'),
(2, 'REQ:2302070259509', 'TOPCOVERKL(582x355x55mm)175#C/F_Section1_5101_FA_10_00035_230201162213', 1, 'SN-7336000035e3b17', 'Section 1', '2023-02-07 14:45:17', NULL, 'Test 2', '2023-02-07 14:46:12', 'History'),
(3, 'REQ:2302070259509', 'TriwallBody(1330x1120x665mm)_Section1_5101_FA_1_00041_230201162213', 1, 'SN-b9ef900041498f5', 'Section 1', '2023-02-07 14:45:52', NULL, 'Test 2', '2023-02-07 14:46:21', 'History'),
(4, 'REQ:23021704c67ba', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_Section1_5101_FA_10_00021_230201162213', 1, 'SN-c78ad000215a981', 'Section 1', '2023-02-17 16:00:53', '2023-02-17 16:01:56', 'TESTING DATA TARGET', '2023-02-17 16:02:32', 'Requested'),
(8, 'REQ:2302140865d6a', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 2, 'SN-4651100023b3bb6', 'Section 1', '2023-02-14 08:46:42', '2023-02-14 08:49:26', 'TEST PARAMS', '2023-02-21 10:48:18', 'History'),
(9, 'REQ:23022110fbeac', 'CARTONCOVER(1180X1100X80mm)_Section1_5101_FA_10_00011_230201162213', 1, 'SN-7fb1300011a8731', 'Section 1', '2023-02-21 10:48:48', '2023-02-21 10:49:28', 'TEST PARAMS 2', '2023-02-21 10:49:06', 'History'),
(10, 'REQ:2302210227c39', 'BubbleSheetL(1400mmx1400mm,PBS9.6mm,2plyclear)_Section1_5101_FA_100_00004_230201162213', 1, 'SN-d8c5500004dc676', 'Section 1', '2023-02-21 14:01:27', '2023-02-21 14:03:46', 'Damage', '2023-02-21 14:02:42', 'History'),
(11, 'REQ:23022209eef4f', 'CARTONCOVER(1180X1100X80mm)_Section1_5101_FA_10_00011_230201162213', 2, 'SN-7fb1300011a8731', 'Section 1', '2023-02-22 09:43:57', '2023-02-22 09:58:45', 'TEST PARAMS 2', '2023-02-22 09:58:35', 'History'),
(12, 'REQ:23022809806d7', 'Aguila6x10_Section1_5101_FA_100_00057_230201162213', 3, 'SN-241ef0005741a8e', 'Section 1', '2023-02-28 09:09:19', '2023-02-28 09:13:11', 'SUPER URGENT DAW ITEST', '2023-02-28 09:12:44', 'Requested'),
(13, 'REQ:23022809806d7', 'KraftPaper(515x1080)_Section1_5101_FA_200_00040_230201162213', 3, 'SN-98eaf000403dd1c', 'Section 1', '2023-02-28 09:09:51', '2023-02-28 09:13:11', 'Lagyan ko lang', '2023-02-28 09:13:02', 'Requested'),
(14, 'REQ:23022809806d7', 'MASTERBOXSMALLDW465X355X230_Section1_5101_FA_10_00052_230201162213', 3, 'SN-eb87c00052ee2a3', 'Section 1', '2023-02-28 09:10:43', '2023-02-28 09:13:11', 'ISA PA', '2023-03-15 08:33:10', 'Requested'),
(15, 'REQ:2304010961739', 'ShippingLabelCase(Blue)_Section1_5101_FA_100_00055_230201162213', 1, 'SN-cd3dc000554da31', 'Section 1', '2023-04-01 09:15:32', '2023-04-01 10:32:19', 'TEST LOAD RECENT REQUEST', '2023-04-01 09:50:37', 'Requested');

-- --------------------------------------------------------

--
-- Table structure for table `route_no`
--

CREATE TABLE `route_no` (
  `id` int(10) UNSIGNED NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_no`
--

INSERT INTO `route_no` (`id`, `route_no`, `section`, `car_model`, `line_no`, `factory_area`, `date_updated`) VALUES
(1, '1', 'Section 2', 'Toyota', '4110', 'FAS 1', '2023-02-01 16:44:34'),
(2, '1', 'Section 2', 'Toyota', '4111', 'FAS 1', '2023-02-01 16:44:34'),
(3, '1', 'Section 2', 'Toyota', '4018', 'FAS 1', '2023-02-01 16:44:34'),
(4, '1', 'Section 2', 'Toyota', '4019', 'FAS 1', '2023-02-01 16:44:34'),
(5, '2', 'Section 1', 'Suzuki', '5101', 'FAS 1', '2023-02-01 16:44:34'),
(6, '2', 'Section 1', 'Suzuki', '5102', 'FAS 1', '2023-02-01 16:44:34'),
(7, '2', 'Section 1', 'Suzuki', '5103', 'FAS 1', '2023-02-01 16:44:34'),
(8, '2', 'Section 1', 'Suzuki', '5104', 'FAS 1', '2023-02-01 16:44:34'),
(9, '2', 'Section 1', 'Suzuki', '5105', 'FAS 1', '2023-02-01 16:44:35'),
(10, '2', 'Section 1', 'Suzuki', '5111', 'FAS 1', '2023-02-01 16:44:35'),
(11, '2', 'Section 1', 'Suzuki', '5112', 'FAS 1', '2023-02-01 16:44:35'),
(12, '2', 'Section 1', 'Suzuki', '5113', 'FAS 1', '2023-02-01 16:44:35'),
(13, '2', 'Section 1', 'Suzuki', '5114', 'FAS 1', '2023-02-01 16:44:35'),
(14, '2', 'Section 1', 'Suzuki', '5015', 'FAS 1', '2023-02-01 16:44:35'),
(15, '1', 'Section 2', 'Suzuki', '5116', 'FAS 1', '2023-02-01 16:44:35'),
(16, '1', 'Section 2', 'Suzuki', '5117', 'FAS 1', '2023-02-01 16:44:35'),
(17, '1', 'Section 2', 'Suzuki', '5119', 'FAS 1', '2023-02-01 16:44:35'),
(18, '1', 'Section 2', 'Suzuki', '5121', 'FAS 1', '2023-02-01 16:44:35'),
(19, '1', 'Section 2', 'Suzuki', '5124', 'FAS 1', '2023-02-01 16:44:35'),
(20, '2', 'Section 1', 'Suzuki', '5125', 'FAS 1', '2023-02-01 16:44:35'),
(21, '2', 'Section 1', 'Suzuki', '5126', 'FAS 1', '2023-02-01 16:44:35'),
(22, '2', 'Section 1', 'Suzuki', '5127', 'FAS 1', '2023-02-01 16:44:35'),
(23, '2', 'Section 1', 'Suzuki', '5128', 'FAS 1', '2023-02-01 16:44:35'),
(24, '1', 'Section 2', 'Suzuki', '5031', 'FAS 1', '2023-02-01 16:44:35'),
(25, '2', 'Section 1', 'Suzuki', '5133', 'FAS 1', '2023-02-01 16:44:35'),
(26, '2', 'Section 1', 'Suzuki', '5138', 'FAS 1', '2023-02-01 16:44:35'),
(27, '2', 'Section 1', 'Suzuki', '5139', 'FAS 1', '2023-02-01 16:44:35'),
(28, '1', 'Section 1', 'Suzuki', '5140', 'FAS 1', '2023-02-01 16:44:35'),
(29, '1', 'Section 3', 'Mazda', '1135', 'FAS 1', '2023-02-01 16:44:36'),
(30, '1', 'Section 3', 'Mazda', '1137', 'FAS 1', '2023-02-01 16:44:36'),
(31, '1', 'Section 3', 'Mazda', '1139', 'FAS 1', '2023-02-01 16:44:36'),
(32, '1', 'Section 3', 'Mazda', '1040', 'FAS 1', '2023-02-01 16:44:36'),
(33, '2', 'Section 4', 'Daihatsu', '2026', 'FAS 2', '2023-02-01 16:44:36'),
(34, '2', 'Section 4', 'Daihatsu', '2102', 'FAS 2', '2023-02-01 16:44:36'),
(35, '2', 'Section 4', 'Daihatsu', '2104', 'FAS 2', '2023-02-01 16:44:36'),
(36, '2', 'Section 4', 'Daihatsu', '2105', 'FAS 2', '2023-02-01 16:44:36'),
(37, '2', 'Section 4', 'Daihatsu', '2107', 'FAS 2', '2023-02-01 16:44:36'),
(38, '2', 'Section 3', 'Mazda', '1101', 'FAS 2', '2023-02-01 16:44:36'),
(39, '2', 'Section 3', 'Mazda', '1102', 'FAS 2', '2023-02-01 16:44:36'),
(40, '2', 'Section 3', 'Mazda', '1103', 'FAS 2', '2023-02-01 16:44:36'),
(41, '1', 'Section 3', 'Mazda', '1004', 'FAS 2', '2023-02-01 16:44:36'),
(42, '1', 'Section 3', 'Mazda', '1005', 'FAS 2', '2023-02-01 16:44:36'),
(43, '1', 'Section 3', 'Mazda', '1006', 'FAS 2', '2023-02-01 16:44:36'),
(44, '1', 'Section 3', 'Mazda', '1007', 'FAS 2', '2023-02-01 16:44:36'),
(45, '2', 'Section 3', 'Mazda', '1008', 'FAS 2', '2023-02-01 16:44:36'),
(46, '1', 'Section 3', 'Mazda', '1110', 'FAS 2', '2023-02-01 16:44:36'),
(47, '1', 'Section 3', 'Mazda', '1112', 'FAS 2', '2023-02-01 16:44:36'),
(48, '1', 'Section 3', 'Mazda', '1114', 'FAS 2', '2023-02-01 16:44:36'),
(49, '1', 'Section 3', 'Mazda', '1115', 'FAS 2', '2023-02-01 16:44:36'),
(50, '1', 'Section 3', 'Mazda', '1117', 'FAS 2', '2023-02-01 16:44:36'),
(51, '1', 'Section 3', 'Mazda', '1118', 'FAS 2', '2023-02-01 16:44:37'),
(52, '1', 'Section 3', 'Mazda', '1119', 'FAS 2', '2023-02-01 16:44:37'),
(53, '1', 'Section 3', 'Mazda', '1121', 'FAS 2', '2023-02-01 16:44:37'),
(54, '1', 'Section 3', 'Mazda', '1123', 'FAS 2', '2023-02-01 16:44:37'),
(55, '1', 'Section 3', 'Mazda', '1124', 'FAS 2', '2023-02-01 16:44:37'),
(56, '1', 'Section 3', 'Mazda', '1125', 'FAS 2', '2023-02-01 16:44:37'),
(57, '1', 'Section 3', 'Mazda', '1126', 'FAS 2', '2023-02-01 16:44:37'),
(58, '1', 'Section 3', 'Mazda', '1032', 'FAS 2', '2023-02-01 16:44:37'),
(59, '1', 'Section 1', 'Suzuki', '5123', 'FAS 2', '2023-02-01 16:44:37'),
(60, '1', 'Section 1', 'Suzuki', '5130', 'FAS 2', '2023-02-01 16:44:37'),
(61, '1', 'Section 1', 'Suzuki', '5132', 'FAS 2', '2023-02-01 16:44:37'),
(62, '2', 'Section 1', 'Suzuki', '5135', 'FAS 2', '2023-02-01 16:44:37'),
(63, '4', 'Section 1', 'Suzuki', '5009', 'FAS 3', '2023-02-01 16:44:37'),
(64, '4', 'Section 7', 'Honda', '3122', 'FAS 3', '2023-02-01 16:44:37'),
(65, '4', 'Section 7', 'Honda', '3123', 'FAS 3', '2023-02-01 16:44:37'),
(66, '4', 'Section 7', 'Honda', '3124', 'FAS 3', '2023-02-01 16:44:37'),
(67, '4', 'Section 7', 'Honda', '3125', 'FAS 3', '2023-02-01 16:44:37'),
(68, '4', 'Section 7', 'Honda', '3127', 'FAS 3', '2023-02-01 16:44:37'),
(69, '4', 'Section 7', 'Honda', '3129', 'FAS 3', '2023-02-01 16:44:37'),
(70, '4', 'Section 7', 'Honda', '3130', 'FAS 3', '2023-02-01 16:44:37'),
(71, '3', 'Section 7', 'Honda', '3133', 'FAS 3', '2023-02-01 16:44:37'),
(72, '3', 'Section 7', 'Honda', '3136', 'FAS 3', '2023-02-01 16:44:37'),
(73, '3', 'Section 6', 'Honda', '3138', 'FAS 3', '2023-02-01 16:44:37'),
(74, '3', 'Section 6', 'Honda', '3139', 'FAS 3', '2023-02-01 16:44:38'),
(75, '3', 'Section 6', 'Honda', '3140', 'FAS 3', '2023-02-01 16:44:38'),
(76, '3', 'Section 6', 'Honda', '3141', 'FAS 3', '2023-02-01 16:44:38'),
(77, '3', 'Section 6', 'Honda', '3142', 'FAS 3', '2023-02-01 16:44:38'),
(78, '3', 'Section 5', 'Honda', '3144', 'FAS 3', '2023-02-01 16:44:38'),
(79, '3', 'Section 5', 'Honda', '3145', 'FAS 3', '2023-02-01 16:44:38'),
(80, '3', 'Section 6', 'Honda', '3053', 'FAS 3', '2023-02-01 16:44:38'),
(81, '4', 'Section 7', 'Honda', '3158', 'FAS 3', '2023-02-01 16:44:38'),
(82, '4', 'Section 7', 'Honda', '3159', 'FAS 3', '2023-02-01 16:44:38'),
(83, '4', 'Section 7', 'Honda', '3160', 'FAS 3', '2023-02-01 16:44:38'),
(84, '4', 'Section 7', 'Honda', '3161', 'FAS 3', '2023-02-01 16:44:38'),
(85, '4', 'Section 7', 'Honda', '3168', 'FAS 3', '2023-02-01 16:44:38'),
(86, '4', 'Section 7', 'Honda', '3169', 'FAS 3', '2023-02-01 16:44:38'),
(87, '4', 'Section 4', 'Daihatsu', '2001', 'FAS 3', '2023-02-01 16:44:38'),
(88, '4', 'Section 4', 'Daihatsu', '2109', 'FAS 3', '2023-02-01 16:44:38'),
(89, '4', 'Section 4', 'Daihatsu', '2111', 'FAS 3', '2023-02-01 16:44:38'),
(90, '4', 'Section 4', 'Daihatsu', '2112', 'FAS 3', '2023-02-01 16:44:38'),
(91, '4', 'Section 4', 'Daihatsu', '2113', 'FAS 3', '2023-02-01 16:44:38'),
(92, '4', 'Section 4', 'Daihatsu', '2114', 'FAS 3', '2023-02-01 16:44:38'),
(93, '4', 'Section 4', 'Daihatsu', '2115', 'FAS 3', '2023-02-01 16:44:38'),
(94, '4', 'Section 4', 'Daihatsu', '2116', 'FAS 3', '2023-02-01 16:44:38'),
(95, '4', 'Section 4', 'Daihatsu', '2117', 'FAS 3', '2023-02-01 16:44:38'),
(96, '4', 'Section 4', 'Daihatsu', '2119', 'FAS 3', '2023-02-01 16:44:38'),
(97, '4', 'Section 4', 'Daihatsu', '2120', 'FAS 3', '2023-02-01 16:44:39'),
(98, '3', 'Section 4', 'Daihatsu', '2121', 'FAS 3', '2023-02-01 16:44:39'),
(99, '3', 'Section 4', 'Daihatsu', '2122', 'FAS 3', '2023-02-01 16:44:39'),
(100, '3', 'Section 4', 'Daihatsu', '2123', 'FAS 3', '2023-02-01 16:44:39'),
(101, '3', 'Section 4', 'Daihatsu', '2124', 'FAS 3', '2023-02-01 16:44:39'),
(102, '3', 'Section 4', 'Daihatsu', '2125', 'FAS 3', '2023-02-01 16:44:39'),
(103, '3', 'Section 4', 'Daihatsu', '2127', 'FAS 3', '2023-02-01 16:44:39'),
(104, '2', 'Section 4', 'Daihatsu', '2128', 'FAS 3', '2023-02-01 16:44:39'),
(105, '3', 'Section 5', 'Subaru', '7101', 'FAS 3', '2023-02-01 16:44:39'),
(106, '3', 'Section 5', 'Subaru', '7102', 'FAS 3', '2023-02-01 16:44:39'),
(107, '3', 'Section 5', 'Subaru', '7103', 'FAS 3', '2023-02-01 16:44:39'),
(108, '3', 'Section 5', 'Subaru', '7104', 'FAS 3', '2023-02-01 16:44:39'),
(109, '3', 'Section 5', 'Subaru', '7105', 'FAS 3', '2023-02-01 16:44:39'),
(110, '3', 'Section 5', 'Subaru', '7106', 'FAS 3', '2023-02-01 16:44:39'),
(111, '3', 'Section 5', 'Subaru', '7107', 'FAS 3', '2023-02-01 16:44:39'),
(112, '3', 'Section 5', 'Subaru', '7108', 'FAS 3', '2023-02-01 16:44:39'),
(113, '3', 'Section 5', 'Subaru', '7109', 'FAS 3', '2023-02-01 16:44:39'),
(114, '3', 'Section 5', 'Subaru', '7110', 'FAS 3', '2023-02-01 16:44:39'),
(115, '3', 'Section 5', 'Subaru', '7111', 'FAS 3', '2023-02-01 16:44:39'),
(116, '3', 'Section 5', 'Subaru', '7112', 'FAS 3', '2023-02-01 16:44:39'),
(117, '3', 'Section 5', 'Subaru', '7113', 'FAS 3', '2023-02-01 16:44:39'),
(118, '3', 'Section 5', 'Subaru', '7114', 'FAS 3', '2023-02-01 16:44:39'),
(119, '3', 'Section 5', 'Subaru', '7015', 'FAS 3', '2023-02-01 16:44:39'),
(120, '3', 'Section 5', 'Subaru', '7116', 'FAS 3', '2023-02-01 16:44:40'),
(121, '3', 'Section 5', 'Subaru', '7118', 'FAS 3', '2023-02-01 16:44:40'),
(122, '3', 'Section 5', 'Subaru', '7119', 'FAS 3', '2023-02-01 16:44:40'),
(123, '3', 'Section 5', 'Subaru', '7120', 'FAS 3', '2023-02-01 16:44:40'),
(124, '3', 'Section 5', 'Subaru', '7121', 'FAS 3', '2023-02-01 16:44:40'),
(125, '3', 'Section 5', 'Subaru', '7122', 'FAS 3', '2023-02-01 16:44:40'),
(126, '3', 'Section 5', 'Subaru', '7023', 'FAS 3', '2023-02-01 16:44:40'),
(127, '1', 'Section 1', 'Suzuki', '5006', 'Annex', '2023-02-01 16:44:40'),
(128, '1', 'Section 1', 'Suzuki', '5029', 'Annex', '2023-02-01 16:44:40'),
(129, '5', 'Section 2', 'Suzuki', '5018', 'Annex', '2023-02-01 16:44:40'),
(130, '4', 'Section 7', 'Honda', '3031', 'Annex', '2023-02-01 16:44:40'),
(131, '4', 'Section 7', 'Honda', '3032', 'Annex', '2023-02-01 16:44:40'),
(132, '5', 'Section 5', 'Honda', '3046', 'Annex', '2023-02-01 16:44:40'),
(133, '4', 'Section 5', 'Honda', '3037', 'Annex', '2023-02-01 16:44:40'),
(134, '5', 'Section 7', 'Honda', '3149', 'Annex', '2023-02-01 16:44:41'),
(135, '4', 'Section 7', 'Honda', '3150', 'Annex', '2023-02-01 16:44:41'),
(136, '4', 'Section 7', 'Honda', '3151', 'Annex', '2023-02-01 16:44:41'),
(137, '4', 'Section 7', 'Honda', '3152', 'Annex', '2023-02-01 16:44:41'),
(138, '5', 'Section 7', 'Honda', '3162', 'Annex', '2023-02-01 16:44:41'),
(139, '5', 'Section 7', 'Honda', '3163', 'Annex', '2023-02-01 16:44:41'),
(140, '5', 'Section 7', 'Honda', '3164', 'Annex', '2023-02-01 16:44:41'),
(141, '5', 'Section 7', 'Honda', '3165', 'Annex', '2023-02-01 16:44:41'),
(142, '5', 'Section 7', 'Honda', '3066', 'Annex', '2023-02-01 16:44:41'),
(143, '5', 'Section 7', 'Honda', '3067', 'Annex', '2023-02-01 16:44:41'),
(144, '2', 'Section 3', 'Mazda', '1033', 'Annex', '2023-02-01 16:44:41'),
(145, '2', 'Section 3', 'Mazda', '1034', 'Annex', '2023-02-01 16:44:41'),
(146, '5', 'Section 2', 'Yamaha', '8001', 'Annex', '2023-02-01 16:44:41'),
(147, '5', 'Section 2', 'Toyota', '4120', 'Annex', '2023-02-01 16:44:41'),
(148, '5', 'Section 2', 'Toyota', '4121', 'Annex', '2023-02-01 16:44:41'),
(149, '5', 'Section 2', 'Toyota', '4122', 'Annex', '2023-02-01 16:44:41'),
(150, '5', 'Section 2', 'Toyota', '4123', 'Annex', '2023-02-01 16:44:41'),
(151, '5', 'Section 2', 'Toyota', '4124', 'Annex', '2023-02-01 16:44:41'),
(152, '5', 'Section 2', 'Toyota', '4125', 'Annex', '2023-02-01 16:44:41'),
(153, '5', 'Section 2', 'Toyota', '4126', 'Annex', '2023-02-01 16:44:41'),
(154, 'N/A', 'FG', 'FG', 'FG', 'FAS 3', '2023-02-13 13:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `scanned_kanban`
--

CREATE TABLE `scanned_kanban` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kanban_no` int(10) UNSIGNED NOT NULL,
  `serial_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `line_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `requestor_id_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestor_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requestor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `request_date_time` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `is_read_fg` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scanned_kanban`
--

INSERT INTO `scanned_kanban` (`id`, `request_id`, `kanban`, `kanban_no`, `serial_no`, `item_no`, `item_name`, `line_no`, `quantity`, `storage_area`, `section`, `route_no`, `requestor_id_no`, `requestor_name`, `requestor`, `scan_date_time`, `request_date_time`, `status`, `is_read`, `is_read_fg`) VALUES
(48, 'REQ:230211087ee0b', 'Pads(810X350mm)-TUNDRA_Section1_5101_FA_10_00050_230201162213', 1, 'SN-ba9be000505bd7c', '00050', 'Pads (810X350mm) - TUNDRA', '5101', 10, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:19:21', '2023-02-11 08:21:51', 'Ongoing', 1, 1),
(49, 'REQ:230211087ee0b', 'AngleProtector(50mmx50mmx885mmx5mm)_Section1_5101_FA_20_00047_230201162213', 1, 'SN-e55c300047c9205', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', '5101', 20, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:19:42', '2023-02-11 08:21:51', 'Ongoing', 1, 1),
(50, 'REQ:230211087ee0b', 'ClearTape-Size:1x50\"-Brand:CROCODILE_Section1_5101_FA_5_00036_230201162213', 1, 'SN-f696d00036d43ad', '00036', 'Clear Tape - Size : 1x50\" - Brand: CROCODILE', '5101', 5, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:20:22', '2023-02-11 08:21:51', 'Ongoing', 1, 1),
(51, 'REQ:230211087ee0b', 'TOPCOVERKL(582x355x55mm)175#C/F_Section1_5101_FA_10_00035_230201162213', 2, 'SN-7336000035e3b17', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', '5101', 10, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-11 08:20:59', '2023-02-11 08:21:51', 'Ongoing', 1, 1),
(66, 'REQ:23021704c67ba', 'MasterBoxwithPrintMDW/BC-Flute(542x352x180mm)_Section1_5101_FA_10_00021_230201162213', 1, 'SN-c78ad000215a981', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', '5101', 5, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-17 16:00:53', '2023-02-17 16:01:56', 'Ongoing', 0, 1),
(80, 'REQ:23022809806d7', 'Aguila6x10_Section1_5101_FA_100_00057_230201162213', 3, 'SN-241ef0005741a8e', '00057', 'Aguila 6x10', '5101', 50, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-28 09:09:19', '2023-02-28 09:13:11', 'Pending', 1, 1),
(81, 'REQ:23022809806d7', 'KraftPaper(515x1080)_Section1_5101_FA_200_00040_230201162213', 3, 'SN-98eaf000403dd1c', '00040', 'Kraft Paper (515x1080)', '5101', 200, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-28 09:09:51', '2023-02-28 09:13:11', 'Pending', 1, 1),
(82, 'REQ:23022809806d7', 'MASTERBOXSMALLDW465X355X230_Section1_5101_FA_10_00052_230201162213', 3, 'SN-eb87c00052ee2a3', '00052', 'MASTER BOX SMALL DW 465X355X230', '5101', 10, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-28 09:10:43', '2023-02-28 09:13:11', 'Pending', 1, 1),
(83, 'REQ:23022809806d7', 'PackagingTape-Paramount-Size:2\"_Section1_5101_FA_6_00023_230201162213', 3, 'SN-4651100023b3bb6', '00023', 'Packaging Tape - Paramount -Size: 2\"', '5101', 6, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-02-28 09:11:40', '2023-02-28 09:13:11', 'Ongoing', 0, 1),
(84, 'REQ:23031508973f3', 'PolycardCase(White)_Section1_5101_FA_100_00056_230201162213', 2, 'SN-9911a00056a21b0', '00056', 'Polycard Case (White)', '5101', 100, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-03-15 08:28:07', '2023-03-15 08:28:41', 'Ongoing', 0, 1),
(85, 'REQ:23031508973f3', 'WoodPallet(1120x840x120)-TUNDRA_Section1_5101_FA_1_00051_230201162213', 1, 'SN-7e41c000512fc4e', '00051', 'Wood Pallet (1120x840x120) - TUNDRA', '5101', 1, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-03-15 08:28:22', '2023-03-15 08:28:41', 'Pending', 1, 1),
(86, 'REQ:23031508973f3', 'GunTackerStaplewire3/81000pcs_Section1_5101_FA_1000_00045_230201162213', 1, 'SN-200f30004564670', '00045', 'Gun Tacker Staple wire 3/8 1000pcs', '5101', 1000, 'FG Area', 'Section 1', '2', '22-08675', 'Developer', 'PD1-SEC1', '2023-03-15 08:28:39', '2023-03-15 08:28:41', 'Pending', 1, 1),
(91, 'REQ:2304010961739', 'ShippingLabelCase(Blue)_Section1_5101_FA_100_00055_230201162213', 1, 'SN-cd3dc000554da31', '00055', 'Shipping Label Case (Blue)', '5101', 50, 'FG Area', 'Section 1', '2', '22-08674', 'DeveloperCopy', 'PD1-SEC1', '2023-04-01 09:15:32', '2023-04-01 10:32:19', 'Pending', 0, 1),
(92, 'REQ:2304010961739', 'MasterBoxDWBEFlute-U-pad_Section1_5101_FA_25_00017_230201162213', 2, 'SN-1538000017fb743', '00017', 'Master Box DW BE Flute - U-pad', '5101', 25, 'FG Area', 'Section 1', '2', '22-08674', 'DeveloperCopy', 'PD1-SEC1', '2023-04-01 09:56:57', '2023-04-01 10:32:19', 'Pending', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(10) UNSIGNED NOT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section`, `ip`, `date_updated`) VALUES
(1, 'Section 1', '172.25.112.131', '2023-12-15 10:42:36'),
(2, 'Section 2', '172.25.113.72', '2023-02-01 16:03:21'),
(3, 'Section 3', '172.25.114.67', '2023-02-01 16:03:21'),
(4, 'Section 4', '172.25.114.66', '2023-02-01 16:03:21'),
(5, 'Section 5', '172.25.167.171', '2023-06-02 11:27:38'),
(6, 'Section 6', '172.25.116.120', '2023-02-01 16:03:21'),
(7, 'Section 7', '172.25.118.167', '2023-02-01 16:03:21'),
(8, 'Section 8', '172.25.118.87', '2023-02-01 16:03:21'),
(9, 'QA', '172.25.116.45', '2023-02-01 16:03:21'),
(10, 'QA Final', '172.25.161.171', '2023-02-02 15:43:04'),
(11, 'FG', '172.25.160.78', '2023-02-13 13:24:04'),
(12, 'Section 5', '172.25.167.172', '2023-06-02 11:27:55');

-- --------------------------------------------------------

--
-- Table structure for table `storage_area`
--

CREATE TABLE `storage_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `storage_area`
--

INSERT INTO `storage_area` (`id`, `storage_area`, `date_updated`) VALUES
(1, 'FG Area', '2023-01-28 09:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `store_in_history`
--

CREATE TABLE `store_in_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `rir_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `po_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dr_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inv_received` int(10) UNSIGNED NOT NULL,
  `inv_on_hand` int(10) UNSIGNED NOT NULL,
  `inv_after` int(10) UNSIGNED NOT NULL,
  `store_in_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `delivery_date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_in_history`
--

INSERT INTO `store_in_history` (`id`, `rir_id`, `invoice_no`, `po_no`, `dr_no`, `item_no`, `item_name`, `supplier_name`, `quantity`, `storage_area`, `reason`, `inv_received`, `inv_on_hand`, `inv_after`, `store_in_date_time`, `delivery_date_time`) VALUES
(1, '1', '1', '1', '1', '00014', 'Carton Cover with print XL (1395x980x90mm)', 'Sample Supply', 1000, 'FG Area', 'N/A', 1000, 0, 1000, '2023-02-04 16:21:26', NULL),
(2, '2', '2', '2', '2', '00037', 'Pilot Body', 'Sample Supply', 500, 'FG Area', 'N/A', 500, 0, 500, '2023-02-07 08:21:18', NULL),
(3, '3', '3', '3', '3', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 'Sample Supply', 1000, 'FG Area', 'N/A', 1000, 0, 1000, '2023-02-08 16:35:27', NULL),
(4, '4', '4', '4', '4', '00056', 'Polycard Case (White)', 'Sample Supply', 1000, 'FG Area', 'N/A', 1000, 0, 1000, '2023-02-10 08:36:49', NULL),
(5, '5', '5', '5', '5', '00023', 'Packaging Tape - Paramount -Size: 2\"', 'Sample Supply', 400, 'FG Area', 'N/A', 400, 4, 404, '2023-02-10 08:38:55', NULL),
(6, '6', '6', '6', '6', '00047', 'Angle Protector (50mm x 50mm x 885mm x 5mm)', 'Sample Supply', 1000, 'FG Area', 'N/A', 1000, 0, 1000, '2023-02-11 08:18:01', NULL),
(7, '7', '7', '7', '7', '00050', 'Pads (810X350mm) - TUNDRA', 'Sample Supply', 1000, 'FG Area', 'N/A', 1000, 0, 1000, '2023-02-11 08:18:44', NULL),
(8, '8', '8', '8', '8', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 'Sample Supply', 500, 'FG Area', 'N/A', 500, 0, 500, '2023-02-27 08:21:48', NULL),
(9, '9', '9', '9', '9', '00052', 'MASTER BOX SMALL DW 465X355X230', 'Sample Supply', 100, 'FG Area', 'N/A', 100, 10, 110, '2023-02-27 10:25:58', NULL),
(10, '10', '10', '10', '10', '00021', 'Master Box with Print M DW/BC-Flute (542x352x180mm)', 'Sample Supply', 5000, 'FG Area', 'N/A', 5000, 0, 5000, '2023-03-15 08:31:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_out_history`
--

CREATE TABLE `store_out_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `request_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A',
  `item_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_storage_area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inv_out` int(10) UNSIGNED NOT NULL,
  `inv_on_hand` int(10) UNSIGNED NOT NULL,
  `inv_after` int(10) UNSIGNED NOT NULL,
  `store_out_date_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_out_history`
--

INSERT INTO `store_out_history` (`id`, `request_id`, `item_no`, `item_name`, `quantity`, `storage_area`, `to_storage_area`, `remarks`, `inv_out`, `inv_on_hand`, `inv_after`, `store_out_date_time`) VALUES
(1, 'REQ:23020104ffc5e', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 200, 'FG Area', 'N/A', '', 200, 1595, 1395, '2023-02-01 16:49:52'),
(2, 'REQ:2302021108340', '00057', 'Aguila 6x10', 100, 'FG Area', 'N/A', '', 100, 15900, 15800, '2023-02-02 14:07:32'),
(3, 'REQ:2302030972d87', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 500, 'FG Area', 'N/A', '', 500, 7500, 7000, '2023-02-03 09:41:54'),
(4, 'REQ:2302030972d87', '00040', 'Kraft Paper (515x1080)', 200, 'FG Area', 'N/A', '', 200, 1800, 1600, '2023-02-03 09:41:55'),
(5, 'REQ:2302030972d87', '00042', 'Kraft Paper (1320x1130mm)', 200, 'FG Area', 'N/A', '', 200, 1000, 800, '2023-02-03 09:41:55'),
(6, 'REQ:23020310754fd', '00033', 'Shipping Card Case 100mmx224mm', 100, 'FG Area', 'N/A', '', 100, 1100, 1000, '2023-02-03 10:29:40'),
(7, 'REQ:23020310f26e5', '00044', 'Ordinary Plastic (10x15)', 100, 'FG Area', 'N/A', '', 100, 3000, 2900, '2023-02-03 10:35:01'),
(8, 'REQ:2302031058376', '00028', 'PE Bag (700mmx930mm)', 100, 'FG Area', 'N/A', '', 100, 3053, 2953, '2023-02-04 14:34:00'),
(9, 'REQ:2302031058376', '00029', 'Plastic Buckles/Clip', 200, 'FG Area', 'N/A', '', 200, 33000, 32800, '2023-02-04 14:34:00'),
(10, 'REQ:230204014720e', '00052', 'MASTER BOX SMALL DW 465X355X230', 10, 'FG Area', 'N/A', '', 10, 20, 10, '2023-02-04 14:37:39'),
(11, 'REQ:230204014720e', '00053', 'Pads S (400X290MM)', 50, 'FG Area', 'N/A', '', 50, 975, 925, '2023-02-04 14:37:39'),
(12, 'REQ:23020303af1e5', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 100, 'FG Area', 'N/A', '', 100, 400, 300, '2023-02-08 16:33:41'),
(13, 'REQ:23020209886e2', '00014', 'Carton Cover with print XL (1395x980x90mm)', 10, 'FG Area', 'N/A', '', 10, 1000, 990, '2023-02-10 08:20:08'),
(14, 'REQ:230204035ff26', '00024', 'Pads L (670x370mm)', 50, 'FG Area', 'N/A', '', 50, 2587, 2537, '2023-02-10 08:24:26'),
(15, 'REQ:2302070259509', '00035', 'TOP COVER KL (582x355x55mm) 175#C/F', 10, 'FG Area', 'N/A', 'Test 2', 10, 2340, 2330, '2023-02-10 08:24:46'),
(16, 'REQ:2302070259509', '00041', 'Triwall Body (1330x1120x665mm)', 1, 'FG Area', 'N/A', 'Test 2', 1, 37, 36, '2023-02-10 08:24:47'),
(17, 'REQ:230204035ff26', '00023', 'Packaging Tape - Paramount -Size: 2\"', 2, 'FG Area', 'N/A', 'TEST REQ', 2, 404, 402, '2023-02-10 08:39:39'),
(18, 'REQ:230204115a43c', '00037', 'Pilot Body', 1, 'FG Area', 'N/A', '', 1, 500, 499, '2023-02-14 08:26:01'),
(19, 'REQ:230204115a43c', '00038', 'Pilot Cover', 1, 'FG Area', 'N/A', '', 1, 40, 39, '2023-02-14 08:26:02'),
(20, 'REQ:230204115a43c', '00039', 'Pilot Pallet', 1, 'FG Area', 'N/A', '', 1, 115, 114, '2023-02-14 08:26:02'),
(21, 'REQ:23020804d03e4', '00033', 'Shipping Card Case 100mmx224mm', 100, 'FG Area', 'N/A', '', 100, 1000, 900, '2023-02-14 08:26:16'),
(22, 'REQ:23020804d03e4', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 4, 'FG Area', 'N/A', '', 4, 1000, 996, '2023-02-14 08:26:16'),
(23, 'REQ:2302080472ff1', '00016', 'Master Box DW BE Flute - Body', 10, 'FG Area', 'N/A', '', 10, 5640, 5630, '2023-02-14 08:26:27'),
(24, 'REQ:2302080472ff1', '00017', 'Master Box DW BE Flute - U-pad', 25, 'FG Area', 'N/A', '', 25, 4310, 4285, '2023-02-14 08:26:27'),
(25, 'REQ:23022110fbeac', '00011', 'CARTON COVER (1180X1100X80mm)', 5, 'FG Area', 'N/A', 'TEST PARAMS 2', 5, 2000, 1995, '2023-02-21 11:39:55'),
(26, 'REQ:23021008b2340', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 200, 'FG Area', 'N/A', '', 200, 1395, 1195, '2023-02-21 11:43:50'),
(27, 'REQ:23021008b2340', '00015', 'Kraft Paper / Inter Layer Sheet (570 x 650mm) 140 g', 500, 'FG Area', 'N/A', '', 500, 7000, 6500, '2023-02-21 11:43:51'),
(28, 'REQ:23021008b2340', '00043', 'PE Plastic 12x18 100\'s', 100, 'FG Area', 'N/A', '', 100, 1600, 1500, '2023-02-21 11:43:51'),
(29, 'REQ:23021008b2340', '00028', 'PE Bag (700mmx930mm)', 100, 'FG Area', 'N/A', '', 100, 2953, 2853, '2023-02-21 11:43:51'),
(30, 'REQ:23021008b2340', '00044', 'Ordinary Plastic (10x15)', 100, 'FG Area', 'N/A', '', 100, 2900, 2800, '2023-02-21 11:43:52'),
(31, 'REQ:230210086dba8', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 100, 'FG Area', 'N/A', '', 100, 1900, 1800, '2023-02-21 13:26:58'),
(32, 'REQ:230211087ee0b', '00009', 'Bubble Sheet XS(410mmx300mm, PBS 9.6mm, 2ply clear)', 100, 'FG Area', 'N/A', '', 100, 300, 200, '2023-02-21 13:27:46'),
(33, 'REQ:230221015ff2d', '00002', 'BUBBLE SHEET (150X140MMX9.6MM) 2 PLY CLEAR', 200, 'FG Area', 'N/A', '', 200, 1195, 995, '2023-02-23 13:03:45'),
(34, 'REQ:2302210227c39', '00004', 'Bubble Sheet L (1400mmx1400mm, PBS 9.6mm, 2ply clear)', 50, 'FG Area', 'N/A', 'Damage', 50, 1934, 1884, '2023-02-24 10:32:50'),
(35, 'REQ:2302140865d6a', '00034', 'Stretch Film (20micx500MMx300Mx3\"C)', 4, 'FG Area', 'N/A', '', 4, 996, 992, '2023-02-27 13:54:08'),
(36, 'REQ:2302140865d6a', '00023', 'Packaging Tape - Paramount -Size: 2\"', 6, 'FG Area', 'N/A', 'TEST PARAMS', 6, 402, 396, '2023-02-27 14:50:36'),
(37, 'REQ:2302140865d6a', '00033', 'Shipping Card Case 100mmx224mm', 100, 'FG Area', 'N/A', '', 100, 900, 800, '2023-02-27 14:51:05'),
(38, 'REQ:2302140865d6a', '00040', 'Kraft Paper (515x1080)', 200, 'FG Area', 'N/A', '', 200, 1600, 1400, '2023-02-27 14:53:59'),
(39, 'REQ:23022209eef4f', '00011', 'CARTON COVER (1180X1100X80mm)', 5, 'FG Area', 'N/A', 'TEST PARAMS 2', 5, 1995, 1990, '2023-02-28 08:45:56'),
(40, 'REQ:230210086dba8', '00057', 'Aguila 6x10', 100, 'FG Area', 'N/A', '', 100, 15800, 15700, '2023-02-28 08:56:00'),
(41, 'REQ:230210086dba8', '00052', 'MASTER BOX SMALL DW 465X355X230', 10, 'FG Area', 'N/A', '', 10, 110, 100, '2023-02-28 08:56:00'),
(42, 'REQ:230210086dba8', '00014', 'Carton Cover with print XL (1395x980x90mm)', 10, 'FG Area', 'N/A', '', 10, 990, 980, '2023-02-28 08:56:00'),
(43, 'REQ:230210086dba8', '00019', 'Master Box with Print L DW/BC-Flute (682x382x200mm)', 10, 'FG Area', 'N/A', '', 10, 190, 180, '2023-02-28 08:56:00'),
(44, 'REQ:230210086dba8', '00056', 'Polycard Case (White)', 100, 'FG Area', 'N/A', '', 100, 1000, 900, '2023-02-28 08:56:00'),
(45, 'REQ:230211087ee0b', '00041', 'Triwall Body (1330x1120x665mm)', 1, 'FG Area', 'N/A', '', 1, 36, 35, '2023-03-08 11:33:59'),
(46, 'REQ:23021008b2340', '00031', 'Polypropylene Strapping Band 15.5mmx2500m Y', 1, 'FG Area', 'N/A', '', 1, 500, 499, '2023-03-15 08:32:10'),
(47, 'REQ:230223012bc84', '00007', 'Bubble Sheet S(650mmx550mm, PBS 9.6mm, 2ply clear)', 100, 'FG Area', 'N/A', '', 100, 1800, 1700, '2023-03-21 11:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `date_updated`) VALUES
(1, 'Sample Supply', '2022-11-28 09:11:50');

-- --------------------------------------------------------

--
-- Table structure for table `truck_no`
--

CREATE TABLE `truck_no` (
  `id` int(10) UNSIGNED NOT NULL,
  `truck_no` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_to` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT '1000-01-01 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_no`
--

INSERT INTO `truck_no` (`id`, `truck_no`, `time_from`, `time_to`, `date_updated`) VALUES
(1, '1', '05:30', '06:10', '2020-02-07 22:45:28'),
(2, '2', '06:10', '06:50', '2020-02-07 22:45:37'),
(3, '3', '06:50', '07:35', '2020-02-07 22:45:42'),
(4, '4', '07:35', '08:35', '2020-02-07 22:45:47'),
(5, '5', '08:35', '09:20', '2020-02-07 22:45:53'),
(6, '6', '09:20', '10:20', '2020-02-07 22:45:58'),
(7, '7', '10:20', '11:05', '2020-01-31 14:40:08'),
(8, '8', '11:05', '11:50', '2020-01-31 14:40:34'),
(9, '9', '11:50', '13:35', '2020-01-31 14:41:07'),
(10, '10', '13:35', '14:20', '2020-01-31 14:41:34'),
(11, '11', '14:20', '15:20', '2020-01-31 14:42:03'),
(12, '12', '15:20', '16:05', '2020-01-31 14:42:29'),
(13, '13', '16:05', '16:50', '2020-01-31 14:43:04'),
(14, '14', '16:50', '17:30', '2020-01-31 14:43:26'),
(15, '15', '17:30', '18:10', '2020-01-31 14:43:57'),
(16, '16', '18:10', '18:50', '2020-01-31 14:44:21'),
(17, '17', '18:50', '19:35', '2020-01-31 14:44:45'),
(18, '18', '19:35', '20:35', '2020-01-31 14:45:05'),
(19, '19', '20:35', '21:20', '2020-01-31 14:45:53'),
(20, '20', '21:20', '22:20', '2020-01-31 14:46:28'),
(21, '21', '22:20', '23:05', '2020-01-31 14:47:03'),
(22, '22', '23:05', '23:50', '2020-01-31 14:47:30'),
(23, '23', '23:50', '01:35', '2020-01-31 14:48:16'),
(24, '24', '01:35', '02:20', '2020-01-31 14:48:49'),
(25, '25', '02:20', '03:20', '2020-01-31 14:49:07'),
(26, '26', '03:20', '04:05', '2020-01-31 14:49:40'),
(27, '27', '04:05', '04:50', '2020-01-31 14:50:23'),
(28, '28', '04:50', '05:30', '2020-01-31 14:50:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `car_model`
--
ALTER TABLE `car_model`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `car_model` (`car_model`);

--
-- Indexes for table `factory_area`
--
ALTER TABLE `factory_area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `factory_area` (`factory_area`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_no` (`item_no`),
  ADD UNIQUE KEY `item_name` (`item_name`);

--
-- Indexes for table `kanban_history`
--
ALTER TABLE `kanban_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kanban_masterlist`
--
ALTER TABLE `kanban_masterlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_count`
--
ALTER TABLE `notification_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requestor_account`
--
ALTER TABLE `requestor_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_no` (`id_no`);

--
-- Indexes for table `requestor_remarks`
--
ALTER TABLE `requestor_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_no`
--
ALTER TABLE `route_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scanned_kanban`
--
ALTER TABLE `scanned_kanban`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage_area`
--
ALTER TABLE `storage_area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_area` (`storage_area`);

--
-- Indexes for table `store_in_history`
--
ALTER TABLE `store_in_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rir_id` (`rir_id`);

--
-- Indexes for table `store_out_history`
--
ALTER TABLE `store_out_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_no`
--
ALTER TABLE `truck_no`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `car_model`
--
ALTER TABLE `car_model`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `factory_area`
--
ALTER TABLE `factory_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `kanban_history`
--
ALTER TABLE `kanban_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `kanban_masterlist`
--
ALTER TABLE `kanban_masterlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT for table `notification_count`
--
ALTER TABLE `notification_count`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `requestor_account`
--
ALTER TABLE `requestor_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `requestor_remarks`
--
ALTER TABLE `requestor_remarks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `route_no`
--
ALTER TABLE `route_no`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `scanned_kanban`
--
ALTER TABLE `scanned_kanban`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `storage_area`
--
ALTER TABLE `storage_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `store_in_history`
--
ALTER TABLE `store_in_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `store_out_history`
--
ALTER TABLE `store_out_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `truck_no`
--
ALTER TABLE `truck_no`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
