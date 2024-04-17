drop database quizz;
create database quizz;
use quizz;
create table quiz
(
    id int primary key not null auto_increment,
    title varchar(255) not null
);
create table question
(
    id int primary key not null auto_increment,
    text varchar(255) not null,
    numQuiz int,
    foreign key (numQuiz) references quiz(id)
);
create table reponse
(
    id int primary key not null auto_increment,
    text varchar(255) not null,
    isValid boolean,
    numQuestion int,
    foreign key (numQuestion) references question(id)
);