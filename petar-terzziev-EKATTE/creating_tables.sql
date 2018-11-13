 create table oblasti(
  id int not null auto_increment primary key, 
  ekatte varchar(5) not null,
  kod_oblast varchar(3) unique key, 
  name varchar(20) not null
  );
 


 create table obstini(
  id int not null auto_increment primary key, 
  ekatte varchar(5) not null,
  kod_obst varchar(5) unique key not null, 
  name varchar(20) not null, 
  kod_oblast varchar(3) not null  references oblasti(kod_oblast)
  );

 create table selishta(
  id int not null auto_increment primary key, 
  ekatte varchar(5) not null,
  kod_obst varchar(5) not null references obstini(kod_obst), 
  name varchar(20) not null
  );
 
