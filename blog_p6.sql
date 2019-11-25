-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 25 nov. 2019 à 09:14
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `title`, `description`) VALUES
(1, 'Simple', ''),
(2, 'Moyen', ''),
(3, 'Difficile', '');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `trick_id`, `author`, `content`, `created_at`) VALUES
(100, 21, 'Majon', 'blabla', '2019-11-07 13:50:28'),
(101, 21, 'zozo', 'zozo', '2019-11-07 13:50:48'),
(102, 21, 'Majid', 'Effectivement, c\'est un trick assez basique mais qu\'il faut bien réaliser ! Ne pas faire un 180° baclé, cela ne sert à rien !', '2019-11-07 14:07:21'),
(103, 21, 'Zouzou', 'Basique mais j\'ai mis un bon moment avant de réussir la réalisation !', '2019-11-20 08:39:51');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191010105422', '2019-10-10 10:57:31'),
('20191021073343', '2019-10-21 07:34:39'),
('20191022073819', '2019-10-22 07:41:44'),
('20191022075357', '2019-10-22 07:54:37'),
('20191023065506', '2019-10-23 06:55:28'),
('20191104071039', '2019-11-04 07:11:36'),
('20191105212926', '2019-11-05 21:29:42'),
('20191107133205', '2019-11-07 13:32:36'),
('20191111144804', '2019-11-11 14:49:05'),
('20191111171400', '2019-11-11 17:15:24'),
('20191112093004', '2019-11-12 09:30:28');

-- --------------------------------------------------------

--
-- Structure de la table `picture_illustration`
--

DROP TABLE IF EXISTS `picture_illustration`;
CREATE TABLE IF NOT EXISTS `picture_illustration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tricks_id` int(11) NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EFE661C53B153154` (`tricks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `picture_illustration`
--

INSERT INTO `picture_illustration` (`id`, `tricks_id`, `picture`) VALUES
(3, 19, '180-5dcbd000ad359.jpeg'),
(4, 23, '360-5dcbd7b14dfa1.jpeg'),
(9, 21, 'https://image.noelshack.com/fichiers/2019/47/7/1574601176-360.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

DROP TABLE IF EXISTS `tricks`;
CREATE TABLE IF NOT EXISTS `tricks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `illustration_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `video_illustration` varchar(700) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E1D902C112469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `name`, `description`, `illustration_filename`, `category_id`, `video_illustration`, `slug`) VALUES
(19, 'Grab', 'Le grab est une figure basique dont découle beaucoup de variantes. Idéale pour les débutants et commencer à frimer sur les pistes ;)', 'maxresdefault-5db16c562dcb6.jpeg', 1, 'https://www.youtube.com/embed/CA5bURVJ5zk', 'Grab'),
(21, '180°', 'Le 180° fait partie des tricks basiques, assez simple à réaliser il vous permettra d\'acquérir les bonnes bases pour évoluer dans les tricks de snow', '180-5dc3e23a161fc.jpeg', 1, 'https://www.youtube.com/embed/NQ1MERtpFLQ', '180°'),
(22, '360°', 'Le fameux 360°, le plus dur parmi des \"simples\". En effet, c\'est la barrière à franchir pour beaucoup de débutants, car une fois ce trick géré, c\'est le passage au niveau supérieur !', '360-5dc3e2f65f3be.jpeg', 1, 'https://www.youtube.com/embed/hUddT6FGCws', '360°'),
(23, 'Backflip', 'Wow ! Le flippant, le déroutant, le difficile, j\'ai nommé BACKFLIP !', 'backflip-5dc3e3cac2830.jpeg', 3, 'https://www.youtube.com/embed/IEstbsCJvaU', 'BackFlip'),
(24, 'Japan Air', 'Pas aussi dangereux que les backflip, il reste tout de même particulier et demande une rapidité d\'exécution assez singulière', 'japanair-5dc3e43ebe6c0.jpeg', 2, 'https://www.youtube.com/embed/jH76540wSqU', 'Japan-air'),
(25, 'nosegrab', 'Dans la famille des basiques, je veux NOSE GRAB !', 'nosegrab-5dc3e52e08598.jpeg', 1, 'https://www.youtube.com/embed/M-W7Pmo-YMY', 'Nose-Grab'),
(26, 'One foot', 'Un peu de fun ! Si tu cherches à rigoler avec tes potes sur les pistes ce trick est parfait !', 'onefoot-5dc3e58f98456.jpeg', 1, 'https://www.youtube.com/embed/lh828aVXCYA', 'One-foot'),
(27, 'Slide', 'Un petit slide sur le côté, une barre qui glisse, AIE ! Je sais... Les débuts sont souvent comme ça mais ne t\'en fais pas ça vient avec le temps !', 'slide-5dc3e5e9957ca.jpeg', 2, 'https://www.youtube.com/embed/R3OG9rNDIcs', 'Slide'),
(28, 'Stale Fisih', 'Wouuuuuh ! Quelle classe sur les pistes avec le Stale Fish !', 'tricksstalefishgrab620x393-5dc3e6417f02e.jpeg', 2, 'https://www.youtube.com/embed/51sQRIK-TEI', 'stale-fish'),
(29, 'Grab Mute', 'Une autre forme de grab, allez allez on se motive !', 'grabb-5dc3e6cf6da5e.jpeg', 2, 'https://www.youtube.com/embed/51sQRIK-TEI', 'Grab-Mute');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm` tinyint(1) DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `username`, `password`, `token`, `confirm`, `profile_picture`) VALUES
(3, 'majon@gmail.com', '{\"roles\": \"ROLE_ADMIN\"}', 'majon', '$argon2id$v=19$m=65536,t=4,p=1$cE84d3ZaYnhwZDNnNUxtdw$B5cYDf0PVz3uJ6RcQIP7vcLA9OYOHKN8mhuFCjwEcPw', NULL, NULL, NULL),
(4, 'goyave@gmail.com', '[]', 'Goyave', '$argon2id$v=19$m=65536,t=4,p=1$aGQ5UWNYeTZDOGd4MDRoUQ$PvvTn+yscjVCo6QcL1y8h921QCchEyrB3RKtg0l3KSU', NULL, NULL, NULL),
(8, 'majidAdmin@gmail.com', '[\"ROLE_ADMIN\"]', 'majidAdmin@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$QkdBNTFUelV5SGM3TllpaA$vTiG8kuG6ER49UTPibl04nbpYD8OGqpSjKfoj9cGmyw', '470369969', 0, NULL),
(9, 'mail@gmail.com', '[\"ROLE_ADMIN_EDITOR\"]', 'mail@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RC9ObzMxRlRWNUlRMTliVg$SsLpC8GazEM5BUN/+LuK5c15me2vGr7vkEZNYB8JWzk', '1760241288', 1, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `picture_illustration`
--
ALTER TABLE `picture_illustration`
  ADD CONSTRAINT `FK_EFE661C53B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
