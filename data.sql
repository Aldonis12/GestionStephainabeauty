INSERT INTO Authentification (email, mdp) VALUES ('admin', 'admin1234');

INSERT INTO Salon (nom, adresse, latitude, longitude) VALUES ('analakely', 'La potiniere, Av. de L independance, Antananarivo', 47.525102535415506, -18.90522944159726);
INSERT INTO Salon (nom, adresse, latitude, longitude) VALUES ('ankadifotsy', 'Ankadifotsy Antananarivo, 101',47.52286826350029, -18.892805762084265);
INSERT INTO Salon (nom, adresse, latitude, longitude) VALUES ('alarobia', 'Immeuble RIA II I 2A Morarano Alarobia Antananarivo, 101', 47.51921349304137, -18.87127628438339);
INSERT INTO Salon (nom, adresse, latitude, longitude) VALUES ('tamatave', 'RCV7+9JC, 501 Rue Des Hovas, Toamasina',49.413777966038865,-18.156166576886054);

INSERT INTO Types (nom) VALUES ('Interne');
INSERT INTO Types (nom) VALUES ('Externe');

INSERT INTO Service (nom, idtypes) VALUES
    ('Caissier', 2),
    ('Commercial', 1),
    ('Coiffeur', 1),
    ('Coloriste', 1),
    ('Estheticien', 1),
    ('Onglerie', 1),
    ('POLYVALENT', 1),
    ('Masseuse', 1),
    ('Tatooeur', 1),
    ('Prothesite ongulaire', 1),
    ('Maquilleur', 1),
    ('Femme de menage', 2),
    ('Magasinier', 2),
    ('Responsable salon', 2),
    ('Accueil', 2),
    ('Gardien', 2),
    ('Formateur', 2),
    ('Assistante de direction', 2),
    ('RH - Assistante DG', 2),
    ('Developpeur', 2),
    ('Graphiste Designer', 2),
    ('Coursier', 2),
    ('Employe Polivalent', 2),
    ('Securite', 2),
    ('Comptable', 2),
    ('CDG', 2),
    ('ADM', 2),
    ('Marketing', 2);

INSERT INTO Service(nom, idtypes,issalon) VALUES 
('Pose vernis simple', 1, 1),
('Pose vernis permanent', 1, 1),
('Pose vernis  Miroir', 1, 1),
('Massage facial', 1, 1),
('Manucure', 1, 1),
('Pedicure', 1, 1),
('Faux ongles', 1, 1),
('Depose', 1, 1),
('Extension Gel UV', 1, 1),
('Extension cils', 1, 1),
('Epilation sourcils, duvet', 1, 1),
('Epilation (JE - DJ)', 1, 1),
('Epilation Aisselle', 1, 1),
('Epilation Maillot', 1, 1),
('Brushing', 1, 1),
('Coupe (H-F-E)', 1, 1),
('Steampod', 1, 1),
('Coloration', 1, 1),
('Soins de visage', 1, 1),
('Maquillage', 1, 1),
('Nails Art', 1, 1),
('Foot massage', 1, 1),
('Resine', 1, 1),
('Gainage', 1, 1),
('Tatoo', 1, 1);


INSERT INTO Genre (nom) VALUES ('Homme');
INSERT INTO Genre (nom) VALUES ('Femme');

INSERT INTO EmployeService (idemploye, idservice, idsalon) VALUES
    (1, 1, 1),
    (2, 2, 2),
    (3, 3, 3),
    (4, 4, 1),
    (5, 5, 2);

INSERT INTO Client (nom, prenom, date_naissance, idgenre, adresse, numero, email, profession, Charge) VALUES
    ('Durand', 'Alice', '1988-09-25', 2, '123 Rue de la Beaute', '789-123-456', 'alice.durand@email.com', 'Avocate', 1),
    ('Leroux', 'Thomas', '1995-04-12', 1, '456 Avenue Belle Forme', '456-789-123', 'thomas.leroux@email.com', 'Ingenieur', 2),
    ('Martin', 'Sophie', '1990-11-08', 2, '789 Boulevard eclatant', '123-456-789', 'sophie.martin@email.com', 'Medecin', 3),
    ('Dupont', 'Pierre', '1993-06-20', 1, '1010 Rue de la Serenite', '789-456-123', 'pierre.dupont@email.com', 'Professeur', 4),
    ('Dubois', 'Laura', '1987-03-05', 2, '2222 Avenue Relaxation', '987-654-321', 'laura.dubois@email.com', 'Styliste', 5);

INSERT INTO ClientDetails (idclient, idsalon, idservice, idemploye) VALUES
    (1, 1, 1, 1),
    (2, 2, 2, 2),
    (3, 3, 3, 3),
    (4, 1, 4, 4),
    (5, 2, 5, 5);

INSERT INTO Question (Question) VALUES 
    ('Comment évaluez-vous la qualité de service au salon ?'),
    ('Le personnel du salon a-t-il répondu à vos besoins et à vos attentes ?'),
    ('Comment trouvez-vous l ambiance et le confort du salon ?'),
    ('Pensez-vous que les tarifs du salon sont raisonnables par rapport à la qualité des services ?');

INSERT INTO Reponse (idquest, valeur, reponse)
VALUES (1,1,'Bonne'),
       (1,2,'Moyenne'),
       (1,3,'Médiocre'),
       (2,1,'Oui, totalement'),
       (2,2,'Oui, partiellement'),
       (2,3,'Non, pas du tout'),
       (3,1,'Bien'),
       (3,2,'Pas trop à l aise'),
       (3,3,'Pas bien du tout'),
       (4,1,'Raisonnables'),
       (4,2,'Neutres'),
       (4,3,'Un peu eleves');

INSERT INTO ReponseClient (idclient, idquestion, reponse, inserted) VALUES
    (1, 1, 1, '2023-10-01'),
    (2, 1, 2, '2023-09-15'),
    (3, 1, 3, '2023-08-20'),
    (1, 2, 1, '2023-10-05'),
    (2, 2, 2, '2023-09-18'),
    (3, 2, 3, '2023-08-25'),
    (1, 3, 1, '2023-10-10'),
    (2, 3, 2, '2023-09-22'),
    (3, 3, 3, '2023-08-30'),
    (1, 4, 1, '2023-10-12'),
    (2, 4, 2, '2023-09-25'),
    (3, 4, 3, '2023-08-10');

insert into Influenceur (nom, prenom, date_naissance, adresse, idgenre, numero, email) values ('Denise', 'Alice', '1988-09-25', 'Toamasina', 2, '789-123-456', 'alice.durand@email.com');
insert into Influenceur (nom, prenom, date_naissance, adresse, idgenre, numero, email) values ('Fy', 'Kely', '2006-10-25', 'Tana', 2, '21339-123-456', 'fy.durand@email.com');
insert into Influenceur (nom, prenom, date_naissance, adresse, idgenre, numero, email) values ('Stephany', 'Be', '1997-09-25', 'Tulear', 2, '789-123-456', 'stephany.durand@email.com');

insert into ReseauxSociaux (nom) values ('Facebook'),('Instagram'),('Tiktok');

insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (1, 1, 8500);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (1, 2, 5000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (1, 3, 1900);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (2, 1, 5000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (2, 2, 6000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (2, 3, 7000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (3, 1, 2000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (3, 2, 3000);
insert into InfluenceurReseauxSociaux (idinfluenceur, idreseauxsociaux, followers) values (3, 3, 4000);

insert into InfluenceurDetails (idinfluenceur, idreseauxsociaux, lien, likes, comments, inserted) values (1, 1, 'https://www.facebook.com/johndoe/post2', 600, 40, NOW());
insert into InfluenceurDetails (idinfluenceur, idreseauxsociaux, lien, likes, comments, inserted) values (1, 1, 'https://www.facebook.com/johndoe/post2', 300, 50, NOW());
insert into InfluenceurDetails (idinfluenceur, idreseauxsociaux, lien, likes, comments, inserted) values (1, 2, 'https://www.instagram.com/johndoe/post2', 300, 40, NOW());
insert into InfluenceurDetails (idinfluenceur, idreseauxsociaux, lien, likes, comments, inserted) values (1, 3, 'https://www.tiktok.com/johndoe/post2', 300, 40, NOW());
insert into InfluenceurDetails (idinfluenceur, idreseauxsociaux, lien, likes, comments, inserted) values (2, 1, 'https://www.facebook.com/sarahsmith/post2', 250, 20, NOW());



/*create table CommentairePublic (
    id Serial PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    commentaire VARCHAR(50) NOT NULL,
    inserted timestamp default CURRENT_TIMESTAMP
); */


--PageAddEmployeService -- AddController
SELECT s.id, s.nom
FROM Service s
WHERE s.id NOT IN (
    SELECT idservice
    FROM EmployeService
    WHERE idemploye = :idemploye
);

--StatistiqueSalonClient -- StatistiqueController
SELECT EXTRACT(MONTH FROM inserted) AS mois, COUNT(*) AS nombre_de_clients FROM ClientDetails WHERE EXTRACT(year FROM inserted) = ? AND idsalon = ? GROUP BY mois ORDER BY mois
SELECT EXTRACT(MONTH FROM inserted) AS mois, SUM(CASE WHEN reponse = 1 THEN 1 ELSE 0 END) AS reponse_1, SUM(CASE WHEN reponse = 2 THEN 1 ELSE 0 END) AS reponse_2, SUM(CASE WHEN reponse = 3 THEN 1 ELSE 0 END) AS reponse_3 FROM reponseclient WHERE EXTRACT(year FROM inserted) = ? AND idsalon = ? GROUP BY mois ORDER BY mois


--StatistiqueDashboard -- StatistiqueController
SELECT nom, nombre FROM v_salonsemaine WHERE idsalon={$salonId} AND EXTRACT(week FROM current_date) = semaine AND EXTRACT(year FROM current_date) = annee ORDER BY nombre DESC LIMIT 3

SELECT q.id, q.Question AS "Question",
       r.reponse AS "Reponse"
FROM Question q
JOIN Reponse r ON q.id = r.idquest
ORDER BY q.id, r.valeur;


select * from v_salonsemaine where idsalon=1 AND EXTRACT(week from current_date)=semaine and EXTRACT(year from current_date)=annee ORDER BY nombre_de_services DESC limit 3;

SELECT COUNT(*) AS nombre
FROM EmployeService es
JOIN Employe e ON es.idemploye = e.id
WHERE es.idsalon = 2
  AND e.isCanceled = 0;


select r.nom,followers from influenceurreseauxsociaux 
JOIN ReseauxSociaux r on influenceurreseauxsociaux.idreseauxsociaux=r.id
where idinfluenceur=1 order by idreseauxsociaux;

select r.nom,idreseauxsociaux,followers from influenceurreseauxsociaux 
JOIN ReseauxSociaux r on influenceurreseauxsociaux.idreseauxsociaux=r.id
where idinfluenceur=1 order by idreseauxsociaux;

SELECT salon.nom , COUNT(*) AS client
FROM clientdetails 
JOIN salon ON clientdetails.idsalon = salon.id
WHERE DATE(inserted) = CURRENT_DATE
GROUP BY salon.nom;