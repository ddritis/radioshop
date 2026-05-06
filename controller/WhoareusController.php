<?php
// #0 controller/WhoareusController.php
require_once 'BaseController.php';

class WhoareusController extends BaseController
{
    /**
     * Azione di default per renderizzare la pagina "Chi siamo" (about)
     */
    public function index()
    {
        // #1 Renderizzo la view senza dati dal DB, passo solo il titolo            
        $this->renderView('whoareus', [
            'pageTitle' => 'Chi siamo - Radioshop'
        ]);
    }
}
