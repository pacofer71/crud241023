create table usuarios(
    id int auto_increment primary key,
    nombre varchar(40) not null,
    apellidos varchar(100) not null,
    email varchar(120) unique not null,
    provincia varchar(80) not null,
    perfil enum('Admin', 'User') default 'User'
);