-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2026 at 05:12 AM
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
-- Database: `admindb`
--
CREATE DATABASE IF NOT EXISTS `admindb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `admindb`;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_address`, `quantity`, `delivery_date`, `payment_method`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 'Kirsten', 'Manibaug, Porac', 1, '2026-02-15', 'Cash on Delivery', 'Completed', '2026-02-15 16:12:09', '2026-02-15 16:12:09'),
(2, 'Krizie Lagman', 'Ma. Victoria St., Essel', 2, '2026-02-17', 'Card', 'Completed', '2026-02-15 16:58:55', '2026-02-15 16:58:55'),
(3, 'Leewel Nash', 'Sapangbato', 2, '2026-02-19', 'G-Cash', 'Completed', '2026-02-16 03:55:25', '2026-02-16 03:55:25'),
(4, 'Alexa', 'Fatima, Porac', 3, '2026-02-16', 'Cash on Delivery', 'Completed', '2026-02-16 00:29:28', '2026-02-16 00:29:28'),
(5, 'Chris Almocera', 'Holy Angel University', 2, '2026-02-16', 'Cash', 'Completed', '2026-02-16 00:34:33', '2026-02-16 00:34:33'),
(6, 'Samantha Yandan', '123, Mexico', 3, '2026-02-16', 'G-Cash', 'Completed', '2026-02-16 00:45:01', '2026-02-16 00:45:01'),
(7, 'Raquel Rivera', 'Holy Angel University', 4, '2026-02-16', 'Card', 'Completed', '2026-02-16 00:47:56', '2026-02-16 00:47:56'),
(8, 'Giane', 'Essel Park', 2, '2026-02-16', 'G-Cash', 'Completed', '2026-02-16 00:51:13', '2026-02-16 00:51:13'),
(9, 'Sigma Boy', 'Mabangis St.', 2, '2026-02-16', 'Cash on Delivery', 'Completed', '2026-02-16 00:52:26', '2026-02-16 00:52:26'),
(10, 'Jolly Vee', 'MM St.', 4, '2026-02-16', 'Cash on Delivery', 'Completed', '2026-02-16 00:54:02', '2026-02-16 00:54:02'),
(11, 'Will Byers', 'Upside Down', 2, '2026-02-16', 'Card', 'Completed', '2026-02-16 00:57:49', '2026-02-16 00:57:49'),
(12, 'Junjun Delacruz', 'Angeles City', 5, '2026-02-19', 'Cash on Delivery', 'Pending', '2026-02-16 02:58:41', '2026-02-16 02:58:41'),
(13, 'Marietes Santos', 'Mining Subd.', 3, '2026-02-16', 'Cash', 'Completed', '2026-02-16 03:55:04', '2026-02-16 03:55:04'),
(14, 'Princess Cya', 'Angeles city', 3, '2026-02-17', 'Card', 'Pending', '2026-02-16 03:00:04', '2026-02-16 03:00:04'),
(15, 'Sherryon Top', 'Angeles City', 3, '2026-02-16', 'Cash on Delivery', 'Pending', '2026-02-16 03:00:36', '2026-02-16 03:00:36'),
(16, 'Sabrina', 'Balibago', 2, '2026-02-16', 'Card', 'Pending', '2026-02-16 03:47:13', '2026-02-16 03:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Database: `badgereview`
--
CREATE DATABASE IF NOT EXISTS `badgereview` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `badgereview`;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `units` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `units`) VALUES
(101, 'Database Systems', 4),
(102, 'Network Systems', 4),
(103, 'Computer Ethics', 3),
(104, 'Calculus', 3);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `salary` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `emp_name`, `department`, `salary`) VALUES
(1001, 'Sherly', 'SAS', 50000.00),
(1002, 'Alma', 'SED', 40000.00),
(1003, 'Joven', 'SOC', 49000.00),
(1004, 'Chris', 'SOC', 20000.00),
(1005, 'Cristina', 'SAS', 52000.00),
(1006, 'Marc', 'SED', 55000.00),
(1007, 'JJ', 'SOC', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `grade`) VALUES
(1, 1, 101, 9.99),
(2, 1, 102, 9.99),
(3, 1, 103, 9.99),
(4, 1, 104, 9.99),
(5, 2, 101, 9.99),
(6, 3, 102, 9.99),
(7, 4, 103, 9.99),
(8, 4, 104, 9.99);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `year_level` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `course`, `year_level`) VALUES
(1, 'Ananya', 'CSE', '1st'),
(2, 'Bryle', 'WEB', '2nd'),
(3, 'Alex', 'EMC', '3rd'),
(4, 'Adler', 'IT', '4th');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `idx_course_name` (`course_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `fk_student` (`student_id`),
  ADD KEY `fk_course` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-02-16 04:11:32', '{\"Console\\/Mode\":\"collapse\",\"NavigationWidth\":0}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `school_enrollment`
--
CREATE DATABASE IF NOT EXISTS `school_enrollment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `school_enrollment`;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `year_level` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `subject_id1` int(11) DEFAULT NULL,
  `subject_id2` int(11) DEFAULT NULL,
  `subject_id3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `year_level`, `email`, `birthdate`, `subject_id1`, `subject_id2`, `subject_id3`) VALUES
(2, 'Maria', 'Santos', '2', NULL, NULL, 2, 6, NULL),
(3, 'Pedro', 'Reyes', '4', NULL, NULL, 2, 6, NULL),
(4, 'Kirsten', 'Zapanta', '2', NULL, NULL, 4, 5, 3),
(5, 'Amrex', 'Mayo', '4', NULL, NULL, 3, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students_backup`
--

CREATE TABLE `students_backup` (
  `student_id` int(11) NOT NULL DEFAULT 0,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `year_level` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `subject_id1` int(11) DEFAULT NULL,
  `subject_id2` int(11) DEFAULT NULL,
  `subject_id3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_backup`
--

INSERT INTO `students_backup` (`student_id`, `first_name`, `last_name`, `year_level`, `email`, `birthdate`, `subject_id1`, `subject_id2`, `subject_id3`) VALUES
(2, 'Maria', 'Santos', '2', NULL, NULL, 2, 6, NULL),
(3, 'Pedro', 'Reyes', '4', NULL, NULL, 2, 6, NULL),
(4, 'Kirsten', 'Zapanta', '2', NULL, NULL, 4, 5, 3),
(5, 'Amrex', 'Mayo', '4', NULL, NULL, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects_backup`
--

CREATE TABLE `subjects_backup` (
  `subject_id` int(11) NOT NULL DEFAULT 0,
  `subject_code` varchar(10) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `units` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects_backup`
--

INSERT INTO `subjects_backup` (`subject_id`, `subject_code`, `subject_name`, `units`) VALUES
(2, 'CS201', 'Data Structures', 3),
(3, 'IT202', 'Advanced Database Systems', 3),
(4, 'WD101', 'DWEB', 3),
(5, 'WD202', 'ITN', 3),
(6, 'CS101', 'ComEthics', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Database: `student_portal`
--
CREATE DATABASE IF NOT EXISTS `student_portal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `student_portal`;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `firstname`, `lastname`, `course`, `year_level`) VALUES
(1, 'Krizie', 'Lagman', 'InfoMan', 3),
(2, 'Alexa', 'Sanchez', 'ITN', 2),
(3, 'Nash', 'Tumang', 'DWEB', 2),
(5, 'Kirsten', 'Zapanta', 'DWEB', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `units` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `units`) VALUES
(1, 'InfoMan', 3),
(2, 'ITN', 3),
(3, 'DWEB', 4),
(4, 'CalPhyLec', 2),
(5, 'CalPhyLab', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
--
-- Database: `zapanta_college`
--
CREATE DATABASE IF NOT EXISTS `zapanta_college` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zapanta_college`;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `CLASS_CODE` varchar(10) NOT NULL,
  `CRS_CODE` varchar(10) DEFAULT NULL,
  `CLASS_SECTION` varchar(10) DEFAULT NULL,
  `CLASS_TIME` varchar(20) DEFAULT NULL,
  `CLASS_ROOM` varchar(10) DEFAULT NULL,
  `PROF_NUM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`CLASS_CODE`, `CRS_CODE`, `CLASS_SECTION`, `CLASS_TIME`, `CLASS_ROOM`, `PROF_NUM`) VALUES
('10610', 'WebDev3', 'WD301', '12PM-9PM', 'MGN 305', 111),
('10731', 'Web3', 'WD302', '1PM-8PM', 'MGN 302', 444),
('10751', 'Media2', 'EM202', '4PM-8PM', 'SJH 710', 333),
('16048', 'ComSci2', 'CS203', '7AM-12PM', 'SJH 506', 555),
('17980', 'NetAd4', 'NW402', '10AM-3PM', 'SJH 706', 222);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CRS_CODE` varchar(10) NOT NULL,
  `DEPT_CODE` varchar(20) DEFAULT NULL,
  `CRS_DESCRIPTION` varchar(100) DEFAULT NULL,
  `CRS_CREDIT` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CRS_CODE`, `DEPT_CODE`, `CRS_DESCRIPTION`, `CRS_CREDIT`) VALUES
('ComSci2', 'CS', 'Computer Ethics', 2),
('Media2', 'EMC', 'Intro to Animation', 3),
('NetAd4', 'ITNA', 'Network Administration', 3),
('Web3', 'ITWD', 'Web Programming 101', 3),
('WebDev3', 'ITWD', 'Dynamic Web Programming', 3);

-- --------------------------------------------------------

--
-- Table structure for table `enroll`
--

CREATE TABLE `enroll` (
  `CLASS_CODE` varchar(10) NOT NULL,
  `STU_NUM` int(11) NOT NULL,
  `ENROLL_GRADE` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enroll`
--

INSERT INTO `enroll` (`CLASS_CODE`, `STU_NUM`, `ENROLL_GRADE`) VALUES
('10610', 1, '1.25'),
('10731', 4, '1.25'),
('10751', 3, '1.25'),
('16048', 5, '1.50'),
('17980', 2, '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `STU_NUM` int(11) NOT NULL,
  `STU_LNAME` varchar(50) DEFAULT NULL,
  `STU_FNAME` varchar(50) DEFAULT NULL,
  `STU_INIT` char(1) DEFAULT NULL,
  `STU_DOB` date DEFAULT NULL,
  `STU_HRS` int(11) DEFAULT NULL,
  `STU_CLASS` varchar(20) DEFAULT NULL,
  `STU_GPA` decimal(4,2) DEFAULT NULL,
  `STU_TRANSFER` tinyint(1) DEFAULT NULL,
  `DEPT_CODE` varchar(20) DEFAULT NULL,
  `STU_PHONE` int(11) DEFAULT NULL,
  `PROF_NUM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`STU_NUM`, `STU_LNAME`, `STU_FNAME`, `STU_INIT`, `STU_DOB`, `STU_HRS`, `STU_CLASS`, `STU_GPA`, `STU_TRANSFER`, `DEPT_CODE`, `STU_PHONE`, `PROF_NUM`) VALUES
(1, 'Castro', 'Ryza', 'C', '2005-05-09', 35, 'Junior', 1.00, 1, 'ITWD', 2147483647, 111),
(2, 'Mayo', 'Amrex', 'C', '2003-10-30', 40, 'Senior', 1.75, 1, 'ITNA', 2147483647, 222),
(3, 'Gutierrez', 'Dianna', 'D', '2006-09-29', 35, 'Sophomore', 1.00, 1, 'EMC', 2147483647, 333),
(4, 'Colis', 'Mark', 'D', '2005-10-05', 20, 'Junior', 1.00, 1, 'ITWD', 2147483647, 444),
(5, 'Dela Cruz', 'Pia', 'A', '2006-04-06', 26, 'Sophomore', 1.25, 0, 'CS', 2147483647, 555);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`CLASS_CODE`),
  ADD KEY `CRS_CODE` (`CRS_CODE`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CRS_CODE`);

--
-- Indexes for table `enroll`
--
ALTER TABLE `enroll`
  ADD PRIMARY KEY (`CLASS_CODE`,`STU_NUM`),
  ADD KEY `STU_NUM` (`STU_NUM`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`STU_NUM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `STU_NUM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`CRS_CODE`) REFERENCES `course` (`CRS_CODE`);

--
-- Constraints for table `enroll`
--
ALTER TABLE `enroll`
  ADD CONSTRAINT `enroll_ibfk_1` FOREIGN KEY (`CLASS_CODE`) REFERENCES `class` (`CLASS_CODE`),
  ADD CONSTRAINT `enroll_ibfk_2` FOREIGN KEY (`STU_NUM`) REFERENCES `student` (`STU_NUM`);
--
-- Database: `zapanta_gamedb`
--
CREATE DATABASE IF NOT EXISTS `zapanta_gamedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zapanta_gamedb`;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `game_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_platform`
--

CREATE TABLE `game_platform` (
  `gplat_id` int(11) NOT NULL,
  `gp_id` int(11) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `release_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game_publisher`
--

CREATE TABLE `game_publisher` (
  `gp_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `publisher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_name`) VALUES
(1, 'Racing'),
(2, 'Strategy'),
(3, 'Survival');

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `platform_id` int(11) NOT NULL,
  `platform_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`platform_id`, `platform_name`) VALUES
(1, 'Playstation'),
(2, 'Xbox'),
(3, 'NVIDIA');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` int(11) NOT NULL,
  `publisher_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisher_id`, `publisher_name`) VALUES
(1, 'Nintendo'),
(2, 'Sony'),
(3, 'Microsoft');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `region_id` int(11) NOT NULL,
  `region_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `region_sales`
--

CREATE TABLE `region_sales` (
  `gplat_id` int(11) NOT NULL,
  `num_sales` int(11) DEFAULT NULL,
  `region_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `game_platform`
--
ALTER TABLE `game_platform`
  ADD PRIMARY KEY (`gplat_id`),
  ADD KEY `gp_id` (`gp_id`),
  ADD KEY `platform_id` (`platform_id`);

--
-- Indexes for table `game_publisher`
--
ALTER TABLE `game_publisher`
  ADD PRIMARY KEY (`gp_id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`platform_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `region_sales`
--
ALTER TABLE `region_sales`
  ADD PRIMARY KEY (`region_id`,`gplat_id`),
  ADD KEY `gplat_id` (`gplat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_platform`
--
ALTER TABLE `game_platform`
  MODIFY `gplat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game_publisher`
--
ALTER TABLE `game_publisher`
  MODIFY `gp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `platform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);

--
-- Constraints for table `game_platform`
--
ALTER TABLE `game_platform`
  ADD CONSTRAINT `game_platform_ibfk_1` FOREIGN KEY (`gp_id`) REFERENCES `game_publisher` (`gp_id`),
  ADD CONSTRAINT `game_platform_ibfk_2` FOREIGN KEY (`platform_id`) REFERENCES `platform` (`platform_id`);

--
-- Constraints for table `game_publisher`
--
ALTER TABLE `game_publisher`
  ADD CONSTRAINT `game_publisher_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`),
  ADD CONSTRAINT `game_publisher_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`publisher_id`);

--
-- Constraints for table `region_sales`
--
ALTER TABLE `region_sales`
  ADD CONSTRAINT `region_sales_ibfk_1` FOREIGN KEY (`gplat_id`) REFERENCES `game_platform` (`gplat_id`),
  ADD CONSTRAINT `region_sales_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
