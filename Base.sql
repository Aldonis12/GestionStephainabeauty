\c stephainabeauty projet

create table Authentification (
    id Serial PRIMARY KEY,
    email VARCHAR(20) NOT NULL,
    mdp VARCHAR(20) NOT NULL
);

create table Salon (
    id Serial PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    adresse VARCHAR(75) NOT NULL
    --latitude double precision,
    --longitude double precision
);

create table Types(
    id Serial PRIMARY KEY,
    nom VARCHAR(10) NOT NULL
);

create table Service (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    idtypes integer REFERENCES Types(id)
);

create table Genre (
    id Serial PRIMARY KEY,
    nom VARCHAR(25) NOT NULL
);

create table Employe (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    idgenre integer REFERENCES Genre(id),
    isCanceled integer default 0,
    isInternship integer default 0,
    inserted timestamp default CURRENT_TIMESTAMP
);


create table EmployeService (
    id Serial PRIMARY KEY,
    idemploye integer REFERENCES Employe(id),
    idservice integer REFERENCES Service(id),
    idsalon integer REFERENCES Salon(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table EmployeQuit(
    id Serial PRIMARY KEY,
    idemploye integer REFERENCES Employe(id),
    motif VARCHAR(10) NOT NULL,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Influenceur (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    Code VARCHAR(15) NOT NULL,
    isCanceled integer default 0,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table ReseauxSociaux(
    id serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

create TABLE InfluenceurReseauxSociaux (
    id serial PRIMARY KEY,
    idinfluenceur integer REFERENCES Influenceur(id) NOT NULL,
    idreseauxsociaux integer REFERENCES ReseauxSociaux(id) NOT NULL,
    followers integer default 0
);

create table InfluenceurDetails (
    id serial PRIMARY KEY,
    idinfluenceur integer REFERENCES Influenceur(id) NOT NULL,
    idreseauxsociaux integer REFERENCES ReseauxSociaux(id) NOT NULL,
    lien VARCHAR(50) NOT NULL,
    likes integer default 0,
    comments integer default 0,
    inserted timestamp NOT NULL
);

create table InfluenceurQuit(
    id Serial PRIMARY KEY,
    idinfluenceur integer REFERENCES Influenceur(id),
    motif VARCHAR(10) NOT NULL,
    inserted timestamp default CURRENT_TIMESTAMP
);

create table InfluenceurPrestataire (
    id serial PRIMARY KEY,
    idinfluenceur integer REFERENCES Influenceur(id),
    idsalon integer REFERENCES Salon(id),
    idservice integer REFERENCES Service(id),
    idemploye integer REFERENCES Employe(id),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Client (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_naissance DATE NOT NULL,
    idgenre integer REFERENCES Genre(id),
    adresse VARCHAR(50) NOT NULL,
    numero VARCHAR(15),
    email VARCHAR(50),
    profession VARCHAR(50),
    Code integer REFERENCES Influenceur(id),
    qr_code VARCHAR(50),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table ClientDetails (
    id serial PRIMARY KEY,
    idclient integer REFERENCES Client(id),
    idsalon integer REFERENCES Salon(id),
    idservice integer REFERENCES Service(id),
    idemploye integer REFERENCES Employe(id),
    prix decimal(15,2),
    inserted timestamp default CURRENT_TIMESTAMP
);

create table Question (
    id Serial PRIMARY KEY,
    Question text NOT NULL
);

CREATE TABLE Reponse (
    id SERIAL PRIMARY KEY,
    idquest INTEGER REFERENCES Question(id),
    valeur INTEGER NOT NULL,
    reponse TEXT NOT NULL
);

create table ReponseClient (
    id Serial PRIMARY KEY,
    idclient integer REFERENCES Client(id),
    idquestion integer REFERENCES Question(id),
    idsalon integer REFERENCES Salon(id),
    reponse integer REFERENCES Reponse(id),
    inserted timestamp default CURRENT_TIMESTAMP
);


create view v_dashcarousel AS
    SELECT
        salon.id AS salon_id,
        service.nom AS service_nom,
        COUNT(employe.id) AS nombre_emp
    FROM
        EmployeService
    JOIN
        Salon ON EmployeService.idsalon = Salon.id
    JOIN
        Service ON EmployeService.idservice = Service.id
    LEFT JOIN
        Employe ON EmployeService.idemploye = Employe.id
        WHERE
        Employe.isCanceled = 0
        AND Service.idtypes = 1
    GROUP BY
        salon_id, service_nom
    ORDER BY
        salon_id;

create view v_dashclientmensuel AS
    SELECT 
        EXTRACT(MONTH FROM inserted) AS mois,
        EXTRACT(YEAR FROM inserted) AS annee,
        COUNT(*) AS nombre_de_clients
    FROM 
        ClientDetails
    GROUP BY 
        mois,annee
    ORDER BY 
        annee asc, mois asc;

create view v_dashreponseclientmensuel AS
    SELECT 
        EXTRACT(MONTH FROM inserted) AS mois,
        EXTRACT(YEAR FROM inserted) AS annee,
        SUM(CASE WHEN reponse = 1 THEN 1 ELSE 0 END) AS reponse_1,
        SUM(CASE WHEN reponse = 2 THEN 1 ELSE 0 END) AS reponse_2,
        SUM(CASE WHEN reponse = 3 THEN 1 ELSE 0 END) AS reponse_3
    FROM 
        reponseclient
    GROUP BY 
        mois,annee
    ORDER BY 
        annee asc, mois asc;

create view v_salonsemaine AS
    SELECT
        idsalon,
        idservice,
        service.nom,
        EXTRACT(WEEK FROM inserted) AS semaine,
        EXTRACT(YEAR FROM inserted) AS annee,
        COUNT(idservice) AS nombre
    FROM
        clientdetails
        JOIN service ON clientdetails.idservice = service.id
    GROUP BY
        idsalon,service.nom, idservice, semaine, annee
    ORDER BY
        idsalon,service.nom, idservice, semaine, annee;

create view v_servsalon AS
    SELECT 
        es.idservice,s.nom, COUNT(*) AS nombre
    FROM 
        EmployeService es
    JOIN 
        Employe e ON es.idemploye = e.id
    JOIN 
        Salon s ON es.idsalon = s.id
    WHERE 
        e.isCanceled = 0
    GROUP BY 
        s.nom,es.idservice;

create view V_Influenceur AS
    SELECT
        I.id AS id,
        R.nom AS reseau,
        COUNT(ID.id) AS nombre
    FROM 
        Influenceur AS I
    INNER JOIN 
        InfluenceurDetails AS ID ON I.id = ID.idinfluenceur
    INNER JOIN 
        ReseauxSociaux AS R ON ID.idreseauxsociaux = R.id
    GROUP BY
        I.id, R.nom
    ORDER BY 
        I.id, R.nom;

create view V_InfluenceurReseaux AS
    SELECT 
        I.id AS id,
        I.nom AS nom,
        RS.nom AS reseau,
        IR.followers AS followers,
        COALESCE(COUNT(ID.id), 0) AS publication
    FROM 
        Influenceur I
    JOIN 
        InfluenceurReseauxSociaux IR ON I.id = IR.idinfluenceur
    JOIN 
        ReseauxSociaux RS ON RS.id = IR.idreseauxsociaux
    LEFT JOIN 
        InfluenceurDetails ID ON I.id = ID.idinfluenceur AND IR.idreseauxsociaux = ID.idreseauxsociaux
    GROUP BY 
        I.id, I.nom, RS.nom, IR.followers
    ORDER BY 
        I.id, I.nom, RS.nom;

create view V_ListInfluenceur AS 
    SELECT * 
        FROM 
            Influenceur 
                WHERE id NOT IN (SELECT idinfluenceur FROM InfluenceurDetails WHERE idinfluenceur = Influenceur.id)
        UNION
    SELECT *
        FROM 
            Influenceur 
                WHERE id NOT IN (SELECT idinfluenceur FROM InfluenceurReseauxSociaux WHERE idinfluenceur = Influenceur.id);

create view V_ListClientFidele AS
    SELECT
        idclient,
        EXTRACT(MONTH FROM inserted) AS mois,
        EXTRACT(YEAR FROM inserted) AS annee,
        COUNT(DISTINCT id) AS visite
    FROM 
        ClientDetails
    GROUP BY 
        idclient, mois, annee;

create view V_ListClientCode AS
    SELECT I.id,I.nom AS nom, I.Code AS code, COUNT(*) AS nombre
    FROM Client AS C
    LEFT JOIN Influenceur AS I ON C.Code = I.id
    WHERE I.id IS NOT NULL
    GROUP BY I.id,C.Code, I.nom, I.Code
    ORDER BY C.Code;


SELECT Service.nom, COUNT(*) AS nombre
FROM ClientDetails
JOIN Service ON ClientDetails.idservice = Service.id
GROUP BY Service.nom;

SELECT EXTRACT(MONTH FROM ClientDetails.inserted) AS mois,EXTRACT(YEAR FROM ClientDetails.inserted) AS annee,idservice, COUNT(*) AS nombre 
FROM ClientDetails GROUP BY mois,annee,idservice ORDER BY  annee asc, mois asc;



--TODO: SITE WEB 
CREATE TABLE Actualite (
  id SERIAL PRIMARY Key,
  image64 text,
  types integer NOT NULL,
  inserted timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE SalonSW(
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    localisation text NOT NULL
);

INSERT INTO SalonSW (nom, localisation) VALUES ('Analakely', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.549528139245!2d47.52252637513196!3d-18.907055307271264!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f07fe85316aa19%3A0x593520d87df5e71!2sStephaina%20beauty%20Analakely!5e0!3m2!1sfr!2smg!4v1697573870241!5m2!1sfr!2smg');
INSERT INTO SalonSW (nom, localisation) VALUES ('Ivandry', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3775.3259590875136!2d47.51612217513091!3d-18.872615306255017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f081cad554e4a7%3A0x718d19f91a80ea59!2sStephaina%20beauty%20Alarobia!5e0!3m2!1sfr!2smg!4v1697573085766!5m2!1sfr!2smg');
INSERT INTO SalonSW (nom, localisation) VALUES ('Ankadifotsy', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.8299693576496!2d47.520182675131444!3d-18.894622806904216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f08138a1607173%3A0x5d05dd2166b5da81!2sStephaina%20Beauty%20Ankadifotsy!5e0!3m2!1sfr!2smg!4v1697574051904!5m2!1sfr!2smg');
INSERT INTO SalonSW (nom, localisation) VALUES ('Tamatave', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3791.1609554789056!2d49.41143857510988!3d-18.156497885541697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f501e5fca08673%3A0x8d9ff2e71557a437!2sStephaina%20beauty%20Tamatave!5e0!3m2!1sfr!2smg!4v1697574131645!5m2!1sfr!2smg');


CREATE TABLE Contact (
  id SERIAL PRIMARY Key,
  idSalon integer REFERENCES SalonSW(id) NOT NULL,
  contact VARCHAR(50) NOT NULL
);

create table ServiceSW (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    image64 text NOT NULL,
    description VARCHAR(150)
);

create table ServiceCategorie(
    id Serial PRIMARY KEY,
    idService int not null references ServiceSW(id),
    nom varchar(100),
    prix decimal(10,2),
    description varchar(150)
);


create table ServiceSousCategorie(
    id Serial PRIMARY KEY,
    idServiceCategorie int not null references ServiceCategorie(id),
    nom varchar(100),
    prix decimal(10,2)
);

INSERT INTO ServiceCategorie(idService,nom,prix,description) values
    (1,'DEPOSE',6000,''),
    (1,'NAIL ART SIMPLE',2000,''),
    (1,'NAIL ART COMPLEXE',3000,''),
    (1,'EFFET MAT',3000,''),
    (1,'NAIL ART TRES COMPLEXE',6000,''),
    (1,'POSE VERNIS CLASSIQUE',6000,''),
    (1,'MANUCURE COMPLETE',12000,'nettoyage + gommage + modelage + pose vernis simple'),
    (1,'POSE VERNIS CLASSIQUE KIKO',12000,''),
    (1,'FAUX ONGLES',15000,''),
    (1,'POSE VERNIS SEMI-PERMANENT',18000,''),
    (1,'POSE VERNIS EFFET MIRROIR',24000,''),
    (1,'SOIN PARRAFINE MAINS',25000, 'nettoyage + gommage + bain paraffine +modelage'),
    (1,'GAINAGE',30000,'Sur les ongles naturels'),
    (1,'PEDICURE COMPLETE',25000,'nettoyage + gommage + modelage + pose vernis simple'),
    (1,'EXTENSION ONGLES GEL UV',36000,'faux ongles + gel'),
    (1,'SOIN PARRAFINE PIEDS',35000,'nettoyage + gommage + bain de paraffine + modelage'),
    (1,'POSE VERNIS SEMI-PERMANENT INDIGO',50000,''),
    (1,'POSE AMERICAINE',60000,'Capsule sans colle + gel'),
    (1,'RESINE AVEC CAPSULE',70000,''),
    (1,'RESINE CHABLON',70000,'Sans capsule'),
    (2,'COCOONING',84000,'vapozone + retrait points noirs + epilation sourcils et duvet + gommage + masque + modelage visage'),
    (2,'SOTHYS SIMPLE',300000,'vapozone + retrait points noirs + epilation sourcils et duvet + gommage + masque + modelage visage'),
    (2,'SOTHYS SOIN PURETE',360000,''),
    (2,'SOTHYS SOIN DETOX',360000,''),
    (3,'SOURCILS AU FIL / PINCE',6000,''),
    (3,'DUVET AU FIL / PINCE',6000,''),
    (3,'SOURCILS A LA CIRE',6000,''),
    (3,'DUVET A LA CIRE',6000,''),
    (3,'AISSELLES',12000,''),
    (3,'DEMI-JAMBES',30000,''),
    (3,'DOS',20000,''),
    (3,'BRAS',25000,''),
    (3,'VISAGE',20000,''),
    (3,'TORSE / VENTRE',30000,''),
    (3,'MAILLOT FEMME ',36000,''),
    (3,'SOIN MAILLOT CLASSIQUE',60000,''),
    (3,'JAMBES ENTIERES',40000,''),
    (3,'MAILLOT HOMME',50000,''),
    (3,'CORPS ENTIERS',175000,'visage, sourcils, duvet, aisselles, dos, torse,jambes entieres, maillot, bras'),
    (4,'Brushing CHEVEUX FINS',0,''),
    (4,'Brushing CHEVEUX EPAIS',0,''),
    (4,'LISSAGE BRESILIEN CHEVEUX FINS',0,''),
    (4,'LISSAGE BRESILIEN CHEVEUX EPAIS',0,''),
    (5,'VOLUME RUSSE',50000,''),
    (5,'EFFET MASCARA',35000,''),
    (5,'YEUX DE BICHE',40000,''),
    (5,'EFFET NATUREL',30000,''),
    (5,'REHAUSSEMENT CILS',70000,''),
    (5,'DEPOSE CILS',10000,''),
    (5,'COULEUR',10000,'Couleurs: rose, bleu, jaune fluo, vert fluo'),
    (6,'MICROBLADING',350000,''),
    (6,'MICROSHADING',350000,''),
    (6,'MICROBLADING+MICROSHADING',400000,''),
    (6,'BROWLIFT',70000,'Couleurs: marron, marron clair'),
    (7,'FARMAVITA Meche',0,''),
    (7,'FARMAVITA Patinage / tete entiere',0,''),
    (7,'MAJIREL',0,''),
    (7,'Main d oeuvre (sans brushing)',90000,''),
    (8,'droite, frange',10000,''),
    (8,'degrade',15000,''),
    (8,'style',15000,''),
    (8,'Traçage barbe',15000,''),
    (9,'MASSAGE FACIALE (15MIN)',20000,''),
    (9,'MASSAGE FACIAL + PIERRE CHAUDE (30MIN)',35000,''),
    (9,'FOOT MASSAGE (15MIN)',18000,''),
    (9,'MASSAGE DOS + PIERRE CHAUDE (30MIN)',35000,''),
    (9,'MASSAGE VENTRE + PIERRE CHAUDE (30MIN)',35000,''),
    (9,'GOMMAGE CORPS',50000,''),
    (9,'MASSAGE RELAXANT (1H)',60000,'1H'),
    (9,'MASSAGE TONIFIANT (1H)',60000,'1H'),
    (9,'MASSAGE CORP HAMMAM (30 MIN)',70000,'30 min'),
    (9,'MASSAGE PIERRE CHAUDE (1H)',80000,'1H'),
    (9,'MASSAGE TURQUE',85000,'SAVON NOIR + GOMMAGE (45 MIN)'),
    (9,'MASSAGE A LA BOUGIE',100000,'1H'),
    (9,'MASSAGE AMINCISSANT',500000,'20 seances de 45 min');

INSERT INTO ServiceSousCategorie(idServiceCategorie,nom,prix) values
    (40,'courts (coupe garçon)',15000),
    (40,'mi-long',20000),
    (40,'long',30000),
    (40,'tres long',40000),
    (40,'tres tres long',50000),
    (41,'courts (coupe garçon)',25000),
    (41,'mi-long',30000),
    (41,'long',40000),
    (41,'tres long',50000),
    (41,'tres tres long',60000),
    (42,'courts (coupe garçon)',120000),
    (42,'courts (coupe carre)',240000),
    (42,'mi-long',340000),
    (42,'long',440000),
    (42,'tres long',540000),
    (42,'tres tres long',640000),
    (43,'courts (coupe garçon)',190000),
    (43,'courts (coupe carre)',300000),
    (43,'mi-long',420000),
    (43,'long',520000),
    (43,'tres long',620000),
    (43,'tres tres long',720000),
    (55,'courts (coupe garçon)',100000),
    (55,'courts (coupe carre)',120000),
    (55,'mi-long',195000),
    (55,'long',200000),
    (55,'tres long',210000),
    (55,'tres tres long',220000),
    (56,'repousse',85000),
    (56,'coloration des cheveux blancs',95000),
    (56,'courts (coupe garçon)',170000),
    (56,'courts (coupe carre)',190000),
    (56,'mi-long',210000),
    (56,'long',350000),
    (56,'tres long',460000),
    (56,'tres tres long',560000),
    (57,'repousse',120000),
    (57,'coloration des cheveux blancs',180000),
    (57,'courts (coupe garçon)',200000),
    (57,'courts (coupe carre)',300000),
    (57,'mi-long',400000),
    (57,'long',500000),
    (57,'tres long',600000),
    (57,'tres tres long',700000);


SELECT * FROM employe 
JOIN EmployeService ON EmployeService.idEmploye = employe.id
JOIN Service ON Service.id = EmployeService.idService
where service.idtypes = 1;