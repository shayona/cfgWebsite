<?php
require_once '../vendor/autoload.php';
$client = new \Google_Client();
$client->setApplicationName('Coding For Good');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(json_decode(getenv("client_secret"),true));
$sheets = new \Google_Service_Sheets($client);
$projects = [];
$rows = $sheets->spreadsheets_values->get("16g1KX2jPqsU6b0Dwzcg-IqcM4RnyWAWdJ53gCmv-OVo","A2:Z");
if (isset($rows['values'])) {
  foreach ($rows['values'] as $row) {
    if (isset($row[7])&& strtoupper($row[7])=="YES") {
      $desc = explode("\n",$row[10]);
      $row[9] = strtolower(str_replace(' ', '-', $row[9]));
      $projects[$row[9]] = [
          'title' => $row[0],
          'desc' => $desc,
          'client' => $row[2],
      ];
      if (isset($row[12])&&$row[12]!="") $projects[$row[9]]['url']=$row[12];
      if (isset($row[11])&&$row[11]!="") $projects[$row[9]]['img']=$row[11];
    }
  }
}
if (file_put_contents("projects.json",json_encode($projects))) {
  http_response_code(200);
  echo json_encode($projects);
}
