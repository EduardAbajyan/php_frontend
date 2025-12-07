CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

CREATE TABLE IF NOT EXISTS education_list (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	platfolm_type ENUM('bachelor', 'master', 'udemy', 'mosh') NOT NULL,
    faculty_name VARCHAR(255) NOT NULL,
    platform_name VARCHAR(255) NOT NULL,
    starting_year YEAR NOT NULL,
    ending_year YEAR NOT NULL,
    link VARCHAR(1000)
);

CREATE TABLE IF NOT EXISTS skills_list (
id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
category ENUM(
			'Technical Skills', 
			'Programming Languages and Frameworks',
            'Languages', 
            'Working Style', 
            'Additional Experiance') NOT NULL,
header VARCHAR(255) NOT NULL,
image VARCHAR(1000),
description_text TEXT 
);
