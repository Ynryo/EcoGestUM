USE ecogestum;

INSERT INTO role (nom_role) VALUES
('Présidence de l''université'),
('Directeur de composante'),
('Chef de département'),
('Responsable de service'),
('Administrateur'),
('Bureau des étudiants'),
('Enseignant'),
('Etudiant');

INSERT INTO odd (num_odd, titre_odd, desc_odd, link_odd) VALUES
('ODD 4', 'Éducation de qualité', 'Le quatrième objectif vise à garantir l’accès à tous et toutes à une éducation équitable, gratuite et de qualité à travers toutes les étapes de la vie, en éliminant notamment les disparités entre les sexes et les revenus. Il met également l’accent sur l’acquisition de compétences fondamentales et de niveau supérieur pour vivre dans une société durable. L’ODD4 appelle aussi à la construction et à l’amélioration des infrastructures éducatives, à l’augmentation du nombre de bourses d’études supérieures octroyées aux pays en développement et du nombre d’enseignants qualifiés dans ces pays.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd4-veiller-a-ce-que-tous-puissent-suivre-une-education-de-qualite-dans-des'),
('ODD 9', 'Industrie, innovation et infrastructure', 'Le neuvième objectif promeut l’essor résilient et durable d’infrastructures, de l’industrialisation et de l’innovation. Ces secteurs doivent être un moteur pour le recul de la pauvreté et l’amélioration de la qualité de vie dans le monde, tout en ayant un impact mineur sur l’environnement.\n\nL’ODD9 appelle à favoriser un appui financier, technologique et technique des industries et à encourager l’innovation et la recherche scientifique. Pour atteindre cet objectif, il est nécessaire de renforcer la coopération internationale dans la recherche et le développement, tout en assurant le transfert de technologie vers les pays en développement.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd9-mettre-en-place-une-infrastructure-resiliente-promouvoir-une'),
('ODD 11', 'Villes et communautés durables', 'Le onzième objectif vise à réhabiliter et à planifier les villes, ou tout autre établissement humain, de manière à ce qu’elles puissent offrir à tous des opportunités d’emploi, un accès aux services de base, à l’énergie, au logement, au transport, espaces publics verts et autres, tout en améliorant l’utilisation des ressources et réduisant leurs impacts environnementaux.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd11-faire-en-sorte-que-les-villes-et-les-etablissements-humains-soient'),
('ODD 12', 'Consommation et production responsables', 'Le douzième objectif est un appel pour les producteurs, les consommateurs, les communautés et les gouvernements à réfléchir sur leurs habitudes et usages en termes de consommation, de production de déchets, à l’impact environnemental et social de l’ensemble de la chaîne de valeur de nos produits. Plus globalement, cet ODD réclame de comprendre les interconnexions entre les décisions personnelles et collectives, et de percevoir les impacts de nos comportements respectifs entre les pays et à l’échelle mondiale.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd12-etablir-des-modes-de-consommation-et-de-production-durables'),
('ODD 13', 'Mesures relatives à la lutte contre les changements climatiques', 'Le treizième objectif vise à renforcer la résilience et la capacité d’adaptation des pays face aux aléas et catastrophes climatiques avec un focus sur le renforcement des capacités des pays les moins avancés et des petits États insulaires en développement. Cette ambition se traduit à chaque échelle : via le renforcement de la coopération internationale au travers notamment de l’opérationnalisation du fonds vert ; dans l’élaboration des politiques et planifications nationales, via la sensibilisation des citoyens et la mise en place de systèmes d’alertes rapides.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd13-prendre-d-urgence-des-mesures-pour-lutter-contre-les-changements'),
('ODD 17', 'Partenariats pour la réalisation des objectifs', 'Le dix-septième et dernier objectif promeut des partenariats efficaces entre les gouvernements, le secteur privé et la société civile qui sont nécessaires pour la réalisation des ODD au niveau mondial, régional, national et local. Ces partenariats doivent être inclusifs, construits sur des principes et des valeurs communes, et plaçant au cœur de leur préoccupation les peuples et la planète.', 'https://www.agenda-2030.fr/17-objectifs-de-developpement-durable/article/odd17-partenariats-pour-la-realisation-des-objectifs');


INSERT INTO categorie (titre_categorie, desc_categorie, id_odd) VALUES
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

INSERT INTO inventaire (nom_inventaire) VALUES 
('Inventaire Informatique (Laval)'),
('Inventaire Génie Biologique'),
('Inventaire Métiers du Multimédia et de l''Internet'),
('Inventaire Techniques de Commercialisation'),
('Inventaire Chimie (IUT)'),
('Inventaire Génie Mécanique et Productique'),
('Inventaire Gestion des Entreprises et des Administrations'),
('Inventaire Mesures Physiques'),
('Inventaire Acoustique'),
('Inventaire Biologie'),
('Inventaire Chimie (Fac)'),
('Inventaire Géosciences'),
('Inventaire Informatique (Fac)'),
('Inventaire Mathématiques'),
('Inventaire Physique'),
('Inventaire STAPS'),
('Inventaire Anglais'),
('Inventaire Allemand'),
('Inventaire Espagnol'),
('Inventaire Lettres'),
('Inventaire Langues Étrangères Appliquées (LEA)'),
('Inventaire Géographie'),
('Inventaire Histoire'),
('Inventaire Didactique des Langues'),
('Inventaire Droit'),
('Inventaire Sciences Économiques'),
('Inventaire Sciences de Gestion'),
('Inventaire Vibrations, Acoustique, Capteurs'),
('Inventaire Informatique (ENSIM)');

INSERT INTO utilisateur (identifiant, nom_utilisateur, prenom_utilisateur, mail_univ, mdp_univ, id_role) VALUES 
('i2400001', 'Bertrand', 'Marc', 'marc.bertrand@univ-lemans.fr', 'fhd586scv', 1),
('i2400002', 'Gaëtan', 'Vincent', 'vincent.gaetan@univ-lemans.fr', 'yun913daw', 2),
('i2400003', 'Sullivan', 'Violette', 'violette.sullivan@univ-lemans.fr', 'zfb568xvd', 3),
('i2400004', 'Élodie', 'Célie', 'celie.elodie@univ-lemans.fr', 'pml963wqa', 4),
('i2400005', 'Jocelin', 'Alex', 'alex.jocelin@univ-lemans.fr', 'yhn123sdf', 5),
('i2400006', 'Marcelin', 'Chloé', 'chloe.marcelin.etu@univ-lemans.fr', 'abc123def', 6),
('i2400007', 'Christian', 'Thomas', 'thomas.christian.etu@univ-lemans.fr', 'bla555bla', 7),
('i2400008', 'Léon', 'Julie', 'julie.leon.etu@univ-lemans.fr', 'iop753aze', 8),
('i2400009', 'Bosco', 'Lucas', 'lucas.bosco.etu@univ-lemans.fr', 'nzi654cqq', 8),
('i2400010', 'Maël', 'Éva', 'eva.mael.etu@univ-lemans.fr', 'xls855daz', 8),
('i2400011', 'Roulin', 'Olivier', 'olivier.roulin@univ-lemans.fr', 'password123', 3), -- Info Laval
('i2400012', 'Faure-Ferlet', 'Axelle', 'axelle.faure-ferlet@univ-lemans.fr', 'password123', 3), -- TC Laval
('i2400013', 'Corbière', 'Pascal', 'pascal.corbiere@univ-lemans.fr', 'password123', 3), -- Bio Laval
('i2400014', 'Leduc', 'Cédric', 'cedric.leduc@univ-lemans.fr', 'password123', 3), -- MMI Laval
('i2400015', 'Gautier', 'François', 'francois.gautier@univ-lemans.fr', 'password123', 3), -- Acoustique
('i2400016', 'Pichelin', 'Murielle', 'murielle.pichelin@univ-lemans.fr', 'password123', 3), -- Biologie
('i2400017', 'Leriche', 'Philippe', 'philippe.leriche@univ-lemans.fr', 'password123', 3), -- Chimie
('i2400018', 'Reynaud', 'Pascal', 'pascal.reynaud@univ-lemans.fr', 'password123', 3), -- Géo/Phys
('i2400019', 'Guillais', 'Flavie', 'flavie.guillais@univ-lemans.fr', 'password123', 3), -- Math
('i2400020', 'Hollebecq', 'Sylvain', 'sylvain.hollebecq@univ-lemans.fr', 'password123', 3), -- STAPS
('i2400021', 'Palanque', 'Pascal', 'pascal.palanque@univ-lemans.fr', 'password123', 3); -- ENSIM


INSERT INTO composante (nom_composante, coords_composante, ville) VALUES
('Faculté de Droit, Sciences économiques & de Gestion', '48.016, 0.160', 'Le Mans'),
('Faculté des Lettres, Langues & Sciences humaines', '48.018, 0.162', 'Le Mans'),
('Faculté des Sciences et Techniques', '48.019, 0.165', 'Le Mans'),
('IUT du Mans', '48.020, 0.170', 'Le Mans'),
('IUT de Laval', '48.085, -0.762', 'Laval'),
('ENSIM', '48.021, 0.164', 'Le Mans');

INSERT INTO departement (nom_departement, id_composante, id_inventaire, id_utilisateur) VALUES 
('Informatique', 5, 1, 11),
('Génie Biologique', 5, 2, 13),
('Métiers du Multimédia et de l''Internet', 5, 3, 14),
('Techniques de Commercialisation', 5, 4, 12),
('Chimie', 4, 5, NULL),
('Génie Mécanique et Productique', 4, 6, NULL),
('Gestion des Entreprises et des Administrations', 4, 7, NULL),
('Mesures Physiques', 4, 8, NULL),
('Acoustique', 3, 9, 15),
('Biologie', 3, 10, 16),
('Chimie', 3, 11, 17),
('Géosciences', 3, 12, 18),
('Informatique', 3, 13, NULL),
('Mathématiques', 3, 14, 19),
('Physique', 3, 15, NULL),
('STAPS', 3, 16, 20),
('Anglais', 2, 17, NULL),
('Allemand', 2, 18, NULL),
('Espagnol', 2, 19, NULL),
('Lettres', 2, 20, NULL),
('Géographie', 2, 22, NULL),
('Histoire', 2, 23, NULL),
('Droit', 1, 25, NULL),
('Sciences Économiques', 1, 26, NULL),
('Sciences de Gestion', 1, 27, NULL),
('Vibrations, Acoustique, Capteurs', 6, 28, 21),
('Informatique', 6, 29, NULL);

INSERT INTO service (nom_service, id_inventaire, id_composante) VALUES
('Secrétariat de la faculté de droit', 11, 1),
('Maintenance de la faculté de droit', 12, 1),
('Secrétariat de la faculté des lettres', 13, 2),
('Maintenance de la faculté des lettres', 14, 2),
('Secrétariat de la faculté des sciences', 15, 3),
('Maintenance de la faculté des sciences', 16, 3),
('Secrétariat de l''IUT du Mans', 17, 4),
('Maintenance de l''IUT du Mans', 18, 4),
('Secrétariat de l''IUT de Laval', 19, 5),
('Maintenance de l''IUT de Laval', 20, 5);

INSERT INTO statistique (titre_statistique, nb_recyclages, id_categorie) VALUES
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

INSERT INTO communique (id_communique, titre_communique, contenu, date_publication, cat_communique, id_utilisateur) VALUES
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

INSERT INTO evenement (id_evenement, titre_evenement, desc_evenement, date_debut, date_fin, id_composante) VALUES
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

INSERT INTO objet (id_objet, nom_objet, desc_objet, color, etat, size, quantity, date_ajout, statut, id_categorie) VALUES
(1, 'Bouteille Plastique', 'Bouteille d’eau 1.5L vide', 'Transparent', 'Très bon', 'Taille unique', 1, '2025-10-20', 'disponible', 2),
(2, 'Journal Le Monde', 'Ancien numéro du quotidien', NULL, 'Très bon', 'Taille unique', 1, '2025-10-21', 'disponible', 1),
(3, 'Batterie AA', 'Pile usagée', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'disponible', 4),
(4, 'Écran PC 24\"', 'Vieux écran de bureau, HS', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'indisponible', 5),
(5, 'Canette de Soda', 'Canette vide en aluminium', NULL, 'Très bon', 'Taille unique', 1, '2025-10-20', 'disponible', 7),
(6, 'Boîte à pizza', 'Carton de pizza, peu sale', NULL, 'Très bon', 'Taille unique', 1, '2025-10-21', 'disponible', 1),
(7, 'Bloc-notes', 'Cahier brouillon', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'disponible', 1),
(8, 'Pot de Yaourt en Verre', 'Vide', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'disponible', 3),
(9, 'Clavier USB', 'Clavier inutilisé', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'indisponible', 5),
(10, 'Déchets de repas', 'Épluchures de fruits, restes', NULL, 'Très bon', 'Taille unique', 1, '2025-10-22', 'disponible', 6);

INSERT INTO notification (titre_notification, date_envoi, id_emetteur, id_recepteur) VALUES
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

INSERT INTO agencer (id_objet, id_inventaire) VALUES
(1, 3),
(2, 2),
(3, 8),
(4, 5),
(5, 6),
(6, 1),
(7, 4),
(8, 7),
(9, 10),
(10, 9);