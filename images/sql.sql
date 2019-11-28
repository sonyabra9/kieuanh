-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2019 at 10:20 AM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `facebookapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(20) unsigned NOT NULL,
  `user_id` int(20) unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) unsigned NOT NULL,
  `post_id` int(20) unsigned NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `user_id` int(20) unsigned NOT NULL,
  `uid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_id` int(20) unsigned NOT NULL,
  `success` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(20) unsigned NOT NULL,
  `uid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `user_id`, `uid`, `name`, `token`) VALUES
(1, 1, '158918978677477', 'Chương Nón', 'EAAGV64pBIYABACpdNvaAHmkplIID1vv71F7oZBuZCDZA2WFLB0fobreNFUWR7irSY8AtUgZCHyW9vaOKu0lhjMErd1kw46tw6V8Vp1mawdmWRqLz0nZBFwjyZBuC9ZCrZBpgtiOczpZBXiDG1AuIgXcGVhZBaiAIhjXyGfeMlVg9IZCytHiMqvXYo3h'),
(2, 1, '100368584778353', 'Shop Áo Thun Đẹp', 'EAAGV64pBIYABAMEyfO8ZBW6DjEEiMEHt1hHLNBzqemMVAgg8MoERaZBZAAFhfq1VYG5vtg5KwxvGU43xMocSBpmj9lmwiSrcZCKR7IbAaWZB6cRjKjwAbRQxtSuJZBruTGrXiAqjGpvJPLjKaNKp1xe2RAtRPLgghg7fXf1r64jNerTrEtiX8UTJZBZAWb48smQZD'),
(3, 1, '100789178069065', 'Áo Thun Nam Đẹp', 'EAAGV64pBIYABAABZBpzaMGMAkIJk33nO8ahhpUBoJ9dq9WkXxw6s0YGZAqTSkuHnAZCsgHtck4YT5BiRHZCVSeq5FRsBAiaEAEWgN4JrpwxZCQUrlvPqGSB5AAUWap2ex0NuyGZCMcRw0czyhheq2j4P2FRvItCtMP8U0H6iP3a0uahhrPDrONK45W5YUH2wYZD'),
(4, 1, '101456441334493', 'Áo Thun Nam Coton Đẹp', 'EAAGV64pBIYABANQFdM7E0FD3Dn40vZA5NWcmCHF4B6E8sz1JSs9QtfJbsJ2IpecfMYreTBwFck6IGCUMQdorrrzHetWQn1uqtZCNNl36trrTD0DcbHJQVxZAXBhITtr4lmZACrltGiUMaKoDJ5iZAHh6pZAwSWou8mBJXVUY21MCFLuM810z7yktwxGXYDQ7gZD'),
(5, 1, '103568871119778', 'Áo Thun Đẹp Cho Nam Nữ', 'EAAGV64pBIYABAMyPIT1rNTWs0hK5mjCNq1y6ZBAZBwqEFq8Yp2nJHNxH6h2uDZCtKZA8P66fKmd1vJA8UZAyjzXfs9G8AxVXx0nJua1O5fka1p4SxNGHaWd31IkDwyuhsV3DuGWyd8j8yvWSOBV3KKIZBBbrBIk0kdopns91Dq7zjZALMLLkumbFP09kuUnZCkIZD'),
(6, 1, '104119974397422', 'Áo Thun Đẹp', 'EAAGV64pBIYABAA9G8NKqDkVnGYmmUJhfKrmHAJlUiSnHkQ1vRL791tDqr4qbKQVZBLv4KGI4KMZA3ZBwlvs2tiTOanpZCzg8ya1ybZCCoeZBEBsUu3C7E008GmPLZBTqJMWr4zexrtVdZAiocgzQf4N67O8vDYdZB2ukj2HiZCFmGzIJLkbZAWH6kCv1w8vySopJ9QZD'),
(7, 1, '105563974250995', 'Nón kết nam', 'EAAGV64pBIYABAC7K08533gADZCOqwYn5vzZChDg8hnMEIAwuRYruBpsrSJvgBBKZCgJdNyfR8glq2MNMQwjoAI7h0FmZCJQe3NhwmMOiKVOC5r4azf2aDGAZCkT0ZC1fwRaTdeYBW7k9hUMOiZAoHPkUzc2rPKnGQsqnDAFDFj9pRV10JA6iS7fQxDduXZC8oCMZD'),
(8, 1, '106231434184681', 'Áo Thun Nam', 'EAAGV64pBIYABACAnZBd7tPXZCpHPIA7tboPNi41L810hHZADPZAdYZCtKDZAkluQgZAgiPpcwUvfVXP0yQtTmRVvUvauzJJISKE5XX7v1xqBJAS794jrstFHkpX8MS4eoi00inZByk2PSkoBYtoqPrJYC4FtQTn0ZBrg5qZBk6siE7X41PXb7PPIZBNZAKsksQ69IV0ZD'),
(9, 1, '110939067042329', 'Áo Thun Nam Đẹp Sài Gòn', 'EAAGV64pBIYABAOFVo5wDpJsVJSHtyX0Kncx0uoTq4ZAquOCm7rfCedHV5iNPpWRQbxRVFGxy5lWxZCEgrmfcrpLfu8UEX2eQDfbOvBAZCmRfXJv73oVjESTXWGeyZBQ7BC7sO8rBuCZCJl21NBQQFI9WXPQ2TAxRuPPksLuVHkSY8HLwGWFf3FEoKifhvb3oZD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'tupham', '$2y$10$bf5r42OG.cylMjhKBUDgr.XGeYwxMv/BNcUMhRWXZaiai10huGdS6', '2019-11-13 05:25:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
