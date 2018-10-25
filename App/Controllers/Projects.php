<?php

/**
 * Projects
 *
 * @author Palash Sharma <hi@palashsharma.com>
 * @copyright 2018 Palash Sharma
 */

namespace App\Controllers;

use \Core\View;
use App\Models\ProjectsModel;

class Projects extends \Core\Controller {

  function before(){
    $this->model = new ProjectsModel(
      ((isset($this->route_params["id"])) ? $this->route_params["id"] : null)
    );
  }

  function allProjectsAction() {
    $this->route_params["projects"] = $this->model->showProjects('all');
    View::renderTemplate("Projects/all-projects.html", $this->route_params);
  }

  function showProjectAction() {
    $this->route_params["project"] = $this->model->showProjects('one');
    View::renderTemplate("Projects/show-project.html", $this->route_params);
  }

  function updateAction() {
    echo ($this->model->updateProjects()) ? "Success" : "Error";
  }

}
