--
-- Database: `mdenggre_projects`
--
 
-- Drop existing tables

DROP TABLE IF EXISTS  classes; 
DROP TABLE IF EXISTS  contacts;
DROP TABLE IF EXISTS  users;
DROP TABLE IF EXISTS  projects;



CREATE TABLE IF NOT EXISTS `projects` (
  `pid` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'project id',
  `pTitle` VARCHAR(50) NOT NULL COMMENT 'project title',
  `description` VARCHAR(3000) NULL DEFAULT NULL COMMENT 'project description',
  `note` varchar(5000) NOT NULL COMMENT 'instructor write the note for project',
  `status` VARCHAR(20) NULL DEFAULT NULL COMMENT 'project status',
  `cName` VARCHAR(50) NULL DEFAULT NULL COMMENT 'company name (client)',
  `cLocation` VARCHAR(200) NULL DEFAULT NULL COMMENT 'company location (client)',
  `cSite` VARCHAR(200) NULL DEFAULT NULL COMMENT 'company site (url)',
  `url` VARCHAR(200) NULL DEFAULT NULL COMMENT 'site url',
  `trello` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'trello info',
  `login` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'login credential',
  `github` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'GitHub info',
  
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `projects` (pTitle, description, cname) VALUES
('iGrad Registration', 'Provide a web application form of iGrad registration for students', 'iGrad'),
('Project A', 'This is a project sample', 'Company A'),
('Project B', 'This is an other project sample', 'Company B');




CREATE TABLE IF NOT EXISTS `classes` (
  `cid` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'class id',
  `pid` MEDIUMINT UNSIGNED NOT NULL,
  `className` varchar(30) DEFAULT NULL COMMENT 'class name like "IT305"',
  `quarter` varchar(30) NOT NULL COMMENT '"2017_4" means 2017 fall quarter',
  `instructor` varchar(30) NOT NULL,
  `url` VARCHAR(200) NULL DEFAULT NULL COMMENT 'site url',
  `trello` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'trello info',
  `login` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'login credential',
  `github` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'GitHub info',
  PRIMARY KEY (`cid`),

  CONSTRAINT PROJECT_class_id FOREIGN KEY (pid) REFERENCES projects(pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` MEDIUMINT UNSIGNED NOT NULL,
  `contactName` varchar(30) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`contact_id`),
  
  CONSTRAINT PROJECT_contact_id FOREIGN KEY (pid) REFERENCES projects(pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE IF NOT EXISTS `users` (
  `user_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `privilege` TINYINT UNSIGNED NOT NULL,
  `userName` varchar(30) NOT NULL,
  `password` char(64) NOT NULL,
  `email` varchar(50) DEFAULT NULL,

  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




