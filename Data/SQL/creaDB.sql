PRAGMA foreign_keys = ON;

-- Tables principales :

DROP TABLE IF EXISTS ARTISTE;
CREATE TABLE ARTISTE(
    idArtiste INTEGER PRIMARY KEY AUTOINCREMENT,
    nomA TEXT NOT NULL,
    prenomA TEXT NOT NULL DEFAULT "Inconnu",
    descriptionA TEXT NOT NULL DEFAULT "Pas de description",
    nbAuditeurs INTEGER NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS ALBUM;
CREATE TABLE ALBUM(
    idAlbum INTEGER PRIMARY KEY AUTOINCREMENT,
    idArtiste INTEGER NOT NULL,
    imageAlbum TEXT DEFAULT "default.png",
    nomAlbum TEXT NOT NULL,
    releaseYear INTEGER NOT NULL,
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste)
);

DROP TABLE IF EXISTS MUSIQUE;
CREATE TABLE MUSIQUE (
    idMusique INTEGER PRIMARY KEY AUTOINCREMENT,
    idAlbum INTEGER DEFAULT NULL,
    idArtiste INTEGER NOT NULL,
    imageMusique TEXT DEFAULT "default.png",
    nomMusique TEXT NOT NULL,
    releaseYear INTEGER NOT NULL,
    nbVues INTEGER NOT NULL DEFAULT 0,
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum),
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste)
);

DROP TABLE IF EXISTS UTILISATEUR;
CREATE TABLE UTILISATEUR(
    idUser INTEGER PRIMARY KEY AUTOINCREMENT,
    pseudo TEXT NOT NULL,
    mdp TEXT NOT NULL,
    email TEXT NOT NULL,
    descriptionU TEXT NOT NULL,
    roleU TEXT NOT NULL DEFAULT 'USER',
    imageUser TEXT DEFAULT "default.png"
);

DROP TABLE IF EXISTS PLAYLIST;
CREATE TABLE PLAYLIST(
    idPlaylist INTEGER PRIMARY KEY AUTOINCREMENT,
    idUser INTEGER NOT NULL,
    nomPlaylist TEXT NOT NULL,
    releaseYear INTEGER NOT NULL,
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser)
);

DROP TABLE IF EXISTS GENRE;
CREATE TABLE GENRE(
    idGenre INTEGER PRIMARY KEY AUTOINCREMENT,
    nomGenre TEXT NOT NULL
);


-- Tables de joINTEGERures :

DROP TABLE IF EXISTS CREER;
CREATE TABLE CREER(
    idUser INTEGER NOT NULL,
    idPlaylist INTEGER NOT NULL,
    PRIMARY KEY (idUser, idPlaylist),
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser),
    FOREIGN KEY (idPlaylist) REFERENCES PLAYLIST(idPlaylist)
);

DROP TABLE IF EXISTS CONTENIR;
CREATE TABLE CONTENIR(
    idPlaylist INTEGER NOT NULL,
    idMusique INTEGER NOT NULL,
    PRIMARY KEY (idPlaylist, idMusique),
    FOREIGN KEY (idPlaylist) REFERENCES PLAYLIST(idPlaylist),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique)
);

DROP TABLE IF EXISTS APPRECIER;
CREATE TABLE APPRECIER(
    idUser INTEGER NOT NULL,
    idMusique INTEGER NOT NULL,
    PRIMARY KEY (idUser, idMusique),
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique)
);

DROP TABLE IF EXISTS CLASSER;
CREATE TABLE CLASSER(
    idMusique INTEGER NOT NULL,
    idGenre INTEGER NOT NULL,
    PRIMARY KEY (idMusique, idGenre),
    FOREIGN KEY (idMusique) REFERENCES MUSIQUE(idMusique),
    FOREIGN KEY (idGenre) REFERENCES GENRE(idGenre)
);

DROP TABLE IF EXISTS REALISER;
CREATE TABLE REALISER(
    idArtiste INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    PRIMARY KEY (idArtiste, idAlbum),
    FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
);

DROP TABLE IF EXISTS APPARTENIR;
CREATE TABLE APPARTENIR(
    idAlbum INTEGER NOT NULL,
    idGenre INTEGER NOT NULL,
    PRIMARY KEY (idAlbum, idGenre),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum),
    FOREIGN KEY (idGenre) REFERENCES GENRE(idGenre)
);

DROP TABLE IF EXISTS NOTER;
CREATE TABLE NOTER(
    idUser INTEGER NOT NULL,
    idAlbum INTEGER NOT NULL,
    note INTEGER NOT NULL,
    PRIMARY KEY (idUser, idAlbum),
    FOREIGN KEY (idUser) REFERENCES UTILISATEUR(idUser),
    FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
);