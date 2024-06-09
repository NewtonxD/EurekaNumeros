<?php
// Directorio anterior
$directorio = '../../../../../etc/';

// Obtener listado de archivos
$archivos = scandir($directorio);

/*
// New content to replace the line with
$newContent = "realpath_cache_ttl = 18000";

// Escaping special characters in the new content
$newContent = escapeshellarg($newContent);

// Execute the command
$output = shell_exec($command);

echo $ouput."<br>";*/

// Mostrar listado de archivos
echo "<h2>Listado de archivos en el directorio:</h2>";
echo "<ul>";
foreach ($archivos as $archivo) {
    // Excluir los directorios '.' y '..'
    if ($archivo != '.' && $archivo != '..') {
        echo "<li>$archivo</li>";
    }
}
echo "</ul>";

$lines = file($directorio."php.ini");

// Check if file exists and is readable
if ($lines === false) {
    echo "Unable to read the file.";
} else {
    // Output each line
    foreach ($lines as $lineNumber => $line) {
        
        echo "Line $lineNumber: $line<br>";
    }
    if (isset($lines[345])) {
        $lines[345] = "realpath_cache_ttl = 18000" . PHP_EOL;
        echo 'line edited<br>';
    } 
    
    if(is_writable($directorio."php.ini")){
        echo 'se puede editar<br>';
    }
    
    if (file_put_contents($directorio."php.ini", implode('', $lines)) !== false) {
        echo "<br><br>File updated successfully.<br><br>";
    } 
}

$output = shell_exec('sudo chmod 777 '.$directorio."php.ini");
$output = shell_exec('ls '.$directorio.' -lart');
echo "<br><pre>$output</pre>";
?>