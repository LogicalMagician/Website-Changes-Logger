Overview
This PHP script sends a request to a specified web page every day using SOCKS5 proxies, checks for changes in the web page, and prints out the changes that have been made on the website into a text file every 24 hours.

Requirements
To run this script, you need to have PHP installed on your system. You also need to have access to a SOCKS5 proxy server that you can use to connect to the internet.

Configuration
Before running the script, you need to configure the following settings in the config.php file:

$url: The URL of the web page that you want to monitor for changes.
$proxy_host: The hostname or IP address of the SOCKS5 proxy server.
$proxy_port: The port number of the SOCKS5 proxy server.
$proxy_user: The username (if any) to use for authentication with the SOCKS5 proxy server.
$proxy_pass: The password (if any) to use for authentication with the SOCKS5 proxy server.
$output_file: The name of the file where the changes will be written to.
Usage
To run the script, simply run the following command:

Copy code
php monitor.php
The script will connect to the web page specified in the config.php file using the SOCKS5 proxy server specified in the same file. It will check for changes in the web page and write any new changes to the file specified in the config.php file.

The script will continue to run indefinitely, checking for changes every 24 hours.
