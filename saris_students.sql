-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 16, 2019 at 01:59 PM
-- Server version: 5.5.42
-- PHP Version: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saris_students`
--

-- --------------------------------------------------------

--
-- Table structure for table `academicyear`
--

CREATE TABLE `academicyear` (
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Status` tinyint(1) DEFAULT NULL,
  `intYearID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `allocation`
--

CREATE TABLE `allocation` (
  `HID` varchar(50) NOT NULL DEFAULT '',
  `RNumber` varchar(50) NOT NULL DEFAULT '',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `CheckOut` date NOT NULL DEFAULT '0000-00-00',
  `CheckIn` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `HID` varchar(15) NOT NULL DEFAULT '',
  `BName` varchar(15) NOT NULL DEFAULT '',
  `Capacity` smallint(6) DEFAULT NULL,
  `NoofFloors` int(11) DEFAULT NULL,
  `NoofRooms` int(11) DEFAULT NULL,
  `Id` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE `campus` (
  `CampusID` int(11) NOT NULL,
  `Campus` varchar(50) NOT NULL DEFAULT '',
  `Location` varchar(50) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Tel` varchar(50) NOT NULL DEFAULT '',
  `Email` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `classstream`
--

CREATE TABLE `classstream` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `group` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `intCountryID` int(11) NOT NULL,
  `szCountry` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table to store a list of all the countries.';

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Id` int(11) NOT NULL,
  `CourseCode` varchar(9) NOT NULL DEFAULT '',
  `CourseName` varchar(255) NOT NULL DEFAULT '',
  `YearOffered` varchar(50) DEFAULT NULL,
  `Capacity` int(11) NOT NULL DEFAULT '1000',
  `Units` varchar(50) DEFAULT NULL,
  `Department` varchar(200) NOT NULL DEFAULT '',
  `Faculty` varchar(200) NOT NULL DEFAULT '',
  `Programme` varchar(10) DEFAULT NULL,
  `StudyLevel` varchar(10) DEFAULT NULL,
  `Status` int(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coursecandidate`
--

CREATE TABLE `coursecandidate` (
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `CourseCode` varchar(50) NOT NULL DEFAULT '',
  `AYear` varchar(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coursecontrol`
--

CREATE TABLE `coursecontrol` (
  `ID` int(11) NOT NULL,
  `CourseCode` varchar(15) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(13) DEFAULT NULL,
  `Mark` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `coursecountprogramme`
--

CREATE TABLE `coursecountprogramme` (
  `ProgrammeID` varchar(50) NOT NULL,
  `Semester` varchar(50) NOT NULL,
  `CourseCount` tinyint(10) NOT NULL,
  `YearofStudy` tinyint(10) NOT NULL,
  `AYear` varchar(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courseoption`
--

CREATE TABLE `courseoption` (
  `Id` int(11) NOT NULL,
  `Description` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courseprogramme`
--

CREATE TABLE `courseprogramme` (
  `ProgrammeID` varchar(50) NOT NULL DEFAULT '',
  `CourseCode` varchar(50) NOT NULL DEFAULT '',
  `Status` tinyint(10) DEFAULT NULL,
  `YearofStudy` tinyint(10) DEFAULT NULL,
  `Semester` tinyint(10) DEFAULT NULL,
  `AYear` varchar(9) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coursestatus`
--

CREATE TABLE `coursestatus` (
  `StatusCode` tinyint(4) NOT NULL DEFAULT '0',
  `StatusName` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `CriteriaID` int(11) NOT NULL,
  `ShortName` varchar(50) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `denomination`
--

CREATE TABLE `denomination` (
  `denominationId` int(11) NOT NULL,
  `denomination` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ReligionID` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DeptID` int(11) NOT NULL,
  `CampusID` int(11) NOT NULL DEFAULT '0',
  `Faculty` varchar(120) DEFAULT NULL,
  `DeptName` varchar(200) DEFAULT NULL,
  `DeptPhysAdd` varchar(70) NOT NULL DEFAULT '',
  `DeptAddress` varchar(50) DEFAULT NULL,
  `DeptTel` varchar(50) DEFAULT NULL,
  `DeptEmail` varchar(50) DEFAULT NULL,
  `DeptHead` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `disability`
--

CREATE TABLE `disability` (
  `DisabilityCode` int(11) NOT NULL,
  `disability` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disability3`
--

CREATE TABLE `disability3` (
  `DisabilityID` int(11) NOT NULL,
  `Disability` varchar(150) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `disabilitycategory`
--

CREATE TABLE `disabilitycategory` (
  `DisabilityCategoryId` int(11) NOT NULL,
  `disabilityCategory` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `DisabilityCode` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE `docs` (
  `docId` int(50) NOT NULL,
  `doc` varchar(200) DEFAULT NULL,
  `received` varchar(50) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electioncandidate`
--

CREATE TABLE `electioncandidate` (
  `id` int(11) NOT NULL,
  `RegNo` varchar(255) DEFAULT NULL,
  `Post` varchar(30) NOT NULL DEFAULT '',
  `Faculty` varchar(20) NOT NULL DEFAULT '',
  `Institution` varchar(50) NOT NULL DEFAULT '',
  `Period` varchar(10) NOT NULL DEFAULT '',
  `Photo` longblob,
  `Size` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `electiondate`
--

CREATE TABLE `electiondate` (
  `PostId` int(11) NOT NULL DEFAULT '0',
  `Period` varchar(255) NOT NULL DEFAULT '',
  `StartDate` datetime DEFAULT '0000-00-00 00:00:00',
  `EndDate` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `electionpost`
--

CREATE TABLE `electionpost` (
  `Id` int(11) NOT NULL,
  `Post` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `electionvotes`
--

CREATE TABLE `electionvotes` (
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `CandidateID` int(11) NOT NULL DEFAULT '0',
  `Period` varchar(10) NOT NULL DEFAULT '',
  `Post` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examcategory`
--

CREATE TABLE `examcategory` (
  `Id` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exammarker`
--

CREATE TABLE `exammarker` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL DEFAULT '',
  `Address` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_`
--

CREATE TABLE `examnumber_` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_0`
--

CREATE TABLE `examnumber_0` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_10`
--

CREATE TABLE `examnumber_10` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_11`
--

CREATE TABLE `examnumber_11` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_12`
--

CREATE TABLE `examnumber_12` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_13`
--

CREATE TABLE `examnumber_13` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_14`
--

CREATE TABLE `examnumber_14` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_16`
--

CREATE TABLE `examnumber_16` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_17`
--

CREATE TABLE `examnumber_17` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_18`
--

CREATE TABLE `examnumber_18` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_19`
--

CREATE TABLE `examnumber_19` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_20`
--

CREATE TABLE `examnumber_20` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_21`
--

CREATE TABLE `examnumber_21` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_22`
--

CREATE TABLE `examnumber_22` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_23`
--

CREATE TABLE `examnumber_23` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_24`
--

CREATE TABLE `examnumber_24` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_25`
--

CREATE TABLE `examnumber_25` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_26`
--

CREATE TABLE `examnumber_26` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_27`
--

CREATE TABLE `examnumber_27` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_28`
--

CREATE TABLE `examnumber_28` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_29`
--

CREATE TABLE `examnumber_29` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_30`
--

CREATE TABLE `examnumber_30` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_31`
--

CREATE TABLE `examnumber_31` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_32`
--

CREATE TABLE `examnumber_32` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_33`
--

CREATE TABLE `examnumber_33` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_34`
--

CREATE TABLE `examnumber_34` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_35`
--

CREATE TABLE `examnumber_35` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_36`
--

CREATE TABLE `examnumber_36` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_37`
--

CREATE TABLE `examnumber_37` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_38`
--

CREATE TABLE `examnumber_38` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_39`
--

CREATE TABLE `examnumber_39` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_40`
--

CREATE TABLE `examnumber_40` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_41`
--

CREATE TABLE `examnumber_41` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_42`
--

CREATE TABLE `examnumber_42` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_43`
--

CREATE TABLE `examnumber_43` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_44`
--

CREATE TABLE `examnumber_44` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_AC`
--

CREATE TABLE `examnumber_AC` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_BA`
--

CREATE TABLE `examnumber_BA` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_COD`
--

CREATE TABLE `examnumber_COD` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_ed`
--

CREATE TABLE `examnumber_ed` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_EGH`
--

CREATE TABLE `examnumber_EGH` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_EKE`
--

CREATE TABLE `examnumber_EKE` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_eod`
--

CREATE TABLE `examnumber_eod` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_gd`
--

CREATE TABLE `examnumber_gd` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_gi`
--

CREATE TABLE `examnumber_gi` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_HRM`
--

CREATE TABLE `examnumber_HRM` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_ICT`
--

CREATE TABLE `examnumber_ICT` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_MSD`
--

CREATE TABLE `examnumber_MSD` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_nil`
--

CREATE TABLE `examnumber_nil` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_pmsd`
--

CREATE TABLE `examnumber_pmsd` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_PRO`
--

CREATE TABLE `examnumber_PRO` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_REC`
--

CREATE TABLE `examnumber_REC` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_repeated`
--

CREATE TABLE `examnumber_repeated` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_ss`
--

CREATE TABLE `examnumber_ss` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examnumber_yw`
--

CREATE TABLE `examnumber_yw` (
  `RegNo` varchar(50) NOT NULL,
  `ExamNo` varchar(50) DEFAULT NULL,
  `EntryYear` varchar(9) DEFAULT NULL,
  `AYear` varchar(9) DEFAULT NULL,
  `Semester` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `examregister`
--

CREATE TABLE `examregister` (
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Semester` varchar(12) NOT NULL DEFAULT '',
  `CourseCode` varchar(10) NOT NULL DEFAULT '',
  `ExamDate` date NOT NULL DEFAULT '0000-00-00',
  `Recorder` varchar(20) NOT NULL DEFAULT '',
  `RecordDate` date NOT NULL DEFAULT '0000-00-00',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `Checked` tinyint(4) NOT NULL DEFAULT '0',
  `Status` varchar(6) NOT NULL DEFAULT '',
  `Count` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examregisterlecturer`
--

CREATE TABLE `examregisterlecturer` (
  `PCode` varchar(100) NOT NULL DEFAULT '',
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Semester` varchar(12) NOT NULL DEFAULT '',
  `CourseCode` varchar(10) NOT NULL DEFAULT '',
  `Faculty` varchar(100) NOT NULL,
  `Day` varchar(25) NOT NULL DEFAULT '',
  `Room` varchar(100) NOT NULL COMMENT 'Study Venue',
  `StartTime` varchar(10) NOT NULL DEFAULT '',
  `EndTime` varchar(10) NOT NULL DEFAULT '',
  `ExamDate` date NOT NULL DEFAULT '0000-00-00',
  `Recorder` varchar(20) NOT NULL DEFAULT '',
  `RecordDate` date NOT NULL DEFAULT '0000-00-00',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `Checked` tinyint(4) NOT NULL DEFAULT '1',
  `Status` varchar(6) NOT NULL DEFAULT '',
  `Count` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examremark`
--

CREATE TABLE `examremark` (
  `Remark` varchar(10) NOT NULL DEFAULT '',
  `Description` text,
  `Recorder` varchar(20) DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `examresult`
--

CREATE TABLE `examresult` (
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Semester` varchar(12) DEFAULT NULL,
  `Marker` varchar(5) NOT NULL DEFAULT '0',
  `CourseCode` varchar(10) NOT NULL DEFAULT '',
  `ExamCategory` varchar(6) NOT NULL DEFAULT '',
  `ExamDate` date NOT NULL DEFAULT '0000-00-00',
  `ExamSitting` varchar(6) NOT NULL DEFAULT '',
  `Recorder` varchar(20) NOT NULL DEFAULT '',
  `RecordDate` date NOT NULL DEFAULT '0000-00-00',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `ExamNo` varchar(30) DEFAULT NULL,
  `ExamScore` varchar(5) DEFAULT NULL,
  `Checked` tinyint(4) NOT NULL DEFAULT '0',
  `Status` varchar(6) NOT NULL DEFAULT '',
  `Count` tinyint(4) NOT NULL DEFAULT '0',
  `Comment` varchar(50) DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `examresult`
--
DELIMITER $$
CREATE TRIGGER `before_examresult_delete` BEFORE DELETE ON `examresult`
 FOR EACH ROW BEGIN 
INSERT INTO examresult_audit 
SET action_value = 'delete', 
AYear=OLD.AYear,
Semester=OLD.Semester,
Marker=OLD.Marker,
CourseCode=OLD.CourseCode,
ExamCategory=OLD.ExamCategory,
ExamDate=OLD.ExamDate,
ExamSitting=OLD.ExamSitting,
Recorder=OLD.Recorder,
RecordDate=OLD.RecordDate,
RegNo=OLD.RegNo,
ExamNo=OLD.ExamNo,
ExamScore=OLD.ExamScore,
ExamScoreAfter = OLD.ExamScore,
Checked=OLD.Checked,
Status=OLD.Status,
`Count`=OLD.`Count`,
`Comment`=OLD.`Comment`,
action_user=OLD.Recorder;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_examresult_update` BEFORE UPDATE ON `examresult`
 FOR EACH ROW BEGIN 
IF(NEW.ExamScore <> OLD.ExamScore) THEN 
INSERT INTO examresult_audit 
SET action_value = 'update', 
AYear=OLD.AYear,
Semester=OLD.Semester,
Marker=OLD.Marker,
CourseCode=OLD.CourseCode,
ExamCategory=OLD.ExamCategory,
ExamDate=OLD.ExamDate,
ExamSitting=OLD.ExamSitting,
Recorder=OLD.Recorder,
RecordDate=OLD.RecordDate,
RegNo=OLD.RegNo,
ExamNo=OLD.ExamNo,
ExamScore=OLD.ExamScore,
ExamScoreAfter = NEW.ExamScore,
Checked=OLD.Checked,
Status=OLD.Status,
`Count`=OLD.`Count`,
`Comment`=OLD.`Comment`,
action_user=NEW.Recorder;
END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `examresult_audit`
--

CREATE TABLE `examresult_audit` (
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Semester` varchar(12) DEFAULT NULL,
  `Marker` varchar(5) NOT NULL DEFAULT '0',
  `CourseCode` varchar(10) NOT NULL DEFAULT '',
  `ExamCategory` varchar(6) NOT NULL DEFAULT '',
  `ExamDate` date NOT NULL DEFAULT '0000-00-00',
  `ExamSitting` varchar(6) NOT NULL DEFAULT '',
  `Recorder` varchar(20) NOT NULL DEFAULT '',
  `RecordDate` date NOT NULL DEFAULT '0000-00-00',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `ExamNo` varchar(30) DEFAULT NULL,
  `ExamScore` varchar(5) DEFAULT NULL,
  `ExamScoreAfter` varchar(5) DEFAULT NULL,
  `Checked` tinyint(4) NOT NULL DEFAULT '0',
  `Status` varchar(6) NOT NULL DEFAULT '',
  `Count` tinyint(4) NOT NULL DEFAULT '0',
  `Comment` varchar(50) DEFAULT '',
  `action_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action_user` varchar(50) NOT NULL,
  `action_value` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `CampusID` int(11) NOT NULL DEFAULT '0',
  `FacultyID` int(11) NOT NULL,
  `FacultyName` varchar(200) DEFAULT NULL,
  `Address` varchar(80) NOT NULL DEFAULT '',
  `Email` varchar(50) NOT NULL DEFAULT '',
  `Tel` varchar(50) NOT NULL DEFAULT '',
  `Location` varchar(70) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feecombination`
--

CREATE TABLE `feecombination` (
  `feestructure` varchar(10) NOT NULL DEFAULT '',
  `feecode` varchar(15) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(11) NOT NULL,
  `feecode` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feesrates`
--

CREATE TABLE `feesrates` (
  `ayear` varchar(10) NOT NULL DEFAULT '',
  `feecode` varchar(10) NOT NULL DEFAULT '',
  `programmecode` varchar(4) NOT NULL DEFAULT '',
  `sponsor` varchar(50) NOT NULL DEFAULT '',
  `amount` double(11,2) DEFAULT NULL,
  `debtorlimit` double(11,2) DEFAULT NULL,
  `yearofstudy` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `feestructure`
--

CREATE TABLE `feestructure` (
  `StructureID` varchar(10) NOT NULL DEFAULT '0',
  `StructureName` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gradescale`
--

CREATE TABLE `gradescale` (
  `id` int(11) NOT NULL DEFAULT '0',
  `examcat` tinyint(4) NOT NULL DEFAULT '0',
  `marks` double NOT NULL DEFAULT '0',
  `grade` char(2) NOT NULL DEFAULT '',
  `point` double NOT NULL DEFAULT '0',
  `remark` varchar(4) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='examination grading scale';

-- --------------------------------------------------------

--
-- Table structure for table `gradyears`
--

CREATE TABLE `gradyears` (
  `YearID` int(11) NOT NULL,
  `Year` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `hostel`
--

CREATE TABLE `hostel` (
  `HID` varchar(5) NOT NULL DEFAULT '',
  `HName` varchar(50) NOT NULL DEFAULT '',
  `Location` varchar(70) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Address` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mannerofentry`
--

CREATE TABLE `mannerofentry` (
  `ID` int(11) NOT NULL,
  `MannerofEntry` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `maritalstatus`
--

CREATE TABLE `maritalstatus` (
  `intStatusID` int(11) NOT NULL,
  `szStatus` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table with a list of marital status';

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `moduleid` int(10) unsigned NOT NULL,
  `modulename` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`moduleid`, `modulename`) VALUES
(1, 'Examination'),
(2, 'Accommodation'),
(3, 'Student'),
(4, 'Admission'),
(5, 'Webmaster'),
(6, 'Blocked'),
(7, 'Billing'),
(8, 'Timetable');

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `id` tinyint(3) unsigned NOT NULL,
  `nationality` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `received` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fromid` varchar(30) NOT NULL DEFAULT '',
  `toid` varchar(30) NOT NULL DEFAULT '',
  `message` text,
  `replied` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `olevel_results`
--

CREATE TABLE `olevel_results` (
  `Id` int(11) NOT NULL,
  `indexNo` varchar(255) NOT NULL,
  `subjectID` varchar(255) NOT NULL,
  `regno` varchar(255) NOT NULL,
  `grade` varchar(1) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organisation`
--

CREATE TABLE `organisation` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `tel` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `website` varchar(80) DEFAULT NULL,
  `city` varchar(120) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `privilegeID` int(11) NOT NULL,
  `privilegename` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`privilegeID`, `privilegename`) VALUES
(1, 'Webmaster'),
(2, 'Manager'),
(3, 'Operator'),
(4, 'Student'),
(5, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

CREATE TABLE `programme` (
  `ProgrammeID` int(11) NOT NULL,
  `ProgrammeCode` int(4) NOT NULL,
  `ProgrammeName` varchar(250) DEFAULT NULL,
  `Title` text,
  `Ntalevel` varchar(250) DEFAULT NULL,
  `Faculty` varchar(250) DEFAULT NULL,
  `CampusID` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `programmelevel`
--

CREATE TABLE `programmelevel` (
  `Code` tinyint(2) NOT NULL DEFAULT '0',
  `StudyLevel` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `religion`
--

CREATE TABLE `religion` (
  `ReligionID` int(11) NOT NULL,
  `Religion` varchar(60) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `RNumber` varchar(50) NOT NULL DEFAULT '',
  `HID` varchar(15) NOT NULL DEFAULT '',
  `BID` varchar(20) DEFAULT NULL,
  `FloorName` varchar(50) DEFAULT NULL,
  `Capacity` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roomapplication`
--

CREATE TABLE `roomapplication` (
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `AppYear` varchar(50) NOT NULL DEFAULT '',
  `AllCriteria` int(11) DEFAULT NULL,
  `Hall` longtext,
  `Received` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Status` int(11) NOT NULL DEFAULT '0',
  `Processed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `UserName` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(45) NOT NULL DEFAULT '',
  `FullName` varchar(200) DEFAULT NULL,
  `RegNo` varchar(30) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `Registered` date DEFAULT NULL,
  `AuthLevel` varchar(20) DEFAULT NULL,
  `Module` int(11) NOT NULL DEFAULT '3',
  `PrivilegeID` int(11) NOT NULL DEFAULT '4',
  `Dept` int(11) NOT NULL DEFAULT '0',
  `Faculty` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`UserName`, `password`, `FullName`, `RegNo`, `Position`, `Email`, `LastLogin`, `Registered`, `AuthLevel`, `Module`, `PrivilegeID`, `Dept`, `Faculty`) VALUES
('systemadmin', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'System Administrator', 'ADMIN/0001', 'Administrator', '', '2006-02-27 12:15:50', '2004-02-07', 'admin', 5, 1, 0, 0),
('registrar', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'Registrar', 'ADMIN/0003', 'Administrator', '', '2007-03-19 13:02:03', '2007-03-19', 'user', 4, 2, 0, 31),
('timetable', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'Mohamed, Nassoro', 'PROG01', 'student', '', '2019-08-16 14:46:17', '2019-08-16', 'user', 8, 2, 0, 0),
('examofficer', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'Ramadhan, M', 'PROG02', 'Lecturer', '', '2019-08-16 14:53:15', '2019-08-16', 'user', 1, 2, 0, 0),
('student', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'Muneer, M', 'PROG03', 'student', '', '2019-08-16 14:54:56', '2019-08-16', 'user', 3, 4, 0, 0),
('admission', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'MAKANYAGA, Robert', 'PROG04', 'Administrator', '', '2019-08-16 14:56:39', '2019-08-16', 'user', 4, 2, 0, 0),
('accommodation', '{jlungo-hash}HdtNbxCN++TqcRvgNzxvp/bhJV8=', 'RASHID, Idd', 'PROG05', 'Administrator', '', '2019-08-16 14:58:16', '2019-08-16', 'user', 2, 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

CREATE TABLE `sex` (
  `sexid` int(11) NOT NULL,
  `sex` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sitting`
--

CREATE TABLE `sitting` (
  `Id` int(11) NOT NULL,
  `Description` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `SponsorID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `ip` varchar(50) DEFAULT NULL,
  `browser` varchar(200) DEFAULT NULL,
  `received` datetime DEFAULT NULL,
  `page` varchar(50) DEFAULT NULL,
  `ID` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`ip`, `browser`, `received`, `page`, `ID`) VALUES
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:43:55', 'registrar', 1),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:44:40', 'systemadmin - Visited the Administrator Page', 2),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:51:29', 'timetable - Visited the Academic Page', 3),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:51:46', 'systemadmin - Visited the Administrator Page', 4),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:53:42', 'examofficer - Visited the Academic Page', 5),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:53:57', 'systemadmin - Visited the Administrator Page', 6),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:55:13', 'student - Visited the Student Page', 7),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:55:39', 'systemadmin - Visited the Administrator Page', 8),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:57:11', 'admission', 9),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:57:34', 'systemadmin - Visited the Administrator Page', 10),
('::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:68.0) Gecko/20100101 Firefox/68.0', '2019-08-16 14:58:45', 'accommodation - Visited the Accommodation Page', 11);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `AdmissionNo` varchar(30) NOT NULL DEFAULT '',
  `Sex` char(1) NOT NULL DEFAULT '',
  `DBirth` varchar(14) DEFAULT NULL,
  `MannerofEntry` varchar(50) DEFAULT NULL,
  `MaritalStatus` varchar(10) DEFAULT NULL,
  `Campus` varchar(50) DEFAULT NULL,
  `ProgrammeofStudy` int(11) NOT NULL DEFAULT '0',
  `Subject` tinyint(3) NOT NULL DEFAULT '0',
  `Faculty` varchar(50) NOT NULL DEFAULT '',
  `Department` varchar(50) DEFAULT NULL,
  `Sponsor` varchar(50) DEFAULT NULL,
  `GradYear` varchar(20) DEFAULT NULL,
  `EntryYear` varchar(10) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `YearofStudy` smallint(6) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `Photo` varchar(250) DEFAULT 'images/default.gif',
  `IDProcess` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `Region` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `ParentOccupation` varchar(50) DEFAULT NULL,
  `Received` varchar(20) DEFAULT '0000-00-00 00:00:00',
  `user` varchar(200) DEFAULT NULL,
  `display` tinyint(1) DEFAULT NULL,
  `Denomination` varchar(200) NOT NULL DEFAULT '',
  `Religion` varchar(50) NOT NULL DEFAULT '',
  `Disability` varchar(200) NOT NULL DEFAULT '',
  `formfour` varchar(255) NOT NULL,
  `formsix` varchar(255) NOT NULL,
  `diploma` varchar(255) NOT NULL,
  `father` varchar(255) NOT NULL,
  `father_job` varchar(255) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `mother_job` varchar(255) NOT NULL,
  `father_address` varchar(255) NOT NULL,
  `father_phone` varchar(255) NOT NULL,
  `mother_address` varchar(255) NOT NULL,
  `mother_phone` varchar(255) NOT NULL,
  `brother` varchar(255) NOT NULL,
  `brother_phone` varchar(255) NOT NULL,
  `brother_address` varchar(255) NOT NULL,
  `brother_job` varchar(255) NOT NULL,
  `sister` varchar(255) NOT NULL,
  `sister_phone` varchar(255) NOT NULL,
  `sister_address` varchar(255) NOT NULL,
  `sister_job` varchar(255) NOT NULL,
  `spouse` varchar(255) NOT NULL,
  `spouse_phone` varchar(255) NOT NULL,
  `spouse_address` varchar(255) NOT NULL,
  `spouse_job` varchar(255) NOT NULL,
  `kin` varchar(255) NOT NULL,
  `kin_phone` varchar(255) NOT NULL,
  `kin_address` varchar(255) NOT NULL,
  `kin_job` varchar(255) NOT NULL,
  `relative` varchar(255) NOT NULL,
  `relative_phone` varchar(255) NOT NULL,
  `relative_address` varchar(255) NOT NULL,
  `relative_job` varchar(255) NOT NULL,
  `School_attended_from` varchar(255) NOT NULL,
  `School_attended` varchar(255) NOT NULL,
  `School_attended_to` varchar(255) NOT NULL,
  `School_attended_to_olevel` varchar(255) NOT NULL,
  `School_attended_from_olevel` varchar(255) NOT NULL,
  `School_attended_from_alevel` varchar(255) NOT NULL,
  `School_attended_to_alevel` varchar(255) NOT NULL,
  `School_attended_olevel` varchar(255) NOT NULL,
  `School_attended_alevel` varchar(255) NOT NULL,
  `disabilityCategory` varchar(255) DEFAULT NULL,
  `f4year` varchar(255) NOT NULL,
  `f6year` varchar(255) NOT NULL,
  `f7year` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_branch_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `form4no` varchar(255) NOT NULL,
  `form4name` varchar(255) NOT NULL,
  `form6name` varchar(255) NOT NULL,
  `form6no` varchar(255) NOT NULL,
  `form7name` varchar(255) NOT NULL,
  `form7no` varchar(255) NOT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `currentaddaress` varchar(255) NOT NULL,
  `studylevel` varchar(255) NOT NULL,
  `RegNo` varchar(30) NOT NULL,
  `Class` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `before_student_delete` BEFORE DELETE ON `student`
 FOR EACH ROW BEGIN 
INSERT INTO student_audit 
SET action_value = 'delete', 
Id=OLD.Id,
Name=OLD.Name,
AdmissionNo=OLD.AdmissionNo,
Sex=OLD.Sex,
DBirth=OLD.DBirth,
MannerofEntry=OLD.MannerofEntry,
Campus=OLD.Campus,
ProgrammeofStudy=OLD.ProgrammeofStudy,
Subject=OLD.Subject,
Faculty=OLD.Faculty,
Department=OLD.Department,
Sponsor=OLD.Sponsor,
GradYear=OLD.GradYear,
EntryYear=OLD.EntryYear,
Status=OLD.Status,
YearofStudy=OLD.YearofStudy,
Address=OLD.Address,
comment=OLD.comment,
Photo=OLD.Photo,
IDProcess=OLD.IDProcess,
Nationality=OLD.Nationality,
Region=OLD.Region,
District=OLD.District,
Country=OLD.Country,
ParentOccupation=OLD.ParentOccupation,
Received=OLD.Received,
user=OLD.user,
display=OLD.display,
Denomination=OLD.Denomination,
Religion=OLD.Religion,
Disability=OLD.Disability,
formfour=OLD.formfour,
formsix=OLD.formsix,
paddress=OLD.paddress,
Email=OLD.Email,
Phone=OLD.Phone,
studylevel=OLD.studylevel,
RegNo=OLD.RegNo,
Class=OLD.Class,
action_user=OLD.user;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_student_update` BEFORE UPDATE ON `student`
 FOR EACH ROW BEGIN 
INSERT INTO student_audit 
SET action_value = 'update', 
Id=OLD.Id,
Name=OLD.Name,
AdmissionNo=OLD.AdmissionNo,
Sex=OLD.Sex,
DBirth=OLD.DBirth,
MannerofEntry=OLD.MannerofEntry,
Campus=OLD.Campus,
ProgrammeofStudy=OLD.ProgrammeofStudy,
Subject=OLD.Subject,
Faculty=OLD.Faculty,
Department=OLD.Department,
Sponsor=OLD.Sponsor,
GradYear=OLD.GradYear,
EntryYear=OLD.EntryYear,
Status=OLD.Status,
YearofStudy=OLD.YearofStudy,
Address=OLD.Address,
comment=OLD.comment,
Photo=OLD.Photo,
IDProcess=OLD.IDProcess,
Nationality=OLD.Nationality,
Region=OLD.Region,
District=OLD.District,
Country=OLD.Country,
ParentOccupation=OLD.ParentOccupation,
Received=OLD.Received,
user=OLD.user,
display=OLD.display,
Denomination=OLD.Denomination,
Religion=OLD.Religion,
Disability=OLD.Disability,
formfour=OLD.formfour,
formsix=OLD.formsix,
paddress=OLD.paddress,
Email=OLD.Email,
Phone=OLD.Phone,
studylevel=OLD.studylevel,
RegNo=OLD.RegNo,
Class=OLD.Class,
action_user=NEW.user;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `studentlog`
--

CREATE TABLE `studentlog` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `RegNo` varchar(30) NOT NULL,
  `AdmissionNo` varchar(30) NOT NULL DEFAULT '',
  `Sex` char(1) NOT NULL DEFAULT '',
  `DBirth` varchar(14) DEFAULT NULL,
  `MannerofEntry` varchar(50) DEFAULT NULL,
  `MaritalStatus` varchar(10) DEFAULT NULL,
  `Campus` varchar(50) DEFAULT NULL,
  `ProgrammeofStudy` int(11) NOT NULL DEFAULT '0',
  `Subject` tinyint(3) NOT NULL DEFAULT '0',
  `Faculty` varchar(50) NOT NULL DEFAULT '',
  `Department` varchar(50) DEFAULT NULL,
  `Sponsor` varchar(50) DEFAULT NULL,
  `GradYear` varchar(20) DEFAULT NULL,
  `EntryYear` varchar(10) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `YearofStudy` smallint(6) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `Photo` varchar(250) DEFAULT NULL,
  `IDProcess` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `Region` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `ParentOccupation` varchar(50) DEFAULT NULL,
  `Received` varchar(20) DEFAULT '0000-00-00 00:00:00',
  `user` varchar(200) DEFAULT NULL,
  `display` tinyint(1) DEFAULT NULL,
  `Denomination` varchar(200) NOT NULL DEFAULT '',
  `Religion` varchar(50) NOT NULL DEFAULT '',
  `Disability` varchar(200) NOT NULL DEFAULT '',
  `formfour` varchar(255) NOT NULL,
  `formsix` varchar(255) NOT NULL,
  `diploma` varchar(255) NOT NULL,
  `father` varchar(255) NOT NULL,
  `father_job` varchar(255) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `mother_job` varchar(255) NOT NULL,
  `father_address` varchar(255) NOT NULL,
  `father_phone` varchar(255) NOT NULL,
  `mother_address` varchar(255) NOT NULL,
  `mother_phone` varchar(255) NOT NULL,
  `brother` varchar(255) NOT NULL,
  `brother_phone` varchar(255) NOT NULL,
  `brother_address` varchar(255) NOT NULL,
  `brother_job` varchar(255) NOT NULL,
  `sister` varchar(255) NOT NULL,
  `sister_phone` varchar(255) NOT NULL,
  `sister_address` varchar(255) NOT NULL,
  `sister_job` varchar(255) NOT NULL,
  `spouse` varchar(255) NOT NULL,
  `spouse_phone` varchar(255) NOT NULL,
  `spouse_address` varchar(255) NOT NULL,
  `spouse_job` varchar(255) NOT NULL,
  `kin` varchar(255) NOT NULL,
  `kin_phone` varchar(255) NOT NULL,
  `kin_address` varchar(255) NOT NULL,
  `kin_job` varchar(255) NOT NULL,
  `relative` varchar(255) NOT NULL,
  `relative_phone` varchar(255) NOT NULL,
  `relative_address` varchar(255) NOT NULL,
  `relative_job` varchar(255) NOT NULL,
  `School_attended_from` varchar(255) NOT NULL,
  `School_attended` varchar(255) NOT NULL,
  `School_attended_to` varchar(255) NOT NULL,
  `School_attended_to_olevel` varchar(255) NOT NULL,
  `School_attended_from_olevel` varchar(255) NOT NULL,
  `School_attended_from_alevel` varchar(255) NOT NULL,
  `School_attended_to_alevel` varchar(255) NOT NULL,
  `School_attended_olevel` varchar(255) NOT NULL,
  `School_attended_alevel` varchar(255) NOT NULL,
  `disabilityCategory` varchar(255) DEFAULT NULL,
  `f4year` varchar(255) NOT NULL,
  `f6year` varchar(255) NOT NULL,
  `f7year` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `bank_branch_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `form4no` varchar(255) NOT NULL,
  `form4name` varchar(255) NOT NULL,
  `form6name` varchar(255) NOT NULL,
  `form6no` varchar(255) NOT NULL,
  `form7name` varchar(255) NOT NULL,
  `form7no` varchar(255) NOT NULL,
  `paddress` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `currentaddaress` varchar(255) NOT NULL,
  `studylevel` varchar(255) NOT NULL,
  `ActUser` varchar(255) NOT NULL COMMENT 'User Involved',
  `Action` varchar(255) NOT NULL COMMENT 'Action Performed',
  `ActionDate` varchar(255) NOT NULL COMMENT 'Date of Action'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentpayments`
--

CREATE TABLE `studentpayments` (
  `id` int(11) NOT NULL,
  `regno` varchar(30) NOT NULL DEFAULT '',
  `amount` double(11,2) NOT NULL DEFAULT '0.00',
  `feecode` varchar(30) DEFAULT NULL,
  `method` varchar(15) DEFAULT NULL,
  `receipt` varchar(50) DEFAULT NULL,
  `receiptdate` varchar(50) DEFAULT NULL,
  `semester` varchar(15) DEFAULT NULL,
  `aYear` varchar(50) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `user` varchar(30) NOT NULL DEFAULT '',
  `received` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `currency` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studentremark`
--

CREATE TABLE `studentremark` (
  `AYear` varchar(9) NOT NULL DEFAULT '',
  `Semester` varchar(15) NOT NULL DEFAULT '',
  `RegNo` varchar(30) NOT NULL DEFAULT '',
  `Remark` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studentstatus`
--

CREATE TABLE `studentstatus` (
  `StatusID` int(11) NOT NULL,
  `Status` varchar(60) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studentstatusvalue`
--

CREATE TABLE `studentstatusvalue` (
  `StatusID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student_audit`
--

CREATE TABLE `student_audit` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `AdmissionNo` varchar(30) NOT NULL DEFAULT '',
  `Sex` char(1) NOT NULL DEFAULT '',
  `DBirth` varchar(14) DEFAULT NULL,
  `MannerofEntry` varchar(50) DEFAULT NULL,
  `MaritalStatus` varchar(10) DEFAULT NULL,
  `Campus` varchar(50) DEFAULT NULL,
  `ProgrammeofStudy` int(11) NOT NULL DEFAULT '0',
  `Subject` tinyint(3) DEFAULT '0',
  `Faculty` varchar(50) DEFAULT '',
  `Department` varchar(50) DEFAULT NULL,
  `Sponsor` varchar(50) DEFAULT NULL,
  `GradYear` varchar(20) DEFAULT NULL,
  `EntryYear` varchar(10) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `YearofStudy` smallint(6) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `Photo` varchar(250) DEFAULT 'images/default.gif',
  `IDProcess` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `Region` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `ParentOccupation` varchar(50) DEFAULT NULL,
  `Received` varchar(20) DEFAULT '0000-00-00 00:00:00',
  `user` varchar(200) DEFAULT NULL,
  `display` tinyint(1) DEFAULT NULL,
  `Denomination` varchar(200) DEFAULT '',
  `Religion` varchar(50) DEFAULT '',
  `Disability` varchar(200) DEFAULT '',
  `formfour` varchar(255) DEFAULT NULL,
  `formsix` varchar(255) NOT NULL,
  `diploma` varchar(255) NOT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(255) NOT NULL,
  `studylevel` varchar(255) NOT NULL,
  `RegNo` varchar(30) NOT NULL,
  `Class` varchar(30) DEFAULT NULL,
  `action_user` varchar(30) NOT NULL,
  `action_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action_value` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `studylevel`
--

CREATE TABLE `studylevel` (
  `LevelCode` int(11) NOT NULL,
  `LevelName` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ProgrammeCode` int(11) NOT NULL DEFAULT '100'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjectcombination`
--

CREATE TABLE `subjectcombination` (
  `SubjectID` tinyint(3) NOT NULL DEFAULT '0',
  `SubjectName` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject_olevel`
--

CREATE TABLE `subject_olevel` (
  `Id` int(11) NOT NULL,
  `subjectID` varchar(255) NOT NULL,
  `subjectName` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(11) NOT NULL,
  `received` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fromid` varchar(30) NOT NULL DEFAULT '',
  `toid` varchar(30) NOT NULL DEFAULT '',
  `message` text,
  `replied` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcautionfee`
--

CREATE TABLE `tblcautionfee` (
  `ID` int(11) NOT NULL,
  `RegNo` varchar(30) DEFAULT NULL,
  `Paytype` int(11) NOT NULL DEFAULT '1',
  `Amount` int(11) NOT NULL DEFAULT '0',
  `ReceiptNo` int(50) NOT NULL DEFAULT '0',
  `ReceiptDate` date DEFAULT NULL,
  `user` varchar(250) NOT NULL DEFAULT '',
  `Description` varchar(250) NOT NULL DEFAULT '',
  `Received` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbllecturenotes`
--

CREATE TABLE `tbllecturenotes` (
  `id` int(11) NOT NULL,
  `coursecode` varchar(30) NOT NULL DEFAULT '',
  `notes` text,
  `received` date DEFAULT NULL,
  `filename` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `teachingtype`
--

CREATE TABLE `teachingtype` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `Code` varchar(9) NOT NULL,
  `Name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `Id` varchar(4) DEFAULT NULL,
  `Semester` varchar(15) NOT NULL DEFAULT '0',
  `Description` varchar(50) DEFAULT NULL,
  `NumberofDays` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `AYear` varchar(20) NOT NULL,
  `Programme` varchar(20) NOT NULL,
  `timetable_category` int(11) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `start_end` int(11) NOT NULL,
  `venue` varchar(30) NOT NULL,
  `lecturer` varchar(50) NOT NULL,
  `Recorder` varchar(20) NOT NULL,
  `day` int(11) NOT NULL,
  `teachingtype` int(11) NOT NULL,
  `YoS` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `timetableCategory`
--

CREATE TABLE `timetableCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transcriptcount`
--

CREATE TABLE `transcriptcount` (
  `id` int(11) NOT NULL,
  `RegNo` varchar(20) DEFAULT NULL,
  `received` datetime DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `Id` int(10) NOT NULL,
  `VenueCode` varchar(100) NOT NULL DEFAULT '',
  `VenueName` varchar(100) NOT NULL DEFAULT '',
  `VenueLocation` varchar(100) NOT NULL DEFAULT '',
  `VenueCapacity` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academicyear`
--
ALTER TABLE `academicyear`
  ADD PRIMARY KEY (`intYearID`);

--
-- Indexes for table `allocation`
--
ALTER TABLE `allocation`
  ADD PRIMARY KEY (`RegNo`,`AYear`);

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `campus`
--
ALTER TABLE `campus`
  ADD PRIMARY KEY (`CampusID`);

--
-- Indexes for table `classstream`
--
ALTER TABLE `classstream`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`intCountryID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`Id`,`CourseCode`),
  ADD KEY `coursecode` (`CourseCode`);

--
-- Indexes for table `coursecandidate`
--
ALTER TABLE `coursecandidate`
  ADD PRIMARY KEY (`RegNo`,`CourseCode`);

--
-- Indexes for table `coursecontrol`
--
ALTER TABLE `coursecontrol`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `coursecountprogramme`
--
ALTER TABLE `coursecountprogramme`
  ADD PRIMARY KEY (`ProgrammeID`,`Semester`,`YearofStudy`);

--
-- Indexes for table `courseoption`
--
ALTER TABLE `courseoption`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `courseprogramme`
--
ALTER TABLE `courseprogramme`
  ADD PRIMARY KEY (`ProgrammeID`,`CourseCode`,`AYear`);

--
-- Indexes for table `coursestatus`
--
ALTER TABLE `coursestatus`
  ADD PRIMARY KEY (`StatusCode`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`CriteriaID`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `denomination`
--
ALTER TABLE `denomination`
  ADD PRIMARY KEY (`denominationId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DeptID`),
  ADD KEY `deptname_faculty` (`DeptName`,`Faculty`);

--
-- Indexes for table `disability`
--
ALTER TABLE `disability`
  ADD PRIMARY KEY (`DisabilityCode`);

--
-- Indexes for table `disability3`
--
ALTER TABLE `disability3`
  ADD PRIMARY KEY (`DisabilityID`);

--
-- Indexes for table `disabilitycategory`
--
ALTER TABLE `disabilitycategory`
  ADD PRIMARY KEY (`DisabilityCategoryId`),
  ADD KEY `DisabilityCode` (`DisabilityCode`);

--
-- Indexes for table `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`docId`);

--
-- Indexes for table `electioncandidate`
--
ALTER TABLE `electioncandidate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `RegNo` (`RegNo`,`Period`);

--
-- Indexes for table `electiondate`
--
ALTER TABLE `electiondate`
  ADD PRIMARY KEY (`PostId`,`Period`);

--
-- Indexes for table `electionpost`
--
ALTER TABLE `electionpost`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `electionvotes`
--
ALTER TABLE `electionvotes`
  ADD PRIMARY KEY (`RegNo`,`CandidateID`,`Period`);

--
-- Indexes for table `examcategory`
--
ALTER TABLE `examcategory`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `exammarker`
--
ALTER TABLE `exammarker`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `examnumber_`
--
ALTER TABLE `examnumber_`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_0`
--
ALTER TABLE `examnumber_0`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_10`
--
ALTER TABLE `examnumber_10`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_11`
--
ALTER TABLE `examnumber_11`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_12`
--
ALTER TABLE `examnumber_12`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_13`
--
ALTER TABLE `examnumber_13`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_14`
--
ALTER TABLE `examnumber_14`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_16`
--
ALTER TABLE `examnumber_16`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_17`
--
ALTER TABLE `examnumber_17`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_18`
--
ALTER TABLE `examnumber_18`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_19`
--
ALTER TABLE `examnumber_19`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_20`
--
ALTER TABLE `examnumber_20`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_21`
--
ALTER TABLE `examnumber_21`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_22`
--
ALTER TABLE `examnumber_22`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_23`
--
ALTER TABLE `examnumber_23`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_24`
--
ALTER TABLE `examnumber_24`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_25`
--
ALTER TABLE `examnumber_25`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_26`
--
ALTER TABLE `examnumber_26`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_27`
--
ALTER TABLE `examnumber_27`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_28`
--
ALTER TABLE `examnumber_28`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_29`
--
ALTER TABLE `examnumber_29`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_30`
--
ALTER TABLE `examnumber_30`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_31`
--
ALTER TABLE `examnumber_31`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_32`
--
ALTER TABLE `examnumber_32`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_33`
--
ALTER TABLE `examnumber_33`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_34`
--
ALTER TABLE `examnumber_34`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_35`
--
ALTER TABLE `examnumber_35`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_36`
--
ALTER TABLE `examnumber_36`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_37`
--
ALTER TABLE `examnumber_37`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_38`
--
ALTER TABLE `examnumber_38`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_39`
--
ALTER TABLE `examnumber_39`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_40`
--
ALTER TABLE `examnumber_40`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_41`
--
ALTER TABLE `examnumber_41`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_42`
--
ALTER TABLE `examnumber_42`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_43`
--
ALTER TABLE `examnumber_43`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_44`
--
ALTER TABLE `examnumber_44`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_AC`
--
ALTER TABLE `examnumber_AC`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_BA`
--
ALTER TABLE `examnumber_BA`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_COD`
--
ALTER TABLE `examnumber_COD`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_ed`
--
ALTER TABLE `examnumber_ed`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_EGH`
--
ALTER TABLE `examnumber_EGH`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_EKE`
--
ALTER TABLE `examnumber_EKE`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_eod`
--
ALTER TABLE `examnumber_eod`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_gd`
--
ALTER TABLE `examnumber_gd`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_gi`
--
ALTER TABLE `examnumber_gi`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_HRM`
--
ALTER TABLE `examnumber_HRM`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_ICT`
--
ALTER TABLE `examnumber_ICT`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_MSD`
--
ALTER TABLE `examnumber_MSD`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_nil`
--
ALTER TABLE `examnumber_nil`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_pmsd`
--
ALTER TABLE `examnumber_pmsd`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_PRO`
--
ALTER TABLE `examnumber_PRO`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_REC`
--
ALTER TABLE `examnumber_REC`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_repeated`
--
ALTER TABLE `examnumber_repeated`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_ss`
--
ALTER TABLE `examnumber_ss`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examnumber_yw`
--
ALTER TABLE `examnumber_yw`
  ADD PRIMARY KEY (`RegNo`),
  ADD UNIQUE KEY `ExamNo` (`ExamNo`);

--
-- Indexes for table `examregister`
--
ALTER TABLE `examregister`
  ADD PRIMARY KEY (`AYear`,`CourseCode`,`RegNo`),
  ADD KEY `RegNo` (`RegNo`);

--
-- Indexes for table `examregisterlecturer`
--
ALTER TABLE `examregisterlecturer`
  ADD PRIMARY KEY (`AYear`,`CourseCode`,`RegNo`,`PCode`,`StartTime`),
  ADD KEY `PCode` (`PCode`);

--
-- Indexes for table `examremark`
--
ALTER TABLE `examremark`
  ADD PRIMARY KEY (`Remark`);

--
-- Indexes for table `examresult`
--
ALTER TABLE `examresult`
  ADD PRIMARY KEY (`AYear`,`CourseCode`,`ExamCategory`,`ExamSitting`,`RegNo`),
  ADD KEY `RegNo` (`RegNo`);

--
-- Indexes for table `examresult_audit`
--
ALTER TABLE `examresult_audit`
  ADD KEY `RegNo` (`RegNo`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FacultyID`);

--
-- Indexes for table `feecombination`
--
ALTER TABLE `feecombination`
  ADD PRIMARY KEY (`feestructure`,`feecode`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feesrates`
--
ALTER TABLE `feesrates`
  ADD PRIMARY KEY (`ayear`,`feecode`,`programmecode`,`sponsor`);

--
-- Indexes for table `feestructure`
--
ALTER TABLE `feestructure`
  ADD PRIMARY KEY (`StructureID`,`StructureName`);

--
-- Indexes for table `gradescale`
--
ALTER TABLE `gradescale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gradyears`
--
ALTER TABLE `gradyears`
  ADD PRIMARY KEY (`YearID`);

--
-- Indexes for table `hostel`
--
ALTER TABLE `hostel`
  ADD PRIMARY KEY (`HID`);

--
-- Indexes for table `mannerofentry`
--
ALTER TABLE `mannerofentry`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `maritalstatus`
--
ALTER TABLE `maritalstatus`
  ADD PRIMARY KEY (`intStatusID`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`moduleid`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `olevel_results`
--
ALTER TABLE `olevel_results`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `subjectID` (`subjectID`);

--
-- Indexes for table `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`privilegeID`);

--
-- Indexes for table `programme`
--
ALTER TABLE `programme`
  ADD PRIMARY KEY (`ProgrammeID`),
  ADD UNIQUE KEY `ProgrammeCode` (`ProgrammeCode`);

--
-- Indexes for table `programmelevel`
--
ALTER TABLE `programmelevel`
  ADD PRIMARY KEY (`Code`);

--
-- Indexes for table `religion`
--
ALTER TABLE `religion`
  ADD PRIMARY KEY (`ReligionID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`RNumber`,`HID`);

--
-- Indexes for table `roomapplication`
--
ALTER TABLE `roomapplication`
  ADD PRIMARY KEY (`RegNo`,`AppYear`);

--
-- Indexes for table `security`
--
ALTER TABLE `security`
  ADD PRIMARY KEY (`UserName`);

--
-- Indexes for table `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`sexid`);

--
-- Indexes for table `sitting`
--
ALTER TABLE `sitting`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`SponsorID`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `regno_name_degree` (`AdmissionNo`),
  ADD KEY `name_degree` (`AdmissionNo`,`Name`,`ProgrammeofStudy`);

--
-- Indexes for table `studentlog`
--
ALTER TABLE `studentlog`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `regno_name_degree` (`RegNo`),
  ADD KEY `name_degree` (`RegNo`,`Name`,`ProgrammeofStudy`);

--
-- Indexes for table `studentpayments`
--
ALTER TABLE `studentpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentremark`
--
ALTER TABLE `studentremark`
  ADD PRIMARY KEY (`AYear`,`Semester`,`RegNo`);

--
-- Indexes for table `studentstatus`
--
ALTER TABLE `studentstatus`
  ADD PRIMARY KEY (`StatusID`);

--
-- Indexes for table `studentstatusvalue`
--
ALTER TABLE `studentstatusvalue`
  ADD PRIMARY KEY (`StatusID`);

--
-- Indexes for table `student_audit`
--
ALTER TABLE `student_audit`
  ADD KEY `regno_name_degree` (`AdmissionNo`),
  ADD KEY `name_degree` (`AdmissionNo`,`Name`,`ProgrammeofStudy`);

--
-- Indexes for table `studylevel`
--
ALTER TABLE `studylevel`
  ADD PRIMARY KEY (`LevelCode`);

--
-- Indexes for table `subjectcombination`
--
ALTER TABLE `subjectcombination`
  ADD PRIMARY KEY (`SubjectID`,`SubjectName`);

--
-- Indexes for table `subject_olevel`
--
ALTER TABLE `subject_olevel`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcautionfee`
--
ALTER TABLE `tblcautionfee`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `regno` (`RegNo`);

--
-- Indexes for table `tbllecturenotes`
--
ALTER TABLE `tbllecturenotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachingtype`
--
ALTER TABLE `teachingtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`Code`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`Semester`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetableCategory`
--
ALTER TABLE `timetableCategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transcriptcount`
--
ALTER TABLE `transcriptcount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `VenueCode` (`VenueCode`),
  ADD UNIQUE KEY `VenueName` (`VenueName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academicyear`
--
ALTER TABLE `academicyear`
  MODIFY `intYearID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `Id` tinyint(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `campus`
--
ALTER TABLE `campus`
  MODIFY `CampusID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `classstream`
--
ALTER TABLE `classstream`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `intCountryID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coursecontrol`
--
ALTER TABLE `coursecontrol`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `courseoption`
--
ALTER TABLE `courseoption`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `CriteriaID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `denomination`
--
ALTER TABLE `denomination`
  MODIFY `denominationId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `DeptID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disability3`
--
ALTER TABLE `disability3`
  MODIFY `DisabilityID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `disabilitycategory`
--
ALTER TABLE `disabilitycategory`
  MODIFY `DisabilityCategoryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `docs`
--
ALTER TABLE `docs`
  MODIFY `docId` int(50) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `electioncandidate`
--
ALTER TABLE `electioncandidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `electionpost`
--
ALTER TABLE `electionpost`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `examcategory`
--
ALTER TABLE `examcategory`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exammarker`
--
ALTER TABLE `exammarker`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `FacultyID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gradyears`
--
ALTER TABLE `gradyears`
  MODIFY `YearID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mannerofentry`
--
ALTER TABLE `mannerofentry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `maritalstatus`
--
ALTER TABLE `maritalstatus`
  MODIFY `intStatusID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `moduleid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `olevel_results`
--
ALTER TABLE `olevel_results`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organisation`
--
ALTER TABLE `organisation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `privilegeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `programme`
--
ALTER TABLE `programme`
  MODIFY `ProgrammeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `religion`
--
ALTER TABLE `religion`
  MODIFY `ReligionID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sex`
--
ALTER TABLE `sex`
  MODIFY `sexid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sitting`
--
ALTER TABLE `sitting`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `SponsorID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studentlog`
--
ALTER TABLE `studentlog`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studentpayments`
--
ALTER TABLE `studentpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studentstatus`
--
ALTER TABLE `studentstatus`
  MODIFY `StatusID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studentstatusvalue`
--
ALTER TABLE `studentstatusvalue`
  MODIFY `StatusID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `studylevel`
--
ALTER TABLE `studylevel`
  MODIFY `LevelCode` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject_olevel`
--
ALTER TABLE `subject_olevel`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblcautionfee`
--
ALTER TABLE `tblcautionfee`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbllecturenotes`
--
ALTER TABLE `tbllecturenotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `teachingtype`
--
ALTER TABLE `teachingtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `timetableCategory`
--
ALTER TABLE `timetableCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transcriptcount`
--
ALTER TABLE `transcriptcount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
