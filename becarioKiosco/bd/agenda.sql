rty456$%&RTY

create database tabladinamicaprueba;
use tabladinamicaprueba;

create table t_personas
	(
		id int auto_increment,
		nombre varchar(50),
		apellido varchar(50),
		email varchar(50),
		telefono varchar(50),
		primary key(id)
	);

insert into 
	t_personas (id, nombre, apellido, email, telefono)
	values (null, 'juan', 'perez', 'jp@gmail.com', '3454489567');

INSERT INTO `t_productos` (`id`, `nombre`,`stock` , `precio`, `categoria`, `codigodebarra`) VALUES 
(NULL, 'Alfajor',25 ,'25', 'kiosco', '1'), 
(NULL, 'Gaseosa',50 ,'50', 'kiosco', '2');


/*uner*/
create database bduner;
use bduner;

create table t_productos
	(
		id int auto_increment,
		nombre varchar(50),
		precio varchar(50),
		stock int,
		categoria varchar(50),
		codigodebarra varchar(50),
		primary key(id)
	);

create table t_productosvt
	(
		id int auto_increment,
		nombre varchar(50),
		precio varchar(50),
		categoria varchar(50),
		codigodebarra varchar(50),
		primary key(id)
	);

create table t_productosv
	(
		id int auto_increment,
		nombre varchar(50),
		precio varchar(50),
		categoria varchar(50),
		codigodebarra varchar(50),
		primary key(id)
	);