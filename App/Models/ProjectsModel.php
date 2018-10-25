<?php

/**
 * ProjectsModel
 *
 * @author Palash Sharma <hi@palashsharma.com>
 * @copyright 2018 Palash Sharma
 */

namespace App\Models;

class ProjectsModel {

  public $id;
  public $projects;

  function __construct($id) {
    if (isset($id)) {
      $this->id = $id;
    }
  }

  function showProjects($data = null) {

    if (file_exists('../p.json')) {
      $this->projects = json_decode(file_get_contents('../p.json'), true);
    }

    if (!isset($projects)) {
      $this->updateProjects();
    }

    switch ($data) {
      case 'one':
        $output = $this->projects[$this->id];
        break;
      default:
        $output = $this->projects;
        break;
    }

    return $output;
  }

  function updateProjects() {
    $this->projects = json_decode(file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=E1icTPJPDXCJsOPTKHSK_0SdD-DQ7CfI0zQUa_9PAuigOz9BMmmbpZUwUK3cq4I1caNyqq1mt7EnRzMGwRU6D6RjcKkXWw1_m5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnJK4DgJ2qkfav5JQj27i5FfvFF4kxUm2jiUROOUi_SO2e9Gfj4XcOcBxtIS9z7MUuHSTNzgsg0p2&lib=MlwJGesRDLu0emjvioR11_UAcCTvbymtO"), true);
    return file_put_contents('../p.json', json_encode($this->projects));
  }

}
