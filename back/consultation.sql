-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Maj 2020, 12:22
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.2.28

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
-- Struktura tabeli dla tabeli `consultation_scheme`
--

CREATE TABLE `consultation_scheme` (
  `id` int(11) NOT NULL,
  `teacher_subject_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `day` int(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `consultation_scheme`
--

INSERT INTO `consultation_scheme` (`id`, `teacher_subject_id`, `start_time`, `finish_time`, `day`, `start_date`, `end_date`) VALUES
(2, 2, '10:00:00', '11:00:00', 1, '2020-04-22', '2020-05-15');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `student_consultation`
--

CREATE TABLE `student_consultation` (
  `id` int(11) NOT NULL,
  `consultation_id` int(11) NOT NULL,
  `student_name` varchar(40) NOT NULL,
  `student_surname` varchar(40) NOT NULL,
  `student_email` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `student_consultation`
--

INSERT INTO `student_consultation` (`id`, `consultation_id`, `student_name`, `student_surname`, `student_email`, `date`, `start_time`, `finish_time`, `accepted`) VALUES
(1, 2, 'Adam', 'Kwiat', 'kwiat.adam@gmail.com', '2020-05-02', '10:00:00', '10:10:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `subject`
--

INSERT INTO `subject` (`id`, `name`) VALUES
(1, 'Grafika komputerowa'),
(2, 'Programowanie'),
(3, 'Analiza matematyczna');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `first_login` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `surname`, `password`, `email`, `first_login`) VALUES
(1, 'Adam', 'Nowak', '$2y$10$DHv0HDGuVWhKXZAFFAyAReQWKUY7M5rDZGajLy6ukJcIowD8WsgJ6', 'adam.nowak@us.pl', 0),
(2, 'Jan', 'Kowalski', '$2y$10$wVAwO4Hk6Ana7mfhdFQGse0aMsu23xs9sepRxevs.IAhl1Ko2EwzK', 'jan.kowalski@us.pl', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `teacher_subject`
--

CREATE TABLE `teacher_subject` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `teacher_subject`
--

INSERT INTO `teacher_subject` (`id`, `teacher_id`, `subject_id`) VALUES
(2, 2, 2),
(6, 1, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `consultation_scheme`
--
ALTER TABLE `consultation_scheme`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_teacher_id` (`teacher_subject_id`);

--
-- Indeksy dla tabeli `student_consultation`
--
ALTER TABLE `student_consultation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consult_id` (`consultation_id`);

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
-- Indeksy dla tabeli `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `consultation_scheme`
--
ALTER TABLE `consultation_scheme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `student_consultation`
--
ALTER TABLE `student_consultation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `teacher_subject`
--
ALTER TABLE `teacher_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `consultation_scheme`
--
ALTER TABLE `consultation_scheme`
  ADD CONSTRAINT `consultation_scheme_ibfk_1` FOREIGN KEY (`teacher_subject_id`) REFERENCES `teacher_subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `student_consultation`
--
ALTER TABLE `student_consultation`
  ADD CONSTRAINT `student_consultation_ibfk_1` FOREIGN KEY (`consultation_id`) REFERENCES `consultation_scheme` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `teacher_subject`
--
ALTER TABLE `teacher_subject`
  ADD CONSTRAINT `teacher_subject_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_subject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
