-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 21, 2024 alle 02:27
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gymbuddy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`idUser`) VALUES
(2);

-- --------------------------------------------------------

--
-- Struttura della tabella `creditcard`
--

CREATE TABLE `creditcard` (
  `idCreditCard` int(11) NOT NULL,
  `idSubscription` int(11) NOT NULL,
  `cvc` int(11) NOT NULL,
  `accountHolder` varchar(255) DEFAULT NULL,
  `cardNumber` varchar(16) DEFAULT NULL,
  `expirationDate` date DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `creditcard`
--

INSERT INTO `creditcard` (`idCreditCard`, `idSubscription`, `cvc`, `accountHolder`, `cardNumber`, `expirationDate`, `idUser`) VALUES
(1, 4, 111, 'antonella', '12312331131', '0000-00-00', 3),
(2, 5, 119, 'silvio', '432423432', '0000-00-00', 3),
(3, 6, 111, 'tiziano', '1231231311', '2024-07-12', 3),
(4, 7, 111, 'antonio rossi', '1313133131', '2024-07-05', 5),
(5, 8, 111, 'laura', '3131313131', '2024-07-05', 3),
(6, 9, 311, 'lorenzo rodorigo', '3323131211', '2024-07-30', 6),
(7, 10, 121, 'mattia', '12312313313', '2024-07-24', 3),
(8, 11, 111, 'paola', '1231313', '2024-07-12', 3),
(9, 12, 111, 'silvio', '43411241', '2024-07-14', 4),
(10, 13, 121, 'matteo', '123131', '2024-07-07', 3),
(11, 14, 111, 'paola', '2313131', '2024-07-14', 3),
(12, 15, 111, 'tttt', '12312312', '2024-07-11', 3),
(13, 16, 111, 'marco', '2312112', '2024-07-07', 3),
(14, 17, 211, 'marzia rossi', '123123123', '2024-02-14', 7),
(15, 18, 111, 'marzia', '1321331', '2024-07-05', 7),
(16, 19, 111, 'marzia neri', '1313123132', '2024-06-15', 7),
(17, 20, 111, '111', '12313133', '2024-07-06', 3),
(18, 21, 111, 'marco neri', '1231331', '2024-07-14', 3),
(19, 22, 111, 'marco rossi', '1231313', '2024-07-07', 3),
(20, 23, 111, 'angelo rossi', '123123131', '2024-07-07', 9),
(21, 24, 111, 'angelo neri', '12331312', '2024-07-04', 9),
(22, 25, 111, 'angelo viola', '2313123', '2024-07-13', 9),
(23, 26, 123, 'marco', '1312312', '2024-07-05', 3),
(24, 27, 111, 'antonellorossi', '12311312', '2024-07-06', 10),
(25, 28, 111, 'antonello', '4234324', '2024-07-04', 10),
(26, 29, 123, 'franco ', '2131231212', '2024-07-31', 11),
(27, 30, 1121, 'dad', '23213123', '2024-07-17', 3),
(28, 31, 1213, 'asdsa', '41241', '2024-07-14', 3),
(29, 32, 111, 'antonio', '4143124', '2024-07-11', 3),
(30, 33, 1231, 'asdasd', '12313213', '2024-07-03', 3),
(31, 34, 1231, 'silvio', '14123213', '2024-07-11', 3),
(32, 35, 12312, '121313', '123123131', '2024-07-14', 3),
(33, 36, 1231, '313', '34342', '2024-07-06', 3),
(34, 37, 123, 'marco', '2313113', '2024-07-04', 3),
(35, 38, 111, 'alessia rossi', '233131', '2024-07-04', 14),
(36, 39, 111, 'alessia rossi', '4343434', '2024-07-07', 14),
(37, 40, 111, 'antonella', '43442', '2024-07-05', 3),
(38, 41, 111, 'matteo', '343343', '2024-07-05', 3),
(39, 42, 111, 'silvio', '143242', '2024-07-03', 6),
(40, 43, 122, 'silvio', '13311', '2024-07-05', 16),
(41, 44, 2313, 'adad', '12212321', '2024-07-05', 3),
(42, 45, 111, 'ken', '13213', '2024-07-04', 19),
(43, 46, 123, 'matteo', '3213231', '2024-07-10', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `idNews` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `news`
--

INSERT INTO `news` (`idNews`, `idUser`, `title`, `description`, `creation_time`) VALUES
(1, 2, 'CIAO MONDO', '2024-07-20 20:38:52', '0000-00-00 00:00:00'),
(2, 2, 'ciaooo', 'prova 2', '2024-07-20 20:41:05'),
(3, 2, 'ciao', 'hello\r\n', '2024-07-20 21:39:03');

-- --------------------------------------------------------

--
-- Struttura della tabella `personaltrainer`
--

CREATE TABLE `personaltrainer` (
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `personaltrainer`
--

INSERT INTO `personaltrainer` (`idUser`) VALUES
(1);

-- --------------------------------------------------------

--
-- Struttura della tabella `physicaldata`
--

CREATE TABLE `physicaldata` (
  `idUser` int(11) NOT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `leanMass` float DEFAULT NULL,
  `fatMass` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `idPhysicalData` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `physicaldata`
--

INSERT INTO `physicaldata` (`idUser`, `sex`, `height`, `weight`, `leanMass`, `fatMass`, `bmi`, `date`, `idPhysicalData`) VALUES
(3, 'uomo', 33, 33, 33, 33, 33, '2024-07-20 15:27:52', 1),
(9, 'donna', 222, 22, 43, 433, 4334, '2024-07-20 15:30:20', 2),
(14, 'donna', 33, 33, 33, 33, 33, '2024-07-20 15:39:01', 3),
(3, 'uomo', 22, 22, 21, 12, 11, '2024-07-20 15:43:10', 4),
(3, 'uomo', 50, 60, 70, 50, 40, '2024-07-20 16:11:22', 5),
(3, 'uomo', 150, 300, 200, 220, 100, '2024-07-20 16:11:39', 6),
(7, 'donna', 22, 23, 0, 11, 200, '2024-07-20 19:33:10', 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `registereduser`
--

CREATE TABLE `registereduser` (
  `idUser` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `registereduser`
--

INSERT INTO `registereduser` (`idUser`, `type`) VALUES
(3, 'followed_user'),
(4, 'user_only'),
(5, NULL),
(6, 'user_only'),
(7, 'followed_user'),
(8, NULL),
(9, 'followed_user'),
(10, 'user_only'),
(11, 'followed_user'),
(12, NULL),
(13, NULL),
(14, 'followed_user'),
(15, NULL),
(16, 'followed_user'),
(17, NULL),
(18, NULL),
(19, 'followed_user'),
(20, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `reservation`
--

CREATE TABLE `reservation` (
  `idReservation` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `trainingPT` tinyint(1) NOT NULL DEFAULT 0,
  `time` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `reservation`
--

INSERT INTO `reservation` (`idReservation`, `idUser`, `date`, `trainingPT`, `time`) VALUES
(1, 3, '2024-07-06', 0, NULL),
(2, 3, '2024-07-04', 1, NULL),
(3, 3, '2024-07-03', 1, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `subscription`
--

CREATE TABLE `subscription` (
  `idSubscription` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `subscription`
--

INSERT INTO `subscription` (`idSubscription`, `idUser`, `type`, `duration`, `price`) VALUES
(1, 3, 'individual', 12, 300),
(2, 3, 'coached', 1, 100),
(3, 3, 'individual', 1, 30),
(4, 3, 'coached', 12, 1000),
(5, 3, 'individual', 1, 30),
(6, 3, 'individual', 12, 300),
(7, 5, 'coached', 1, 100),
(8, 3, 'coached', 1, 100),
(9, 6, 'individual', 1, 30),
(10, 3, 'individual', 12, 300),
(11, 3, 'coached', 1, 100),
(12, 4, 'individual', 12, 300),
(13, 3, 'individual', 12, 300),
(14, 3, 'individual', 1, 30),
(15, 3, 'coached', 1, 100),
(16, 3, 'individual', 12, 300),
(17, 7, 'coached', 1, 100),
(18, 7, 'individual', 12, 300),
(19, 7, 'coached', 1, 100),
(20, 3, 'individual', 12, 300),
(21, 3, 'coached', 12, 1000),
(22, 3, 'individual', 12, 300),
(23, 9, 'coached', 1, 100),
(24, 9, 'individual', 12, 300),
(25, 9, 'coached', 1, 100),
(26, 3, 'individual', 12, 300),
(27, 10, 'coached', 1, 100),
(28, 10, 'individual', 1, 30),
(29, 11, 'coached', 1, 100),
(30, 3, 'individual', 12, 300),
(31, 3, 'coached', 1, 100),
(32, 3, 'coached', 12, 1000),
(33, 3, 'individual', 1, 30),
(34, 3, 'individual', 12, 300),
(35, 3, 'individual', 12, 300),
(36, 3, 'coached', 1, 100),
(37, 3, 'coached', 12, 1000),
(38, 14, 'individual', 12, 300),
(39, 14, 'coached', 1, 100),
(40, 3, 'individual', 12, 300),
(41, 3, 'coached', 1, 100),
(42, 6, 'individual', 1, 30),
(43, 16, 'coached', 1, 100),
(44, 3, 'individual', 1, 30),
(45, 19, 'coached', 1, 100),
(46, 3, 'coached', 1, 100);

-- --------------------------------------------------------

--
-- Struttura della tabella `trainingcard`
--

CREATE TABLE `trainingcard` (
  `idUser` int(11) NOT NULL,
  `idTrainingCard` int(11) NOT NULL,
  `exercises` text DEFAULT NULL,
  `repetition` text DEFAULT NULL,
  `recovery` text DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`idUser`, `email`, `username`, `first_name`, `last_name`, `password`, `role`) VALUES
(1, 'personalTrainer@gmail.com', 'personalTrainer', 'mario', 'del corvo', '$2y$10$ZHf4L2qFLZOfjW8I1s4GFuBWeuamZYBAgPYkEh9s9Jc7idEFalVZK', 'personalTrainer'),
(2, 'admin@gmail.com', 'admin', 'admin', 'user', '$2y$10$OXjV3zrKMzR6LxD1MOMXQ.SPG8zyBiL9Fg1ilj18jngohNXHbfL5i', 'admin'),
(3, 'marco@gmail.com', 'marco', 'marco', 'rossi', '$2y$10$ToSs1/EumQJN3htOhwdW9uCQlBgvZUbvlbCnUHtfbBdhs1a3Xi9ze', 'registeredUser'),
(4, 'silvio@gmail.com', 'silvio', 'silvio', 'rossi', '$2y$10$8M968RZePTSrykUHWjvk2O6ogded8c9qTM1hgHZh128X9ymG0ueoW', 'registeredUser'),
(5, 'silvia@gmail.com', 'silvia', 'silvia', 'neri', '$2y$10$NbHrU3JJ/3MPdQyDEjgAs.lVdVGL35PK1FtDa/m2xYdT5qsJzOHiC', 'registeredUser'),
(6, 'daniela@gmail.com', 'daniela', 'daniela', 'rossi', '$2y$10$ZOBx/HL1KU6w6HkOyS20zuH/oOk/THnvl54phgTO5xpWkwiYloCt.', 'registeredUser'),
(7, 'marzia@gmail.com', 'marzia', 'marzia', 'rossi', '$2y$10$NrdY2G8q8Dexaw6CpQR6VulCC1oxZvoJSs117jMwdfZTnftW8x.3.', 'registeredUser'),
(8, 'nicola@gmail.com', 'nicola', 'nicola', 'rossi', '$2y$10$P1toxFuPiKYixql.LbQp4e//vfLBH4N6xISByr3Pi2/YHsfIdCS3S', 'registeredUser'),
(9, 'angelo@gmail.com', 'angelo', 'angelo', 'rossi', '$2y$10$nTvn1JwtVStgqDvScmwWme4Fg52kzo4ZZa44qmRdgbdm35TLcy0X.', 'registeredUser'),
(10, 'antonello@gmail.com', 'antonello', 'antonello', 'rossi', '$2y$10$ZyJw3RwQ.BjfoTpSSgzbBOCZv.VAXZyYdFfLCofVzrbQsS7fZvMgS', 'registeredUser'),
(11, 'franco@gmail.com', 'franco', 'franco', 'maffia', '$2y$10$UlGFdWF4nxyz.JyFEjjp.ujIfvrqOjZoi3M51h/rXsp.2SB4GHOR2', 'registeredUser'),
(12, 'osvaldo@gmail.com', 'osvaldo', 'osvaldo', 'rossi', '$2y$10$PAzNdJilDjO3xj.m9Yy.lu9iLC/UimUC4jonLc3D8N9SSvx0dEAnm', 'registeredUser'),
(13, 'carla@gmail.com', 'carla', 'carla', 'rossi', '$2y$10$CGd2RhXuDpb5R79PJkTrvehQNJzJ0U.Vn1azly8yfZ058UJs5wXK.', 'registeredUser'),
(14, 'alessia@gmail.com', 'alessia', 'alessia', 'rossi', '$2y$10$EvHbXWE3CO8BAiyOMBUCru.zAYmZSZlvbpfh3iuJlHQmm4ri/3Sxy', 'registeredUser'),
(15, 'orlando@gmail.com', 'orlando', 'orlando', 'rossi', '$2y$10$pOqEKwfL6JsbYrfc/fSTx.AkpHOuvkkx0nnZxIBA7Ik6jnxvV8pb6', 'registeredUser'),
(16, 'davide@gmail.com', 'davide', 'davide', 'rossi', '$2y$10$gI/U1QlxCERX2g9/76jHle5/gRsfBrz2YhZULLaaTDIXOckxgYVKW', 'registeredUser'),
(17, 'paolo@gmail.com', 'paolo', 'paolo', 'rossi', '$2y$10$ndFSNwaR19SVFfVqTvxsMeDP74m0BFuySo5NspQdp7nOYiwu/EsVu', 'registeredUser'),
(18, 'lorenza@gmail.com', 'lorenza', 'lorenza', 'rossi', '$2y$10$kGH8BDj8BLnEwtor4PdKdeuVOcl709A4BKyeCAxfRMyNoCIsYKXoW', 'registeredUser'),
(19, 'kevin@gmail.com', 'kevin', 'kevin', 'rossi', '$2y$10$LBY.Fc03whhlDFbKy9NRqeSJfoeEtIjY6jSb/XPSx9HCHRcoVg082', 'registeredUser'),
(20, 'lavinia@gmail.com', 'lavinia', 'lavinia', 'rossi', '$2y$10$uHI15xSy5JQfgFFLqDecR.isDSJ4PSYL60OKIfDj.1VVgi6DmTzJe', 'registeredUser');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idUser`);

--
-- Indici per le tabelle `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`idCreditCard`),
  ADD KEY `creditcard_ibfk_1` (`idSubscription`),
  ADD KEY `fk_creditcard` (`idUser`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`idNews`),
  ADD KEY `news_ibfk_1` (`idUser`);

--
-- Indici per le tabelle `personaltrainer`
--
ALTER TABLE `personaltrainer`
  ADD PRIMARY KEY (`idUser`);

--
-- Indici per le tabelle `physicaldata`
--
ALTER TABLE `physicaldata`
  ADD PRIMARY KEY (`idPhysicalData`),
  ADD KEY `physicaldata_ibfk_1` (`idUser`);

--
-- Indici per le tabelle `registereduser`
--
ALTER TABLE `registereduser`
  ADD PRIMARY KEY (`idUser`);

--
-- Indici per le tabelle `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `reservation_ibfk_1` (`idUser`);

--
-- Indici per le tabelle `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`idSubscription`),
  ADD KEY `subscription_ibfk_1` (`idUser`);

--
-- Indici per le tabelle `trainingcard`
--
ALTER TABLE `trainingcard`
  ADD PRIMARY KEY (`idTrainingCard`),
  ADD KEY `trainingcard_ibfk_1` (`idUser`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `idCreditCard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `personaltrainer`
--
ALTER TABLE `personaltrainer`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `physicaldata`
--
ALTER TABLE `physicaldata`
  MODIFY `idPhysicalData` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `registereduser`
--
ALTER TABLE `registereduser`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `reservation`
--
ALTER TABLE `reservation`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `subscription`
--
ALTER TABLE `subscription`
  MODIFY `idSubscription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `trainingcard`
--
ALTER TABLE `trainingcard`
  MODIFY `idTrainingCard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`idSubscription`) REFERENCES `subscription` (`idSubscription`),
  ADD CONSTRAINT `fk_creditcard` FOREIGN KEY (`idUser`) REFERENCES `registereduser` (`idUser`);

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `admin` (`idUser`);

--
-- Limiti per la tabella `personaltrainer`
--
ALTER TABLE `personaltrainer`
  ADD CONSTRAINT `personaltrainer_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `physicaldata`
--
ALTER TABLE `physicaldata`
  ADD CONSTRAINT `physicaldata_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `registereduser` (`idUser`);

--
-- Limiti per la tabella `registereduser`
--
ALTER TABLE `registereduser`
  ADD CONSTRAINT `registereduser_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Limiti per la tabella `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `registereduser` (`idUser`);

--
-- Limiti per la tabella `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `registereduser` (`idUser`);

--
-- Limiti per la tabella `trainingcard`
--
ALTER TABLE `trainingcard`
  ADD CONSTRAINT `trainingcard_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `registereduser` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
