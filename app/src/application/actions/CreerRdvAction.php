<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\dto\InputRdvDTO;

class CreerRdvAction extends AbstractAction {

    protected ServiceRdvInterface $serviceRdv;

    public function __construct(ServiceRdvInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke (ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {

        try {
            $idPraticien = $rq->getParsedBody()["idPraticien"] ?? null;
            $idPatient = $rq->getParsedBody()["idPatient"] ?? null;
            $horaireData = $rq->getParsedBody()["horaire"] ?? null;
            $idSpecialite = $rq->getParsedBody()["idSpecialite"] ?? null;            
            $type = $rq->getParsedBody()["type"] ?? null;
            $statut = $rq->getParsedBody()["statut"] ?? null;

            $horaire = new \DateTimeImmutable($horaireData['date'], new \DateTimeZone($horaireData['timezone']));

            $inputRdvDTO = new InputRdvDTO($idPraticien, $idPatient, $horaire, $idSpecialite, $type, $statut);
            $rdv_DTO = $this->serviceRdv->creerRdv($inputRdvDTO);


        } catch (\Exception $e) {
            $rs->getBody()->write($e->getMessage());
            return $rs->withStatus(404);
        }


        return JsonRenderer::render($rs, 200);

    }
}