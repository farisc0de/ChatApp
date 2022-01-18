SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user` int NOT NULL,
  `message` text COLLATE utf8mb4_bin NOT NULL,
  `date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_online` tinyint(1) NOT NULL DEFAULT '0',
  `failed_login` int NOT NULL DEFAULT '0',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `is_online`, `failed_login`, `last_login`) VALUES
(1, 'admin', '$2y$10$Nq9Vvf9MxOIVRJvHHz/KvOt4X/BOmz.5s4rizTEnPYWAD7sphcAFK', 'admin@localhost.com', 0, 0, '2022-01-18 15:51:29');

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;