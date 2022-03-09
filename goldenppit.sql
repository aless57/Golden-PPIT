-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 23, 2022 at 07:26 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goldenppit`
--

-- --------------------------------------------------------

--
-- Table structure for table `besoin`
--

CREATE TABLE `besoin` (
  `b_id` int(5) NOT NULL COMMENT 'L''ID du besoin.\r\nClé primaire de la table.\r\nCette valeur s''auto-incrémente.',
  `b_objet` varchar(50) NOT NULL COMMENT 'Le nom du besoin.',
  `b_desc` varchar(500) DEFAULT NULL COMMENT 'La description du besoin.\r\nAttribut facultatif.',
  `b_nombre` int(5) DEFAULT NULL COMMENT 'Le nombre d''objets dont il est question dans le besoin. Attribut Facultatif.',
  `b_event` int(5) NOT NULL COMMENT 'L''ID de l''évènement auquel se rattache le besoin.\r\nClé étrangère sur la table evenement.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `evenement`
--

CREATE TABLE `evenement` (
  `e_id` int(10) NOT NULL COMMENT 'L''ID de l''évènement. Clé primaire de la table. Cette valeur s''auto-incrémente. ',
  `e_titre` varchar(50) NOT NULL COMMENT 'Le nom de l''évènement.',
  `e_date` date NOT NULL COMMENT 'La date de début de l''évènement.',
  `e_desc` varchar(500) DEFAULT NULL COMMENT 'La description de l''évènement. Attribut facultatif.',
  `e_image` varchar(50) DEFAULT NULL COMMENT 'Une image liée à l''évènement.\r\nAttribut facultatif.',
  `e_supp_date` date DEFAULT NULL COMMENT 'La date de suppression automatique. Attribut Facultatif. La date de suppression doit être postérieure à la date d''archivage.',
  `e_archive` date NOT NULL COMMENT 'La date d''archivage de l''évènement.',
  `e_statut` varchar(50) NOT NULL COMMENT 'Le statut actuel de l''évènement.\r\nEn cours, terminé, archivé ou supprimé.',
  `e_proprio` varchar(50) NOT NULL COMMENT 'Le mail du responsable de l''évènement. Clé étrangère sur la table utilisateur.',
  `e_ville` int(5) NOT NULL COMMENT 'La ville où se déroule l''évènement. Clé étrangère sur la table ville.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `modif_temp`
--

CREATE TABLE `modif_temp` (
  `m_id` int(5) NOT NULL COMMENT 'L''ID de la modification.\r\nClé primaire de la table. Cette valeur s''auto-incrémente.',
  `m_objet` varchar(50) NOT NULL COMMENT 'Le nom du besoin.',
  `m_desc` varchar(500) DEFAULT NULL COMMENT 'La description du besoin.\r\nAttribut facultatif.',
  `m_nombre` int(5) DEFAULT NULL COMMENT 'Le nombre d''objets dont il est question dans le besoin.',
  `m_notif` int(5) NOT NULL COMMENT 'L''ID de la notification à laquelle se rattache la modification.\r\nClé étrangère sur la table notification.',
  `n_besoin` int(5) NOT NULL COMMENT 'L''ID du besoin auquel se rattache la modification.\r\nClé étrangère sur la table besoin.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `n_id` int(5) NOT NULL COMMENT 'L''ID de la notification. Clé primaire de la table. Cette valeur s''autoincrémente.',
  `n_objet` varchar(50) NOT NULL COMMENT 'L''objet de la notification.',
  `n_contenu` varchar(500) NOT NULL COMMENT 'Le message de la notification.',
  `n_statut` varchar(50) NOT NULL COMMENT 'Le statut de la notification.\r\nLue, non lue, supprimée.',
  `n_type` varchar(50) NOT NULL COMMENT 'Le type de la notification.\r\nBesoin, invitation, évènement.',
  `n_expediteur` varchar(50) NOT NULL COMMENT 'L''email de l''utilisateur qui envoie la notification.\r\nClé étrangère sur la table utilisateur.',
  `n_destinataire` varchar(50) NOT NULL COMMENT 'L''email de l''utilisateur qui reçoit la notification.\r\nClé étrangère sur la table utilisateur.',
  `n_event` int(5) NOT NULL COMMENT 'L''évènement qui concerne la notification.\r\nClé étrangère sur la table evenement.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `participe`
--

CREATE TABLE `participe` (
  `p_user` varchar(50) NOT NULL COMMENT 'L''utilisateur qui participe à l''évènement.\r\nComposante de la clé primaire. Clé étrangère sur la table utilisateur.',
  `p_event` int(5) NOT NULL COMMENT 'L''évènement auquel participe un utilisateur. Composante de la clé primaire.\r\nClé étrangère sur la table evenement.',
  `p_besoin` int(5) NOT NULL COMMENT 'Le besoin auquel participe un utilisateur.\r\nClé étrangère sur la table besoin.\r\nAttribut facultatif.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `souhaite`
--

CREATE TABLE `souhaite` (
  `s_notif` int(5) NOT NULL COMMENT 'La notification liée au souhait d''un utilisateur.\r\nComposante de la clé primaire. Clé étrangère sur la table notification.',
  `s_event` int(5) NOT NULL COMMENT 'L''évènement lié au souhait d''un utilisateur.\r\nComposante de la clé primaire. Clé étrangère sur la table evenement.',
  `s_besoin` int(5) NOT NULL COMMENT 'Le besoin lié au souhait d''un utilisateur.\r\nClé étrangère sur la table besoin.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `u_mail` varchar(50) NOT NULL COMMENT 'L''email de l''utilisateur. Clé primaire de la table.',
  `u_mdp` varchar(200) NOT NULL COMMENT 'Le mot de passe de l''utilisateur. Doit être sauvegardé de manière sécurisée.',
  `u_nom` varchar(50) NOT NULL COMMENT 'Le nom de l''utilisateur.',
  `u_prenom` varchar(50) NOT NULL COMMENT 'Le prénom de l''utilisateur.',
  `u_naissance` date NOT NULL COMMENT 'La date de naissance de l''utilisateur. Attribut facultatif.',
  `u_tel` int(10) NOT NULL COMMENT 'Le numéro de téléphone de l''utilisateur. Attribut facultatif.',
  `u_photo` varchar(50) DEFAULT NULL COMMENT 'La photo de l''utilisateur. Attribut Facultatif.',
  `u_notif_mail` tinyint(4) NOT NULL COMMENT 'Un booléen qui représente le choix de l''utilisateur de recevoir ou non les notifications par mail.',
  `u_statut` varchar(50) NOT NULL COMMENT 'Le statut de l''utilisateur.\r\nSupprimé, administrateur ou simple utilisateur.',
  `u_ville` int(5) NOT NULL COMMENT 'L''ID de la ville de l''utilisateur.\r\nClé étrangère sur la table ville.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

CREATE TABLE `ville` (
  `v_id` int(5) NOT NULL COMMENT 'L''ID de la ville.\r\nClé primaire de la table.\r\nCette valeur s''auto-incrémente.',
  `v_nom` varchar(50) NOT NULL COMMENT 'Le nom de la ville.',
  `v_dep` varchar(50) NOT NULL COMMENT 'Le département de la ville.',
  `v_cope_postal` int(5) NOT NULL COMMENT 'Le code postal de la ville.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `besoin`
--
ALTER TABLE `besoin`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `b_event` (`b_event`);

--
-- Indexes for table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`e_id`),
  ADD KEY `e_ville` (`e_ville`),
  ADD KEY `e_proprio` (`e_proprio`);

--
-- Indexes for table `modif_temp`
--
ALTER TABLE `modif_temp`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `m_notif` (`m_notif`),
  ADD KEY `n_besoin` (`n_besoin`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`n_id`),
  ADD KEY `n_expediteur` (`n_expediteur`),
  ADD KEY `n_destinataire` (`n_destinataire`),
  ADD KEY `n_event` (`n_event`);

--
-- Indexes for table `participe`
--
ALTER TABLE `participe`
  ADD PRIMARY KEY (`p_user`,`p_event`),
  ADD KEY `p_user` (`p_user`),
  ADD KEY `p_event` (`p_event`),
  ADD KEY `p_besoin` (`p_besoin`);

--
-- Indexes for table `souhaite`
--
ALTER TABLE `souhaite`
  ADD PRIMARY KEY (`s_notif`,`s_event`),
  ADD KEY `s_notif` (`s_notif`),
  ADD KEY `s_event` (`s_event`),
  ADD KEY `s_besoin` (`s_besoin`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`u_mail`),
  ADD KEY `u_ville` (`u_ville`);

--
-- Indexes for table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `besoin`
--
ALTER TABLE `besoin`
  MODIFY `b_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'L''ID du besoin.\r\nClé primaire de la table.\r\nCette valeur s''auto-incrémente.';

--
-- AUTO_INCREMENT for table `evenement`
--
ALTER TABLE `evenement`
  MODIFY `e_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'L''ID de l''évènement. Clé primaire de la table. Cette valeur s''auto-incrémente. ';

--
-- AUTO_INCREMENT for table `modif_temp`
--
ALTER TABLE `modif_temp`
  MODIFY `m_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'L''ID de la modification.\r\nClé primaire de la table. Cette valeur s''auto-incrémente.';

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `n_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'L''ID de la notification. Clé primaire de la table. Cette valeur s''autoincrémente.';

--
-- AUTO_INCREMENT for table `ville`
--
ALTER TABLE `ville`
  MODIFY `v_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'L''ID de la ville.\r\nClé primaire de la table.\r\nCette valeur s''auto-incrémente.';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `besoin`
--
ALTER TABLE `besoin`
  ADD CONSTRAINT `besoin_ibfk_1` FOREIGN KEY (`b_event`) REFERENCES `evenement` (`e_id`);

--
-- Constraints for table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`e_ville`) REFERENCES `ville` (`v_id`),
  ADD CONSTRAINT `evenement_ibfk_2` FOREIGN KEY (`e_proprio`) REFERENCES `utilisateur` (`u_mail`);

--
-- Constraints for table `modif_temp`
--
ALTER TABLE `modif_temp`
  ADD CONSTRAINT `modif_temp_ibfk_1` FOREIGN KEY (`m_notif`) REFERENCES `notification` (`n_id`),
  ADD CONSTRAINT `modif_temp_ibfk_2` FOREIGN KEY (`n_besoin`) REFERENCES `besoin` (`b_id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`n_expediteur`) REFERENCES `utilisateur` (`u_mail`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`n_destinataire`) REFERENCES `utilisateur` (`u_mail`),
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`n_event`) REFERENCES `evenement` (`e_id`);

--
-- Constraints for table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`p_user`) REFERENCES `utilisateur` (`u_mail`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`p_event`) REFERENCES `evenement` (`e_id`),
  ADD CONSTRAINT `participe_ibfk_3` FOREIGN KEY (`p_besoin`) REFERENCES `besoin` (`b_id`);

--
-- Constraints for table `souhaite`
--
ALTER TABLE `souhaite`
  ADD CONSTRAINT `souhaite_ibfk_1` FOREIGN KEY (`s_notif`) REFERENCES `notification` (`n_id`),
  ADD CONSTRAINT `souhaite_ibfk_2` FOREIGN KEY (`s_event`) REFERENCES `evenement` (`e_id`),
  ADD CONSTRAINT `souhaite_ibfk_3` FOREIGN KEY (`s_besoin`) REFERENCES `besoin` (`b_id`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`u_ville`) REFERENCES `ville` (`v_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
