drop database if exists verkkokauppa;
create database verkkokauppa;
use verkkokauppa;

create table tuoteryhma (
    id int primary key AUTO_INCREMENT,
    nimi varchar(50) not null UNIQUE 
);

create table tuote (
    id int primary key auto_increment,
    nimi varchar(100) not null,
    hinta DECIMAL(5,2) not null,
    kuvaus text,
    varastomaara int not null,
    tuoteryhma_id int not null,
    index (tuoteryhma_id),
    foreign key (tuoteryhma_id) references tuoteryhma(id)
    on delete restrict
);

insert into tuoteryhma (nimi) values ('asusteet');

insert into tuote (nimi,hinta,varastomaara,tuoteryhma_id) values
('takki',50,6,1);

insert into tuote (nimi,hinta,varastomaara,tuoteryhma_id) values
('housut',73,3,1);