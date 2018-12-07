CREATE DATABASE fbdb;
USE fbdb;

CREATE TABLE `fbdb`.`beer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `beer_name` VARCHAR(45) NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  `container` VARCHAR(45) NULL,
  `manufacturer` VARCHAR(45) NULL,
  `alcohol_content` VARCHAR(45) NULL,
  `serving_size` VARCHAR(45) NULL,
  `cals_per_serving` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`regular_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `middle_initial` VARCHAR(45) NULL,
  `user_name` VARCHAR(255) NULL,
  `pass_word` VARCHAR(255) NULL,
  `email` VARCHAR(45) NULL,
  `gender` DATE NULL,
  `birth_date` VARCHAR(45) NULL,
  `favorite_beer` VARCHAR(45) NULL,
  `favorite_bar` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`establishment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `user_name` VARCHAR(45) NULL,
  `pass_word` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `zip` VARCHAR(45) NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `middle_initial` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`manufacturer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `user_name` VARCHAR(45) NULL,
  `pass_word` VARCHAR(45) NULL,
  `street` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `zip` VARCHAR(45) NULL,
  `website_url` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`beer_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`container_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`oz_to_ml` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `oz` VARCHAR(45) NULL,
  `ml` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `fbdb`.`zip` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `zip` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));
