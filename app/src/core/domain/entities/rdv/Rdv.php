<?php

namespace toubeelib\core\domain\entities\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RdvDTO;

class Rdv extends Entity
{
    protected string $idPraticien;
    protected string $idPatient;
    protected DateTimeImmutable $horaire;
    protected string $idSpecialite;
    protected string $type;
    protected string $statut;

    public function __construct($praticien, $patient, $horaire, $specialite, $type, $statut)
    {
        $this->idPraticien = $praticien;
        $this->idPatient = $patient;
        $this->horaire = $horaire;
        $this->idSpecialite = $specialite;
        $this->type = $type;
        $this->statut = $statut;
    }

    public function toDTO() : RdvDTO {
        return new RdvDTO($this->ID, $this->idPraticien, $this->idPatient, $this->horaire, $this->idSpecialite, $this->type, $this->statut);
    }
}