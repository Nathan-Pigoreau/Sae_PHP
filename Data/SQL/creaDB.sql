PRAGMA foreign_keys = ON;

-- Désactivation des clés étrangères
PRAGMA foreign_keys = OFF;

-- Tables de joINTure :
DROP TABLE IF EXISTS CONTENIR;
DROP TABLE IF EXISTS APPRECIER;
DROP TABLE IF EXISTS CLASSER;
DROP TABLE IF EXISTS REALISER;
DROP TABLE IF EXISTS APPARTENIR;
DROP TABLE IF EXISTS NOTER;

-- Tables principales :
DROP TABLE IF EXISTS PLAYLIST;
DROP TABLE IF EXISTS MUSIQUE;
DROP TABLE IF EXISTS ALBUM;
DROP TABLE IF EXISTS ARTISTE;
DROP TABLE IF EXISTS UTILISATEUR;
DROP TABLE IF EXISTS GENRE;

-- Activation des clés étrangères
PRAGMA foreign_keys = ON;


-- Tables principales :


CREATE TABLE ARTISTE(
    idArtiste INTEGER PRIMARY KEY AUTOINCREMENT,
    nomA TEXT NOT NULL,
    prenomA TEXT NOT NULL DEFAULT "Inconnu",
    descriptionA TEXT NOT NULL DEFAULT "Pas de description",
    imageArtiste TEXT DEFAULT "defaultPDP.png",
    nbAuditeurs INTEGER NOT NULL DEFAULT 0
);


CREATE TABLE ALBUM(
    idAlbum INTEGER PRIMARY KEY AUTOINCREMENT,
    idArtiste INTEGER NOT NULL,
    imageAlbum TEXT DEFAULT "default.jpg",
    nomAlbum TEXT NOT NULL,
    releaseYear INTEGER NOT NULL,
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste)
);


CREATE TABLE MUSIQUE (
    idMusique INTEGER PRIMARY KEY AUTOINCREMENT,
    idAlbum INTEGER DEFAULT NULL,
    idArtiste INTEGER NOT NULL,
    imageMusique TEXT DEFAULT "default.jpg",
    nomMusique TEXT NOT NULL,
    releaseYear INTEGER NOT NULL,
    nbVues INTEGER NOT NULL DEFAULT 0,
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum),
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste)
);


CREATE TABLE UTILISATEUR(
    idUser INTEGER PRIMARY KEY AUTOINCREMENT,
    pseudo TEXT NOT NULL,
    mdp TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    descriptionU TEXT NOT NULL,
    roleU TEXT NOT NULL DEFAULT 'USER',
    imageUser TEXT DEFAULT "defaultPDP.png"
);


CREATE TABLE PLAYLIST(
    idPlaylist INTEGER PRIMARY KEY AUTOINCREMENT,
    idUser INTEGER NOT NULL,
    nomPlaylist TEXT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser)
);


CREATE TABLE GENRE(
    idGenre INTEGER PRIMARY KEY AUTOINCREMENT,
    nomGenre TEXT NOT NULL
);


-- Tables de joINTEGERures :

CREATE TABLE CONTENIR(
    idPlaylist INTEGER NOT NULL,
    idMusique INTEGER NOT NULL,
    PRIMARY KEY (idPlaylist, idMusique),
    FOREIGN KEY (idPlaylist) REFERENCES PLAYLIST(idPlaylist),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique)
);


CREATE TABLE APPRECIER(
    idUser INTEGER NOT NULL,
    idMusique INTEGER NOT NULL,
    PRIMARY KEY (idUser, idMusique),
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique)
);


CREATE TABLE CLASSER(
    idMusique INTEGER NOT NULL,
    idGenre INTEGER NOT NULL,
    PRIMARY KEY (idMusique, idGenre),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique),
    FOREIGN KEY (idGenre) REFERENCES GENRE(idGenre)
);


CREATE TABLE REALISER(
    idArtiste INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    PRIMARY KEY (idArtiste, idAlbum),
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
);


CREATE TABLE APPARTENIR(
    idAlbum INTEGER NOT NULL,
    idGenre INTEGER NOT NULL,
    PRIMARY KEY (idAlbum, idGenre),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum),
    FOREIGN KEY (idGenre) REFERENCES GENRE(idGenre)
);


CREATE TABLE NOTER(
    idUser INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    note INTEGER NOT NULL,
    PRIMARY KEY (idUser, idAlbum),
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
);


-- Insertion des données :

INSERT INTO ARTISTE (nomA, prenomA, descriptionA, imageArtiste, nbAuditeurs) VALUES ("Artiste1", "Prenom1", "Description1", "defaultPDP.png", 0);

INSERT INTO ALBUM (idArtiste, imageAlbum, nomAlbum, releaseYear) VALUES (1, "default.jpg", "Album1", 2021);

INSERT INTO MUSIQUE (idAlbum, idArtiste, imageMusique, nomMusique, releaseYear, nbVues) VALUES (1, 1, "default.jpg", "Musique1", 2021, 0);