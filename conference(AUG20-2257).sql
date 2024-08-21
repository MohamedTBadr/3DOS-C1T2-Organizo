-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2024 at 10:57 PM
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
-- Database: `conference`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'New'),
(2, 'Improve'),
(3, 'Bug');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `image` longtext DEFAULT NULL,
  `comment` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `image`, `comment`, `user_id`, `task_id`) VALUES
(45, NULL, 'please consider all the users', 21, 12),
(46, 'hubstaff mar.PNG', 'ther is bug in this dashboard ', 21, 13),
(47, NULL, 'insights is not correct', 21, 11),
(48, NULL, 'consider the targeted audience ', 33, 15);

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL,
  `plan_type` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`plan_id`, `plan_type`, `price`, `limit`) VALUES
(1, 'Free', 0, 1),
(2, 'Professional', 50, 5),
(3, 'Business', 150, 15);

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE `priority` (
  `priority_id` int(11) NOT NULL,
  `priority_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`priority_id`, `priority_name`) VALUES
(1, 'high'),
(2, 'medium'),
(3, 'low');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `team_members` int(11) NOT NULL,
  `project_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `team_members`, `project_type_id`, `user_id`) VALUES
(21, 'Sales', 1, 1, 21),
(22, 'Voice over', 1, 1, 33),
(23, 'Planning App', 1, 1, 33);

-- --------------------------------------------------------

--
-- Table structure for table `project_member`
--

CREATE TABLE `project_member` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_member`
--

INSERT INTO `project_member` (`user_id`, `project_id`) VALUES
(21, 21),
(21, 23),
(32, 21),
(32, 23),
(33, 22),
(33, 23),
(36, 21),
(37, 21),
(37, 22),
(38, 21),
(39, 22);

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE `project_type` (
  `project_type_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_type`
--

INSERT INTO `project_type` (`project_type_id`, `name`, `description`) VALUES
(1, 'it project', 'it'),
(2, 'design project', 'design');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'leader'),
(2, 'member');

-- --------------------------------------------------------

--
-- Table structure for table `sprint`
--

CREATE TABLE `sprint` (
  `sprint_id` int(11) NOT NULL,
  `sprint_name` varchar(250) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sprint`
--

INSERT INTO `sprint` (`sprint_id`, `sprint_name`, `start_date`, `end_date`, `project_id`) VALUES
(22, 'Data Visualization', '2024-08-21', '2024-09-10', 21),
(23, 'Reports', '2024-08-27', '2024-09-16', 21),
(24, 'KPIs', '2024-09-01', '2024-09-29', 21),
(25, 'Optimization', '2024-08-21', '2024-09-19', 21),
(26, 'sprint 1', '2024-08-21', '2024-09-19', 22),
(27, 'sprint 2', '2024-08-23', '2024-09-20', 22),
(29, 'sprint 3', '2024-08-28', '2024-09-24', 22),
(30, 'dveloping', '2024-08-21', '2024-09-19', 23),
(31, 'testing', '2024-09-20', '2024-09-30', 23);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'not active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`plan_id`, `user_id`, `status`, `start_date`, `end_date`) VALUES
(2, 21, 'active', '2024-08-20', '2024-09-20'),
(2, 24, 'not active', '2024-08-22', '2024-09-22'),
(2, 33, 'active', '2024-09-24', '2024-09-24');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(250) NOT NULL,
  `task_status` varchar(255) NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` longtext NOT NULL,
  `hidden` varchar(250) NOT NULL,
  `view` varchar(255) NOT NULL DEFAULT 'assigned',
  `sprint_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `assignie` int(11) NOT NULL,
  `assign_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_status`, `start_date`, `end_date`, `description`, `hidden`, `view`, `sprint_id`, `priority_id`, `category_id`, `assignie`, `assign_by`) VALUES
(11, 'Marketing Insights', '1', '2024-08-21', '2024-08-30', 'Sales Data Analysis for Marketing Insights', 'unarchive', 'default', 22, 2, 3, 32, 21),
(12, 'Segmentation', '2', '2024-08-21', '2024-08-31', 'Customer Segmentation & Clustering', 'unarchive', 'seen', 22, 3, 1, 36, 21),
(13, 'Dashboard', '3', '2024-08-21', '2024-08-29', 'Dashboard', 'unarchive', 'default', 22, 1, 3, 37, 21),
(14, 'TV Advertisement', '1', '2024-08-21', '2024-08-30', 'Commercial Voice Over for TV Advertisement', 'unarchive', 'default', 26, 1, 1, 37, 33),
(15, 'Podcast ', '2', '2024-08-24', '2024-09-06', 'Podcast Intro and Outro Voice Over', 'unarchive', 'default', 26, 2, 2, 39, 33),
(16, 'Arabic Voice Over', '3', '2024-08-20', '2024-08-28', 'Arabic Voice Over for Educational Videos', 'unarchive', 'default', 26, 1, 1, 37, 33),
(17, 'coding', '1', '2024-08-21', '2024-08-31', 'coding the backend', 'unarchive', 'default', 30, 2, 3, 32, 33),
(18, 'frontend', '1', '2024-08-21', '2024-08-29', 'improving the user interface', 'unarchive', 'default', 30, 2, 2, 21, 33);

-- --------------------------------------------------------

--
-- Table structure for table `task_notes`
--

CREATE TABLE `task_notes` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `note` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_notes`
--

INSERT INTO `task_notes` (`note_id`, `user_id`, `task_id`, `note`) VALUES
(70, 32, 11, 'consider it again'),
(71, 36, 12, 'include the new users');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `image` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `password`, `email`, `phone_number`, `plan_id`, `role_id`, `image`) VALUES
(21, 'Alaa', 'Mostafa', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'alaanaguib96@gmail.com', '01000966903', 2, 1, '37c5d1b8-0c3a-4b85-b80e-ae5a28e1f4b9.jpg'),
(22, 'Salma', 'Mohammed', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'salmaa.mohamedd56@gmail.com', '01028970103', 1, 2, 'defaultprofile.png'),
(23, 'Sarah', 'Shendy', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'sarahshendy23@gmail.com', '01096774388', 1, 2, 'defaultprofile.png'),
(24, 'Farah', 'Yasser', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'farah.yasser@gmail.com', '01128101015', 2, 1, 'defaultprofile.png'),
(25, 'Shehab', 'Serry', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'shehabmohamed7907@gmail.com', '01005109123', 1, 2, 'defaultprofile.png'),
(26, 'Rawan', 'Ezzat', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'rawan.ezzat@gmail.com', '01025174479', 1, 2, 'defaultprofile.png'),
(27, 'Boshra', 'Hazem', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'boshra.hazem@gmail.com', '01157710818', 1, 2, 'defaultprofile.png'),
(28, 'Magda', 'Shreif', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'magda.shreif@gmail.com', '01094488974', 1, 2, 'defaultprofile.png'),
(29, 'Mohamed', 'Tarek', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'mohamed.tarek@gmail.com', '01122968127', 1, 2, 'defaultprofile.png'),
(30, 'Salma', 'Adel', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'salma.adel@gmail.com', '01051844299', 1, 2, 'defaultprofile.png'),
(31, 'Jana', 'Hossam', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'jana.hossam@gmail.com', '01051844288', 1, 2, 'defaultprofile.png'),
(32, 'Elham', 'Hesham', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'elham.hisham@gmail.com', '01000956584', 1, 2, 'defaultprofile.png'),
(33, 'Sara', 'Ali', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'sara.ali@gmail.com', '01024162764', 2, 1, 'defaultprofile.png'),
(34, 'Laila', 'Gabr', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'lailagabrr@gmail.com', '01010359871', 1, 2, 'defaultprofile.png'),
(35, 'Malak', 'Islam', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'malak.islam@gmail.com', '01110359871', 1, 2, 'defaultprofile.png'),
(36, 'Habiba', 'Mostafa', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'habiba.mostafa02@gmail.com', '01061910997', 1, 2, 'defaultprofile.png'),
(37, 'Rana', 'mohsen', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'rana.mohsen@gmail.com', '01061910843', 1, 2, 'defaultprofile.png'),
(38, 'Amira', 'Hashim', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'amira.hashim@gmail.com', '01102527489', 1, 2, 'defaultprofile.png'),
(39, 'Yasmin', 'Mohamed', '$2y$10$wvAoggnPjFHdMhHnC4yui.uw8akPtTmIzr8ipcbQMOv5tI7jGyNUu', 'yasmin.mohamed@gmail.com', '01102527748', 1, 2, 'defaultprofile.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `project_type_id` (`project_type_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_member`
--
ALTER TABLE `project_member`
  ADD PRIMARY KEY (`user_id`,`project_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_type`
--
ALTER TABLE `project_type`
  ADD PRIMARY KEY (`project_type_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `sprint`
--
ALTER TABLE `sprint`
  ADD PRIMARY KEY (`sprint_id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `plan_id` (`plan_id`,`user_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `sprint_id` (`sprint_id`,`priority_id`,`category_id`,`assignie`,`assign_by`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `assignie` (`assignie`),
  ADD KEY `assign_by` (`assign_by`);

--
-- Indexes for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `plan_id` (`plan_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `priority`
--
ALTER TABLE `priority`
  MODIFY `priority_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `project_type`
--
ALTER TABLE `project_type`
  MODIFY `project_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `sprint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `task_notes`
--
ALTER TABLE `task_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_type_id`) REFERENCES `project_type` (`project_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_member`
--
ALTER TABLE `project_member`
  ADD CONSTRAINT `project_member_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_member_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sprint`
--
ALTER TABLE `sprint`
  ADD CONSTRAINT `sprint_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscription_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`sprint_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`priority_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`assign_by`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_6` FOREIGN KEY (`assignie`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD CONSTRAINT `task_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_notes_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
