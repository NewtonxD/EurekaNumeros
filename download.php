<?php
include('includesphp/authentication.php');
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filePath = __DIR__ . '/.upload/' . $filename;

    if (file_exists($filePath)) {
        // Set headers to force download
        header('Content-Type: text/x-vcard');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filePath);
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Filename not specified.';
}
?>
