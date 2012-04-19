-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 17, 2012 at 03:48 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `devels`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ua` varchar(255) NOT NULL,
  `text_ua` text NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_ru` text NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `text_en` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title_ua`, `text_ua`, `title_ru`, `text_ru`, `title_en`, `text_en`) VALUES
(1, 'Новина 1 (ua)', 'Текст новини 1', 'Новость 1 (ru)', 'Текст новости 1', 'News 1 (en)', 'The text of a news 1'),
(2, 'Новина 2 (ua)', 'Текст новини 2', 'Новость 2 (ru)', 'Текст новости 2', 'News 2 (en)', 'The text of a news 2'),
(3, 'Новина 3 (ua)', 'Текст новини 3', 'Новость 3 (ru)', 'Текст новости 3', 'News 3 (en)', 'The text of a news 3');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `title_ua` varchar(255) NOT NULL,
  `text_ua` text NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `text_ru` text NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `text_en` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `alias`, `title_ua`, `text_ua`, `title_ru`, `text_ru`, `title_en`, `text_en`) VALUES
(1, 'contacts', 'Завітайте до нас', '<p>Наша адреса:</p>\r\n<p>м. Луцьк, вул. Будівельників 25</p>\r\n<p>тел. 12-34-56</p>', 'Приходите к нам', '<p>Наш адрес:</p>\r\n<p>г. Луцк, ул. Строителей 25</p>\r\n<p>тел. 12-34-56</p>', 'Visit us', '<p>Our address is:</p>\r\n<p>Lutsk, Builders 25 st.</p>\r\n<p>tel. 12-34-56</p>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `surname`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70', 'Ivan', 'Petrov'),
(14, 'sdf', 'd9729feb74992cc3482b350163a1a010', 'sdf', 'sdf'),
(13, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', 'test');
