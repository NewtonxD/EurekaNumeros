<?php
include('includesphp/authentication.php');
include('includesphp/conexion.php');

set_time_limit(0);
ignore_user_abort(true);

function formatNumber($number) {
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

function bulkInsertNumbers($numbers) {
    /*$values = implode(',', array_map(function($number) {
        return "(".$number .")";
    }, $numbers));

    $query = "INSERT INTO num (num,nom) VALUES $values";
    return $query;*/
    $chunkSize = 500; // Limit to 500 entries per query
    $queries = [];
    
    // Break the numbers into chunks of $chunkSize
    $chunks = array_chunk($numbers, $chunkSize);

    foreach ($chunks as $chunk) {
        // Prepare values for the current chunk
        $values = implode(',', array_map(function($number) {
            return "(" . $number . ")";
        }, $chunk));

        // Create the query for this chunk
        $query = "INSERT INTO num (num) VALUES $values";
        $queries[] = $query;
    }
    
    return $queries;
}

function detect_csv_delimiter($file_path) {
    $delimiters = [',', ';']; 

    $file_handle = fopen($file_path, 'r');
    if (!$file_handle) {
        return false; 
    }

    $first_line = fgets($file_handle);
    fclose($file_handle);

    $delimiter_count = [];
    foreach ($delimiters as $delimiter) {
        $delimiter_count[$delimiter] = substr_count($first_line, $delimiter);
    }

    $max_occurrence = max($delimiter_count);
    $detected_delimiter = array_search($max_occurrence, $delimiter_count);

    return $detected_delimiter;
}

if (isset($_POST["prefix"])) {
    $prefijo = $_POST["prefix"];
    $repetido = filter_var($_POST["repetido"], FILTER_VALIDATE_BOOLEAN);

    $uploadDir = __DIR__ . '/.upload/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $vcfData = '';
    $txtData = '';
    $cant = 0;
    $cant_rep = 0;
    $numbersToInsert[];
    
    foreach ($_FILES['filenumber']['tmp_name'] as $tmp_filename) {

        $delimiter = detect_csv_delimiter($tmp_filename);
        $file = fopen($tmp_filename, "r");
        
        $connection=connect();
        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {
            $nombre = preg_replace('/[^a-zA-Z]/', '', $row[0]);
            $numero = preg_replace('/[^0-9]/', '', $row[1]);

            $query = "SELECT * FROM num WHERE num LIKE '%$numero%'";
            
            $result = mysqli_query($connection, $query);

            if ($result) {
                if (mysqli_num_rows($result) == 0) {
                    $cant++;
                    $vcfData .= "\r\nBEGIN:VCARD\r\n";
                    $vcfData .= "VERSION:2.1\r\n";
                    $vcfData .= "N:" . $nombre . ";" . $prefijo . ";" . formatNumber($cant) . ";;\r\n";
                    $vcfData .= "FN:" . $prefijo . " " . formatNumber($cant) . " " . $nombre . "\r\n";
                    $vcfData .= "TEL;TYPE=CELL:+" . $numero . "\r\n";
                    $vcfData .= "END:VCARD";

                    if($txtData!=""){
                        $txtData.="\n".$numero;
                    }else{ 
                        $txtData.=$numero; 
                    }

                    // Collect numbers for bulk insertion
                    $numbersToInsert[] = "'+".$numero."','".$prefijo." " .formatNumber($cant)." ".$nombre."'";
                } else {
                    if ($repetido) {
                        $cant_rep++;
                        $vcfData .= "\r\nBEGIN:VCARD\r\n";
                        $vcfData .= "VERSION:2.1\r\n";
                        $vcfData .= "N:" . $nombre . ";Rep" . $prefijo . ";" . formatNumber($cant_rep) . ";;\r\n";
                        $vcfData .= "FN:Rep" . $prefijo . " " . formatNumber($cant_rep) . " " . $nombre . "\r\n";
                        $vcfData .= "TEL;TYPE=CELL:+" . $numero . "\r\n";
                        $vcfData .= "END:VCARD";
                    }
                }
            }
        }
        mysqli_close($connection);

        fclose($file);

    }
    
    


    $filename = uniqid('contact_') . '-' . $prefijo . '.txt';
    $filePath = $uploadDir . $filename;
    file_put_contents($filePath, $txtData);

    $filename = uniqid('contact_') . '-' . $prefijo . '.vcf';
    $filePath = $uploadDir . $filename;
    file_put_contents($filePath, $vcfData);
    
    
    // Bulk insert numbers
    $queries = bulkInsertNumbers($numbersToInsert);
    foreach ($queries as $query) {
        // Execute each query
        // mysqli_query($conn, $query);
        $connection=connect();
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    header('Content-Type: text/x-vcard');
    header('Content-Disposition: attachment; filename="' . $filename . '.vcf"');
    echo $vcfData;
}

?>
