<?php
// Bypass caching
if (!isset($_GET['timestamp'])) {
    header('Location: get-current-embed.php?timestamp=' . time());
    exit;
}
$json_file = __DIR__ . '/facebook-live.json'; // Path to the JSON file

// Check if the file exists and read data
if (file_exists($json_file)) {
    $data = json_decode(file_get_contents($json_file), true);

    if (isset($data['data']) && is_array($data['data'])) {
        foreach ($data['data'] as $video) {
            if (isset($video['status']) && $video['status'] === 'LIVE' && isset($video['embed_html'])) {
                // Extract embed URL
                preg_match('/src="([^"]+)"/', $video['embed_html'], $matches);
                $url = $matches[1] ?? '';

                if ($url) {
                    // Append cache-busting parameter
                    $cache_bust = $data['cache_bust'] ?? time();
                    $url .= (strpos($url, '?') === false ? '?' : '&') . "cache_bust=$cache_bust";

                    echo <<<HTML
                    <div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%; overflow: hidden;">
                        <iframe src="$url" 
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" 
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen>
                        </iframe>
                    </div>
                    HTML;
                    exit;
                }
            }
        }
    }
}

// Fallback banner
echo <<<HTML
<div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%; overflow: hidden;">
    <img src="https://conference.wolim.org/wp-content/uploads/2024/11/wcc-2024-banner.jpg" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" 
         alt="No live stream available">
</div>
HTML;
?>
