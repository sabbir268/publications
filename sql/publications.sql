-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2019 at 08:12 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `publications`
--

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `arm_paid_am` (`p_a_id` INT(15), `p_e_id` INT(15)) RETURNS FLOAT(15,2) BEGIN
	DECLARE v_paid_am float(15,2) ;
	SELECT SUM(authors_pay.pay_am) INTO v_paid_am FROM authors_pay WHERE authors_pay.a_id = p_a_id AND authors_pay.e_id = p_e_id;
	
	IF v_paid_am IS NULL
		THEN
		SET v_paid_am = 0;
	END IF;
	
	RETURN v_paid_am;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `grand_total_am` (`p_o_id` INT(15)) RETURNS FLOAT(15,2) BEGIN
	DECLARE v_g_total_price float(15,2);
	DECLARE v_disc_am float(15,2);
	DECLARE v_disc_per float(15,2);
	DECLARE v_disc_per_am float(15,2);
	DECLARE v_total_disc float(15,2);
	
	SELECT orders.o_disc INTO v_disc_am FROM orders WHERE orders.o_id = p_o_id;
	SELECT orders.o_disc_per INTO v_disc_per FROM orders WHERE orders.o_id = p_o_id;
	
	SET v_disc_per_am = ((total_orders_price(p_o_id)*v_disc_per)/100);
	
	SET v_total_disc = v_disc_am + v_disc_per_am;
	
	SET v_g_total_price = (total_orders_price(p_o_id)-v_total_disc);
	
	RETURN v_g_total_price;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `last_arm_id` (`p_a_id` INT(15)) RETURNS INT(15) BEGIN
	DECLARE v_last_arm_id int(15);
	SELECT max(arm_id) INTO v_last_arm_id FROM author_rm WHERE a_id = p_a_id;
	RETURN v_last_arm_id;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_exp_am` (`p_e_id` INT(15)) RETURNS FLOAT(15,2) BEGIN
	DECLARE v_total_expected_amount float(15,2);
	DECLARE v_b_price float(15,2);
	DECLARE v_total_copy float(15,2);
	SELECT editions.b_price ,  editions.ttl_copy INTO v_b_price , v_total_copy FROM editions WHERE editions.e_id = p_e_id;
	SET v_total_expected_amount = (v_total_copy*v_b_price);
	
	RETURN v_total_expected_amount;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_orders_item` (`p_o_id` INT(15)) RETURNS INT(15) BEGIN
	DECLARE v_total_items int(15);
	
	SELECT SUM(order_details.qty) INTO v_total_items FROM order_details WHERE order_details.o_id = p_o_id;
	
	RETURN v_total_items;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_orders_price` (`p_o_id` INT(15)) RETURNS FLOAT(15,2) BEGIN
	DECLARE v_total_price float(15,2) ;
	SELECT SUM(order_details_view.t_price) INTO v_total_price FROM order_details_view WHERE order_details_view.o_id = p_o_id;
	RETURN v_total_price;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tottal_copy_soled` (`p_e_id` INT(15)) RETURNS INT(15) BEGIN
	DECLARE v_total int(15) ;
	SELECT SUM(order_details.qty) INTO v_total FROM order_details WHERE order_details.e_id = p_e_id ;
	
	IF v_total IS NULL
		THEN
		SET v_total = 0;
	END IF;
	
	RETURN v_total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `a_id` int(10) NOT NULL,
  `a_name` varchar(45) NOT NULL,
  `a_phn` varchar(45) NOT NULL,
  `a_mail` varchar(100) NOT NULL,
  `a_addr` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`a_id`, `a_name`, `a_phn`, `a_mail`, `a_addr`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'তামিম শাহারিয়ার সুবিন', '016419823984', '', 'Jessore', '2019-01-07 07:11:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'তাহামিদ রাফি', '0182389734', '', 'Jhinadaha', '2019-01-07 07:11:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'মোঃ মাহাবুবুল হাসান', '0129832932', '', 'Magura', '2019-01-07 07:11:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `authors_pay`
--

CREATE TABLE `authors_pay` (
  `ap_id` int(15) NOT NULL,
  `a_id` int(10) NOT NULL,
  `e_id` int(10) NOT NULL,
  `pay_am` float(15,2) NOT NULL,
  `pay_date` date NOT NULL,
  `remarks` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authors_pay`
--

INSERT INTO `authors_pay` (`ap_id`, `a_id`, `e_id`, `pay_am`, `pay_date`, `remarks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 2, 10000.00, '2019-01-15', 'Given.......bla bla ', '2019-01-05 19:03:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `authors_pay_view`
-- (See below for the actual view)
--
CREATE TABLE `authors_pay_view` (
`ap_id` int(15)
,`a_id` int(10)
,`a_name` varchar(45)
,`e_id` int(10)
,`b_name` text
,`pay_am` float(15,2)
,`pay_date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `author_rm`
--

CREATE TABLE `author_rm` (
  `arm_id` int(10) NOT NULL,
  `a_id` int(10) NOT NULL,
  `e_id` int(10) NOT NULL,
  `allot_per` float(15,2) NOT NULL,
  `allot_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author_rm`
--

INSERT INTO `author_rm` (`arm_id`, `a_id`, `e_id`, `allot_per`, `allot_date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 3.00, '2019-01-08', '2019-01-03 22:16:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 1, 5.00, '2019-01-08', '2019-01-03 22:16:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 1, 2.00, '2019-01-08', '2019-01-03 22:16:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 3, 2, 20.00, '2019-01-09', '2019-01-05 19:05:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `author_rm_view`
-- (See below for the actual view)
--
CREATE TABLE `author_rm_view` (
`arm_id` int(10)
,`a_id` int(10)
,`a_name` varchar(45)
,`e_id` int(10)
,`b_name` text
,`allot_per` float(15,2)
,`allot_am` decimal(15,2)
,`paid_am` float(15,2)
,`due_am` double(19,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `b_id` int(10) NOT NULL,
  `b_name` text NOT NULL,
  `b_isbn` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`b_id`, `b_name`, `b_isbn`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'প্রোগ্রামিং এর ৫২ টি সমস্যা ও সমাধান', '234-4344-342', '2019-01-02 06:59:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'প্রোগ্রামিং কন্টেস্ট , ডাটা স্ট্রাকচার ও এলগরিদম', '2349-234-23423-324', '2019-01-02 06:53:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `book_auth`
--

CREATE TABLE `book_auth` (
  `ba_id` int(10) NOT NULL,
  `b_id` int(10) NOT NULL,
  `a_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book_auth`
--

INSERT INTO `book_auth` (`ba_id`, `b_id`, `a_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2019-01-02 06:59:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, '2019-01-02 06:59:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 3, '2019-01-02 06:59:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 3, '2019-01-02 06:53:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `book_auth_view`
-- (See below for the actual view)
--
CREATE TABLE `book_auth_view` (
`ba_id` int(10)
,`b_id` int(10)
,`b_name` text
,`a_id` int(10)
,`a_name` varchar(45)
);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `c_id` int(10) NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_addr` varchar(255) NOT NULL,
  `c_phn` varchar(12) NOT NULL,
  `c_mail` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_id`, `c_name`, `c_addr`, `c_phn`, `c_mail`, `created_at`, `updated_at`, `deleted_at`) VALUES
(0, '', '', '', '', '2019-01-06 11:20:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1, 'হাসান বুক ডিপো', 'Jashore, Khulna , Bangladesh', '016631776875', 'hasan.bookdipo@gmail.com', '2019-01-02 19:41:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'জহির বুক ডিপো', 'jesshore, Khulna , Bangladesh', '01911223344', 'johir@gmail.com', '2019-01-02 19:02:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'সুমন বুক হাউজ', 'Jashore', '0120934343', 'sumon@ham.com', '2019-01-02 20:26:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'আলাআমিন লাইব্রেরি', 'চাড়াভিটা বাজার, বাঘারপাড়া , যশোর।', '01775280411', 'alamin@gmail.com', '2019-01-06 06:15:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `editions`
--

CREATE TABLE `editions` (
  `e_id` int(10) NOT NULL,
  `b_id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `pr_date` date NOT NULL,
  `ttl_copy` int(10) NOT NULL,
  `pr_cost` float(15,2) NOT NULL,
  `b_price` float(15,2) NOT NULL,
  `ttl_edition` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `editions`
--

INSERT INTO `editions` (`e_id`, `b_id`, `p_id`, `pr_date`, `ttl_copy`, `pr_cost`, `b_price`, `ttl_edition`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2019-01-08', 100, 140.00, 300.00, 1, '2019-01-03 22:16:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2, 1, '2019-01-09', 500, 200.00, 400.00, 1, '2019-01-05 19:05:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `exp_id` int(10) NOT NULL,
  `exp_type` enum('1','2','3','4') NOT NULL,
  `amount` float(15,2) NOT NULL,
  `exp_date` date NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `log`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'added a book', '2019-01-02 06:59:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'added a book', '2019-01-02 06:53:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'made a editions', '2019-01-02 06:58:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 'made a editions', '2019-01-02 06:55:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 'Logged In at', '2019-01-02 11:47:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, 'Logged In at', '2019-01-02 11:48:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, 'added a customers from quick add', '2019-01-02 18:40:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 'added a customers from quick add', '2019-01-02 18:44:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 1, 'added a customers from quick add', '2019-01-02 18:21:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, 'added a customers from quick add', '2019-01-02 18:37:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, 'added a customers from quick add', '2019-01-02 18:20:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 'added a customers from quick add', '2019-01-02 18:32:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, 'added a customers from quick add', '2019-01-02 18:39:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, 'added a customers from quick add', '2019-01-02 18:45:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 1, 'added a customers from quick add', '2019-01-02 18:32:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, 'added a customers from quick add', '2019-01-02 18:42:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, 'added a customers from quick add', '2019-01-02 18:24:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 1, 'added a customers from quick add', '2019-01-02 18:07:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 1, 'added a customers from quick add', '2019-01-02 18:11:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, 'added a customers from quick add', '2019-01-02 18:40:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 1, 'added a customers from quick add', '2019-01-02 18:19:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, 'added a customers from quick add', '2019-01-02 18:58:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 1, 'added a customers from quick add', '2019-01-02 18:48:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 1, 'added a customers from quick add', '2019-01-02 18:33:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 1, 'added a customers from quick add', '2019-01-02 19:41:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 1, 'added a customers from quick add', '2019-01-02 19:02:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 1, 'added a customers from quick add', '2019-01-02 20:26:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 1, 'made a editions', '2019-01-03 22:16:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 1, 'made a editions', '2019-01-05 19:05:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 1, 'added a customers from quick add', '2019-01-06 06:15:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 1, 'Logged In at', '2019-01-06 18:18:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(10) NOT NULL,
  `c_id` int(15) NOT NULL,
  `order_date` date NOT NULL,
  `o_disc` float(15,2) NOT NULL,
  `o_disc_per` float(15,2) NOT NULL,
  `o_paid_am` float(15,2) NOT NULL,
  `status` tinyint(5) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `c_id`, `order_date`, `o_disc`, `o_disc_per`, `o_paid_am`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, '2019-01-06', 0.00, 5.00, 9615.00, 0, '2019-01-06 12:17:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 3, '2019-01-06', 1000.00, 0.00, 9000.00, 0, '2019-01-06 12:20:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `orders_view`
-- (See below for the actual view)
--
CREATE TABLE `orders_view` (
`o_id` int(10)
,`c_id` int(15)
,`order_date` date
,`total_item` int(15)
,`total_am` float(15,2)
,`disc_am` float(15,2)
,`disc_per` float(15,2)
,`disc_per_am` decimal(15,2)
,`g_total_am` float(15,2)
,`paid_am` float(15,2)
,`due_am` double(19,2)
,`status` tinyint(5)
);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `od_id` int(10) NOT NULL,
  `o_id` int(10) NOT NULL,
  `e_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `disc` float(15,2) NOT NULL,
  `disc_per` float(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`od_id`, `o_id`, `e_id`, `qty`, `disc`, `disc_per`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 10, 0.00, 10.00, '2019-01-06 12:26:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, 100, 1000.00, 0.00, '2019-01-06 12:37:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 2, 50, 0.00, 0.00, '2019-01-06 12:18:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 2, 50, 0.00, 0.00, '2019-01-06 12:24:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_details_view`
-- (See below for the actual view)
--
CREATE TABLE `order_details_view` (
`od_id` int(10)
,`o_id` int(10)
,`e_id` int(10)
,`b_id` int(10)
,`book_name` text
,`editions` int(5)
,`body_rate` float(15,2)
,`qty` int(10)
,`price` double(19,2)
,`disc_am` float(15,2)
,`disc_per` float(15,2)
,`t_price` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `printers`
--

CREATE TABLE `printers` (
  `p_id` int(10) NOT NULL,
  `p_name` varchar(45) NOT NULL,
  `p_addr` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `printers`
--

INSERT INTO `printers` (`p_id`, `p_name`, `p_addr`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'New Printing', 'Jessore, Jame moshzid Lane', '2018-12-31 18:36:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_view`
-- (See below for the actual view)
--
CREATE TABLE `stock_view` (
`e_id` int(10)
,`b_id` int(10)
,`book_name` text
,`total_copy` int(10)
,`stock` bigint(16)
,`total_sold` int(15)
,`editions` int(5)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(111) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `role`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'Admin', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2018-10-31 19:23:25', '2018-07-18 18:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure for view `authors_pay_view`
--
DROP TABLE IF EXISTS `authors_pay_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `authors_pay_view`  AS  select `authors_pay`.`ap_id` AS `ap_id`,`authors_pay`.`a_id` AS `a_id`,`authors`.`a_name` AS `a_name`,`authors_pay`.`e_id` AS `e_id`,`books`.`b_name` AS `b_name`,`authors_pay`.`pay_am` AS `pay_am`,`authors_pay`.`pay_date` AS `pay_date` from (((`authors_pay` join `authors`) join `editions`) join `books`) where ((`authors_pay`.`a_id` = `authors`.`a_id`) and (`authors_pay`.`e_id` = `editions`.`e_id`) and (`editions`.`b_id` = `books`.`b_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `author_rm_view`
--
DROP TABLE IF EXISTS `author_rm_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `author_rm_view`  AS  select `author_rm`.`arm_id` AS `arm_id`,`author_rm`.`a_id` AS `a_id`,`authors`.`a_name` AS `a_name`,`author_rm`.`e_id` AS `e_id`,`books`.`b_name` AS `b_name`,`author_rm`.`allot_per` AS `allot_per`,cast(((`total_exp_am`(`editions`.`e_id`) * `author_rm`.`allot_per`) / 100) as decimal(15,2)) AS `allot_am`,`arm_paid_am`(`author_rm`.`a_id`,`author_rm`.`e_id`) AS `paid_am`,(cast(((`total_exp_am`(`editions`.`e_id`) * `author_rm`.`allot_per`) / 100) as decimal(15,2)) - `arm_paid_am`(`author_rm`.`a_id`,`author_rm`.`e_id`)) AS `due_am` from (((`author_rm` join `authors`) join `editions`) join `books`) where ((`author_rm`.`a_id` = `authors`.`a_id`) and (`author_rm`.`e_id` = `editions`.`e_id`) and (`editions`.`b_id` = `books`.`b_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `book_auth_view`
--
DROP TABLE IF EXISTS `book_auth_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `book_auth_view`  AS  select `book_auth`.`ba_id` AS `ba_id`,`book_auth`.`b_id` AS `b_id`,`books`.`b_name` AS `b_name`,`book_auth`.`a_id` AS `a_id`,`authors`.`a_name` AS `a_name` from ((`book_auth` join `books`) join `authors`) where ((`book_auth`.`b_id` = `books`.`b_id`) and (`book_auth`.`a_id` = `authors`.`a_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `orders_view`
--
DROP TABLE IF EXISTS `orders_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `orders_view`  AS  select `orders`.`o_id` AS `o_id`,`orders`.`c_id` AS `c_id`,`orders`.`order_date` AS `order_date`,`total_orders_item`(`orders`.`o_id`) AS `total_item`,`total_orders_price`(`orders`.`o_id`) AS `total_am`,`orders`.`o_disc` AS `disc_am`,`orders`.`o_disc_per` AS `disc_per`,cast(((`total_orders_price`(`orders`.`o_id`) * `orders`.`o_disc_per`) / 100) as decimal(15,2)) AS `disc_per_am`,`grand_total_am`(`orders`.`o_id`) AS `g_total_am`,`orders`.`o_paid_am` AS `paid_am`,(`grand_total_am`(`orders`.`o_id`) - `orders`.`o_paid_am`) AS `due_am`,`orders`.`status` AS `status` from `orders` ;

-- --------------------------------------------------------

--
-- Structure for view `order_details_view`
--
DROP TABLE IF EXISTS `order_details_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_details_view`  AS  select `order_details`.`od_id` AS `od_id`,`order_details`.`o_id` AS `o_id`,`order_details`.`e_id` AS `e_id`,`editions`.`b_id` AS `b_id`,`books`.`b_name` AS `book_name`,`editions`.`ttl_edition` AS `editions`,`editions`.`b_price` AS `body_rate`,`order_details`.`qty` AS `qty`,(`editions`.`b_price` * `order_details`.`qty`) AS `price`,`order_details`.`disc` AS `disc_am`,`order_details`.`disc_per` AS `disc_per`,cast(((`editions`.`b_price` * `order_details`.`qty`) - (`order_details`.`disc` + (((`editions`.`b_price` * `order_details`.`qty`) * `order_details`.`disc_per`) / 100))) as decimal(15,2)) AS `t_price` from ((`order_details` join `editions`) join `books`) where ((`order_details`.`e_id` = `editions`.`e_id`) and (`editions`.`b_id` = `books`.`b_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `stock_view`
--
DROP TABLE IF EXISTS `stock_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_view`  AS  select `editions`.`e_id` AS `e_id`,`editions`.`b_id` AS `b_id`,`books`.`b_name` AS `book_name`,`editions`.`ttl_copy` AS `total_copy`,(`editions`.`ttl_copy` - `tottal_copy_soled`(`editions`.`e_id`)) AS `stock`,`tottal_copy_soled`(`editions`.`e_id`) AS `total_sold`,`editions`.`ttl_edition` AS `editions` from (`editions` join `books`) where (`editions`.`b_id` = `books`.`b_id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `authors_pay`
--
ALTER TABLE `authors_pay`
  ADD PRIMARY KEY (`ap_id`),
  ADD KEY `fkIdx_184` (`a_id`),
  ADD KEY `fkIdx_187` (`e_id`);

--
-- Indexes for table `author_rm`
--
ALTER TABLE `author_rm`
  ADD PRIMARY KEY (`arm_id`),
  ADD KEY `fkIdx_142` (`a_id`),
  ADD KEY `fkIdx_165` (`e_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `book_auth`
--
ALTER TABLE `book_auth`
  ADD PRIMARY KEY (`ba_id`),
  ADD KEY `fkIdx_149` (`a_id`),
  ADD KEY `fkIdx_152` (`b_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `editions`
--
ALTER TABLE `editions`
  ADD PRIMARY KEY (`e_id`),
  ADD KEY `fkIdx_61` (`b_id`),
  ADD KEY `fkIdx_64` (`p_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `fkIdx_111` (`e_id`),
  ADD KEY `fkIdx_114` (`o_id`);

--
-- Indexes for table `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `a_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `authors_pay`
--
ALTER TABLE `authors_pay`
  MODIFY `ap_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `author_rm`
--
ALTER TABLE `author_rm`
  MODIFY `arm_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_auth`
--
ALTER TABLE `book_auth`
  MODIFY `ba_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `c_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `editions`
--
ALTER TABLE `editions`
  MODIFY `e_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `exp_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `o_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `od_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `printers`
--
ALTER TABLE `printers`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors_pay`
--
ALTER TABLE `authors_pay`
  ADD CONSTRAINT `FK_184` FOREIGN KEY (`a_id`) REFERENCES `authors` (`a_id`),
  ADD CONSTRAINT `FK_187` FOREIGN KEY (`e_id`) REFERENCES `editions` (`e_id`);

--
-- Constraints for table `author_rm`
--
ALTER TABLE `author_rm`
  ADD CONSTRAINT `FK_142` FOREIGN KEY (`a_id`) REFERENCES `authors` (`a_id`),
  ADD CONSTRAINT `FK_165` FOREIGN KEY (`e_id`) REFERENCES `editions` (`e_id`);

--
-- Constraints for table `book_auth`
--
ALTER TABLE `book_auth`
  ADD CONSTRAINT `FK_149` FOREIGN KEY (`a_id`) REFERENCES `authors` (`a_id`),
  ADD CONSTRAINT `FK_152` FOREIGN KEY (`b_id`) REFERENCES `books` (`b_id`);

--
-- Constraints for table `editions`
--
ALTER TABLE `editions`
  ADD CONSTRAINT `FK_61` FOREIGN KEY (`b_id`) REFERENCES `books` (`b_id`),
  ADD CONSTRAINT `FK_64` FOREIGN KEY (`p_id`) REFERENCES `printers` (`p_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_111` FOREIGN KEY (`e_id`) REFERENCES `books` (`b_id`),
  ADD CONSTRAINT `FK_114` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
