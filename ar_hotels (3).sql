-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 03:03 PM
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
-- Database: `ar_hotels`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `room_id`, `room_type`, `name`, `email`, `phone`, `check_in`, `check_out`, `price`, `created_at`, `payment_status`) VALUES
(1, 10, 'Standard Room', 'krishhh', 'kpansara790@rku.ac.in', '1234567890', '2025-04-12', '2025-04-13', 80.00, '2025-04-11 15:38:24', 'PENDING'),
(13, 1, 'Deluxe Room', 'krish pansara', 'kpansara790@rku.ac.in', '9876543210', '2025-04-18', '2025-04-19', 120.00, '2025-04-13 14:07:51', 'PAID'),
(14, 11, 'Suite', 'krishhh', 'kpansara790@rku.ac.in', '1234567890', '2025-04-15', '2025-04-17', 200.00, '2025-04-13 14:09:02', 'PAID'),
(20, 2, 'Economy Room', 'aditya', 'aadityadodiya01@gmail.com', '6356503668', '2025-09-10', '2025-09-11', 45.00, '2025-04-16 02:52:07', 'PAID'),
(22, 12, 'Family Room', 'krish pansara', 'kpansara790@rku.ac.in', '9876543210', '2025-04-26', '2025-04-27', 150.00, '2025-04-19 12:02:01', 'PAID'),
(23, 14, 'Couple Room', 'rushi', 'kpansara790@rku.ac.in', '1234567890', '2025-04-21', '2025-04-22', 500.00, '2025-04-19 12:07:21', 'PAY_ON_ARRIVAL'),
(24, 10, 'Standard Room', 'rushivxv', 'abc@gmai.com', '1234567890', '2025-04-26', '2025-04-27', 80.00, '2025-04-19 12:17:46', 'PENDING'),
(25, 1, 'Deluxe Room', 'rushivxv', 'rsorathiya880@rku.ac.in', '1234567890', '2025-04-29', '2025-04-30', 120.00, '2025-04-19 12:19:03', 'PENDING'),
(26, 1, 'Deluxe Room', 'rushi', 'kpansara790@rku.ac.in', '1234567890', '2025-04-20', '2025-04-21', 120.00, '2025-04-19 12:32:41', 'PAID'),
(27, 12, 'Family Room', 'krishhh', 'kpansara790@rku.ac.in', '1234567890', '2025-05-02', '2025-05-03', 150.00, '2025-04-26 16:17:37', 'PAID'),
(29, 1, 'Deluxe Room', 'krishhh', 'kpansara790@rku.ac.in', '1234567890', '2025-05-17', '2025-05-18', 120.00, '2025-05-01 15:03:18', 'PENDING'),
(32, 13, 'Single Room', 'krish pansara', 'kpansara790@rku.ac.in', '9876543210', '2025-05-10', '2025-05-11', 60.00, '2025-05-01 15:36:04', 'PENDING'),
(33, 1, 'Deluxe Room', 'krishhh', 'abc@gmai.com', '1234567890', '2025-05-29', '2025-05-30', 120.00, '2025-05-02 05:29:34', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `user_id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 21, 'krishhh', 'kpansara790@rku.ac.in', 'hey', 'i wan to go o  a trip', '2025-04-08 10:08:01'),
(2, 21, 'krishhh', 'kpansara790@rku.ac.in', 'Booking Website', 'hlwww', '2025-04-08 17:50:46'),
(3, 21, 'krishhh', 'kpansara790@rku.ac.in', 'Booking Website', 'hlwww', '2025-04-08 18:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `otp_attempts` int(11) NOT NULL,
  `last_resend` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_token`
--

INSERT INTO `password_token` (`id`, `email`, `otp`, `created_at`, `expires_at`, `otp_attempts`, `last_resend`) VALUES
(0, 'rsorathiya880@rku.ac.in', 995652, '2025-05-01 17:50:28', '2025-05-01 17:52:28', 1, '2025-05-01 15:50:32');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `rating`, `review`, `created_at`) VALUES
(1, 'jhon deo', 'jhondeo@123gmail.com', 5, 'good', '2025-04-06 12:30:23'),
(2, 'krish pansara', 'kpansara790@rku.ac.in', 4, 'very nice', '2025-04-06 12:30:49'),
(3, 'Aaditya', 'adodiya337@rku.ac.in', 5, 'nice', '2025-04-06 12:49:39'),
(4, 'rushi', 'rsorathiya880@rku.ac.in', 5, 'very good', '2025-04-16 03:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `view` varchar(100) DEFAULT NULL,
  `is_discounted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `type`, `price`, `discount_price`, `image`, `description`, `size`, `capacity`, `amenities`, `view`, `is_discounted`) VALUES
(1, 'Deluxe Room', 120.00, NULL, 'diluxroom.jpg', 'Spacious deluxe room with modern amenities', '400 sq ft', '2 Adults + 1 Child', 'King-size bed,Mini bar,Smart TV,Work desk,Free Wi-Fi,Air conditioning', 'City view', 0),
(2, 'Economy Room', 60.00, 45.00, 'economy.jpg', 'Budget-friendly room with essential amenities', '250 sq ft', '2 Adults', 'Double bed,TV,Basic Wi-Fi,Air conditioning', 'City view', 1),
(3, 'Compact Room', 80.00, 60.00, 'compact.jpg', 'Efficiently designed compact room for short stays', '200 sq ft', '2 Adults', 'Queen-size bed,TV,Wi-Fi,Work corner', 'Garden view', 1),
(9, 'Small Suite', 100.00, 75.00, 'small.jpg', 'Cozy suite with modern amenities', '300 sq ft', '2 Adults + 1 Child', 'Queen-size bed,TV,Mini fridge,Wi-Fi,Seating area', 'Pool view', 1),
(10, 'Standard Room', 80.00, NULL, 'standared.jpg', 'Comfortable standard room with essential amenities', '300 sq ft', '2 Adults', 'Queen-size bed,TV,Work desk,Free Wi-Fi,Air conditioning', 'Garden view', 0),
(11, 'Suite', 200.00, NULL, 'suit.jpg', 'Luxurious suite with separate living area and premium amenities', '600 sq ft', '2 Adults + 2 Children', 'King-size bed,Mini bar,Smart TV,Living room,Kitchenette,Premium Wi-Fi', 'Ocean view', 0),
(12, 'Family Room', 150.00, NULL, 'family.jpg', 'Spacious family room perfect for larger groups', '500 sq ft', '4 Adults', '2 Queen-size beds,TV,Mini fridge,Free Wi-Fi,Family seating area', 'Pool view', 0),
(13, 'Single Room', 60.00, NULL, 'single.jpg', 'Cozy single room ideal for solo travelers', '200 sq ft', '1 Adult', 'Single bed,TV,Desk,Wi-Fi,Air conditioning', 'City view', 0),
(14, 'Couple Room', 500.00, NULL, 'couple.jpg', 'Romantic room designed for couples with luxury amenities', '450 sq ft', '2 Adults', 'King-size bed,Jacuzzi,Smart TV,Mini bar,Premium Wi-Fi,Balcony', 'Ocean view', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `email_verified` tinyint(4) NOT NULL DEFAULT 0,
  `verification_token` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile_no` varchar(15) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `email_verified`, `verification_token`, `created_at`, `mobile_no`, `profile_picture`) VALUES
(1, 'Rushi', 'rsorathiya880@rku.ac.in', '12421242', 'admin', 0, 0, '2025-04-01 06:26:04', '', NULL),
(12, 'Deep kacha', 'dkacha329@rku.ac.in', 'Deep@123', 'user', 0, 2147483647, '2025-04-03 06:51:31', '', NULL),
(21, 'krish pansara', 'kpansara790@rku.ac.in', 'PKrish14', 'user', 0, 0, '2025-04-05 05:09:41', '7984358848', '67f0d23967f5f_4.jpg'),
(22, 'Aditya Dodiya', 'adodiya337@rku.ac.in', 'Adi123456', 'user', 0, 3, '2025-04-07 04:20:27', '6356503668', '67f3532061ce7_2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
