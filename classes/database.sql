-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generatie Tijd: 14 Mar 2012 om 09:41
-- Server versie: 5.1.30
-- PHP Versie: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `goededoelenportal`
--

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `agendas`
--

CREATE TABLE IF NOT EXISTS `agendas` (
  `gebruiker_id` int(11) NOT NULL,
  `agenda_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `agendas`
--

INSERT INTO `agendas` (`gebruiker_id`, `agenda_id`, `status`) VALUES
(4, 1, 1),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `donaties`
--

CREATE TABLE IF NOT EXISTS `donaties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goeddoel_id` int(11) DEFAULT NULL,
  `stichting_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `duur` int(11) NOT NULL,
  `bedrag` double NOT NULL,
  `opmerking` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `donaties`
--

INSERT INTO `donaties` (`id`, `goeddoel_id`, `stichting_id`, `gebruiker_id`, `duur`, `bedrag`, `opmerking`, `datum`) VALUES
(1, NULL, 1, 4, 1, 50, 'Jullie doen goed werk!', '2012-03-13 18:51:21'),
(2, 5, NULL, 4, 1, 19.95, '', '2012-03-13 18:57:10');

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `gebruikers`
--

CREATE TABLE IF NOT EXISTS `gebruikers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailadres` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `is_organisatie` int(11) NOT NULL,
  `form_aanhef` varchar(255) NOT NULL,
  `form_voornaam` varchar(255) NOT NULL,
  `form_achternaam` varchar(255) NOT NULL,
  `form_rekeningnummer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden uitgevoerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `emailadres`, `wachtwoord`, `is_organisatie`, `form_aanhef`, `form_voornaam`, `form_achternaam`, `form_rekeningnummer`) VALUES
(1, 'pieter@greenpeace.nl', 'ditmoetnoggehashedworden', 1, 'Dhr.', 'Aangepaste', 'Data', '306203734764'),
(2, 'karel@wnf.nl', 'kareldeparel', 1, 'Dhr.', 'Karel', 'van Akkeren', ''),
(3, 'm.soeteman-reijnen@stichting-als.nl', 'marieke', 1, 'Mevr.', 'Marieke', 'Soeteman-Reijnen', ''),
(4, 'e.nolet@stichting-als.nl', 'ernout', 0, 'Dhr.', 'Ernout', 'Nolet', ''),
(5, 'j.jansen@actie-calcutta.nl', 'Jean-marie', 1, 'Mevr.', 'Jean-marie', 'Jansen', ''),
(6, 'p.vanbeek@hartstichting.nl', 'peter', 1, 'Dhr', 'Peter', 'van Beek', ''),
(7, 'e.colstee@lilianefonds.nl', 'els', 1, 'Mevr.', 'Els', 'Colstee', '');

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `goededoelen`
--

CREATE TABLE IF NOT EXISTS `goededoelen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organisatie_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `url_homepage` varchar(255) NOT NULL,
  `categorie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `goededoelen`
--

INSERT INTO `goededoelen` (`id`, `organisatie_id`, `naam`, `beschrijving`, `logo`, `url_homepage`, `categorie`) VALUES
(1, 1, 'Save The Whales', 'Wij willen de walvissen redden!', '', 'http://www.greenpeace.nl/actie/save-the-whales/', 2),
(2, 1, 'Red het regenwoud', 'Ja.. red het! Voordat het te laat is!', '', 'http://www.greenpeace.com/acties/red-het-regenwoud/', 3),
(3, 2, 'WNF Rangerclub', 'De rangerclub is voor kinderen. Red de panda!', 'http://assets.wnf.nl/img/original/ranger_club_logo_1.jpg', 'http://www.rangerclub.nl/', 2),
(4, 2, 'De natuur dat ben jij', '50 manieren om de natuur te redden, weet jij er nog meer?', 'http://external.ak.fbcdn.net/safe_image.php?d=AQBz0Kxyhh3sTn9c&url=http%3A%2F%2Fi1.ytimg.com%2Fvi%2Fx8I_Z5lVdg0%2Fhqdefault.jpg', 'http://www.wnf.nl/50manieren', 3),
(5, 2, 'Earth Hour 2012', 'Doe een dag het licht uit en bespaar energie, over de hele wereld!', 'http://d2hv3zvds9z8pu.cloudfront.net/img/eh_60_logo_jpeg_small_13392.jpg', 'http://www.wnf.nl/nl/earth_hour/', 4);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `organisaties`
--

CREATE TABLE IF NOT EXISTS `organisaties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beheerder_id` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `cbf` int(11) NOT NULL,
  `cbf_verified` int(11) NOT NULL,
  `bank_giro` varchar(255) NOT NULL,
  `naw_straat` varchar(255) NOT NULL,
  `naw_huisnummer` varchar(255) NOT NULL,
  `naw_postcode` varchar(255) NOT NULL,
  `naw_plaats` varchar(255) NOT NULL,
  `telefoon` varchar(255) NOT NULL,
  `emailadres` varchar(255) NOT NULL,
  `url_homepage` varchar(255) NOT NULL,
  `url_twitter` varchar(255) NOT NULL,
  `url_facebook` varchar(255) NOT NULL,
  `lidmaatschap` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `organisaties`
--

INSERT INTO `organisaties` (`id`, `beheerder_id`, `categorie`, `naam`, `beschrijving`, `logo`, `cbf`, `cbf_verified`, `bank_giro`, `naw_straat`, `naw_huisnummer`, `naw_postcode`, `naw_plaats`, `telefoon`, `emailadres`, `url_homepage`, `url_twitter`, `url_facebook`, `lidmaatschap`) VALUES
(1, 1, 1, 'Greenpeace', 'Greenpeace is geweldig. Help de natuur en de dieren!', '', 31237247, 1, '3652360', 'Jollemanhof', '15-17', '1019 GW', 'Amsterdam', '+31 (0)20 626 1877', 'info@greenpeace.nl', 'http://www.greenpeace.nl', 'http://www.twitter.com/GreenpeaceNL', 'http://www.facebook.com/greenpeacenederland', 0),
(2, 2, 2, 'Wereld Natuur Fonds', 'Wij zijn het WNF! We hebben een panda logo, yee-haw!', 'http://pandabeer.moonfruit.com/communities/9/004/009/320/669/images/4552602307.jpg', 83647, 1, '374898765', 'Driebergseweg', '10', '3708 JB ', 'Zeist', '0800-1962', 'info@wwf.nl', 'http://www.wnf.nl', 'https://twitter.com/#!/wnfnederland', 'http://www.facebook.com/wereldnatuurfonds', 0),
(3, 3, 3, 'ALS Nederland', 'Amyotrofische Laterale Sclerose (ALS) is een zeldzame en dodelijke zenuw-spierziekte, waarvoor nog geen medicijn bestaat. Onze missie luidt: het stimuleren van wetenschappelijk onderzoek naar de oorzaken en behandeling van ALS en het creëren van een beter', 'http://www.goededoelen.nl/images/uploads/logos/logo_ALS_superklein.jpg', 753924, 1, '100.000', 'Koninginnegracht', '7', '2514 AA', 'Den Haag', '088-666 0333', 'info@stichting-als.nl', 'http://www.stichting-als.nl', 'http://www.twitter.com/alsnederland', 'http://www.facebook.com/ALSnederland', 0),
(4, 5, 4, 'Stichting Actie Calcutta', 'Miljoenen kinderen, vooral van de inheemse stammen en kastelozen, gaan niet naar school vanwege de armoede van hun ouders. Daarom geeft SAC een bijdrage in de kosten voor onderwijs, voeding, kleding en onderdak, en voor bouw van scholen en internaten.', 'http://www.goededoelen.nl/images/uploads/logos/LOGO-SAC_c.jpg', 64920, 1, '54.96.20.168', 'Postbus 200', '', '5660 AH', 'Geldrop', '040 - 285 27 22', 'info@actie-calcutta.nl', 'http://www.actie-calcutta.nl', '', '', 0),
(5, 6, 5, 'Nederlandse Hartstichting', 'Hart- en vaatziekten zijn ernstige ziekten. Een op de drie Nederlanders sterft eraan, jaarlijks zo&#39;n 41.000 personen. Hoewel het aantal sterfgevallen afneemt, neemt het aantal patiënten toe. Op dit moment zijn er zo&#39;n 1 miljoen hart- en vaatpatiën', 'http://www.goededoelen.nl/images/uploads/logos/logo_Hartstichting.jpg', 95728, 1, '300', 'Postbus 300', '', '2501 CH', 'Den Haag', '070 - 315 55 55', 'info@hartstichting.nl', 'http://www.hartstichting.nl', 'http://twitter.com/hartstichting', 'http://www.facebook.com/Hartstichting', 0),
(6, 7, 6, 'Stichting Liliane Fonds', 'Het Liliane Fonds wil de wereld openen voor kinderen en jongeren met een handicap in ontwikkelingslanden. Zodat ze kunnen meedoen en meetellen in hun gemeenschap.', 'http://www.goededoelen.nl/images/uploads/logos/lilianefonds_logo.jpg', 28462, 1, '7800800', 'Havensingel', '26', '5211 TX', 'Den Bosch', '0800 - 780 08 00', 'voorlichting@lilianefonds.nl', 'http://www.lilianefonds.nl', 'http://twitter.com/lilianefonds', '', 0);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `publiekeagenda`
--

CREATE TABLE IF NOT EXISTS `publiekeagenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goeddoel_id` int(11) DEFAULT NULL,
  `stichting_id` int(11) DEFAULT NULL,
  `naam` varchar(255) NOT NULL,
  `beschrijving` varchar(255) NOT NULL,
  `locatie` varchar(255) NOT NULL,
  `entree` float NOT NULL,
  `foto` varchar(255) NOT NULL,
  `datum_begin` date NOT NULL,
  `datum_eind` date NOT NULL,
  `tijd_begin` varchar(255) NOT NULL,
  `tijd_eind` varchar(255) NOT NULL,
  `heledag` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `publiekeagenda`
--

INSERT INTO `publiekeagenda` (`id`, `goeddoel_id`, `stichting_id`, `naam`, `beschrijving`, `locatie`, `entree`, `foto`, `datum_begin`, `datum_eind`, `tijd_begin`, `tijd_eind`, `heledag`) VALUES
(1, 5, NULL, 'Superfeest', 'Kom lekker dansen! Al het geld gaat naar de Panda''s!', 'Amsterdam ArenA, Amsterdam', 9.95, '', '2012-03-17', '2012-03-18', '19:00', '02:00', NULL),
(2, NULL, 1, 'WNF Actie Dag', 'Actie.. op deze dag.. doe mee!', 'Nederland', 0, '', '2012-03-21', '2012-03-21', '', '', 1);

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `reacties`
--

CREATE TABLE IF NOT EXISTS `reacties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doel_goeddoel_id` int(11) DEFAULT NULL,
  `doel_stichting_id` int(11) DEFAULT NULL,
  `doel_agenda_id` int(11) DEFAULT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `bericht` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `reacties`
--

INSERT INTO `reacties` (`id`, `doel_goeddoel_id`, `doel_stichting_id`, `doel_agenda_id`, `gebruiker_id`, `bericht`, `datum`) VALUES
(1, 5, NULL, NULL, 4, 'Oh wow cool.. een reactie!', '2012-03-13 19:36:54'),
(2, NULL, 1, NULL, 4, 'Oh wow cool.. een reactie!', '2012-03-13 19:36:58'),
(3, NULL, NULL, 2, 4, 'Oh wow cool.. een reactie!', '2012-03-13 19:37:01');
