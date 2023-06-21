-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2023 at 09:24 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_annuel`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_comment`
--

CREATE TABLE `article_comment` (
  `id_comment` int(255) NOT NULL,
  `commentaire` text NOT NULL,
  `id_commentateur` varchar(255) NOT NULL,
  `id_article` int(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_comment`
--

INSERT INTO `article_comment` (`id_comment`, `commentaire`, `id_commentateur`, `id_article`, `date`) VALUES
(1, 'test', '7', 1, '2023-06-11 18:45:29'),
(2, 'test article 2', '6', 2, '2023-06-11 18:46:44'),
(3, 'réponse au commentaire via phpmyadmin', '1', 2, '2023-06-11 20:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `article_post`
--

CREATE TABLE `article_post` (
  `id_article` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `corps_de_texte` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_post`
--

INSERT INTO `article_post` (`id_article`, `nom`, `prenom`, `titre`, `categorie`, `corps_de_texte`, `image`) VALUES
(1, 'khalifa', 'julien', 'Nutrition #1', 'nutrition', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'image-1686498969.'),
(2, 'khal', 'Jul', 'Actualité #1', 'actualite', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'image-1686499239.png');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` int(10) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contact_commentaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `nom`, `email`, `telephone`, `objet`, `contact_commentaire`) VALUES
(1, 'Khalifa', 'test@contact.fr', 9090909, 'Demande d\'information', 'corps de texte');

-- --------------------------------------------------------

--
-- Table structure for table `forum_thread`
--

CREATE TABLE `forum_thread` (
  `id_thread` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `commentaire_zero` text NOT NULL,
  `date_thread` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum_thread`
--

INSERT INTO `forum_thread` (`id_thread`, `titre`, `commentaire_zero`, `date_thread`) VALUES
(1, 'TITRE 1', 'Lorem Ipsum is simply dummy text of th', '2023-06-15 08:17:34'),
(2, 'TITRE DEUX', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2023-06-15 08:18:12'),
(3, 'TITRE TROIS', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2023-06-15 08:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `forum_thread_comment`
--

CREATE TABLE `forum_thread_comment` (
  `id_forum_comment` int(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `id_commentateur` varchar(255) NOT NULL,
  `id_forum_thread` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forum_thread_comment`
--

INSERT INTO `forum_thread_comment` (`id_forum_comment`, `commentaire`, `id_commentateur`, `id_forum_thread`) VALUES
(1, '\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sexe` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int(120) NOT NULL,
  `role` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `sexe`, `nom`, `prenom`, `age`, `role`, `mdp`, `image`) VALUES
(1, 'newtest@test.com', '', '', '', 0, '', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', ''),
(2, 'test@test.com', '', '', '', 0, '', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', 'uploads/image1686304216.png'),
(3, 'testun@test.com', '', '', '', 0, '', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', 'uploads/image1686304276.png'),
(4, 'test5@test.com', '', '', '', 0, '', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', ''),
(5, 'test6@test.com', '', '', '', 0, '', '37268335dd6931045bdcdf92623ff819a64244b53d0e746d438797349d4da578', ''),
(6, 'testx@test.com', '', '', '', 0, '', '974df8590f7e794e357169c3e3d18655f96396c3b5ff3b3b933441f4104f910a', ''),
(7, 'testi@test.com', '', 'Khalifa', 'Julien', 0, 'admin', '974df8590f7e794e357169c3e3d18655f96396c3b5ff3b3b933441f4104f910a', 'image-1686498215.jpg'),
(8, 'testz@test.com', 'homme', 'Monaco', 'Albert', 23, 'utilisateur', '974df8590f7e794e357169c3e3d18655f96396c3b5ff3b3b933441f4104f910a', 'image-1686509750.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article_comment`
--
ALTER TABLE `article_comment`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indexes for table `article_post`
--
ALTER TABLE `article_post`
  ADD PRIMARY KEY (`id_article`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_thread`
--
ALTER TABLE `forum_thread`
  ADD PRIMARY KEY (`id_thread`);

--
-- Indexes for table `forum_thread_comment`
--
ALTER TABLE `forum_thread_comment`
  ADD PRIMARY KEY (`id_forum_comment`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_comment`
--
ALTER TABLE `article_comment`
  MODIFY `id_comment` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `article_post`
--
ALTER TABLE `article_post`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forum_thread`
--
ALTER TABLE `forum_thread`
  MODIFY `id_thread` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forum_thread_comment`
--
ALTER TABLE `forum_thread_comment`
  MODIFY `id_forum_comment` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
