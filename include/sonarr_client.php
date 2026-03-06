  function sonarr_request($endpoint) {
      $url = $GLOBALS['sonarr_url'] . "/api/v3/" . $endpoint;
      $opts = ["http" => ["method" => "GET", "header" => "X-Api-Key: " .
  $GLOBALS['sonarr_api_key']]];
      $context = stream_context_create($opts);
      $result = file_get_contents($url, false, $context);
           5

       return json_decode($result, true);
  }