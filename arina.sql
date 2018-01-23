-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Січ 23 2018 р., 22:57
-- Версія сервера: 5.6.37
-- Версія PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `arina_new`
--

-- --------------------------------------------------------

--
-- Структура таблиці `accounting_mounth`
--

CREATE TABLE `accounting_mounth` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `accounting_year`
--

CREATE TABLE `accounting_year` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `mounth` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `passwordHash` varchar(255) NOT NULL,
  `passwordResetToken` varchar(255) DEFAULT NULL,
  `passwordResetExpire` int(11) DEFAULT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL,
  `authKey` varchar(32) DEFAULT NULL,
  `emailConfirmToken` varchar(255) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `firstName`, `lastName`, `role`, `status`, `passwordHash`, `passwordResetToken`, `passwordResetExpire`, `createdAt`, `updatedAt`, `authKey`, `emailConfirmToken`, `data`) VALUES
(1, 'admin', 'admin@test.com', 'Admin', 'Admin', NULL, 1, '$2y$13$tzrTVmmf57FYb9m/QTGg3eUAg3Q1diYhY9z.wafOYuCIQAN4B9pHG', NULL, NULL, 1493203743, 1493203743, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `big_village`
--

CREATE TABLE `big_village` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `region_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `characteristics_type`
--

CREATE TABLE `characteristics_type` (
  `id` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `region_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL,
  `district_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `curator_group`
--

CREATE TABLE `curator_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `cyclic_commission`
--

CREATE TABLE `cyclic_commission` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `head_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `department`
--

INSERT INTO `department` (`id`, `title`, `head_id`) VALUES
(3, 'Економіки та менеджменту', NULL),
(4, 'Інженерної механіки', NULL),
(5, 'Автомобільний транспорт', NULL),
(6, 'Комп’ютерної інженерії', NULL),
(7, 'Програмної інженерії', NULL),
(8, 'ЗАОЧНЕ', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `directories_audience`
--

CREATE TABLE `directories_audience` (
  `id` int(11) NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `id_teacher` int(11) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `directories_audience`
--

INSERT INTO `directories_audience` (`id`, `number`, `name`, `type`, `id_teacher`, `capacity`) VALUES
(1, '111', NULL, 1, NULL, NULL),
(2, '133', NULL, 1, NULL, NULL),
(3, '247', NULL, 1, NULL, NULL),
(4, '124a', NULL, 1, NULL, NULL),
(5, '139a', NULL, 1, NULL, NULL),
(6, '124', NULL, 1, NULL, NULL),
(7, '211', NULL, 2, NULL, NULL),
(8, '123', NULL, 1, NULL, NULL),
(9, '122', NULL, 1, NULL, NULL),
(10, '244a', NULL, 2, NULL, NULL),
(11, '231', NULL, 2, NULL, NULL),
(12, '232', NULL, 2, NULL, NULL),
(13, '235', NULL, 2, NULL, NULL),
(14, '243', NULL, 2, NULL, NULL),
(15, '121', NULL, 1, NULL, NULL),
(16, '125', NULL, 1, NULL, NULL),
(17, '126', NULL, 1, NULL, NULL),
(18, '127', NULL, 1, NULL, NULL),
(19, '128', NULL, 1, NULL, NULL),
(20, '129', NULL, 1, NULL, NULL),
(21, '131', NULL, 1, NULL, NULL),
(22, '131a', NULL, 1, NULL, NULL),
(23, '132', NULL, 2, NULL, NULL),
(24, '132a', NULL, 1, NULL, NULL),
(25, '134', NULL, 2, NULL, NULL),
(26, '134a', NULL, 1, NULL, NULL),
(27, '135', NULL, 1, NULL, NULL),
(28, '135a', NULL, 1, NULL, NULL),
(29, '136a', NULL, 1, NULL, NULL),
(30, '137', NULL, 1, NULL, NULL),
(31, '137a', NULL, 2, NULL, NULL),
(32, '138', NULL, 1, NULL, NULL),
(33, '138a', NULL, 1, NULL, NULL),
(34, '141', NULL, 1, NULL, NULL),
(35, '141a', NULL, 1, NULL, NULL),
(36, '142', NULL, 1, NULL, NULL),
(37, '145', NULL, 1, NULL, NULL),
(38, '142a', NULL, 1, NULL, NULL),
(39, '143', NULL, 1, NULL, NULL),
(40, '144a', NULL, 1, NULL, NULL),
(41, '143a', NULL, 1, NULL, NULL),
(42, '144', NULL, 1, NULL, NULL),
(43, '145a', NULL, 1, NULL, NULL),
(44, '146', NULL, 1, NULL, NULL),
(45, '146a', NULL, 1, NULL, NULL),
(46, '147', NULL, 1, NULL, NULL),
(47, '147a', NULL, 1, NULL, NULL),
(48, '148', NULL, 1, NULL, NULL),
(49, '149', NULL, 1, NULL, NULL),
(50, '149a', NULL, 1, NULL, NULL),
(51, '222', NULL, 1, NULL, NULL),
(52, '234', NULL, 1, NULL, NULL),
(53, '233', NULL, 2, NULL, NULL),
(54, '235a', NULL, 2, NULL, NULL),
(55, '236', NULL, 1, NULL, NULL),
(56, '237', NULL, 1, NULL, NULL),
(57, '239', NULL, 1, NULL, NULL),
(58, '239a', NULL, 1, NULL, NULL),
(59, '241', NULL, 1, NULL, NULL),
(60, '242', NULL, 1, NULL, NULL),
(61, '243a', NULL, 2, NULL, NULL),
(62, '243б', NULL, 2, NULL, NULL),
(63, '246', NULL, 1, NULL, NULL),
(64, '248', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `district`
--

CREATE TABLE `district` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `region_id` int(11) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `is_in_education` smallint(6) NOT NULL,
  `position_id` int(2) NOT NULL,
  `category_id` int(2) NOT NULL,
  `type` int(2) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` smallint(6) NOT NULL,
  `cyclic_commission_id` int(2) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `passport` varchar(10) DEFAULT NULL,
  `passport_issued_by` varchar(30) DEFAULT NULL,
  `passport_issued_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `employee`
--

INSERT INTO `employee` (`id`, `is_in_education`, `position_id`, `category_id`, `type`, `first_name`, `middle_name`, `last_name`, `gender`, `cyclic_commission_id`, `birth_date`, `passport`, `passport_issued_by`, `passport_issued_date`, `start_date`) VALUES
(1, 0, 2, 1, 0, 'yjtyj', 'tyjtyj', 'fjf', 0, NULL, '2017-05-17', 'RT №456456', 'tryrtyrtuy', '2017-05-31', '2017-05-04');

-- --------------------------------------------------------

--
-- Структура таблиці `employee_education`
--

CREATE TABLE `employee_education` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `name_of_institution` varchar(64) DEFAULT NULL,
  `document` varchar(64) DEFAULT NULL,
  `graduation_year` int(11) DEFAULT NULL,
  `speciality` varchar(64) DEFAULT NULL,
  `qualification` varchar(64) DEFAULT NULL,
  `education_form` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL,
  `value` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `evaluation_systems`
--

CREATE TABLE `evaluation_systems` (
  `id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `exemptions`
--

CREATE TABLE `exemptions` (
  `id` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `exemptions`
--

INSERT INTO `exemptions` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'дитина сирота', 1495012534, 1495012534),
(2, 'інвалід 2-групи', 1495012563, 1495012563),
(3, 'інвалід 3-групи', 1495012590, 1495012590),
(4, 'дитина під опікою', 1495012612, 1495012612),
(5, 'діти - переселенці', 1495012640, 1495012640);

-- --------------------------------------------------------

--
-- Структура таблиці `exemptions_students_relations`
--

CREATE TABLE `exemptions_students_relations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exemption_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `information` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `family_relation`
--

CREATE TABLE `family_relation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `work_place` varchar(255) DEFAULT NULL,
  `work_position` varchar(255) DEFAULT NULL,
  `phone1` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `family_relation_type`
--

CREATE TABLE `family_relation_type` (
  `id` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `speciality_qualifications_id` int(11) DEFAULT NULL,
  `created_study_year_id` int(11) DEFAULT NULL,
  `number_group` smallint(6) DEFAULT NULL,
  `title` varchar(8) DEFAULT NULL,
  `group_leader_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `group`
--

INSERT INTO `group` (`id`, `speciality_qualifications_id`, `created_study_year_id`, `number_group`, `title`, `group_leader_id`) VALUES
(1, 2, 1, 2, 'ПР132', 35),
(2, 2, 1, 1, 'ПР131', NULL),
(3, 2, 2, 1, 'ПР141', NULL),
(4, 2, 2, 2, 'ПР142', 181),
(5, 2, 4, 1, 'ПР151', NULL),
(6, 2, 4, 2, 'ПР152', 112),
(7, 1, 5, 1, 'ПІ161', 141),
(8, 1, 5, 2, 'ПІ162', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `journal_mark`
--

CREATE TABLE `journal_mark` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `presence` tinyint(1) DEFAULT '1',
  `not_presence_reason_id` int(11) DEFAULT NULL,
  `evaluation_system_id` int(11) DEFAULT NULL,
  `evaluation_id` int(11) DEFAULT NULL,
  `ticket` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `retake_evaluation_id` int(11) DEFAULT NULL,
  `retake_ticket` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `retake_date` date DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `journal_record`
--

CREATE TABLE `journal_record` (
  `id` int(11) NOT NULL,
  `load_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `home_work` text COLLATE utf8_unicode_ci,
  `number` int(11) DEFAULT NULL,
  `number_in_day` int(11) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `audience_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `journal_record_types`
--

CREATE TABLE `journal_record_types` (
  `id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinyint(1) DEFAULT '0',
  `homework` tinyint(1) DEFAULT '0',
  `audience` int(11) DEFAULT NULL,
  `hours` tinyint(1) DEFAULT '0',
  `present` tinyint(1) DEFAULT '0',
  `date` tinyint(1) DEFAULT '0',
  `n_pp` tinyint(1) DEFAULT '0',
  `n_in_day` tinyint(1) DEFAULT '0',
  `ticket` tinyint(1) DEFAULT '0',
  `is_report` tinyint(1) DEFAULT '0',
  `report_title` varchar(182) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `journal_student`
--

CREATE TABLE `journal_student` (
  `id` int(11) NOT NULL,
  `load_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `load`
--

CREATE TABLE `load` (
  `id` int(11) NOT NULL,
  `study_year_id` int(10) DEFAULT NULL,
  `employee_id` int(10) DEFAULT NULL,
  `group_id` int(10) DEFAULT NULL,
  `work_subject_id` int(10) DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `course` int(10) DEFAULT NULL,
  `consult` varchar(255) DEFAULT NULL,
  `students` varchar(255) DEFAULT NULL,
  `fall_hours` varchar(255) DEFAULT NULL,
  `spring_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1493203740),
('m000000_000001_create_admin_table', 1493203743),
('m010517_092305_create_table_load', 1495526843),
('m150920_102406_create_geo_tables', 1496786219),
('m160911_143902_add_audience_table', 1493203743),
('m160911_143903_add_audience_data', 1493203744),
('m160915_111039_create_table_students', 1493203744),
('m161013_074655_table_refactoring', 1493203744),
('m161020_101318_create_department_table', 1493203744),
('m161020_172816_add_subject_table', 1493203744),
('m161020_172823_add_subject_data', 1493203744),
('m161022_093131_create_speciality_table', 1493203744),
('m161022_094857_create_speciality_qualification_table', 1493203745),
('m161022_095057_create_qualification_table', 1493203745),
('m161023_070635_add_columns_to_main_table', 1493203745),
('m161023_195857_add_refactoring_speciality_group_table', 1493203745),
('m161023_200213_add_study_year', 1493203745),
('m161023_200702_add_refactoring_qualification_group_table', 1493203745),
('m161023_202501_add_column_in_audience_table', 1493203746),
('m161025_055552_refactor_table_main', 1493203747),
('m161027_055442_create_table_group', 1493203747),
('m161027_071214_create_table_student_group', 1493203747),
('m161027_073835_create_table_founding_type', 1493203748),
('m161027_094620_create_position_table', 1493203748),
('m161027_094928_add_position_data', 1493203748),
('m161111_064314_refactor_student_group_tbl', 1493203748),
('m161203_071322_create_table_employee', 1493203748),
('m161203_082126_tbl_family_ties', 1493203748),
('m161203_084204_tbl_family_ties_types', 1493203748),
('m161205_202039_tbl_exemptions', 1493203748),
('m161205_202505_tbl_exemptions_relations', 1493203748),
('m161208_203645_tbl_student_history', 1493203749),
('m161210_195125_study_year_active_field', 1493203749),
('m161216_221247_del_tbl_student_group', 1493203749),
('m170101_161107_tbl_students_phones', 1493203749),
('m170101_161126_tbl_students_emails', 1493203749),
('m170117_145511_create_table_work_subject', 1493203749),
('m170117_150206_create_table_study_subject', 1493203749),
('m170117_163258_create_table_work_plan', 1493203749),
('m170117_164527_create_table_study_plan', 1493203749),
('m170205_141213_create_table_cyclic_commission', 1493203749),
('m170213_214153_tbl_curator_group', 1493203750),
('m170217_111854_add_speciality_data', 1493203750),
('m170218_145720_create_subject_relation_table', 1495526843),
('m170218_150317_add_subject_relation_data', 1495526843),
('m170218_161329_create_subject_cycle_table', 1493203750),
('m170218_161703_add_subject_cycle_data', 1493203750),
('m170219_090312_add_qualification_data', 1493203750),
('m170219_091633_add_speciality_qualification_data', 1493203750),
('m170228_065825_add_data_fields', 1493203750),
('m170228_100541_tbl_employee_education', 1493203751),
('m170317_104234_tbls_social_networks', 1493203751),
('m170319_183721_tbl_students_charateristics', 1493203751),
('m170424_073656_init_accounting', 1496786219),
('m170424_080707_init_accounting_year', 1496786219),
('m170515_072615_update_accounting_mounth', 1496786219),
('m170515_074001_update_accounting_year', 1496786220),
('m170521_114818_create_geo_district', 1496786220),
('m170521_132704_add_column_country_id_to_district', 1496786220),
('m170521_141621_add_column_district_id_to_city', 1496786220),
('m170522_061941_create_village_table', 1496786220),
('m170522_231134_create_table_big_village', 1496786220),
('m170523_204213_refactor_students_eemptions_relation', 1496301727),
('m170531_193614_tbls_evolation_systems_and_evolation', 1496301727),
('m170601_192404_tbl_journal_record', 1496786221),
('m170606_210311_tbl_student_journal', 1496786221),
('m170618_133732_tbl_student_not_presence', 1516300409),
('m170621_075956_tbl_record_types', 1516300409),
('m170621_214244_tbl_record_type_refactor', 1516300409),
('m170621_215904_tbl_record_refactor', 1516300409),
('m170622_064724_tbl_mark_refactor', 1516300409),
('m180107_154634_add_country_id_to_student', 1516300409),
('m180107_194604_rename_family_relation_table', 1516300409),
('m180117_160538_add_data_work_subject', 1493203751),
('m180117_161354_add_data_study_subject', 1493203751),
('m180117_162217_add_data_study_plan', 1493203751),
('m180117_163702_add_data_work_plan', 1493203751);

-- --------------------------------------------------------

--
-- Структура таблиці `not_presence_type`
--

CREATE TABLE `not_presence_type` (
  `id` int(11) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_great` tinyint(1) DEFAULT '0',
  `percent_hours` int(11) DEFAULT '100',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `max_hours_1` int(11) DEFAULT NULL,
  `max_hours_2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `position`
--

INSERT INTO `position` (`id`, `title`, `max_hours_1`, `max_hours_2`) VALUES
(1, 'Викладач', 720, 360),
(2, 'Завідувач', 720, 360),
(3, 'Директор', 720, 360);

-- --------------------------------------------------------

--
-- Структура таблиці `qualification`
--

CREATE TABLE `qualification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `qualification`
--

INSERT INTO `qualification` (`id`, `title`, `sort_order`) VALUES
(1, 'Молодший спеціаліст', NULL),
(2, 'Бакалавр', NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `country_id` int(11) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `social_networks`
--

CREATE TABLE `social_networks` (
  `id` int(11) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `speciality`
--

CREATE TABLE `speciality` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `accreditation_date` date DEFAULT NULL,
  `short_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `speciality`
--

INSERT INTO `speciality` (`id`, `title`, `department_id`, `number`, `accreditation_date`, `short_title`) VALUES
(1, 'Економіка', 3, '051', '1970-01-01', 'ЕК'),
(2, 'Економіка підприємства ', 3, '5.03050401 ', '1970-01-01', 'ЕП'),
(3, 'Менеджмент', 3, '073', '1970-01-01', 'МЕ'),
(4, 'Організація виробництва', 3, '5.03060101', '1970-01-01', 'ОВ'),
(5, 'Прикладна механіка', 4, '131', '1970-01-01', 'ПМ'),
(6, 'Обслуговування верстатів з програмним управлінням та робото-технічних комплексів', 4, '5.05050202', '1970-01-01', 'ВР'),
(7, 'Галузеве машинобудування', 4, '133', '1970-01-01', 'МГ'),
(8, 'Технологія обробки матеріалів на верстатах та автоматичних лініях', 4, '5.05050302 ', '1970-01-01', 'ОМ'),
(10, 'Автомобільний транспорт', 5, '131', '1970-01-01', 'АТ'),
(11, 'Обслуговування та ремонт автомобілів і двигунів', 5, '5.07010602', '1970-01-01', 'ОА'),
(12, 'Комп’ютерна інженерія', 6, '123', '1970-01-01', 'КІ'),
(13, 'Обслуговування комп’ютерних систем та мереж', 6, '5.05010201', '1970-01-01', 'КС'),
(14, 'Інженерія програмного забезпечення', 7, '121 ', '1970-01-01', 'ПІ'),
(15, 'Розробка програмного забезпечення', 7, '5.05010301', '1970-01-01', 'ПР');

-- --------------------------------------------------------

--
-- Структура таблиці `speciality_qualification`
--

CREATE TABLE `speciality_qualification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `speciality_id` int(11) DEFAULT NULL,
  `qualification_id` int(11) DEFAULT NULL,
  `years_count` int(11) DEFAULT NULL,
  `months_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `speciality_qualification`
--

INSERT INTO `speciality_qualification` (`id`, `title`, `speciality_id`, `qualification_id`, `years_count`, `months_count`) VALUES
(1, 'Технік-програміст', 14, 1, 3, 10),
(2, 'Технік-програміст', 15, 1, 3, 10);

-- --------------------------------------------------------

--
-- Структура таблиці `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `gender` smallint(6) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `birth_certificate` varchar(10) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `passport_issued` varchar(255) DEFAULT NULL,
  `student_code` varchar(12) DEFAULT NULL,
  `sseed_id` varchar(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `passport_code` varchar(12) DEFAULT NULL,
  `tax_id` varchar(10) DEFAULT NULL,
  `passport_issued_date` date DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `student`
--

INSERT INTO `student` (`id`, `last_name`, `first_name`, `middle_name`, `gender`, `birth_day`, `status`, `created_at`, `updated_at`, `birth_certificate`, `photo`, `passport_issued`, `student_code`, `sseed_id`, `user_id`, `passport_code`, `tax_id`, `passport_issued_date`, `country_id`, `region_id`, `district_id`) VALUES
(1, 'Якимишин', 'Богдан', 'Юрійович', 0, '1996-11-24', NULL, 1494536720, 1494536720, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Дзюбак', 'Владислав', 'Валентинович', 0, '1998-02-02', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Ковальчук', 'Олександр', 'Олегович', 0, '1997-01-14', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Коваль', 'Владислав', 'Вадимович', 0, '1997-07-05', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Кемінь', 'Максим', 'Вікторович', 0, '1997-12-11', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Зайчук', 'Богдана', 'Миколаївна', 1, '1998-02-28', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Ліповуз', 'Вадим', 'Вікторович', 0, '1998-01-10', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Дорожанський', 'Олексій', 'Олегович', 0, '1998-03-11', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Горяк', 'Дмитро', 'Вікторович', 0, '1998-08-20', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Горбатюк', 'Іван', 'Володимирович', 0, '1998-07-07', NULL, 1494536721, 1494536721, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Гайдай', 'Вадим', 'Геннадійович', 0, '2013-09-30', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Войцехівський', 'Владислав', 'Олександрович', 0, '1997-12-11', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Абдул', 'Рустам', 'Рауфович', 0, '1997-12-26', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Новацький', 'Олег', 'Валерійович', 0, '1998-01-15', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Мазуренко', 'Андрій', 'Володимирович', 0, '1997-11-24', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Маркітан', 'Максим', 'Олександрович', 0, '1998-01-02', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Никифоров', 'Андрій', 'Васильович', 0, '1998-05-29', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Ощепков', 'Віктор', 'Сергійович', 0, '1998-05-10', NULL, 1494536722, 1494536722, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Полюк', 'Денис', 'Вікторович', 0, '1997-10-21', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Попович', 'Андрій', 'Олегович', 0, '1997-12-13', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Самуляк', 'Роман', 'Русланович', 0, '1997-10-08', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Стецюк', 'Павло', 'Петрович', 0, '1998-08-04', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Ткач', 'Михайло', 'Борисович', 0, '1997-11-21', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Фаін', 'Артем', 'Борисович', 0, '1997-10-20', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Самотес', 'Владислав', 'Олександрович', 0, '2015-08-31', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Брітов', 'Олександр', 'Вікторович', 0, '1998-07-15', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Свінтков', 'Денис', 'Дмитрович', 0, '1970-01-01', NULL, 1494536723, 1494536723, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Войцехівський', 'Владислав', 'Ігорович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Гладищук', 'Дмитро', 'Володимирович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Горчилов', 'Іван', 'Іванович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Казаков', 'Олександр', 'Олександрович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Карвацький', 'Максим', 'Олегович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'Коваль', 'Олег', 'Ігорович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Ковальчук', 'Костянтин', 'Валерійович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'Когут', 'Василь', 'Сергійович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'Мельник', 'Андрій', 'Сергійович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'Петрук', 'Богдан', 'Євгенович', 0, '1970-01-01', NULL, 1494536724, 1494536724, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'Рикун', 'Валентин', 'Володимирович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Буров', 'Андрій', 'Юрійович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'Гуцалюк', 'Вікторія', 'Миколаївна', 1, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'Димков ', 'Микола', 'Костянтинович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Прокопенко', 'Єлизавета ', 'Сергіївна', 1, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'Яворський', 'Богдан', 'Сергійович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Скакун', 'Віталій', 'Володимирович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Федоров', 'Олександр', 'Олександрович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Чабан', 'Роман', 'Володимирович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Шмагайло', 'Вадим', 'Володимирович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Ющенко', 'Владислав', 'Богданович', 0, '1970-01-01', NULL, 1494536725, 1494536725, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Тихоненко ', 'Валерій', 'Олегович', 0, '2015-08-31', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Бліндар ', 'Юрій', 'Юрійович', 0, '1998-11-18', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Кудрявцев', 'Віктор', 'Володимирович', 0, '1999-05-11', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'Валєєв ', 'Андрій', 'Сергійович', 0, '1998-12-02', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'Боднар', 'Костянтин', 'Юрійович', 0, '1998-11-16', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'Коломієць', 'Олександр', 'Станіславович', 0, '1999-08-23', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'Кучмій', 'Олександр', 'Іванович', 0, '1999-06-02', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Воробйов ', 'Володимир', 'Сергійович', 0, '1999-06-11', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'Воронін', 'Олександр', 'Вікторович', 0, '1999-06-11', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Вавринчук', 'Едуард', 'Миколайович', 0, '1999-05-09', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'Адамчук', 'Юлія', 'Олегівна', 1, '1999-11-11', NULL, 1494536726, 1494536726, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Головня', 'Олександр', 'Олексндрович', 0, '1999-12-10', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Єльцин', 'Яніс', 'Сергійович', 0, '1999-04-23', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Атаман', 'Владислав', 'Олександрович', 0, '1998-11-07', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Заровний', 'Владислав', 'Ігірович', 0, '1999-04-19', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Борікун', 'Артур', 'Анатолійович', 0, '1999-02-25', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Дідух ', 'Ростислав', 'Юрійович', 0, '1998-08-08', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Козачок', 'Антон', 'Ігорович', 0, '1999-03-12', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Когут', 'Дмитро', 'Русланович', 0, '1998-11-08', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Біловол', 'Андрій', 'Ігорович', 0, '1999-02-10', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Боднар', 'Олексій', 'Валерійович', 0, '1999-10-10', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Зелінський', 'Михайло', 'Романович', 0, '1997-11-21', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Євстаф\'єва', 'Євгенія', 'Олексіївна', 1, '1999-03-20', NULL, 1494536727, 1494536727, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Вовкович', 'Дмитро', 'Валерійович', 0, '2000-09-29', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Лімаренко', 'Володимир', 'Олександрович', 0, '2000-03-27', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Нетреба', 'Ігор', 'Вікторович', 0, '1999-09-30', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Матвійцев', 'Ігор', 'Сергійович', 0, '2000-01-29', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Маленко', 'Олена', 'Романівна', 1, '1999-01-13', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Мойсюк', 'Даниіл', 'Миколайович', 0, '2000-06-22', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Дрищ', 'Катерина', 'Володимирівна', 1, '1999-12-07', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'Колос', 'Андрій', 'Богданович', 0, '2000-04-11', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'Кушнір', 'Дмитро', 'Віталійович', 0, '1999-08-15', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'Лозовський', 'Петро', 'Миколайович', 0, '2000-06-20', NULL, 1494536728, 1494536728, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'Кудринецький', 'Антон', 'Сергійович', 0, '1999-04-04', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'Чепіль', 'Сергій', 'Віталійович', 0, '1970-01-01', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'Карпович', 'Вячеслав', 'Васильович', 0, '2000-06-24', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'Прус', 'Богдан', 'Вікторович', 0, '2000-09-27', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'Багрій', 'Дар\'я', 'Олександрівна', 1, '1999-10-14', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 'Кирилюк ', 'Ольга', ' Олександрівна', 1, '2000-04-15', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 'Чернобай', 'Ярослав', 'Олександрович', 0, '2000-07-26', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 'Танасієнко', 'Вадим', 'Павлович', 0, '2000-05-17', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'Стрілець', 'Дмитро', 'Анатолійович', 0, '2001-03-19', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'Ісайкін ', 'Іван ', 'Андрійович', 0, '1970-01-01', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'Савіцький ', 'Владислав', 'Русланович', 0, '1999-09-08', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'Сулійманова', 'Світлана ', 'Володимирівна', 1, '1970-01-01', NULL, 1494536729, 1494536729, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Семераз ', 'Віталій ', 'Сергійович', 0, '2000-05-02', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'Козубай', 'Марина', 'Андріївна', 1, '1999-12-03', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'Чалий', 'В\'ячеслав', 'Володимирович', 0, '2000-06-02', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'Савкін ', 'Роман', 'Русланович', 0, '2000-06-20', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'Ткачук', 'Ярослав ', 'Олександрович ', 1, '2000-03-18', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'Логвиненко ', 'Анна ', 'Тарасівна', 1, '1999-09-22', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'Омельчук', 'Тарас', 'Володимирович', 0, '1999-09-19', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'Лисюк', 'Олег', 'Валентинович', 0, '1999-08-20', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'Гуменюк', 'Юрій ', 'Васильович', 0, '2000-05-06', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'Дуда ', 'Костянтин ', 'Михайлович', 0, '1999-11-14', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'Нагачевська', 'Марина', 'Вікторівна', 1, '2000-08-01', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 'Слободянюк ', 'Андрій', 'Сергійович', 0, '2000-08-17', NULL, 1494536730, 1494536730, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'Ліпінін', 'Вадим ', 'Сергійович', 0, '2000-07-16', NULL, 1494536731, 1494536731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'Собко ', 'Владислав', 'Вадимович', 0, '2000-05-11', NULL, 1494536731, 1494536731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, 'Голубович', 'Володимир ', 'Євгенович', 0, '2000-07-28', NULL, 1494536731, 1494536731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'Холод ', 'Владислав', 'Олексійович', 0, '2000-05-29', NULL, 1494536731, 1494536731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'Бондар', 'Василь', 'Васильович', 0, '2000-03-02', NULL, 1494536731, 1494536731, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'Коваль', 'Артем', 'Олександрович', 0, '2000-08-21', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'Савонов ', 'Павло ', 'Володимирович', 0, '2000-07-27', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'Вейко', 'Юлія', 'Олександрівна', 1, '2000-12-11', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'Миколюк', 'Андрій ', 'Анатолійович', 0, '1999-10-06', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'Починок', 'Артур ', 'Андрійович', 0, '2000-01-04', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'Залозна ', 'Олена ', 'Миколаївна', 1, '2000-04-02', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'Кот', 'Олександр', 'Олександрович', 0, '2000-09-09', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'Перець', 'Валентин', 'Вікторович', 0, '1970-01-01', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'Гончар', 'Діана', 'Олександрівна', 1, '1970-01-01', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'Мачковський', 'Павло', 'Володимирович', 0, '1970-01-01', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'Шпаченко', 'Тарас', 'Олександрович', 0, '1970-01-01', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'Котецький ', 'Олександр', 'Сергійович', 0, '2001-12-27', NULL, 1494536732, 1494536732, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'Андросюк', 'Іван', 'Олександрович', 0, '2000-11-30', NULL, 1494536732, 1494590815, '', NULL, '', '', '', NULL, '', '', NULL, NULL, NULL, NULL),
(124, 'Шпорт', 'Іван', 'Миколайович', 0, '2001-10-10', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'Гаркавюк', 'Даніїл', 'Степанович', 0, '2000-11-17', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'Міщинський', 'Ростислав', 'Сергійович', 0, '2000-08-07', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'Пилипчук', 'Микола', 'Миколайович', 0, '2001-06-29', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'Лазарчук', 'Юлія ', 'Юріївна', 1, '2001-07-19', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'Желавська', 'Злата', 'Олегівна', 1, '2001-11-10', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 'Качур', 'Володимир ', 'Андрійович', 0, '2001-09-26', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'Загуровська ', 'Яна', 'Сергіївна', 1, '2001-07-24', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'Жиліч', 'Анна', 'Андріївна', 1, '2001-02-28', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'Ліфінцев', 'Петро', 'Петрович', 0, '1999-12-20', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'Лищук', 'Олександр', 'Анатолійович', 0, '2001-03-07', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 'Сікорський', 'Павло', 'Олександрович', 0, '2001-04-28', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 'Фіть', 'Василь', 'Олександрович', 0, '2001-01-14', NULL, 1494536733, 1494536733, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'Шевчук', 'Микола', 'Ігорович', 0, '2000-12-18', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'Пілецька', 'Дар\'я', 'Олександрівна', 1, '2001-03-26', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 'Дзись', 'Владислав', 'Сергійович', 0, '2000-09-24', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Гурніцький', 'Богдан', 'Олегович', 0, '2001-10-12', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'Гибелинда', 'Вікторія', 'Олександрівна', 1, '1970-01-01', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 'Варук', 'Валентин', 'Констянтинович', 0, '2001-09-08', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'Бень', 'Іван', 'Володимирович', 0, '2000-10-15', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'Бабайцев', 'Богдан', 'Олександрович', 0, '2001-06-06', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'Поліщук', 'Максим', 'Ігорович', 0, '2001-11-16', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'Юрченко', 'Дмитро', 'Юрійович', 0, '2000-11-26', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'Пасічник', 'Тимофій', 'Віталійович', 0, '2001-06-13', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'Бихал', 'Іван', 'Юрійович', 0, '2001-10-12', NULL, 1494536734, 1494536734, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'Бендій', 'Данило', 'Михайлович', 0, '2001-08-04', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'Рекрутняк', 'Анастасія', 'Павлівна', 1, '2001-09-04', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'Пеліховський', 'Петро', 'В\'ячеславович', 0, '2001-09-03', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'Боролюк', 'Владислав', 'Русланович', 0, '2001-08-19', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 'Монастирський', 'Тарас', 'Андрійович', 0, '2001-05-22', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'Момот', 'Максим', 'Степанович', 0, '2001-05-10', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'Крачковський', 'Назар', 'Андрійович', 0, '2001-07-04', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'Колесник', 'Павло', 'Андрійович', 0, '2001-07-17', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'Кашперський', 'Юрій', 'Васильович', 0, '2001-07-10', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 'Андрущенко', 'Дмитро', 'Петрович', 0, '2001-02-03', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 'Зозуляк', 'Дарія', 'Василівна', 1, '2000-11-14', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'Борсук', 'Ірина', 'Миколаївна', 1, '2001-11-29', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'Войченко', 'Роман', 'Олександрович', 0, '2000-11-16', NULL, 1494536735, 1494536735, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(162, 'Гунчак', 'Діана', 'Валентинівна', 1, '2001-09-18', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(163, 'Єфімчук', 'Назарій', 'Іванович', 0, '2000-09-27', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(164, 'Савич', 'Нікола', 'Властімірович', 0, '2000-11-16', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'Самойлюк', 'Максим', 'Ігорович', 0, '2001-04-29', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'Бадьора', 'Ярослав', 'Михайлович', 0, '2001-06-11', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(167, 'Балагур', 'Андрій', 'Ігорович', 0, '2001-08-04', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(168, 'Стіпанов', 'Павло', 'Васильович', 0, '2001-07-12', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(169, 'Токарчук', 'Єгор', 'Олегович', 0, '2001-06-30', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(170, 'Шаповалюк', 'Дмитро', 'Олегович', 0, '2000-10-04', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(171, 'Ямборко', 'Дмитро', 'Анатолійович', 0, '2000-12-31', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(172, 'Харитонюк ', 'Ярослав', 'Ярославович', 0, '1970-01-01', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(173, 'Кустовський', 'Роман ', 'Сергійович', 0, '1999-04-21', NULL, 1494536736, 1494536736, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(174, 'Остапчук ', 'Ігор', 'Русланович', 0, '1989-03-12', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(175, 'Кузьминих', 'Василь', 'В\'ячеславович', 0, '1998-08-11', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(176, 'Легельбах ', 'Павло', 'Вікторович', 0, '1996-07-14', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'Лівенська', 'Валерія', 'Олександрівна', 1, '1999-04-27', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'Манзюк ', 'Ярослав ', 'Віталійович', 0, '1999-07-31', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(179, 'Матвійчук', 'Євгеній', 'Вікторович', 0, '1999-07-07', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(180, 'Мельник', 'Богдан', 'Юрійович', 0, '1998-04-27', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'Некрасова', 'Юліанна', 'Андріївна', 1, '1998-11-14', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(182, 'Ніколенко ', 'Ірина', 'Віталіївна', 1, '1999-04-30', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'Сітніков ', 'Олександр ', 'Олексійович', 0, '2015-08-31', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'Савчишин ', 'Іван ', 'Васильович', 0, '1999-06-19', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'Сарнацький', 'Олекса', 'Вадимович', 0, '1999-08-07', NULL, 1494536737, 1494536737, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(186, 'Слівінська ', 'Ольга', 'Ярославівна', 1, '1999-05-14', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(187, 'Федоришин ', 'Олександр', 'Михайлович', 0, '1999-04-27', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(188, 'Юзвишин ', 'Ярослав', 'Валентинович', 0, '1999-01-21', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'Слипченко', 'Руслан', 'Сергійович', 0, '1998-09-21', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(190, 'Даньковський', 'Костянтин', 'Юрійович', 0, '2015-08-31', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'Білий', 'Ігор ', 'Володимирович', 0, '2015-08-31', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(192, 'Кондратюк', 'Андрій', 'Олегович', 0, '2015-08-31', NULL, 1494536738, 1494536738, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `students_characteristics`
--

CREATE TABLE `students_characteristics` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `from` varchar(128) DEFAULT NULL,
  `text` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `students_emails`
--

CREATE TABLE `students_emails` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `comment` varchar(128) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `students_history`
--

CREATE TABLE `students_history` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `study_year_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `speciality_qualification_id` int(11) DEFAULT NULL,
  `action_type` smallint(4) DEFAULT NULL,
  `payment_type` smallint(4) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `course` smallint(4) DEFAULT NULL,
  `command` varchar(128) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `students_history`
--

INSERT INTO `students_history` (`id`, `student_id`, `parent_id`, `study_year_id`, `date`, `speciality_qualification_id`, `action_type`, `payment_type`, `group_id`, `course`, `command`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(2, 3, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(3, 4, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(4, 5, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(5, 6, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(6, 7, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(7, 8, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(8, 9, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(9, 10, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(10, 11, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(11, 12, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(12, 13, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(13, 14, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(14, 15, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(15, 16, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(16, 17, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(17, 18, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(18, 19, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(19, 20, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(20, 21, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(21, 22, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(22, 23, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(23, 24, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(24, 25, NULL, NULL, '2015-08-07', 2, 2, 2, 2, 1, 'Imported', NULL, NULL),
(25, 26, NULL, NULL, '2013-09-01', 2, 2, 1, 2, 1, 'Imported', NULL, NULL),
(26, 27, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(27, 28, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(28, 29, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(29, 30, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(30, 31, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(31, 32, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(32, 33, NULL, NULL, '2013-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(33, 34, NULL, NULL, '2013-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(34, 35, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(35, 36, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(36, 37, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(37, 38, NULL, NULL, '2013-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(38, 39, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(39, 40, NULL, NULL, '2014-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(40, 41, NULL, NULL, '2014-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(41, 42, NULL, NULL, '2014-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(42, 43, NULL, NULL, '2014-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(43, 44, NULL, NULL, '2013-09-01', 2, 2, 2, 1, 1, 'Imported', NULL, NULL),
(44, 45, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(45, 46, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(46, 47, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(47, 48, NULL, NULL, '2013-09-01', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(48, 49, NULL, NULL, '2015-08-31', 2, 2, 1, 1, 1, 'Imported', NULL, NULL),
(49, 50, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(50, 51, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(51, 52, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(52, 53, NULL, NULL, '2015-08-31', 2, 2, 2, 3, 1, 'Imported', NULL, NULL),
(53, 54, NULL, NULL, '2014-08-18', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(54, 55, NULL, NULL, '2014-08-18', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(55, 56, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(56, 57, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(57, 58, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(58, 59, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(59, 60, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(60, 61, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(61, 62, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(62, 63, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(63, 64, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(64, 65, NULL, NULL, '2015-08-31', 2, 2, 2, 3, 1, 'Imported', NULL, NULL),
(65, 66, NULL, NULL, '2014-08-08', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(66, 67, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(67, 68, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(68, 69, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(69, 70, NULL, NULL, '2015-08-31', 2, 2, 2, 3, 1, 'Imported', NULL, NULL),
(70, 71, NULL, NULL, '2014-08-05', 2, 2, 1, 3, 1, 'Imported', NULL, NULL),
(71, 72, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(72, 73, NULL, NULL, '2015-09-01', 2, 2, 2, 5, 1, 'Imported', NULL, NULL),
(73, 74, NULL, NULL, '2015-09-01', 2, 2, 2, 5, 1, 'Imported', NULL, NULL),
(74, 75, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(75, 76, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(76, 77, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(77, 78, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(78, 79, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(79, 80, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(80, 81, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(81, 82, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(82, 83, NULL, NULL, '2016-09-01', 2, 2, 2, 5, 1, 'Imported', NULL, NULL),
(83, 84, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(84, 85, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(85, 86, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(86, 87, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(87, 88, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(88, 89, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(89, 90, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(90, 91, NULL, NULL, '2016-09-01', 2, 2, 2, 5, 1, 'Imported', NULL, NULL),
(91, 92, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(92, 93, NULL, NULL, '2016-09-01', 2, 2, 2, 5, 1, 'Imported', NULL, NULL),
(93, 94, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(94, 95, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(95, 96, NULL, NULL, '2015-09-01', 2, 2, 1, 5, 1, 'Imported', NULL, NULL),
(96, 97, NULL, NULL, '2015-09-01', 2, 2, 2, 6, 1, 'Imported', NULL, NULL),
(97, 98, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(98, 99, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(99, 100, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(100, 101, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(101, 102, NULL, NULL, '2015-09-01', 2, 2, 2, 6, 1, 'Imported', NULL, NULL),
(102, 103, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(103, 104, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(104, 105, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(105, 106, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(106, 107, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(107, 108, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(108, 109, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(109, 110, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(110, 111, NULL, NULL, '2015-09-01', 2, 2, 2, 6, 1, 'Imported', NULL, NULL),
(111, 112, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(112, 113, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(113, 114, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(114, 115, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(115, 116, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(116, 117, NULL, NULL, '2015-09-01', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(117, 118, NULL, NULL, '2016-09-01', 2, 2, 2, 6, 1, 'Imported', NULL, NULL),
(118, 119, NULL, NULL, '2016-07-11', 2, 2, 1, 6, 1, 'Imported', NULL, NULL),
(119, 122, NULL, NULL, '2016-09-01', 1, 2, 2, 7, 1, 'Imported', NULL, NULL),
(120, 123, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(121, 124, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(122, 125, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(123, 126, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(124, 127, NULL, NULL, '2016-09-01', 1, 2, 2, 7, 1, 'Imported', NULL, NULL),
(125, 128, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(126, 129, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(127, 130, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(128, 131, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(129, 132, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(130, 133, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(131, 134, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(132, 135, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(133, 136, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(134, 137, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(135, 138, NULL, NULL, '2016-09-01', 1, 2, 2, 7, 1, 'Imported', NULL, NULL),
(136, 139, NULL, NULL, '2016-09-01', 1, 2, 2, 7, 1, 'Imported', NULL, NULL),
(137, 140, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(138, 141, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(139, 142, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(140, 143, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(141, 144, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(142, 145, NULL, NULL, '2016-09-01', 1, 2, 1, 7, 1, 'Imported', NULL, NULL),
(143, 146, NULL, NULL, '2016-09-01', 1, 2, 2, 7, 1, 'Imported', NULL, NULL),
(144, 147, NULL, NULL, '2016-09-01', 1, 2, 2, 8, 1, 'Imported', NULL, NULL),
(145, 148, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(146, 149, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(147, 150, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(148, 151, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(149, 152, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(150, 153, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(151, 154, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(152, 155, NULL, NULL, '2016-09-01', 1, 2, 2, 8, 1, 'Imported', NULL, NULL),
(153, 156, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(154, 157, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(155, 158, NULL, NULL, '2016-09-01', 1, 2, 2, 8, 1, 'Imported', NULL, NULL),
(156, 159, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(157, 160, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(158, 161, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(159, 162, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(160, 163, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(161, 164, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(162, 165, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(163, 166, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(164, 167, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(165, 168, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(166, 169, NULL, NULL, '2016-09-01', 1, 2, 2, 8, 1, 'Imported', NULL, NULL),
(167, 170, NULL, NULL, '2016-09-01', 1, 2, 2, 8, 1, 'Imported', NULL, NULL),
(168, 171, NULL, NULL, '2016-09-01', 1, 2, 1, 8, 1, 'Imported', NULL, NULL),
(169, 172, NULL, NULL, '2016-07-11', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(170, 173, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(171, 174, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(172, 175, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(173, 176, NULL, NULL, '2014-08-08', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(174, 177, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(175, 178, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(176, 179, NULL, NULL, '2014-08-08', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(177, 180, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(178, 181, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(179, 182, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(180, 183, NULL, NULL, '2015-08-31', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(181, 184, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(182, 185, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(183, 186, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(184, 187, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(185, 188, NULL, NULL, '2014-08-05', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(186, 189, NULL, NULL, '2014-12-08', 2, 2, 1, 4, 1, 'Imported', NULL, NULL),
(187, 190, NULL, NULL, '2015-08-31', 2, 2, 2, 4, 1, 'Imported', NULL, NULL),
(188, 191, NULL, NULL, '2015-08-31', 2, 2, 2, 4, 1, 'Imported', NULL, NULL),
(189, 192, NULL, NULL, '2015-08-31', 2, 2, 2, 4, 1, 'Imported', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `students_phones`
--

CREATE TABLE `students_phones` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `comment` varchar(128) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `students_social_networks`
--

CREATE TABLE `students_social_networks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `network_id` int(11) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `student_group`
--

CREATE TABLE `student_group` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `comment` varchar(128) DEFAULT NULL,
  `funding_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `study_plan`
--

CREATE TABLE `study_plan` (
  `id` int(11) NOT NULL,
  `speciality_qualification_id` int(10) DEFAULT NULL,
  `semesters` varchar(255) DEFAULT NULL,
  `graph` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `study_plan`
--

INSERT INTO `study_plan` (`id`, `speciality_qualification_id`, `semesters`, `graph`, `created`, `updated`) VALUES
(4, 1, '[17,23,16,16,16,17,16,8]', '[[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"H\",\"H\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"S\",\"P\",\"P\",\"P\",\"P\",\"P\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"S\",\"P\",\"P\",\"P\",\"P\",\"P\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"P\",\"P\",\"P\",\"P\",\"P\",\"P\",\"P\",\"P\",\"P\",\"DP\",\"DP\",\"DP\",\"DP\",\"DP\",\"DA\",\" \",\" \",\" \",\" \",\" \",\" \",\" \",\" \",\" \"]]', 1504852074, 1504852074);

-- --------------------------------------------------------

--
-- Структура таблиці `study_subject`
--

CREATE TABLE `study_subject` (
  `id` int(11) NOT NULL,
  `study_plan_id` int(10) DEFAULT NULL,
  `subject_id` int(10) DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `lectures` int(10) DEFAULT NULL,
  `lab_works` int(10) DEFAULT NULL,
  `practices` int(10) DEFAULT NULL,
  `weeks` varchar(255) DEFAULT NULL,
  `control` text,
  `practice_weeks` int(10) DEFAULT NULL,
  `diploma_name` varchar(255) DEFAULT NULL,
  `certificate_name` varchar(255) DEFAULT NULL,
  `dual_practice` tinyint(1) DEFAULT NULL,
  `dual_lab_work` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `study_subject`
--

INSERT INTO `study_subject` (`id`, `study_plan_id`, `subject_id`, `total`, `lectures`, `lab_works`, `practices`, `weeks`, `control`, `practice_weeks`, `diploma_name`, `certificate_name`, `dual_practice`, `dual_lab_work`) VALUES
(1, 1, 1, 140, 96, 0, 18, '[2,2,2,0,0,0,0,0]', '[[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,1,0,0,0],[0,0,0,0,0,0],\n                    [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]', NULL, '', '', 0, 0),
(2, 1, 2, 210, 2, 0, 170, '[4,3,2,0,0,0,0,0]', '[[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,1,0,0,0],[0,0,0,0,0,0],\n                    [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]', NULL, '', '', 0, 0),
(3, 3, 12, 140, 50, 0, 62, '[\"2\",\"2\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"1\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Українська мова', 'Українська мова', 0, 0),
(4, 3, 56, 160, 0, 0, 114, '[\"3\",\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Іноземна мова за професійним спрямуванням', 'Іноземна мова за професійним спрямуванням', 0, 0),
(5, 3, 1, 52, 46, 0, 0, '[\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, '', '', 0, 0),
(6, 4, 12, 140, 50, 0, 62, '[\"2\",\"2\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Українська мова', 'Українська мова', 0, 0),
(7, 4, 13, 210, 170, 0, 0, '[\"0\",\"6\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Українська література', 'Українська література', 0, 0),
(8, 4, 14, 160, 0, 0, 114, '[\"3\",\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Іноземна мова за професійним спрямуванням', 'Іноземна мова за професійним спрямуванням', 0, 0),
(9, 4, 15, 104, 16, 0, 64, '[\"5\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Світова література', 'Світова література', 0, 0),
(10, 4, 24, 80, 0, 0, 0, '[\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Історія України', 'Історія України', 0, 0),
(11, 4, 23, 104, 80, 0, 0, '[\"0\",\"4\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Всесвітня історія', 'Всесвітня історія', 0, 0),
(12, 4, 7, 34, 30, 0, 0, '[\"2\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Людина і світ', 'Людина і світ', 0, 0),
(13, 4, 52, 420, 134, 0, 170, '[\"6\",\"6\",\"4\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Математика', 'Математика', 0, 0),
(14, 4, 3, 140, 72, 20, 28, '[\"3\",\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Фізика', 'Фізика', 0, 0),
(15, 4, 4, 34, 26, 0, 0, '[\"0\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Астрономія', 'Астрономія', 0, 0),
(16, 4, 2, 122, 82, 10, 0, '[\"0\",\"4\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Біологія', 'Біологія', 0, 0),
(17, 4, 1, 52, 46, 0, 0, '[\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Географія', 'Географія', 0, 0),
(18, 4, 89, 70, 46, 20, 0, '[\"4\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Хімія', 'Хімія', 0, 0),
(19, 4, 92, 140, 52, 62, 0, '[\"4\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Інформатика (основи програмування)', 'Інформатика (основи програмування)', 0, 0),
(20, 4, 93, 160, 0, 0, 80, '[\"2\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Фізична культура', 'Фізична культура', 0, 0),
(21, 4, 94, 70, 21, 0, 42, '[\"0\",\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Захист Вітчизни', 'Захист Вітчизни', 0, 0),
(22, 4, 19, 54, 32, 0, 0, '[\"0\",\"0\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Іс', 'Історія України', 0, 0),
(23, 4, 21, 54, 26, 0, 6, '[\"0\",\"0\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Культурологія', 'Культурологія', 0, 0),
(24, 4, 20, 81, 2, 0, 32, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"2\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Українська мова за проф.спрям.', 'Українська мова за проф.спрям.', 0, 0),
(25, 4, 22, 81, 22, 0, 10, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"3\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Філософія', 'Філософія', 0, 0),
(26, 4, 54, 54, 22, 0, 10, '[\"0\",\"0\",\"0\",\"2\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Економічна теорія', 'Економічна теорія', 0, 0),
(27, 4, 55, 54, 22, 0, 10, '[\"0\",\"0\",\"0\",\"2\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Правознавство', 'Правознавство', 0, 0),
(28, 4, 70, 54, 22, 0, 10, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"4\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Соціологія', 'Соціологія', 0, 0),
(29, 4, 56, 216, 0, 0, 128, '[\"0\",\"0\",\"2\",\"2\",\"4\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Іноземна мова за професійним спрямуванням', 'Іноземна мова за професійним спрямуванням', 0, 0),
(30, 4, 65, 270, 4, 0, 220, '[\"0\",\"0\",\"2\",\"2\",\"4\",\"4\",\"2\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Фізичне виховання', 'Фізичне виховання', 0, 0),
(31, 4, 97, 54, 22, 0, 10, '[\"0\",\"0\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Екологія', 'Екологія', 0, 0),
(32, 4, 57, 135, 32, 10, 20, '[\"0\",\"0\",\"0\",\"4\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Фізика (ел.)', 'Фізика (ел.)', 0, 0),
(33, 4, 58, 108, 32, 0, 32, '[\"0\",\"0\",\"4\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Лінійна алгебра', 'Лінійна алгебра', 0, 0),
(34, 4, 59, 62, 0, 6, 28, '[\"0\",\"0\",\"0\",\"6\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Мат. аналіз', 'Мат. аналіз', 0, 0),
(35, 4, 64, 81, 24, 0, 24, '[\"0\",\"0\",\"0\",\"0\",\"3\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Диференційні рівняння', 'Диференційні рівняння', 0, 0),
(36, 4, 66, 108, 24, 0, 24, '[\"0\",\"0\",\"0\",\"0\",\"3\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Теорія ймовірності', 'Теорія ймовірності', 0, 0),
(37, 4, 96, 189, 58, 0, 54, '[\"0\",\"0\",\"4\",\"3\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"1\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Дискретна математика', 'Дискретна математика', 0, 0),
(38, 4, 67, 135, 24, 24, 0, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"3\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', 0, 'Чисельні методи', 'Чисельні методи', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблиці `study_years`
--

CREATE TABLE `study_years` (
  `id` int(11) NOT NULL,
  `year_start` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `study_years`
--

INSERT INTO `study_years` (`id`, `year_start`, `active`) VALUES
(1, 2013, 0),
(2, 2014, 0),
(4, 2015, 0),
(5, 2016, 1),
(6, 2017, 1);

-- --------------------------------------------------------

--
-- Структура таблиці `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `practice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `subject`
--

INSERT INTO `subject` (`id`, `title`, `code`, `short_name`, `practice`) VALUES
(1, 'Географія', 'ЗО.13', 'Географія', NULL),
(2, 'Біологія', 'ЗО.12', 'Біологія', NULL),
(3, 'Фізика', 'ЗО.10', 'Фізика', NULL),
(4, 'Астрономія', 'ЗО.11', 'Астрономія', NULL),
(5, 'Геометрія', 'ЗО.09', 'Геометрія', NULL),
(6, 'Алгебра', 'ЗО.09', 'Алгебра', NULL),
(7, 'Людина і світ', 'ЗО.07', 'Людина і світ', NULL),
(9, 'Дискретні структури', '4.11', 'Дискретні структури', 0),
(10, 'Економіка та організація виробництва', '4.10', 'Економіка та орг. вироб', 0),
(11, 'Автоматизовані інформаційні системи', '4,9', 'АІС', NULL),
(12, 'Українська мова', 'ЗО.01', 'Укр.мова', 0),
(13, 'Українська література ', 'ЗО.02', 'Укр.літ', 0),
(14, 'Іноземна мова', 'ЗО.03', 'Іноз. мова', 0),
(15, 'Світова література', 'ЗО.04', 'Світ.літ.', 0),
(16, 'Ліцензування та сертифікація програмних продуктів', '4.12', 'Ліц. та серт. ПЗ', NULL),
(17, 'Програмування Інтернет-застосувань', '4,13', 'Програмування Інтернет-застосувань', NULL),
(18, 'Основи програмування', '3.01', 'ОП', NULL),
(19, 'Історія  України', '1.01', 'Історія України', 0),
(20, 'Українська мова (за професійним спрямуванням)', '1.03', 'Укр.мова проф', 0),
(21, 'Культурологія', '1.02', 'Культурологія', 0),
(22, 'Основи філософських знань', '1.04', 'Філософія', 0),
(23, 'Всесвітня історія', 'ЗО.06', 'Всес.іст.', NULL),
(24, '*Історія України', 'ЗО.05', 'Іст.Укр', 0),
(25, 'Конструювання програмного забезпечення', '3,11', 'КПЗ', NULL),
(26, 'Проектний практикум', '3,12', 'Прок.практикум', NULL),
(27, 'Охорона праці', '3,13', 'Ох. праці', NULL),
(28, 'Охорона праці в галузі', '3,15', 'Ох праці в галуз', NULL),
(29, 'Практика з програмування', '3,15', 'Практика з прог', NULL),
(30, 'Практика з ОС та ООП', '3,16', 'Практика з ОС та ООП', NULL),
(31, 'Технологічна практика', '3,17', 'Технологічна практика', NULL),
(32, 'Переддипломна практика', '3,18', 'Переддипломна практика', NULL),
(33, 'Дипломне проктування', '3,19', 'Дипломне проктування', NULL),
(34, 'Основи психології та педагогіки', '4,1', 'Основи психології та педагогіки', NULL),
(35, 'Політологія', '4,2', 'Політологія', NULL),
(36, 'Підприємництво та менеджмент', '4,3', 'Підприємництво та менеджмент', NULL),
(37, 'Англійська мова (технічний переклад)', '4,4', 'Англійська мова (технічний переклад)', NULL),
(38, 'Комп\'ютерна графіка', '4,5', 'Комп\'ютерна графіка', NULL),
(39, 'Групова дінаміка і комунікації', '4,6', 'ГДК', NULL),
(40, 'Засоби системного програмування', '4,7', 'ЗСП', NULL),
(41, 'Дослідження операцій', '4,8', 'Досл. операцій', NULL),
(42, 'Вступ в спеціальність', '3.01', 'Вступ ', NULL),
(43, 'Об\'єктно-орієнтоване програмування', '3,02', 'ООП', NULL),
(44, 'Алгоритми і структури даних', '3,03', 'Алг і стр.дан', NULL),
(45, 'Операційні системи', '3,04', 'ОС', NULL),
(46, 'Інструментальні засоби візуального програмування', '3,05', 'ІЗВП', NULL),
(47, 'Бази даних', '3,06', 'БД', NULL),
(48, 'Людинно-машинна взаємодія', '3,08', 'ЛМВ', NULL),
(49, 'Архітектура комп\'ютерів', '3.08', 'Арх. комп', NULL),
(50, 'Організація комп\'ютерних мереж', '3,09', 'ОКМ', NULL),
(51, 'Основи програмної інженерії', '3,10', 'ОПІ', NULL),
(52, 'Математика', 'ЗО.09', 'Математика', NULL),
(54, 'Економічна теорія', '1.05', ' Економіка ', 0),
(55, 'Основи правознавства', '1.06', 'Правознавство', 0),
(56, 'Іноземна мова (за професійним спрямуванням)', '1.08', 'Іноз. мова (проф.)', 0),
(57, ' Фізика(електрика) ', '2.02', 'Фізика(елек.)', 0),
(58, 'Лінійна алгебра та аналітична геометрія', '2.03', 'Лін. алгебра', 0),
(59, 'Математичний аналіз', '2.04', 'Мат. аналіз', 0),
(61, 'Безпека життєдіяльності', '2.09', 'БЖД', 0),
(63, 'Технології', '3,10', 'технології', NULL),
(64, 'Диференціальні рівняння', '2.05', 'Диф. рівняння', 0),
(65, 'Фізичне виховання', '1.09', 'Фіз. вих.', 0),
(66, 'Теорія ймовірності і матем. статистика', '2.06', 'ТІ і Мат. стат.', 0),
(67, 'Чисельні методи', '2.08', 'Чис. методи', 0),
(68, 'Основи охорони праці', '3,13', 'Осн. ОП', NULL),
(69, 'Основи веб-програмування', '4,7', 'веб-програмування', NULL),
(70, 'Соціологія', '1.07', 'Соціологія', 0),
(71, 'Людино-машинна взаємодія', '3,07', 'ЛМВ', NULL),
(72, 'Економіка програмної інженерії', '4,10', 'економіка ПІ', NULL),
(73, 'Вища математика', '2.1', 'Вища математика', 0),
(74, 'Теорія електричних та магнітних кіл', '2.4', 'ТЕМК', 0),
(75, 'Комп\'ютерна логіка', '2.8', 'КЛ', 0),
(76, 'Програмування', '3,3', 'програмування', NULL),
(77, 'Основи електроніки', '3,4', 'основи електроніки', NULL),
(78, 'Інженерна та комп\'ютерна графіка', '2.3', 'ІТКГ', 0),
(79, 'Алгоритми та методи обчислень', '2.7', 'АТМО', 0),
(80, 'Комп\'ютерна електроніка', '3,01', 'КЕ', NULL),
(81, 'Електрорадіовимірювання', '3,4', 'електрорадіовимірювання', NULL),
(82, 'Системне програмування', '2.10', 'Сис. програмування', 0),
(83, 'Комп\'ютерна схемотехніка', '3,11', 'КС', NULL),
(84, 'Периферійні пристрої', '3,08', 'ПП', NULL),
(85, 'Комп\'ютерні системи та мережі', '3,09', 'КСТМ', NULL),
(86, 'Надійність, діагностика та експлуатація КС та КМ.', '3,12', 'НДТЕКС', NULL),
(87, 'Економіка і планування виробництва', '3,14', 'економіка', NULL),
(88, 'Захист інформації в комп\'ютерних системах', '3,4', 'ЗІВКС', NULL),
(89, 'Хімія', 'ЗО.14', 'Хімія', NULL),
(92, 'Інформатика (основи програмування)', 'ЗО.17', 'Інформатика', NULL),
(93, 'Фізична культура', 'ЗО.18', 'Фіз.культ', NULL),
(94, 'Захист Вітчизни', 'ЗО.19', 'Захист Вітчизни', NULL),
(96, 'Дискретна математика', '2.07', 'Дм', NULL),
(97, 'Основи екології', '2.01', 'Екологія', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `subject_cycle`
--

CREATE TABLE `subject_cycle` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `subject_cycle`
--

INSERT INTO `subject_cycle` (`id`, `title`) VALUES
(1, 'Загальноосвітня підготовка'),
(2, 'Цикл загальної підготовки');

-- --------------------------------------------------------

--
-- Структура таблиці `subject_relation`
--

CREATE TABLE `subject_relation` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `speciality_qualification_id` int(11) DEFAULT NULL,
  `subject_cycle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `subject_relation`
--

INSERT INTO `subject_relation` (`id`, `subject_id`, `speciality_qualification_id`, `subject_cycle_id`) VALUES
(1, 12, 1, 1),
(2, 13, 1, 1),
(3, 14, 1, 1),
(4, 15, 1, 1),
(5, 24, 1, 1),
(6, 23, 1, 1),
(7, 7, 1, 1),
(8, 52, 1, 1),
(9, 3, 1, 1),
(10, 4, 1, 1),
(11, 2, 1, 1),
(12, 89, 1, 1),
(13, 92, 1, 1),
(14, 93, 1, 1),
(15, 94, 1, 1),
(16, 1, 1, 1),
(17, 19, 1, 2),
(18, 21, 1, 2),
(19, 20, 1, 2),
(20, 22, 1, 2),
(21, 54, 1, 2),
(22, 55, 1, 2),
(23, 70, 1, 2),
(24, 56, 1, 2),
(25, 65, 1, 2),
(26, 97, 1, 2),
(27, 57, 1, 2),
(28, 58, 1, 2),
(29, 59, 1, 2),
(30, 64, 1, 2),
(31, 66, 1, 2),
(32, 96, 1, 2),
(33, 67, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблиці `village`
--

CREATE TABLE `village` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` text,
  `region_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `createdAt` int(11) NOT NULL,
  `updatedAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `work_plan`
--

CREATE TABLE `work_plan` (
  `id` int(11) NOT NULL,
  `speciality_qualification_id` int(10) DEFAULT NULL,
  `semesters` varchar(255) DEFAULT NULL,
  `graph` text,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `study_year_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `work_plan`
--

INSERT INTO `work_plan` (`id`, `speciality_qualification_id`, `semesters`, `graph`, `created`, `updated`, `study_year_id`) VALUES
(2, 1, '[17,23,16,16,16,16,16,8]', '[[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"H\",\"H\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"H\",\"H\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"S\",\"P\",\"P\",\"P\",\"P\",\"P\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"H\",\"H\",\"P\",\"P\",\"P\",\"P\",\"P\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"S\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"],[\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"H\",\"H\",\"P\",\"P\",\"P\",\"P\",\"P\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"T\",\"S\",\"P\",\"P\",\"P\",\"P\",\"DP\",\"DP\",\"DP\",\"DP\",\"DP\",\"DP\",\"DA\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\",\"H\"]]', 1504783600, 1516612635, 5);

-- --------------------------------------------------------

--
-- Структура таблиці `work_subject`
--

CREATE TABLE `work_subject` (
  `id` int(11) NOT NULL,
  `work_plan_id` int(10) DEFAULT NULL,
  `subject_id` int(10) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `lectures` varchar(255) DEFAULT NULL,
  `lab_works` varchar(255) DEFAULT NULL,
  `practices` varchar(255) DEFAULT NULL,
  `weeks` varchar(255) DEFAULT NULL,
  `control` text,
  `cyclic_commission_id` int(10) DEFAULT NULL,
  `certificate_name` varchar(255) DEFAULT NULL,
  `diploma_name` varchar(255) DEFAULT NULL,
  `control_hours` varchar(255) DEFAULT NULL,
  `project_hours` int(10) DEFAULT NULL,
  `dual_practice` tinyint(1) DEFAULT NULL,
  `dual_lab_work` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `work_subject`
--

INSERT INTO `work_subject` (`id`, `work_plan_id`, `subject_id`, `total`, `lectures`, `lab_works`, `practices`, `weeks`, `control`, `cyclic_commission_id`, `certificate_name`, `diploma_name`, `control_hours`, `project_hours`, `dual_practice`, `dual_lab_work`) VALUES
(1, 1, 1, '[43,55,42,0,0,0,0,0]', '[0,0,2,0,0,0,0,0,0]', '[0,0,0,0,0,0,0,0]', '[34,46,30,0,0,0,0]', '[2,2,2,0,0,0,0,0]', '[[0,0,0,0,0,0],[1,0,0,0,0,0],[0,0,1,0,0,0],[0,0,0,0,0,0],\n                    [0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0],[0,0,0,0,0,0]]', 10, '', '', '{\"total\":\"140\",\"lectures\":\"96\",\"lab_works\":\"0\",\"practices\":\"18\"}', NULL, 0, 0),
(2, 2, 12, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"2\",\"2\",\"2\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"1\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', NULL, '', '', '{\"total\":140,\"lectures\":50,\"lab_works\":0,\"practices\":62}', NULL, 0, 0),
(3, 2, 56, '[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\"]', '[\"3\",\"3\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]', '[[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"1\",\"0\",\"1\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],[\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"]]', NULL, '', '', '{\"total\":160,\"lectures\":0,\"lab_works\":0,\"practices\":114}', NULL, 0, 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `accounting_mounth`
--
ALTER TABLE `accounting_mounth`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `accounting_year`
--
ALTER TABLE `accounting_year`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `big_village`
--
ALTER TABLE `big_village`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `characteristics_type`
--
ALTER TABLE `characteristics_type`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `curator_group`
--
ALTER TABLE `curator_group`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `cyclic_commission`
--
ALTER TABLE `cyclic_commission`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `directories_audience`
--
ALTER TABLE `directories_audience`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `passport` (`passport`);

--
-- Індекси таблиці `employee_education`
--
ALTER TABLE `employee_education`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `evaluation_systems`
--
ALTER TABLE `evaluation_systems`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `exemptions`
--
ALTER TABLE `exemptions`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `exemptions_students_relations`
--
ALTER TABLE `exemptions_students_relations`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `family_relation`
--
ALTER TABLE `family_relation`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `family_relation_type`
--
ALTER TABLE `family_relation_type`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `journal_mark`
--
ALTER TABLE `journal_mark`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `journal_record`
--
ALTER TABLE `journal_record`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `journal_record_types`
--
ALTER TABLE `journal_record_types`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `journal_student`
--
ALTER TABLE `journal_student`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `load`
--
ALTER TABLE `load`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Індекси таблиці `not_presence_type`
--
ALTER TABLE `not_presence_type`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `qualification`
--
ALTER TABLE `qualification`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `social_networks`
--
ALTER TABLE `social_networks`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `speciality_qualification`
--
ALTER TABLE `speciality_qualification`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `students_characteristics`
--
ALTER TABLE `students_characteristics`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `students_emails`
--
ALTER TABLE `students_emails`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `students_history`
--
ALTER TABLE `students_history`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `students_phones`
--
ALTER TABLE `students_phones`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `students_social_networks`
--
ALTER TABLE `students_social_networks`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `student_group`
--
ALTER TABLE `student_group`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `study_plan`
--
ALTER TABLE `study_plan`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `study_subject`
--
ALTER TABLE `study_subject`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `study_years`
--
ALTER TABLE `study_years`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `subject_cycle`
--
ALTER TABLE `subject_cycle`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `subject_relation`
--
ALTER TABLE `subject_relation`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `work_plan`
--
ALTER TABLE `work_plan`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `work_subject`
--
ALTER TABLE `work_subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `accounting_mounth`
--
ALTER TABLE `accounting_mounth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `accounting_year`
--
ALTER TABLE `accounting_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблиці `big_village`
--
ALTER TABLE `big_village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `characteristics_type`
--
ALTER TABLE `characteristics_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `curator_group`
--
ALTER TABLE `curator_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `cyclic_commission`
--
ALTER TABLE `cyclic_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблиці `directories_audience`
--
ALTER TABLE `directories_audience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT для таблиці `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблиці `employee_education`
--
ALTER TABLE `employee_education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `evaluation_systems`
--
ALTER TABLE `evaluation_systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `exemptions`
--
ALTER TABLE `exemptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблиці `exemptions_students_relations`
--
ALTER TABLE `exemptions_students_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `family_relation`
--
ALTER TABLE `family_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `family_relation_type`
--
ALTER TABLE `family_relation_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблиці `journal_mark`
--
ALTER TABLE `journal_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `journal_record`
--
ALTER TABLE `journal_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `journal_record_types`
--
ALTER TABLE `journal_record_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `journal_student`
--
ALTER TABLE `journal_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `load`
--
ALTER TABLE `load`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `not_presence_type`
--
ALTER TABLE `not_presence_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблиці `qualification`
--
ALTER TABLE `qualification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `social_networks`
--
ALTER TABLE `social_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `speciality`
--
ALTER TABLE `speciality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблиці `speciality_qualification`
--
ALTER TABLE `speciality_qualification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;
--
-- AUTO_INCREMENT для таблиці `students_characteristics`
--
ALTER TABLE `students_characteristics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `students_emails`
--
ALTER TABLE `students_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `students_history`
--
ALTER TABLE `students_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;
--
-- AUTO_INCREMENT для таблиці `students_phones`
--
ALTER TABLE `students_phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `students_social_networks`
--
ALTER TABLE `students_social_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `student_group`
--
ALTER TABLE `student_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `study_plan`
--
ALTER TABLE `study_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблиці `study_subject`
--
ALTER TABLE `study_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT для таблиці `study_years`
--
ALTER TABLE `study_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблиці `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT для таблиці `subject_cycle`
--
ALTER TABLE `subject_cycle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `subject_relation`
--
ALTER TABLE `subject_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблиці `village`
--
ALTER TABLE `village`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблиці `work_plan`
--
ALTER TABLE `work_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `work_subject`
--
ALTER TABLE `work_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
