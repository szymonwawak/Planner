-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 23 Kwi 2020, 18:12
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `consultations`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `consult_scheme`
--

CREATE TABLE `consult_scheme` (
  `id` int(11) NOT NULL,
  `idlesson` int(11) NOT NULL,
  `consult_date` date NOT NULL,
  `day` varchar(40) NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `consult_student`
--

CREATE TABLE `consult_student` (
  `id` int(11) NOT NULL,
  `idconsult` int(11) NOT NULL,
  `student_name` varchar(40) NOT NULL,
  `student_surname` varchar(40) NOT NULL,
  `student_email` varchar(40) NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `accepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson`
--

CREATE TABLE `lesson` (
  `id` int(11) NOT NULL,
  `idteacher` int(11) NOT NULL,
  `idsubject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson`
--

INSERT INTO `lesson` (`id`, `idteacher`, `idsubject`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `subject`
--

INSERT INTO `subject` (`id`, `subject_name`) VALUES
(1, 'Grafika komputerowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `teacher`
--

INSERT INTO `teacher` (`id`, `email`, `password`, `name`, `surname`) VALUES
(1, 'nowak.adam@us.pl', '$2y$10$g4s7bbe3G9Ysma490LslJeELHRqpz9WT.esLZkyGiiqdvD4aQeFjO', 'Adam', 'Nowak');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `consult_scheme`
--
ALTER TABLE `consult_scheme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idlesson` (`idlesson`);

--
-- Indeksy dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idconsult` (`idconsult`);

--
-- Indeksy dla tabeli `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsubject` (`idsubject`),
  ADD KEY `idteacher` (`idteacher`);

--
-- Indeksy dla tabeli `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `consult_scheme`
--
ALTER TABLE `consult_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `consult_scheme`
--
ALTER TABLE `consult_scheme`
  ADD CONSTRAINT `consult_scheme_ibfk_1` FOREIGN KEY (`idlesson`) REFERENCES `lesson` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  ADD CONSTRAINT `consult_student_ibfk_1` FOREIGN KEY (`idconsult`) REFERENCES `consult_scheme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`idsubject`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_ibfk_2` FOREIGN KEY (`idteacher`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
