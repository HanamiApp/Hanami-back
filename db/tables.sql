create table `user` (
   id int auto_increment,
   name varchar(50) NOT NULL,
   surname varchar(50) NOT NULL,
   email varchar(100) NOT NULL,
   password varchar(25) NOT NULL,
   primary key(id)
);