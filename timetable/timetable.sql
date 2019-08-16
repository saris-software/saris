CREATE TABLE IF NOT EXISTS `timetable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;




CREATE TABLE IF NOT EXISTS `venue` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `VenueCode` varchar(100) NOT NULL DEFAULT '',
  `VenueName` varchar(100) NOT NULL DEFAULT '',
  `VenueLocation` varchar(100) NOT NULL DEFAULT '',
  `VenueCapacity` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `VenueCode` (`VenueCode`),
  UNIQUE KEY `VenueName` (`VenueName`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `timetableCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

INSERT INTO `timetableCategory` (`id`, `name`) VALUES
(1, 'Semester I'),
(2, 'SemesterII'),
(3, 'SemesterI Examination'),
(4, 'SemesterII Examination'),
(5, 'Supp/Special Exam');


CREATE TABLE IF NOT EXISTS `days` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday');




