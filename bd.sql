---------------------
-- TABLES CREATION --
---------------------

create table if not exists Categorie
(
    cid      int auto_increment
        primary key,
    intitule varchar(50) not null
);

create table if not exists Zone
(
    zid         int auto_increment
        primary key,
    nom         varchar(50)  not null,
    description varchar(150) not null
);

create table if not exists Emplacement
(
    eid  int auto_increment
        primary key,
    code varchar(50) not null,
    zid  int         not null,
    constraint code
        unique (code),
    constraint Emplacement_ibfk_1
        foreign key (zid) references Zone (zid)
);

create table if not exists Brocanteur
(
    bid                int auto_increment
        primary key,
    nom                varchar(50)          not null,
    prenom             varchar(50)          not null,
    courriel           varchar(150)         not null,
    mot_passe          varchar(255)         not null,
    photo              varchar(100)         null,
    description        varchar(2000)        not null,
    visible            tinyint(1) default 1 null,
    est_administrateur tinyint(1) default 0 null,
    eid                int                  null,
    a_paye             tinyint(1) default 0 not null,
    isDeleted          tinyint(1) default 0 null,
    constraint courriel
        unique (courriel),
    constraint eid
        unique (eid),
    constraint Brocanteur_ibfk_1
        foreign key (eid) references Emplacement (eid)
);

create index idx_zid
    on Emplacement (zid);

create table if not exists Objet
(
    oid         int auto_increment
        primary key,
    intitule    varchar(100)         not null,
    image       varchar(150)         null,
    description varchar(500)         not null,
    cid         int                  not null,
    bid         int                  not null,
    isDeleted   tinyint(1) default 0 null,
    constraint Objet_ibfk_1
        foreign key (cid) references Categorie (cid),
    constraint Objet_ibfk_2
        foreign key (bid) references Brocanteur (bid)
);

create index idx_bid
    on Objet (bid);

create index idx_cid
    on Objet (cid);

create table if not exists query_logs
(
    id          int auto_increment
        primary key,
    query_text  text                                null,
    executed_at timestamp default CURRENT_TIMESTAMP null
);



-------------
-- INSERTS --
-------------
insert into Categorie (cid, intitule)
values  (1, 'Drôle'),
        (2, 'Légendaire'),
        (3, 'Mythique'),
        (4, 'Normal'),
        (5, 'Rare'),
        (6, 'Vintage');

insert into Zone (zid, nom, description)
values  (1, 'Zone A', 'Hall principal'),
        (2, 'Zone B', 'Hall avant-gauche'),
        (3, 'Zone C', 'Hall arrière-gauche'),
        (4, 'Zone D', 'Hall avant-droit'),
        (5, 'Zone E', 'Hall arrière-droit');

insert into Emplacement (eid, code, zid)
values  (1, 'ZA-E1-001', 1),
        (2, 'ZA-E1-002', 1),
        (3, 'ZA-E1-003', 1),
        (4, 'ZA-E1-004', 1),
        (5, 'ZA-E1-005', 1),
        (6, 'ZA-E1-006', 1),
        (7, 'ZA-E1-007', 1),
        (8, 'ZA-E1-008', 1),
        (9, 'ZA-E1-009', 1),
        (10, 'ZA-E1-010', 1),
        (11, 'ZA-E1-011', 1),
        (12, 'ZA-E1-012', 1),
        (13, 'ZA-E1-013', 1),
        (14, 'ZA-E1-014', 1),
        (15, 'ZA-E1-015', 1),
        (16, 'ZA-E1-016', 1),
        (17, 'ZA-E1-017', 1),
        (18, 'ZA-E1-018', 1),
        (19, 'ZA-E1-019', 1),
        (20, 'ZA-E1-020', 1),
        (21, 'ZB-E1-001', 2),
        (22, 'ZB-E1-002', 2),
        (23, 'ZB-E1-003', 2),
        (24, 'ZB-E1-004', 2),
        (25, 'ZB-E1-005', 2),
        (26, 'ZB-E1-006', 2),
        (27, 'ZB-E1-007', 2),
        (28, 'ZB-E1-008', 2),
        (29, 'ZB-E1-009', 2),
        (30, 'ZB-E1-010', 2),
        (31, 'ZC-E1-001', 3),
        (32, 'ZC-E1-002', 3),
        (33, 'ZC-E1-003', 3),
        (34, 'ZC-E1-004', 3),
        (35, 'ZC-E1-005', 3),
        (36, 'ZC-E1-006', 3),
        (37, 'ZC-E1-007', 3),
        (38, 'ZC-E1-008', 3),
        (39, 'ZC-E1-009', 3),
        (40, 'ZC-E1-010', 3),
        (41, 'ZD-E1-001', 4),
        (42, 'ZD-E1-002', 4),
        (43, 'ZD-E1-003', 4),
        (44, 'ZD-E1-004', 4),
        (45, 'ZD-E1-005', 4),
        (46, 'ZD-E1-006', 4),
        (47, 'ZD-E1-007', 4),
        (48, 'ZD-E1-008', 4),
        (49, 'ZD-E1-009', 4),
        (50, 'ZD-E1-010', 4),
        (51, 'ZE-E1-001', 5),
        (52, 'ZE-E1-002', 5),
        (53, 'ZE-E1-003', 5),
        (54, 'ZE-E1-004', 5),
        (55, 'ZE-E1-005', 5),
        (56, 'ZE-E1-006', 5),
        (57, 'ZE-E1-007', 5),
        (58, 'ZE-E1-008', 5),
        (59, 'ZE-E1-009', 5),
        (60, 'ZE-E1-010', 5);

insert into Brocanteur (bid, nom, prenom, courriel, mot_passe, photo, description, visible, est_administrateur, eid, a_paye, isDeleted)
values  (1, 'admin', 'admin', 'admin@admin.aa', '$2y$12$LYDQsBgwDSC4k2IX7B7p0ebjOrM2J5gDCWx1AZ7saFCTEbtO0naUi', 'uploads/admin_admin_20032025_ABCDE.jpg', 'Im the admin', 0, 1, null, 0, 0),
        (2, 'Broc', 'Broc', 'broc@broc.aa', '$2y$12$zd0oTX9NCR1idtkFvGuhCOQHv144pkV94C5DD9GVKHt9RWzWUzxS2', 'uploads/Broc_Broc_13042025105203_aQv8j.png', 'Je suis un brocanteur de test. J&#039;ai besoin de tester une description assez longue pour pouvoir déterminer si un petit bug d&#039;affichage traine. Au lieu de m&#039;attaquer à de plus gros morceaux de code, je perds mon temps sur des détails que personne ne remarquera et encore moins augmentera ma côte finale. Mais au moins, je serais fier de mon travail.', 1, 0, 2, 1, 0),
        (3, 'test2', 'test2', 'test2@test2.aa', '$2y$12$ffDUHLCnOyQo1gKftymv5.1.2d3VT4wdcSdqQXoZljmqqxrcgSJ4C', 'uploads/default_avatar.jpg', 'test2', 1, 0, null, 0, 0),
        (4, 'Nita', 'Nat', 'nn@nn.aa', '$2y$12$NRDMRMW0t/YA/FZXvA4.aeNFGqVHooynKzxXh0ipHI2OwkTaXUtm.', 'uploads/nat_nita_25032025161738_O2pLd.jpg', 'Je m''appelle Nat, j''aime les PEZ.', 1, 0, 45, 1, 0),
        (5, 'Louage', 'Julie', 'jl@jl.aa', '$2y$12$WCEVN8CujzQXeoF/L1yjVex3V22PwEvH9RPeacZQ.IjjMlr6Ismnq', 'uploads/julie_louage_25032025161738_f65i7.jpg', 'Hello, julie ici. J''adore travailler dans le monde du marché au puces, et je m''amuse énormément depuis que je me suis mise à la revente de dispenseurs de PEZ.', 1, 0, 57, 1, 0),
        (6, 'Wamba', 'Tristan', 'tw@tw.aa', '$2y$12$qZr50QuuPbkCmzWzBLblg.u2UlS3ipNVZxXHcROH1q6JasRAGJ2V6', 'uploads/tristan_wamba_25032025161738_WG12y.jpg', 'Je m''appelle Tristan Wamba, c''est ma première participation à un marché au puces.', 0, 0, 14, 1, 0),
        (7, 'test6', 'test6', 'test6@test6.aa', '$2y$12$/LdqyAHRB9TEuecoymJDiO7fhjF0HBnZC0IFE/AkMjeaevGVSwDDq', 'uploads/default_avatar.jpg', 'test6', 0, 0, null, 0, 0),
        (11, 'Kim', 'Peter', 'pk@pk.aa', '$2y$12$y5S3AT0bNZ0oUmKLoHcs3O1c6eNWM1132YEsxRpc2uUTCdPTC5oge', 'uploads/peter_kim_25032025161738_hGf5x.jpg', 'Profesionnel de la vente de seconde main depuis 20 ans.', 1, 0, 27, 1, 0),
        (12, 'Petit', 'David', 'dp@dp.aa', '$2y$12$ZB5tcK6u0IrGCfCscAffB.a020xU0P4Vd2WfwNsKrdTYINlPgCcfG', 'uploads/david_petit_25032025161738_946k7.jpg', 'My name is David Petit. That''s it. Mic drop.', 1, 0, null, 1, 0),
        (13, 'Hammil', 'Mark', 'mh@mh.aa', '$2y$12$/fDhxKcpkZWEbmp1gx57Weqo/MOmuNJHtjytF1OuYVOT/aPglpLXq', 'uploads/marc_hammil_23032025213604_Jg5cq.jpg', 'Star wars, pew pew.', 1, 0, 8, 1, 0),
        (14, 'hatar', 'Julius', 'jh@jh.aa', '$2y$12$NdFr/A9FEOOoejFhuDsMAuneQx2oB2Pe8JUbRvKNymgu3ALLj8QJG', 'uploads/julius_hatar_24032025212754_HulWX.jpg', 'Venez venez ...', 1, 0, 10, 1, 0),
        (15, 'Dogvi', 'Micha', 'md@md.aa', '$2y$12$NqXXXad5hELRC1uw9Ezre.gtsAGX3dknOCrCjvgJ7Dw7eThtBbv4e', 'uploads/micha_dogvi_24032025211245_6XPiV.jpg', 'Never good at these.', 1, 0, 7, 1, 0),
        (17, 'McTay', 'Tommy', 'tm@tm.aa', '$2y$12$/zGL0Vs5MlA/7p79oR5fyelZWMR4M0raJ0znSqlKShLiedodZwfAm', 'uploads/tommy_mctay_25032025161738_faQVC.jpg', 'yeeeehhaaaa.', 1, 0, 40, 1, 0),
        (18, 'Mighty', 'Jinny', 'jm@jm.aa', '$2y$12$sMUU2qxX6M8.E3C72yrtcOqrHTyn2w5r/nhtc9D7OBRWB2vdJH02q', 'uploads/jinny_mighty_24032025212027_HGvqn.jpg', 'Salut, je suis Jinny.', 1, 0, null, 1, 0),
        (19, 'Hamilton', 'Hanna', 'hh@hh.aa', '$2y$12$nnRXZEAtx01QwkWMZApv/O9r5BfnPnBpR14Nn/mwYwUh.ke8r7HgW', 'uploads/Hanna_Hamilton_26032025115227_FeE25.jpg', 'Yo, I''m Hanna.', 1, 0, 17, 1, 0),
        (20, 'Thompson', 'Milly', 'mt@mt.aa', '$2y$12$yJBiJHL8.95LEvVBWdiRkO6E0HRFCkhx1VJW4mOBjXNL0oGrcJbIa', 'uploads/Milly_Thompson_29032025074112_bQ12P.jpg', 'Hello there, I come directly from Australia to participate in this event and sell tons of PEZ&#039;s dispensers. I hope to see many of you there, cya.', 1, 0, 35, 1, 0),
        (22, 'Dallas', 'Korben', 'kd@kd.aa', '$2y$12$TfqU.cuC9wb9J9eMRPD/Y.lyp1Bjv0ZA/0KI2ozfx7PjGC.0vnIWm', 'uploads/Korben_Dallas_30032025103109_fNTGM.jpg', 'The 5th Element is a must-watch. All my PEZ dispensers are derived from the movie. Enjoy.', 1, 0, null, 0, 0),
        (24, 'Zuko', 'Danny', 'dz@dz.aa', '$2y$12$mJniE5Me5oZi59N11.OdQutnxt12zbsUIagy13MnMvrsI2AcpBx8m', 'uploads/Danny_Zuko_13042025120404_vysgO.png', 'Rock&#039;n roll.', 1, 0, 4, 1, 0);

insert into Objet (oid, intitule, image, description, cid, bid, isDeleted)
values  (1, 'Donkey Kong', 'uploads/MjGws7KLUr_28032025192540.jpg', 'Donkey Kong', 2, 2, 0),
        (2, 'Grumpy Bear', 'uploads/klmxBkPM68_27032025215845.jpg', 'Le dispenseur de PEZ Grumpy Bear fait partie de la serie "Les Bisounours" sortie en 1993.', 4, 2, 0),
        (3, 'Red Bird', 'uploads/8koxBkPM68_27032025215828.jpg', 'Le dispenseur de PEZ Red Bird fait partie de la serie "Angry Birds" sortie en 2019.', 4, 2, 0),
        (4, 'Black Bird', 'uploads/123xBkPM68_27032025215825.jpg', 'Le dispenseur de PEZ Black Bird fait partie de la serie "Angry Birds" sortie en 2019.', 4, 2, 0),
        (5, 'Meat Ball', 'uploads/abyxBkPM68_27032025215821.jpg', 'Le dispenseur de PEZ Meat Ball fait partie de la serie "..." sortie en 2019.', 4, 2, 0),
        (6, 'Sweet Bear', 'uploads/AHOxBkPM68_27032025215823.jpg', 'Le dispenseur de PEZ Sweet Bear fait partie de la serie &quot;Les Bisounours&quot; sortie en 1993.', 4, 2, 0),
        (7, 'Good Luck Bear', 'uploads/ehz4rI2UVB_27032025220028.jpg', 'Le dispenseur de PEZ Sweet Bear fait partie de la serie &quot;Les Bisounours&quot; sortie en 1993.', 4, 2, 0),
        (8, 'Cheer Bear', 'uploads/ZAw4nVNKsF_28032025173132.jpg', 'Le dispenseur de PEZ Cheer Bear fait partie de la serie &quot;Les Bisounours&quot; sortie en 1994.', 6, 2, 0),
        (9, 'Sleepy Garfield', 'uploads/kcJ0e5THEm_27032025221332.jpg', 'Sleepy Garfield', 1, 2, 0),
        (10, 'The Grinch', 'uploads/uM3QY0H5kb_27032025221505.jpg', 'The Grinch', 6, 2, 0),
        (11, 'Masha', 'uploads/30OZcFGmUu_28032025110702.jpg', 'Masha', 6, 6, 0),
        (12, 'Kermit', 'uploads/TbKDdBFCyi_28032025185149.jpg', 'Kermit', 3, 2, 0),
        (14, 'Mario', 'uploads/WZTNmv8jEJ_28032025195110.jpg', 'Mario', 3, 2, 0),
        (15, 'Wall-e', 'uploads/cMIQF7ZoUq_30032025143931.jpg', 'Test3', 1, 2, 0),
        (16, 'Pluto', 'uploads/g5k9pTeIWD_30032025104926.jpg', 'Pluto est le chien de Mickey Mouse. Sa première apparition date d&#039;avant votre naissance.', 6, 6, 0),
        (17, 'Donald', 'uploads/q2SQwza6H5_30032025142709.jpg', 'Donald', 1, 2, 0),
        (18, 'Peter Pan', 'uploads/HE36aKyDkd_30032025142803.jpg', 'Peter Pan, hideous', 6, 2, 0),
        (19, 'Cendrillon', 'uploads/JvCSNhmU4M_30032025142937.jpg', 'Cendrillon test', 3, 2, 0),
        (20, 'Belle', 'uploads/Z0cIaMWu4N_30032025143003.jpg', 'Objet 1 de catégorie 2', 2, 2, 0),
        (21, 'Lampo', 'uploads/w138kiEufj_30032025143026.jpg', 'Objet 2 de catégorie 2', 2, 2, 0),
        (22, 'Toad', 'uploads/SgqjpeyI7w_30032025143052.jpg', 'Objet 3 de catégorie 2', 2, 2, 0),
        (23, 'Yoshi', 'uploads/kc4Y9Sgt7C_30032025143110.jpg', 'Objet 1 de catégorie 3', 3, 2, 0),
        (24, 'Troll Fille', 'uploads/MkXPOdWHVr_30032025143133.jpg', 'Objet 2 de catégorie 3', 3, 2, 0),
        (25, 'Troll Dude', 'uploads/X5y6JBU9Mi_30032025143157.jpg', 'Objet 3 de catégorie 3', 3, 2, 0),
        (26, 'Penguin A', 'uploads/vGI6UmyC73_30032025143220.jpg', 'Objet 1 de catégorie 4', 4, 2, 0),
        (27, 'Penguin B', 'uploads/h2M4KwzStn_30032025143259.jpg', 'Objet 2 de catégorie 4', 4, 2, 0),
        (28, 'Penguin C', 'uploads/j5cqgHKrVY_30032025143315.jpg', 'Objet 3 de catégorie 4', 4, 2, 0),
        (29, 'Penguin D', 'uploads/fi5pt7Nc1e_30032025143332.jpg', 'Objet 1 de catégorie 5', 5, 2, 0),
        (30, 'Fiona', 'uploads/Q5p9xYMegD_30032025143422.jpg', 'Objet 2 de catégorie 5', 5, 2, 0),
        (31, 'Shrek', 'uploads/9VTvum7rjx_30032025143435.jpg', 'Objet 3 de catégorie 5', 5, 2, 0),
        (32, 'Tigre', 'uploads/M9KPsIYBJy_30032025143450.jpg', 'Objet 1 de catégorie 6', 6, 2, 0),
        (33, 'Kung Fu Panda', 'uploads/sdCYlETRpV_30032025143512.jpg', 'Objet 2 de catégorie 6', 6, 2, 0),
        (34, 'Eve', 'uploads/5yGx2ndu3B_30032025143529.jpg', 'Objet 3 de catégorie 6', 6, 2, 0),
        (35, 'Woody', 'uploads/N1Y2DVcxZo_30032025144129.jpg', 'Objet 1 de catégorie 1', 1, 4, 0),
        (36, 'Martian', 'uploads/yknAWYDJq4_30032025144447.jpg', 'Objet 2 de catégorie 1', 1, 4, 0),
        (37, 'Dog', 'uploads/cINQORfDbp_30032025144504.jpg', 'Objet 3 de catégorie 1', 1, 4, 0),
        (38, 'Rex', 'uploads/5hmFGTdeJn_30032025144517.jpg', 'Objet 1 de catégorie 2', 2, 4, 0),
        (39, 'Buzz', 'uploads/hWmoeSin6x_30032025144532.jpg', 'Objet 2 de catégorie 2', 2, 4, 0),
        (40, 'Grumpy chef', 'uploads/Ems2dMYOfS_30032025144552.jpg', 'Objet 3 de catégorie 2', 2, 4, 0),
        (41, 'Useless cook', 'uploads/2oIamiV57J_30032025144613.jpg', 'Objet 1 de catégorie 3', 3, 4, 0),
        (42, 'Ratatouille', 'uploads/Z4XQNBURgW_30032025144644.jpg', 'Objet 2 de catégorie 3', 3, 4, 0),
        (43, 'Jack Sparrow', 'uploads/UyPfDSeb0R_30032025144730.jpg', 'Objet 3 de catégorie 3', 3, 4, 0),
        (44, 'Purple monster', 'uploads/ju5m01tnvc_30032025144748.jpg', 'Objet 1 de catégorie 4', 4, 4, 0),
        (45, 'One eye', 'uploads/E9F8sT6XD7_30032025144816.jpg', 'Objet 2 de catégorie 4', 4, 4, 0),
        (46, 'Moana', 'uploads/ndDIAqMbYo_30032025144839.jpg', 'Objet 3 de catégorie 4', 4, 4, 0),
        (47, 'Timon', 'uploads/8cEwIQ93pJ_30032025144906.jpg', 'Objet 1 de catégorie 5', 5, 4, 0),
        (48, 'Simba', 'uploads/VFnibxUwfH_30032025144936.jpg', 'Objet 2 de catégorie 5', 5, 4, 0),
        (49, 'Pumbaa', 'uploads/ZFlbfKvMX5_30032025144952.jpg', 'Objet 3 de catégorie 5', 5, 4, 0),
        (50, 'Simba adult', 'uploads/Kx5oXUtRPG_30032025145221.jpg', 'Objet 1 de catégorie 6', 6, 4, 0),
        (51, 'Lion girl', 'uploads/y3Xs0f4bTU_30032025145155.jpg', 'Objet 2 de catégorie 6', 6, 4, 0),
        (52, 'Violet', 'uploads/sWpHGB8zN9_30032025145247.jpg', 'Objet 3 de catégorie 6', 6, 4, 0),
        (53, 'Bob', 'uploads/5PFjvkBJDV_30032025145445.jpg', 'Objet 1 de catégorie 1', 1, 5, 0),
        (54, 'Helen', 'uploads/e8LyvXBqPY_30032025145500.jpg', 'Objet 2 de catégorie 1', 1, 5, 0),
        (55, 'Dash', 'uploads/A37zuZ6mNl_30032025145516.jpg', 'Objet 3 de catégorie 1', 1, 5, 0),
        (56, 'Olaf', 'uploads/BkjiX1q0us_30032025145605.jpg', 'Objet 1 de catégorie 2', 2, 5, 0),
        (57, 'Elsa', 'uploads/IndLa4OfFi_30032025145623.jpg', 'Objet 2 de catégorie 2', 2, 5, 0),
        (58, 'Dory', 'uploads/rBKVDlgYTO_30032025145712.jpg', 'Objet 3 de catégorie 2', 2, 5, 0),
        (59, 'McQueen', 'uploads/Zw4XDN72zj_30032025145728.jpg', 'Objet 1 de catégorie 3', 3, 5, 0),
        (60, 'Nemo', 'uploads/qlpn4HgvQW_30032025145745.jpg', 'Objet 2 de catégorie 3', 3, 5, 0),
        (61, 'Winnie', 'uploads/8XPWrvGo9R_30032025145835.jpg', 'Objet 3 de catégorie 3', 3, 5, 0),
        (62, 'Tigrou', 'uploads/AH9gjxSLYd_30032025145852.jpg', 'Objet 1 de catégorie 4', 4, 5, 0),
        (63, 'Boeuf', 'uploads/a2kufMJmcP_30032025145921.jpg', 'Objet 2 de catégorie 4', 4, 5, 0),
        (64, 'Scary Simplet', 'uploads/KmjpETuRNO_30032025150007.jpg', 'Objet 3 de catégorie 4', 4, 5, 0),
        (65, 'Grincheux', 'uploads/mrLh4xJ1gs_30032025150038.jpg', 'Objet 1 de catégorie 5', 5, 5, 0),
        (66, 'Pocahontas', 'uploads/Rj7UVMLCse_30032025150102.jpg', 'Objet 2 de catégorie 5', 5, 5, 0),
        (67, 'Irish girl', 'uploads/WqdyBDIezb_30032025150130.jpg', 'Objet 3 de catégorie 5', 5, 5, 0),
        (68, 'Jasmine', 'uploads/BojEVzDXnJ_30032025150159.jpg', 'Objet 1 de catégorie 6', 6, 5, 0),
        (69, 'Obj17-5', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 5, 0),
        (70, 'Obj18-5', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 5, 0),
        (71, 'Obj01-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 1', 1, 6, 0),
        (72, 'Obj02-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 1', 1, 6, 0),
        (73, 'Obj03-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 1', 1, 6, 0),
        (74, 'Obj04-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 2', 2, 6, 0),
        (75, 'Obj05-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 2', 2, 6, 0),
        (76, 'Obj06-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 2', 2, 6, 0),
        (77, 'Obj07-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 3', 3, 6, 0),
        (78, 'Obj08-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 3', 3, 6, 0),
        (79, 'Obj09-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 3', 3, 6, 0),
        (80, 'Obj10-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 4', 4, 6, 0),
        (81, 'Obj11-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 4', 4, 6, 0),
        (82, 'Obj12-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 4', 4, 6, 0),
        (83, 'Obj13-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 5', 5, 6, 0),
        (84, 'Obj14-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 5', 5, 6, 0),
        (85, 'Obj15-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 5', 5, 6, 0),
        (86, 'Obj16-6', 'uploads/default_image.jpg', 'Objet 1 de catégorie 6', 6, 6, 0),
        (87, 'Obj17-6', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 6, 0),
        (88, 'Obj18-6', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 6, 0),
        (89, 'Obj01-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 1', 1, 11, 0),
        (90, 'Obj02-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 1', 1, 11, 0),
        (91, 'Obj03-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 1', 1, 11, 0),
        (92, 'Obj04-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 2', 2, 11, 0),
        (93, 'Obj05-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 2', 2, 11, 0),
        (94, 'Obj06-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 2', 2, 11, 0),
        (95, 'Obj07-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 3', 3, 11, 0),
        (96, 'Obj08-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 3', 3, 11, 0),
        (97, 'Obj09-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 3', 3, 11, 0),
        (98, 'Obj10-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 4', 4, 11, 0),
        (99, 'Obj11-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 4', 4, 11, 0),
        (100, 'Obj12-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 4', 4, 11, 0),
        (101, 'Obj13-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 5', 5, 11, 0),
        (102, 'Obj14-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 5', 5, 11, 0),
        (103, 'Obj15-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 5', 5, 11, 0),
        (104, 'Obj16-11', 'uploads/default_image.jpg', 'Objet 1 de catégorie 6', 6, 11, 0),
        (105, 'Obj17-11', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 11, 0),
        (106, 'Obj18-11', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 11, 0),
        (107, 'Obj01-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 1', 1, 17, 0),
        (108, 'Obj02-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 1', 1, 17, 0),
        (109, 'Obj03-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 1', 1, 17, 0),
        (110, 'Obj04-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 2', 2, 17, 0),
        (111, 'Obj05-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 2', 2, 17, 0),
        (112, 'Obj06-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 2', 2, 17, 0),
        (113, 'Obj07-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 3', 3, 17, 0),
        (114, 'Obj08-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 3', 3, 17, 0),
        (115, 'Obj09-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 3', 3, 17, 0),
        (116, 'Obj10-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 4', 4, 17, 0),
        (117, 'Obj11-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 4', 4, 17, 0),
        (118, 'Obj12-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 4', 4, 17, 0),
        (119, 'Obj13-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 5', 5, 17, 0),
        (120, 'Obj14-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 5', 5, 17, 0),
        (121, 'Obj15-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 5', 5, 17, 0),
        (122, 'Obj16-17', 'uploads/default_image.jpg', 'Objet 1 de catégorie 6', 6, 17, 0),
        (123, 'Obj17-17', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 17, 0),
        (124, 'Obj18-17', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 17, 0),
        (125, 'Obj01-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 1', 1, 19, 0),
        (126, 'Obj02-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 1', 1, 19, 0),
        (127, 'Obj03-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 1', 1, 19, 0),
        (128, 'Obj04-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 2', 2, 19, 0),
        (129, 'Obj05-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 2', 2, 19, 0),
        (130, 'Obj06-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 2', 2, 19, 0),
        (131, 'Obj07-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 3', 3, 19, 0),
        (132, 'Obj08-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 3', 3, 19, 0),
        (133, 'Obj09-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 3', 3, 19, 0),
        (134, 'Obj10-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 4', 4, 19, 0),
        (135, 'Obj11-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 4', 4, 19, 0),
        (136, 'Obj12-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 4', 4, 19, 0),
        (137, 'Obj13-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 5', 5, 19, 0),
        (138, 'Obj14-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 5', 5, 19, 0),
        (139, 'Obj15-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 5', 5, 19, 0),
        (140, 'Obj16-19', 'uploads/default_image.jpg', 'Objet 1 de catégorie 6', 6, 19, 0),
        (141, 'Obj17-19', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 19, 0),
        (142, 'Obj18-19', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 19, 0),
        (143, 'Obj01-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 1', 1, 20, 0),
        (144, 'Obj02-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 1', 1, 20, 0),
        (145, 'Obj03-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 1', 1, 20, 0),
        (146, 'Obj04-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 2', 2, 20, 0),
        (147, 'Obj05-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 2', 2, 20, 0),
        (148, 'Obj06-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 2', 2, 20, 0),
        (149, 'Obj07-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 3', 3, 20, 0),
        (150, 'Obj08-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 3', 3, 20, 0),
        (151, 'Obj09-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 3', 3, 20, 0),
        (152, 'Obj10-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 4', 4, 20, 0),
        (153, 'Obj11-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 4', 4, 20, 0),
        (154, 'Obj12-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 4', 4, 20, 0),
        (155, 'Obj13-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 5', 5, 20, 0),
        (156, 'Obj14-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 5', 5, 20, 0),
        (157, 'Obj15-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 5', 5, 20, 0),
        (158, 'Obj16-20', 'uploads/default_image.jpg', 'Objet 1 de catégorie 6', 6, 20, 0),
        (159, 'Obj17-20', 'uploads/default_image.jpg', 'Objet 2 de catégorie 6', 6, 20, 0),
        (160, 'Obj18-20', 'uploads/default_image.jpg', 'Objet 3 de catégorie 6', 6, 20, 0),
        (161, 'Aladdin', 'uploads/V3tSRGi26Y_30032025142848.jpg', 'Aladdin', 4, 2, 0);

