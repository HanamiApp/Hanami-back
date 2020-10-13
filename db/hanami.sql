CREATE DATABASE IF NOT EXISTS Hanami;
USE Hanami;


DROP TABLE IF EXISTS gruppo_servizio;
DROP TABLE IF EXISTS servizio;
DROP TABLE IF EXISTS utente_gruppo;
DROP TABLE IF EXISTS gruppo;
DROP TABLE IF EXISTS utente_task;
DROP TABLE IF EXISTS task;
DROP TABLE IF EXISTS utente_obiettivo;
DROP TABLE IF EXISTS obiettivo;
DROP TABLE IF EXISTS aggiornamento;
DROP TABLE IF EXISTS utente_pianta;
DROP TABLE IF EXISTS stato_pianta;
DROP TABLE IF EXISTS stato_regalo;
DROP TABLE IF EXISTS luogo;
DROP TABLE IF EXISTS pianta;
DROP TABLE IF EXISTS spostamento;
DROP TABLE IF EXISTS mezzo;
DROP TABLE IF EXISTS notifica;
DROP TABLE IF EXISTS utente;



Create table utente( 
   id int auto_increment primary key,
   nome varchar(20) not null,
   cognome varchar(30) not null,
   email varchar(100) not null,
   `password` varchar(30) not null,
   regione ENUM('abruzzo', 'basilicata', 'calabria', 'campania', 'emilia romagna', 
               'friuli-venezia giulia', 'lazio', 'liguria', 'lombardia', 'marche', 'molise',
               'piemonte', 'puglia', 'sardegna', 'sicilia', 'toscana', 'trentino-alto adige',
               'umbria', 'valle d aosta', 'veneto') not null
);

Create table notifica(
   id int auto_increment primary key,
   titolo varchar(30) not null,
   testo text not null,
   id_utente int,
   foreign key (id_utente) references utente(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

create table mezzo(
   id int auto_increment primary key,
   nome varchar(25) not null,
   co2 float not null
);

create table spostamento(
   id int auto_increment primary key,
   tempo int not null, 
   lunghezza int not null, 
   co2 float not null,
   id_utente int,
   id_mezzo int,
   foreign key(id_utente) references utente(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE,
   foreign key(id_mezzo) references mezzo(id)
      ON UPDATE CASCADE
      ON DELETE CASCADE
);

create table pianta(
   id int auto_increment primary key,
   genere varchar(50),
   specie varchar(50),
   nome varchar(50) not null,
   co2 float not null
);

create table luogo(
   id int auto_increment primary key,
   nome varchar(30) not null,
   citta varchar(30) not null,
   regione ENUM('abruzzo', 'basilicata', 'calabria', 'campania', 'emilia romagna', 
               'friuli-venezia giulia', 'lazio', 'liguria', 'lombardia', 'marche', 'molise',
               'piemonte', 'puglia', 'sardegna', 'sicilia', 'toscana', 'trentino-alto adige',
               'umbria', 'valle d aosta', 'veneto') not null,
   coordinate float
);

create table stato_regalo(
   id int auto_increment primary key,
   stato ENUM('spedito', 'ricevuto', 'completato', 'in completamento') not null
);

create table stato_pianta(
   id int auto_increment primary key,
   stato ENUM('trasporto', 'piantata', 'deceduta') not null,
   stato_vitale ENUM('buono stato', 'assetata', 'rinsecchita', 'incolta') not null,
   giorno date
);

create table utente_pianta(
   id int auto_increment primary key,
   regalo boolean default 0,
   id_luogo int,
   id_stato_pianta int,
   id_stato_regalo int,
   foreign key (id_luogo) references luogo(id)
      on delete cascade
      on update cascade,
   foreign key (id_stato_pianta) references stato_pianta(id)
      on delete cascade
      on update cascade,
   foreign key (id_stato_regalo) references stato_regalo(id)
      on delete cascade
      on update cascade
);

create table aggiornamento(
   id int auto_increment primary key,
   `data` date not null,
   ora time,
   intervento varchar(100) not null,
   path_img varchar(1000),
   id_utente_pianta int,
   id_utente int,
   foreign key (id_utente_pianta) references utente_pianta(id)
      on update CASCADE
      on delete cascade,
   foreign key (id_utente) references utente(id)
      on update cascade
      on delete cascade
);

create table obiettivo(
   id int auto_increment primary key,
   nome varchar(30) not null
);

create table utente_obiettivo(
   id int auto_increment primary key,
   data_inizio date not null,
   id_obiettivo int,
   id_utente int,
   foreign key (id_obiettivo) references obiettivo(id)
      on delete cascade
      on update cascade,
   foreign key (id_utente) references utente(id)
      on delete cascade
      on update cascade
);

create table task(
   id int auto_increment primary key,
   nome varchar(50) not null, 
   scadenza date not null,
   data_inizio date not null,
   periodo int not null
);

create table utente_task(
   id int auto_increment primary key,
   id_task int,
   id_utente int,
   foreign key (id_task) references task(id)
      on delete cascade
      on update cascade,
   foreign key (id_utente) references utente(id)
      on delete cascade
      on update cascade
);

create table gruppo(
   id int auto_increment primary key,
   nome varchar(30) not null
);

create table utente_gruppo(
   id int auto_increment primary key,
   id_gruppo int,
   id_utente int,
   foreign key (id_gruppo) references gruppo(id)
      on delete cascade
      on update cascade,
   foreign key (id_utente) references utente(id)
      on delete cascade
      on update cascade
);

create table servizio(
   id int auto_increment primary key,
   nome varchar(50) not null,
   sconto int default 0
);

create table gruppo_servizio(
   id int auto_increment primary key,
   id_servizio int,
   id_gruppo int,
   foreign key (id_servizio) references servizio(id)
      on delete cascade
      on update cascade,
   foreign key (id_gruppo) references gruppo(id)
      on delete cascade
      on update cascade
);