<?php
// Set the header to return JSON
header('Content-Type: application/json');

//Allow CORS policy for fruitask.com only
//Implement $_GET['token'] for extra authorization

// Example logic or data
$data = [
    'type' => 'remote',
    'dbname' => 'bngcdb',
    'username' => 'root',
    'port' => 3306, //make sure the port exist INBOUND
    'password' => 'liik0egorecducxl', //this is user password permission
    'location' => '72.60.43.106', //ip or host domain
    'timestamp' => date('Y-m-d H:i:s'),
    'disk_storage' => 'https://bngcbe-bngcapp-ozrark-e8c535-72-60-43-106.traefik.me/upload.php',
    'gallery_url' => 'https://bngcbe-bngcapp-ozrark-e8c535-72-60-43-106.traefik.me/gallery.php',
    'base_url' => 'https://bngcbe-bngcapp-ozrark-e8c535-72-60-43-106.traefik.me/'
];

// Return as JSON
echo json_encode($data, JSON_PRETTY_PRINT);
