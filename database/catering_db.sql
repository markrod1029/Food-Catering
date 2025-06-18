-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 11:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `inventory_id` int(30) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `category` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`, `status`, `date_created`) VALUES
(1, 'Meats', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed ex efficitur, sodales odio ac, fermentum purus. Vestibulum pretium mi dolor, varius bibendum nulla condimentum non. Aenean faucibus non leo in aliquet. Vestibulum luctus quis leo at pharetra. Donec a sapien sed est condimentum pulvinar. Vivamus ultrices fringilla massa nec varius. Aenean et convallis tellus. Donec semper dolor quis tellus scelerisque dictum. Cras posuere augue in turpis aliquet, sed mattis ante faucibus.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;Pellentesque dapibus felis nulla, id vehicula ligula bibendum sed. Vestibulum in quam sed magna auctor iaculis. Vestibulum fermentum rutrum volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut in sollicitudin mi. Sed elit lorem, ultricies in hendrerit a, gravida et lorem. Donec sollicitudin ultrices diam et pellentesque. Integer tortor orci, commodo in felis id, rhoncus viverra mi. Fusce risus ligula, ullamcorper vitae ligula id, dictum ornare risus. Mauris bibendum blandit elementum. Etiam nec orci lacinia ligula pulvinar sagittis nec sed felis. Duis pharetra lacinia mattis. Etiam euismod ante quis ultricies porta. Fusce nec felis et neque lobortis vulputate.&lt;/p&gt;', 1, '2021-08-04 11:37:48'),
(2, 'Veges', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Pellentesque dapibus felis nulla, id vehicula ligula bibendum sed. Vestibulum in quam sed magna auctor iaculis. Vestibulum fermentum rutrum volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut in sollicitudin mi. Sed elit lorem, ultricies in hendrerit a, gravida et lorem. Donec sollicitudin ultrices diam et pellentesque. Integer tortor orci, commodo in felis id, rhoncus viverra mi. Fusce risus ligula, ullamcorper vitae ligula id, dictum ornare risus. Mauris bibendum blandit elementum. Etiam nec orci lacinia ligula pulvinar sagittis nec sed felis. Duis pharetra lacinia mattis. Etiam euismod ante quis ultricies porta. Fusce nec felis et neque lobortis vulputate.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 11:38:12'),
(3, 'Sandwiches', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 11:38:44'),
(4, 'Chicken', '&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed ex efficitur, sodales odio ac, fermentum purus. Vestibulum pretium mi dolor, varius bibendum nulla condimentum non. Aenean faucibus non leo in aliquet. Vestibulum luctus quis leo at pharetra. Donec a sapien sed est condimentum pulvinar. Vivamus ultrices fringilla massa nec varius. Aenean et convallis tellus. Donec semper dolor quis tellus scelerisque dictum. Cras posuere augue in turpis aliquet, sed mattis ante faucibus.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;&quot;&gt;Pellentesque dapibus felis nulla, id vehicula ligula bibendum sed. Vestibulum in quam sed magna auctor iaculis. Vestibulum fermentum rutrum volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut in sollicitudin mi. Sed elit lorem, ultricies in hendrerit a, gravida et lorem. Donec sollicitudin ultrices diam et pellentesque. Integer tortor orci, commodo in felis id, rhoncus viverra mi. Fusce risus ligula, ullamcorper vitae ligula id, dictum ornare risus. Mauris bibendum blandit elementum. Etiam nec orci lacinia ligula pulvinar sagittis nec sed felis. Duis pharetra lacinia mattis. Etiam euismod ante quis ultricies porta. Fusce nec felis et neque lobortis vulputate.&lt;/p&gt;', 1, '2021-08-04 11:55:08'),
(5, 'Drinks', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(30) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `firstname`, `lastname`, `gender`, `contact`, `email`, `password`, `address`, `date_created`) VALUES
(1, 'John', 'Smith', 'Male', '09123456789', 'jsmith@sample.com', '1254737c076cf867dc53d60a0364f38e', 'Sample Address', '2021-08-04 14:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `type_name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `type_name`, `description`, `price`, `date_created`, `date_updated`) VALUES
(1, 1, 'Buffet', 'Good for 50 person', 3500, '2021-08-04 12:23:21', '2021-08-04 14:07:52'),
(2, 1, 'Packed', 'Good for 1 person with rice', 80, '2021-08-04 12:26:39', '2021-08-04 14:07:33'),
(3, 3, 'Buffet', 'Good 95 person', 1000, '2021-08-04 12:28:35', '2021-08-04 14:07:04'),
(4, 2, 'Buffet', '85 pieces', 1500, '2021-08-04 12:29:22', '2021-08-04 14:06:41'),
(5, 2, 'Packed', '1 piece with rice', 100, '2021-08-04 12:29:59', '2021-08-04 14:06:26'),
(6, 5, 'Serve', '1 Gallon good for 150 cups', 2000, '2021-08-04 12:30:57', '2021-08-04 14:06:05'),
(7, 4, 'Buffet', 'Good for 60 person', 2500, '2021-08-04 12:58:08', '2021-08-04 14:05:39'),
(8, 6, 'Canned', '12 oz', 45, '2021-08-04 12:59:14', '2021-08-04 14:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `event` varchar(250) NOT NULL,
  `venue` text NOT NULL,
  `event_date` datetime NOT NULL,
  `amount` double NOT NULL,
  `additional_remarks` text DEFAULT NULL,
  `additional_amount` float NOT NULL DEFAULT 0,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `event`, `venue`, `event_date`, `amount`, `additional_remarks`, `additional_amount`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 'Birthday Celebration', 'Sample Event Venue', '2021-12-08 10:00:00', 6250, 'Servers, utensils, and other Fees.', 2500, 1, '2021-08-04 15:32:25', '2021-08-04 15:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `inventory_id` int(30) NOT NULL,
  `quantity` int(30) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `inventory_id`, `quantity`, `price`, `total`) VALUES
(1, 1, 7, 1, 2500, 2500),
(2, 1, 4, 1, 1500, 1500),
(3, 1, 8, 50, 45, 2250);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` longtext NOT NULL,
  `photo1` varchar(100) NOT NULL,
  `photo2` varchar(100) NOT NULL,
  `photo3` varchar(100) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `package_id` int(11) NOT NULL,
  `sub_category_id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `package_id`, `sub_category_id`, `title`, `description`, `status`, `date_created`) VALUES
(1, 1, 11, 2, 'Beef Steak', '&lt;p style=\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\\&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed ex efficitur, sodales odio ac, fermentum purus. Vestibulum pretium mi dolor, varius bibendum nulla condimentum non. Aenean faucibus non leo in aliquet. Vestibulum luctus quis leo at pharetra. Donec a sapien sed est condimentum pulvinar. Vivamus ultrices fringilla massa nec varius. Aenean et convallis tellus. Donec semper dolor quis tellus scelerisque dictum. Cras posuere augue in turpis aliquet, sed mattis ante faucibus.&lt;/p&gt;&lt;p style=\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\\&quot;&gt;Pellentesque dapibus felis nulla, id vehicula ligula bibendum sed. Vestibulum in quam sed magna auctor iaculis. Vestibulum fermentum rutrum volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut in sollicitudin mi. Sed elit lorem, ultricies in hendrerit a, gravida et lorem. Donec sollicitudin ultrices diam et pellentesque. Integer tortor orci, commodo in felis id, rhoncus viverra mi. Fusce risus ligula, ullamcorper vitae ligula id, dictum ornare risus. Mauris bibendum blandit elementum. Etiam nec orci lacinia ligula pulvinar sagittis nec sed felis. Duis pharetra lacinia mattis. Etiam euismod ante quis ultricies porta. Fusce nec felis et neque lobortis vulputate.&lt;/p&gt;', 1, '2021-08-04 11:51:13'),
(2, 4, 10, 0, 'Fried Chicken', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:00:32'),
(3, 4, 12, 0, 'Chicken 101', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:06:41'),
(4, 1, 9, 1, 'Crispy Roasted Pork', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:08:08'),
(5, 5, 10, 3, 'Coffee 101', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:08:41'),
(6, 5, 11, 4, 'Soda 101', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:09:03'),
(7, 5, 10, 5, 'Wine 101', '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:09:29');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `order_id`, `total_amount`, `date_created`) VALUES
(1, 1, 8250, '2021-08-04 14:59:53'),
(2, 1, 6250, '2021-08-04 15:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(30) NOT NULL,
  `parent_id` int(30) NOT NULL,
  `sub_category` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `parent_id`, `sub_category`, `description`, `status`, `date_created`) VALUES
(1, 1, 'Pork', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 11:40:35'),
(2, 1, 'Beef', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed ex efficitur, sodales odio ac, fermentum purus. Vestibulum pretium mi dolor, varius bibendum nulla condimentum non. Aenean faucibus non leo in aliquet. Vestibulum luctus quis leo at pharetra. Donec a sapien sed est condimentum pulvinar. Vivamus ultrices fringilla massa nec varius. Aenean et convallis tellus. Donec semper dolor quis tellus scelerisque dictum. Cras posuere augue in turpis aliquet, sed mattis ante faucibus.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 11:47:06'),
(3, 5, 'Coffee', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:02:51'),
(4, 5, 'Soda', '&lt;p&gt;&lt;span style=&quot;text-align: justify;&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:03:44'),
(5, 5, 'Wine', '&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;Sed quam lorem, finibus vel sapien in, fermentum consectetur dolor. Sed in facilisis nulla. Cras fringilla sapien gravida est sollicitudin cursus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque et justo nec nisi eleifend auctor quis vitae ex. Donec tristique mattis libero ut porttitor. Curabitur convallis lectus eu purus laoreet, et pulvinar massa molestie. Nulla in tincidunt purus. In molestie porta ante et feugiat. Nullam facilisis lectus eu sem interdum, sed pulvinar arcu egestas.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 1, '2021-08-04 12:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Online Catering Reservation System'),
(6, 'short_name', 'Food Catering'),
(11, 'logo', 'uploads/1628047500_catering.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1628047500_banner.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
