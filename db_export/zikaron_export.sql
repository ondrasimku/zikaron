-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 20. led 2022, 15:04
-- Verze serveru: 10.4.22-MariaDB
-- Verze PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `zikaron`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `text`
--

CREATE TABLE `text` (
  `id_item` int(11) NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `header` varchar(60) NOT NULL,
  `text` text DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `googleLink` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `text`
--

INSERT INTO `text` (`id_item`, `id_parent`, `header`, `text`, `latitude`, `longitude`, `googleLink`) VALUES
(1, NULL, 'Zikaron a.s.', '<p style=\"text-align: justify;\"><span style=\"font-family: \'Playfair Display\', serif; font-size: 1.2rem;\"><span style=\"color: #e4e6eb;\">Spolek ZIKARON (česky Paměť) se zaměřuje na aktivity připomínající život židovské komunity v Jindřichově Hradci, kulturu, náboženství i současnost židovského národa. </span><span style=\"color: #e4e6eb;\">V září 2018 jsme vzdali úctu rodině Winternitzově. Z pěti sourozenců přežila jen paní Dina. Kterou mnozí znás znali. Čest její památce.</span></span></p>\r\n<p><span style=\"color: #e4e6eb; font-family: \'Segoe UI Historic\', \'Segoe UI\', Helvetica, Arial, sans-serif; font-size: 1.3rem;\"><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"uploads/sukot.jpg\" alt=\"\" width=\"580\" height=\"435\" /></span></p>\r\n<ul>\r\n<li>Položka 1</li>\r\n<li><strong>Položka 2</strong></li>\r\n<li>Položka 3</li>\r\n</ul>\r\n<p style=\"text-align: right;\"><em>Text vpravo</em></p>\r\n<p style=\"text-align: center;\"><span style=\"text-decoration: underline;\">Text uprostřed</span></p>\r\n<p style=\"text-align: left;\"><span style=\"font-size: 2.3rem; font-family: \'arial black\', \'avant garde\';\">Text vlevo</span></p>\r\n<ol>\r\n<li style=\"text-align: left;\">položka 1</li>\r\n<li style=\"text-align: left;\">položka 2</li>\r\n<li style=\"text-align: left;\">položka 3 </li>\r\n</ol>\r\n<p style=\"text-align: left;\"><a href=\"https://www.facebook.com/ZikaronJH/\" target=\"_blank\" rel=\"noopener\">Odkaz</a></p>\r\n<div dir=\"auto\">Emma Baschová pocházela z rodiny významného jindřichohradeckého obchodníka Zikmunda Singera (mimo jiné, ten daroval pozemek na stavbu kostela <a class=\"oajrlxb2 g5ia77u1 qu0x051f esr5mh6w e9989ue4 r7d6kgcz rq0escxv nhd2j8a9 nc684nl6 p7hjln8o kvgmc6g5 cxmmr5t8 oygrvhab hcukyx3x jb3vyjys rz4wbd8a qt6c0cv9 a8nywdso i1ao9s8h esuyzwwr f1sip0of lzcic4wl gpro0wi8 q66pz984 b1v8xokw\" tabindex=\"0\" role=\"link\" href=\"https://www.facebook.com/Evangelicka.cirkev.JH/?__cft__[0]=AZWeApzkBz379ML5fP93IRSbskfNcGJMwtUh6iVUHgOsb8WfUWWhoPi_CikmXQePzYKhcm0uLBIpowvweTV38m99QeFjZKNKQFYCDV-pPt42IUid-3DQ3PBOy4iKLLMxTQT7a15UWmGA7EPlODtrxWDh&amp;__tn__=kK-R\"><span class=\"nc684nl6\">Evangelická církev v Jindřichově Hradci</span></a> ). Se svým manželem se vrátili z Vídně v r.1937 zpět do JH. Robert Basch byl zatčen 1941 a následně v KT Auschwitz umírá. Emma s dcerkou Tilly je odvezena v r. 1942 do Terezína a následně do Lublinu...</div>\r\n<div dir=\"auto\">Přeživší Egon Singer si přál, aby dům,do kterého se již nevrátili, sloužil dětem. A tak je tam stále MŠ.</div>', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$X0FtfIV/Fy2KCmC07ZMryuEyEsoXlly9kGfJNCXHrG1jvtcqbBMui');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `text`
--
ALTER TABLE `text`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
