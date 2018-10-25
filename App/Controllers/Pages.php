<?php

/**
 * Pages
 *
 * @author Palash Sharma <hi@palashsharma.com>
 * @copyright 2018 Palash Sharma
 */

namespace App\Controllers;

use \Core\View;

class Pages extends \Core\Controller {

  function showPageAction() {
    $page = $this->route_params['page'];
    View::renderTemplate("Pages/$page.html", $this->route_params);
  }

}
