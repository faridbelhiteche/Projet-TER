DROP SCHEMA IF EXISTS silore CASCADE;
CREATE SCHEMA silore;

DROP TABLE IF EXISTS silore.contrats CASCADE;
CREATE TABLE silore.contrats(
    id_contrat integer NOT NULL PRIMARY KEY,
    id_groupe integer REFERENCES silose.refi_groupes(id_groupe), --FK silose !
    nom_contrat text,
    nom_eotp text,
    organisme_gestionnaire text,
    date_cloture date
);

DROP TABLE IF EXISTS silore.types_recrutement CASCADE; -- référentiel en interne
CREATE TABLE silore.types_recrutement(
    id_type_recrutement integer NOT NULL PRIMARY KEY,
    type_recrutement text NOT NULL
);

DROP TABLE IF EXISTS silore.etats_recrutement CASCADE;
CREATE TABLE silore.etats_recrutement(
    id_etat_demande serial NOT NULL PRIMARY KEY,
    nom_etat text NOT NULL
);

DROP TABLE IF EXISTS silore.responsabilites CASCADE; -- récupère resp silose puis correspondance
CREATE TABLE silore.responsabilites DROP TABLE IF EXISTS silore.responsabilites CASCADE;
    id_responsabilite serial NOT NULL PRIMARY KEY, -- une responsabilité porte sur un groupe ?
    nom_responsabilite text NOT NULL,
    id_responsabilite_silose integer 
);

-- mettre des index sur les id, les 3 premiers surtout. bien d'avoir des index.
-- idem contrats
-- recherches équipes, filtres groupes...

DROP TABLE IF EXISTS silore.demandes_recrutement CASCADE;
CREATE TABLE silore.demandes_recrutement (
    id_demande serial NOT NULL PRIMARY KEY,
    id_personne_recruteur integer NOT NULL REFERENCES silose.rh_personnes(id_personne), --FK cascade silose !
    id_personne_valideur integer NOT NULL REFERENCES silose.rh_personnes(id_personne), --FK cascade silose !
    groupe_affectation integer REFERENCES silose.refi_groupes(id_groupe), --FK silose cascade!
    nationalite text REFERENCES silose.ref_pays(nationalite), --FK silose !
    niveau_diplome integer REFERENCES silose.ref_lmd_hceres(id_lmd), --FK silose
    etat_demande integer NOT NULL REFERENCES silore.etats_recrutement(id_etat_demande), --FK silore
    id_contrat integer NOT NULL REFERENCES silore.contrats(id_contrat), --FK silore
    id_type_recrutement integer NOT NULL REFERENCES silore.types_recrutement(id_type_recrutement), --FK silore
    nom_recrute text NOT NULL,
    prenom_recrute text NOT NULL,
    email_perso_recrute text NOT NULL,
    libelle_diplome text NOT NULL,
    date_diplome date NOT NULL,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    quotite integer NOT NULL,
    mission text NOT NULL,
    commentaire text,
    motif_abandon text,
    dossier_complet bool NOT NULL,
    tutelle text
    -- "logs"
);

-- à la fin, accès en écriture à silose via une requête API

-- utilisateur lambda : va voir ses droits.
-- resp équipe : consulte les demandes, et choisit pour lesquelles le recrutement sera fait.
-- resp contrat : chercheur lambda (ce sur quoi il travaillle).
-- on ne se base pas sur les équipes de contrat.
-- manip' : faire choisir.
-- formulaire pour mettre à jour les types de recrutements -> libellé ?
-- silose : récupérer informations des personnes qui se connectent, groupes, resp, groupe resp API.
-- typer l'utilisateur -> Lambda, RH ...
-- chef de contrat : id_personne_valideur -> soit resp contrat, soit chef équipe.
-- chef de contrat qui hériterait de recruteur lambda, qui peut potentiellement porter un contrat.

-- boostrap et jquery.


--MARDI 15 à 16h
