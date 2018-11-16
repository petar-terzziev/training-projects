 drop table oblasti;
 create table oblasti(
  id SERIAL unique primary key,
  kod_oblast varchar(3) unique not null,
  name varchar(40) not null
  );
 


 create table obstini(
  id SERIAL unique primary key, 
  kod_obstina varchar(5) unique not null,
  oblast int not null, 
  name varchar(40) not null, 
  foreign key(oblast) references oblasti(id)
  );

 create table selishta(
  id SERIAL unique primary key, 
  ekatte varchar(5) unique not null,
  obstina int not null,
  name varchar(40) not null,
  foreign key(obstina) references obstini(id) 
  );
 
