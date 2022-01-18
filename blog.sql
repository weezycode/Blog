-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 17 jan. 2022 à 22:53
-- Version du serveur : 10.4.19-MariaDB
-- Version de PHP : 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_content` text NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_up` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `id_author`, `title`, `short_content`, `content`, `date_created`, `date_up`) VALUES
(2, 2, '5 paragraphes, 137 mots', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit ', '\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam id erat metus. Phasellus ac tincidunt orci, in vulputate elit. Donec et ligula dapibus, porttitor diam eget, mollis diam. Curabitur feugiat justo at arcu elementum rhoncus vel a dolor. Nunc rutrum ipsum in nisi convallis, nec interdum turpis lacinia. Vestibulum vitae lacinia nulla. Duis viverra ex enim, eget mattis diam tristique sed. Morbi eu augue eu mi imperdiet consequat. Donec mollis, odio vitae ultrices tristique, libero lectus ornare neque, nec consectetur est metus in elit. Morbi rutrum pellentesque quam, nec pellentesque turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris maximus libero at ipsum finibus, a volutpat leo ullamcorper. Proin purus neque, sagittis a nisl id, convallis malesuada urna. Sed facilisis massa a lorem euismod, at semper nunc tempor. Cras dapibus, sem ut sodales volutpat, diam ligula efficitur dui, vel sollicitudin augue orci eget lorem.\n\nSuspendisse potenti. Suspendisse fermentum, urna ac suscipit feugiat, massa augue scelerisque augue, sed rutrum metus neque ac augue. Suspendisse quis orci finibus, dapibus urna eu, dignissim ante. Nunc dapibus, sem quis bibendum maximus, diam justo placerat arcu, id pulvinar lorem enim mollis purus. Fusce posuere non urna ac ultrices. In lobortis bibendum egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet pretium libero, luctus ullamcorper velit accumsan sed. Suspendisse nibh nulla, luctus ac mollis in, tincidunt vel tortor.', '2021-12-22 01:47:08', '2021-12-22 01:47:08'),
(5, 2, 'Google et Facebook condamnés', 'La France inflige une amende de 210 millions d\'euros ', 'La Commission nationale de l\'informatique et des libertés (CNIL), l\'organe de surveillance français de la protection des données, a giflé Facebook (maintenant Meta Platforms) et Google avec des amendes de 150 millions d\'euros (170 millions de dollars) et 60 millions d\'euros (68 millions de dollars) pour violation de l\'UE Règles de confidentialité en omettant de fournir aux utilisateurs une option simple pour rejeter la technologie de suivi des cookies.\r\n\r\n\"Les sites facebook.Com, google.Fr et youtube.Com proposent un bouton permettant à l\'utilisateur d\'accepter immédiatement les cookies\", précise l\'autorité. \"Cependant, ils n\'apportent pas de solution équivalente (bouton ou autre) permettant à l\'internaute de refuser facilement le dépôt de ces cookies.\"\r\n\r\nFacebook a déclaré à TechCrunch qu\'il examinait la décision, tandis que Google a déclaré qu\'il s\'efforçait de modifier ses pratiques en réponse aux amendes de la CNIL.\r\n\r\nLes cookies HTTP sont de petits morceaux de données créés lorsqu\'un utilisateur navigue sur un site Web et placés sur l\'ordinateur de l\'utilisateur ou un autre appareil par le navigateur Web de l\'utilisateur pour suivre l\'activité en ligne sur le Web et stocker des informations sur les sessions de navigation, y compris les connexions et les détails saisis dans champs de formulaire tels que les noms et les adresses.', '2022-01-13 02:37:57', '2022-01-13 02:37:57');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_comment` datetime NOT NULL,
  `display_status` enum('pending','granted','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `id_article`, `content`, `date_comment`, `display_status`) VALUES
(7, 2, 5, 'Une miette.', '2022-01-14 03:25:28', 'pending'),
(9, 7, 5, 'Ah oui quand-même', '2022-01-15 15:11:42', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `status` enum('member','admin','superadmin','') NOT NULL DEFAULT 'member',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `passwd`, `status`, `date_created`) VALUES
(2, 'weezy', 'polo@pop.com', '4212', 'admin', '2021-12-22 01:39:25'),
(3, 'jean', 'jean@pol.fr', '4452', 'member', '2021-12-22 01:40:27'),
(7, 'momo', 'momo@gmail.com', '1234', 'superadmin', '2022-01-15 15:09:08');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_articles_fk` (`id_author`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_comments_fk` (`id_user`),
  ADD KEY `articles_comments_fk` (`id_article`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `users_articles_fk` FOREIGN KEY (`id_author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `articles_comments_fk` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comments_fk` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
