USE sae;

INSERT INTO ROLE (nom_role) VALUES
('Présidence de l''université'),
('Directeur de composante'),
('Chef de département'),
('Responsable de service'),
('Administrateur'),
('Bureau des étudiants'),
('Enseignant'),
('Etudiant');

INSERT INTO ODD (titre_odd, desc_odd, image_odd) VALUES
('ODD 4', 'Éducation de qualité', 'image_odd_4.png'),
('ODD 9', 'Industrie, innovation et infrastructure', 'image_odd_9.png'),
('ODD 11', 'Villes et communautés durables', 'image_odd_11.png'),
('ODD 12', 'Consommation et production responsables', 'image_odd_12.png'),
('ODD 13', 'Mesures relatives à la lutte contre les changements climatiques', 'image_odd_13.png'),
('ODD 17', 'Partenariats pour la réalisation des objectifs', 'image_odd_17.png');

INSERT INTO CATEGORIE (titre_categorie, desc_categorie, id_odd) VALUES
('Papier/Carton', 'Déchets de papier et carton pour recyclage', 1),
('Plastique PET', 'Bouteilles et contenants en plastique PET', 4),
('Verre', 'Bouteilles et pots en verre', 4),
('Piles/Batteries', 'Petites piles usagées', 2),
('Matériel Électronique', 'Ordinateurs, écrans, câbles (DEEE)', 2),
('Compost', 'Déchets organiques de restauration', 4),
('Métaux', 'Petits objets métalliques (canettes)', 4),
('Bois', 'Déchets de bois non traités', 5),
('Déchets chimiques','Déchets potentiellement toxique qui provient des départements scientifiques', 2),
('Caoutchouc','Pneus, butoir de porte', 5);

INSERT INTO INVENTAIRE (nom_inventaire) VALUES
('Inventaire Dépt Droit Public'),
('Inventaire Dépt Anglais'),
('Inventaire Dépt Espagnol'),
('Inventaire Dépt Allemand'),
('Inventaire Dépt Histoire'),
('Inventaire Dépt Informatique'),
('Inventaire Dépt Physique'),
('Inventaire Dépt Génie Industriel'),
('Inventaire Dépt GEA Laval'),
('Inventaire Dépt Acoustique'),
('Inventaire Service Sec Droit'),
('Inventaire Service Mtnc Droit'),
('Inventaire Service Sec Lettres'),
('Inventaire Service Mtnc Lettres'),
('Inventaire Service Sec Sciences'),
('Inventaire Service Mtnc Sciences'),
('Inventaire Service Sec IUT Le Mans'),
('Inventaire Service Mtnc IUT Le Mans'),
('Inventaire Service Sec IUT Laval'),
('Inventaire Service Mtnc IUT Laval');

INSERT INTO COMPOSANTE (nom_composante, coords_composante, ville) VALUES
('Faculté de Droit, Sciences économiques & de Gestion', '48.016, 0.160', 'Le Mans'),
('Faculté des Lettres, Langues & Sciences humaines', '48.018, 0.162', 'Le Mans'),
('Faculté des Sciences et Techniques', '48.019, 0.165', 'Le Mans'),
('IUT du Mans', '48.020, 0.170', 'Le Mans'),
('IUT de Laval', '48.085, -0.762', 'Laval'),
('ENSIM', '48.021, 0.164', 'Le Mans');

INSERT INTO DEPARTEMENT (nom_departement, coords_departement, id_composante, id_inventaire) VALUES
('Département du Droit Public', '48.016, 0.160', 1, 1),
('Département d''Anglais', '48.018, 0.162', 2, 2),
('Département d''Espagnol', '48.019, 0.165', 2, 3),
('Département d''Allemand', '48.010, 0.162', 2, 4),
('Département d''histoire', '48.018, 0.162', 2, 5),
('Département d''Informatique', '48.019, 0.165', 3, 6),
('Département d''Physique', '48.019, 0.165', 3, 7),
('Département de Génie Industriel', '48.020, 0.170', 4, 8),
('GEA', '48.085, -0.762', 5, 9),
('Acoustique', '48.021, 0.164', 6, 10);

INSERT INTO UTILISATEUR (identifiant, nom_utilisateur, prenom_utilisateur, mail_univ, mdp_univ, id_role) VALUES
('i2400001', 'Bertrand', 'Marc', 'marc.bertrand@univ-lemans.fr', 'fhd586scv', 1),
('i2400002', 'Gaëtan', 'Vincent', 'vincent.gaetan@univ-lemans.fr', 'yun913daw', 2),
('i2400003', 'Sullivan', 'Violette', 'violette.sullivan@univ-lemans.fr', 'zfb568xvd', 3),
('i2400004', 'Élodie', 'Célie', 'celie.elodie@univ-lemans.fr', 'pml963wqa', 4),
('i2400005', 'Jocelin', 'Alex', 'alex.jocelin@univ-lemans.fr', 'yhn123sdf', 5),
('i2400006', 'Marcelin', 'Chloé', 'chloe.marcelin.etu@univ-lemans.fr', 'abc123def', 6),
('i2400007', 'Christian', 'Thomas', 'thomas.christian.etu@univ-lemans.fr', 'bla555bla', 7),
('i2400008', 'Léon', 'Julie', 'julie.leon.etu@univ-lemans.fr', 'iop753aze', 8),
('i2400009', 'Bosco', 'Lucas', 'lucas.bosco.etu@univ-lemans.fr', 'nzi654cqq', 8),
('i2400010', 'Maël', 'Éva', 'eva.mael.etu@univ-lemans.fr', 'xls855daz', 8);

INSERT INTO SERVICE (nom_service, coords_service, id_inventaire, id_composante) VALUES
('Secrétariat de la faculté de droit', '48.017, 0.161', 11, 1),
('Maintenance de la faculté de droit', '48.020, 0.170', 12, 1),
('Secrétariat de la faculté des lettres', '48.018, 0.162', 13, 2),
('Maintenance de la faculté des lettres', '48.021, 0.164', 14, 2),
('Secrétariat de la faculté des sciences', '48.085, -0.762', 15, 3),
('Maintenance de la faculté des sciences', '48.020, 0.170', 16, 3),
('Secrétariat de l''IUT du Mans', '48.018, 0.162', 17, 4),
('Maintenance de l''IUT du Mans', '48.021, 0.164', 18, 4),
('Secrétariat de l''IUT de Laval', '48.018, 0.162', 19, 5),
('Maintenance de l''IUT de Laval', '48.021, 0.164', 20, 5);

INSERT INTO STATISTIQUE (titre_statistique, nb_recyclages, id_categorie) VALUES
('Tonnage de Papier - Octobre', 120, 1),
('Volume de Plastique - Septembre', 45, 2),
('Collecte de Verre - Semaine 40', 80, 3),
('Piles collectées - Année', 2500, 4),
('DEEE collectés - Semestre', 50, 5),
('Volume Compost - Octobre', 150, 6),
('Collecte de métaux - Septembre', 110, 7),
('Collete de bois - Octobre', 60, 8),
('Produits chimiques collecté (en L) - Novembre', 9, 9),
('Caoutchouc collecté - Octobre', 60, 10);

INSERT INTO COMMUNIQUE (id_communique, titre_communique, contenu, date_publication, cat_communique, id_utilisateur) VALUES
(1, 'Ouverture de ÉcoGestUM', 'Bonjour à tous,<br><br>Nous sommes ravis d\'annoncer l\'ouverture officielle de notre plateforme de gestion environnementale, ÉcoGestUM ! Pour assurer le succès de cette initiative, nous vous prions de prendre connaissance des règles d\'utilisation et de les respecter scrupuleusement. Votre engagement est clé pour un campus plus vert.<br><br>Cordialement,<br>L\'équipe ÉcoGestUM', '2025-11-17 11:32:44', 'Information', 1),
(2, 'Succès de la collecte DEEE', 'Bonjour,<br><br>Un immense merci à tous les participants ! Notre récente collecte de Déchets d\'Équipements Électriques et Électroniques (DEEE) a été un franc succès, permettant de récupérer 50 kg de matériel. Cela représente un pas important dans la réduction de notre empreinte numérique et le recyclage responsable. Continuons sur cette lancée !<br><br>Cordialement,<br>Le service environnement', '2025-11-17 11:32:44', 'Statistique', 1),
(3, 'Rappel : événements à venir', 'Bonjour,<br><br>Alerte Agenda ! Nous vous rappelons l’imminence de notre prochain événement : la Journée du Réemploi. C\'est l\'occasion parfaite pour donner une seconde vie à vos objets et échanger des astuces zéro déchet. Consultez le programme détaillé sur notre site. Venez nombreux !<br><br>Cordialement,<br>L\'équipe événementielle', '2025-11-17 11:32:44', 'Événement', 1),
(4, 'Changement de point de collecte', 'Avis important,<br><br>Avis de modification : Le point de collecte pour le Verre a été déplacé temporairement (ou définitivement) pour améliorer l\'accessibilité et la sécurité. Le nouveau point se situe désormais au Rez-de-Chaussée du Bâtiment A. Merci de suivre la nouvelle signalétique.<br><br>Cordialement,<br>La Direction des services techniques', '2025-11-17 11:32:44', 'Information', 1),
(5, 'Nouvelles consignes de tri', 'Chers usagers,<br><br>Attention, nouvelles directives de tri effectives dès ce lundi ! Pour optimiser notre compostage, tous les gobelets en carton (bioplastique) utilisés dans nos cafétérias doivent être jetés dans les bacs de compostage prévus à cet effet. Un affichage détaillé sera mis en place.<br><br>Cordialement,<br>Le service déchets', '2025-11-17 11:32:44', 'Information', 1),
(6, 'Succès de la collecte meuble', 'Bonjour à tous,<br><br>Bravo à la communauté ! La dernière collecte de meubles usagés a permis de récupérer 22 pièces. Ces meubles seront reconditionnés ou donnés à des associations. C\'est un excellent score qui témoigne de votre engagement contre le gaspillage de ressources.<br><br>Cordialement,<br>L\'équipe ÉcoGestUM', '2025-11-17 11:32:44', 'Information', 1),
(7, 'Rappel : événements à venir', 'Bonjour,<br><br>Ne manquez pas la Journée Verte ! C\'est ce Vendredi 4 octobre. Au programme : ateliers, stands d\'information sur le tri, et un pot convivial pour clôturer la journée. L\'événement se tiendra dans la cour principale. Venez échanger et apprendre !<br><br>Cordialement,<br>Le comité d\'organisation', '2025-11-17 11:32:44', 'Événement', 1),
(8, 'Heures de maintenance', 'Bonjour,<br><br>Information importante : Notre site web et l\'application mobile feront l\'objet d\'une maintenance technique. L\'accès sera interrompu demain après-midi, de 13h30 à 14h00. Nous nous excusons pour le désagrément et vous remercions de votre compréhension.<br><br>Cordialement,<br>L\'équipe technique', '2025-11-17 11:32:44', 'Information', 5),
(9, 'Rappel : événements à venir', 'Bonjour,<br><br>Encore un rappel ! Vu le succès de la dernière édition, nous réorganisons la Journée du Ré-Réemploi la semaine prochaine. Préparez vos objets à troquer ou à donner ! Plus d\'informations sur les horaires et le lieu suivront très prochainement.<br><br>Cordialement,<br>Le service événementiel', '2025-11-17 11:32:44', 'Information', 1),
(10, 'Changement de point de collecte', 'Avis important,<br><br>Nouvelle localisation pour les déchets en Verre : Afin de mieux desservir la zone Est du campus, le point de collecte Verre a été déplacé au Rez-de-Chaussée du Bâtiment B. Veuillez noter ce changement pour vos prochains dépôts. Merci de votre coopération !<br><br>Cordialement,<br>La Direction des services techniques', '2025-11-17 11:32:44', 'Information', 1);

INSERT INTO EVENEMENT (id_evenement, titre_evenement, desc_evenement, date_debut, date_fin, id_composante) VALUES
(1, 'Journée du Réemploi (Droit)', 'C\'est la journée du Réemploi !', '2025-10-23 08:00:00', '2025-10-23 18:00:00', 1),
(2, 'Journée du Ré-Réemploi (Droit)', 'C\'est la journée du Ré-Réemploi !', '2025-11-10 10:00:00', '2025-11-10 11:30:00', 1),
(3, 'Journée du Réemploi (Lettres)', 'C\'est la journée du Réemploi !', '2025-10-23 08:00:00', '2025-10-23 18:00:00', 2),
(4, 'Journée du Ré-Réemploi (Lettres)', 'C\'est la journée du Réemploi !', '2025-11-10 10:00:00', '2025-11-10 11:30:00', 2),
(5, 'Octobre Rose', 'C\'est la journée Rose.', '2025-12-01 08:00:00', '2025-12-01 12:00:00', 3),
(6, 'Journée d\'information sur le recyclage', 'C\'est une journée info de recyclage', '2025-11-05 08:00:00', '2025-11-05 09:30:00', 3),
(7, 'Octobre Rose', 'C\'est la journée Rose.', '2025-12-01 08:00:00', '2025-12-01 12:00:00', 5),
(8, 'Week-end Vert', 'Le week-end vert', '2025-10-25 08:00:00', '2025-10-26 23:59:59', 4),
(9, 'Octobre Rose', 'C\'est la journée Rose.', '2025-12-01 08:00:00', '2025-12-01 12:00:00', 4),
(10, 'Journée du Réemploi (ENSIM)', 'C\'est la journée du Réemploi !', '2025-10-23 08:00:00', '2025-10-23 18:00:00', 6);

INSERT INTO OBJET (nom_objet, desc_objet, quantity, date_ajout, statut, id_categorie) VALUES
('Bouteille Plastique', 'Bouteille d’eau 1.5L vide', 1, '2025-10-20', 'Disponible', 2),
('Journal Le Monde', 'Ancien numéro du quotidien', 1, '2025-10-21', 'Disponible', 1),
('Batterie AA', 'Pile usagée', 1, '2025-10-22', 'Disponible', 4),
('Écran PC 24"', 'Vieux écran de bureau, HS', 1, '2025-10-22', 'Indisponible', 5),
('Canette de Soda', 'Canette vide en aluminium', 1, '2025-10-20', 'Disponible', 7),
('Boîte à pizza', 'Carton de pizza, peu sale', 1, '2025-10-21', 'Disponible', 1),
('Bloc-notes', 'Cahier brouillon', 1, '2025-10-22', 'Disponible', 1),
('Pot de Yaourt en Verre', 'Vide', 1, '2025-10-22', 'Disponible', 3),
('Clavier USB', 'Clavier inutilisé', 1, '2025-10-22', 'Indisponible', 5),
('Déchets de repas', 'Épluchures de fruits, restes', 1, '2025-10-22', 'En élimination', 6);

INSERT INTO NOTIFICATION (titre_notification, date_envoi, id_emetteur, id_recepteur) VALUES
('Éva Maël veut emprunter l''objet "Bouteille Plastique".', '2025-10-20', 10, 3),
('Le départent Informatique veut collaborer sur l''objet "Bloc-notes"', '2025-09-18', 3, 2),
('Julie Léon veut emprunter l''objet "Boîte à pizza".', '2025-11-08', 8, 4),
('Éva Maël veut emprunter l''objet "Pot de Yaourt en Verre".', '2025-10-01', 10, 4),
('Rappel événement : Journée de Réemploi !', '2025-10-02', 1, 2),
('Le départent d''Anglais veut collaborer sur l''objet "Bloc-notes"', '2025-10-03', 3, 2),
('Le départent Informatique veut collaborer sur l''objet "Écran PC 24""', '2025-10-04', 3, 4),
('Chloé Marcelin veut emprunter l''objet "Batterie AA".', '2025-10-05', 6, 5),
('Rappel événement : Journée de Ré-réemploi !', '2025-10-09', 1, 2),
('Lucas Bosco veut emprunter l''objet "Journal Le Monde".', '2025-10-11', 9, 7);

INSERT INTO AGENCER (id_objet, id_inventaire) VALUES
(1, 2),
(2, 3),
(3, 8),
(4, 5),
(5, 6),
(6, 1),
(7, 4),
(8, 7),
(9, 10),
(10, 9);