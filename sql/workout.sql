-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 02, 2014 at 10:17 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `workout`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attending`
--

CREATE TABLE IF NOT EXISTS `Attending` (
  `WorkoutID` int(11) NOT NULL AUTO_INCREMENT,
  `AttendingName` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`WorkoutID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Exercises`
--

CREATE TABLE IF NOT EXISTS `Exercises` (
  `ExerciseID` int(11) NOT NULL AUTO_INCREMENT,
  `WorkoutID` int(11) NOT NULL,
  `ExerciseOrder` int(11) NOT NULL,
  `ExerciseName` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ExerciseID`),
  KEY `Exercises_ibfk_1` (`WorkoutID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `Modifiers`
--

CREATE TABLE IF NOT EXISTS `Modifiers` (
  `SetID` int(11) NOT NULL,
  `ModifierDescription` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`SetID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `People`
--

CREATE TABLE IF NOT EXISTS `People` (
  `PersonID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(20) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `BirthDate` datetime DEFAULT NULL,
  PRIMARY KEY (`PersonID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `People`
--

INSERT INTO `People` (`PersonID`, `FirstName`, `LastName`, `BirthDate`) VALUES
(1, 'Matt', 'Agra', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Sets`
--

CREATE TABLE IF NOT EXISTS `Sets` (
  `SetID` int(11) NOT NULL AUTO_INCREMENT,
  `ExerciseID` int(11) NOT NULL,
  `SetOrder` int(11) NOT NULL,
  `Repetitions` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`SetID`),
  KEY `Sets_ibfk_1` (`ExerciseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `WeightLog`
--

CREATE TABLE IF NOT EXISTS `WeightLog` (
  `WeightLogID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  `DateLogged` datetime DEFAULT NULL,
  `Weight` int(11) NOT NULL,
  PRIMARY KEY (`WeightLogID`),
  KEY `PersonID` (`PersonID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Workouts`
--

CREATE TABLE IF NOT EXISTS `Workouts` (
  `WorkoutID` int(11) NOT NULL AUTO_INCREMENT,
  `PersonID` int(11) NOT NULL,
  `StartDate` datetime NOT NULL,
  `EndDate` datetime DEFAULT NULL,
  `Location` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `Notes` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`WorkoutID`),
  KEY `Workouts_ibfk_1` (`PersonID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attending`
--
ALTER TABLE `Attending`
  ADD CONSTRAINT `Attending_ibfk_1` FOREIGN KEY (`WorkoutID`) REFERENCES `Workouts` (`WorkoutID`);

--
-- Constraints for table `Exercises`
--
ALTER TABLE `Exercises`
  ADD CONSTRAINT `Exercises_ibfk_1` FOREIGN KEY (`WorkoutID`) REFERENCES `Workouts` (`WorkoutID`) ON DELETE CASCADE;

--
-- Constraints for table `Modifiers`
--
ALTER TABLE `Modifiers`
  ADD CONSTRAINT `Modifiers_ibfk_1` FOREIGN KEY (`SetID`) REFERENCES `Sets` (`SetID`);

--
-- Constraints for table `Sets`
--
ALTER TABLE `Sets`
  ADD CONSTRAINT `Sets_ibfk_1` FOREIGN KEY (`ExerciseID`) REFERENCES `Exercises` (`ExerciseID`) ON DELETE CASCADE;

--
-- Constraints for table `WeightLog`
--
ALTER TABLE `WeightLog`
  ADD CONSTRAINT `WeightLog_ibfk_1` FOREIGN KEY (`PersonID`) REFERENCES `People` (`PersonID`);

--
-- Constraints for table `Workouts`
--
ALTER TABLE `Workouts`
  ADD CONSTRAINT `Workouts_ibfk_1` FOREIGN KEY (`PersonID`) REFERENCES `People` (`PersonID`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
