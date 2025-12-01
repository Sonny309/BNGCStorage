<?php

// ---------------------------
// CONFIG
// ---------------------------
$baseDirectory = __DIR__ . "/remote";     // Folder where files are stored
$baseUrl = "https://example.com/api/remote"; // Public URL base path


// ---------------------------
// FUNCTION: Get All Files
// ---------------------------
function getAllFiles($directory, $baseUrl)
{
    if (!is_dir($directory)) {
        return [
            "status" => "error",
            "message" => "Directory not found",
            "files" => []
        ];
    }

    $files = [];
    $dirFiles = scandir($directory);

    foreach ($dirFiles as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $directory . "/" . $file;

        if (is_file($filePath)) {
            $files[] = [
                "name" => $file,
                "extension" => pathinfo($file, PATHINFO_EXTENSION),
                "size_bytes" => filesize($filePath),
                "size_readable" => formatBytes(filesize($filePath)),
                "url" => rtrim($baseUrl, "/") . "/" . $file
            ];
        }
    }

    return [
        "status" => "success",
        "total" => count($files),
        "files" => $files
    ];
}


// ---------------------------
// HELPER: Convert bytes → readable
// ---------------------------
function formatBytes($bytes)
{
    $sizes = ["B", "KB", "MB", "GB", "TB"];
    $i = 0;
    while ($bytes >= 1024 && $i < count($sizes) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . " " . $sizes[$i];
}


// ---------------------------
// API OUTPUT
// ---------------------------
header('Content-Type: application/json');
echo json_encode(getAllFiles($baseDirectory, $baseUrl), JSON_PRETTY_PRINT);

?>
