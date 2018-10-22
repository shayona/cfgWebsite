<?php
session_start();

require_once '../vendor/autoload.php';

$pages = [
  "home"=>"Home",
  "projects"=>"Our Projects",
  "contact"=>"Contact Us",
];

$page = $_GET['page'];

$title = $pages[$page];

$params = [
  "pages" => $pages,
  "page" => $page,
  "title" => $title
];

if (array_key_exists($page,$pages)) {

  if ($page == "projects") {

    $params["projects"] = "";

    if (file_exists("projects.json")) {
      $params["projects"] = json_decode(file_get_contents("projects.json"),true);
    }

    if ($params["projects"] == "") {
      ob_start();
      require_once 'updateProjects.php';
      $params["projects"] = json_decode(ob_get_clean(),true);
    }

    if (isset($_GET['id'])) {

      $id = $_GET['id'];

      if (isset($params["projects"][$id])) {
        $params["id"] = $id;
      }else {
        $page = "404";
      }

    }

  }

} else {
  $page = "404";
}

$loader = new \Twig_Loader_Filesystem('../Views');
$twig = new \Twig_Environment($loader);
echo $twig->render("$page.html", $params);
