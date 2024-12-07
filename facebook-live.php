<?php
// Configuration
$access_token = 'YOUR_ACCESS_TOKEN';
$page_id = 'YOUR_FACEBOOK_PAGE_ID'; // Replace with your page ID
$api_url = "https://graph.facebook.com/v19.0/$page_id/live_videos?access_token=$access_token";

$json_file = __DIR__ . '/facebook-live.json'; // Path to save the JSON file

// Fetch live video data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Validate response
if ($response) {
    $data = json_decode($response, true);

    // Add cache-busting parameter
    $data['cache_bust'] = time(); // Use a timestamp as the cache-busting token

    // Save response to file
    if (isset($data) && json_last_error() === JSON_ERROR_NONE) {
        file_put_contents($json_file, json_encode($data));
        echo "Live video data updated successfully.\n";
    } else {
        echo "Invalid JSON response from Facebook API.\n";
    }
} else {
    echo "Failed to fetch data from Facebook API.\n";
}
?>
