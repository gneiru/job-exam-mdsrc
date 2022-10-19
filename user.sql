-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2022 at 02:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exam`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `emailaddress` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `company` varchar(30) NOT NULL,
  `contactnumber` varchar(15) NOT NULL,
  `position` varchar(20) NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'active',
  `added` timestamp NOT NULL DEFAULT current_timestamp(),
  `super_user` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `emailaddress`, `password`, `firstname`, `middlename`, `lastname`, `address`, `company`, `contactnumber`, `position`, `active`, `added`, `super_user`) VALUES
(1, 'rohi', 'rohi@gmail.com', '8fb137ab86c7697d02042cf664bb382522613ec2', 'rohi', 'cagunot', 'garcia', 'rohi', 'rohi', '123123', 'rohi', 'active', '2022-10-17 07:19:41', 1),
(2, 'popoy', 'popoy@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Popoy', 'C', 'Garcia', '#271 popoy st', 'popoy', '09107120840', 'Aso', 'active', '2022-10-17 08:59:29', 0),
(3, 'aw', 'aw@gmail.com', 'a7ce5b0c7e956b8e3c1a5c254c910d57c56e1b57', 'aw', 'aw', 'aw', 'aw', 'aw', '123', 'aw', 'active', '2022-10-17 10:27:59', 0),
(4, 'eli', 'eli@gmail.com', '3ca62a2ad87376be2697209a1770e1afdbbba220', 'Eli', 'Ly', 'Man', '1237812783jsadkjm #,.', 'IDK', '0921372121', 'Guild Lead', 'active', '2022-10-17 12:39:39', 0),
(5, 'sata', 'satanael@gmail.com', 'defc3a4fb5b3a420e0b910424f057ac10f6fd523', 'Sxtaa', 'A', 'Nael', 'Idk st. ye23', 'HAHA', '012381233', 'Former Officer', 'active', '2022-10-17 12:40:25', 0),
(6, 'Eri', 'eri@gmail.com', '22be77c0cadb4da6085e45c68e23e88f7a6f8ea3', 'erik', 'sor', 'gom', '#2813 Pad . Barangay, province 2381', 'idk', '1230393', 'anyth', 'active', '2022-10-18 10:04:35', 0),
(7, 'eri1', 'eri1@gmail.com', '7c6290325da36b8830e43805d1051e070173dd86', 'erika', 'no', 'yes', 'okay', 'but', '123123123', 'heyey', 'active', '2022-10-18 10:07:12', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `emailaddress` (`emailaddress`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
