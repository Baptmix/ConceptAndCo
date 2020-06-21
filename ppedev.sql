-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 21 juin 2020 à 19:44
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ppedev`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `nom` varchar(120) DEFAULT NULL,
  `prenom` varchar(120) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_privilege` int(11) DEFAULT NULL,
  `is_handicapped` varchar(3) DEFAULT NULL,
  `id_equipes` int(11) DEFAULT NULL,
  `langage` varchar(2) DEFAULT NULL,
  `deactivate` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id`, `nom`, `prenom`, `login`, `password`, `id_privilege`, `is_handicapped`, `id_equipes`, `langage`, `deactivate`) VALUES
(2, 'admin', 'admin', 'admin@admin.fr', 'pwdAdmin1', 2, 'non', 1, 'en', 'non'),
(6, 'user', 'users', 'user@user.fr', 'pwdUser2', 1, 'non', 2, 'fr', 'non');

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `deactivate` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equipes`
--

INSERT INTO `equipes` (`id`, `nom`, `deactivate`) VALUES
(1, 'Equipe 1', 'non'),
(2, 'Equipe 2', 'non');

-- --------------------------------------------------------

--
-- Structure de la table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `wording` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `privilege`
--

INSERT INTO `privilege` (`id`, `wording`) VALUES
(1, 'client'),
(2, 'administrator'),
(3, 'salarie');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `nom_projet` varchar(255) DEFAULT NULL,
  `attribution` varchar(100) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `nom_projet`, `attribution`, `date_debut`, `date_fin`) VALUES
(11, 'Projet 1', 'user@user.fr', '2020-05-14 00:00:00', '2020-05-07 00:00:00'),
(15, 'Projet 2', 'user@user.fr', '2020-05-17 00:00:00', '2020-05-20 00:00:00'),
(19, 'Projet 3', 'admin@admin.fr', '2020-03-04 00:00:00', '2020-09-04 00:00:00'),
(20, 'Projet 4', 'admin@admin.fr', '2020-05-04 00:00:00', '2020-05-24 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE `taches` (
  `id` int(11) NOT NULL,
  `nom_tache` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `projet_associe` varchar(255) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`id`, `nom_tache`, `description`, `projet_associe`, `date_debut`, `date_fin`, `status`) VALUES
(1, 'Tache 1', 'Description 1', 'Projet 3', '2020-05-01 00:00:05', '2020-06-11 00:00:08', 'en cours'),
(5, 'Tache 2', 'Description 2', 'Projet 2', '2020-06-20 00:00:00', '2020-06-26 00:00:00', 'en cours'),
(6, 'Tache 3', 'Description 3', 'Projet 1', '2020-06-19 00:00:00', '2020-07-03 00:00:00', 'en cours');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT pour la table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
