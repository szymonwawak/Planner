-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Kwi 2020, 21:01
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
-- Baza danych: `consultation`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `consult_scheme`
--

CREATE TABLE `consult_scheme` (
  `idconsult` int(11) NOT NULL,
  `idlesson` int(11) NOT NULL,
  `consultdate` date NOT NULL,
  `starttime` time NOT NULL,
  `finishtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `consult_scheme`
--

INSERT INTO `consult_scheme` (`idconsult`, `idlesson`, `consultdate`, `starttime`, `finishtime`) VALUES
(1, 1, '2020-05-12', '10:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `consult_student`
--

CREATE TABLE `consult_student` (
  `idstudent` int(11) NOT NULL,
  `idconsult` int(11) NOT NULL,
  `starttime` time NOT NULL,
  `finishtime` time NOT NULL,
  `studentname` varchar(40) NOT NULL,
  `studentsurname` varchar(40) NOT NULL,
  `studentemail` varchar(40) NOT NULL,
  `accepted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `consult_student`
--

INSERT INTO `consult_student` (`idstudent`, `idconsult`, `starttime`, `finishtime`, `studentname`, `studentsurname`, `studentemail`, `accepted`) VALUES
(1, 1, '10:00:00', '10:10:00', 'Adam', 'Kowal', 'adam@kowal.pl', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lesson`
--

CREATE TABLE `lesson` (
  `idlesson` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `idsubject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lesson`
--

INSERT INTO `lesson` (`idlesson`, `id`, `idsubject`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subject`
--

CREATE TABLE `subject` (
  `idsubject` int(11) NOT NULL,
  `subjectname` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `subject`
--

INSERT INTO `subject` (`idsubject`, `subjectname`) VALUES
(1, 'Grafika komputerowa'),
(2, 'Systemy operacyjne');

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
(1, 'kowalski.jan@us.pl', '$2y$10$nK.df1MT.kJRk1Vj3ywIgOmhE1eAT6wbwIJQx0CTWmirZgE2pNRMu', 'Jan', 'Kowalski'),
(2, 'nowak.anna@us.pl', '$2y$10$nK.df1MT.kJRk1Vj3ywIgOmhE1eAT6wbwIJQx0CTWmirZgE2pNRMu', 'Anna', 'Nowak'),
(3, 'kwiat.adam@o2.pl', '$2y$10$nK.df1MT.kJRk1Vj3ywIgOmhE1eAT6wbwIJQx0CTWmirZgE2pNRMu', 'Adam', 'Kwiat');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `consult_scheme`
--
ALTER TABLE `consult_scheme`
  ADD PRIMARY KEY (`idconsult`),
  ADD KEY `idlesson` (`idlesson`);

--
-- Indeksy dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  ADD PRIMARY KEY (`idstudent`),
  ADD KEY `idconsult` (`idconsult`);

--
-- Indeksy dla tabeli `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`idlesson`),
  ADD KEY `id` (`id`),
  ADD KEY `idsubject` (`idsubject`);

--
-- Indeksy dla tabeli `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`idsubject`);

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
  MODIFY `idconsult` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  MODIFY `idstudent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `lesson`
--
ALTER TABLE `lesson`
  MODIFY `idlesson` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `subject`
--
ALTER TABLE `subject`
  MODIFY `idsubject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `consult_scheme`
--
ALTER TABLE `consult_scheme`
  ADD CONSTRAINT `consult_scheme_ibfk_1` FOREIGN KEY (`idlesson`) REFERENCES `lesson` (`idlesson`);

--
-- Ograniczenia dla tabeli `consult_student`
--
ALTER TABLE `consult_student`
  ADD CONSTRAINT `consult_student_ibfk_1` FOREIGN KEY (`idconsult`) REFERENCES `consult_scheme` (`idconsult`);

--
-- Ograniczenia dla tabeli `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`id`) REFERENCES `teacher` (`id`),
  ADD CONSTRAINT `lesson_ibfk_2` FOREIGN KEY (`idsubject`) REFERENCES `subject` (`idsubject`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
