-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 02:43 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dania_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `avatar_name` varchar(255) DEFAULT NULL,
  `avatar_image` varchar(255) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`id`, `avatar_name`, `avatar_image`, `cost`) VALUES
(1, 'Space Explorer', 'explorer.png', 50),
(2, 'Astronaut', 'astronaut.png', 100),
(3, 'Alien', 'alien.png', 150),
(4, 'Robot', 'robot.png', 200),
(5, 'Cosmic Warrior', 'warrior.png', 300);

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE `coins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `coins_earned` int(11) DEFAULT 0,
  `coins_spent` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT 0,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `level_number` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `total_sessions` int(11) DEFAULT 12
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `level_number`, `level_name`, `description`, `total_sessions`) VALUES
(1, 1, 'test', 'dkidhidhi', 12),
(3, 2, 'Sun and planets', 'aaaaa', 12);

-- --------------------------------------------------------

--
-- Table structure for table `planets`
--

CREATE TABLE `planets` (
  `id` int(11) NOT NULL,
  `planet_name` varchar(255) DEFAULT NULL,
  `planet_image` varchar(255) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planets`
--

INSERT INTO `planets` (`id`, `planet_name`, `planet_image`, `cost`) VALUES
(1, 'Earth', 'earth.png', 100),
(2, 'Mars', 'mars.png', 150),
(3, 'Jupiter', 'jupiter.png', 200),
(4, 'Saturn', 'saturn.png', 250),
(5, 'Neptune', 'neptune.png', 300);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `quiz_name` varchar(100) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `correct_answer_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `level_id`, `quiz_name`, `total_questions`, `correct_answer_count`, `created_at`) VALUES
(10, 1, 'test1', 10, 0, '2024-09-29 11:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question_text`, `correct_answer`, `option_a`, `option_b`, `option_c`, `option_d`) VALUES
(1, 10, 'how are you?', 'fine', 'bad', 'good', 'fine', 'nob'),
(2, 10, 'how do you do', 'fine', 'bad', 'fine', 'asasa', 'nob'),
(3, 10, 'qq', 'qq', 'qq', 'ww', 'ee', 'rr'),
(4, 10, 'ww', 'ww', 'qq', 'ww', 'ee', 'rr'),
(5, 10, 'rr', 'rr', 'ww', 'qq', 'rr', 'cc'),
(6, 10, 'aa', 'aa', 'qq', 'ww', '\\\\', 'aa'),
(7, 10, 'ttt', 'tt', 'yy', 'tt', 'yy', 'ee'),
(8, 10, 'ww', 'ww', 'ww', 'tt', 'asasa', 'rr'),
(9, 10, 'qqqq', 'qq', 'ww', 'qq', 'ww', 'ww'),
(10, 10, 'dd', 'dd', 'dd', 'ww', 'ee', 'qq');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `session_number` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `coins_awarded` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `level_id`, `session_number`, `content`, `is_completed`, `user_id`, `completed_at`, `coins_awarded`) VALUES
(1, 1, 1, 'fdkgvkfnkdbnkdbnkldfbnkdb', 1, NULL, NULL, 0),
(2, 1, 2, 'aaaaaaaaaaaaaaaaaaaaa', 1, NULL, NULL, 0),
(3, 3, 3, 'bffffffff', 1, NULL, NULL, 0),
(4, 1, 3, '333333', 1, 1, '2024-09-29 11:25:09', 0),
(5, 1, 4, '444444', 1, NULL, NULL, 0),
(6, 1, 5, '55555555555', 1, NULL, NULL, 0),
(7, 1, 6, '66666666666', 1, 1, '2024-09-29 11:25:48', 0),
(8, 1, 7, '777777777777777', 1, 1, '2024-09-29 11:27:10', 0),
(9, 1, 8, '8888888888888888', 1, 1, '2024-09-29 11:27:14', 0),
(10, 1, 9, '999999999999999999', 1, 1, '2024-09-29 11:27:21', 0),
(11, 1, 10, '1000000000000', 1, 1, '2024-09-29 11:27:23', 0),
(12, 1, 11, '11111111111111111111', 1, 1, '2024-09-29 11:27:25', 0),
(13, 1, 12, '12222222222222222', 1, 1, '2024-09-29 11:27:26', 0),
(14, 3, 2, '22222222', 0, NULL, NULL, 0),
(15, 3, 3, '3333333333', 0, NULL, NULL, 0),
(16, 3, 4, '444444444444', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `coins` int(11) DEFAULT 0,
  `avatar` varchar(100) DEFAULT 'default_avatar.png',
  `planet` varchar(100) DEFAULT 'Earth',
  `levels_completed` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT NULL,
  `current_streak` int(11) DEFAULT 0,
  `longest_streak` int(11) DEFAULT 0,
  `last_activity` date DEFAULT NULL,
  `last_session_date` date DEFAULT NULL,
  `sessions_completed_today` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `coins`, `avatar`, `planet`, `levels_completed`, `created_at`, `is_admin`, `current_streak`, `longest_streak`, `last_activity`, `last_session_date`, `sessions_completed_today`) VALUES
(1, 'User 01', 'user1@test.com', '25f9e794323b453885f5181f1b624d0b', 440, 'default_avatar.png', 'Earth', 0, '2024-09-28 10:33:52', 1, 1, 1, '2024-09-29', '2024-09-29', 11),
(2, 'User 02', 'user2@test.com', '25f9e794323b453885f5181f1b624d0b', 350, 'warrior.png', 'saturn.png', 0, '2024-09-29 18:23:05', NULL, 0, 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_avatars`
--

CREATE TABLE `user_avatars` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `avatar_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_avatars`
--

INSERT INTO `user_avatars` (`id`, `user_id`, `avatar_id`) VALUES
(1, 2, NULL),
(2, 2, NULL),
(3, 2, NULL),
(4, 2, NULL),
(5, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_planets`
--

CREATE TABLE `user_planets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `planet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_planets`
--

INSERT INTO `user_planets` (`id`, `user_id`, `planet_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `planets`
--
ALTER TABLE `planets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_avatars`
--
ALTER TABLE `user_avatars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `avatar_id` (`avatar_id`);

--
-- Indexes for table `user_planets`
--
ALTER TABLE `user_planets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `planet_id` (`planet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `planets`
--
ALTER TABLE `planets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_avatars`
--
ALTER TABLE `user_avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_planets`
--
ALTER TABLE `user_planets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coins`
--
ALTER TABLE `coins`
  ADD CONSTRAINT `coins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Constraints for table `user_avatars`
--
ALTER TABLE `user_avatars`
  ADD CONSTRAINT `user_avatars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_avatars_ibfk_2` FOREIGN KEY (`avatar_id`) REFERENCES `avatars` (`id`);

--
-- Constraints for table `user_planets`
--
ALTER TABLE `user_planets`
  ADD CONSTRAINT `user_planets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_planets_ibfk_2` FOREIGN KEY (`planet_id`) REFERENCES `planets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
