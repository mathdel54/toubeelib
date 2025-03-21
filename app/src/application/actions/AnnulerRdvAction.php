<?php

namespace toubeelib\application\actions;

use toubeelib\core\services\rdv\ServiceRdvInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRdvNotFoundException;

class AnnulerRdvAction extends AbstractAction {

    protected ServiceRdvInterface $serviceRdv;

    public function __construct(ServiceRdvInterface $serviceRdv) {
        $this->serviceRdv = $serviceRdv;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $id = $args["id"];

        try{
            $rdv_DTO = $this->serviceRdv->annulerRdv($id);
        } catch (ServiceRdvNotFoundException $e) {
            $data = [
                 'message' => $e->getMessage(),
                 'exception' => [
                     'type' => get_class($e),
                     'code' => $e->getCode(),
                     'file' => $e->getFile(),
                     'line' => $e->getLine()
                 ]
             ];
             return JsonRenderer::render($rs, 404, $data);
         } catch (\Exception  $e) {
            $data = [
                'message' => $e->getMessage(),
                'exception' => [
                    'type' => get_class($e),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ];
            
            return JsonRenderer::render($rs, 400, $data);
         }

        $data = [
            'rdv' => $rdv_DTO,
            'links' => [
                'self' => [ 'href' => '/Rdvs/' . $id ], 
                'modifer' => [ 'href' => '/Rdvs/' . $id ],
                'annuler' => [ 'href' => '/Rdvs/' . $id ],
            ]
        ];

        return JsonRenderer::render($rs, 202, $data);
    }
}