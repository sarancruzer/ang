-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2017 at 07:03 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ang`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_payable`
--

CREATE TABLE `accounts_payable` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_inward_id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `payable_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `balanace_amount` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_payable_history`
--

CREATE TABLE `accounts_payable_history` (
  `id` int(11) NOT NULL,
  `accounts_payable_id` int(11) NOT NULL,
  `payable_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `balance_amount` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_receivable`
--

CREATE TABLE `accounts_receivable` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `receivable_amount` varchar(100) NOT NULL,
  `received_amount` varchar(100) NOT NULL,
  `balance_amount` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billing_details`
--

CREATE TABLE `billing_details` (
  `id` int(11) NOT NULL,
  `billno` varchar(100) NOT NULL,
  `billno_at_date` varchar(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `salesman_id` int(11) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `exchange_billno` varchar(100) NOT NULL,
  `exchange_bill_id` int(11) NOT NULL,
  `exchange_cost` varchar(100) NOT NULL,
  `discount_percentage` varchar(50) NOT NULL,
  `discount_amount` varchar(100) NOT NULL,
  `tax_percentage` varchar(50) NOT NULL,
  `tax_amount` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billing_details_history`
--

CREATE TABLE `billing_details_history` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `unit_cost` varchar(100) NOT NULL,
  `total_cost` varchar(100) NOT NULL,
  `net_amount` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_cost` varchar(50) NOT NULL,
  `percentage` float NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `supplier_id`, `product_code`, `product_name`, `product_cost`, `percentage`, `created_at`, `updated_at`, `status`, `is_active`) VALUES
(3, 1, 'product_code1', 'product_name', 'product_cost', 30, '2017-01-11 01:09:13', '2017-02-01 23:13:33', 1, 1),
(4, 1, 'product_code2', 'product_name', 'product_cost', 30, '2017-01-19 15:27:32', '2017-02-01 23:13:38', 1, 1),
(5, 1, 'product_code', 'levis', 'product_cost', 30, '2017-01-19 15:27:35', '2017-02-01 23:13:43', 1, 1),
(6, 1, 'produc1', 'prout banme', '1000', 30, '2017-01-29 01:16:07', '2017-02-01 23:13:46', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_inward`
--

CREATE TABLE `product_inward` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `unit_cost` varchar(100) NOT NULL,
  `total_cost` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `invoice_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_inward`
--

INSERT INTO `product_inward` (`id`, `product_id`, `quantity`, `unit_cost`, `total_cost`, `invoice_no`, `invoice_date`, `created_at`, `updated_at`, `status`, `is_active`) VALUES
(1, 4, '45', '100', '500', '3000', '2017-01-19', '2017-01-19 00:00:00', '2017-01-19 17:25:32', 1, 1),
(3, 5, '20', '150', '1500', '3001', '2017-01-19', '2017-01-19 00:00:00', '2017-01-19 17:26:50', 1, 1),
(4, 5, '10', '150', '1500', '3001', '2017-01-21', '2017-01-21 00:00:00', '2017-01-21 17:00:29', 1, 1),
(5, 5, '10', '150', '1500', '3001', '2017-01-21', '2017-01-21 00:00:00', '2017-01-21 17:03:19', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_return`
--

CREATE TABLE `product_return` (
  `id` int(11) NOT NULL,
  `product_inward_id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `unit_cost` varchar(100) NOT NULL,
  `total_cost` varchar(100) NOT NULL,
  `grand_total` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesman_details`
--

CREATE TABLE `salesman_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `salesman_code` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `return_quantity` varchar(100) NOT NULL,
  `unit_cost` varchar(100) NOT NULL,
  `total_cost` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `unit_cost` varchar(50) NOT NULL,
  `total_cost` varchar(100) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `supplier_code` varchar(20) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `email`, `mobile`, `address`, `supplier_code`, `created_at`, `updated_at`, `status`, `is_active`) VALUES
(8, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(9, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(10, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(11, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(12, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(13, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(14, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(15, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(16, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(17, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(18, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(19, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(20, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(21, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(22, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(23, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(24, 'saravanan', 'email', 'mobile', 'address', 'supplier_code', '2017-01-04 16:02:50', '2017-01-04 16:02:50', 1, 1),
(25, 'saravanan', 'sarancruzer@gmail.com', '9597009544', 'asdf\nasdf\nasdf', 'sup111', '2017-01-26 23:21:15', '2017-01-26 23:21:15', 1, 1),
(28, 'laks', 'laks@gmail.com', '9003853037', 'thanjavur', 'sup222', '2017-01-28 12:26:53', '2017-01-28 12:26:53', 1, 1),
(29, 'alagarsai', 'alagar@gmail.com', '9938938293', 'ksadfl\nkumbakonam', 'sup444', '2017-01-28 12:14:05', '2017-01-28 17:42:32', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'admin@admin.com', 'admin', '$2y$10$QGWiJrgjM5jR14XWq.JI0uPPBPqT6R0P4p0dEyYtE8JC3LCPC0PXy', NULL, '2016-11-24 08:10:17', '2016-11-24 08:10:17'),
(2, 'Chris Sevilleja', 'chris@scotch.io', '', '$2y$10$JWIPOlbU7kctIOy92AXVNuiwRwiLY0hdFufXzNaSMwCtKo4sBgqD6', NULL, '2016-11-24 08:10:17', '2016-11-24 08:10:17'),
(3, 'Holly Lloyd', 'holly@scotch.io', '', '$2y$10$BCzqYN.QiuEjWczWA7FtquT0JQJUavPbpQ6nDozQSKCF1qbbQTFkO', NULL, '2016-11-24 08:10:17', '2016-11-24 08:10:17'),
(4, 'Adnan Kukic', 'adnan@scotch.io', '', '$2y$10$vhGD7novc8qSYb0MfE2RTeaxBrnqQfFCen.p18ByvLdIWCL6orwBC', NULL, '2016-11-24 08:10:18', '2016-11-24 08:10:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_payable`
--
ALTER TABLE `accounts_payable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_payable_history`
--
ALTER TABLE `accounts_payable_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_details`
--
ALTER TABLE `billing_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_details_history`
--
ALTER TABLE `billing_details_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_inward`
--
ALTER TABLE `product_inward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return`
--
ALTER TABLE `product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesman_details`
--
ALTER TABLE `salesman_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return`
--
ALTER TABLE `sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_payable`
--
ALTER TABLE `accounts_payable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `accounts_payable_history`
--
ALTER TABLE `accounts_payable_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billing_details`
--
ALTER TABLE `billing_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `billing_details_history`
--
ALTER TABLE `billing_details_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product_inward`
--
ALTER TABLE `product_inward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `product_return`
--
ALTER TABLE `product_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `salesman_details`
--
ALTER TABLE `salesman_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
