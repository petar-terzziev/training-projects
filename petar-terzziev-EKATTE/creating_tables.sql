drop table selishta;
drop table obstini;
drop table oblasti;
 create table oblasti(
  id int not null auto_increment primary key, 
  name varchar(40) not null
  );
 


 create table obstini(
  id int not null auto_increment primary key, 
  oblast int not null, 
  name varchar(40) not null, 
  foreign key(oblast) references oblasti(id)
  );

 create table selishta(
  id int not null auto_increment primary key, 
  obstina int not null,
  name varchar(40) not null,
  foreign key(obstina) references obstini(id) 
  );
 
