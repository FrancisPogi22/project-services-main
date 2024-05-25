-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 12:46 AM
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
-- Database: `project_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_ban` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not_ban,1=ban',
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `is_ban`, `created_at`) VALUES
(1, 'Mark Lester Baza', 'mark@gmail.com', '$2y$10$x1KXJEw6ajKAYyCGyGC7S.PUlaNOtoiNf0WqczKLDmh1iR7K9uvwW', '1234', 0, '2024-03-07'),
(8, 'Jose Marichan', 'test@gmail.com', '$2y$10$yZl6..BRnZ0b2GLD5ID4fe0DQLKFa7CJKou.TqGFgPge24QDG.Uiu', '09522302132', 0, '2024-03-07'),
(9, 'Juan Dela Cruz', 'delacruz@gmail.com', '$2y$10$Xq9bjrm08/i0n4ELrCmPvenDPrwleCUn4Hlyl/WMjoZypT2X1uP/G', '09821829312', 0, '2024-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `MIDDLENAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `PHONE` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT current_timestamp(),
  `DATE` date NOT NULL,
  `STATUS` varchar(255) NOT NULL,
  `ACTION` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `FIRSTNAME`, `MIDDLENAME`, `LASTNAME`, `PHONE`, `EMAIL`, `TIME`, `DATE`, `STATUS`, `ACTION`) VALUES
(6, 'Mark Lester', 'M.', 'Villa', '09152846323', 'mark@gmail.com', '2024-03-20 10:36:23', '2024-03-20', 'Approved', ''),
(7, 'John Micheal', 'H.', 'Hulyan', '09123012012', 'flex@gmail.com', '2024-03-20 10:37:06', '2024-03-21', 'Approved', ''),
(8, 'Code', 'Juan', 'Text', '09872319129', 'newtext@gmail.com', '2024-03-20 10:37:26', '2024-03-22', 'Canceled', ''),
(9, 'Codey', 'M.', 'Max1', '09100120120', 'textTest@gmail.com', '2024-03-20 10:37:50', '2024-03-23', 'Canceled', ''),
(10, 'Test', 'Max', 'Sample', '09876451263', 'haha@gmail.com', '2024-03-20 11:08:01', '2024-03-20', 'Canceled', ''),
(11, 'John', 'Michael', 'Rizal', '09283818283', 'test@gmail.com', '2024-04-26 05:26:25', '2024-05-01', 'Approved', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `info` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `info`, `status`, `created_at`) VALUES
(1, 'Residential Construction', 'For the residential category purposes', 1, 0, '2024-03-01 00:55:42'),
(2, 'Commercial Construction', 'The Purpose for Commercial Builds', 0, 0, '2024-03-01 00:58:44'),
(3, 'Industrial Construction', 'Industrial Company Environment', 0, 0, '2024-03-01 08:36:09'),
(10, 'Test Category', 'Test', 0, 0, '2024-04-19 10:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `status`, `created_at`) VALUES
(1, 'Efraim Encarnacion Updated', 'efpogi@gmail.com', '1234', 1, '2024-03-11'),
(3, 'Mark Aaron Dinco', 'makmak@gmail.com', '09872382818', 0, '2024-03-13'),
(5, 'Jose Mario Hency', 'test@gmail.com', '09876544312', 0, '2024-03-13'),
(6, 'New Customer', 'new@gmail.com', '12345', 0, '2024-03-15'),
(7, 'Mark Shane', 'shane@gmail.com', '123456', 1, '2024-03-16'),
(8, 'John Michael', 'juanmichael@gmail.com', '123456789', 1, '2024-03-20'),
(9, 'Mark Lester Villa', 'villamarklester756@gmail.com', '09152846323', 0, '2024-04-11'),
(10, 'Lester Baza', 'lester@gmail.com', '09557264223', 0, '2024-05-13'),
(11, 'Code Test', 'codetest@gmail.com', '0987654321', 0, '2024-05-13');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `image`, `name`, `age`, `email`, `contact`, `address`, `position`, `status`) VALUES
(22, 'dinco.png', 'Mark Aaron Dinco', '22', 'dincs@gmail.com', '09771920192', '<p>ad</p>', 'Project Manager', 0),
(23, 'mae.png', 'Jochele Mae Pastor', '21', 'mam@gmail.com', '09861238192', '<p>adadad</p>', 'Project Manager', 0),
(24, 'arvin.png', 'Arvin Clyde Faustino', '22', 'adada@gmail.com', '09712930192', '<p>adada</p>', 'Project Manager', 0),
(25, 'retardo.png', 'Mark Ivan Shane Retardo', '22', 'markrakrka@gmail.com', '09872819201', '<p>Blk 1 Lot 1 St. Barangay St. Provice City</p>', 'Foreman', 0),
(26, 'efraim.png', 'Efraim Encarnacion', '23', 'huhu@gmail.com', '09280192035', '<p>Blk 00 Lot 99 St. Barangay Street City</p>', 'Worker', 0),
(27, 'yis.png', 'Elisha Danielle Batayon', '22', 'eh@gmail.com', '09122030212', '<p>Blk 1 Lot 1 City Province</p>', 'Worker', 0),
(28, 'Screenshot 2023-10-04 191600.png', 'Mark Lester Villa', '23', 'marklestervilla01@gmail.com', '6543756487', '<p>Blk 1 Lot 99 St, Area 200</p>', 'Worker', 0),
(29, 'Screenshot 2023-10-04 134307.png', 'Grace Baza', '68', 'Dummy@gmail.com', '6543756487', '<p>Area Brgy 100 St. Village</p>', 'HR Manager', 0),
(30, 'Screenshot 2023-10-04 134401.png', 'Edgardo Baza', '72', 'testtt@gmail.com', '190249823', '<p>Brgy Subd Mahigit Area 101</p>', 'Electrical Tech', 0);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `image`, `name`, `value`, `note`, `status`) VALUES
(11, 'scissor.png', 'Scissor', '50', '<p>Used by Admin 2</p>', 3),
(12, 'saw.png', 'Saw', '500', '<p>Broken Saw at repair shop</p>', 2),
(13, 'mallet.png', 'Mallet', '400', '<p>Check</p>', 0),
(15, 'ax.png', 'Axe', '600', '<p>Out of Sharp</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `payment_mode` varchar(100) NOT NULL COMMENT 'cash, online',
  `order_placed_by_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `order_date`, `order_status`, `payment_mode`, `order_placed_by_id`) VALUES
(13, 1, '84797', 'INV-362908', '4220', '2024-03-14', 'booked', 'Cash Payment', 0),
(14, 5, '91483', 'INV-186102', '4100', '2024-03-15', 'booked', 'Cash Payment', 0),
(15, 1, '83092', 'INV-480399', '1820', '2024-03-15', 'booked', 'Cash Payment', 0),
(16, 6, '76174', 'INV-364943', '6560', '2024-03-15', 'booked', 'Cash Payment', 0),
(17, 1, '37218', 'INV-571284', '1000', '2024-03-15', 'booked', 'Cash Payment', 0),
(18, 6, '14140', 'INV-268763', '500', '2024-03-15', 'booked', 'Online Payment', 0),
(19, 1, '40527', 'INV-877911', '1360', '2024-03-15', 'booked', 'Cash Payment', 0),
(20, 7, '51342', 'INV-250887', '960', '2024-03-16', 'booked', 'Online Payment', 0),
(21, 7, '90669', 'INV-332933', '2500', '2024-03-16', 'booked', 'Cash Payment', 0),
(22, 7, '38693', 'INV-818834', '1080', '2024-03-16', 'booked', 'Cash Payment', 0),
(23, 6, '46313', 'INV-673294', '2700', '2024-03-21', 'booked', 'Online Payment', 0),
(24, 6, '52885', 'INV-694249', '6720', '2024-04-04', 'booked', 'Cash Payment', 0),
(25, 6, '44680', 'INV-248982', '2100', '2024-04-10', 'booked', 'Cash Payment', 0),
(26, 1, '78954', 'INV-427396', '480', '2024-04-11', 'booked', 'Cash Payment', 0),
(27, 7, '71644', 'INV-900824', '1000', '2024-04-11', 'booked', 'Online Payment', 0),
(28, 1, '45992', 'INV-690918', '120', '2024-04-11', 'booked', 'Cash Payment', 0),
(29, 7, '11144', 'INV-728600', '1000', '2024-04-11', 'booked', 'Online Payment', 0),
(30, 6, '23981', 'INV-591143', '2900', '2024-04-11', 'booked', 'Online Payment', 0),
(31, 9, '19356', 'INV-528845', '26520', '2024-04-11', 'booked', 'Cash Payment', 0),
(32, 6, '44510', 'INV-461391', '120', '2024-04-11', 'booked', 'Cash Payment', 0),
(33, 1, '54453', 'INV-866423', '120', '2024-04-11', 'booked', 'Cash Payment', 0),
(34, 10, '51239', 'INV-901236', '3900', '2024-05-13', 'booked', 'Cash Payment', 0),
(35, 11, '71341', 'INV-706440', '2920', '2024-05-13', 'booked', 'Cash Payment', 0),
(36, 9, '44751', 'INV-464917', '1820', '2024-05-13', 'booked', 'Cash Payment', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 10, '120', '1'),
(2, 1, 11, '1000', '1'),
(3, 1, 12, '500', '1'),
(4, 2, 10, '120', '1'),
(5, 3, 10, '120', '1'),
(6, 4, 10, '120', '1'),
(7, 5, 10, '120', '1'),
(8, 6, 12, '500', '12'),
(9, 7, 12, '500', '2'),
(10, 7, 11, '1000', '1'),
(11, 8, 10, '120', '1'),
(12, 8, 11, '1000', '1'),
(13, 9, 12, '500', '1'),
(14, 9, 10, '120', '1'),
(15, 9, 11, '1000', '1'),
(16, 9, 13, '1200', '1'),
(17, 9, 17, '100', '1'),
(18, 10, 11, '1000', '12'),
(19, 10, 10, '120', '1'),
(20, 11, 10, '120', '2'),
(21, 11, 11, '1000', '1'),
(22, 12, 11, '1000', '3'),
(23, 13, 12, '500', '1'),
(24, 13, 10, '120', '1'),
(25, 13, 13, '1200', '3'),
(26, 14, 10, '120', '20'),
(27, 14, 12, '500', '1'),
(28, 14, 13, '1200', '1'),
(29, 15, 12, '500', '1'),
(30, 15, 10, '120', '1'),
(31, 15, 13, '1200', '1'),
(32, 16, 13, '1200', '1'),
(33, 16, 11, '1000', '5'),
(34, 16, 10, '120', '3'),
(35, 17, 17, '100', '10'),
(36, 18, 17, '100', '5'),
(37, 19, 11, '1000', '1'),
(38, 19, 10, '120', '3'),
(39, 20, 10, '120', '3'),
(40, 20, 12, '500', '1'),
(41, 20, 17, '100', '1'),
(42, 21, 12, '500', '5'),
(43, 22, 10, '120', '9'),
(44, 23, 12, '500', '1'),
(45, 23, 13, '1200', '1'),
(46, 23, 11, '1000', '1'),
(47, 24, 11, '1000', '6'),
(48, 24, 10, '120', '6'),
(49, 25, 10, '120', '5'),
(50, 25, 11, '1000', '1'),
(51, 25, 12, '500', '1'),
(52, 26, 10, '120', '4'),
(53, 27, 11, '1000', '1'),
(54, 28, 10, '120', '1'),
(55, 29, 11, '1000', '1'),
(56, 30, 17, '100', '5'),
(57, 30, 13, '1200', '2'),
(58, 31, 10, '120', '16'),
(59, 31, 11, '1000', '10'),
(60, 31, 12, '500', '10'),
(61, 31, 13, '1200', '8'),
(62, 32, 10, '120', '1'),
(63, 33, 10, '120', '1'),
(64, 34, 11, '1000', '1'),
(65, 34, 13, '1200', '2'),
(66, 34, 12, '500', '1'),
(67, 35, 10, '120', '1'),
(68, 35, 11, '1000', '1'),
(69, 35, 12, '500', '1'),
(70, 35, 13, '1200', '1'),
(71, 35, 17, '100', '1'),
(72, 36, 10, '120', '1'),
(73, 36, 12, '500', '1'),
(74, 36, 13, '1200', '1');

-- --------------------------------------------------------

--
-- Table structure for table `poscategories`
--

CREATE TABLE `poscategories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=visible,1=hidden'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poscategories`
--

INSERT INTO `poscategories` (`id`, `name`, `description`, `status`) VALUES
(1, 'Wood', 'This is a wood description update', 0),
(2, 'Metal', 'Metal Description', 0),
(7, 'Plastic', 'Plastic Description', 0),
(8, 'Glass', 'Glass Description', 0),
(9, 'Miscellanous', 'Necessities', 0),
(10, 'Stone', 'Stones Description', 0);

-- --------------------------------------------------------

--
-- Table structure for table `productivity`
--

CREATE TABLE `productivity` (
  `id` int(11) NOT NULL,
  `task_id` int(100) NOT NULL,
  `description` text NOT NULL,
  `start_duration` datetime NOT NULL,
  `end_duration` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=Pending,1=Preparing,2=On-Progress,3=Done,4=Cancelled',
  `priority` int(11) NOT NULL COMMENT '0=Low,=1=Medium,2=High',
  `employee` varchar(255) NOT NULL,
  `equipment` varchar(255) NOT NULL,
  `material` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productivity`
--

INSERT INTO `productivity` (`id`, `task_id`, `description`, `start_duration`, `end_duration`, `status`, `priority`, `employee`, `equipment`, `material`, `date_created`) VALUES
(7, 34, 'Proceeding to plan', '2024-05-11 17:45:00', '2024-05-29 22:48:00', 1, 2, 'Mark Ivan Shane Retardo (Foreman), Efraim Encarnacion (Worker)', 'Scissor', 'Planks, Reinforce, Glass, Steel, Brick', '2024-05-11 17:45:22'),
(8, 35, 'On the procedure and buying pieces of stuff', '2024-05-11 17:47:00', '2024-05-22 21:47:00', 2, 1, 'Efraim Encarnacion (Worker)', 'Mallet, Axe', 'Planks, Reinforce, Glass, Steel, Brick', '2024-05-11 17:48:05'),
(9, 35, 'Buying other utensils', '2024-05-21 17:49:00', '2024-05-08 17:49:00', 1, 1, 'Elisha Danielle Batayon (Worker)', 'Mallet', 'Reinforce', '2024-05-11 17:49:13'),
(10, 36, 'To be process', '2024-05-11 17:50:00', '2024-05-30 17:50:00', 2, 2, 'Mark Lester Villa (Worker)', 'Axe', 'Steel', '2024-05-11 17:50:58'),
(11, 37, 'test', '2024-05-30 23:53:00', '2024-06-01 23:53:00', 2, 0, 'Efraim Encarnacion (Worker)', 'Mallet', 'Steel', '2024-05-14 23:53:45'),
(12, 37, 'test 2', '2024-05-29 23:54:00', '2024-05-30 23:54:00', 2, 0, 'Mark Lester Villa (Worker)', 'Mallet', 'Steel', '2024-05-14 23:54:45'),
(13, 35, 'cdede', '2024-05-25 23:57:00', '2024-05-28 23:57:00', 2, 1, 'Efraim Encarnacion (Worker)', 'Axe', 'Glass', '2024-05-14 23:57:10'),
(14, 37, 'aaaa', '2024-05-24 23:58:00', '2024-06-01 23:58:00', 3, 0, 'Elisha Danielle Batayon (Worker)', 'Mallet', 'Steel', '2024-05-14 23:58:15');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=visible,1=hidden',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `quantity`, `image`, `status`, `created_at`) VALUES
(10, 7, 'Planks', '#', 120, 55, 'assets/uploads/products/1709971991.png', 0, '2024-03-09'),
(11, 2, 'Reinforce', '#', 1000, 72, 'assets/uploads/products/1709972219.png', 0, '2024-03-09'),
(12, 8, 'Glass', '#', 500, 78, 'assets/uploads/products/1709972466.png', 0, '2024-03-09'),
(13, 2, 'Steel', '#', 1200, 83, 'assets/uploads/products/1710145251.png', 0, '2024-03-11'),
(17, 10, 'Brick', '#', 100, 78, 'assets/uploads/products/1710236675.png', 0, '2024-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `customers_id` int(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_start` varchar(255) NOT NULL,
  `due_date` varchar(255) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `project_num_task` int(11) NOT NULL,
  `task_num_completed` int(11) NOT NULL DEFAULT 0,
  `project_progress` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `category_id`, `project_name`, `customers_id`, `description`, `address`, `position`, `image`, `date_start`, `due_date`, `time_created`, `project_num_task`, `task_num_completed`, `project_progress`, `status`) VALUES
(1, 10, 'First Project', 6, 'Lorem Ipsum', 'Lorem Ipsum', 'Mark Aaron Dinco', 'House.jpg', '2024-05-23', '2024-05-23', '2024-05-23 09:29:56', 3, 3, 100, 3);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `workers` varchar(255) NOT NULL,
  `materials` varchar(255) NOT NULL,
  `equipments` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` mediumint(10) NOT NULL COMMENT '0=Pending,1=Preparing,2=On-Progress,3=Completed,4=Cancelled',
  `priority` mediumint(10) NOT NULL COMMENT '0=Low,1=Medium,2=High'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `project_id`, `task_name`, `description`, `start_date`, `due_date`, `created_at`, `status`, `priority`) VALUES
(47, 1, 'Task Task', 'Lorem Ipsum', '2024-05-23 17:28:00', '2024-05-27 17:28:00', '2024-05-23 09:29:56', 3, 1),
(48, 1, 'Second Task', 'Ipsum Lorem', '2024-05-23 17:29:00', '2024-05-25 17:29:00', '2024-05-23 09:29:56', 1, 1),
(49, 1, 'Third Task', 'Sugoma', '2024-05-23 17:29:00', '2024-05-25 17:29:00', '2024-05-23 09:29:56', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=User, 1=Admin, 2=Staff',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role_as`, `created_at`) VALUES
(10, 'Mark Lester Villa', 'admin@gmail.com', '(+63) 915 284 6323', '1234', 1, NULL),
(20, 'Mark Code', 'user@gmail.com', '(+63) 987 213 0123', '1234', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poscategories`
--
ALTER TABLE `poscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productivity`
--
ALTER TABLE `productivity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `poscategories`
--
ALTER TABLE `poscategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `productivity`
--
ALTER TABLE `productivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
