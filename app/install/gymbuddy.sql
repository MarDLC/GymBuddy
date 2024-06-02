-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 01, 2024 alle 18:30
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
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `creditcard`
--

CREATE TABLE `creditcard` (
  `cvc` int(11) NOT NULL,
  `accountHolder` varchar(255) DEFAULT NULL,
  `cardNumber` varchar(16) DEFAULT NULL,
  `expirationDate` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `idCreditCard` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `idNews` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `date` date NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `personaltrainer`
--

CREATE TABLE `personaltrainer` (
  `email` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `personaltrainer`
--

INSERT INTO `personaltrainer` (`email`, `approved`) VALUES
('testPT@example.com', 0),
('testFPersonalTrainer@example.com', 0),
('testFPersonalTrainer@example.com', 0),
('testFPersonalTrainer@example.com', 0),
('testFPersonalTrainer@example.com', 0),
('testSaveObj@example.com', 0),
('testSaveObj@example.com', 0),
('testSaveObj@example.com', 0),
('testSaveObj22@example.com', 0),
('testSaveObj22@example.com', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `physicaldata`
--

CREATE TABLE `physicaldata` (
  `emailRegisteredUser` varchar(255) NOT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `leanMass` float DEFAULT NULL,
  `fatMass` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  `emailPersonalTrainer` varchar(255) DEFAULT NULL,
  `idPhysicalData` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `registereduser`
--

CREATE TABLE `registereduser` (
  `email` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `registereduser`
--

INSERT INTO `registereduser` (`email`, `type`) VALUES
('test13@example.com', NULL),
('test14@example.com', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `reservation`
--

CREATE TABLE `reservation` (
  `emailRegisteredUser` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `TrainingPT` tinyint(1) DEFAULT NULL,
  `emailPersonalTrainer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `subscription`
--

CREATE TABLE `subscription` (
  `email` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `trainingcard`
--

CREATE TABLE `trainingcard` (
  `idTrainingCard` int(11) NOT NULL,
  `emailRegisteredUser` varchar(255) DEFAULT NULL,
  `creation` date DEFAULT NULL,
  `exercises` text DEFAULT NULL,
  `repetition` text DEFAULT NULL,
  `recovery` text DEFAULT NULL,
  `emailPersonalTrainer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
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

INSERT INTO `user` (`email`, `username`, `first_name`, `last_name`, `password`, `role`) VALUES
('newPT@example.com', 'newPT', 'New', 'PT', '$2y$10$4d7TaKP/pxptay1.kex70OxOW6s/cYuTeU3LCBq5mhtWgGe00g11e', 'personalTrainer'),
('test13@example.com', 'testuser', 'Test', 'User', '$2y$10$91o0JgKE2.UJzxjqJ7BgXeTaMgNXT5wN5BFISUd2waPFQGujz8aHW', 'registeredUser'),
('test14@example.com', 'testuser', 'Test', 'User', '$2y$10$5tVHQNFL7edY6Db58nHcMezburYANynzznOOh1O.CQgYSoz5OSSs6', 'registeredUser'),
('testFPersonalTrainer@example.com', 'testuser', 'Test', 'FPersonalTrainer', '$2y$10$EriR2Yw61ExDirj5hYZoDOQcFUPY94ri2hdIbt2D/VQ14A7nlJ/eK', 'personalTrainer'),
('testPT@example.com', 'testPT', 'Test', 'PT', '$2y$10$mg.XqyQtd5hhiAOVgiCiQuIIo6XmCWHdcDVu5sc.iuI18FXo18dQG', 'personalTrainer'),
('testSaveObj@example.com', 'testuser', 'Test', 'SaveObj', '$2y$10$9OifPP5HyARBnOryXjpSjuqaIjBUzNGCNrQvwc54FtG8heh40Y9lm', 'personalTrainer'),
('testSaveObj22@example.com', 'testuser', 'Test', 'SaveObj', '$2y$10$6sB1dakCFnYdChAIxzlWG.abhjwStWP8yc90jAeJ/tRUB5vk0h3hm', 'personalTrainer');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `creditcard`
--
ALTER TABLE `creditcard`
  ADD PRIMARY KEY (`idCreditCard`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`idNews`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `personaltrainer`
--
ALTER TABLE `personaltrainer`
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `physicaldata`
--
ALTER TABLE `physicaldata`
  ADD PRIMARY KEY (`idPhysicalData`),
  ADD KEY `emailPersonalTrainer` (`emailPersonalTrainer`),
  ADD KEY `physicaldata_ibfk_1` (`emailRegisteredUser`);

--
-- Indici per le tabelle `registereduser`
--
ALTER TABLE `registereduser`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`emailRegisteredUser`),
  ADD KEY `emailPersonalTrainer` (`emailPersonalTrainer`);

--
-- Indici per le tabelle `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `trainingcard`
--
ALTER TABLE `trainingcard`
  ADD PRIMARY KEY (`idTrainingCard`),
  ADD KEY `emailRegisteredUser` (`emailRegisteredUser`),
  ADD KEY `emailPersonalTrainer` (`emailPersonalTrainer`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `creditcard`
--
ALTER TABLE `creditcard`
  MODIFY `idCreditCard` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `idNews` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `physicaldata`
--
ALTER TABLE `physicaldata`
  MODIFY `idPhysicalData` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `trainingcard`
--
ALTER TABLE `trainingcard`
  MODIFY `idTrainingCard` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`email`) REFERENCES `subscription` (`email`);

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Limiti per la tabella `personaltrainer`
--
ALTER TABLE `personaltrainer`
  ADD CONSTRAINT `personaltrainer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `physicaldata`
--
ALTER TABLE `physicaldata`
  ADD CONSTRAINT `physicaldata_ibfk_1` FOREIGN KEY (`emailRegisteredUser`) REFERENCES `registereduser` (`email`),
  ADD CONSTRAINT `physicaldata_ibfk_2` FOREIGN KEY (`emailPersonalTrainer`) REFERENCES `personaltrainer` (`email`);

--
-- Limiti per la tabella `registereduser`
--
ALTER TABLE `registereduser`
  ADD CONSTRAINT `registereduser_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`emailRegisteredUser`) REFERENCES `registereduser` (`email`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`emailPersonalTrainer`) REFERENCES `personaltrainer` (`email`);

--
-- Limiti per la tabella `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`email`) REFERENCES `registereduser` (`email`);

--
-- Limiti per la tabella `trainingcard`
--
ALTER TABLE `trainingcard`
  ADD CONSTRAINT `trainingcard_ibfk_1` FOREIGN KEY (`emailRegisteredUser`) REFERENCES `registereduser` (`email`),
  ADD CONSTRAINT `trainingcard_ibfk_2` FOREIGN KEY (`emailPersonalTrainer`) REFERENCES `personaltrainer` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
