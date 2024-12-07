This repository contains a simple solution for embedding a Facebook Live video directly into the Church Online Platform or any webpage. By using a cron job to fetch live video data every 60 seconds, the solution minimizes Facebook API usage while providing an automatic and dynamic embed experience.

Features
--------

*   Automatically fetches and embeds the latest Facebook Live video.
    
*   Bypasses Facebook API rate limits by caching results in a JSON file.
    
*   Ensures dynamic updates by appending cache-busting query strings to URLs.
    
*   Includes a fallback banner for when no live stream is available.
    
*   Optimized for the Church Online Platform but flexible for general use.
    

Files Overview
--------------

### 1\. facebook-live.php

This script fetches live video data from the Facebook Graph API and saves it to a local JSON file (facebook-live.json).**Key features:**

*   Runs via a cron job every 60 seconds.
    
*   Requires a Facebook Page Access Token and Page ID.
    

### 2\. get-current-embed.php

This script reads the saved JSON file, extracts the live video embed URL, and renders an iframe for embedding. If no live stream is available, a fallback banner is displayed.**Key features:**

*   Automatically bypasses caching issues by appending a unique timestamp to each request.
    
*   Serves the embed code dynamically.
    

### 3\. iframe.html

A lightweight HTML file containing an iframe that references get-current-embed.php. This file is ideal for use in the Church Online Platform's "Embed Code" section.

### 4\. fallback-banner.jpg

A static image displayed when no live stream is available. You can replace this with your church's custom banner.

Setup Instructions
------------------

### Prerequisites

1.  A **Facebook Page Access Token** with the required permissions to access live videos.
    
2.  The **Facebook Page ID** where live streams are hosted.
    
3.  A web server with PHP support and the ability to set up cron jobs.
    

### Steps to Set Up

#### 1\. Clone the Repository

Clone or download the repository files into your web server's document root.

#### 2\. Configure facebook-live.php
```
$access\_token = 'YOUR\_ACCESS\_TOKEN';
$page\_id = 'YOUR\_FACEBOOK\_PAGE\_ID';
```

#### 3\. Set Up a Cron Job

Schedule facebook-live.php to run every minute to fetch the latest live video data.Example cron job:

`* * * * * /usr/bin/php /path/to/facebook-live.php`

#### 4\. Update the Embed Code in Church Online Platform

*   Copy the contents of iframe.html.
    
*   Paste it into the "Embed Code" section for your service on the Church Online Platform.
    

#### 5\. Replace fallback-banner.jpg

Replace the provided fallback-banner.jpg with your custom image for when no live stream is available.

How It Works
------------

1.  **Fetching Live Data**:The facebook-live.php script queries the Facebook Graph API every 60 seconds to check for live videos and saves the results in facebook-live.json.
    
2.  **Dynamic Embedding**:When get-current-embed.php is accessed, it checks for a live video in the JSON file. If a live video is found:
    
    *   The embed URL is extracted and displayed in an iframe.
        
    *   A cache-busting query string is appended to the URL to bypass caching.
        
3.  **Fallback Mechanism**:If no live video is found, the script displays a fallback banner.
    

Example Use Case
----------------

### For Church Online Platform

*   Copy the iframe.html contents into the "Embed Code" section of a Church Online Platform service.
    
*   When a live stream starts, the platform will automatically display the live video. If no live stream is active, the fallback banner will be shown.
    

Customization
-------------

### Banner

Replace fallback-banner.jpg with your custom image for branding or announcements.

### Styling

Update the inline styles in iframe.html or get-current-embed.php to match your website's design.

### API Frequency

Adjust the cron job frequency to control how often the live data is fetched (default: every 60 seconds).

Troubleshooting
---------------

### 1\. No Live Stream Displayed

*   Ensure the Access Token has the necessary permissions.
    
*   Confirm the Facebook Page ID is correct.
    
*   Verify the cron job is running correctly.
    

### 2\. Caching Issues

The code includes a timestamp-based cache-busting mechanism. Ensure your server allows redirection headers for this to work.

Notes
-----

*   This project uses Facebook's Graph API v19.0 as of the time of writing. Ensure you check for API version updates.
    
*   Facebook API rate limits apply. This solution keeps calls to a maximum of 60 per hour (1 per minute).
    

License
-------

This project is licensed under the MIT License. You are free to use, modify, and distribute this code.

Happy embedding! 🎥
