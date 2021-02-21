-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2021 at 12:47 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaztech`
--
CREATE DATABASE IF NOT EXISTS `zaztech` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `zaztech`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `priority` enum('Low','Medium','High') NOT NULL DEFAULT 'Low',
  `description` varchar(255) DEFAULT NULL,
  `status` enum('Pending','In Progress','Finished') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `priority`, `description`, `status`) VALUES
(4, 'Tarefa 4', 'Low', 'Descrição Tarefa 4', 'Finished'),
(2, 'Tarefa 2', 'Medium', 'Descrição tarefa 3', 'Pending'),
(3, 'Tarefa 3', 'High', 'Descrição tarefa 3', 'In Progress'),
(5, 'Tarefa 5', 'Medium', 'Descrição Tarefa 5', 'Pending'),
(6, 'Tarefa 1', 'High', 'Descrição Tarefa 1', 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `tasks_users`
--

DROP TABLE IF EXISTS `tasks_users`;
CREATE TABLE IF NOT EXISTS `tasks_users` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks_users`
--

INSERT INTO `tasks_users` (`task_id`, `user_id`) VALUES
(6, 4),
(3, 3),
(2, 4),
(2, 2),
(4, 4),
(4, 3),
(4, 2),
(4, 1),
(3, 1),
(6, 3),
(6, 2),
(6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`) VALUES
(1, 'User 1'),
(2, 'User 2'),
(3, 'User 3'),
(4, 'User 4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
