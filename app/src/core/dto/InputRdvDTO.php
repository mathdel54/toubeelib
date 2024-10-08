<?php

namespace toubeelib\core\dto;

use DateTimeImmutable;
use InvalidArgumentException;

class InputRdvDTO extends DTO
{
    protected string $idPraticien;
    protected string $idPatient;
    protected DateTimeImmutable $horaire;
    protected string $idSpecialite;
    protected string $type;
    protected string $statut;

    public function __construct($idPraticien, $idPatient, $horaire, $idSpecialite, $type, $statut) {
        // Validation des identifiants de praticien et de patient (par exemple, alphanumériques)
        if (!is_string($idPraticien) || !ctype_alnum($idPraticien)) {
            throw new InvalidArgumentException("L'idPraticien doit être une chaîne alphanumérique.");
        }
        if (!is_string($idPatient) || !ctype_alnum($idPatient)) {
            throw new InvalidArgumentException("L'idPatient doit être une chaîne alphanumérique.");
        }

        // Validation de la date et de l'heure
        if (!$horaire instanceof DateTimeImmutable) {
            throw new InvalidArgumentException("L'horaire doit être une instance de DateTimeImmutable.");
        }

        // Validation de l'identifiant de la spécialité
        if (!is_string($idSpecialite) || !ctype_alnum($idSpecialite)) {
            throw new InvalidArgumentException("L'idSpecialite doit être une chaîne alphanumérique.");
        }

        // Validation du type de RDV (par exemple, vérification d'une valeur dans une liste prédéfinie)
        $validTypes = ['1', '2', '3', '4', '5'];
        if (!in_array($type, $validTypes, true)) {
            throw new InvalidArgumentException("Le type de RDV n'est pas valide.");
        }

        // Validation du statut (par exemple, vérification d'une valeur dans une liste prédéfinie)
        $validStatus = ['en_attente', 'confirmer', 'annule', 'a_payer'];
        if (!in_array($statut, $validStatus, true)) {
            throw new InvalidArgumentException("Le statut du RDV n'est pas valide.");
        }

        // Si toutes les validations passent, on assigne les valeurs
        $this->idPraticien = htmlspecialchars($idPraticien, ENT_QUOTES, 'UTF-8');
        $this->idPatient = htmlspecialchars($idPatient, ENT_QUOTES, 'UTF-8');
        $this->horaire = $horaire;
        $this->idSpecialite = htmlspecialchars($idSpecialite, ENT_QUOTES, 'UTF-8');
        $this->type = $type;
        $this->statut = $statut;
    }
}
