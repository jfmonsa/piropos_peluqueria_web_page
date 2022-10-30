 drop database IF EXISTS piropos;
    CREATE DATABASE piropos 
    character set utf8mb4 COLLATE utf8mb4_general_ci;
    use piropos;



    create table fechasDisponibles(
        id_fecha  datetime primary key unique  NOT NULL, /* time() */
        Isdisponible tinyint(1) unsigned  NOT NULL
    )ENGINE=InnoDB;

    create table citasAgendadas(
    id varchar(255) primary key unique NOT NULL,
    isCommented tinyint(1) unsigned not NULL,/* $tel."--".time() */
    nombre varchar(30)  NOT NULL,
    tel varchar(15)  NOT NULL,
    fecha_inicio datetime  NOT NULL,
    fecha_finalizado datetime  NOT NULL,
    genero char(1) NOT NULL,
    fecha_en_que_fue_agendada datetime not null,
    services set('0','1','2','3')  NOT NULL
     -- fk_id_fechaDisponible datetime unique  NOT NULL,
    /* constraint FOREIGN KEY(fk_id_fechaDisponible) references fechasDisponibles(id_fecha)
    ON UPDATE CASCADE ON DELETE RESTRICT*/
    )ENGINE=InnoDB;


    
    -- for the admin login
    create table administrador(
        usuario VARCHAR(40) primary key not null, 
       	contrasenia char(40)# Encriptamiento sha1 = 40 ch  -- SHA1
    )ENGINE=InnoDB;

    CREATE TABLE comentarios(
        id_citaAgendada varchar(255) primary key NOT NULL,
        nombre varchar(30)  not null,
        ruta_imagen varchar(255) not null,
        comentario varchar(200) not null,
        estado tinyint(1) not null # 0 - inactivo | 1 - activo
    )Engine=InnoDB;

    CREATE TABLE blogs(
        id int PRIMARY KEY UNIQUE AUTO_INCREMENT NOT NULL,
        titulo varchar(90) NOT NULL,
        autor varchar(90) NOT NULL,
        fecha_publicacion datetime NOT NULL,
        ruta_imagen varchar(255) NOT NULL,
        texto longtext NOT NULL,
        estado tinyint(1) NOT NULL,
        FULLTEXT(titulo,texto)
    )ENGINE=InnoDB;