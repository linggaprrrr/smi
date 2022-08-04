-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2022 at 11:22 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color`) VALUES
(2, 'OCEAN'),
(1, 'PUTIH');

-- --------------------------------------------------------

--
-- Table structure for table `det_tim_gelar`
--

CREATE TABLE `det_tim_gelar` (
  `id` int(11) NOT NULL,
  `tim_gelar_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id` int(11) NOT NULL,
  `gudang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jahit_vendors`
--

CREATE TABLE `jahit_vendors` (
  `id` int(11) NOT NULL,
  `vendor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `ip_address` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `media` varchar(50) NOT NULL DEFAULT 'BROWSER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `description`, `user_id`, `created_at`) VALUES
(1, 'Menambahkan produk baru (HOMEDRESS DIRA OCEAN) sebanyak 50. ', 6, '2022-07-26 08:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `lovish_products`
--

CREATE TABLE `lovish_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `qrcode` text DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `weight` float NOT NULL,
  `roll` int(11) NOT NULL DEFAULT 1,
  `qrcode` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `price` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL DEFAULT 1,
  `tgl_cutting` timestamp NOT NULL DEFAULT current_timestamp(),
  `gelar1` int(11) DEFAULT NULL,
  `gelar2` int(11) DEFAULT NULL,
  `pic_cutting` int(11) NOT NULL,
  `vendor_pola` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `material_patterns`
--

CREATE TABLE `material_patterns` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `user_id_in` int(11) DEFAULT NULL,
  `user_id_out` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE `material_types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `material_vendors`
--

CREATE TABLE `material_vendors` (
  `id` int(11) NOT NULL,
  `vendor` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `hpp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`id`, `model_name`, `hpp`) VALUES
(1, 'LUNA', 50000),
(2, 'AMARA', 40000),
(16, 'DIRA', 30000),
(17, 'LOVA', 80000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `color_id` varchar(20) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `price` int(30) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `qrcode` text DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `model_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `color_id`, `weight`, `price`, `qty`, `status`, `qrcode`, `vendor_id`, `model_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '3', '2', 230, 30000, 50, 1, NULL, 1, 16, 6, '2022-07-26 15:29:36', '2022-07-26 15:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `product_barcodes`
--

CREATE TABLE `product_barcodes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qrcode` text DEFAULT NULL,
  `status` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_barcodes`
--

INSERT INTO `product_barcodes` (`id`, `product_id`, `qrcode`, `status`) VALUES
(1, 1, NULL, '1'),
(2, 1, NULL, '1'),
(3, 1, NULL, '1'),
(4, 1, NULL, '1'),
(5, 1, NULL, '1'),
(6, 1, NULL, '1'),
(7, 1, NULL, '1'),
(8, 1, NULL, '1'),
(9, 1, NULL, '1'),
(10, 1, NULL, '1'),
(11, 1, NULL, '1'),
(12, 1, NULL, '1'),
(13, 1, NULL, '1'),
(14, 1, NULL, '1'),
(15, 1, NULL, '1'),
(16, 1, NULL, '1'),
(17, 1, NULL, '1'),
(18, 1, NULL, '1'),
(19, 1, NULL, '1'),
(20, 1, NULL, '1'),
(21, 1, NULL, '1'),
(22, 1, NULL, '1'),
(23, 1, NULL, '1'),
(24, 1, NULL, '1'),
(25, 1, NULL, '1'),
(26, 1, NULL, '1'),
(27, 1, NULL, '1'),
(28, 1, NULL, '1'),
(29, 1, NULL, '1'),
(30, 1, NULL, '1'),
(31, 1, NULL, '1'),
(32, 1, NULL, '1'),
(33, 1, NULL, '1'),
(34, 1, NULL, '1'),
(35, 1, NULL, '1'),
(36, 1, NULL, '1'),
(37, 1, NULL, '1'),
(38, 1, NULL, '1'),
(39, 1, NULL, '1'),
(40, 1, NULL, '1'),
(41, 1, NULL, '1'),
(42, 1, NULL, '1'),
(43, 1, NULL, '1'),
(44, 1, NULL, '1'),
(45, 1, NULL, '1'),
(46, 1, NULL, '1'),
(47, 1, NULL, '1'),
(48, 1, NULL, '1'),
(49, 1, NULL, '1'),
(50, 1, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_logs`
--

CREATE TABLE `product_logs` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `status` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_logs`
--

INSERT INTO `product_logs` (`id`, `product_id`, `qty`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 50, '1', 6, '2022-07-26 08:29:36', '2022-07-26 08:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `product_name`) VALUES
(1, 'TUNIK'),
(2, 'DRESS'),
(3, 'HOMEDRESS');

-- --------------------------------------------------------

--
-- Table structure for table `selling_vendors`
--

CREATE TABLE `selling_vendors` (
  `id` int(11) NOT NULL,
  `vendor` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `selling_vendors`
--

INSERT INTO `selling_vendors` (`id`, `vendor`) VALUES
(1, 'LOVISH'),
(2, 'BASUNDARI');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int(11) NOT NULL,
  `box_name` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `resi` varchar(50) DEFAULT NULL,
  `qrcode` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `box_name`, `created_at`, `updated_at`, `resi`, `qrcode`, `status`, `user_id`) VALUES
(37, 'BOX-WJB2754', '2022-07-14 06:43:01', '2022-07-14 06:43:01', 'JD0125203265', NULL, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `id` int(11) NOT NULL,
  `shipping_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`id`, `shipping_id`, `product_id`) VALUES
(34, 37, 28),
(35, 37, 28),
(36, 37, 28),
(37, 37, 28),
(38, 37, 28);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_vendors`
--

CREATE TABLE `supplier_vendors` (
  `id` int(11) NOT NULL,
  `vendor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_vendors`
--

INSERT INTO `supplier_vendors` (`id`, `vendor`) VALUES
(1, 'MATAHARI TEX'),
(2, 'SURYA TEX'),
(3, 'BMJ TEX'),
(4, 'ALIBABA TEX'),
(5, 'KARUNIA TEX'),
(6, 'DFASHION'),
(8, 'KEMAYORAN TEX');

-- --------------------------------------------------------

--
-- Table structure for table `tim_cutting`
--

CREATE TABLE `tim_cutting` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tim_cutting`
--

INSERT INTO `tim_cutting` (`id`, `name`) VALUES
(1, 'NANA'),
(2, 'AHMAD');

-- --------------------------------------------------------

--
-- Table structure for table `tim_gelar`
--

CREATE TABLE `tim_gelar` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tim_gelar`
--

INSERT INTO `tim_gelar` (`id`, `name`) VALUES
(1, 'BUDI'),
(2, 'YADI');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `username` varchar(55) NOT NULL,
  `password` text NOT NULL,
  `role` enum('administrator','gudang_1','gudang_2','') NOT NULL,
  `accessibility` text DEFAULT NULL,
  `photo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `role`, `accessibility`, `photo`) VALUES
(1, 'admin', 'admin', '$2y$10$PtOhVUMdrxXXMxa2ADilkOfTZopbEKMyv/UoS6nUi5A93dJ43/hbi', 'administrator', NULL, NULL),
(6, 'Lingga', 'gesit', '$2y$10$XtqMCWbwjZ44Wi7GqOZl8.0XTljKBsAjTQl4HqoWqKiz6VZOEGouO', 'gudang_1', '[\"1\",\"2\",\"3\",\"7\",\"4\",\"5\",\"6\"]', NULL),
(7, 'Gesit', '', '$2y$10$CYpEL3.1kmVa4mvo9ZMX0OnHf4lJqzitFGEZ8QuDnhkPFbkwyWrgu', 'administrator', NULL, NULL),
(11, 'lovish', 'lovish', '$2y$10$GShNNckH7H4WMs2Z4hPIm.mJXpxsKc0Or/xlFzLHf16LuOBIOiYse', 'gudang_2', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_pola`
--

CREATE TABLE `vendor_pola` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor_pola`
--

INSERT INTO `vendor_pola` (`id`, `name`) VALUES
(1, 'AR'),
(2, 'NN'),
(3, 'YD');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `color` (`color`);

--
-- Indexes for table `det_tim_gelar`
--
ALTER TABLE `det_tim_gelar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jahit_vendors`
--
ALTER TABLE `jahit_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lovish_products`
--
ALTER TABLE `lovish_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_patterns`
--
ALTER TABLE `material_patterns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_types`
--
ALTER TABLE `material_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_vendors`
--
ALTER TABLE `material_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_barcodes`
--
ALTER TABLE `product_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_logs`
--
ALTER TABLE `product_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selling_vendors`
--
ALTER TABLE `selling_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resi` (`resi`);

--
-- Indexes for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_vendors`
--
ALTER TABLE `supplier_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tim_cutting`
--
ALTER TABLE `tim_cutting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tim_gelar`
--
ALTER TABLE `tim_gelar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_pola`
--
ALTER TABLE `vendor_pola`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `det_tim_gelar`
--
ALTER TABLE `det_tim_gelar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jahit_vendors`
--
ALTER TABLE `jahit_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lovish_products`
--
ALTER TABLE `lovish_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_patterns`
--
ALTER TABLE `material_patterns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_types`
--
ALTER TABLE `material_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_vendors`
--
ALTER TABLE `material_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_barcodes`
--
ALTER TABLE `product_barcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `product_logs`
--
ALTER TABLE `product_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `selling_vendors`
--
ALTER TABLE `selling_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `supplier_vendors`
--
ALTER TABLE `supplier_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tim_cutting`
--
ALTER TABLE `tim_cutting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tim_gelar`
--
ALTER TABLE `tim_gelar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendor_pola`
--
ALTER TABLE `vendor_pola`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
