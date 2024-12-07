-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 01:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `layanan`
--
CREATE DATABASE IF NOT EXISTS `layanan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `layanan`;

-- --------------------------------------------------------

--
-- Table structure for table `request_for_change`
--

CREATE TABLE `request_for_change` (
  `id` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `owner` varchar(100) NOT NULL,
  `initiator` varchar(100) NOT NULL,
  `priority` enum('High','Medium','Low','Urgent') NOT NULL,
  `description` text NOT NULL,
  `risk` text NOT NULL,
  `time` varchar(100) NOT NULL,
  `resources` text NOT NULL,
  `budget` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_for_change`
--

INSERT INTO `request_for_change` (`id`, `tanggal`, `owner`, `initiator`, `priority`, `description`, `risk`, `time`, `resources`, `budget`, `file_path`, `status`) VALUES
('RFC-2024-001', '2024-12-11', 'John Doe', 'IT Department', 'High', 'The request is to upgrade the existing email server from version 2.3 to version 3.0 to address performance issues, enhance security, and provide better integration with the new CRM system.', 'Possible downtime during the migration process (estimated 2 hours).\r\nCompatibility issues with legacy applications.\r\nUser adoption challenges due to minor interface changes.', 'December 15, 2024, from 1:00 AM to 3:00 AM', 'Personnel: 2 IT Engineers, 1 Project Manager\r\nTools/Software: Migration tool provided by the vendor, backup solution\r\nDuration: 2 hours for migration, 1 week for testing and follow-up', '$5,000', 'file/Facebook Live Sellers in Thailand_20210128.xlsx', 'Selesai'),
('RFC-2024-002', '2024-12-07', 'Jane Smith', 'Finance Department', 'Medium', 'Implementation of a new financial reporting module in the existing ERP system to comply with updated regulatory requirements and streamline monthly financial closing processes.', 'Data migration errors during transfer from the old system to the new module.\r\nPotential delays in financial report generation during the first month post-implementation.', 'December 10, 2024 - December 20, 2024 ', 'Personnel: 1 ERP consultant, 2 finance team members, 1 IT support staff\r\nTools/Software: New module license, data migration tools, testing environment\r\nDuration: 3 weeks for full implementation and testing', '$15,000', 'file/Manual_Book_SIPINTER.pdf', 'Diproses'),
('RFC-2024-003', '2024-12-09', 'Michael Johnson', 'Human Resources Department', 'Low', 'Upgrade the employee self-service portal to include new features such as leave balance tracking, performance review history, and automated tax document downloads.', 'Potential downtime of the portal during the upgrade process.\r\nEmployee unfamiliarity with new features, requiring additional training.', 'December 15 2025 - January 5 2025', 'Personnel: 1 HR system analyst, 1 IT engineer, 1 UX designer\r\nTools/Software: Portal upgrade license, testing server\r\nDuration: 2 weeks\r\n', '$10,000', 'file/12.+Nina+Amelia+Silitonga_1270+(1383-1395).pdf', 'Menunggu Persetujuan'),
('RFC-2024-004', '2024-12-11', 'Sarah Lee', 'IT Operations Team', 'Urgent', 'Emergency replacement of the primary firewall device due to critical hardware failure, which has resulted in network security vulnerabilities and intermittent connectivity issues.', 'Temporary disconnection from the internet and internal systems during replacement.\r\nPotential risk of misconfiguration causing extended downtime.', 'December 8, 2024 - December 10, 2024', 'Personnel: 2 network engineers, 1 IT security specialist\r\nTools/Software: New firewall hardware, configuration scripts\r\nDuration: 2 days', '$20,000', 'file/20240801205248_pedoman_skripsi_fst_wajib_menghafal_juz_30_sebagai_syarat_sidang.pdf', 'Dibatalkan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request_for_change`
--
ALTER TABLE `request_for_change`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
