<?php

namespace App\Controllers;

use \Core\View;

/**
 * Expenses controller
 *
 * PHP version 7.0
 */
class Expenses extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Expenses/index.html');
    }
}
