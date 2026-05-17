-- =============================================================
-- Easy Procedures — Données de test bancaires
-- Exécuter : mysql -u my_app -p my_app < config/schema/seed_banking.sql
-- =============================================================

SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------
-- NETTOYAGE des données existantes (hors admin)
-- -------------------------------------------------------------
TRUNCATE TABLE requestrequirementproprieties;
TRUNCATE TABLE requestrequirements;
TRUNCATE TABLE requests;
TRUNCATE TABLE requirementproprieties;
TRUNCATE TABLE procedurerequirements;
TRUNCATE TABLE requirements;
TRUNCATE TABLE procedures;

-- Supprimer tous les utilisateurs sauf l'admin (id=1)
DELETE FROM users WHERE id != 1;

-- Remettre les auto-increments
ALTER TABLE procedures          AUTO_INCREMENT = 1;
ALTER TABLE requirements        AUTO_INCREMENT = 1;
ALTER TABLE requirementproprieties AUTO_INCREMENT = 1;
ALTER TABLE procedurerequirements  AUTO_INCREMENT = 1;
ALTER TABLE requests            AUTO_INCREMENT = 1;
ALTER TABLE requestrequirements AUTO_INCREMENT = 1;
ALTER TABLE users               AUTO_INCREMENT = 2;

-- Corriger les noms des types de pré-requis
UPDATE requirementtypes SET name = 'Formulaire', type = 'formulaire' WHERE id = 1;
UPDATE requirementtypes SET name = 'Fichier',    type = 'file'       WHERE id = 2;

SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================
-- UTILISATEURS
-- Mots de passe : agent123 / client123
-- =============================================================
INSERT INTO users (id, name, surname, email, phonenumber, password, deleted, id_role, created, modified) VALUES
-- Agents (role 2)
(2,  'Sophie',  'Martin',   'sophie.martin@easypro.com',   771234501, '$2y$12$4GMKQWCS1hC6CvtAv/p30uYrL4VGljcioyXq/2hQiyVCu8xDWmr2e', 0, 2, NOW(), NOW()),
(3,  'Thomas',  'Dupont',   'thomas.dupont@easypro.com',   771234502, '$2y$12$4GMKQWCS1hC6CvtAv/p30uYrL4VGljcioyXq/2hQiyVCu8xDWmr2e', 0, 2, NOW(), NOW()),
-- Clients (role 1)
(4,  'Marie',   'Leclerc',  'marie.leclerc@gmail.com',     661234501, '$2y$12$Q9zUbvX1192X1RuCx/nf8uQo3G5B3NnU8YMRgHhULYrVCPxeVVexS', 0, 1, NOW(), NOW()),
(5,  'Paul',    'Bernard',  'paul.bernard@gmail.com',      661234502, '$2y$12$Q9zUbvX1192X1RuCx/nf8uQo3G5B3NnU8YMRgHhULYrVCPxeVVexS', 0, 1, NOW(), NOW()),
(6,  'Fatou',   'Diallo',   'fatou.diallo@gmail.com',      661234503, '$2y$12$Q9zUbvX1192X1RuCx/nf8uQo3G5B3NnU8YMRgHhULYrVCPxeVVexS', 0, 1, NOW(), NOW()),
(7,  'Karim',   'Toure',    'karim.toure@gmail.com',       661234504, '$2y$12$Q9zUbvX1192X1RuCx/nf8uQo3G5B3NnU8YMRgHhULYrVCPxeVVexS', 0, 1, NOW(), NOW()),
(8,  'Amina',   'Coulibaly','amina.coulibaly@gmail.com',   661234505, '$2y$12$Q9zUbvX1192X1RuCx/nf8uQo3G5B3NnU8YMRgHhULYrVCPxeVVexS', 0, 1, NOW(), NOW());

-- =============================================================
-- PROCÉDURES BANCAIRES
-- =============================================================
INSERT INTO procedures (id, name, type, description, deleted, created, modified) VALUES
(1, 'Ouverture de compte',    'Particulier', 'Ouverture d\'un compte courant pour un particulier. Accédez à tous les services bancaires essentiels.', 0, NOW(), NOW()),
(2, 'Demande de crédit',      'Particulier', 'Demande de prêt personnel ou immobilier. Étude de votre dossier par nos conseillers sous 72h.', 0, NOW(), NOW()),
(3, 'Carte bancaire',         'Particulier', 'Demande d\'émission ou de renouvellement de carte bancaire (Visa, Mastercard).', 0, NOW(), NOW()),
(4, 'Virement international', 'Entreprise',  'Exécution d\'un virement bancaire vers un compte à l\'étranger (SWIFT/SEPA).', 0, NOW(), NOW()),
(5, 'Compte épargne',         'Particulier', 'Ouverture d\'un livret d\'épargne rémunéré. Faites fructifier votre argent en toute sécurité.', 0, NOW(), NOW());

-- =============================================================
-- PRÉ-REQUIS (requirements)
-- TYPE 1 = formulaire | TYPE 2 = fichier
-- =============================================================

-- ── Pré-requis communs ──────────────────────────────────────
-- R1 : Pièce d'identité (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(1, 'Pièce d\'identité', 'Copie recto-verso de la CNI ou du passeport en cours de validité.', 'active', 'CNI, Passeport, Titre de séjour', 0, 2, NOW(), NOW());

-- R2 : Justificatif de domicile (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(2, 'Justificatif de domicile', 'Document officiel de moins de 3 mois attestant votre adresse.', 'active', 'Facture EDF, Quittance de loyer, Avis d\'imposition', 0, 2, NOW(), NOW());

-- R3 : Informations personnelles (formulaire)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(3, 'Informations personnelles', 'Renseignements d\'identité du demandeur.', 'active', 'Nom, prénom, date de naissance, nationalité', 0, 1, NOW(), NOW());

-- R4 : Justificatif de revenus (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(4, 'Justificatif de revenus', 'Preuve de vos revenus mensuels réguliers.', 'active', 'Fiche de paie, Avis d\'imposition, Relevé de pension', 0, 2, NOW(), NOW());

-- R5 : Relevé bancaire (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(5, 'Relevé bancaire', 'Extraits de compte des 3 derniers mois de votre banque actuelle.', 'active', 'PDF fourni par votre banque', 0, 2, NOW(), NOW());

-- R6 : Informations sur le crédit (formulaire)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(6, 'Détails du crédit demandé', 'Précisez les caractéristiques du prêt souhaité.', 'active', 'Montant, durée, objet du crédit', 0, 1, NOW(), NOW());

-- R7 : Contrat de travail ou attestation (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(7, 'Contrat de travail', 'Copie du contrat ou attestation de votre employeur.', 'active', 'CDI, CDD, Attestation employeur', 0, 2, NOW(), NOW());

-- R8 : Informations virement (formulaire)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(8, 'Coordonnées du bénéficiaire', 'Informations bancaires complètes du destinataire du virement.', 'active', 'Nom, IBAN, BIC/SWIFT, banque', 0, 1, NOW(), NOW());

-- R9 : Photo d'identité (fichier)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(9, 'Photo d\'identité', 'Photo récente sur fond blanc, format passeport.', 'active', 'JPG ou PNG, moins de 5 Mo', 0, 2, NOW(), NOW());

-- R10 : Objectif d'épargne (formulaire)
INSERT INTO requirements (id, name, description, status, example, deleted, requirementtype_id, created, modified) VALUES
(10, 'Objectif d\'épargne', 'Précisez vos objectifs et le montant initial à déposer.', 'active', 'Montant initial, versements mensuels prévus', 0, 1, NOW(), NOW());

-- =============================================================
-- PROPRIÉTÉS DES FORMULAIRES (requirementproprieties)
-- =============================================================

-- Propriétés du formulaire R3 : Informations personnelles
INSERT INTO requirementproprieties (type, name, label, description, deleted, requirement_id, created, modified) VALUES
('text',     'nom',            'Nom de famille',     'Votre nom de famille tel qu\'il figure sur votre CNI', 0, 3, NOW(), NOW()),
('text',     'prenom',         'Prénom',             'Votre prénom tel qu\'il figure sur votre CNI',         0, 3, NOW(), NOW()),
('date',     'date_naissance', 'Date de naissance',  'Format JJ/MM/AAAA',                                    0, 3, NOW(), NOW()),
('text',     'lieu_naissance', 'Lieu de naissance',  'Ville et pays de naissance',                           0, 3, NOW(), NOW()),
('text',     'nationalite',    'Nationalité',        'Votre nationalité principale',                         0, 3, NOW(), NOW()),
('textarea', 'adresse',        'Adresse complète',   'Numéro, rue, code postal, ville',                      0, 3, NOW(), NOW()),
('email',    'email',          'Adresse email',      'Email de contact valide',                              0, 3, NOW(), NOW()),
('text',     'telephone',      'Téléphone',          'Numéro de téléphone mobile',                           0, 3, NOW(), NOW());

-- Propriétés du formulaire R6 : Détails du crédit
INSERT INTO requirementproprieties (type, name, label, description, deleted, requirement_id, created, modified) VALUES
('number',   'montant',        'Montant souhaité (FCFA)', 'Montant total du crédit demandé',          0, 6, NOW(), NOW()),
('number',   'duree_mois',     'Durée (en mois)',         'Durée de remboursement souhaitée',         0, 6, NOW(), NOW()),
('text',     'objet',          'Objet du crédit',         'Ex : immobilier, véhicule, personnel…',    0, 6, NOW(), NOW()),
('textarea', 'situation_pro',  'Situation professionnelle','Employeur, poste, ancienneté, revenus',   0, 6, NOW(), NOW());

-- Propriétés du formulaire R8 : Coordonnées du bénéficiaire
INSERT INTO requirementproprieties (type, name, label, description, deleted, requirement_id, created, modified) VALUES
('text',   'nom_beneficiaire', 'Nom du bénéficiaire',   'Nom complet du destinataire',                 0, 8, NOW(), NOW()),
('text',   'iban',             'IBAN',                  'Numéro de compte international du destinataire', 0, 8, NOW(), NOW()),
('text',   'bic',              'BIC / SWIFT',           'Code d\'identification de la banque',          0, 8, NOW(), NOW()),
('text',   'banque',           'Nom de la banque',      'Banque du destinataire',                       0, 8, NOW(), NOW()),
('text',   'pays',             'Pays destinataire',     'Pays de la banque destinataire',               0, 8, NOW(), NOW()),
('number', 'montant',          'Montant (FCFA)',         'Montant à virer',                              0, 8, NOW(), NOW()),
('text',   'motif',            'Motif du virement',     'Raison du virement (ex : achat, dette…)',      0, 8, NOW(), NOW());

-- Propriétés du formulaire R10 : Objectif d'épargne
INSERT INTO requirementproprieties (type, name, label, description, deleted, requirement_id, created, modified) VALUES
('number',   'depot_initial',  'Dépôt initial (FCFA)',       'Montant du premier versement',                0, 10, NOW(), NOW()),
('number',   'versement_mois', 'Versement mensuel (FCFA)',   'Montant que vous souhaitez épargner par mois', 0, 10, NOW(), NOW()),
('text',     'objectif',       'Objectif d\'épargne',        'Ex : retraite, achat immobilier, voyage…',     0, 10, NOW(), NOW()),
('number',   'duree_ans',      'Horizon (en années)',        'Durée de votre projet d\'épargne',             0, 10, NOW(), NOW());

-- =============================================================
-- LIENS PROCÉDURES ↔ PRÉ-REQUIS (procedurerequirements)
-- =============================================================

-- P1 : Ouverture de compte → R3 Infos perso, R1 CNI, R2 Domicile, R9 Photo
INSERT INTO procedurerequirements (procedure_id, requirement_id, created, modified) VALUES
(1, 3, NOW(), NOW()),
(1, 1, NOW(), NOW()),
(1, 2, NOW(), NOW()),
(1, 9, NOW(), NOW());

-- P2 : Demande de crédit → R3 Infos perso, R1 CNI, R4 Revenus, R5 Relevé, R6 Détails crédit, R7 Contrat
INSERT INTO procedurerequirements (procedure_id, requirement_id, created, modified) VALUES
(2, 3, NOW(), NOW()),
(2, 1, NOW(), NOW()),
(2, 4, NOW(), NOW()),
(2, 5, NOW(), NOW()),
(2, 6, NOW(), NOW()),
(2, 7, NOW(), NOW());

-- P3 : Carte bancaire → R3 Infos perso, R1 CNI, R2 Domicile
INSERT INTO procedurerequirements (procedure_id, requirement_id, created, modified) VALUES
(3, 3, NOW(), NOW()),
(3, 1, NOW(), NOW()),
(3, 2, NOW(), NOW());

-- P4 : Virement international → R8 Coordonnées bénéficiaire, R1 CNI, R5 Relevé
INSERT INTO procedurerequirements (procedure_id, requirement_id, created, modified) VALUES
(4, 8, NOW(), NOW()),
(4, 1, NOW(), NOW()),
(4, 5, NOW(), NOW());

-- P5 : Compte épargne → R3 Infos perso, R1 CNI, R4 Revenus, R10 Objectif
INSERT INTO procedurerequirements (procedure_id, requirement_id, created, modified) VALUES
(5, 3, NOW(), NOW()),
(5, 1, NOW(), NOW()),
(5, 4, NOW(), NOW()),
(5, 10, NOW(), NOW());

-- =============================================================
-- FIN
-- =============================================================
SELECT CONCAT('✓ ', COUNT(*), ' procédures bancaires')  AS résumé FROM procedures  WHERE deleted=0
UNION ALL
SELECT CONCAT('✓ ', COUNT(*), ' pré-requis')            FROM requirements           WHERE deleted=0
UNION ALL
SELECT CONCAT('✓ ', COUNT(*), ' utilisateurs (hors admin)') FROM users              WHERE deleted=0 AND id != 1
UNION ALL
SELECT CONCAT('✓ ', COUNT(*), ' liens procédure↔prérequis') FROM procedurerequirements;
