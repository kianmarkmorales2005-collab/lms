-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 03:54 AM
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
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `year_level` varchar(20) DEFAULT '1st Year'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `year_level`) VALUES
(289, 'Understanding the Self', 'GE 101', '1st Year First Sem'),
(290, 'Mathematics in Modern World', 'GE 102', '1st Year First Sem'),
(291, 'Introduction to Computing', 'CC 101', '1st Year First Sem'),
(292, 'Fundamentals in Programming', 'CC 102', '1st Year First Sem'),
(293, 'Living in the IT Era', 'GEE 101', '1st Year First Sem'),
(294, 'Physical Activities Towards Health', 'PATHFIT 1', '1st Year First Sem'),
(295, 'National Service Training Program 1', 'NSTP 1', '1st Year First Sem'),
(296, 'Lipa History', 'KLL 1', '1st Year First Sem'),
(297, 'Readings in Philippine History', 'GE 103', '1st Year Second Sem'),
(298, 'Purposive Communication', 'GE 104', '1st Year Second Sem'),
(299, 'Intermediate Programming', 'CC 103', '1st Year Second Sem'),
(300, 'Discrete Structure 1', 'CS 121', '1st Year Second Sem'),
(301, 'Object-Oriented Programming', 'CS 122', '1st Year Second Sem'),
(302, 'Graphics and Visual Computing', 'CSE 101', '1st Year Second Sem'),
(303, 'Physical Activities Towards Health and Fitness 2', 'PATHFIT 2', '1st Year Second Sem'),
(304, 'National Service Training Program 2', 'NSTP 2', '1st Year Second Sem'),
(305, 'Ethics', 'GE 105', '2nd Year First Sem'),
(306, 'Art Appreciation', 'GE 106', '2nd Year First Sem'),
(307, 'Data Structures and Algorithms', 'CC 104', '2nd Year First Sem'),
(308, 'Data Structure 2', 'CC 105', '2nd Year First Sem'),
(309, 'Information Management', 'DC 102', '2nd Year First Sem'),
(310, 'Web Development', 'DC 103', '2nd Year First Sem'),
(311, 'Automata Theory and Formal Languages', 'DC 104', '2nd Year First Sem'),
(312, 'Physical Activities Towards Health 3', 'PATHFIT 3', '2nd Year First Sem'),
(313, 'Science and Technology', 'GE 107', '2nd Year Second Sem'),
(314, 'The Contemporary World', 'GE 108', '2nd Year Second Sem'),
(315, 'Algorithm and Complexity', 'CS 221', '2nd Year Second Sem'),
(316, 'System Development', 'DC 105', '2nd Year Second Sem'),
(317, 'Systems Analysis and Design', 'DC 106', '2nd Year Second Sem'),
(318, 'Database Administration and Concepts', 'DC 107', '2nd Year Second Sem'),
(319, 'Data Science Fundamentals', 'DC 108', '2nd Year Second Sem'),
(320, 'Physical Activities Towards Health 4', 'PATHFIT 4', '2nd Year Second Sem'),
(321, 'Entrepreneurial Mind', 'GE 102', '3rd Year First Sem'),
(322, 'Statistics', 'MATH 2', '3rd Year First Sem'),
(323, 'Architecture and Organization', 'CS 311', '3rd Year First Sem'),
(324, 'Software Engineering 1', 'CS 312', '3rd Year First Sem'),
(325, 'Introduction to Mobile Application', 'CS 313', '3rd Year First Sem'),
(326, 'Parallel and Distributed Computing', 'CSE 102', '3rd Year First Sem'),
(327, 'Machine Learning 1', 'MAC 1', '3rd Year First Sem'),
(328, 'Intelligent Systems', 'CSE 103', '3rd Year First Sem'),
(329, 'Gender and Society', 'GE 103', '3rd Year Second Sem'),
(330, 'Information Assurance and Security', 'CS 321', '3rd Year Second Sem'),
(331, 'Operating Systems', 'CS 322', '3rd Year Second Sem'),
(332, 'Software Engineering 2', 'CS 323', '3rd Year Second Sem'),
(333, 'Programming Languages', 'CS 324', '3rd Year Second Sem'),
(334, 'Social Issues and Professional Practices', 'CS 325', '3rd Year Second Sem'),
(335, 'Thesis 1', 'THESIS 1', '3rd Year Second Sem'),
(336, 'The Life, Works and Writings of Rizal', 'RIZAL', '4th Year First Sem'),
(337, 'Human Computer Interaction', 'CS 411', '4th Year First Sem'),
(338, 'Machine Learning 2', 'MAC 2', '4th Year First Sem'),
(339, 'Thesis 2', 'THESIS 2', '4th Year First Sem'),
(340, 'Practicum (300 hours)', 'PRAC', '4th Year Second Sem'),
(341, 'Applications Development', 'DC 106', '4th Year Second Sem'),
(342, 'Networks and Communication', 'CS 421', '4th Year Second Sem');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`) VALUES
(9, 13, 300);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content_link` text DEFAULT NULL,
  `type` enum('pdf','video','link') DEFAULT 'pdf',
  `date_uploaded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') DEFAULT 'student',
  `year` varchar(50) DEFAULT NULL,
  `gwa` decimal(3,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `year`, `gwa`, `created_at`) VALUES
(1, 'kian', 'kian@gmail.com', '$2y$10$3bt6YGeGmJUe9VS1ZtUEoeQd.igpgpwgVsqphSMGN7cCQOehC1Jzi', 'student', '1st Year - First Sem', 0.00, '2026-04-03 13:25:20'),
(3, 'joshua', 'josh@gmail.com', '$2y$10$nQBV5tgcjWismoP3ESxPm.mkzKp0/6pqhpdoAhuAjWnKK47gWrqRS', 'student', '1st Year - First Sem', 0.00, '2026-04-03 13:53:17'),
(4, 'tyrone', 'tyron@gmail.com', '$2y$10$kNEMX0zsgxjfvM50Knp/Me6EwZHWCKvsjQPu1BiIVD.n2OKkzY7b6', 'student', '1st Year - First Sem', 0.00, '2026-04-03 14:30:41'),
(6, 'red', 'red@gmail.com', '$2y$10$x2O3a8kOHyDsZ0LCtnn1NOE3cbrIwE333aTGkh5v.bCMILJu1V4Su', 'student', '1st Year - First Sem', 0.00, '2026-04-05 08:15:07'),
(7, 'joshua fajilan', 'joshua@gmail.com', '$2y$10$TgZgoFHBD4MDmNRhc5XKMuu6Yf1QogZv4fxBJhhyq8RXjLBgZRVLm', 'student', '4th Year - First Sem', 0.00, '2026-04-05 08:22:27'),
(8, 'kian mark morales', 'kianmarkmorales@gmail.com', '$2y$10$V2egnXuBAifpoKp0t7/Q5OxHVSc424tkM/ibPgV1v2skEaqx4Tk9a', 'student', '2nd Year - First Sem', 0.00, '2026-04-05 09:26:21'),
(9, 'joshua', 'joshua123@gmail.com', '$2y$10$uqDEYTnF/ohV9HiWDoReFu21SKy0I2sZ8AsX0UXwlB0Aup.Pm9H92', 'student', '4th Year - First Sem', 0.00, '2026-04-05 09:36:27'),
(10, 'kian', 'kian123@gmai.com', '$2y$10$WUgiPIW41FTn2Og3nOvxgO2Z.PRItf1IGOMxrxEbwmu8HnSkvHALy', 'student', '1st Year - First Sem', 0.00, '2026-04-19 07:51:03'),
(11, 'kian', 'kian1234@gmail.com', '$2y$10$DN8evCdtABJMlw4dJafqiuKnKmJ4RPwDnv7H7ODpU2Xi3pF6MyuVq', 'student', '2nd Year - First Sem', 0.00, '2026-04-19 14:24:46'),
(12, 'kian mark morales ', 'kiankiankian@gmail.com', '$2y$10$eL7g9s.gLtsu8PI0YINoSu/uLpmLDzI6u8rrFxAUkf7gzBiNvcm.i', 'student', '2nd Year - Second Sem', 0.00, '2026-04-19 18:27:21'),
(13, 'kian mark morales', 'kianmarkmorales123@gmail.com', '$2y$10$FLkja9f/kk7h9KkbVLm.ru2Mun8dCMgNJfOKXuJM1Qt5ysdBCHALW', 'student', '1st Year - Second Sem', 0.00, '2026-04-19 18:52:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
