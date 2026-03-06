  <?php

function sonarr_request($endpoint, $url, $apikey) {

    $full = rtrim($url,'/') . "/api/v3/" . $endpoint;

    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "X-Api-Key: $apikey\r\n",
            "timeout" => 5
        ]
    ];

    $context = stream_context_create($opts);

    $result = @file_get_contents($full, false, $context);

    if ($result === false) {
        return null;
    }

    return json_decode($result, true);
}
