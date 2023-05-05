<?php

namespace App\Controllers;

use \Core\View;

/**
 * Balance controller
 *
 * PHP version 7.0
 */
class Balance extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Balance/index.html');
    }
}
