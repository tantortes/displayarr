<?php
$plugin_name = "sonarr-widget";
$cfg_file = "/boot/config/plugins/$plugin_name/$plugin_name.cfg";

// Load existing settings if they exist
if (file_exists($cfg_file)) {
    $var = parse_ini_file($cfg_file);
}

[span_7](start_span)// Map variables to global scope for the API client[span_7](end_span)
$sonarr_url = $var['sonarr_url'] ?? "";
$sonarr_api_key = $var['sonarr_api_key'] ?? "";
$refresh_interval = $var['refresh_interval'] ?? 60000;

// Update logic: When 'Apply' is pressed
if ($_POST['sonarr_url']) {
    $new_cfg['sonarr_url'] = $_POST['sonarr_url'];
    $new_cfg['sonarr_api_key'] = $_POST['sonarr_api_key'];
    $new_cfg['refresh_interval'] = $_POST['refresh_interval'];
    
    // Save to the flash drive
    write_ini_file($cfg_file, $new_cfg);
}

// Helper to write INI files
function write_ini_file($file, $array) {
    $res = array();
    foreach($array as $key => $val) {
        $res[] = "$key = \"$val\"";
    }
    file_put_contents($file, implode("\r\n", $res));
}
?>
