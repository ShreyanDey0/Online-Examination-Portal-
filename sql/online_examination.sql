-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2021 at 12:58 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc1`
--

CREATE TABLE `acc1` (
  `Id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_examid` varchar(255) NOT NULL,
  `student_collegeid` varchar(255) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `rollnumber` varchar(255) NOT NULL,
  `question_1` varchar(2000) NOT NULL,
  `question_2` varchar(2000) NOT NULL,
  `question_3` varchar(2000) NOT NULL,
  `question_4` varchar(2000) NOT NULL,
  `question_5` varchar(2000) NOT NULL,
  `question_6` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `acc1`
--

INSERT INTO `acc1` (`Id`, `student_name`, `student_examid`, `student_collegeid`, `stream`, `rollnumber`, `question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`) VALUES
(1, 'Shreyan Dey', 'EXM/STU/111', 'NIT/2018/0296', 'abc', 'BCA3A595', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `query`
--

CREATE TABLE `query` (
  `query_id` int(255) NOT NULL,
  `query-email` varchar(255) NOT NULL,
  `query` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `stream` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `teacher_id` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `fullmarks` varchar(255) NOT NULL,
  `question_1` varchar(255) NOT NULL,
  `question_2` varchar(255) NOT NULL,
  `question_3` varchar(255) NOT NULL,
  `question_4` varchar(255) NOT NULL,
  `question_5` varchar(255) NOT NULL,
  `question_6` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `stream`, `subject_code`, `semester`, `subject_name`, `teacher_id`, `time`, `fullmarks`, `question_1`, `question_2`, `question_3`, `question_4`, `question_5`, `question_6`) VALUES
(21, 'abc', 'acc1', '3', 'acc', 'NIT/TEC/2018/0295', '1', '10', 'asd', 'fgh', 'sfg', 'ddg', 'ffh', 'sfg');

-- --------------------------------------------------------

--
-- Table structure for table `student_detail`
--

CREATE TABLE `student_detail` (
  `fname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rollnumber` varchar(255) NOT NULL,
  `collegeid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `examid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_detail`
--

INSERT INTO `student_detail` (`fname`, `email`, `rollnumber`, `collegeid`, `password`, `examid`) VALUES
('Shreyan Dey', 'shreyandey6@gmail.com', 'BCA3A595', 'NIT/2018/0296', '$2y$10$4smqYlKA8SyAXGGpA1Ovle1Eg.8R0Jyg06UllefFniBQBx1FeMmQm', 'EXM/STU/111');

-- --------------------------------------------------------

--
-- Table structure for table `super_user`
--

CREATE TABLE `super_user` (
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `super_user`
--

INSERT INTO `super_user` (`name`, `username`, `password`) VALUES
('Manish', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_detail`
--

CREATE TABLE `teacher_detail` (
  `fname` varchar(255) NOT NULL,
  `examid` varchar(255) NOT NULL,
  `collegeid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_detail`
--

INSERT INTO `teacher_detail` (`fname`, `examid`, `collegeid`, `password`) VALUES
('Test User', 'EXM/TEC/1', 'NIT/TEC/2018/0295', 'NIT/TEC/2018/0295');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc1`
--
ALTER TABLE `acc1`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `query`
--
ALTER TABLE `query`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `student_detail`
--
ALTER TABLE `student_detail`
  ADD PRIMARY KEY (`examid`);

--
-- Indexes for table `teacher_detail`
--
ALTER TABLE `teacher_detail`
  ADD PRIMARY KEY (`examid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc1`
--
ALTER TABLE `acc1`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `query`
--
ALTER TABLE `query`
  MODIFY `query_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
