<?php
// controller/MaintenanceController.php

class MaintenanceController extends BaseController
{

    public function underConstruction()
    {
        // Passiamo i dati alla view, inclusa l'immagine salvata in public/images/
        $this->renderView('under_construction', [
            'pageTitle' => 'Lavori in Corso',
            'imagePath' => 'public/images/under-construction.png'
        ]);
    }
}
