-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 avr. 2025 à 21:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `based`
--

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` int(11) NOT NULL,
  `logo` varchar(225) DEFAULT 'logo.jpg',
  `nom` varchar(225) NOT NULL,
  `description` varchar(225) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `dateC` varchar(255) NOT NULL,
  `nbrEmp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `logo`, `nom`, `description`, `adresse`, `dateC`, `nbrEmp`) VALUES
(1, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(2, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(3, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(4, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(5, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(6, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(7, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(8, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(9, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(10, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(11, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(12, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(13, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(14, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(15, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(16, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(17, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(18, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(19, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(20, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(21, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(22, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(23, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(24, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(25, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(26, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(27, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(28, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(29, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(30, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(31, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(32, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(33, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(34, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(35, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(36, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(37, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(38, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(39, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(40, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(41, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(42, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(43, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(44, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(45, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(46, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(47, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(48, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(49, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(50, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(51, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(52, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(53, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(54, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(55, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(56, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(57, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(58, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(59, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(60, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(61, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(62, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(63, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(64, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(65, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(66, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(67, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(68, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(69, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(70, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(71, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(72, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(73, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(74, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(75, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(76, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(77, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(78, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(79, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(80, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(81, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(82, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(83, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(84, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(85, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(86, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(87, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(88, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(89, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(90, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(91, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(92, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(93, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(94, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(95, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(96, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(97, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(98, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(99, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(100, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(101, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(102, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(103, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(104, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(105, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(106, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(107, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(108, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(109, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(110, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(111, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(112, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(113, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(114, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(115, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(116, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(117, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(118, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(119, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108),
(120, 'logo.jpg', 'Teck', 'vente de produit teck', 'paris', '19-05-2000', 108);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
