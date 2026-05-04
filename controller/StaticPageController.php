<?php
// controller/StaticPageController.php

class StaticPageController extends BaseController
{
    /**
     * Visualizza la Privacy Policy
     * Rotta: index.php?page=staticPage&action=privacy
     */
    public function privacy()
    {
        $this->renderView('privacy', [
            'pageTitle' => 'Privacy Policy - RADIOSHOP'
        ]);
    }

    /**
     * Visualizza la pagina Chi Siamo
     * Rotta: index.php?page=staticPage&action=about
     */
    public function about()
    {
        $this->renderView('about', [
            'pageTitle' => 'Chi Siamo - RADIOSHOP'
        ]);
    }
}
