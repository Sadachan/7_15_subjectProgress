-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2020 at 06:24 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subjectprogress`
--

-- --------------------------------------------------------

--
-- Table structure for table `progress_table`
--

CREATE TABLE `progress_table` (
  `id` int(11) NOT NULL,
  `taskname` varchar(128) NOT NULL,
  `startdate` date NOT NULL,
  `deadline` date NOT NULL,
  `manhour` int(11) NOT NULL,
  `charge` varchar(128) NOT NULL,
  `nowstatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `progress_table`
--

INSERT INTO `progress_table` (`id`, `taskname`, `startdate`, `deadline`, `manhour`, `charge`, `nowstatus`) VALUES
(1, '案件A', '2020-07-05', '2020-07-11', 5, 'Aさん', 1),
(2, '案件A', '2020-07-07', '2020-07-11', 5, '貞野', 4),
(4, '案件B', '2020-07-05', '2020-07-10', 5, '貞野', 4),
(5, '案件Z', '2020-07-04', '2020-07-09', 6, 'Aさん', 0),
(6, '案件C', '2020-07-11', '2020-07-16', 5, 'Bさん', 0),
(7, '案件D', '2020-07-11', '2020-07-15', 5, 'Aさん', 0),
(8, '案件E', '2020-07-11', '2020-07-15', 5, 'Aさん', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`) VALUES
(1, 'Aさん'),
(2, 'Bさん'),
(3, 'Cさん'),
(4, 'Dさん'),
(5, 'Eさん'),
(6, 'Fさん'),
(7, 'Gさん');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `progress_table`
--
ALTER TABLE `progress_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `progress_table`
--
ALTER TABLE `progress_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
