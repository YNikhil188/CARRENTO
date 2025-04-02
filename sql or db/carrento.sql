-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 05:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrento`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `user_id`, `title`, `content`, `image`, `createdon`) VALUES
(1, 1, 'goa tour', 'its a fantastic and marvelous trip', '673dfc769f837_sedan.jpg', '2024-11-20 15:12:54'),
(2, 1, 'kerala trip', 'it is an adventrous trip', '673e19d93b349_off-road.jpg', '2024-11-20 17:18:17'),
(3, 1, 'madurai', 'super', '67417461d7793_off road.png', '2024-11-23 06:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `model` varchar(255) DEFAULT NULL,
  `returned_date` date DEFAULT NULL,
  `return_location` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_cancellations`
--

CREATE TABLE `booking_cancellations` (
  `cancellation_id` int(11) NOT NULL,
  `booking_id` varchar(50) DEFAULT NULL,
  `cancellation_date` date DEFAULT NULL,
  `refund_amount` double DEFAULT NULL,
  `refund_percentage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `model` varchar(100) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `gearbox` varchar(50) NOT NULL,
  `fuel` varchar(50) NOT NULL,
  `doors` int(11) NOT NULL,
  `air_conditioner` varchar(50) NOT NULL,
  `seats` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `status` varchar(255) DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `image`, `model`, `price_per_day`, `gearbox`, `fuel`, `doors`, `air_conditioner`, `seats`, `latitude`, `longitude`, `status`) VALUES
(24, 'Hyundai Verna.jpeg', 'Hyundai Verna', 750.00, 'Automatic', 'Petrol', 4, '1', 5, 28.6139, 77.209, 'available'),
(25, 'Honda City.jpeg', 'Honda City', 850.00, 'Automatic', 'Petrol', 4, '1', 5, 19.076, 72.8777, 'Unavailable'),
(26, 'Volkswagen.jpeg', 'Volkswagen Virtus', 950.00, 'Automatic', 'Petrol', 4, '1', 5, 13.0827, 80.2707, 'Available'),
(27, 'MG Gloster.jpeg', 'MG Gloster', 2750.00, 'Automatic', 'Diesel', 5, '1', 7, 22.5726, 88.3639, 'Available'),
(28, 'Toyoto Fortuner.jpeg', 'Toyoto Fortuner', 3750.00, 'Automatic', 'Diesel', 5, '1', 7, 17.385, 78.4867, 'Available'),
(29, 'Jeep Cheroke.jpeg', 'Jeep Cherokee', 4750.00, 'Automatic', 'Petrol', 5, '1', 7, 12.9716, 77.5946, 'Available'),
(30, 'Suzuki Jimny.jpg', 'Maruti Suzuki Jimny', 1750.00, 'Manual', 'Petrol', 5, '1', 4, 23.2599, 77.4126, 'Available'),
(31, 'Mahindhra Thar.jpg', 'Mahindra Thar', 2000.00, 'Manual', 'Petrol', 2, '1', 4, 26.8467, 80.9462, 'Available'),
(32, 'Force Gurkha.jpg', 'Force Gurkha', 1750.00, 'Manual', 'Diesel', 5, '1', 4, 15.3173, 75.7139, 'Available'),
(34, 'tata harrier ev.webp', 'Tata Harrier Ev', 2400.00, 'Manual', 'Electric', 5, '1', 5, 0, 0, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `car_locations`
--

CREATE TABLE `car_locations` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'nikhil', 'nikhil@gmail.com', 'this is very super', '2024-11-24 12:40:35'),
(2, 'tharun', 'tharun16c@gmail.com', 'car repaired', '2024-12-24 05:47:22');

-- --------------------------------------------------------

--
-- Table structure for table `employee_bookings`
--

CREATE TABLE `employee_bookings` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `comments` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `sender`, `receiver`, `message`, `timestamp`, `user_id`, `is_read`, `content`) VALUES
(1, 'nikhil', 'admin', 'hi\r\n', '2024-11-27 10:25:24', 1, 0, 'hello'),
(2, 'nikhil', 'admin', 'hello\r\n', '2024-11-27 10:42:32', 1, 0, 'hi'),
(6, 'admin', '1', 'hello', '2024-12-04 10:31:26', 1, 0, ''),
(7, 'admin', '1', 'say your problem', '2024-12-04 10:44:41', 1, 0, ''),
(8, '1', 'admin', 'i want to cancel my booking', '2024-12-04 14:02:51', 1, 0, ''),
(9, 'admin', '1', 'kk done', '2024-12-04 14:03:37', 1, 0, ''),
(10, '1', 'admin', 'thanks a lot', '2024-12-04 14:05:09', 1, 0, ''),
(11, '1', 'admin', 'did i get my refunded money', '2024-12-04 14:05:38', 1, 0, ''),
(12, 'admin', '1', 'hlo', '2024-12-04 14:07:44', 1, 0, ''),
(13, '4', 'admin', 'hi', '2024-12-04 15:19:32', 4, 0, ''),
(14, 'admin', '4', 'hi', '2024-12-06 10:46:04', 4, 0, ''),
(16, '1', 'admin', 'hello', '2024-12-24 05:46:28', 1, 0, ''),
(17, '87', 'admin', 'hi', '2025-01-12 09:01:59', 87, 0, ''),
(18, '4', 'admin', 'hi bsdk', '2025-03-15 02:47:46', 4, 0, ''),
(19, 'admin', '4', 'chutiya', '2025-03-15 02:48:32', 4, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `paid_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `usertype` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address_type` varchar(50) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `license_no` varchar(255) DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp(),
  `aadhaar` varchar(12) NOT NULL,
  `aadhaar_doc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `usertype`, `phone`, `dob`, `gender`, `address_type`, `pincode`, `address`, `license_no`, `license`, `createdon`, `aadhaar`, `aadhaar_doc`) VALUES
(1, 'nikhil', 'nikhil@gmail.com', '123456', '2', '9392510416', NULL, 'male', 'Permanent', '521228', 'chennai', '12354484216585', 'uploads/license/licence.jpg', '2024-11-13 03:42:39', '123456789014', 'uploads/aadhaar/A_sample_of_Aadhaar_card.jpg'),
(2, 'admin', 'admin@gmail.com', '1234', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-13 04:01:17', '', NULL),
(4, 'employee', 'employee@gmail.com', '1234', '3', '6677889900', NULL, 'male', 'Permanent', '521228', 'chennai-tn', '12354484216585', NULL, '2024-12-03 17:04:33', '123456789012', NULL),
(83, 'alam', 'alam@gmal.com', '1234', '2', '1234568722', '2001-05-30', 'male', 'Permanent', '692586', 'Chennai-Tn', '12354484216581', 'uploads/license/licence.jpg', '2025-01-03 07:26:53', '123456789012', 'uploads/aadhaar/A_sample_of_Aadhaar_card.jpg'),
(86, 'Yalaka Nikhil', 'yalakanikhil30@gmail.com', '12347', '2', '8985902404', '2003-09-30', 'male', 'Temporary', '521228', '201-sribhagya residency\\r\\nShanthi Nagar', '5813941658452', 'uploads/license/licence.jpg', '2025-01-08 03:21:56', '123456789215', 'uploads/aadhaar/A_sample_of_Aadhaar_card.jpg'),
(87, 'singh', 'singh@gmail.com', '1234', '2', '8985902404', '2025-09-30', 'male', 'Permanent', '521228', 'Chennai-Tn', '9584632846563', 'uploads/license/licence.jpg', '2025-01-09 09:10:00', '351848383344', 'uploads/aadhaar/A_sample_of_Aadhaar_card.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `booking_cancellations`
--
ALTER TABLE `booking_cancellations`
  ADD PRIMARY KEY (`cancellation_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `car_locations`
--
ALTER TABLE `car_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_bookings`
--
ALTER TABLE `employee_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
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
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `booking_cancellations`
--
ALTER TABLE `booking_cancellations`
  MODIFY `cancellation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `car_locations`
--
ALTER TABLE `car_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee_bookings`
--
ALTER TABLE `employee_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;

--
-- Constraints for table `car_locations`
--
ALTER TABLE `car_locations`
  ADD CONSTRAINT `car_locations_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `employee_bookings`
--
ALTER TABLE `employee_bookings`
  ADD CONSTRAINT `employee_bookings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_bookings_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
