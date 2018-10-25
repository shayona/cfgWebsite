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
    $this->route_params["projects"] = $this->model->showProjects();
    View::renderTemplate("Projects/all-projects.html", $this->route_params);
  }

  function showProjectAction() {
    $this->route_params["project"] = $this->model->showProjects('one');
    View::renderTemplate("Projects/show-project.html", $this->route_params);
  }

  function updateAction() {
    if ($this->model->updateProjects()) {
      http_response_code(500);
      echo "Success";
    }else {
      http_response_code(200);
      echo "Error";
    }
  }

}
