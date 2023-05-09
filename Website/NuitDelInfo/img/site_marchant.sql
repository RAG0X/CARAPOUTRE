-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 15 nov. 2022 à 10:27
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `site_marchant`
--

-- --------------------------------------------------------

--
-- Structure de la table `table_catalogue`
--

DROP TABLE IF EXISTS `table_catalogue`;
CREATE TABLE IF NOT EXISTS `table_catalogue` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `Constructeur` varchar(50) NOT NULL,
  `Modele` varchar(50) NOT NULL,
  `Prix` int(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_catalogue`
--

INSERT INTO `table_catalogue` (`ID`, `Constructeur`, `Modele`, `Prix`) VALUES
(1, 'Peugeot', '306 1.4', 2000),
(2, 'Peugeot', '306 Laboiserie', 12000),
(3, 'Peugeot', '306 Neuve', 5000),
(4, 'Peugeot', '306 Maxi', 2),
(5, 'Peugeot', '306 Limousine Luxe', 100000),
(6, 'Peugeot', '306 Piscine', 3800),
(7, 'Peugeot', '306 4x4', 5500),
(8, 'Peugeot', '306 Grand coffre', 7000);

-- --------------------------------------------------------

--
-- Structure de la table `table_login`
--

DROP TABLE IF EXISTS `table_login`;
CREATE TABLE IF NOT EXISTS `table_login` (
  `ID` int(50) NOT NULL AUTO_INCREMENT,
  `utilisateur` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `table_login`
--

INSERT INTO `table_login` (`ID`, `utilisateur`, `email`, `password`) VALUES
(1, 'QuentinF', 'jurax5000@gmail.com', 'azerty123');

-- --------------------------------------------------------

--
-- Structure de la table `table_panier`
--

DROP TABLE IF EXISTS `table_panier`;
CREATE TABLE IF NOT EXISTS `table_panier` (
  `ID` int(50) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_voiture` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
