-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 03:56 PM
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
-- Database: `exam_managment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_ID` varchar(255) NOT NULL,
  `course_code` int(255) NOT NULL,
  `course_name` varchar(70) NOT NULL,
  `devision_name` varchar(30) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `semester` varchar(3) NOT NULL,
  `total_credits` int(8) NOT NULL,
  `deparment` varchar(20) NOT NULL,
  `included_subjects` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `Director_ID` varchar(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `hire_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_ID` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `start_time` varchar(10) NOT NULL,
  `duration` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `Registration_number` varchar(255) NOT NULL,
  `title` varchar(4) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `name_with_initials` varchar(70) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `deparment` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirm_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`Registration_number`, `title`, `Full_Name`, `name_with_initials`, `gender`, `email`, `contact_number`, `address`, `deparment`, `password`, `confirm_password`) VALUES
('001', 'Mr', 'sasia', 'sasika', 'male', 'sasiikka@gmail.com', '3456', 'homagama', 'computing', '200SAsa#', '200SAsa#'),
('09', 'Mr', 'sasika', 'sasika', 'male', 'sasiikka@gmail.com', '3456', 'godagama', 'computing', '200SAsa#', '200SAsa#'),
('9421', 'Mr', 'Charuka', 'Kushan', 'male', 'lessonsmyse@gmail.com', '0776790011', 'D15/6, Bilingahahena', 'It', '123', '123');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer2`
--

CREATE TABLE `lecturer2` (
  `Reg_number` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `name_with_initials` varchar(70) NOT NULL,
  `address` varchar(50) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `T.P.1` varchar(15) NOT NULL,
  `T.P.2` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('user', 'pass');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_ID` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `issued_Date` varchar(20) NOT NULL,
  `issued_time` varchar(20) NOT NULL,
  `result_status` varchar(10) NOT NULL,
  `marks` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Registration_number` varchar(255) NOT NULL,
  `title` varchar(4) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `name_with_initials` varchar(70) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `deparment` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirm_password` varchar(50) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Registration_number`, `title`, `Full_Name`, `name_with_initials`, `gender`, `email`, `contact_number`, `address`, `deparment`, `password`, `confirm_password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
('0000', 'Mr', 'Charuka', 'Kushan', 'male', 'charubim0530@gmail.com', '0776790011', 'D15/6, Bilingahahena', 'Management', 'Ab123456@', 'Ab123456@', '4eada0ab5058344ba0311d733709ed6bc474ccb668c6bcdd296897b28b4fe7ac', '2025-01-19 17:12:08'),
('08', 'Mr', 'nimal', 'nimal', 'male', 'saman@gmail.com', '123456', 'homagama', 'computing', '200SAsa#', '200SAsa#', NULL, NULL),
('09', 'Mr', 'sasika', 'sasika', 'male', 'saman@gmail.com', '123456', 'godagama', 'xcfgh', '200SAsa#', '200SASa#', NULL, NULL),
('1', 'Mr', 'sasia', 'sasika', 'male', 'saman@gmail.com', '123456', 'godagama', 'computing', '200SAsa#', '200SAsa#', NULL, NULL),
('123', 'Mr', 'saman', 'saman', 'male', 'saman@gmail.com', '12345678', 'homagama', 'computing', '200SAsa#', '200SAsa#', NULL, NULL),
('1234', 'Mr', 'lal', 'lal', 'male', 'lal@gmail.com', '9876543', 'homagama', 'computing', '200SAsa#', '200SAsa#', NULL, NULL),
('2', 'Mr', 'sasia', 'sasika', 'male', 'sasiikka@gmail.com', '123456', 'godagama', 'bnhjhgfd', '200SAsa#', '200SAsa#', NULL, NULL),
('2528', 'Mr', 'kasun chandima', 'K.chandima', 'male', 'adamulurataekamitakata@rataanurata.lk', '0776790011', 'D15/6, Bilingahahena', 'Management', 'Ab123456@', 'Ab123456@', NULL, NULL),
('3', 'Mr', 'sasia', 'sasika', 'male', 'sasiikka@gmail.com', '123456', 'fdhfj', 'dfdgh', '200SAsa#', '200SAsa#', NULL, NULL),
('456', 'Mr', 'Charuka', 'Kushan', 'male', 'h26000043@gmail.com', '0776790011', 'D15/6, Bilingahahena', 'Agri', '123456@Ab', '123456@Ab', '343197dcab0f6dea7ae70d4174905a96b446a2da978f03cb242dd5b61b3950b6', '2025-01-19 12:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `studentapply`
--

CREATE TABLE `studentapply` (
  `Registration_number` varchar(255) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `semester` varchar(3) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `index_number` varchar(255) NOT NULL,
  `devision_name` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentapply`
--

INSERT INTO `studentapply` (`Registration_number`, `course_name`, `semester`, `academic_year`, `index_number`, `devision_name`, `subject`) VALUES
('sa', 'sa', 'I', '1', 'sa', 'Agri', 'AG1209'),
('sdzs', 'ccc', 'I', '1', 'vvvv', 'Management', 'MG2101');

-- --------------------------------------------------------

--
-- Table structure for table `student_enroll`
--

CREATE TABLE `student_enroll` (
  `Registration_number` varchar(255) NOT NULL,
  `exam_ID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `date` varchar(20) NOT NULL,
  `devision` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `start_time` varchar(6) NOT NULL,
  `end_time` varchar(10) NOT NULL,
  `TableID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`date`, `devision`, `subject`, `start_time`, `end_time`, `TableID`) VALUES
('2025-01-01', 'Division 1', 'Math', '11:00', '13:59', 13),
('', 'Division 1', 'Science', '11:11', '17:55', 14),
('', '', '', '', '', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`Director_ID`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_ID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`Registration_number`);

--
-- Indexes for table `lecturer2`
--
ALTER TABLE `lecturer2`
  ADD PRIMARY KEY (`Reg_number`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Registration_number`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `studentapply`
--
ALTER TABLE `studentapply`
  ADD PRIMARY KEY (`Registration_number`);

--
-- Indexes for table `student_enroll`
--
ALTER TABLE `student_enroll`
  ADD PRIMARY KEY (`Registration_number`,`exam_ID`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`TableID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_code` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `TableID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
