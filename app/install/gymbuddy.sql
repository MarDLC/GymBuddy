-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 19, 2024 alle 13:19
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
-- Struttura della tabella `followeduser`
--

CREATE TABLE `followeduser` (
  `emailPersonalTrainer` varchar(255) NOT NULL,
  `emailRegisteredUser` varchar(255) NOT NULL
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
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Indici per le tabelle `followeduser`
--
ALTER TABLE `followeduser`
  ADD KEY `emailPersonalTrainer` (`emailPersonalTrainer`),
  ADD KEY `emailRegisteredUser` (`emailRegisteredUser`);

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
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE;

--
-- Limiti per la tabella `creditcard`
--
ALTER TABLE `creditcard`
  ADD CONSTRAINT `creditcard_ibfk_1` FOREIGN KEY (`email`) REFERENCES `subscription` (`email`);

--
-- Limiti per la tabella `followeduser`
--
ALTER TABLE `followeduser`
  ADD CONSTRAINT `followeduser_ibfk_1` FOREIGN KEY (`emailPersonalTrainer`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `followeduser_ibfk_2` FOREIGN KEY (`emailRegisteredUser`) REFERENCES `user` (`email`);

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

--
-- Limiti per la tabella `personaltrainer`
--
ALTER TABLE `personaltrainer`
  ADD CONSTRAINT `personaltrainer_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`);

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
  ADD CONSTRAINT `registereduser_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE;

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
