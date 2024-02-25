<?php
$uploadDir = __DIR__ . '/.upload/';

// Get list of files in upload directory
$files = [];
if (is_dir($uploadDir)){
    $files = scandir($uploadDir);
}
// Remove . and .. from file list
if($files!==false){
    $files = array_diff($files, array('.', '..'));
}

// Get file creation dates
$fileList = [];
foreach ($files as $filename) {
    $filePath = $uploadDir . $filename;
    $creationDate = date('Y-m-d H:i:s', filectime($filePath));
    $fileList[] = [
        'filename' => $filename,
        'creation_date' => $creationDate
    ];
}

// Return file list as JSON
header('Content-Type: application/json');
echo json_encode($fileList);
?>
