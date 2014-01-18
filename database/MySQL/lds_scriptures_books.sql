-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2014 at 07:23 PM
-- Server version: 5.5.30-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mackle2_LDS`
--

-- --------------------------------------------------------

--
-- Table structure for table `lds_scriptures_books`
--

CREATE TABLE IF NOT EXISTS `lds_scriptures_books` (
  `language` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `book_id` smallint(2) NOT NULL DEFAULT '0',
  `volume_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `volume_title` tinytext NOT NULL,
  `version` tinytext NOT NULL,
  `book_title` tinytext NOT NULL,
  `book_title_long` tinytext NOT NULL,
  `book_title_short` tinytext NOT NULL,
  `book_title_jst` tinyblob NOT NULL,
  `book_subtitle` tinytext NOT NULL,
  `lds_org` varchar(6) NOT NULL DEFAULT '',
  `num_chapters` smallint(3) unsigned NOT NULL DEFAULT '0',
  `num_verses` smallint(4) unsigned NOT NULL DEFAULT '0',
  KEY `language` (`language`(20))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lds_scriptures_books`
--

INSERT INTO `lds_scriptures_books` (`language`, `book_id`, `volume_id`, `volume_title`, `version`, `book_title`, `book_title_long`, `book_title_short`, `book_title_jst`, `book_subtitle`, `lds_org`, `num_chapters`, `num_verses`) VALUES
('english', 1, 1, 'Old Testament', 'KJV', 'Genesis', 'The First Book of Moses called Genesis', 'Gen.', '', '', 'gen', 50, 1533),
('english', 2, 1, 'Old Testament', 'KJV', 'Exodus', 'The Second Book of Moses called Exodus', 'Ex.', '', '', 'ex', 40, 1213),
('english', 3, 1, 'Old Testament', 'KJV', 'Leviticus', 'The Third Book of Moses called Leviticus', 'Lev.', '', '', 'lev', 27, 859),
('english', 4, 1, 'Old Testament', 'KJV', 'Numbers', 'The Fourth Book of Moses called Numbers', 'Num.', '', '', 'num', 36, 1288),
('english', 5, 1, 'Old Testament', 'KJV', 'Deuteronomy', 'The Fifth Book of Moses called Deuteronomy', 'Deut.', '', '', 'deut', 34, 959),
('english', 6, 1, 'Old Testament', 'KJV', 'Joshua', 'The Book of Joshua', 'Josh.', '', '', 'josh', 24, 658),
('english', 7, 1, 'Old Testament', 'KJV', 'Judges', 'The Book of Judges', 'Judg.', '', '', 'judg', 21, 618),
('english', 8, 1, 'Old Testament', 'KJV', 'Ruth', 'The Book of Ruth', 'Ruth', '', '', 'ruth', 4, 85),
('english', 9, 1, 'Old Testament', 'KJV', '1 Samuel', 'The First Book of Samuel', '1 Sam.', '', 'Otherwise called the First Book of the Kings', '1_sam', 31, 810),
('english', 10, 1, 'Old Testament', 'KJV', '2 Samuel', 'The Second Book of Samuel', '2 Sam.', '', 'Otherwise called the Second Book of the Kings', '2_sam', 24, 695),
('english', 11, 1, 'Old Testament', 'KJV', '1 Kings', 'The First Book of the Kings', '1 Kgs.', '', 'Commonly called the Third Book of the Kings', '1_kgs', 22, 816),
('english', 12, 1, 'Old Testament', 'KJV', '2 Kings', 'The Second Book of the King', '2 Kgs.', '', 'Commonly called the Fourth Book of the Kings', '2_kgs', 25, 719),
('english', 13, 1, 'Old Testament', 'KJV', '1 Chronicles', 'The First Book of the Chronicles', '1 Chr.', '', '', '1_chr', 29, 942),
('english', 14, 1, 'Old Testament', 'KJV', '2 Chronicles', 'The Second Book of the Chronicles', '2 Chr.', '', '', '2_chr', 36, 822),
('english', 15, 1, 'Old Testament', 'KJV', 'Ezra', 'Ezra', 'Ezra', '', '', 'ezra', 10, 280),
('english', 16, 1, 'Old Testament', 'KJV', 'Nehemiah', 'The Book of Nehemiah', 'Neh.', '', '', 'neh', 13, 406),
('english', 17, 1, 'Old Testament', 'KJV', 'Esther', 'The Book of Esther', 'Esth.', '', '', 'esth', 10, 167),
('english', 18, 1, 'Old Testament', 'KJV', 'Job', 'The Book of Job', 'Job', '', '', 'job', 42, 1070),
('english', 19, 1, 'Old Testament', 'KJV', 'Psalms', 'The Book of Psalms', 'Ps.', '', '', 'ps', 150, 2461),
('english', 20, 1, 'Old Testament', 'KJV', 'Proverbs', 'The Proverbs', 'Prov.', '', '', 'prov', 31, 915),
('english', 21, 1, 'Old Testament', 'KJV', 'Ecclesiastes', 'Ecclesiastes or, The Preacher', 'Eccl.', '', '', 'eccl', 12, 222),
('english', 22, 1, 'Old Testament', 'KJV', 'Solomon''s Song', 'The Song of Solomon', 'Song.', '', '', 'song', 8, 117),
('english', 23, 1, 'Old Testament', 'KJV', 'Isaiah', 'The Book of the Prophet Isaiah', 'Isa.', '', '', 'isa', 66, 1292),
('english', 24, 1, 'Old Testament', 'KJV', 'Jeremiah', 'The Book of the Prophet Jeremiah', 'Jer.', '', '', 'jer', 52, 1364),
('english', 25, 1, 'Old Testament', 'KJV', 'Lamentations', 'The Lamentations of Jeremiah', 'Lam.', '', '', 'lam', 5, 154),
('english', 26, 1, 'Old Testament', 'KJV', 'Ezekiel', 'The Book of the Prophet Ezekiel', 'Ezek.', '', '', 'ezek', 48, 1273),
('english', 27, 1, 'Old Testament', 'KJV', 'Daniel', 'The Book of Daniel', 'Dan.', '', '', 'dan', 12, 357),
('english', 28, 1, 'Old Testament', 'KJV', 'Hosea', 'Hosea', 'Hosea', '', '', 'hosea', 14, 197),
('english', 29, 1, 'Old Testament', 'KJV', 'Joel', 'Joel', 'Joel', '', '', 'joel', 3, 73),
('english', 30, 1, 'Old Testament', 'KJV', 'Amos', 'Amos', 'Amos', '', '', 'amos', 9, 146),
('english', 31, 1, 'Old Testament', 'KJV', 'Obadiah', 'Obadiah', 'Obad.', '', '', 'obad', 1, 21),
('english', 32, 1, 'Old Testament', 'KJV', 'Jonah', 'Jonah', 'Jonah', '', '', 'jonah', 4, 48),
('english', 33, 1, 'Old Testament', 'KJV', 'Micah', 'Micah', 'Micah', '', '', 'micah', 7, 105),
('english', 34, 1, 'Old Testament', 'KJV', 'Nahum', 'Nahum', 'Nahum', '', '', 'nahum', 3, 47),
('english', 35, 1, 'Old Testament', 'KJV', 'Habakkuk', 'Habakkuk', 'Hab.', '', '', 'hab', 3, 56),
('english', 36, 1, 'Old Testament', 'KJV', 'Zephaniah', 'Zephaniah', 'Zeph.', '', '', 'zeph', 3, 53),
('english', 37, 1, 'Old Testament', 'KJV', 'Haggai', 'Haggai', 'Hag.', '', '', 'hag', 2, 38),
('english', 38, 1, 'Old Testament', 'KJV', 'Zechariah', 'Zechariah', 'Zech.', '', '', 'zech', 14, 211),
('english', 39, 1, 'Old Testament', 'KJV', 'Malachi', 'Malachi', 'Mal.', '', '', 'mal', 4, 55),
('english', 1, 2, 'New Testament', 'KJV', 'Matthew', 'The Gospel According to St Matthew', 'Matt.', 0x5468652054657374696d6f6e79206f66205374204d617474686577, '', 'matt', 28, 1071),
('english', 2, 2, 'New Testament', 'KJV', 'Mark', 'The Gospel According to St Mark', 'Mark', 0x5468652054657374696d6f6e79206f66205374204d61726b, '', 'mark', 16, 678),
('english', 3, 2, 'New Testament', 'KJV', 'Luke', 'The Gospel According to St Luke', 'Luke', 0x5468652054657374696d6f6e79206f66205374204c756b65, '', 'luke', 24, 1151),
('english', 4, 2, 'New Testament', 'KJV', 'John', 'The Gospel According to St John', 'John', 0x5468652054657374696d6f6e79206f66205374204a6f686e, '', 'john', 21, 879),
('english', 5, 2, 'New Testament', 'KJV', 'Acts', 'The Acts of the Apostles', 'Acts', '', '', 'acts', 28, 1007),
('english', 6, 2, 'New Testament', 'KJV', 'Romans', 'The Epistle of Paul the Apostle to the Romans', 'Rom.', '', '', 'rom', 16, 433),
('english', 7, 2, 'New Testament', 'KJV', '1 Corinthians', 'The First Epistle of Paul the Apostle to the Corinthians', '1 Cor.', '', '', '1_cor', 16, 437),
('english', 8, 2, 'New Testament', 'KJV', '2 Corinthians', 'The Second Epistle of Paul the Apostle to the Corinthians', '2 Cor.', '', '', '2_cor', 13, 257),
('english', 9, 2, 'New Testament', 'KJV', 'Galatians', 'The Epistle of Paul the Apostle to the Galatians', 'Gal.', '', '', 'gal', 6, 149),
('english', 10, 2, 'New Testament', 'KJV', 'Ephesians', 'The Epistle of Paul the Apostle to the Ephesians', 'Eph.', '', '', 'eph', 6, 155),
('english', 11, 2, 'New Testament', 'KJV', 'Philippians', 'The Epistle of Paul the Apostle to the Philippians', 'Philip.', '', '', 'philip', 4, 104),
('english', 12, 2, 'New Testament', 'KJV', 'Colossians', 'The Epistle of Paul the Apostle to the Colossians', 'Col.', '', '', 'col', 4, 95),
('english', 13, 2, 'New Testament', 'KJV', '1 Thessalonians', 'The First Epistle of Paul the Apostle to the Thessalonians', '1 Thes.', '', '', '1_thes', 5, 89),
('english', 14, 2, 'New Testament', 'KJV', '2 Thessalonians', 'The Second Epistle of Paul the Apostle to the Thessalonians', '2 Thes.', '', '', '2_thes', 3, 47),
('english', 15, 2, 'New Testament', 'KJV', '1 Timothy', 'The First Epistle of Paul the Apostle to Timothy', '1 Tim.', '', '', '1_tim', 6, 113),
('english', 16, 2, 'New Testament', 'KJV', '2 Timothy', 'The Second Epistle of Paul the Apostle to Timothy', '2 Tim.', '', '', '2_tim', 4, 83),
('english', 17, 2, 'New Testament', 'KJV', 'Titus', 'The Epistle of Paul to Titus', 'Titus', '', '', 'titus', 3, 46),
('english', 18, 2, 'New Testament', 'KJV', 'Philemon', 'The Epistle of Paul to Philemon', 'Philem.', '', '', 'philem', 1, 25),
('english', 19, 2, 'New Testament', 'KJV', 'Hebrews', 'The Epistle of Paul to the Hebrews', 'Heb.', '', '', 'heb', 13, 303),
('english', 20, 2, 'New Testament', 'KJV', 'James', 'The General Epistle of James', 'James', '', '', 'james', 5, 108),
('english', 21, 2, 'New Testament', 'KJV', '1 Peter', 'The First Epistle General of Peter', '1 Pet.', '', '', '1_pet', 5, 105),
('english', 22, 2, 'New Testament', 'KJV', '2 Peter', 'The Second Epistle General of Peter', '2 Pet.', '', '', '2_pet', 3, 61),
('english', 23, 2, 'New Testament', 'KJV', '1 John', 'The First Epistle General of John', '1 Jn.', '', '', '1_jn', 5, 105),
('english', 24, 2, 'New Testament', 'KJV', '2 John', 'The Second Epistle of John', '2 Jn.', '', '', '2_jn', 1, 13),
('english', 25, 2, 'New Testament', 'KJV', '3 John', 'The Third Epistle of John', '3 Jn.', '', '', '3_jn', 1, 14),
('english', 26, 2, 'New Testament', 'KJV', 'Jude', 'The General Epistle of Jude', 'Jude', '', '', 'jude', 1, 25),
('english', 27, 2, 'New Testament', 'KJV', 'Revelation', 'The Revelation of St John the Divine', 'Rev.', '', '', 'rev', 22, 404),
('english', 1, 3, 'Book of Mormon', 'LDS', '1 Nephi', 'The First Book of Nephi', '1 Ne.', '', 'His Reign and Ministry', '1_ne', 22, 618),
('english', 2, 3, 'Book of Mormon', 'LDS', '2 Nephi', 'The Second Book of Nephi', '2 Ne.', '', '', '2_ne', 33, 779),
('english', 3, 3, 'Book of Mormon', 'LDS', 'Jacob', 'The Book of Jacob', 'Jacob', '', 'The Brother of Nephi', 'jacob', 7, 203),
('english', 4, 3, 'Book of Mormon', 'LDS', 'Enos', 'The Book of Enos', 'Enos', '', '', 'enos', 1, 27),
('english', 5, 3, 'Book of Mormon', 'LDS', 'Jarom', 'The Book of Jarom', 'Jarom', '', '', 'jarom', 1, 15),
('english', 6, 3, 'Book of Mormon', 'LDS', 'Omni', 'The Book of Omni', 'Omni', '', '', 'omni', 1, 30),
('english', 7, 3, 'Book of Mormon', 'LDS', 'Words of Mormon', 'Words of Mormon', 'W of M', '', '', 'w_of_m', 1, 18),
('english', 8, 3, 'Book of Mormon', 'LDS', 'Mosiah', 'The Book of Mosiah', 'Mosiah', '', '', 'mosiah', 29, 785),
('english', 9, 3, 'Book of Mormon', 'LDS', 'Alma', 'The Book of Alma', 'Alma', '', 'The Son of Alma', 'alma', 63, 1975),
('english', 10, 3, 'Book of Mormon', 'LDS', 'Helaman', 'The Book of Helaman', 'Hel.', '', '', 'hel', 16, 497),
('english', 11, 3, 'Book of Mormon', 'LDS', '3 Nephi', 'The Third Book of Nephi', '3 Ne.', '', 'The Book of Nephi  The Son of Nephi, who was the Son of Helaman', '3_ne', 30, 785),
('english', 12, 3, 'Book of Mormon', 'LDS', '4 Nephi', 'The Fourth Book of Nephi', '4 Ne.', '', 'The Book of Nephi  Who is the son of Nephi, one of the disciples of Jesus Christ', '4_ne', 1, 49),
('english', 13, 3, 'Book of Mormon', 'LDS', 'Mormon', 'The Book of Mormon', 'Morm.', '', '', 'morm', 9, 227),
('english', 14, 3, 'Book of Mormon', 'LDS', 'Ether', 'The Book of Ether', 'Ether', '', '', 'ether', 15, 433),
('english', 15, 3, 'Book of Mormon', 'LDS', 'Moroni', 'The Book of Moroni', 'Moro.', '', '', 'moro', 10, 163),
('english', 1, 4, 'Doctrine and Covenants', 'LDS', 'Section 1', 'Section 1', 'D&C 1', '', 'of the Church of Jesus Christ of Latter-day Saints', 'dc', 1, 0),
('english', 1, 5, 'Pearl of Great Price', 'LDS', 'Moses', 'Selections from the Book of Moses', 'Moses', '', '', 'moses', 8, 356),
('english', 2, 5, 'Pearl of Great Price', 'LDS', 'Abraham', 'The Book of Abraham', 'Abr.', '', 'Translated from the papyrus, by Joseph Smith', 'abr', 5, 136),
('english', 3, 5, 'Pearl of Great Price', 'LDS', 'Joseph Smith--Matthew', 'Joseph Smith--Matthew', 'JS-M', '', '', 'js_m', 1, 55),
('english', 4, 5, 'Pearl of Great Price', 'LDS', 'Joseph Smith--History', 'Joseph Smith--History', 'JS-H', '', 'Extracts from The History of Joseph Smith, the Prophet', 'js_h', 2, 75),
('english', 5, 5, 'Pearl of Great Price', 'LDS', 'Articles of Faith', 'The Articles of Faith', 'A of F', '', 'Of The Church of Jesus Christ of Latter-day Saints', 'a_of_f', 1, 13),
('english', 2, 4, 'Doctrine and Covenants', 'LDS', 'Section 2', 'Section 2', 'D&C 2', '', '', 'dc', 1, 0),
('english', 3, 4, 'Doctrine and Covenants', 'LDS', 'Section 3', 'Section 3', 'D&C 3', '', '', 'dc', 1, 0),
('english', 4, 4, 'Doctrine and Covenants', 'LDS', 'Section 4', 'Section 4', 'D&C 4', '', '', 'dc', 1, 0),
('english', 5, 4, 'Doctrine and Covenants', 'LDS', 'Section 5', 'Section 5', 'D&C 5', '', '', 'dc', 1, 0),
('english', 6, 4, 'Doctrine and Covenants', 'LDS', 'Section 6', 'Section 6', 'D&C 6', '', '', 'dc', 1, 0),
('english', 7, 4, 'Doctrine and Covenants', 'LDS', 'Section 7', 'Section 7', 'D&C 7', '', '', 'dc', 1, 0),
('english', 8, 4, 'Doctrine and Covenants', 'LDS', 'Section 8', 'Section 8', 'D&C 8', '', '', 'dc', 1, 0),
('english', 9, 4, 'Doctrine and Covenants', 'LDS', 'Section 9', 'Section 9', 'D&C 9', '', '', 'dc', 1, 0),
('english', 10, 4, 'Doctrine and Covenants', 'LDS', 'Section 10', 'Section 10', 'D&C 10', '', '', 'dc', 1, 0),
('english', 11, 4, 'Doctrine and Covenants', 'LDS', 'Section 11', 'Section 11', 'D&C 11', '', '', 'dc', 1, 0),
('english', 12, 4, 'Doctrine and Covenants', 'LDS', 'Section 12', 'Section 12', 'D&C 12', '', '', 'dc', 1, 0),
('english', 13, 4, 'Doctrine and Covenants', 'LDS', 'Section 13', 'Section 13', 'D&C 13', '', '', 'dc', 1, 0),
('english', 14, 4, 'Doctrine and Covenants', 'LDS', 'Section 14', 'Section 14', 'D&C 14', '', '', 'dc', 1, 0),
('english', 15, 4, 'Doctrine and Covenants', 'LDS', 'Section 15', 'Section 15', 'D&C 15', '', '', 'dc', 1, 0),
('english', 16, 4, 'Doctrine and Covenants', 'LDS', 'Section 16', 'Section 16', 'D&C 16', '', '', 'dc', 1, 0),
('english', 17, 4, 'Doctrine and Covenants', 'LDS', 'Section 17', 'Section 17', 'D&C 17', '', '', 'dc', 1, 0),
('english', 18, 4, 'Doctrine and Covenants', 'LDS', 'Section 18', 'Section 18', 'D&C 18', '', '', 'dc', 1, 0),
('english', 19, 4, 'Doctrine and Covenants', 'LDS', 'Section 19', 'Section 19', 'D&C 19', '', '', 'dc', 1, 0),
('english', 20, 4, 'Doctrine and Covenants', 'LDS', 'Section 20', 'Section 20', 'D&C 20', '', '', 'dc', 1, 0),
('english', 21, 4, 'Doctrine and Covenants', 'LDS', 'Section 21', 'Section 21', 'D&C 21', '', '', 'dc', 1, 0),
('english', 22, 4, 'Doctrine and Covenants', 'LDS', 'Section 22', 'Section 22', 'D&C 22', '', '', 'dc', 1, 0),
('english', 23, 4, 'Doctrine and Covenants', 'LDS', 'Section 23', 'Section 23', 'D&C 23', '', '', 'dc', 1, 0),
('english', 24, 4, 'Doctrine and Covenants', 'LDS', 'Section 24', 'Section 24', 'D&C 24', '', '', 'dc', 1, 0),
('english', 25, 4, 'Doctrine and Covenants', 'LDS', 'Section 25', 'Section 25', 'D&C 25', '', '', 'dc', 1, 0),
('english', 26, 4, 'Doctrine and Covenants', 'LDS', 'Section 26', 'Section 26', 'D&C 26', '', '', 'dc', 1, 0),
('english', 27, 4, 'Doctrine and Covenants', 'LDS', 'Section 27', 'Section 27', 'D&C 27', '', '', 'dc', 1, 0),
('english', 28, 4, 'Doctrine and Covenants', 'LDS', 'Section 28', 'Section 28', 'D&C 28', '', '', 'dc', 1, 0),
('english', 29, 4, 'Doctrine and Covenants', 'LDS', 'Section 29', 'Section 29', 'D&C 29', '', '', 'dc', 1, 0),
('english', 30, 4, 'Doctrine and Covenants', 'LDS', 'Section 30', 'Section 30', 'D&C 30', '', '', 'dc', 1, 0),
('english', 31, 4, 'Doctrine and Covenants', 'LDS', 'Section 31', 'Section 31', 'D&C 31', '', '', 'dc', 1, 0),
('english', 32, 4, 'Doctrine and Covenants', 'LDS', 'Section 32', 'Section 32', 'D&C 32', '', '', 'dc', 1, 0),
('english', 33, 4, 'Doctrine and Covenants', 'LDS', 'Section 33', 'Section 33', 'D&C 33', '', '', 'dc', 1, 0),
('english', 34, 4, 'Doctrine and Covenants', 'LDS', 'Section 34', 'Section 34', 'D&C 34', '', '', 'dc', 1, 0),
('english', 35, 4, 'Doctrine and Covenants', 'LDS', 'Section 35', 'Section 35', 'D&C 35', '', '', 'dc', 1, 0),
('english', 36, 4, 'Doctrine and Covenants', 'LDS', 'Section 36', 'Section 36', 'D&C 36', '', '', 'dc', 1, 0),
('english', 37, 4, 'Doctrine and Covenants', 'LDS', 'Section 37', 'Section 37', 'D&C 37', '', '', 'dc', 1, 0),
('english', 38, 4, 'Doctrine and Covenants', 'LDS', 'Section 38', 'Section 38', 'D&C 38', '', '', 'dc', 1, 0),
('english', 39, 4, 'Doctrine and Covenants', 'LDS', 'Section 39', 'Section 39', 'D&C 39', '', '', 'dc', 1, 0),
('english', 40, 4, 'Doctrine and Covenants', 'LDS', 'Section 40', 'Section 40', 'D&C 40', '', '', 'dc', 1, 0),
('english', 41, 4, 'Doctrine and Covenants', 'LDS', 'Section 41', 'Section 41', 'D&C 41', '', '', 'dc', 1, 0),
('english', 42, 4, 'Doctrine and Covenants', 'LDS', 'Section 42', 'Section 42', 'D&C 42', '', '', 'dc', 1, 0),
('english', 43, 4, 'Doctrine and Covenants', 'LDS', 'Section 43', 'Section 43', 'D&C 43', '', '', 'dc', 1, 0),
('english', 44, 4, 'Doctrine and Covenants', 'LDS', 'Section 44', 'Section 44', 'D&C 44', '', '', 'dc', 1, 0),
('english', 45, 4, 'Doctrine and Covenants', 'LDS', 'Section 45', 'Section 45', 'D&C 45', '', '', 'dc', 1, 0),
('english', 46, 4, 'Doctrine and Covenants', 'LDS', 'Section 46', 'Section 46', 'D&C 46', '', '', 'dc', 1, 0),
('english', 47, 4, 'Doctrine and Covenants', 'LDS', 'Section 47', 'Section 47', 'D&C 47', '', '', 'dc', 1, 0),
('english', 48, 4, 'Doctrine and Covenants', 'LDS', 'Section 48', 'Section 48', 'D&C 48', '', '', 'dc', 1, 0),
('english', 49, 4, 'Doctrine and Covenants', 'LDS', 'Section 49', 'Section 49', 'D&C 49', '', '', 'dc', 1, 0),
('english', 50, 4, 'Doctrine and Covenants', 'LDS', 'Section 50', 'Section 50', 'D&C 50', '', '', 'dc', 1, 0),
('english', 51, 4, 'Doctrine and Covenants', 'LDS', 'Section 51', 'Section 51', 'D&C 51', '', '', 'dc', 1, 0),
('english', 52, 4, 'Doctrine and Covenants', 'LDS', 'Section 52', 'Section 52', 'D&C 52', '', '', 'dc', 1, 0),
('english', 53, 4, 'Doctrine and Covenants', 'LDS', 'Section 53', 'Section 53', 'D&C 53', '', '', 'dc', 1, 0),
('english', 54, 4, 'Doctrine and Covenants', 'LDS', 'Section 54', 'Section 54', 'D&C 54', '', '', 'dc', 1, 0),
('english', 55, 4, 'Doctrine and Covenants', 'LDS', 'Section 55', 'Section 55', 'D&C 55', '', '', 'dc', 1, 0),
('english', 56, 4, 'Doctrine and Covenants', 'LDS', 'Section 56', 'Section 56', 'D&C 56', '', '', 'dc', 1, 0),
('english', 57, 4, 'Doctrine and Covenants', 'LDS', 'Section 57', 'Section 57', 'D&C 57', '', '', 'dc', 1, 0),
('english', 58, 4, 'Doctrine and Covenants', 'LDS', 'Section 58', 'Section 58', 'D&C 58', '', '', 'dc', 1, 0),
('english', 59, 4, 'Doctrine and Covenants', 'LDS', 'Section 59', 'Section 59', 'D&C 59', '', '', 'dc', 1, 0),
('english', 60, 4, 'Doctrine and Covenants', 'LDS', 'Section 60', 'Section 60', 'D&C 60', '', '', 'dc', 1, 0),
('english', 61, 4, 'Doctrine and Covenants', 'LDS', 'Section 61', 'Section 61', 'D&C 61', '', '', 'dc', 1, 0),
('english', 62, 4, 'Doctrine and Covenants', 'LDS', 'Section 62', 'Section 62', 'D&C 62', '', '', 'dc', 1, 0),
('english', 63, 4, 'Doctrine and Covenants', 'LDS', 'Section 63', 'Section 63', 'D&C 63', '', '', 'dc', 1, 0),
('english', 64, 4, 'Doctrine and Covenants', 'LDS', 'Section 64', 'Section 64', 'D&C 64', '', '', 'dc', 1, 0),
('english', 65, 4, 'Doctrine and Covenants', 'LDS', 'Section 65', 'Section 65', 'D&C 65', '', '', 'dc', 1, 0),
('english', 66, 4, 'Doctrine and Covenants', 'LDS', 'Section 66', 'Section 66', 'D&C 66', '', '', 'dc', 1, 0),
('english', 67, 4, 'Doctrine and Covenants', 'LDS', 'Section 67', 'Section 67', 'D&C 67', '', '', 'dc', 1, 0),
('english', 68, 4, 'Doctrine and Covenants', 'LDS', 'Section 68', 'Section 68', 'D&C 68', '', '', 'dc', 1, 0),
('english', 69, 4, 'Doctrine and Covenants', 'LDS', 'Section 69', 'Section 69', 'D&C 69', '', '', 'dc', 1, 0),
('english', 70, 4, 'Doctrine and Covenants', 'LDS', 'Section 70', 'Section 70', 'D&C 70', '', '', 'dc', 1, 0),
('english', 71, 4, 'Doctrine and Covenants', 'LDS', 'Section 71', 'Section 71', 'D&C 71', '', '', 'dc', 1, 0),
('english', 72, 4, 'Doctrine and Covenants', 'LDS', 'Section 72', 'Section 72', 'D&C 72', '', '', 'dc', 1, 0),
('english', 73, 4, 'Doctrine and Covenants', 'LDS', 'Section 73', 'Section 73', 'D&C 73', '', '', 'dc', 1, 0),
('english', 74, 4, 'Doctrine and Covenants', 'LDS', 'Section 74', 'Section 74', 'D&C 74', '', '', 'dc', 1, 0),
('english', 75, 4, 'Doctrine and Covenants', 'LDS', 'Section 75', 'Section 75', 'D&C 75', '', '', 'dc', 1, 0),
('english', 76, 4, 'Doctrine and Covenants', 'LDS', 'Section 76', 'Section 76', 'D&C 76', '', '', 'dc', 1, 0),
('english', 77, 4, 'Doctrine and Covenants', 'LDS', 'Section 77', 'Section 77', 'D&C 77', '', '', 'dc', 1, 0),
('english', 78, 4, 'Doctrine and Covenants', 'LDS', 'Section 78', 'Section 78', 'D&C 78', '', '', 'dc', 1, 0),
('english', 79, 4, 'Doctrine and Covenants', 'LDS', 'Section 79', 'Section 79', 'D&C 79', '', '', 'dc', 1, 0),
('english', 80, 4, 'Doctrine and Covenants', 'LDS', 'Section 80', 'Section 80', 'D&C 80', '', '', 'dc', 1, 0),
('english', 81, 4, 'Doctrine and Covenants', 'LDS', 'Section 81', 'Section 81', 'D&C 81', '', '', 'dc', 1, 0),
('english', 82, 4, 'Doctrine and Covenants', 'LDS', 'Section 82', 'Section 82', 'D&C 82', '', '', 'dc', 1, 0),
('english', 83, 4, 'Doctrine and Covenants', 'LDS', 'Section 83', 'Section 83', 'D&C 83', '', '', 'dc', 1, 0),
('english', 84, 4, 'Doctrine and Covenants', 'LDS', 'Section 84', 'Section 84', 'D&C 84', '', '', 'dc', 1, 0),
('english', 85, 4, 'Doctrine and Covenants', 'LDS', 'Section 85', 'Section 85', 'D&C 85', '', '', 'dc', 1, 0),
('english', 86, 4, 'Doctrine and Covenants', 'LDS', 'Section 86', 'Section 86', 'D&C 86', '', '', 'dc', 1, 0),
('english', 87, 4, 'Doctrine and Covenants', 'LDS', 'Section 87', 'Section 87', 'D&C 87', '', '', 'dc', 1, 0),
('english', 88, 4, 'Doctrine and Covenants', 'LDS', 'Section 88', 'Section 88', 'D&C 88', '', '', 'dc', 1, 0),
('english', 89, 4, 'Doctrine and Covenants', 'LDS', 'Section 89', 'Section 89', 'D&C 89', '', '', 'dc', 1, 0),
('english', 90, 4, 'Doctrine and Covenants', 'LDS', 'Section 90', 'Section 90', 'D&C 90', '', '', 'dc', 1, 0),
('english', 91, 4, 'Doctrine and Covenants', 'LDS', 'Section 91', 'Section 91', 'D&C 91', '', '', 'dc', 1, 0),
('english', 92, 4, 'Doctrine and Covenants', 'LDS', 'Section 92', 'Section 92', 'D&C 92', '', '', 'dc', 1, 0),
('english', 93, 4, 'Doctrine and Covenants', 'LDS', 'Section 93', 'Section 93', 'D&C 93', '', '', 'dc', 1, 0),
('english', 94, 4, 'Doctrine and Covenants', 'LDS', 'Section 94', 'Section 94', 'D&C 94', '', '', 'dc', 1, 0),
('english', 95, 4, 'Doctrine and Covenants', 'LDS', 'Section 95', 'Section 95', 'D&C 95', '', '', 'dc', 1, 0),
('english', 96, 4, 'Doctrine and Covenants', 'LDS', 'Section 96', 'Section 96', 'D&C 96', '', '', 'dc', 1, 0),
('english', 97, 4, 'Doctrine and Covenants', 'LDS', 'Section 97', 'Section 97', 'D&C 97', '', '', 'dc', 1, 0),
('english', 98, 4, 'Doctrine and Covenants', 'LDS', 'Section 98', 'Section 98', 'D&C 98', '', '', 'dc', 1, 0),
('english', 99, 4, 'Doctrine and Covenants', 'LDS', 'Section 99', 'Section 99', 'D&C 99', '', '', 'dc', 1, 0),
('english', 100, 4, 'Doctrine and Covenants', 'LDS', 'Section 100', 'Section 100', 'D&C 100', '', '', 'dc', 1, 0),
('english', 101, 4, 'Doctrine and Covenants', 'LDS', 'Section 101', 'Section 101', 'D&C 101', '', '', 'dc', 1, 0),
('english', 102, 4, 'Doctrine and Covenants', 'LDS', 'Section 102', 'Section 102', 'D&C 102', '', '', 'dc', 1, 0),
('english', 103, 4, 'Doctrine and Covenants', 'LDS', 'Section 103', 'Section 103', 'D&C 103', '', '', 'dc', 1, 0),
('english', 104, 4, 'Doctrine and Covenants', 'LDS', 'Section 104', 'Section 104', 'D&C 104', '', '', 'dc', 1, 0),
('english', 105, 4, 'Doctrine and Covenants', 'LDS', 'Section 105', 'Section 105', 'D&C 105', '', '', 'dc', 1, 0),
('english', 106, 4, 'Doctrine and Covenants', 'LDS', 'Section 106', 'Section 106', 'D&C 106', '', '', 'dc', 1, 0),
('english', 107, 4, 'Doctrine and Covenants', 'LDS', 'Section 107', 'Section 107', 'D&C 107', '', '', 'dc', 1, 0),
('english', 108, 4, 'Doctrine and Covenants', 'LDS', 'Section 108', 'Section 108', 'D&C 108', '', '', 'dc', 1, 0),
('english', 109, 4, 'Doctrine and Covenants', 'LDS', 'Section 109', 'Section 109', 'D&C 109', '', '', 'dc', 1, 0),
('english', 110, 4, 'Doctrine and Covenants', 'LDS', 'Section 110', 'Section 110', 'D&C 110', '', '', 'dc', 1, 0),
('english', 111, 4, 'Doctrine and Covenants', 'LDS', 'Section 111', 'Section 111', 'D&C 111', '', '', 'dc', 1, 0),
('english', 112, 4, 'Doctrine and Covenants', 'LDS', 'Section 112', 'Section 112', 'D&C 112', '', '', 'dc', 1, 0),
('english', 113, 4, 'Doctrine and Covenants', 'LDS', 'Section 113', 'Section 113', 'D&C 113', '', '', 'dc', 1, 0),
('english', 114, 4, 'Doctrine and Covenants', 'LDS', 'Section 114', 'Section 114', 'D&C 114', '', '', 'dc', 1, 0),
('english', 115, 4, 'Doctrine and Covenants', 'LDS', 'Section 115', 'Section 115', 'D&C 115', '', '', 'dc', 1, 0),
('english', 116, 4, 'Doctrine and Covenants', 'LDS', 'Section 116', 'Section 116', 'D&C 116', '', '', 'dc', 1, 0),
('english', 117, 4, 'Doctrine and Covenants', 'LDS', 'Section 117', 'Section 117', 'D&C 117', '', '', 'dc', 1, 0),
('english', 118, 4, 'Doctrine and Covenants', 'LDS', 'Section 118', 'Section 118', 'D&C 118', '', '', 'dc', 1, 0),
('english', 119, 4, 'Doctrine and Covenants', 'LDS', 'Section 119', 'Section 119', 'D&C 119', '', '', 'dc', 1, 0),
('english', 120, 4, 'Doctrine and Covenants', 'LDS', 'Section 120', 'Section 120', 'D&C 120', '', '', 'dc', 1, 0),
('english', 121, 4, 'Doctrine and Covenants', 'LDS', 'Section 121', 'Section 121', 'D&C 121', '', '', 'dc', 1, 0),
('english', 122, 4, 'Doctrine and Covenants', 'LDS', 'Section 122', 'Section 122', 'D&C 122', '', '', 'dc', 1, 0),
('english', 123, 4, 'Doctrine and Covenants', 'LDS', 'Section 123', 'Section 123', 'D&C 123', '', '', 'dc', 1, 0),
('english', 124, 4, 'Doctrine and Covenants', 'LDS', 'Section 124', 'Section 124', 'D&C 124', '', '', 'dc', 1, 0),
('english', 125, 4, 'Doctrine and Covenants', 'LDS', 'Section 125', 'Section 125', 'D&C 125', '', '', 'dc', 1, 0),
('english', 126, 4, 'Doctrine and Covenants', 'LDS', 'Section 126', 'Section 126', 'D&C 126', '', '', 'dc', 1, 0),
('english', 127, 4, 'Doctrine and Covenants', 'LDS', 'Section 127', 'Section 127', 'D&C 127', '', '', 'dc', 1, 0),
('english', 128, 4, 'Doctrine and Covenants', 'LDS', 'Section 128', 'Section 128', 'D&C 128', '', '', 'dc', 1, 0),
('english', 129, 4, 'Doctrine and Covenants', 'LDS', 'Section 129', 'Section 129', 'D&C 129', '', '', 'dc', 1, 0),
('english', 130, 4, 'Doctrine and Covenants', 'LDS', 'Section 130', 'Section 130', 'D&C 130', '', '', 'dc', 1, 0),
('english', 131, 4, 'Doctrine and Covenants', 'LDS', 'Section 131', 'Section 131', 'D&C 131', '', '', 'dc', 1, 0),
('english', 132, 4, 'Doctrine and Covenants', 'LDS', 'Section 132', 'Section 132', 'D&C 132', '', '', 'dc', 1, 0),
('english', 133, 4, 'Doctrine and Covenants', 'LDS', 'Section 133', 'Section 133', 'D&C 133', '', '', 'dc', 1, 0),
('english', 134, 4, 'Doctrine and Covenants', 'LDS', 'Section 134', 'Section 134', 'D&C 134', '', '', 'dc', 1, 0),
('english', 135, 4, 'Doctrine and Covenants', 'LDS', 'Section 135', 'Section 135', 'D&C 135', '', '', 'dc', 1, 0),
('english', 136, 4, 'Doctrine and Covenants', 'LDS', 'Section 136', 'Section 136', 'D&C 136', '', '', 'dc', 1, 0),
('english', 137, 4, 'Doctrine and Covenants', 'LDS', 'Section 137', 'Section 137', 'D&C 137', '', '', 'dc', 1, 0),
('english', 138, 4, 'Doctrine and Covenants', 'LDS', 'Section 138', 'Section 138', 'D&C 138', '', '', 'dc', 1, 0),
('english', 150, 4, 'Doctrine and Covenants', 'LDS', 'OFFICIAL DECLARATION-1', 'OFFICIAL DECLARATION-1', 'Official Declaration-1', '', '', 'dc', 1, 0),
('english', 151, 4, 'Doctrine and Covenants', 'LDS', 'OFFICIAL DECLARATION-2', 'OFFICIAL DECLARATION-2', 'Official Declaration-2', '', '', 'dc', 1, 0),
('english', 0, 1, 'Old Testament', 'KJV', 'Introduction', 'Introduction', 'Intro', '', 'Introduction', 'ded', 2, 7),
('english', 6, 5, 'Pearl of Great Price', 'LDS', 'Oliver Cowdery addendum', 'Oliver Cowdery addendum', 'Oliver Cowdery', '', 'Of The Church of Jesus Christ of Latter-day Saints', 'oc_add', 1, 7),
('english', 0, 3, 'Book of Mormon', 'LDS', 'Preface', 'Preface', 'BM', '', '', '', 1, 0),
('english', -5, 3, 'Book of Mormon', 'LDS', 'INTRODUCTION', 'INTRODUCTION', 'BM', '', '', '', 1, 0),
('english', -3, 3, 'Book of Mormon', 'LDS', 'THE TESTIMONY OF EIGHT WITNESSES\r\n', 'THE TESTIMONY OF EIGHT WITNESSES\r\n', 'BM', '', '', '', 1, 0),
('english', -4, 3, 'Book of Mormon', 'LDS', 'THE TESTIMONY OF THREE WITNESSES\r\n', 'THE TESTIMONY OF THREE WITNESSES\r\n', 'BM', '', '', '', 1, 0),
('english', -2, 3, 'Book of Mormon', 'LDS', 'TESTIMONY OF THE PROPHET JOSEPH SMITH', 'TESTIMONY OF THE PROPHET JOSEPH SMITH', 'BM', '', '', '', 1, 0),
('english', -1, 3, 'Book of Mormon', 'LDS', 'A BRIEF EXPLANATION ABOUT\r\nTHE BOOK OF MORMON\r\n', 'A BRIEF EXPLANATION ABOUT\r\nTHE BOOK OF MORMON\r\n', 'BM', '', '', '', 1, 0),
('english', 4, 5, 'Pearl of Great Price', 'LDS', 'Joseph Smith--History', 'Joseph Smith--History', 'JS-H', '', 'Extracts from The History of Joseph Smith, the Prophet', '', 2, 7);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
