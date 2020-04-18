--
-- Datenbank: `cnperfmon`
--
CREATE DATABASE IF NOT EXISTS `cnperfmon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_german2_ci;
USE `cnperfmon`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cnperf_inventory`
--

CREATE TABLE `cnperf_inventory` (
  `id` int(11) NOT NULL,
  `hostname` varchar(50) COLLATE utf8mb4_german2_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_dttm` datetime NOT NULL DEFAULT current_timestamp(),
  `lastupd_dttm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cnperf_inventory`
--
ALTER TABLE `cnperf_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hostname` (`hostname`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cnperf_inventory`
--
ALTER TABLE `cnperf_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
