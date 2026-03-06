<?php

require_once __DIR__ . "/../include/sonarr_client.php";

$config = parse_ini_file("/boot/config/plugins/sonarr-widget/settings.cfg");

$sonarr_url = $config['url'];
$sonarr_api = $config['apikey'];

$series = sonarr_request("series", $sonarr_url, $sonarr_api);
$episodes = sonarr_request("episode", $sonarr_url, $sonarr_api);
$queue = sonarr_request("queue", $sonarr_url, $sonarr_api);

if (!$series || !$episodes || !$queue) {
    echo json_encode(["status"=>"offline"]);
    exit;
}

$totalEpisodes = 0;
$missingEpisodes = 0;

foreach ($episodes as $ep) {

    $totalEpisodes++;

    if (!$ep['hasFile'] && $ep['monitored']) {
        $missingEpisodes++;
    }

}

$response = [
    "series" => count($series),
    "episodes" => $totalEpisodes,
    "missing" => $missingEpisodes,
    "downloading" => count($queue),
    "queue" => count($queue),
    "last_updated" => time()
];

header("Content-Type: application/json");
echo json_encode($response);
