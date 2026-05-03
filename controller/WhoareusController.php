<?php
// controller/WhoareusController.php
require_once 'BaseController.php';

class WhoareusController extends BaseController
{
    /**
     * Default action to render the About Us page
     */
    public function index()
    {
        // Render the view without dynamic database data, just the title
        $this->renderView('whoareus', [
            'pageTitle' => 'Chi Siamo - Radioshop'
        ]);
    }
}
