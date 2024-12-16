-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 16 déc. 2024 à 15:21
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biblioecf`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

DROP TABLE IF EXISTS `abonnement`;
CREATE TABLE IF NOT EXISTS `abonnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_351268BBA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonnement`
--

INSERT INTO `abonnement` (`id`, `user_id`, `date_debut`, `date_fin`, `type`) VALUES
(5, 3, '2024-12-11 12:45:55', '2025-12-11 12:45:55', 'annuel'),
(6, 4, '2024-12-11 12:48:53', '2025-01-11 12:48:53', 'mensuel'),
(7, 5, '2024-12-11 13:01:23', '2025-12-11 13:01:23', 'annuel'),
(8, 1, '2024-12-12 09:22:32', '2025-12-12 09:22:32', 'annuel'),
(9, 6, '2024-12-12 09:23:17', '2025-01-12 09:23:17', 'mensuel'),
(10, 9, '2024-12-13 10:32:30', '2025-12-13 10:32:30', 'annuel'),
(11, 10, '2024-12-14 09:32:56', '2025-01-14 09:32:56', 'mensuel');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `note` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`),
  KEY `IDX_67F068BC37D925CB` (`livre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `user_id`, `livre_id`, `content`, `created_at`, `note`) VALUES
(1, 3, 1, 'Une oeuvre incroyable dont je ne me lasserais jamais.', '2024-12-13 09:51:45', 5),
(2, 5, 1, 'Je suis d\'accord, je compte bien le relire prochainement.', '2024-12-13 09:54:17', 5),
(3, 7, 2, 'Un très bon livre plein de rebondissement.', '2024-12-13 10:18:24', 4),
(4, 9, 1, 'Gimli > Legolas', '2024-12-13 10:33:32', 4),
(5, 11, 2, 'Excellent livre', '2024-12-14 12:21:58', 5),
(6, 3, 2, 'J\'ai beaucoup aimé, merci pour la recommandation.', '2024-12-14 12:48:18', 5);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241209095849', '2024-12-09 09:59:05', 20),
('DoctrineMigrations\\Version20241209184136', '2024-12-09 18:41:44', 34),
('DoctrineMigrations\\Version20241210162548', '2024-12-10 16:26:16', 26),
('DoctrineMigrations\\Version20241211104745', '2024-12-11 10:47:57', 37),
('DoctrineMigrations\\Version20241211104926', '2024-12-11 10:49:30', 38),
('DoctrineMigrations\\Version20241211113524', '2024-12-11 11:39:05', 43),
('DoctrineMigrations\\Version20241212190314', '2024-12-12 19:03:28', 18),
('DoctrineMigrations\\Version20241213093149', '2024-12-13 09:32:12', 56),
('DoctrineMigrations\\Version20241214113649', '2024-12-14 11:36:56', 20),
('DoctrineMigrations\\Version20241216083148', '2024-12-16 08:31:56', 63),
('DoctrineMigrations\\Version20241216090455', '2024-12-16 09:04:59', 41),
('DoctrineMigrations\\Version20241216091952', '2024-12-16 09:19:56', 24);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

DROP TABLE IF EXISTS `emprunt`;
CREATE TABLE IF NOT EXISTS `emprunt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `date_emprunt` datetime NOT NULL,
  `date_retour` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_364071D737D925CB` (`livre_id`),
  KEY `IDX_364071D7A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`id`, `user_id`, `livre_id`, `date_emprunt`, `date_retour`) VALUES
(1, 3, 1, '2024-12-16 09:05:05', '2024-12-16'),
(2, 9, 1, '2024-12-16 09:22:16', '2024-12-16'),
(3, 9, 2, '2024-12-16 09:52:18', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

DROP TABLE IF EXISTS `livres`;
CREATE TABLE IF NOT EXISTS `livres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee_publication` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `resume`, `image`, `annee_publication`) VALUES
(1, 'Le Seigneur des anneaux', 'J. R. R. Tolkien', 'Dans la Comté, les Hobbits vivaient en paix... jusqu\'au jour fatal où l\'un d\'entre eux entra en possession de l\'Anneau Unique aux immenses pouvoirs.', '08bc76fc36f4613616f2dfc963482e4e254cb359.jpg', 1972),
(2, 'Harry Potter à l\'école des sorciers', 'J. K. Rowling', 'Harry Potter, jeune orphelin, a été élevé par son oncle et sa tante dans des conditions hostiles. À l\'âge de onze ans, un demi-géant nommé Rubeus Hagrid lui apprend qu\'il possède des pouvoirs magiques et que ses parents ont été assassinés, des années aupa', 'fb9d8e2ab4d54e3757f0d58bdbe831008c7d8a38.jpg', 1997);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` date NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `prenom`, `nom`, `adress`, `ville`, `date_de_naissance`, `tel`, `avatar`) VALUES
(1, 'test1@test.com', '[\"ROLE_ADMIN\", \"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$rDrUd2XXJWSNdUenxeffeeKUbxUGQfPXJGq.NY4xedbi6dlpoLF92', 'Jean', 'Test', '15 rue de la fac', 'Pasloindutout', '1989-01-02', '0505050505', '675888d45c647.png'),
(3, 'test3@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$kHOnWqvYHjSCEYcxajGuKuOh.6iFk.Oyu/VrSGGuKJqdh.AYHuMkG', 'Jeannette', 'Testencore', '15 avenue des champs', 'Plusloin', '1997-04-14', '0504050405', NULL),
(4, 'test2@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$ieYEI8nqw5FBV/44.pJFvOqKfTO9KkK4uUapwE.jaTdSzFe4KIRrO', 'Pierre', 'Delafontaine', '20 rue marchand', 'Dacoté', '1987-05-02', '0605040302', '67587660825c2.png'),
(5, 'test4@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$5iOWDxRA9DNaePhSot0iI.PCb/oHcJV33r6Ni2Po39nUf3MlY3fk.', 'Denis', 'TestProps', '32 rue des flans', 'Environde', '1993-05-12', '0605070304', NULL),
(6, 'test5@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$UjOaEsp/VveR6C.hdoRTM.KPRxkGsuWR73LsaxKGV3h9LStO4tuVG', 'Jérémy', 'Onsaitpas', '2 avenue du centre', 'Deplusloin', '2000-07-01', '0604030502', NULL),
(7, 'test6@test.com', '[\"ROLE_USER\"]', '$2y$13$VaER4FVeD3mBTUhfnAfaTe.hO4BMmEBY0HfvE.iuzO0OXYM94k2La', 'Natan', 'Corporation', '5 avenue du centre', 'Prochede', '1994-07-18', '0642352651', NULL),
(8, 'test7@test.com', '[\"ROLE_USER\"]', '$2y$13$fflpdtQJJs2o5xb3cbcY7.9EbnPFT8E3XNaWNaJeeFEBZLfUKjz0W', 'Hugo', 'Lavidas', '17 rue de l\'avalanche', 'Pasaussiproche', '1999-05-01', '0645372961', NULL),
(9, 'test8@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$0z08nAev0unV4IIGRIbX4.5JoE2DWbIcuEP8.DR5s8a0yH1R9.WW6', 'Jennifer', 'Jones', '11 rue des champs', 'Plusloinque', '1997-05-12', '0645377982', '675c0ea94a469.png'),
(10, 'test9@test.com', '[\"ROLE_USER\", \"ROLE_ABONNE\"]', '$2y$13$ByZ/ibNli2ph5ZW8v.tfwe32dc1Dwac56s8jtf/DQw3n8QlXiRY.G', 'Fabrice', 'Lucini', '02 rue des carnes', 'Labas', '1998-01-12', '0644572961', '675d50f74f5bb.jpg'),
(11, 'test10@test.com', '[\"ROLE_USER\"]', '$2y$13$GwiNXwtEa.vmT8MvSWy/J.jR49vY3TM8WsmasJBcaI.2bJIX3n4Pe', 'Emanuelle', 'Tasted', '10 rue marchand', 'Plusloinquavant', '1899-07-04', '0692359659', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `FK_351268BBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livres` (`id`),
  ADD CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `FK_364071D737D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livres` (`id`),
  ADD CONSTRAINT `FK_364071D7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
