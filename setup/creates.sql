DROP DATABASE IF EXISTS sae;
CREATE DATABASE sae;
USE sae;

DROP TABLE IF EXISTS AGENCER;
DROP TABLE IF EXISTS AIMER;
DROP TABLE IF EXISTS RECUPERER;
DROP TABLE IF EXISTS NOTIFICATION;
DROP TABLE IF EXISTS COMMUNIQUE;
DROP TABLE IF EXISTS STATISTIQUE;
DROP TABLE IF EXISTS DEPARTEMENT;
DROP TABLE IF EXISTS SERVICE;
DROP TABLE IF EXISTS EVENEMENT;
DROP TABLE IF EXISTS OBJET;
DROP TABLE IF EXISTS CATEGORIE;
DROP TABLE IF EXISTS UTILISATEUR;
DROP TABLE IF EXISTS COMPOSANTE;
DROP TABLE IF EXISTS INVENTAIRE;
DROP TABLE IF EXISTS ROLE;
DROP TABLE IF EXISTS ODD;

CREATE TABLE ROLE (
   id_role INT AUTO_INCREMENT,
   nom_role VARCHAR(255) NOT NULL,
   PRIMARY KEY (id_role),
   UNIQUE (nom_role)
);

CREATE TABLE ODD (
   id_odd INT AUTO_INCREMENT,
   titre_odd VARCHAR(255) NOT NULL,
   desc_odd VARCHAR(255),
   image_odd VARCHAR(255) NOT NULL,
   PRIMARY KEY (id_odd),
   UNIQUE (titre_odd)
);

CREATE TABLE INVENTAIRE (
   id_inventaire INT AUTO_INCREMENT,
   nom_inventaire VARCHAR(255) NOT NULL,
   PRIMARY KEY (id_inventaire)
);

CREATE TABLE COMPOSANTE (
   id_composante INT AUTO_INCREMENT,
   nom_composante VARCHAR(255) NOT NULL,
   coords_composante VARCHAR(255),
   ville VARCHAR(255) NOT NULL,
   PRIMARY KEY (id_composante)
);

CREATE TABLE DEPARTEMENT (
   id_departement INT AUTO_INCREMENT,
   nom_departement VARCHAR(255) NOT NULL,
   coords_departement VARCHAR(255) NOT NULL,
   id_composante INT NOT NULL,
   id_inventaire INT,
   PRIMARY KEY (id_departement),
   FOREIGN KEY (id_composante) REFERENCES COMPOSANTE (id_composante) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_inventaire) REFERENCES INVENTAIRE (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE EVENEMENT (
   id_evenement INT AUTO_INCREMENT,
   titre_evenement VARCHAR(255) NOT NULL,
   desc_evenement VARCHAR(255),
   date_debut DATETIME NOT NULL,
   date_fin DATETIME NOT NULL,
   id_composante INT,
   PRIMARY KEY (id_evenement),
   FOREIGN KEY (id_composante) REFERENCES COMPOSANTE (id_composante) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE UTILISATEUR (
   id_utilisateur INT AUTO_INCREMENT,
   identifiant VARCHAR(50) NOT NULL,
   nom_utilisateur VARCHAR(255) NOT NULL,
   prenom_utilisateur VARCHAR(255) NOT NULL,
   mail_univ VARCHAR(255) NOT NULL,
   mdp_univ VARCHAR(255) NOT NULL,
   id_role INT NOT NULL,
   PRIMARY KEY (id_utilisateur),
   UNIQUE (identifiant),
   UNIQUE (mail_univ),
   FOREIGN KEY (id_role) REFERENCES ROLE (id_role) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CATEGORIE (
   id_categorie INT AUTO_INCREMENT,
   titre_categorie VARCHAR(255) NOT NULL,
   desc_categorie VARCHAR(255),
   id_odd INT,
   PRIMARY KEY (id_categorie),
   UNIQUE (titre_categorie),
   FOREIGN KEY (id_odd) REFERENCES ODD (id_odd) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE STATISTIQUE (
   id_statistique INT AUTO_INCREMENT,
   titre_statistique VARCHAR(255) NOT NULL,
   nb_recyclages INT NOT NULL,
   id_categorie INT,
   PRIMARY KEY (id_statistique),
   FOREIGN KEY (id_categorie) REFERENCES CATEGORIE (id_categorie) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE COMMUNIQUE (
   id_communique INT AUTO_INCREMENT,
   titre_communique VARCHAR(255) NOT NULL,
   contenu TEXT NOT NULL, 
   cat_communique VARCHAR(255) NOT NULL,
   date_publication DATETIME NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY (id_communique),
   FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE SERVICE (
   id_service INT AUTO_INCREMENT,
   nom_service VARCHAR(255) NOT NULL,
   coords_service VARCHAR(255) NOT NULL,
   id_inventaire INT,
   id_composante INT NOT NULL,
   PRIMARY KEY (id_service),
   FOREIGN KEY (id_inventaire) REFERENCES INVENTAIRE (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_composante) REFERENCES COMPOSANTE (id_composante) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE NOTIFICATION (
   id_notification INT AUTO_INCREMENT,
   titre_notification VARCHAR(255) NOT NULL,
   date_envoi DATE NOT NULL,
   id_emetteur INT NOT NULL,
   id_recepteur INT NOT NULL,
   PRIMARY KEY (id_notification),
   FOREIGN KEY (id_emetteur) REFERENCES UTILISATEUR (id_utilisateur) ON DELETE NO ACTION ON UPDATE NO ACTION,
   FOREIGN KEY (id_recepteur) REFERENCES UTILISATEUR (id_utilisateur) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE OBJET (
   id_objet INT AUTO_INCREMENT,
   nom_objet VARCHAR(255) NOT NULL,
   desc_objet VARCHAR(255),
   color VARCHAR(20),
   etat VARCHAR(20),
   size VARCHAR(20),
   quantity SMALLINT NOT NULL,
   date_ajout DATE NOT NULL,
   statut VARCHAR(30) NOT NULL,
   id_categorie INT,
   PRIMARY KEY (id_objet),
   FOREIGN KEY (id_categorie) REFERENCES CATEGORIE (id_categorie) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT statut_contrainte CHECK (
      statut IN (
         'Disponible',
         'Réservé',
         'Indisponible',
         'En élimination',
         'Supprimé'
      )
   )
);

CREATE TABLE RECUPERER (
   id_donneur INT,
   id_recepteur INT,
   id_objet INT,
   date_ajout DATETIME NOT NULL,
   date_fin DATETIME,
   PRIMARY KEY (id_recepteur, id_objet, id_donneur),
   FOREIGN KEY (id_donneur) REFERENCES INVENTAIRE (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_recepteur) REFERENCES UTILISATEUR (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_objet) REFERENCES OBJET (id_objet) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE AGENCER (
   id_objet INT,
   id_inventaire INT,
   PRIMARY KEY (id_objet, id_inventaire),
   FOREIGN KEY (id_objet) REFERENCES OBJET (id_objet) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_inventaire) REFERENCES INVENTAIRE (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE AIMER (
   id_utilisateur INT,
   id_objet INT,
   PRIMARY KEY (id_utilisateur, id_objet),
   FOREIGN KEY (id_utilisateur) REFERENCES UTILISATEUR (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
   FOREIGN KEY (id_objet) REFERENCES OBJET (id_objet) ON DELETE CASCADE ON UPDATE CASCADE
);