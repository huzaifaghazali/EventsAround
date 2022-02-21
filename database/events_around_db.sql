-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2021 at 01:56 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events_around_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fp_key` varchar(50) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `name`, `username`, `password`, `email`, `fp_key`, `status`) VALUES
(1, 'Admin', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'admin@admin.com', 'SI0255', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ads`
--

CREATE TABLE `tbl_ads` (
  `ad_id` int(11) NOT NULL,
  `ad_title` varchar(255) DEFAULT NULL,
  `ad_description` text DEFAULT NULL,
  `ad_status` enum('A','B') NOT NULL DEFAULT 'A',
  `ad_img_path` varchar(255) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_ads`
--

INSERT INTO `tbl_ads` (`ad_id`, `ad_title`, `ad_description`, `ad_status`, `ad_img_path`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'New AD', 'Ad Description', 'A', 'blogsImages/1627903578-download (3).jpg', 1, '2021-07-04 09:53:51', 1, '2021-08-02 01:26:18'),
(2, 'New AD 2', 'Add Description here', 'A', 'blogsImages/1627903566-download (2).jpg', 1, '2021-07-04 09:54:46', 1, '2021-08-02 01:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs`
--

CREATE TABLE `tbl_blogs` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) DEFAULT NULL,
  `blog_image` varchar(255) DEFAULT NULL,
  `blog_description` text DEFAULT NULL,
  `blog_views` int(11) DEFAULT NULL,
  `blog_status` enum('A','B') NOT NULL DEFAULT 'A',
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_blogs`
--

INSERT INTO `tbl_blogs` (`blog_id`, `blog_title`, `blog_image`, `blog_description`, `blog_views`, `blog_status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'Blog Title here (e-g Educational Blog)', 'blogsImages/1627903286-IMG_20200223_173155_304.jpg', ' Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here Blog Description here .', 0, 'A', 1, '2021-06-29 09:05:31', 1, '2021-08-02 01:21:26'),
(2, 'Blog Title here (e-g Fashion Blog)', 'blogsImages/1625042341-card-profile1-square.jpg', 'Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here Add Blog Description here .', NULL, 'A', 1, '2021-06-30 10:39:01', 1, '2021-08-02 01:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs_comments`
--

CREATE TABLE `tbl_blogs_comments` (
  `blog_comment_id` int(11) NOT NULL,
  `blogID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `blog_comment` text DEFAULT NULL,
  `createdDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_blogs_comments`
--

INSERT INTO `tbl_blogs_comments` (`blog_comment_id`, `blogID`, `userID`, `blog_comment`, `createdDate`) VALUES
(1, 1, 3, 'This is my testing data', '2021-06-29'),
(2, 1, 3, 'Amazing...!', '2021-06-29'),
(3, 1, 2, 'This is vary interesting data', '2021-06-29'),
(4, 1, 1, 'Nice post', '2021-06-29'),
(5, 1, 1, 'this is dummy', '2021-06-30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs_like`
--

CREATE TABLE `tbl_blogs_like` (
  `blog_like_id` int(11) NOT NULL,
  `blogID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `blog_like_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_blogs_like`
--

INSERT INTO `tbl_blogs_like` (`blog_like_id`, `blogID`, `userID`, `blog_like_date`) VALUES
(2, 3, 1, '2021-06-29'),
(4, 1, 1, '2021-06-30'),
(5, 2, 1, '2021-06-30'),
(6, 3, 2, '2021-06-29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `title` varchar(225) NOT NULL,
  `status` enum('B','A') NOT NULL DEFAULT 'B',
  `createdBy` int(11) NOT NULL,
  `createdDate` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `title`, `status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'Business', 'A', 1, '2021-06-22 09:20:02', NULL, NULL),
(2, 'Food & Drinks', 'A', 1, '2021-06-22 09:20:19', NULL, NULL),
(3, 'Health', 'A', 1, '2021-06-22 09:22:38', NULL, NULL),
(4, 'Music', 'A', 1, '2021-06-22 09:22:43', NULL, NULL),
(5, 'Virtual Event', 'A', 1, '2021-06-22 09:22:56', NULL, NULL),
(8, 'Charity and Causes', 'A', 1, '2021-08-02 01:14:53', NULL, NULL),
(9, 'Community', 'A', 1, '2021-08-02 01:15:00', NULL, NULL),
(10, 'Family & Education', 'A', 1, '2021-08-02 01:15:11', NULL, NULL),
(11, 'Fashion', 'A', 1, '2021-08-02 01:15:15', NULL, NULL),
(12, 'Film & Media', 'A', 1, '2021-08-02 01:15:20', 1, '2021-08-02 01:15:34'),
(13, 'Hobbies', 'A', 1, '2021-08-02 01:15:27', NULL, NULL),
(14, 'Home & Life Style', 'A', 1, '2021-08-02 01:15:45', NULL, NULL),
(15, 'Performing & Visual Arts', 'A', 1, '2021-08-02 01:16:03', NULL, NULL),
(16, 'Govenment', 'A', 1, '2021-08-02 01:16:08', NULL, NULL),
(17, 'Spirituality', 'A', 1, '2021-08-02 01:16:14', NULL, NULL),
(18, 'Science & Tech', 'A', 1, '2021-08-02 01:16:21', NULL, NULL),
(19, 'Holiday', 'A', 1, '2021-08-02 01:16:26', NULL, NULL),
(20, 'Sports & Fitness', 'A', 1, '2021-08-02 01:16:32', NULL, NULL),
(21, 'Travel & Outdoor', 'A', 1, '2021-08-02 01:16:38', 1, '2021-08-02 01:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `id` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `message` text NOT NULL,
  `senderReadNoti` enum('0','1') NOT NULL DEFAULT '0',
  `receverReadNoti` enum('0','1') NOT NULL DEFAULT '0',
  `createdTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_chat`
--

INSERT INTO `tbl_chat` (`id`, `senderID`, `receiverID`, `message`, `senderReadNoti`, `receverReadNoti`, `createdTime`) VALUES
(1, 2, 4, 'Asalam u Alikun', '1', '1', '2021-07-14 05:11:22'),
(2, 2, 4, 'can you please tell me your contact no', '1', '1', '2021-07-14 05:12:22'),
(3, 2, 1, 'Haji Group', '1', '1', '2021-07-14 05:14:02'),
(4, 2, 1, 'how are you', '1', '1', '2021-07-14 05:14:07'),
(5, 2, 1, 'need some info', '1', '1', '2021-07-14 05:14:13'),
(6, 1, 2, 'how can i help you', '1', '1', '2021-07-14 05:14:13'),
(7, 4, 2, 'Wa Alikum Asalm', '1', '1', '2021-07-14 05:11:22'),
(8, 1, 2, 'ok', '1', '1', '2021-07-14 06:37:42'),
(9, 2, 1, 'How are you', '1', '1', '2021-07-15 05:14:02'),
(10, 2, 5, 'Asalm O alikum! Can i get the information about your upcomming events?', '1', '1', '2021-08-02 03:54:15'),
(11, 6, 5, 'Message by Huzaifa', '1', '0', '2021-08-02 04:07:03'),
(12, 5, 2, 'Due to Covid the events are canceled. We will upload new events Soon! Thanks', '1', '1', '2021-08-02 04:10:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `contactus_id` int(11) NOT NULL,
  `contactus_name` varchar(255) DEFAULT NULL,
  `contactus_email` varchar(11) DEFAULT NULL,
  `contactus_msg` text DEFAULT NULL,
  `contactus_data` datetime DEFAULT NULL,
  `adminNoti` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_contact_us`
--

INSERT INTO `tbl_contact_us` (`contactus_id`, `contactus_name`, `contactus_email`, `contactus_msg`, `contactus_data`, `adminNoti`) VALUES
(1, 'Khawaja Ammad', 'rohan@gmail', 'This is dummy data', '2021-07-19 11:59:42', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_startDate` date DEFAULT NULL,
  `event_startTime` varchar(50) DEFAULT NULL,
  `event_duration` int(11) DEFAULT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `event_cateID` int(11) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_contact` varchar(50) DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `event_type` enum('P','F') NOT NULL DEFAULT 'P',
  `event_ticketPrice` float DEFAULT NULL,
  `event_totalTickets` int(11) DEFAULT NULL,
  `event_remainingTickets` int(11) DEFAULT NULL,
  `event_ticketSaleStartDate` date DEFAULT NULL,
  `event_ticketSaleEndDate` date DEFAULT NULL,
  `event_organizerID` int(11) DEFAULT NULL,
  `event_groupID` int(11) DEFAULT NULL,
  `event_status` enum('A','B') NOT NULL DEFAULT 'A',
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`event_id`, `event_name`, `event_startDate`, `event_startTime`, `event_duration`, `event_image`, `event_cateID`, `event_location`, `event_contact`, `event_description`, `event_type`, `event_ticketPrice`, `event_totalTickets`, `event_remainingTickets`, `event_ticketSaleStartDate`, `event_ticketSaleEndDate`, `event_organizerID`, `event_groupID`, `event_status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'New Event', '2021-07-10', '10:00', 12, 'uploads/1624697918-card-profile1-square.jpg', 1, 'Islamabad,Pakistan', '03320569001', 'This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event This is dummy data for event ', 'P', 1000, 100, 100, '2021-07-01', '2021-07-07', 1, 1, 'A', 1, '2021-06-26 10:58:38', NULL, NULL),
(2, 'Testing', '2021-07-08', '11:00', 48, 'uploads/1624712259-card-profile2-square.jpg', 4, 'Lahore', '03320569001', 'This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data This is dummy Data ', 'P', 299, 120, 120, '2021-01-07', '2021-07-10', 1, 1, 'A', 1, '2021-06-26 02:57:39', NULL, NULL),
(3, 'Haji Event', '2021-08-01', '11:00', 12, 'uploads/1624712641-marc.jpg', 4, 'Islamabad,Pakistan', '03320569001', 'This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is This is ', 'P', 1000, 100, 100, '2021-07-01', '2021-07-10', 1, 1, 'A', 1, '2021-06-26 03:04:01', 1, '2021-06-30 10:29:50'),
(4, 'New Test', '2021-07-10', '14:32', 48, 'uploads/1625042042-avatar.jpg', 1, 'Islamabad,Pakistan', '03320569001', 'eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID eventID ', 'P', 299, 120, 120, '2021-07-03', '2021-07-07', 1, 1, 'A', 1, '2021-06-30 10:34:02', NULL, NULL),
(5, 'New Virtual Event', '2021-07-30', '10:00', 10, 'uploads/1625600061-1624689897-card-profile2-square.jpg', 5, 'Islamabad', '03320569001', 'This is dummy data', 'P', 10, 100, 99, '2021-07-10', '2021-07-12', 1, 1, 'A', 1, '2021-07-06 09:34:21', NULL, NULL),
(6, 'New Virtual Event 2', '2021-08-08', '12:00', 10, 'uploads/1625600263-1624689873-card-profile2-square.jpg', 5, 'Islamabad', '03320569001', 'This is dummy data', 'F', 1000, 100, 100, '2021-07-13', '2021-07-29', 1, 1, 'A', 1, '2021-07-06 09:37:43', NULL, NULL),
(7, 'New Test', '2021-08-12', '13:00', 10, 'uploads/1626335201-1624439770-6.jpg', 3, 'Islamabad', '03320569001', 'This is dummy data', 'F', 0, 100, 100, '2021-07-18', '2021-08-01', 1, 1, 'A', 1, '2021-07-15 09:46:41', NULL, NULL),
(8, 'test', '2021-11-01', '11:00', 10, 'uploads/1626701087-bg1.jpeg', 5, 'Islamabad', '03320569001', 'fksfdkfdmk sdmksfdkfdk kas', 'P', 100, 10, 10, '2021-09-01', '2021-09-29', 1, 1, 'A', 1, '2021-07-19 03:24:47', NULL, NULL),
(9, 'Music Even', '2021-12-01', '17:00', 11, 'uploads/1626701374-login.jpg', 4, 'Islamabad', '03320569001', 'rohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.comrohanrazamir@gmail.com', 'P', 1000, 100, 99, '2021-09-01', '2021-10-29', 1, 1, 'A', 1, '2021-07-19 03:29:34', NULL, NULL),
(10, 'Event 1 of Eventarious', '2021-08-23', '14:51', 10, 'uploads/1627901244-download (1).jpg', 4, 'Islamabad,pk', '03320569001', 'Hi, The Description of the Event 1 of Eventarious will be displayed here.', 'P', 1000, 100, 100, '2021-08-21', '2021-08-22', 5, 4, 'A', 5, '2021-07-29 09:52:39', 5, '2021-08-02 12:47:24'),
(11, 'Music Event10', '2021-08-20', '13:03', 10, 'uploads/1627545756-logo.jpg', 4, 'rwp', '03320569001', ' rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk ', 'P', 1000, 100, 100, '2021-08-18', '2021-08-19', 4, 3, 'A', 4, '2021-07-29 10:02:36', NULL, NULL),
(12, 'Music Event11', '2021-08-10', '15:10', 10, 'uploads/1627546290-logo.jpg', 4, 'Rawalpindi Sports Complex', '03320569001', 'rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk rohan.bscs3600@iiu.edu.pk ', 'P', 1000, 100, 100, '2021-08-08', '2021-08-09', 4, 3, 'A', 4, '2021-07-29 10:11:30', NULL, NULL),
(13, 'm', '2021-08-31', '15:27', 1, 'uploads/1627899933-logo.jpg', 4, 'rwp', '03320569001', 're', 'P', 1000, 100, 100, '2021-08-24', '2021-08-26', 5, 4, 'B', 5, '2021-08-02 12:25:33', 5, '2021-08-02 12:45:05'),
(14, 'Event 2 of Eventarious ', '2021-08-20', '20:48', 48, 'uploads/1627901522-images.jpg', 5, 'Google meet', '03320569001', 'Hi, Here Organiser can add a link to virtual events if it is created already and add description of Event 2 of Eventarious.', 'F', 0, 100, 94, '2021-08-13', '2021-08-14', 5, 4, 'A', 5, '2021-08-02 12:52:02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_tickets`
--

CREATE TABLE `tbl_event_tickets` (
  `event_ticket_id` int(11) NOT NULL,
  `event_ticket_eventID` int(11) DEFAULT NULL,
  `event_ticket_userName` varchar(255) DEFAULT NULL,
  `event_ticket_email` varchar(255) DEFAULT NULL,
  `event_ticket_address` varchar(300) DEFAULT NULL,
  `event_ticket_city` varchar(100) DEFAULT NULL,
  `event_ticket_howToGet` enum('E','A') DEFAULT NULL,
  `event_ticket_totalTickets` int(11) DEFAULT NULL,
  `event_ticket_paymentMethod` enum('BT','EP','JC') DEFAULT NULL,
  `event_ticket_status` enum('A','P') NOT NULL DEFAULT 'P',
  `event_ticket_groupOnwerID` int(11) DEFAULT NULL,
  `event_ticket_groupOnwerNoti` enum('0','1') NOT NULL DEFAULT '0',
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_event_tickets`
--

INSERT INTO `tbl_event_tickets` (`event_ticket_id`, `event_ticket_eventID`, `event_ticket_userName`, `event_ticket_email`, `event_ticket_address`, `event_ticket_city`, `event_ticket_howToGet`, `event_ticket_totalTickets`, `event_ticket_paymentMethod`, `event_ticket_status`, `event_ticket_groupOnwerID`, `event_ticket_groupOnwerNoti`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 9, 'Khawaja Ammad', 'superadmin@wordecampus.com', 'Zia Masjid Road Rawalpidni', 'Rawalpindi', 'E', 1, 'BT', 'A', 1, '1', 0, '2021-07-24 09:53:35', NULL, NULL),
(2, 14, 'Rohan', 'rohan@gmail.com', 'House#318, Street#3A, Waliyat Colony Chaklala Scheme 3, Rawalpindi', 'Rawalpindi', 'A', 6, '', 'A', 5, '1', 0, '2021-08-02 12:59:34', NULL, NULL),
(3, 10, 'Huzaifa', 'huzaifaUser@gmail.com', 'House#3, Street#3A, Waliyat Colony Chaklala Scheme 3, Rawalpindi', 'Rawalpindi', 'A', 8, 'BT', 'P', 5, '0', 0, '2021-08-02 01:53:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `group_location` varchar(255) DEFAULT NULL,
  `group_image` varchar(255) DEFAULT NULL,
  `group_description` text DEFAULT NULL,
  `group_organizerID` int(11) DEFAULT NULL,
  `group_status` enum('A','B','D') NOT NULL DEFAULT 'A',
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_groups`
--

INSERT INTO `tbl_groups` (`group_id`, `group_name`, `group_location`, `group_image`, `group_description`, `group_organizerID`, `group_status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'Haji Group', 'Rawalpindi', 'uploads/1625041713-card-profile1-square.jpg', 'This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group This is dummy Haji Group ', 1, 'B', 1, '2021-06-22 09:03:21', 1, '2021-08-02 01:22:28'),
(2, 'Event Management ', 'Islamabad', 'uploads/1624439770-6.jpg', 'This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... This is my group in which ....... ', 3, 'B', 3, '2021-06-23 11:16:10', 1, '2021-08-02 01:22:21'),
(3, 'Educational', 'Islamabad', 'uploads/1624516389-card-profile1-square.jpg', 'This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this This is my dummy data please ignore this ', 4, 'A', 4, '2021-06-24 08:33:09', NULL, NULL),
(4, 'Eventarious', 'Islamabad,pk', 'uploads/1627900995-1.jpg', 'Hi, In this area the description of the group is displayed. Description of the groups is added dynamically.', 5, 'A', 5, '2021-07-29 09:50:34', 5, '2021-08-02 12:43:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_members`
--

CREATE TABLE `tbl_group_members` (
  `group_member_id` int(11) NOT NULL,
  `groupID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `group_member_status` enum('A','B') NOT NULL DEFAULT 'A',
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_group_members`
--

INSERT INTO `tbl_group_members` (`group_member_id`, `groupID`, `userID`, `group_member_status`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(7, 4, 2, 'B', 2, '2021-08-02 12:53:42', NULL, NULL),
(8, 4, 6, 'A', 6, '2021-08-02 01:06:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `review_id` int(11) NOT NULL,
  `review_groupID` int(11) DEFAULT NULL,
  `review_userID` int(11) DEFAULT NULL,
  `review_message` text DEFAULT NULL,
  `review_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`review_id`, `review_groupID`, `review_userID`, `review_message`, `review_date`) VALUES
(4, 3, 2, 'Excellent team.', '2021-07-28 01:27:18'),
(5, 4, 2, 'I attended Event 1 of Eventarious, it was quite amazing. Well Organised Event!', '2021-08-02 12:56:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscribe`
--

CREATE TABLE `tbl_subscribe` (
  `subscribe_id` int(11) NOT NULL,
  `subscribe_email` varchar(255) DEFAULT NULL,
  `subscribe_cateID` int(11) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subscribe`
--

INSERT INTO `tbl_subscribe` (`subscribe_id`, `subscribe_email`, `subscribe_cateID`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'ammadkhawaja2@gmail.com', 5, 0, '2021-07-06 09:18:16', NULL, NULL),
(2, 'rohanrazamir@gmail.com', 4, 0, '2021-07-19 03:27:31', NULL, NULL),
(3, 'huzaifaghazali@gmail.com', 4, 0, '2021-07-29 09:48:59', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_type` enum('O','U') NOT NULL DEFAULT 'U',
  `user_status` enum('A','B') NOT NULL DEFAULT 'A',
  `user_fpKey` varchar(30) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdDate` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_image`, `user_type`, `user_status`, `user_fpKey`, `createdBy`, `createdDate`, `updatedBy`, `updatedDate`) VALUES
(1, 'Ammad Khawaja', 'ammadkhawaja2@gmail.com', '1f32aa4c9a1d2ea010adcf2348166a04', NULL, 'O', 'B', '', 0, '2021-06-22 10:37:31', 1, '2021-08-02 01:22:10'),
(2, 'Rohan Raza', 'rohan@gmail.com', '14e1b600b1fd579f47433b88e8d85291', 'uploads/1624712259-card-profile2-square.jpg', 'U', 'A', NULL, 0, '2021-06-22 10:45:04', 1, '2021-06-23 08:13:44'),
(3, 'Khuram Shahzad', 'khuram@gamail.com', '14e1b600b1fd579f47433b88e8d85291', 'uploads/1624367607-marc.jpg', 'O', 'B', NULL, 0, '2021-06-22 03:13:27', 1, '2021-08-02 01:22:05'),
(4, 'Huzaifa', 'huzaifa@gmail.com', '14e1b600b1fd579f47433b88e8d85291', 'uploads/1624516305-marc.jpg', 'O', 'A', NULL, 0, '2021-06-24 08:31:45', NULL, NULL),
(5, 'Rohan Raza Mir', 'rohanrazamir@gmail.com', '1f32aa4c9a1d2ea010adcf2348166a04', 'uploads/1627470471-IMG_20191122_205116_356.jpg', 'O', 'A', 'WH40944', 0, '2021-07-28 01:07:51', NULL, NULL),
(6, 'Huzaifa', 'huzaifaUser@gmail.com', '14e1b600b1fd579f47433b88e8d85291', NULL, 'U', 'A', NULL, 0, '2021-08-02 01:05:05', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `tbl_blogs_comments`
--
ALTER TABLE `tbl_blogs_comments`
  ADD PRIMARY KEY (`blog_comment_id`);

--
-- Indexes for table `tbl_blogs_like`
--
ALTER TABLE `tbl_blogs_like`
  ADD PRIMARY KEY (`blog_like_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`contactus_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_event_tickets`
--
ALTER TABLE `tbl_event_tickets`
  ADD PRIMARY KEY (`event_ticket_id`);

--
-- Indexes for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `tbl_group_members`
--
ALTER TABLE `tbl_group_members`
  ADD PRIMARY KEY (`group_member_id`);

--
-- Indexes for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `tbl_subscribe`
--
ALTER TABLE `tbl_subscribe`
  ADD PRIMARY KEY (`subscribe_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_ads`
--
ALTER TABLE `tbl_ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_blogs_comments`
--
ALTER TABLE `tbl_blogs_comments`
  MODIFY `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_blogs_like`
--
ALTER TABLE `tbl_blogs_like`
  MODIFY `blog_like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `contactus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_event_tickets`
--
ALTER TABLE `tbl_event_tickets`
  MODIFY `event_ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_group_members`
--
ALTER TABLE `tbl_group_members`
  MODIFY `group_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_subscribe`
--
ALTER TABLE `tbl_subscribe`
  MODIFY `subscribe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
