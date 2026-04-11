-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 12:18 PM
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
-- Database: `playnrate`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `genre_id` int(11) NOT NULL,
  `release_year` year(4) NOT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT 'default-cover.jpg',
  `avg_rating` decimal(3,1) DEFAULT 0.0,
  `rating_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `description`, `genre_id`, `release_year`, `developer`, `publisher`, `cover_image`, `avg_rating`, `rating_count`, `created_at`, `updated_at`) VALUES
(1, 'Elden Ring', 'An action RPG set in a vast open world crafted by Hidetaka Miyazaki and George R.R. Martin. Explore the Lands Between, battle fearsome bosses, and uncover the mystery of the Elden Ring.', 1, '2022', 'FromSoftware', 'Bandai Namco', 'elden-ring.jpg', 9.7, 3, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(2, 'The Witcher 3: Wild Hunt', 'A story-driven open-world RPG set in a war-torn fantasy universe. Play as Geralt of Rivia, a monster hunter, and make choices that shape the world around you.', 2, '2015', 'CD Projekt Red', 'CD Projekt', 'witcher3.jpg', 9.7, 3, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(3, 'Cyberpunk 2077', 'An open-world action-adventure set in Night City. Play as V, a mercenary outlaw going after a one-of-a-kind implant that holds the key to immortality.', 1, '2020', 'CD Projekt Red', 'CD Projekt', 'cyberpunk2077.jpg', 8.0, 3, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(4, 'Halo Infinite', 'Master Chief returns to confront the most ruthless foe he has ever faced — the Banished — on a mysterious ringworld known as Zeta Halo.', 3, '2021', '343 Industries', 'Xbox Game Studios', 'halo-infinite.jpg', 7.5, 2, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(5, 'The Legend of Zelda: Breath of the Wild', 'Step into a world of discovery and exploration in this open-air adventure. Explore the wilds of Hyrule and face the darkness of Calamity Ganon.', 4, '2017', 'Nintendo EPD', 'Nintendo', 'botw.jpg', 9.5, 2, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(6, 'Civilization VI', 'Build an empire to stand the test of time in this critically acclaimed strategy game. Explore, expand, exploit and exterminate across multiple eras.', 5, '2016', 'Firaxis Games', '2K Games', 'civ6.jpg', 6.0, 3, '2026-04-04 09:00:12', '2026-04-09 11:24:21'),
(7, 'FIFA 24', 'EA Sports FC brings the world\'s game to life with HyperMotion V technology, delivering a true-to-life football experience.', 6, '2023', 'EA Vancouver', 'EA Sports', 'fifa24.jpg', 5.0, 3, '2026-04-04 09:00:12', '2026-04-09 11:49:57'),
(8, 'Resident Evil Village', 'Set a few years after Resident Evil 7, Ethan Winters searches a mysterious village for his kidnapped daughter while uncovering dark secrets.', 7, '2021', 'Capcom', 'Capcom', 're-village.jpg', 8.5, 2, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(9, 'Hollow Knight', 'A challenging 2D action-adventure through a vast ruined kingdom of insects and heroes. Explore twisting caverns and battle tainted creatures.', 8, '2017', 'Team Cherry', 'Team Cherry', 'hollow-knight.jpg', 9.5, 2, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(10, 'God of War Ragnarök', 'Kratos and his son Atreus must journey to each of the Nine Realms in search of answers as Fimbulwinter approaches its end.', 1, '2022', 'Santa Monica Studio', 'Sony Interactive Entertainment', 'gow-ragnarok.jpg', 8.7, 3, '2026-04-04 09:00:12', '2026-04-09 10:45:12'),
(11, 'Baldur\'s Gate 3', 'Gather your party and return to the Forgotten Realms in this tale of fellowship and betrayal, sacrifice and survival, and the lure of absolute power.', 2, '2023', 'Larian Studios', 'Larian Studios', 'bg3.jpg', 9.5, 2, '2026-04-04 09:00:12', '2026-04-08 07:11:10'),
(12, 'Doom Eternal', 'Hell\'s armies have invaded Earth. Become the Slayer in an epic single-player campaign to conquer demons across dimensions.', 3, '2020', 'id Software', 'Bethesda Softworks', 'doom-eternal.jpg', 6.7, 3, '2026-04-04 09:00:12', '2026-04-09 11:32:25');

-- --------------------------------------------------------

--
-- Table structure for table `game_platforms`
--

CREATE TABLE `game_platforms` (
  `game_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_platforms`
--

INSERT INTO `game_platforms` (`game_id`, `platform_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 3),
(2, 6),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 4),
(5, 5),
(6, 1),
(7, 1),
(7, 3),
(7, 6),
(8, 1),
(8, 2),
(8, 5),
(9, 1),
(9, 5),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Action', 'Fast-paced games focused on combat and reflexes', '2026-04-04 09:00:12'),
(2, 'RPG', 'Role-playing games with story, progression and character builds', '2026-04-04 09:00:12'),
(3, 'FPS', 'First-person shooter games', '2026-04-04 09:00:12'),
(4, 'Adventure', 'Story-driven exploration games', '2026-04-04 09:00:12'),
(5, 'Strategy', 'Tactical and resource management games', '2026-04-04 09:00:12'),
(6, 'Sports', 'Sports and racing simulations', '2026-04-04 09:00:12'),
(7, 'Horror', 'Survival horror and psychological terror', '2026-04-04 09:00:12'),
(8, 'Platformer', 'Jump-and-run side-scrolling games', '2026-04-04 09:00:12');

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`) VALUES
(5, 'Nintendo Switch'),
(1, 'PC'),
(3, 'PlayStation 4'),
(2, 'PlayStation 5'),
(6, 'Xbox One'),
(4, 'Xbox Series X');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` tinyint(4) NOT NULL CHECK (`score` between 1 and 10),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `game_id`, `user_id`, `score`, `review_text`, `created_at`) VALUES
(1, 1, 1, 10, 'An absolute masterpiece. The world design and boss fights are unmatched.', '2026-04-08 07:11:10'),
(2, 1, 2, 9, 'Breathtaking world but steep learning curve for newcomers.', '2026-04-08 07:11:10'),
(3, 1, 3, 10, 'Best game I have ever played. Period.', '2026-04-08 07:11:10'),
(4, 2, 4, 10, 'The story, the characters, the world — all perfect. A gold standard RPG.', '2026-04-08 07:11:10'),
(5, 2, 5, 9, 'Incredible narrative depth. Some quests genuinely moved me.', '2026-04-08 07:11:10'),
(6, 2, 6, 10, 'Gwent alone is worth the price. Timeless classic.', '2026-04-08 07:11:10'),
(7, 3, 7, 7, 'Rough at launch but now a fantastic cyberpunk experience.', '2026-04-08 07:11:10'),
(8, 3, 8, 8, 'Night City is stunningly detailed. Story is gripping.', '2026-04-08 07:11:10'),
(9, 3, 9, 9, 'The 2.0 update transformed this game completely.', '2026-04-08 07:11:10'),
(10, 4, 10, 8, 'The campaign is solid and multiplayer is addictive.', '2026-04-08 07:11:10'),
(11, 4, 11, 7, 'Good but feels like a step back from Halo 5 in some areas.', '2026-04-08 07:11:10'),
(12, 5, 12, 10, 'Redefines what open-world games can be. Pure joy to explore.', '2026-04-08 07:11:10'),
(13, 5, 13, 9, 'Still magical years later. A benchmark for game design.', '2026-04-08 07:11:10'),
(14, 6, 14, 9, 'The deepest strategy experience you can get. Hundreds of hours of content.', '2026-04-08 07:11:10'),
(15, 6, 15, 8, 'Perfect for fans of the series. The civics system is genius.', '2026-04-08 07:11:10'),
(16, 7, 16, 7, 'Solid gameplay improvements but still feels incremental.', '2026-04-08 07:11:10'),
(17, 7, 17, 6, 'Good football sim but little innovation year over year.', '2026-04-08 07:11:10'),
(18, 8, 18, 9, 'Terrifying atmosphere and brilliant level design. Loved every second.', '2026-04-08 07:11:10'),
(19, 8, 19, 8, 'Lady Dimitrescu sections are iconic. Great horror game.', '2026-04-08 07:11:10'),
(20, 9, 20, 10, 'One of the greatest indie games ever made. Art, music, gameplay — all perfect.', '2026-04-08 07:11:10'),
(21, 9, 21, 9, 'Brutally difficult but extremely rewarding. A true gem.', '2026-04-08 07:11:10'),
(22, 10, 22, 10, 'Emotional, epic, and beautiful. Sets a new bar for action games.', '2026-04-08 07:11:10'),
(23, 10, 23, 9, 'The father-son dynamic is handled with so much care.', '2026-04-08 07:11:10'),
(24, 11, 24, 10, 'A revolution in RPGs. The reactivity and depth are unparalleled.', '2026-04-08 07:11:10'),
(25, 11, 25, 9, 'Larian has outdone themselves. This is D&D brought to life perfectly.', '2026-04-08 07:11:10'),
(26, 12, 26, 9, 'Non-stop adrenaline. Best gunplay in any FPS, full stop.', '2026-04-08 07:11:10'),
(27, 12, 27, 8, 'Incredible movement system and satisfying combat loop.', '2026-04-08 07:11:10'),
(28, 10, 29, 7, 'Game hay', '2026-04-09 10:45:12'),
(29, 6, 29, 1, 'like shit', '2026-04-09 11:24:21'),
(30, 12, 29, 3, 'shit game', '2026-04-09 11:32:25'),
(31, 7, 29, 2, 'I don&#039;t like it', '2026-04-09 11:49:57');

--
-- Triggers `ratings`
--
DELIMITER $$
CREATE TRIGGER `after_rating_delete` AFTER DELETE ON `ratings` FOR EACH ROW BEGIN
    UPDATE games
    SET avg_rating  = COALESCE((SELECT ROUND(AVG(score),1) FROM ratings WHERE game_id = OLD.game_id), 0.0),
        rating_count = (SELECT COUNT(*) FROM ratings WHERE game_id = OLD.game_id)
    WHERE id = OLD.game_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_rating_insert` AFTER INSERT ON `ratings` FOR EACH ROW BEGIN
    UPDATE games
    SET avg_rating  = (SELECT ROUND(AVG(score),1) FROM ratings WHERE game_id = NEW.game_id),
        rating_count = (SELECT COUNT(*) FROM ratings WHERE game_id = NEW.game_id)
    WHERE id = NEW.game_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'AlexM', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(2, 'SaraK', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(3, 'TomR', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(4, 'EmilyW', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(5, 'JakeS', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(6, 'NinaP', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(7, 'ChrisB', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(8, 'MiaT', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(9, 'LiamO', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(10, 'RyanH', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(11, 'ZoeL', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(12, 'DanielC', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(13, 'AnnaB', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(14, 'MarcusF', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(15, 'LunaV', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(16, 'KevinP', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(17, 'JessA', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(18, 'FrankD', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(19, 'GraceE', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(20, 'OliviaN', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(21, 'SamQ', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(22, 'IsabellaR', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(23, 'HenryS', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(24, 'SophiaT', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(25, 'ArthurU', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(26, 'ChloeV', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(27, 'EthanW', '$2y$10$I6fOxJtJ42PYpi6PX6GYKO3DRPzJSjFrD.VZ2UP53AFFlTjxSk.qS', 'user', '2026-04-08 07:11:10'),
(28, 'admin', '$2y$10$/kGoS8DrZ03K8FF3EZjkzeF0NVBYtx9HLADSBbhKBKvJxVC.Lh7ry', 'admin', '2026-04-08 07:21:17'),
(29, 'minh', '$2y$10$gC2Q.s07U/VzcNZiAxCpJuqhi2lsxcJL/IoxIeFz2gFbDRVuqipLa', 'user', '2026-04-08 09:01:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `game_platforms`
--
ALTER TABLE `game_platforms`
  ADD PRIMARY KEY (`game_id`,`platform_id`),
  ADD KEY `platform_id` (`platform_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `fk_rating_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `game_platforms`
--
ALTER TABLE `game_platforms`
  ADD CONSTRAINT `game_platforms_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_platforms_ibfk_2` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_rating_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
