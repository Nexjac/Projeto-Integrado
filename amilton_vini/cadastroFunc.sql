create database Empresa;
use Empresa;
create table Funcionarios(
idFunc int auto_increment primary key,
nome varchar(60) not null,
matricula varchar(30) not null,
funcao varchar(30) not null,
departamento varchar(30) not null,
idade char(3),
cpf varchar (13),
rg varchar(15),
salario decimal(8.2),
endereco varchar(30) not null,
uf char(3) not null,
pais varchar(20) not null
);
select*from Funcionarios; 