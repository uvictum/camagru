CREATE TABLE Users (
ID int NOT NULL AUTO_INCREMENT Primary key,
Login CHAR(25) NOT NULL,
Pass VARCHAR(128) NOT NULL,
Email CHAR(25) NOT NULL,
Hash VARCHAR(32) NOT NULL,
Notify int DEFAULT 1,
Activate int DEFAULT 0);

CREATE TABLE Images (
ID int NOT NULL AUTO_INCREMENT Primary key,
UserID int NOT NULL,
Link VARCHAR (100) NOT NULL,
Comments int DEFAULT 0,
Postdate TIMESTAMP NULL,
Likes int DEFAULT 0);

CREATE TABLE Masks (
ID int NOT NULL AUTO_INCREMENT Primary key,
Link VARCHAR (100) NOT NULL,
TimesUsed int NULL);

CREATE TABLE Comments (
ID int NOT NULL AUTO_INCREMENT Primary key,
UserID int NOT NULL,
ImageID int NOT NULL,
Postdate TIMESTAMP NULL,
Text VARCHAR(350) NOT NULL,
CONSTRAINT FOREIGN KEY (ImageID) REFERENCES Images (ID) ON DELETE CASCADE);

CREATE TABLE Likes (
ID int NOT NULL AUTO_INCREMENT Primary key,
UserID int NOT NULL,
ImageID int NOT NULL,
CONSTRAINT FOREIGN KEY (ImageID) REFERENCES Images (ID) ON DELETE CASCADE);

INSERT INTO Images (UserID, Link) VALUES (1, 'images/test.JPG');
INSERT INTO Images (UserID, Link) VALUES (1, 'images/sample1.jpg');
INSERT INTO Images (UserID, Link) VALUES (1, 'images/sampl.jpg');
INSERT INTO Images (UserID, Link) VALUES (1, 'images/test3.jpg');

INSERT INTO Masks (Link) VALUES ('images/masks/bowler-hat.png');
INSERT INTO Masks (Link) VALUES ('images/masks/clubman-glasses.png');
INSERT INTO Masks (Link) VALUES ('images/masks/cowboy-hat.png');
INSERT INTO Masks (Link) VALUES ('images/masks/frames-circo-png.png');
INSERT INTO Masks (Link) VALUES ('images/masks/meme-sunglasses.png');
INSERT INTO Masks (Link) VALUES ('images/masks/christmas-frame-1916987_640.png');

CREATE TRIGGER Comment_Added
AFTER INSERT ON Comments
FOR EACH ROW
    UPDATE Images SET Images.Comments = Images.Comments + 1 WHERE Images.ID = NEW.ImageID;

CREATE TRIGGER Comment_Removed
BEFORE DELETE ON Comments
FOR EACH ROW
    UPDATE Images SET Images.Comments = Images.Comments - 1 WHERE Images.ID = OLD.ImageID;

CREATE TRIGGER Like_Added
AFTER INSERT ON Likes
FOR EACH ROW
    UPDATE Images SET Images.Likes = Images.Likes + 1 WHERE Images.ID = NEW.ImageID;

CREATE TRIGGER Like_Removed
BEFORE DELETE ON Likes
FOR EACH ROW
    UPDATE Images SET Images.Likes = Images.Likes - 1 WHERE Images.ID = OLD.ImageID;