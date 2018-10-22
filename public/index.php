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

    $params["projects"] = json_decode(file_get_contents("https://script.googleusercontent.com/macros/echo?user_content_key=E1icTPJPDXCJsOPTKHSK_0SdD-DQ7CfI0zQUa_9PAuigOz9BMmmbpZUwUK3cq4I1caNyqq1mt7EnRzMGwRU6D6RjcKkXWw1_m5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnJK4DgJ2qkfav5JQj27i5FfvFF4kxUm2jiUROOUi_SO2e9Gfj4XcOcBxtIS9z7MUuHSTNzgsg0p2&lib=MlwJGesRDLu0emjvioR11_UAcCTvbymtO"), true);

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
