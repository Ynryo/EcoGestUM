DROP DATABASE IF EXISTS ecogestum;
CREATE DATABASE ecogestum;
USE ecogestum;

DROP TABLE IF EXISTS agencer;
DROP TABLE IF EXISTS aimer;
DROP TABLE IF EXISTS recuperer;
DROP TABLE IF EXISTS notification;
DROP TABLE IF EXISTS communique;
DROP TABLE IF EXISTS statistique;
DROP TABLE IF EXISTS departement;
DROP TABLE IF EXISTS service;
DROP TABLE IF EXISTS evenement;
DROP TABLE IF EXISTS objet;
DROP TABLE IF EXISTS categorie;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS composante;
DROP TABLE IF EXISTS inventaire;
DROP TABLE IF EXISTS role;
DROP TABLE IF EXISTS odd;

CREATE TABLE
   role (
      id_role INT AUTO_INCREMENT,
      nom_role VARCHAR(255) NOT NULL,
      PRIMARY KEY (id_role),
      UNIQUE (nom_role)
   );

CREATE TABLE
   odd (
      id_odd INT AUTO_INCREMENT,
      num_odd VARCHAR(50) NOT NULL,
      titre_odd VARCHAR(255) NOT NULL,
      desc_odd MEDIUMTEXT,
      link_odd VARCHAR(255) NOT NULL,
      PRIMARY KEY (id_odd),
      UNIQUE (num_odd),
      UNIQUE (titre_odd)
   );

CREATE TABLE
   inventaire (
      id_inventaire INT AUTO_INCREMENT,
      nom_inventaire VARCHAR(255) NOT NULL,
      PRIMARY KEY (id_inventaire)
   );

CREATE TABLE
   utilisateur (
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
      FOREIGN KEY (id_role) REFERENCES role (id_role) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   composante (
      id_composante INT AUTO_INCREMENT,
      nom_composante VARCHAR(255) NOT NULL,
      coords_composante VARCHAR(255),
      ville VARCHAR(255) NOT NULL,
      id_utilisateur INT,
      PRIMARY KEY (id_composante),
      UNIQUE (id_utilisateur),
      FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   departement (
      id_departement INT AUTO_INCREMENT,
      nom_departement VARCHAR(255) NOT NULL,
      id_utilisateur INT,
      id_composante INT NOT NULL,
      id_inventaire INT,
      PRIMARY KEY (id_departement),
      UNIQUE (id_utilisateur),
      FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_composante) REFERENCES composante (id_composante) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_inventaire) REFERENCES inventaire (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   evenement (
      id_evenement INT AUTO_INCREMENT,
      titre_evenement VARCHAR(255) NOT NULL,
      desc_evenement VARCHAR(255),
      date_debut DATETIME NOT NULL,
      date_fin DATETIME NOT NULL,
      id_composante INT,
      PRIMARY KEY (id_evenement),
      FOREIGN KEY (id_composante) REFERENCES composante (id_composante) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   categorie (
      id_categorie INT AUTO_INCREMENT,
      titre_categorie VARCHAR(255) NOT NULL,
      desc_categorie VARCHAR(255),
      id_odd INT,
      PRIMARY KEY (id_categorie),
      UNIQUE (titre_categorie),
      FOREIGN KEY (id_odd) REFERENCES odd (id_odd) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   statistique (
      id_statistique INT AUTO_INCREMENT,
      titre_statistique VARCHAR(255) NOT NULL,
      nb_recyclages INT NOT NULL,
      id_categorie INT,
      PRIMARY KEY (id_statistique),
      FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   communique (
      id_communique INT AUTO_INCREMENT,
      titre_communique VARCHAR(255) NOT NULL,
      contenu TEXT NOT NULL,
      cat_communique VARCHAR(255) NOT NULL,
      date_publication DATETIME NOT NULL,
      id_utilisateur INT NOT NULL,
      PRIMARY KEY (id_communique),
      FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   service (
      id_service INT AUTO_INCREMENT,
      nom_service VARCHAR(255) NOT NULL,
      id_utilisateur INT,
      id_inventaire INT,
      id_composante INT NOT NULL,
      PRIMARY KEY (id_service),
      UNIQUE (id_utilisateur),
      FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_inventaire) REFERENCES inventaire (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_composante) REFERENCES composante (id_composante) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   notification (
      id_notification INT AUTO_INCREMENT,
      titre_notification VARCHAR(255) NOT NULL,
      date_envoi DATE NOT NULL,
      id_emetteur INT NOT NULL,
      id_recepteur INT NOT NULL,
      PRIMARY KEY (id_notification),
      FOREIGN KEY (id_emetteur) REFERENCES utilisateur (id_utilisateur) ON DELETE NO ACTION ON UPDATE NO ACTION,
      FOREIGN KEY (id_recepteur) REFERENCES utilisateur (id_utilisateur) ON DELETE NO ACTION ON UPDATE NO ACTION
   );

CREATE TABLE
   objet (
      id_objet INT AUTO_INCREMENT,
      nom_objet VARCHAR(255) NOT NULL,
      desc_objet VARCHAR(255),
      color VARCHAR(20),
      etat VARCHAR(20),
      size VARCHAR(20) DEFAULT "Taille unique",
      quantity SMALLINT NOT NULL,
      date_ajout DATE NOT NULL,
      statut VARCHAR(30) NOT NULL,
      id_categorie INT,
      PRIMARY KEY (id_objet),
      FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT statut_contrainte CHECK (
         statut IN (
            'disponible',
            'réservé',
            'indisponible',
            'en_élimination',
            'supprimé'
         )
      )
   );

CREATE TABLE
   recuperer (
      id_donneur INT,
      id_recepteur INT,
      id_objet INT,
      date_ajout DATETIME NOT NULL,
      date_fin DATETIME,
      FOREIGN KEY (id_donneur) REFERENCES inventaire (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_recepteur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_objet) REFERENCES objet (id_objet) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   agencer (
      id_objet INT,
      id_inventaire INT,
      PRIMARY KEY (id_objet, id_inventaire),
      FOREIGN KEY (id_objet) REFERENCES objet (id_objet) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_inventaire) REFERENCES inventaire (id_inventaire) ON DELETE CASCADE ON UPDATE CASCADE
   );

CREATE TABLE
   aimer (
      id_utilisateur INT,
      id_objet INT,
      PRIMARY KEY (id_utilisateur, id_objet),
      FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY (id_objet) REFERENCES objet (id_objet) ON DELETE CASCADE ON UPDATE CASCADE
   );