use quizz_database;
create table quizz ( id int primary key auto_increment, title varchar(64)not null);
create table question ( id int primary key auto_increment, text varchar(1024) not null);
create table reponse ( id int primary key auto_increment, text varchar(1024) not null, isValid boolean not null);
alter table question add (numQuiz int not null, foreign key(numQuiz) references quizz(id));
alter table reponse add (numQuestion int not null, foreign key(numQuestion) references question(id));