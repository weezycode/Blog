-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 déc. 2021 à 03:36
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
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_content` text NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_up` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `id_author`, `title`, `short_content`, `content`, `date_created`, `date_up`) VALUES
(1, 1, 'Lorem Ipseum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque augue arcu, auctor at sapien venenatis, congue viverra arcu. Nullam venenatis ligula tincidunt sem interdum auctor. Aenean eu porttitor arcu. Etiam vel urna dui. Proin efficitur mollis ipsum. Vivamus viverra ac felis non vehicula. Nulla non diam eget erat accumsan rutrum et non leo. Proin congue orci sit amet eros luctus pellentesque. Nam malesuada odio justo. Pellentesque lacinia, ligula pellentesque euismod faucibus, ante lacus sagittis mi, sit amet malesuada eros urna a ex. Ut ut diam dignissim odio tempor tincidunt. Mauris hendrerit mauris mauris, nec mattis odio consectetur vel. In hac habitasse platea dictumst. Curabitur quis mauris augue.\r\n\r\nMorbi lobortis libero in ipsum efficitur, ac viverra ex dignissim. Mauris aliquam scelerisque mi eget iaculis. Sed nec quam aliquam purus tincidunt tempor id vitae purus. Sed bibendum odio sagittis, efficitur enim sed, aliquet diam. Maecenas urna augue, condimentum ullamcorper ullamcorper non, mattis sed purus. Mauris quis ligula nunc. Ut et aliquam sapien. Phasellus mi arcu, interdum vitae rutrum eu, aliquam eget mauris. Fusce a lectus feugiat, ultricies massa vitae, luctus purus. Nulla arcu libero, placerat sit amet metus in, lobortis ultricies felis. Nam tempus ante ut lacus dignissim rutrum. Fusce dapibus a purus ac lobortis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo urna sit amet magna auctor, vel volutpat turpis semper.', '2021-12-22 01:45:34', '2021-12-22 01:45:34'),
(2, 2, '5 paragraphes, 137 mots, 1026 caractères de Lorem Ipsum généré', '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"\r\n', '\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam id erat metus. Phasellus ac tincidunt orci, in vulputate elit. Donec et ligula dapibus, porttitor diam eget, mollis diam. Curabitur feugiat justo at arcu elementum rhoncus vel a dolor. Nunc rutrum ipsum in nisi convallis, nec interdum turpis lacinia. Vestibulum vitae lacinia nulla. Duis viverra ex enim, eget mattis diam tristique sed. Morbi eu augue eu mi imperdiet consequat. Donec mollis, odio vitae ultrices tristique, libero lectus ornare neque, nec consectetur est metus in elit. Morbi rutrum pellentesque quam, nec pellentesque turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris maximus libero at ipsum finibus, a volutpat leo ullamcorper. Proin purus neque, sagittis a nisl id, convallis malesuada urna. Sed facilisis massa a lorem euismod, at semper nunc tempor. Cras dapibus, sem ut sodales volutpat, diam ligula efficitur dui, vel sollicitudin augue orci eget lorem.\r\n\r\nSuspendisse potenti. Suspendisse fermentum, urna ac suscipit feugiat, massa augue scelerisque augue, sed rutrum metus neque ac augue. Suspendisse quis orci finibus, dapibus urna eu, dignissim ante. Nunc dapibus, sem quis bibendum maximus, diam justo placerat arcu, id pulvinar lorem enim mollis purus. Fusce posuere non urna ac ultrices. In lobortis bibendum egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur imperdiet pretium libero, luctus ullamcorper velit accumsan sed. Suspendisse nibh nulla, luctus ac mollis in, tincidunt vel tortor.', '2021-12-22 01:47:08', '2021-12-22 01:47:08');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `display_status` enum('pending','granted','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `id_user`, `id_article`, `content`, `date_created`, `display_status`) VALUES
(1, 3, 1, 'excellent', '2021-12-22 01:49:08', 'granted');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `status` enum('member','admin','superadmin','') NOT NULL DEFAULT 'member',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `passwd`, `status`, `date_created`) VALUES
(1, 'momo', 'momo@mo.fr', '1234\r\n', 'superadmin', '2021-12-22 01:34:06'),
(2, 'weezy', 'polo@pop.com', '4212', 'admin', '2021-12-22 01:39:25'),
(3, 'jean', 'jean@pol.fr', '4452', 'member', '2021-12-22 01:40:27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_articles_fk` (`id_author`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_comments_fk` (`id_user`),
  ADD KEY `articles_comments_fk` (`id_article`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `users_articles_fk` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `articles_comments_fk` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_comments_fk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
