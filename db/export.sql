create database dbz;
use dbz;

create table user(
	id int auto_increment,
	username varchar(128) unique not null,
	email varchar(128) unique not null,
	senha char(32) not null,
	primary key(id));

create table pontuacao(
	id_user int not null,
	pontos int not null,
	criado_em date not null,
	foreign key(id_user) references user);

create table perguntas(
	id int auto_increment,
	pergunta varchar(256) unique not null,
	valor tinyint not null default 10,
	primary key(id));
	
create table respostas(
	id int auto_increment,
	id_pergunta int not null,
	resposta varchar(256) unique not null,
	certo tinyint not null default 0,
	primary key(id),
	foreign key(id_pergunta) references perguntas);
	
create table hist_pergunta(
	id_user int not null,
	id_pergunta int not null,
	criado_em date not null,
	foreign key (id_user) references user,
	foreign key (id_pergunta) references perguntas,
	primary key (id_user, id_pergunta));
