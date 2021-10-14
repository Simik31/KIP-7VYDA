-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 19. lis 2020, 09:56
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
-- Databáze: `test2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `countries`
--

CREATE TABLE `countries` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Česká republika'),
(2, 'Slovenská republika'),
(3, 'Polsko');

-- --------------------------------------------------------

--
-- Struktura tabulky `regions`
--

CREATE TABLE `regions` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `regions`
--

INSERT INTO `regions` (`id`, `name`) VALUES
(1, 'Hlavní město Praha'),
(2, 'Středočeský'),
(3, 'Liberecký'),
(4, 'Ústecký'),
(5, 'Karlovarský'),
(6, 'Plzeňský'),
(7, 'Jihočeský'),
(8, 'Pardubický'),
(9, 'Královéhradecký'),
(10, 'Vysočina'),
(11, 'Jihomoravský'),
(12, 'Olomoucký'),
(13, 'Moravskoslezský'),
(14, 'Zlínský');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `street` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `zip` int(5) NOT NULL,
  `region_id` int(10) NOT NULL,
  `country_id` int(10) NOT NULL,
  `sex` set('male','female') COLLATE utf8_czech_ci NOT NULL,
  `note` mediumtext COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `street`, `city`, `zip`, `region_id`, `country_id`, `sex`, `note`) VALUES
(2, 'Vilém', 'Trojan', 'vilem.trojan@osu.cz', '', 'Olomoucká 18', 'Praha', 22333, 1, 1, 'male', 'poznámka 2'),
(3, 'Pavla', 'Malá', 'pavla.mala@osu.cz', '', 'Bráfova 10', 'Ostrava', 33444, 13, 1, 'female', 'poznámka 3'),
(4, 'Karolína', 'Nováková', 'karolina.novakova@osu.cz', '', 'Olomoucká 10', 'Praha', 22333, 1, 1, 'female', 'poznámka 4'),
(5, 'Pavel', 'Nový', 'pavel.novy@osu.cz', '', 'Bráfova 15', 'Ostrava', 33444, 13, 1, 'male', 'poznámka 5'),
(6, 'Monika', 'Javorová', 'monika.javorova@osu.cz', '', 'Brněnská 34', 'Praha', 22333, 1, 1, 'female', 'poznámka 6'),
(7, 'Marek', 'Hardt', 'marek.hardt@osu.cz', '', 'Nádražní 32', 'Brno', 11122, 11, 1, 'male', 'poznámka 7'),
(8, 'Irena', 'Trojanová', 'irena.trojanova@osu.cz', '', 'Ostravská 16', 'Brno', 11122, 11, 1, 'female', 'poznámka 8'),
(9, 'Hynek', 'Gregor', 'hynek.gregor@osu.cz', '', 'Pražská 56', 'Ostrava', 33444, 13, 1, 'male', 'poznámka 9'),
(10, 'Hana', 'Fredonová', 'hana.fredonova@osu.cz', '', 'Ostravská 159', 'Brno', 11222, 11, 1, 'female', 'poznámka 10'),
(11, 'Administrátor', 'Systému', 'admin@osu.cz', '$2y$10$iYA/YqqSKzFRW.UQBfj0N.QnVoeQi7oC95cnSe9boi7xoCc3AoTda', 'Bráfova 14', 'Ostrava', 33444, 13, 1, 'male', 'poznámka 11');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `region_id` (`region_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
