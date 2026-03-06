<?php
// Load configuration and the request helper function
require_once "../include/settings.php";
require_once "../include/sonarr_client.php";

[span_4](start_span)[span_5](start_span)// Fetch data from Sonarr API v3 endpoints[span_4](end_span)[span_5](end_span)
$series = sonarr_request("series");
$episodes = sonarr_request("episode");
$queue = sonarr_request("queue");

[span_6](start_span)[span_7](start_span)// Initialize counters for the iteration[span_6](end_span)[span_7](end_span)
$totalEpisodes = 0;
$missingEpisodes = 0;

[span_8](start_span)[span_9](start_span)// Process episode data[span_8](end_span)[span_9](end_span)
if (is_array($episodes)) {
    foreach ($episodes as $ep) {
        $totalEpisodes++;
        [span_10](start_span)[span_11](start_span)// Logic for "Missing": No file present AND the episode is monitored[span_10](end_span)[span_11](end_span)
        if (!$ep['hasFile'] && $ep['monitored']) {
            $missingEpisodes++;
        }
    }
}

[span_12](start_span)[span_13](start_span)// Prepare the normalized response[span_12](end_span)[span_13](end_span)
$response = [
    "series"       => is_array($series) ? count($series) : 0,
    "episodes"     => $totalEpisodes,
    "missing"      => $missingEpisodes,
    "downloading"  => is_array($queue) ? count($queue) : 0,
    "queue"        => is_array($queue) ? count($queue) : 0,
    "last_updated" => time()
];

[span_14](start_span)[span_15](start_span)// Return JSON for the JavaScript widget[span_14](end_span)[span_15](end_span)
header('Content-Type: application/json');
echo json_encode($response);
?>
