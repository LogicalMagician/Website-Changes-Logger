<?php

// Set the URL to check
$url = "http://example.com";

// Set the SOCKS5 proxy settings
$proxy_host = "proxy.example.com";
$proxy_port = 1080;
$proxy_user = "username";
$proxy_pass = "password";

// Define the function to send the HTTP request using SOCKS5 proxy
function send_request($url, $proxy_host, $proxy_port, $proxy_user, $proxy_pass) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PROXY, $proxy_host);
    curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$proxy_user:$proxy_pass");
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

// Define the function to check for changes in the web page
function check_changes($url, $proxy_host, $proxy_port, $proxy_user, $proxy_pass) {
    // Load the current version of the web page
    $current_content = send_request($url, $proxy_host, $proxy_port, $proxy_user, $proxy_pass);

    // Load the previous version of the web page
    $previous_content = file_get_contents("current.txt");

    // Check for changes
    $changes = diff($previous_content, $current_content);
    if (strlen($changes) > 0) {
        // Save the changes to a text file
        file_put_contents("changes.txt", $changes);

        // Print the changes to the console
        echo $changes;

        // Save the current version of the web page
        file_put_contents("current.txt", $current_content);
    }
}

// Define the diff function
function diff($old, $new) {
    $old_lines = explode("\n", $old);
    $new_lines = explode("\n", $new);
    $matrix = array();

    for ($i = 0; $i <= count($old_lines); $i++) {
        $matrix[$i] = array();
        for ($j = 0; $j <= count($new_lines); $j++) {
            $matrix[$i][$j] = 0;
        }
    }

    for ($i = 1; $i <= count($old_lines); $i++) {
        for ($j = 1; $j <= count($new_lines); $j++) {
            if ($old_lines[$i - 1] == $new_lines[$j - 1]) {
                $matrix[$i][$j] = $matrix[$i - 1][$j - 1] + 1;
            } else {
                $matrix[$i][$j] = max($matrix[$i - 1][$j], $matrix[$i][$j - 1]);
            }
        }
    }

    $i = count($old_lines);
    $j = count($new_lines);
    $diff = "";

    while ($i > 0 || $j > 0) {
        if ($i > 0 && $j > 0 && $old_lines[$i - 1] == $new_lines[$j - 1]) {
            $diff = "\n" . $old_lines[$i - 1] . $diff;
            $i--;
            $j--;
        } else if ($j > 0 && $matrix[$i][$j] ==
    } else if ($j > 0 && $matrix[$i][$j] == $matrix[$i][$j - 1]) {
            $diff = "\n+" . $new_lines[$j - 1] . $diff;
            $j--;
        } else {
            $diff = "\n-" . $old_lines[$i - 1] . $diff;
            $i--;
        }
    }

    return $diff;
}

// Define the main function
function main() {
    // Check for changes every 24 hours
    while (true) {
        check_changes($GLOBALS['url'], $GLOBALS['proxy_host'], $GLOBALS['proxy_port'], $GLOBALS['proxy_user'], $GLOBALS['proxy_pass']);
        sleep(86400);
    }
}

// Call the main function
main();
