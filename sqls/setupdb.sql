CREATE TABLE Users (
ID CHAR(10) NOT NULL Primary key,
Login CHAR(25) NOT NULL,
Pass CHAR(25) NOT NULL,
Email CHAR(25) NOT NULL,
Activate BIT);

CREATE TABLE Images (
ID CHAR(10) NOT NULL Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL);

CREATE TABLE Comments (
ID CHAR(10) NOT NULL Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL);

CREATE TABLE Likes (
ID CHAR(10) NOT NULL Primary key,
Custom_name CHAR(25) NOT NULL,
Custom_address CHAR(25) NULL,
Custom_city CHAR(25) NULL,
Custom_Country CHAR(25) NULL)