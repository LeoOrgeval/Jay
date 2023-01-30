create database if not exists back_office;

use back_office;

create table admin
(
    id int primary key auto_increment,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null
    )
)

create table tags
(
    id    int primary key auto_increment,
    title varchar(256) not null
) engine = innoDB;

create table card
(
    id          int primary key auto_increment,
    title       varchar(256) not null,
    image_url   varchar(256) not null,
    link_url    varchar(256),
    description longtext

) engine = innoDB;


insert into tags (title)
values (?);

insert into card (title, image_url, link_url, description)
values (?, ?, ?, ?);
