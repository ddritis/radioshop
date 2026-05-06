<?php
// #0 controller/MaintenanceController.php

class MaintenanceController extends BaseController
{

    public function underConstruction()
    {
        // #1 Passo i dati alla view, inclusa l'immagine salvata in public/images/
        $this->renderView('under_construction', [
            'pageTitle' => 'Lavori in Corso',
            'imagePath' => 'public/images/under-construction.png'
        ]);
    }

    // TODO: qui implementare la gestione della pagina "404", GitHub issue #9
}
