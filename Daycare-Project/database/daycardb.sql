DROP DATABASE IF EXISTS `DaycareDB`;

CREATE DATABASE IF NOT EXISTS `DaycareDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- Important in MySQL to select MySQL database and switch between databases
USE `DaycareDB`;
-- DISABLE the foreign keys in order to be able to delete child tables having foreign key
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Account;
DROP TABLE IF EXISTS Branch;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Appointment;
DROP TABLE IF EXISTS Parent;
DROP TABLE IF EXISTS OtherParent;
DROP TABLE IF EXISTS child;
DROP TABLE IF EXISTS Product;

CREATE TABLE IF NOT EXISTS Account
(account_id INT(10) NOT NULL AUTO_INCREMENT,
date_account_open DATE,
username VARCHAR(50),
password VARCHAR(8),
email VARCHAR(100),
user_type VARCHAR(255),
UNIQUE(username,email),
CONSTRAINT account_account_id_pk PRIMARY KEY (account_id)); 

CREATE TABLE IF NOT EXISTS Branch
(b_id INT(5),
b_name VARCHAR(30),
b_spot INT(3),
b_address VARCHAR(50),
b_phone VARCHAR(15),
CONSTRAINT branch_b_id_pk PRIMARY KEY (b_id)); 

CREATE TABLE IF NOT EXISTS Department
(d_id INT(5),
d_name VARCHAR(30),
d_spot INT(3),
d_price DOUBLE(8,2),
b_id INT(5),
CONSTRAINT department_db_id_CPK PRIMARY KEY (d_id,b_id),
CONSTRAINT department_b_id_FK FOREIGN KEY (b_id) REFERENCES Branch(b_id)); 

CREATE TABLE IF NOT EXISTS Appointment
(a_id INT(5) NOT NULL AUTO_INCREMENT,
a_name VARCHAR(30),
a_email VARCHAR(30),
a_subject VARCHAR(30),
a_visitdate DATE,
a_comment VARCHAR(350),
b_id INT(5),
CONSTRAINT appointment_a_id_PK PRIMARY KEY (a_id),
CONSTRAINT appointment_account_id_FK FOREIGN KEY (b_id) REFERENCES Branch(b_id)); 

CREATE TABLE IF NOT EXISTS Parent
(
p_fname VARCHAR(30),
p_lname VARCHAR(30),
p_phone VARCHAR(15),
p_streetadd VARCHAR(30),
p_city VARCHAR(15),
p_state VARCHAR(2),
p_postal VARCHAR(6),
p_nas INT(10),
p_comment VARCHAR(350),
account_id INT(10),
CONSTRAINT parent_account_id_PK PRIMARY KEY (account_id),
CONSTRAINT parent_account_id_FK FOREIGN KEY (account_id) REFERENCES Account(account_id));

CREATE TABLE IF NOT EXISTS OtherParent
(op_id INT(5) NOT NULL AUTO_INCREMENT,
op_name VARCHAR(50),
op_phone VARCHAR(15),
op_email VARCHAR(30),
account_id INT(10),
CONSTRAINT otherparent_op_id_PK PRIMARY KEY (op_id),
CONSTRAINT otherparent_account_id_FK FOREIGN KEY (account_id) REFERENCES Account(account_id));

CREATE TABLE child
(c_id INT(5) NOT NULL AUTO_INCREMENT,
c_name VARCHAR(30),
c_birthdate DATE,
c_insurance VARCHAR(30),
c_entrydate DATE,
account_id INT(10),
d_id INT(5),
b_id INT(5),
CONSTRAINT child_c_id_PK PRIMARY KEY (c_id),
CONSTRAINT child_account_id_FK FOREIGN KEY (account_id) REFERENCES Account(account_id),
CONSTRAINT child_b_id_FK FOREIGN KEY (b_id) REFERENCES Branch(b_id),
CONSTRAINT child_d_id_FK FOREIGN KEY (d_id) REFERENCES Department(d_id)); 

CREATE TABLE IF NOT EXISTS Product
(id INT(10) NOT NULL AUTO_INCREMENT,
image VARCHAR(255),
name VARCHAR(255),
price DOUBLE(8,3),
code VARCHAR(100),
UNIQUE(code),
CONSTRAINT product_id_pk PRIMARY KEY (id));

INSERT INTO Account (account_id, date_account_open, username, password, email, user_type) 
VALUES
(111, CURDATE(), 'Admin', 'Admin', 'admin@gmail.com', 'admin');

INSERT INTO Branch VALUES
(1,'God’s Little Treasures montreal',100,'123 Rue vincent montreal 4h7-1m2', '512-359 4444');
INSERT INTO Branch VALUES
(2,'God’s Little Treasures longueuil',90,'1340 Rue beahar longueuil 1z7-8j2', '438-121 5555');
INSERT INTO Branch VALUES
(3,'God’s Little Treasures St-Hubert',75,'1250 Rue mur St-Hubert 2b6-1h9', '438-312 9999');

INSERT INTO Department VALUES
(1,'A. FULL DAY - INFANTS, TODDLERS, AND PRESCHOOLERS',42,48.40,1);
INSERT INTO Department VALUES
(2,'B. KINDERGARTEN',15,34.60,1);
INSERT INTO Department VALUES
(3,'C. SCHOOL AGE WITHOUT LUNCH',15,22.65,1);
INSERT INTO Department VALUES
(4,'D. FULL DAY – SCHOOL AGE CHILDREN',28,49.35,1);
INSERT INTO Department VALUES
(1,'A. FULL DAY - INFANTS, TODDLERS, AND PRESCHOOLERS',42,48.40,2);
INSERT INTO Department VALUES
(2,'B. KINDERGARTEN',15,34.60,2);
INSERT INTO Department VALUES
(3,'C. SCHOOL AGE WITHOUT LUNCH',15,22.65,2);
INSERT INTO Department VALUES
(4,'D. FULL DAY – SCHOOL AGE CHILDREN',28,49.35,2);
INSERT INTO Department VALUES
(1,'A. FULL DAY - INFANTS, TODDLERS, AND PRESCHOOLERS',42,48.40,3);
INSERT INTO Department VALUES
(2,'B. KINDERGARTEN',15,34.60,3);
INSERT INTO Department VALUES
(3,'C. SCHOOL AGE WITHOUT LUNCH',15,22.65,3);
INSERT INTO Department VALUES
(4,'D. FULL DAY – SCHOOL AGE CHILDREN',28,49.35,3);


INSERT INTO Product VALUES
(1,'../img/product/1.png', 'Second Step Early Learning Poster and Card Pack',36.00,'Poster01');
INSERT INTO Product VALUES
(2,'../img/product/2.png', 'Early Learning Lanyards with Skill Reinforcement',29.00,'Lanyards01');
INSERT INTO Product VALUES
(3,'../img/product/3.png', 'Second Step Early Learning Boy and Girl Puppet Set',35.00,'Puppet01');
INSERT INTO Product VALUES
(4,'../img/product/4.png', 'Second Step Early Learning Feelings Cards',17.00,'Cards01');