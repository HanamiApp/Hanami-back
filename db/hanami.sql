CREATE DATABASE IF NOT EXISTS hanami;
USE hanami;

DROP TABLE IF EXISTS `group_service`;
DROP TABLE IF EXISTS `service`;
DROP TABLE IF EXISTS `user_group`;
DROP TABLE IF EXISTS `group`;
DROP TABLE IF EXISTS `user_task`;
DROP TABLE IF EXISTS `task`;
DROP TABLE IF EXISTS `user_goal`;
DROP TABLE IF EXISTS `goal`;
DROP TABLE IF EXISTS `update`;
DROP TABLE IF EXISTS `plant`;
DROP TABLE IF EXISTS `plant_state`;
DROP TABLE IF EXISTS `gift_state`;
DROP TABLE IF EXISTS `place`;
DROP TABLE IF EXISTS `species`;
DROP TABLE IF EXISTS `genus`;
DROP TABLE IF EXISTS `trip`;
DROP TABLE IF EXISTS `vehicle`;
DROP TABLE IF EXISTS `notice`;
DROP TABLE IF EXISTS `refresh_token`;
DROP TABLE IF EXISTS `user`;



CREATE TABLE `user`( 
   `id` int auto_increment primary key,
   `first_name` varchar(20) not null,
   `last_name` varchar(30) not null,
   `email` varchar(100) not null unique,
   `password` varchar(30) not null,
   `region` ENUM('ABRUZZO', 'BASILICATA', 'CALABRIA', 'CAMPANIA', 'EMILIA_ROMAGNA', 
               'FRIULI_VENEZIA_GIULIA', 'LAZIO', 'LIGURIA', 'LOMBARDIA', 'MARCHE', 'MOLISE',
               'PIEMONTE', 'PUGLIA', 'SARDEGNA', 'SICILIA', 'TOSCANA', 'TRENTINO_ALTO_ADIGE',
               'UMBRIA', "VALLE_D_AOSTA", 'VENETO') not null
);

CREATE TABLE `refresh_token`(
   `id_user` int primary key,
   `token` varchar(255) not null,
   foreign key (`id_user`) references `user`(`id`)
      ON UPDATE cascade
      ON DELETE cascade
);
/* inserimento `user` di default per i test */
INSERT INTO `user`(`first_name`, `last_name`, `email`, `password`, `region`) VALUES('admin', 'admin', 'admin@admin.com','admin', 'ABRUZZO');

CREATE TABLE `notice`(
   `id` int auto_increment primary key,
   `title` varchar(30) not null,
   `text` text not null,
   `id_user` int,
   foreign key (`id_user`) references `user`(`id`)
      ON UPDATE cascade
      ON DELETE cascade
);

CREATE TABLE `vehicle`(
   `id` int auto_increment primary key,
   `name` varchar(25) not null,
   `co2` float not null
);

CREATE TABLE `trip`(
   `id` int auto_increment primary key,
   `time` int not null, 
   `length` int not null, 
   `co2` float not null,
   `id_user` int,
   `id_vehicle` int,
   foreign key(`id_user`) references `user`(`id`)
      ON UPDATE cascade
      ON DELETE cascade,
   foreign key(`id_vehicle`) references `vehicle`(`id`)
      ON UPDATE cascade
      ON DELETE cascade
);

CREATE TABLE `genus`(
   `id` int auto_increment primary key,
   `name` varchar(50)
);

CREATE TABLE `species`(
   `id` int auto_increment primary key,
   `name` varchar(50),
   `co2` float not null,
   `description` text not null,
   `id_genus` int,
   foreign key (`id_genus`) references `genus`(`id`)
      ON UPDATE cascade
      ON DELETE cascade
);

CREATE TABLE `place`(
   `id` int auto_increment primary key,
   `name` varchar(30) not null,
   `city` varchar(30) not null,
   `region` ENUM('ABRUZZO', 'BASILICATA', 'CALABRIA', 'CAMPANIA', 'EMILIA_ROMAGNA', 
               'FRIULI_VENEZIA_GIULIA', 'LAZIO', 'LIGURIA', 'LOMBARDIA', 'MARCHE', 'MOLISE',
               'PIEMONTE', 'PUGLIA', 'SARDEGNA', 'SICILIA', 'TOSCANA', 'TRENTINO_ALTO_ADIGE',
               'UMBRIA', "VALLE_D_AOSTA", 'VENETO') not null,
   `coordinate_x` float not null,
   `coordinate_y` float not null
);

CREATE TABLE `gift_state`(
   `id` int auto_increment primary key,
   `state` ENUM('IN_PROCESS', 'SHIPPED', 'RECEIVED') not null
);

CREATE TABLE `plant_state`(
   `id` int auto_increment primary key,
   `state` ENUM('IN_PROCESS', 'TRAVELIN', 'PLANTED', 'DIED') not null,
   `condition` ENUM('HEALTHY', 'THIRSTY', 'DRY', 'UNCUT') not null,  -- in salute, assetata, secca, non tagliata
   `day` date
);

CREATE TABLE `plant`(
   `id` int auto_increment primary key,
   `name` varchar(50) not null,
   `gift` boolean default 0,
   `id_place` int,
   `id_plant_state` int,
   `id_gift_state` int,
   `id_user` int,
   `id_species` int,
   `qrcode` text,
   foreign key (`id_place`) references `place`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_plant_state`) references `plant_state`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_gift_state`) references `gift_state`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_user`) references `user`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_species`) references `species`(`id`)
      ON DELETE cascade
      ON UPDATE cascade
);

/* inserimento di una pianta di prova */
INSERT INTO `plant`(`name`) VALUES('baobab');

CREATE TABLE `update`(
   `id` int auto_increment primary key,
   `date` date not null,
   `hour` time,
   `operation` varchar(100) not null,
   `path_img` varchar(1000),
   `id_plant` int,
   `id_user` int,
   foreign key (`id_plant`) references `plant`(`id`)
      ON UPDATE cascade
      ON DELETE cascade,
   foreign key (`id_user`) references `user`(`id`)
      ON UPDATE cascade
      ON DELETE cascade
);

/* inserimento aggiornamento di prova */
INSERT INTO `update`(`date`, `operation`, `id_plant`, `id_user`) VALUES('2020-01-01', 'potatura', 1, 1);
INSERT INTO `update`(`date`, `operation`, `id_plant`, `id_user`) VALUES('2020-01-02', 'controllo', 1, 1);

CREATE TABLE `goal`(
   `id` int auto_increment primary key,
   `name` varchar(30) not null
);

CREATE TABLE `user_goal`(
   `id` int auto_increment primary key,
   `start_date` date not null,
   `id_goal` int,
   `id_user` int,
   foreign key (`id_goal`) references `goal`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_user`) references `user`(`id`)
      ON DELETE cascade
      ON UPDATE cascade
);

CREATE TABLE `task`(
   `id` int auto_increment primary key,
   `name` varchar(50) not null, 
   `deadline` date not null,
   `duration` int not null
);

CREATE TABLE `user_task`(
   `id` int auto_increment primary key,
   `start_date` date not null,
   `id_task` int not null,
   `id_user` int not null,
   foreign key (`id_task`) references `task`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_user`) references `user`(`id`)
      ON DELETE cascade
      ON UPDATE cascade
);

CREATE TABLE `group`(
   `id` int auto_increment primary key,
   `name` varchar(30) not null
);

/* gruppi utenza di default */
INSERT INTO `group`(`name`) VALUES('GUEST');
INSERT INTO `group`(`name`) VALUES('ADMIN');
INSERT INTO `group`(`name`) VALUES('GARDENER');

CREATE TABLE `user_group`(
   `id` int auto_increment primary key,
   `id_group` int,
   `id_user` int,
   foreign key (`id_group`) references `group`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_user`) references `user`(`id`)
      ON DELETE cascade
      ON UPDATE cascade
);

CREATE TABLE `service`(
   `id` int auto_increment primary key,
   `name` varchar(50) not null,
   `discount` int default 0
);

CREATE TABLE `group_service`(
   `id` int auto_increment primary key,
   `id_service` int,
   `id_group` int,
   foreign key (`id_service`) references `service`(`id`)
      ON DELETE cascade
      ON UPDATE cascade,
   foreign key (`id_group`) references `group`(`id`)
      ON DELETE cascade
      ON UPDATE cascade
);
