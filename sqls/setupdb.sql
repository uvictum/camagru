CREATE TABLE Users (
ID int NOT NULL AUTO_INCREMENT Primary key,
Login CHAR(25) NOT NULL,
Pass VARCHAR(128) NOT NULL,
Email CHAR(25) NOT NULL,
Hash VARCHAR(32) NOT NULL,
Activate BIT);

CREATE TABLE Images (
ID int NOT NULL AUTO_INCREMENT Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL);

CREATE TABLE Comments (
ID int NOT NULL AUTO_INCREMENT Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL);

CREATE TABLE Likes (
ID int NOT NULL AUTO_INCREMENT Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL)