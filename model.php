<?php

namespace App\Models;

use CodeIgniter\Model;

class DemandeRecrutement extends Model
{
    protected $DBGroup = 'silose';  //Connecte à la database de silose

    protected $table      = 'demande_recrutement';  //nom de la table avec laquelle le modele va communiquer principalement
    protected $primaryKey = 'id_demande'; //la clé primaire est id_demande

    protected $useAutoIncrement = true; //permet l'auto incrémentation de la clé primaire (serial)

    protected $returnType     = 'array';  //pas vraiment compris ?
    protected $useSoftDeletes = true; //à garder, plus de sécurité lors de la suppression, à voir

    protected $allowedFields =
    ['personnel_responsable',
    'groupe_affectation',
    'date_etat',
    'nom_recrute',
    'prenom_recrute',
    'nationalite',
    'email_perso',
    'libelle_diplome',
    'niveau_diplome',
    'date_diplome',
    'date_debut',
    'date_fin',
    'quotite',
    'mission',
    'commentaire',
    'motif_abandon',
    'dossier_complet',
    'etat_demande',
    'id_contrat',
    'type_recrutement'];

    //protected $useTimestamps = false;     //a priori on s'en sert pas, à moins qu'on veut savoir quand est ce que le fichier a été crée, mis à jour ou supprimé
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [
       'personnel_responsable'     => 'required|is_not_unique[table.field,where_field,where_value]',  //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec un des personnels du bureau
       'groupe_affectation'     => 'required|is_not_unique[table.field,where_field,where_value]',   //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec un des groupes
       'date_etat' => 'required|valid_date',
       'nom_recrute'        => 'required|string',
       'prenom_recrute'        => 'required|string',
       'nationalite'        => 'required|is_not_unique[table.field,where_field,where_value]', //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec une des nationalités
       'email_perso'        => 'required|valid_email',
       'libelle_diplome'        => 'required|string',
       'niveau_diplome'        => 'required|is_not_unique[table.field,where_field,where_value]',  //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec un des niveaux de diplomes
       'date_diplome'        => 'required|valid_date',
       'date_debut'        => 'required|valid_date',
       'date_fin'        => 'required|valid_date',
       'quotite'        => 'required|integer',
       'mission'        => 'required|string',
       'commentaire'        => 'string',
       'motif_abandon'        => 'required|string',
       'dossier_complet'        => 'required',
       'etat_demande'        => 'required|in_list[initialisé, ]',   //a compléter, à voir si on fait des int sinon ?
       'id_contrat'        => 'required|is_not_unique[table.field,where_field,where_value]',   //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec un des id contrat
       'type_recrutement'        => 'required|is_not_unique[table.field,where_field,where_value]',   //il faut changer le table.field, where_field, where_value pour vérifier qu'il matche bien avec un des types
   ];
    protected $validationMessages =  [
         'personnel_responsable' => [
             'required'    => 'Veuillez saisir un membre du personnel.',
             'is_not_unique[table.field,where_field,where_value]' => 'Le membre du personnel saisi n\'existe pas',
         ],
         'groupe_affectation'    => [
             'required' => 'Veuillez saisir un groupe d\'affectation.',
             'is_not_unique[table.field,where_field,where_value]' => 'Le groupe d\'affectation saisi n\'existe pas',
         ],
         'date_etat' => [
             'required'    => 'Veuillez saisir une date.',
             'valid_date' => 'Il semble que la date saisie n\'est pas au bon format.',
         ],
         'nom_recrute'    => [
             'required' => 'Veuillez saisir un nom pour le recruté.',
             'string' => 'Il semble que le format du nom est incorrect.',
         ],
         'prenom_recrute' => [
           'required' => 'Veuillez saisir un prénom pour le recruté.',
           'string' => 'Il semble que le format du prénom est incorrect.',
         ],
         'nationalite'    => [
             'required' => 'Veuillez saisir une nationalité.',
             'is_not_unique[table.field,where_field,where_value]' => 'Il semble que la nationalité choisie n\'est pas correcte.'
         ],
         'libelle_diplome' => [
             'required'    => 'Veuillez saisir un libellé au diplôme.',
             'string' => 'Il semble que le format du libellé est incorrect.',
         ],
         'niveau_diplome'    => [
             'required'    => 'Veuillez saisir un niveau de diplôme.',
             'is_not_unique[table.field,where_field,where_value]' => 'Il semble que le niveau de diplôme choisi n\'est pas correct.'
         ],
         'date_diplome' => [
           'required'    => 'Veuillez saisir une date pour le diplôme.',
           'valid_date' => 'Il semble que la date saisie n\'est pas au bon format.',
         ],
         'date_debut'    => [
           'required'    => 'Veuillez saisir une date de début de contrat.',
           'valid_date' => 'Il semble que la date saisie n\'est pas au bon format.',
         ],
         'date_fin' => [
           'required'    => 'Veuillez saisir une date de fin de contrat.',
           'valid_date' => 'Il semble que la date saisie n\'est pas au bon format.',
         ],
         'quotite'    => [
             'required'    => 'Veuillez saisir une quotité.',
             'integer' => 'Veuillez entrer un nombre entier.'
         ],
         'mission' => [
             'required'    => 'Veuillez saisir une mission.',
         ],
         'commentaire'    => [
             'string' => 'Ajoutez un commentaire à la mission.',
         ],
         'motif_abandon'    => [
             'required' => 'Veuillez expliquer pourquoi la mission a été abandonnée.',
         ],
         'dossier_complet'    => [
             'required' => 'Veuillez préciser si le dossier est complet ou non.',
         ],
         'etat_demande'    => [
             'required' => 'Veuillez appliquer un état à la demande.',
             'in_list[initialisé, ]' => 'Veuillez entrer un état correct (initialisé, ...)'
         ],
         'id_contrat'    => [
             'required' => 'Veuillez saisir un id de contrat.',
             'is_not_unique[table.field,where_field,where_value]' => 'Il semble que l\'id saisi est incorrect.'
         ],
         'type_recrutement'    => [
             'required' => 'Veuillez saisir un type de recrutement.',
             'is_not_unique[table.field,where_field,where_value]' => 'Il semble que le type de recrutement saisi est incorrect.'
         ],
     ];
    protected $skipValidation     = false;
}
