-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 19. lis 2020, 09:54
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `test`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price_no_vat_item` int(10) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_finished` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `quantity`, `price_no_vat_item`, `date_created`, `date_finished`) VALUES
(1, 1, 3, 20000, '2019-11-24 06:24:34', '2019-11-24 18:59:59'),
(2, 1, 4, 20000, '2019-11-24 07:33:52', '2019-11-25 11:41:59'),
(3, 2, 5, 22000, '2019-11-24 08:37:59', '2019-11-26 11:59:00'),
(4, 2, 1, 22000, '2019-11-24 09:44:59', '2019-11-25 17:59:00'),
(5, 2, 4, 22000, '2019-11-24 11:42:59', '2019-11-26 14:47:10'),
(6, 3, 4, 7990, '2019-11-24 08:38:20', '2019-11-24 14:47:54'),
(7, 3, 2, 7990, '2019-11-25 08:37:12', '2019-11-25 17:49:26'),
(8, 4, 1, 9990, '2019-11-24 13:48:55', '2019-11-24 20:48:50'),
(9, 4, 6, 9990, '2019-11-26 09:51:29', '2019-11-26 12:40:12'),
(10, 5, 5, 12990, '2019-11-24 08:41:19', '2019-11-25 08:30:13'),
(11, 5, 3, 12990, '2019-11-24 06:31:10', '2019-11-25 11:46:16'),
(12, 6, 2, 26990, '2019-11-24 10:44:14', '2019-11-24 20:36:15'),
(13, 6, 5, 26990, '2019-11-25 11:52:11', '2019-11-25 20:24:12'),
(14, 6, 1, 26990, '2019-11-24 04:25:39', '2019-11-26 06:40:16');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
