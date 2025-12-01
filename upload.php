<?php
// -----------------------------------------
// File Upload Script (Disk Storage)
// -----------------------------------------

//Provide authentication if you need

// Where to save the uploaded files
$uploadDir = __DIR__ . "/remote/";

// Create folder if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Check if file was uploaded properly
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "status" => "error",
        "message" => "No file uploaded or upload error."
    ]);
    exit;
}

$file = $_FILES['file'];

// Limit to 50 MB (adjust as needed)
$maxSize = 50 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    echo json_encode([
        "status" => "error",
        "message" => "File is too large. Maximum allowed is 50MB."
    ]);
    exit;
}

// Allowed extensions
$allowed = ['jpg','jpeg','png','gif','webp','pdf','mp4','mov','txt','json'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid file type."
    ]);
    exit;
}

// Generate safe filename
$uniqueName = uniqid() . "-" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $file['name']);
$destination = $uploadDir . $uniqueName;

// Move uploaded file to disk storage
if (move_uploaded_file($file['tmp_name'], $destination)) {

    // Public URL (adjust to your domain)
    $publicUrl = "https://example.com/api/remote/" . $uniqueName;

    echo json_encode([
        "status" => "success",
        "file" => $uniqueName,
        "url" => $publicUrl
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save the file."
    ]);
}
