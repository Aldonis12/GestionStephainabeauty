create table Authentification (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(20) NOT NULL,
    mdp VARCHAR(20) NOT NULL
);

create table Salon (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL,
    adresse VARCHAR(75) NOT NULL
);

create table Types(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(10) NOT NULL
);

create table Service (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    idtypes integer REFERENCES Types(id)
);

create table Genre (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(25) NOT NULL
);

create table Employe (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    idgenre integer REFERENCES Genre(id),
    isCanceled integer default 0,
    isInternship integer default 0,
    inserted timestamp default CURRENT_TIMESTAMP
);


create table EmployeService (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idemploye integer REFERENCES Employe(id),
    idservice integer REFERENCES Service(id),
    idsalon integer REFERENCES Salon(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table EmployeQuit(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idemploye integer REFERENCES Employe(id),
    motif VARCHAR(10) NOT NULL,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Influenceur (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    Code VARCHAR(15) NOT NULL,
    isCanceled integer default 0,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table ReseauxSociaux(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL
);

create TABLE InfluenceurReseauxSociaux (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idinfluenceur integer REFERENCES Influenceur(id),
    idreseauxsociaux integer REFERENCES ReseauxSociaux(id),
    followers integer default 0
);

create table InfluenceurDetails (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idinfluenceur integer REFERENCES Influenceur(id),
    idreseauxsociaux integer REFERENCES ReseauxSociaux(id),
    lien VARCHAR(50) NOT NULL,
    likes integer default 0,
    comments integer default 0,
    inserted timestamp NOT NULL
);

create table InfluenceurQuit(
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idinfluenceur integer REFERENCES Influenceur(id),
    motif VARCHAR(10) NOT NULL,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table InfluenceurPrestataire (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idinfluenceur integer REFERENCES Influenceur(id),
    idsalon integer REFERENCES Salon(id),
    idservice integer REFERENCES Service(id),
    idemploye integer REFERENCES Employe(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Client (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_naissance DATE NOT NULL,
    idgenre integer REFERENCES Genre(id),
    adresse VARCHAR(50) NOT NULL,
    numero VARCHAR(15),
    email VARCHAR(50),
    profession VARCHAR(50),
    Code integer REFERENCES Influenceur(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table ClientDetails (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idclient integer REFERENCES Client(id),
    idsalon integer REFERENCES Salon(id),
    idservice integer REFERENCES Service(id),
    idemploye integer REFERENCES Employe(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Question (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    Question text NOT NULL
);

CREATE TABLE Reponse (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idquest INTEGER REFERENCES Question(id),
    valeur INTEGER NOT NULL,
    reponse TEXT NOT NULL
);

create table ReponseClient (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    idclient integer REFERENCES Client(id),
    idquestion integer REFERENCES Question(id),
    idsalon integer REFERENCES Salon(id),
    reponse integer REFERENCES Reponse(id),
    inserted timestamp default CURRENT_TIMESTAMP
);