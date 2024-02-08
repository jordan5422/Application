#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
-- Création de la BDD
CREATE DATABASE IF NOT EXISTS `foodDB`;
USE `foodDB`;


#------------------------------------------------------------
# Table: users
#------------------------------------------------------------

CREATE TABLE users(
        id        Int  Auto_increment  NOT NULL ,
        mail      Varchar (50) NOT NULL ,
        password  Varchar (50) NOT NULL ,
        telephone Int NOT NULL ,
        nom       Varchar (50) NOT NULL ,
        role      Varchar (50) NOT NULL
	,CONSTRAINT users_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: commentaires
#------------------------------------------------------------

CREATE TABLE commentaires(
        id          Int  Auto_increment  NOT NULL ,
        commentaire Text NOT NULL ,
        heure       Date NOT NULL ,
        id_users     Int NOT NULL
	,CONSTRAINT commentaires_PK PRIMARY KEY (id)

	,CONSTRAINT commentaires_users_FK FOREIGN KEY (id_users) REFERENCES users(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: recette
#------------------------------------------------------------

CREATE TABLE recette(
        id           Int  Auto_increment  NOT NULL ,
        nom          Varchar (1000) NOT NULL ,
        nombre_plats Int NOT NULL ,
        id_users      Int NOT NULL
	,CONSTRAINT recette_PK PRIMARY KEY (id)

	,CONSTRAINT recette_users_FK FOREIGN KEY (id_users) REFERENCES users(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: likes
#------------------------------------------------------------

CREATE TABLE likes(
        id         Int  Auto_increment  NOT NULL ,
        date       Date NOT NULL ,
        id_recette Int NOT NULL
	,CONSTRAINT likes_PK PRIMARY KEY (id)

	,CONSTRAINT likes_recette_FK FOREIGN KEY (id_recette) REFERENCES recette(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ingredient
#------------------------------------------------------------

CREATE TABLE ingredient(
        id       Int  Auto_increment  NOT NULL ,
        nom      Varchar (50) NOT NULL ,
        origine  Varchar (50) NOT NULL ,
        quantite Varchar (1000) NOT NULL
	,CONSTRAINT ingredient_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: video
#------------------------------------------------------------

CREATE TABLE video(
        id         Int  Auto_increment  NOT NULL ,
        nom        Varchar (50) NOT NULL ,
        lien       Varchar (1000) NOT NULL ,
        id_recette Int NOT NULL
	,CONSTRAINT video_PK PRIMARY KEY (id)

	,CONSTRAINT video_recette_FK FOREIGN KEY (id_recette) REFERENCES recette(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: image
#------------------------------------------------------------

CREATE TABLE image(
        id            Int  Auto_increment  NOT NULL ,
        nom           Varchar (1000) NOT NULL ,
        lien          Varchar (5) NOT NULL ,
        id_recette    Int NOT NULL ,
        id_ingredient Int NOT NULL
	,CONSTRAINT image_PK PRIMARY KEY (id)

	,CONSTRAINT image_recette_FK FOREIGN KEY (id_recette) REFERENCES recette(id)
	,CONSTRAINT image_ingredient0_FK FOREIGN KEY (id_ingredient) REFERENCES ingredient(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Avoir
#------------------------------------------------------------

CREATE TABLE Avoir(
        id         Int NOT NULL ,
        id_recette Int NOT NULL
	,CONSTRAINT Avoir_PK PRIMARY KEY (id,id_recette)

	,CONSTRAINT Avoir_ingredient_FK FOREIGN KEY (id) REFERENCES ingredient(id)
	,CONSTRAINT Avoir_recette0_FK FOREIGN KEY (id_recette) REFERENCES recette(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: likesr
#------------------------------------------------------------

CREATE TABLE likesr(
        id      Int NOT NULL ,
        id_users Int NOT NULL
	,CONSTRAINT likesr_PK PRIMARY KEY (id,id_users)

	,CONSTRAINT likesr_recette_FK FOREIGN KEY (id) REFERENCES recette(id)
	,CONSTRAINT likesr_users0_FK FOREIGN KEY (id_users) REFERENCES users(id)
)ENGINE=InnoDB;

