CREATE DATABASE mad3134_mining;
USE mad3134_mining;

CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(40) NOT NULL
);

CREATE TABLE blocks (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	hash VARCHAR(255) NOT NULL UNIQUE,
	data VARCHAR(255),
	username VARCHAR(255),
	FOREIGN KEY (username) REFERENCES users(name)
);


