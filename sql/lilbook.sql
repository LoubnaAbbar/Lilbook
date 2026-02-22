-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 22 fév. 2026 à 18:49
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lilbook`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(150) DEFAULT NULL,
  `description` text,
  `slug` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `description`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Conte', 'À travers le voyage d’un jeune prince venu d’une autre planète, ce conte poétique explore l’amitié, l’amour et le regard que les adultes portent sur le monde.', 'le-petit-prince', '2026-02-21 15:13:39', '2026-02-22 19:16:05'),
(3, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', 'Fantasy', 'Un jeune garçon découvre qu’il est sorcier et entre à l’école de Poudlard, où il se lie d’amitié et affronte les premières forces obscures de son destin.', 'harry-potter-ecole-sorciers', '2026-02-21 15:13:39', '2026-02-22 19:16:22'),
(4, '1984', 'George Orwell', 'Dystopie', 'Dans un régime totalitaire où chaque individu est surveillé en permanence, un homme tente de préserver sa liberté de pensée face à l’oppression.', '1984', '2026-02-21 15:13:39', '2026-02-22 19:16:37'),
(5, 'Les Misérables', 'Victor Hugo', 'Historique', 'À travers le destin de plusieurs personnages marqués par l’injustice, ce roman retrace les luttes sociales et morales de la France du XIXe siècle.', 'les-miserables', '2026-02-21 15:13:39', '2026-02-22 19:16:57'),
(6, 'L\'Étranger', 'Albert Camus', 'Philosophique', 'Un homme indifférent au monde qui l\'entoure se retrouve confronté à l’absurdité de l’existence après un acte irréversible qui bouleverse sa vie.', 'l-etranger', '2026-02-21 15:14:52', '2026-02-22 19:17:10'),
(9, 'La bibliothèque de minuit', 'Matt Haig', 'Roman contemporain', 'Entre la vie et la mort, une femme découvre une bibliothèque mystérieuse où chaque livre représente une version différente de son existence.', 'la-bibliotheque-de-minuit-2', '2026-02-22 19:14:54', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@lilbook.com', '$2y$10$Z3Hc3WOFT5uMSqjDdn9a3ujZ.gdx0P34TVgiuz1DEHTqB.9GXHMgy', 'admin', '2026-02-21 15:13:39'),
(2, 'user', 'user@lilbook.com', '$2y$10$KbQiD6K4RjWgY5Yw3a5KxeUyk6xj4nM3nH8u6Hk4P7R9bK8w3FzCe', 'user', '2026-02-21 15:13:39'),
(3, 'loubna', '', '$2y$10$sLkV5iyQt7.W0oKVmup1nufE5ExVAsJYC5qV4v867Pb292EkDn7wW', 'user', '2026-02-22 19:04:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
