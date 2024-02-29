-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2022 at 09:39 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12
SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
    AUTOCOMMIT = 0;START TRANSACTION;
SET
    time_zone = "+00:00";
    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
    /*!40101 SET NAMES utf8mb4 */;--
    -- Database: `notes`
    --
    -- --------------------------------------------------------
    --
    -- Table structure for table `uploads`
    --
    CREATE TABLE `uploads` (
        `file_id` int(11) NOT NULL,
        `file_name` varchar(225) NOT NULL,
        `file_description` text NOT NULL,
        `file_type` varchar(225) NOT NULL,
        `file_uploader` varchar(225) NOT NULL,
        `file_uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `file_uploaded_to` varchar(225) NOT NULL,
        `file` varchar(225) NOT NULL,
        `status` varchar(225) NOT NULL DEFAULT 'not approved yet'
    ) ENGINE = MyISAM DEFAULT CHARSET = latin1;
    --
    -- Dumping data for table `uploads`
    --
    CREATE TABLE `questions` (
        `question_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `question_chapter_name` varchar(225) NOT NULL,
        `question_description` text NOT NULL,
        `question_uploader` varchar(225) NOT NULL,
        `question_uploaded_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `question_uploaded_to` varchar(225) NOT NULL,
        `question` varchar(225) NOT NULL,
        `question_image` varchar(225) DEFAULT 'question.jpg'
    ) ENGINE = MyISAM DEFAULT CHARSET = latin1;

CREATE TABLE answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT(11) NOT NULL,
    answer TEXT NOT NULL DEFAULT 'no',
    answer_image VARCHAR(255),
    answer_uploader VARCHAR(225),
    answer_uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES questions(question_id)
)ENGINE = MyISAM DEFAULT CHARSET = latin1;

INSERT INTO
    `uploads` (
        `file_id`,
        `file_name`,
        `file_description`,
        `file_type`,
        `file_uploader`,
        `file_uploaded_on`,
        `file_uploaded_to`,
        `file`,
        `status`
    )
VALUES
    (
        57,
        'demo previer',
        'demo',
        'pdf',
        'user',
        '2022-04-28 05:08:23',
        'BCA',
        '578090.pdf',
        'approved'
    );-- --------------------------------------------------------
    --
    -- Table structure for table `users`
    --
    CREATE TABLE `users` (
        `id` int(11) NOT NULL,
        `username` varchar(225) NOT NULL,
        `name` varchar(225) NOT NULL,
        `about` varchar(300) NOT NULL DEFAULT 'N/A',
        `role` varchar(225) NOT NULL,
        `email` varchar(225) NOT NULL,
        `token` varchar(225) NOT NULL,
        `gender` varchar(225) NOT NULL,
        `password` varchar(225) NOT NULL,
        `course` varchar(225) NOT NULL,
        `image` varchar(225) NOT NULL DEFAULT 'profile.jpg',
        `joindate` varchar(225) NOT NULL
    ) ENGINE = MyISAM DEFAULT CHARSET = latin1;
    --
    -- Dumping data for table `users`
    --
INSERT INTO
    `users` (
        `id`,
        `username`,
        `name`,
        `about`,
        `role`,
        `email`,
        `token`,
        `gender`,
        `password`,
        `course`,
        `image`,
        `joindate`
    )
VALUES
    (
        12,
        'admin',
        'Admin',
        'Full Stack Developer',
        'admin',
        'admin@gmail.com',
        '',
        'Male',
        'adminadmin',
        'Class-12',
        'profile.jpg',
        'February 27, 2024'
    );
    
    --
    -- Indexes for dumped tables
    --
    --
    -- Indexes for table `uploads`
    --
ALTER TABLE
    `uploads`
ADD
    PRIMARY KEY (`file_id`);
    --
    -- Indexes for table `users`



    --
ALTER TABLE
    `users`
ADD
    PRIMARY KEY (`id`);
    --
    -- AUTO_INCREMENT for dumped tables
    --
    --
    -- AUTO_INCREMENT for table `uploads`
    --
ALTER TABLE
    `uploads`
MODIFY
    `file_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 59;
    --
    -- AUTO_INCREMENT for table `users`



    ALTER TABLE
    `questions`
MODIFY
    `question_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 59;
    --
ALTER TABLE
    `users`
MODIFY
    `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 30;COMMIT;
    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
    /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
    /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;