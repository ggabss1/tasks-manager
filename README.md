# tasks-manager
Registro, edição e visualização de tarefas com prazo de realização
Utiliza banco de dados postgresql
--------------------------------
CREATE TABLE users (
 usuario varchar(256),
 email varchar(256),
 senha varchar(256)
)
CREATE TABLE tasks (
 id int,
 usuario varchar(256),
 titulo varchar(256),
 status varchar (256),
 descricao varchar(256),
 data_registro date,
 prazo date
)
