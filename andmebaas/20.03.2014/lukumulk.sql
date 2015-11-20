-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Loomise aeg: Märts 20, 2014 kell 06:46 PM
-- Serveri versioon: 5.5.33
-- PHP versioon: 5.4.4-14+deb7u7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Andmebaas: `lukumulk`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Andmete tõmmistamine tabelile `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Tavakasutaja', ''),
(2, 'Administraator', '{\r\n"administrator": 1,\r\n"moderator": 1,\r\n"v_spordihall": 1\r\n}'),
(4, 'Vana spordihall', '{\r\n"v_spordihall": 1\r\n}');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Andmete tõmmistamine tabelile `languages`
--

INSERT INTO `languages` (`id`, `short`, `name`) VALUES
(1, 'en', 'English'),
(2, 'ee', 'Eesti');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `author` varchar(32) NOT NULL,
  `authorid` int(11) NOT NULL,
  `groupid` varchar(32) NOT NULL,
  `userid` varchar(32) NOT NULL,
  `importance` varchar(64) NOT NULL DEFAULT 'danger',
  `deadline` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Andmete tõmmistamine tabelile `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `date`, `author`, `authorid`, `groupid`, `userid`, `importance`, `deadline`) VALUES
(1, 'Mingi pealkiri', 'Mingi uuudise sisu.', '2014-03-17 13:40:18', 'Tanel Elvast', 16, '0', '0', 'warning', '0'),
(2, 'Live teade', 'Kõigile saab teadet', '2014-03-17 20:37:08', 'Tanel Elvast', 16, '0', '0', 'danger', '0'),
(3, 'Mjäuu', 'Homme saab kooki moosiga!', '2014-03-18 01:59:58', 'Martin Mikson', 20, '0', '0', 'warning', '1395180000'),
(4, 'Test Täna', 'Test Täna', '2014-03-18 02:02:07', 'Martin Mikson', 20, '0', '0', 'warning', '1395093600'),
(5, 'Test Täna 2', 'Test Täna 2', '2014-03-18 02:02:53', 'Martin Mikson', 20, '0', '0', 'danger', '1395093600'),
(6, 'Test Eile', 'Eile', '2014-03-18 02:03:30', 'Martin Mikson', 20, '0', '0', 'amethyst', '1395007200'),
(7, 'Kolmas katse!', 'Mjäuuuuuuuu', '2014-03-18 02:05:05', 'Martin Mikson', 20, '0', '0', 'info', '1395352800'),
(8, 'Badumtsss', 'Badumtsss Badumtsss Badumtsss Õkaõkaõkaõka\r\nFrop The bass', '2014-03-18 02:06:46', 'Martin Mikson', 20, '0', '0', 'warning', '0'),
(9, 'The lumberyard', 'I like chopping trees so many times! ', '2014-03-18 02:09:26', 'Martin Mikson', 20, '0', '0', 'warning', '1403902800'),
(10, 'Chopping', 'Tuleviku sportlaste autasustamine!', '2014-03-18 02:10:49', 'Martin Mikson', 20, '0', '0', 'danger', '1429304400'),
(11, 'Miauuu', 'sdasdasdfasfasdf', '2014-03-18 02:31:36', 'Martin Mikson', 20, '0', '0', 'danger', '1394229600'),
(12, 'Pealkiri', 'Räme möll toimub!', '2014-03-18 06:25:23', 'Tanel Elvast', 16, '2', '0', 'info', '1395180000');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(128) NOT NULL,
  `lang` int(10) NOT NULL,
  `value` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Andmete tõmmistamine tabelile `translations`
--

INSERT INTO `translations` (`id`, `keyword`, `lang`, `value`) VALUES
(1, 'hello_guest', 1, 'Hello, Guest!'),
(2, 'log_in', 1, 'Login'),
(3, 'username', 1, 'Username'),
(4, 'username_placeholder', 1, 'Enter your username'),
(5, 'password', 1, 'Password'),
(6, 'password_placeholder', 1, 'Enter your password'),
(7, 'wrong_user_or_pass', 1, 'Wrong username or password.'),
(8, 'register', 1, 'Register'),
(9, 'confirm_password', 1, 'Confirm password'),
(10, 'confim_password_placeh', 1, 'Confirm your password'),
(11, 'email', 1, 'Email'),
(12, 'email_placeholder', 1, 'Insert your email'),
(13, 'firstname', 1, 'First name'),
(14, 'firstname_placeholder', 1, 'Enter your first name'),
(15, 'lastname', 1, 'Last name'),
(16, 'lastname_placeholder', 1, 'Enter your lastname'),
(17, 'select_gender', 1, 'Select gender'),
(18, 'gender', 1, 'Gender'),
(19, 'male', 1, 'Male'),
(20, 'female', 1, 'Female'),
(21, 'prefer_not_to', 1, 'Prefer not to answer'),
(22, 'agreement', 1, 'Agreement'),
(23, 'i_agree', 1, 'I agree with the'),
(24, 'terms', 1, 'Terms and Conditions'),
(25, 'log_out', 1, 'Logout'),
(26, 'home', 1, 'Home'),
(27, 'guest_welcome', 1, 'Don''t have an account?'),
(28, 'signed_in_as', 1, 'Signed in as'),
(29, 'welcome', 1, 'Welcome %t%'),
(30, 'or', 1, 'or'),
(31, 'sign_with_twitter', 1, 'Sign in with Twitter'),
(32, 'sign_with_fb', 1, 'Sign in with Facebook'),
(33, 'hello_guest', 2, 'Tere, külaline!'),
(34, 'username', 2, 'Kasutajanimi'),
(35, 'username_placeholder', 2, 'Sisesta kasutajanimi'),
(36, 'password', 2, 'Parool'),
(37, 'password_placeholder', 2, 'Sisesta parool'),
(38, 'wrong_user_or_pass', 2, 'Vale kasutajanimi voi parool'),
(39, 'register', 2, 'Registreeru'),
(40, 'confirm_password', 2, 'Korda parooli'),
(41, 'confim_password_placeh', 2, 'Korda oma parooli'),
(42, 'email_placeholder', 2, 'Sisesta oma email'),
(43, 'firstname', 2, 'Eesnimi'),
(44, 'firstname_placeholder', 2, 'Sisesta oma eesnimi'),
(45, 'lastname', 2, 'Perenimi'),
(46, 'lastname_placeholder', 2, 'Sisesta oma perekonnanimi'),
(47, 'select_gender', 2, 'Vali sugu'),
(48, 'gender', 2, 'Sugu'),
(49, 'male', 2, 'Mees'),
(50, 'female', 2, 'Naine'),
(51, 'prefer_not_to', 2, 'Ei soovi vastata'),
(52, 'log_out', 2, 'Logi välja'),
(53, 'home', 2, 'Avaleht'),
(54, 'guest_welcome', 2, 'Pole kasutajat registreeritud?'),
(55, 'signed_in_as', 2, 'Sisse logitud kasutajaga'),
(56, 'welcome', 2, 'Tere tulemast %t%'),
(57, 'or', 2, 'või'),
(58, 'sign_with_twitter', 2, 'Logi sisse Twitteriga'),
(59, 'sign_with_fb', 2, 'Logi sisse Facebookiga'),
(60, 'log_in', 2, 'Logi sisse'),
(61, 'remember_me', 1, 'Remember me'),
(62, 'remember_me', 2, 'Jäta mind meelde'),
(63, 'email', 2, 'Email'),
(64, 'dashboard', 1, 'Dashboard'),
(65, 'dashboard', 2, 'Töölaud'),
(66, 'is_required', 1, '%t% is required'),
(67, 'is_required', 2, '%t% on kohustuslik');

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Andmete tõmmistamine tabelile `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `firstname`, `lastname`, `active`, `joined`, `group`) VALUES
(16, 'john', '1792aa95ac67d07ee1284e3358466a7d03d7133ffb074938ecd806bfe260f86e', 'ZñmµëªÏD{ºü¤', 'tester@rastapats.ee', 'Tanel', 'Elvast', 0, '2014-03-03 01:31:24', 2),
(20, 'The Truth', 'a5ed90216eac9056c2ce2b5b82625eedea1de6baa37d262fb0837a632b74e319', 'ò¨J\\Iø\0 ÛïàtYÔi[ÇJxM$\ZB½£ ', 'mikson@vixcor.eu', 'Martin', 'Mikson', 0, '2014-03-04 01:27:44', 2),
(21, 'aadmin', '4a97b10b9265c449af01b6707d6b57069a3e8be7a34388227d82b7b7ce4c519a', '«<µzÇ¬^À}Ââ)îÎ%>3ÌÔËm7YÓ±l_pÒ', 'vrasda@hot.ee', 'Viru', 'Kunn', 0, '2014-03-04 02:56:35', 2),
(22, 'Peedu', '5a98597ac116153b7fae0fa2143a70ced33ef826d162d2a2d66c5642583134fa', '´dÏïz[§`k¯33Á²QÂêË.äªwaf', 'miksn@gil.ee', 'Milli', 'Mallikas', 0, '2014-03-07 02:48:59', 1),
(23, 'andres', 'cd6d45f767765bc0e40babc52a521a88c5225ab7fd58bb85ba0de2099ff2218e', '¿[ô\ZÖKmY\rôðü3-s&½²9Ôã¯Ì', 'andres@it-abi.ee', 'andres', 'rosin', 0, '2014-03-07 17:35:29', 1),
(24, 'Test', 'aa49b4b35142841a31bccf2be57af481faf0f81db647083bef0e7ebe5242220e', '»Áñ%¢¥sÍ³h77SOÇ½CþÕÕ·5ÓGýÊA', 'mimmu@hot.ee', 'Mimmu', 'Maiasmokk', 0, '2014-03-07 19:39:51', 1),
(25, 'Kimmukas', 'b5141f5228af1cf926378a5bd9eb192581d61b61de018ca508ca8e5369ce84a0', 'Ó9»º K²0·å_BÄS6Ø"å¬Zb­lßø«h', 'lammas@hi.ee', 'Mimmu', 'Kimmu', 0, '2014-03-07 19:58:23', 2),
(26, 'Lambine', 'dc28127bf847c2d3d07676560db17f7e205f3608e04c67a49ab096caf6575305', 'óxcÓ:Ú½cÊCßVæÙï>û@}^Ë4¡Û', 'lamma@hot.ee', 'Mimmu', 'Maias', 0, '2014-03-13 00:38:17', 1),
(27, 'Mimmu', '9b2a5370142dce3f178c8bf3e1901506bbb98d5ef6ffe23d252b14cab4e1ec5c', '1\\ý]ï{_Û«CøÚQyns¨<ggKÓ', 'mikson@hotie.ee', 'Mimmu', 'Mammi', 0, '2014-03-14 21:35:33', 1),
(28, 'Peedu232', '5a98597ac1232316153b7fae0fa2143a70ced33ef826d162d2a2d66c5642583134fa', '´dÏïz[§`k¯33Á²232QÂêË.äª', 'miksn@gil.ee', 'Peeeter', 'Millimaullikas', 0, '2014-03-07 02:48:59', 1),
(29, 'Kullerkupp', '4a97b10b9265c449af01b6707d6b57069a3e8be7a34388227d82b7b7ce4c519a', '«<µzÇ¬^À}Ââ)îÎ%>3ÌÔËm7YÓ±l_pÒ', 'vrasda@hot.ee', 'Võru', 'Emme', 0, '2014-03-04 02:56:35', 1),
(30, 'Josh.', '1c08b1577d0fae10c00271f287e4d87b1b6259bb32bdf0c73413c2ccf175061e', 'MdHpËvø÷DcICwHãT4ñJí\nÅ0	', 'mimmu@himmu.ee', 'Tanel', 'Elvast', 0, '2014-03-19 18:39:38', 2);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `users_session`
--

CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
