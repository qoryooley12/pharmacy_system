-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 06:59 PM
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
-- Database: `pharmacy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `lab_requests`
--

CREATE TABLE `lab_requests` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `requested_tests` text NOT NULL,
  `request_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_requests`
--

INSERT INTO `lab_requests` (`id`, `patient_id`, `doctor_name`, `requested_tests`, `request_date`, `created_at`) VALUES
(1, 17, 'nuur', 'Complete Blood Count, Glucose, Cholesterol, Liver Function Test, Kidney Function Test, Malaria Smear, Typhoid Test, Urinalysis', '2025-07-09', '2025-07-09 13:20:39'),
(2, 14, 'Abdinaasir', 'Complete Blood Count, Glucose, Cholesterol, Liver Function Test, Kidney Function Test, Malaria Smear, Typhoid Test, Urinalysis', '2025-07-09', '2025-07-09 13:25:39'),
(3, 15, '', 'Complete Blood Count, Liver Function Test', '2025-07-09', '2025-07-09 13:30:27'),
(4, 13, '', 'Complete Blood Count, Glucose, Cholesterol, Liver Function Test, Kidney Function Test, Malaria Smear, Typhoid Test, Urinalysis', '2025-07-09', '2025-07-09 13:37:23'),
(5, 16, 'Abdalla ,mohamed', 'Complete Blood Count, Glucose, Cholesterol, Liver Function Test', '2025-07-09', '2025-07-09 14:03:32'),
(6, 16, '', 'Complete Blood Count, Glucose, Cholesterol, Liver Function Test, Kidney Function Test, Malaria Smear, Typhoid Test, Urinalysis', '2025-07-09', '2025-07-09 14:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `lab_results`
--

CREATE TABLE `lab_results` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `test_name` varchar(255) DEFAULT NULL,
  `result` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `patient_no` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `patient_no`, `name`, `phone`, `gender`, `age`, `address`, `medical_conditions`, `created_at`, `updated_at`) VALUES
(12, 'PAT-0001', 'mohamed ali  nuur', '617618145', 'Male', 30, 'hodon', 'xanuun lafaha', '2025-07-08 02:01:41', '2025-07-08 02:01:41'),
(13, 'PAT-0002', 'bilan mohamed yuusuf', '619599345', 'Female', 20, 'xalane', 'typhoid', '2025-07-08 03:50:23', '2025-07-08 03:50:23'),
(14, 'PAT-0003', 'xudayfi ibraahim', '617618145', 'Male', 30, 'hodon', 'fever', '2025-07-08 03:58:29', '2025-07-08 03:58:29'),
(15, 'PAT-0004', 'nuur macalin', '17932', 'Male', 50, 'vfemvmf', 'wmmw', '2025-07-08 04:07:58', '2025-07-08 04:07:58'),
(16, 'PAT-0005', 'maryan cabdiraxmaan', '618545745', 'Female', 20, 'hodon', 'allergies', '2025-07-08 08:54:08', '2025-07-08 08:54:08'),
(17, 'PAT-0006', 'timiro Aadan isaaq', '618787371', 'Female', 53, 'degaaybeere', 'fever/head ache/ gonohrea', '2025-07-08 09:54:31', '2025-07-08 09:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(50) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `status`, `created_data`) VALUES
(1, 'naasir', '123', 'active', '2025-07-06 08:49:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab_requests`
--
ALTER TABLE `lab_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lab_requests`
--
ALTER TABLE `lab_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lab_results`
--
ALTER TABLE `lab_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_results`
--
ALTER TABLE `lab_results`
  ADD CONSTRAINT `lab_results_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `lab_requests` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
