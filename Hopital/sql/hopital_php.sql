-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 09 nov. 2021 à 02:12
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hopital_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `motifs`
--

DROP TABLE IF EXISTS `motifs`;
CREATE TABLE IF NOT EXISTS `motifs` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `motifs`
--

INSERT INTO `motifs` (`code`, `libelle`) VALUES
(1, 'Consultation libre'),
(2, 'Urgence'),
(3, 'Prescription');

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

DROP TABLE IF EXISTS `patients`;
CREATE TABLE IF NOT EXISTS `patients` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `sexe` varchar(2) NOT NULL,
  `date_naissance` date NOT NULL,
  `num_sec_soc` bigint(13) DEFAULT NULL,
  `code_pays` varchar(4) NOT NULL,
  `date_prem_entree` date NOT NULL,
  `code_motifs` int(11) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `fk_patients_sexe_id` (`sexe`),
  KEY `fk_patients_pays_id` (`code_pays`),
  KEY `fk_patients_motifs_id` (`code_motifs`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`code`, `nom`, `prenom`, `sexe`, `date_naissance`, `num_sec_soc`, `code_pays`, `date_prem_entree`, `code_motifs`) VALUES
(1, 'MAALOUL', 'Ali', 'M', '1979-01-12', NULL, 'TN', '2018-02-01', 1),
(2, 'DUPONT', 'Veronique', 'F', '1938-12-27', 238277502900442, 'FR', '2018-04-05', 2),
(3, 'DUPONT', 'Jean', 'M', '1985-04-01', 185045903800855, 'FR', '2018-06-12', 3),
(4, 'EL GUERROUJ', 'Hicham', 'M', '1980-06-10', NULL, 'MA', '2018-08-18', 1),
(5, 'BELMADI', 'Djamel', 'M', '1982-12-27', NULL, 'DZ', '2018-09-26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `code` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`code`, `libelle`) VALUES
('FR', 'France'),
('BE', 'Belgique'),
('MA', 'Maroc'),
('TN', 'Tunisie'),
('DZ', 'Algerie');

-- --------------------------------------------------------

--
-- Structure de la table `sexe`
--

DROP TABLE IF EXISTS `sexe`;
CREATE TABLE IF NOT EXISTS `sexe` (
  `code` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sexe`
--

INSERT INTO `sexe` (`code`, `libelle`) VALUES
('F', 'Feminin'),
('M', 'Masculin');
COMMIT;

-- --------------------------------------------------------

--
-- Structure de la table `reference_document`
--

DROP TABLE IF EXISTS `reference_document`;
CREATE TABLE IF NOT EXISTS `reference_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) DEFAULT NULL,
  `code_patients` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_patients` (`code_patients`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reference_document`
--

INSERT INTO `reference_document` (`id`, `nom`, `code_patients`) VALUES
(1, '', 1),
(2, '', 2),
(3, '', 3),
(4, '', 4),
(5, '', 5),
(6, '', 1),
(7, '', 2),
(9, '', 2),
(10, '', 2),
(11, '', 3),
(12, '', 3),
(13, '', 5),
(14, '', 3),
(15, '', 4),
(16, '', 4);


--
-- Contraintes pour la table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `fk_patients_sexe` FOREIGN KEY (`sexe`) REFERENCES `sexe` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_patients_pays` FOREIGN KEY (`code_pays`) REFERENCES `pays` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_patients_motifs` FOREIGN KEY (`code_motifs`) REFERENCES `motifs` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
