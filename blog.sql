-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 31 jan. 2022 à 12:12
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
  `date_up` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `id_author`, `title`, `short_content`, `content`, `date_created`, `date_up`) VALUES
(2, 13, 'Raspberry Pi c\'est quoi ? ', 'Le Raspberry Pi est un nano-ordinateur monocarte à processeur ARM de la taille d\'une carte de crédit conçu par des professeurs du département informatique de l\'université de Cambridge dans le cadre de la fondation Raspberry Pi.', 'Le Raspberry Pi fut créé afin de démocratiser l\'accès aux ordinateurs et au digital making (terme anglophone désignant à la fois la capacité de résolution de problèmes et les compétences techniques et informatiques). Cette démocratisation est possible en raison du coût réduit du Raspberry Pi, mais aussi grâce aux logiciels libres. Le Raspberry Pi permet l\'exécution de plusieurs variantes du système d\'exploitation libre GNU/Linux, notamment Debian, et des logiciels compatibles. Il fonctionne également avec le système d\'exploitation Microsoft Windows : Windows 10 IoT Core, Windows 10 on ARM (pour l\'instant[Quand ?] relativement instable), celui de Google Android Pi et même une version de l\'OS/MVT d\'IBM accompagnée du système APL3602.\r\n\r\nIl est initialement fourni nu, c\'est-à-dire la carte mère seule, sans boîtier, câble d\'alimentation, clavier, souris ni écran, dans l\'objectif de diminuer les coûts et de permettre l\'utilisation de matériel de récupération. Néanmoins des « kits » regroupant le « tout en un » sont disponibles sur le web à partir de quelques dizaines d\'euros seulement.\r\n\r\nSon prix de vente était estimé à 25 $ américains, soit 19,09 €, début mai 2011. Les premiers exemplaires ont été mis en vente le 29 février 2012 pour environ 25 €. En septembre 2016, plus de dix millions de Raspberry Pi ont été vendus. De multiples versions ont été développées ; les dernières sont vendues un peu plus de 25 € pour le B+, à un peu plus de 30 € pour le Pi 2 (2015), un peu plus de 35 € pour le Pi 3 (2016), 5 € pour le Raspberry Pi Zero (2016), 10 € pour le Raspberry Pi Zero W (2017), 15 € pour le Raspberry Pi Zero WH (2018) et 40 € pour le Raspberry Pi 4 (varie selon la quantité de mémoire).\r\nAlors ça vous tente ? <source wikipédia>', '2021-12-22 01:47:08', '2022-01-30 02:03:03'),
(5, 2, 'Google et FaceBook prennent une amende ', 'La France inflige une amende de 250 millions d\'euros', 'La Cour des comptes épingle la désastreuse gestion de la rénovation des logiciels, malgré un budget de 500 millions d’euros.\r\n\r\nUn fiasco, une gabegie, une faute collective, mais pas de responsable. La Cour des comptes a remis mercredi au Sénat un audit accablant sur la transformation numérique de la justice lors du dernier quinquennat. Emmanuel Macron voulait que les ministères soient autant de start-up d’État. Pour cela, il a accordé des budgets dignes des licornes numériques: un demi-milliard a été offert à la Place Vendôme pour faire entrer la justice millénaire dans l’ère du métavers. Mais cette somme n’a pas permis à la Chancellerie et à son bras armé, le secrétariat général, de se moderniser comme attendu.\r\nÀ lire aussiLe grand bazar de l’informatique judiciaire', '2022-01-13 02:37:57', '2022-01-30 01:45:42'),
(7, 13, 'Qu\'est ce que c\'est le PHP ?', 'PHP est un langage de script utilisé le plus souvent côté serveur : dans cette architecture, le serveur interprète le code PHP des pages web demandées et génère du code (HTML, XHTML, CSS par exemple) et des données (JPEG, GIF, PNG par exemple) pouvant être interprétés et rendus par un navigateur web. PHP peut également générer d\'autres formats comme le WML, le SVG et le PDF.', 'Le langage PHP a été créé en 1994 par Rasmus Lerdorf pour son site web. C\'était à l\'origine une bibliothèque logicielle en C34 dont il se servait pour conserver une trace des visiteurs qui venaient consulter son CV. Au fur et à mesure qu\'il ajoutait de nouvelles fonctionnalités, Rasmus a transformé la bibliothèque en une implémentation capable de communiquer avec des bases de données et de créer des applications dynamiques et simples pour le Web. Rasmus a alors décidé, en 1995, de publier son code, pour que tout le monde puisse l\'utiliser et en profiter35. PHP s\'appelait alors PHP/FI (pour Personal Home Page Tools/Form Interpreter). En 1997, deux étudiants, Andi Gutmans et Zeev Suraski, ont redéveloppé le cœur de PHP/FI. Ce travail a abouti un an plus tard à la version 3 de PHP, devenu alors PHP: Hypertext Preprocessor. Peu de temps après, Andi Gutmans et Zeev Suraski ont commencé la réécriture du moteur interne de PHP. C’est ce nouveau moteur, appelé Zend Engine — le mot Zend est la contraction de Zeev et Andi — qui a servi de base à la version 4 de PHP.\r\nEnfin en 2010, PHP est le langage dont les logiciels open source sont les plus utilisés dans les entreprises, avec 57 % de taux de pénétration.', '2022-01-29 20:03:48', '2022-01-30 16:16:02'),
(8, 2, 'Programmation orientée objet c\'est quoi ?', 'La programmation orientée objet (POO), ou programmation par objet, est un paradigme de programmation informatique. Elle consiste en la définition et l\'interaction de briques logicielles appelées objets ; un objet représente un concept, une idée ou toute entité du monde physique, comme une voiture, une personne ou encore une page d\'un livre.', 'Il possède une structure interne et un comportement, et il sait interagir avec ses pairs. Il s\'agit donc de représenter ces objets et leurs relations ; l\'interaction entre les objets via leurs relations permet de concevoir et réaliser les fonctionnalités attendues, de mieux résoudre le ou les problèmes. Dès lors, l\'étape de modélisation revêt une importance majeure et nécessaire pour la POO. C\'est elle qui permet de transcrire les éléments du réel sous forme virtuelle.\r\n\r\nLa programmation par objet consiste à utiliser des techniques de programmation pour mettre en œuvre une conception basée sur les objets. Celle-ci peut être élaborée en utilisant des méthodologies de développement logiciel objet, dont la plus connue est le processus unifié (« Unified Software Development Process » en anglais), et exprimée à l\'aide de langages de modélisation tels que le Unified Modeling Language (UML).\r\n\r\n\r\nsouce:Wikipedia', '2022-01-30 00:21:51', '2022-01-30 01:39:42'),
(9, 13, 'C\'est quoi  un Arduino ?', 'Un module Arduino est généralement construit autour d\'un microcontrôleur Atmel AVR (ATmega328, ATmega32u4 ou ATmega2560 pour les versions récentes, ATmega168, ATmega1280 ou ATmega8 pour les plus anciennes), et de composants complémentaires qui facilitent la programmation et l\'interfaçage avec d\'autres circuits. Chaque module possède au moins un régulateur linéaire 5 V et un oscillateur à quartz 16 MHz (ou un résonateur céramique dans certains modèles).', 'Le microcontrôleur est préprogrammé avec un bootloader de façon qu\'un programmateur dédié ne soit pas nécessaire.\r\n\r\nLes modules sont programmés avec une connexion série TTL, mais les connexions permettant cette programmation diffèrent selon les modèles. Les premiers Arduino possédaient un port série RS-232, puis l\'USB est apparu sur les modèles Diecimila, tandis que certains modules destinés à une utilisation portable comme le Lillypad ou le Pro-mini se sont affranchis de l\'interface de programmation, relocalisée sur un module USB-série dédié (sous forme de carte ou de câble), cela permettait aussi de réduire leur coût, le convertisseur USB-Série TTL (un FTDI232RL de FTDI) coûtant assez cher.\r\n\r\nL\'Arduino utilise la plupart des entrées/sorties du microcontrôleur pour l\'interfaçage avec les autres circuits. Le modèle Diecimila par exemple, possède quatorze entrées/sorties numériques, dont six peuvent produire des signaux PWM, et 6 entrées analogiques. Les connexions sont établies au travers de connecteurs femelles HE14 situés sur le dessus de la carte, les modules d\'extension venant s\'empiler sur l\'Arduino. Plusieurs sortes d\'extensions sont disponibles dans le commerce.\r\n\r\nD\'autres cartes comme l\'Arduino Nano ou le Pro micro utilisent des connecteurs mâles, permettant de les disposer sur une platine d\'expérimentation.\r\n\r\nLa société STMicroelectronics a également travaillé avec Arduino, sur des cartes compatibles. Les cartes STM32 Nucleo, basées sur les processeurs STM32, utilisant l\'architecture ARM plutôt que l\'architecture Harvard des Atmel AVR. Ces cartes comportent un processeur plus puissant, ARM Cortex-M 32 bits, de M0+ à 32 MHz ou M0 à 48 MHz jusqu\'au M4 à 100 MHz, comportant des instructions DSP4 et un processeur graphique Chrom-ART de STMicroelectronics. <souce wikipédia>', '2022-01-30 01:54:24', '2022-01-30 01:57:23'),
(10, 7, 'Parlons des drones quadrirotors', 'Un drone quadrirotor est un drone (appareil sans pilote embarqué), reprenant le principe des aéronefs quadrirotors, et pouvant fonctionner de manière autonome, ou piloté par un pilote au sol. Il en existe de plein de types et tailles, adaptés à différentes utilisations. Ce type de drone peut être utilisé en essaim de drones.', 'Il existe différents types de drones quadrirotors adaptés à différents usages. Usage sportif (course, freestyle), de prise de vue (aux commandes plus souples, pour une prise de vue plus stable), ou encore affectés à des tâches de sécurité, de cartographie, d\'évaluation des stocks, ou encore de transport. Certains peuvent convenir à différentes de ses tâches, selon le matériel qu\'ils comportent ou qu\'on y ajoute, ou encore, selon les programmes de la carte de vol.\r\nSur les drones de course (en anglais, FPV Quadcopter), un domaine plus réservé au hackers, où les drones sont modifiés pour les besoins des utilisateurs, les vitesses peuvent passer de 0 à 100 km/h en 1 seconde et les stabilisateurs sont souvent coupés afin d\'augmenter la manœuvrabilité. Des Visiocasques sont alors utilisés pour le pilotage en immersion (ou FPV dans le jargon), par opposition au vol à vue dans ce domaine, décrivant un vol sans visiocasque en utilisant la commande et regardant le drone évoluer (à ne pas confondre avec le vol à vue en aéronautique qui s\'oppose au vol aux instruments), et des systèmes de transmissions plus rapides, et permettant les défauts d\'affichage (bruit, basse résolution) afin d\'éviter les latences, sont utilisés.\r\nLe contrôleur de vol est connecté ou comporte des éléments permettant différents types de télétransmissions selon les modèles de drones. Dans le cas des jouets d\'entrée de gamme, le bluetooth est utilisé pour les commandes (portée très faible, jusqu\'à 60 m en LTE), les gammes suivantes utilisent du Wi-Fi pour la transmission des commandes et de la vidéo. Pour les plus haut de gamme, des fréquences radio (parfois couplées avec bluetooth et Wi-Fi), sont utilisées pour le contrôle, soit FM en 41 MHz, soit, pour les plus grandes portées (plusieurs kilomètres), en 2,4 GHz, souvent programmables. Dna les télécommandes FM, le firmware libre OpenTX est souvent utilisé.\r\nLe module VTX (en anglais : Video Transmitter) est chargé d\'émettre la vidéo en temps-réel au casque de vision. Il peut émettre dans les fréquences de 1,2 GHz, 2,4 Ghz ou 5,8 GHz, la dernière fréquence étant autorisée dans de nombreux pays3. Ils émettent généralement de base en 25 mW dans la fréquence des 5,8 Ghz. Il est possible d\'augmenter la puissance en 200 mW, mais la réglementation locale peut l\'interdire. En France, par exemple, la limite est à 25 mW. Le type d\'antenne joue un rôle important dans la transmission, tant sur l\'appareil que sur le poste de réception. Maintenant avec plusieurs modifications du réseau Wi-Fi et l\'antenne la limite monte à 50 mW. La puissance est de 300 mW et la fréquence est 6,2 GHz.', '2022-01-30 02:23:14', '2022-01-30 02:24:45');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `content` text NOT NULL,
  `display_status` enum('pending','granted','rejected','') NOT NULL DEFAULT 'pending',
  `date_comment` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_user`, `id_article`, `content`, `display_status`, `date_comment`) VALUES
(16, 2, 5, 'Joli article !', 'granted', '2022-01-29 02:29:10'),
(17, 13, 2, 'Personnes n\'est là ?', 'granted', '2022-01-29 02:41:43'),
(18, 13, 5, '@weezy oui c\'est pas mal ', 'granted', '2022-01-29 02:45:02'),
(19, 13, 7, 'il parrait que PHP perd sa place !', 'granted', '2022-01-30 16:11:17'),
(20, 13, 10, 'Ha oui j\'en ai un FPV c\'est amusant. ', 'granted', '2022-01-30 16:12:23'),
(21, 2, 8, 'Il parrait bien', 'granted', '2022-01-30 22:06:19'),
(22, 2, 9, 'Sincèrement le micro pro fait l\'affaire avec sa petite taille.', 'granted', '2022-01-30 22:09:43'),
(23, 7, 9, 'Mais @weezy il faut quand même un FTDI232RL  pour le bootloader .', 'granted', '2022-01-30 22:11:22');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `passwd`, `status`, `date_created`) VALUES
(2, 'weezy', 'polo@pop.com', '$2y$10$xXWtGHgeIaFFIuGPLGhQWuPwNnsuduQ7MZEWjrfZoEc35lz8hHyrW', 'admin', '2021-12-22 01:39:25'),
(7, 'momo', 'momo@gmail.com', '$2y$10$xXWtGHgeIaFFIuGPLGhQWuPwNnsuduQ7MZEWjrfZoEc35lz8hHyrW', 'superadmin', '2022-01-15 15:09:08'),
(13, 'marvin', 'mar@marv.fr', '$2y$10$xXWtGHgeIaFFIuGPLGhQWuPwNnsuduQ7MZEWjrfZoEc35lz8hHyrW', 'admin', '2022-01-29 01:42:10'),
(17, 'Bravo', 'bravo@b.fr', '$2y$10$brH4sAAsNo9jsuG4FsGzEOteYNsbjqeVVGCaF9.c042rCSgl7j47a', 'member', '2022-01-30 22:27:47'),
(18, 'Charlie', 'charlie@c.fr', '$2y$10$VoRhKXXhvEnIC2RbrGk9CeBlOj63CJ1pJtyYI4EMrQf4sIGbxzswy', 'member', '2022-01-30 22:28:21'),
(19, 'Delta', 'delta@d.fr', '$2y$10$HFUT5q2kxM/cCSFfAN.EQ..BkRLMBpWv4uuQnn1I0DpciqFDpc2c6', 'member', '2022-01-30 22:28:49');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_author` (`id_author`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
