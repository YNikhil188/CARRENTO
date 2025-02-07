-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 09:54 AM
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
-- Database: `carrento`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `car_id`, `model`, `name`, `email`, `phone`, `start_date`, `days`, `total_price`, `booking_date`) VALUES
(1, 28, 'Toyoto Fortuner', 'nikhil', 'nikhil@gmail.com', '8985902404', '2024-11-23', 3, 11250.00, '2024-11-15 05:24:07'),
(2, 31, 'Mahindra Thar', 'dsfgh', 'dszfg@gmail.com', '963', '2024-11-15', 200, 400000.00, '2024-11-15 07:51:03');

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
  `seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `image`, `model`, `price_per_day`, `gearbox`, `fuel`, `doors`, `air_conditioner`, `seats`) VALUES
(24, 'Hyundai Verna.jpeg', 'Hyundai Verna', 750.00, 'Automatic', 'Petrol', 4, '1', 5),
(25, 'Honda City.jpeg', 'Honda City', 850.00, 'Automatic', 'Petrol', 4, '1', 5),
(26, 'Volkswagen.jpeg', 'Volkswagen Virtus', 950.00, 'Automatic', 'Petrol', 4, '1', 5),
(27, 'MG Gloster.jpeg', 'MG Gloster', 2750.00, 'Automatic', 'Diesel', 5, '1', 7),
(28, 'Toyoto Fortuner.jpeg', 'Toyoto Fortuner', 3750.00, 'Automatic', 'Diesel', 5, '1', 7),
(29, 'Jeep Cheroke.jpeg', 'Jeep Cherokee', 4750.00, 'Automatic', 'Petrol', 5, '1', 7),
(30, 'Suzuki Jimny.jpg', 'Maruti Suzuki Jimny', 1750.00, 'Manual', 'Petrol', 5, '1', 4),
(31, 'Mahindhra Thar.jpg', 'Mahindra Thar', 2000.00, 'Manual', 'Petrol', 2, '1', 4),
(32, 'Force Gurkha.jpg', 'Force Gurkha', 1750.00, 'Manual', 'Diesel', 5, '1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL,
  `comments` text DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `experience`, `rating`, `comments`, `createdon`) VALUES
(1, 'nikhil', 'nikhil@gmail.com', 'Excellent', 5, 'super', '2024-11-12 07:47:44');

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
  `license` varchar(255) DEFAULT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `usertype`, `phone`, `dob`, `gender`, `address_type`, `pincode`, `address`, `license`, `createdon`) VALUES
(1, 'nikhil', 'nikhil@gmail.com', '1234', '2', '9392510416', '2024-11-13', 'male', 'permanent', '521228', 'chennai', 'uploads/license/Screenshot 2024-11-11 204602.png', '2024-11-13 03:42:39'),
(2, 'admin', 'admin@gmail.com', '1234', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-13 04:01:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
