<?php

include('includesphp/conexion.php');

function formatNumber($number) {
    // Check if the number is less than 10
    if ($number < 10) {
        // If so, prepend '0' to the number
        return '0' . $number;
    } else {
        // Otherwise, return the number as it is
        return $number;
    }
}

// Function to detect CSV delimiter
function detect_csv_delimiter($file_path) {
    $delimiters = [',', ';']; // Possible CSV delimiters

    // Open the file
    $file_handle = fopen($file_path, 'r');
    if (!$file_handle) {
        return false; // Unable to open file
    }

    // Read the first line of the file
    $first_line = fgets($file_handle);
    fclose($file_handle);

    // Check which delimiter occurs more in the first line
    $delimiter_count = [];
    foreach ($delimiters as $delimiter) {
        $delimiter_count[$delimiter] = substr_count($first_line, $delimiter);
    }

    // Get the delimiter with the maximum occurrence
    $max_occurrence = max($delimiter_count);
    $detected_delimiter = array_search($max_occurrence, $delimiter_count);

    return $detected_delimiter;
}

if( isset($_POST["prefix"]) ){

    $cant=0;
    $cant_rep=0;
    $prefijo=$_POST["prefix"];
    

    $vcffile="";
    //if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
    foreach ($_FILES['filenumber']['tmp_name'] as $key => $tmp_filename) {
        $tmp_name = $_FILES['filenumber']['tmp_name'][$key];
        // Retrieve the original file name
        //$name = $_FILES['filenumber']['name'];
        
        $delimiter=detect_csv_delimiter($tmp_name);
        if ($delimiter !== false) {
            $file = fopen($tmp_name, "r");
            if($file){
                $first=0;
    
                while (($row = fgetcsv($file,0,$delimiter)) !== false) {
                    
                    if($first>0){
                        $col=0;
                        $nombre="";
                        $numero="";
                        foreach ($row as $column) {
                            if($col==0){
                                $nombre=preg_replace('/[^a-zA-Z]/', '',$column);
                            }
                            if($col==1){
                                $numero=preg_replace('/[^0-9]/', '',$column);
                            }
                            $col++;
                        }
    
                        $query="SELECT * FROM num WHERE num like '%$numero%'";
                        $result= mysqli_query($connection,$query);
    
                        if(!$result) {
                            die('Query Error 1 ' . mysqli_error($connection));
                        }else{
    
                            if(mysqli_num_rows($result)==0){
        
                                $query="INSERT INTO num (num) VALUES ('+".$numero."')";
                                $result= mysqli_query($connection,$query);
        
                                if(!$result) {
                                    die('Query Error 2 ' . mysqli_error($connection));
                                }
                                $cant++;
                                
                                $vcffile .= "\r\nBEGIN:VCARD\r\n";
                                $vcffile .= "VERSION:2.1\r\n";
                                $vcffile .= "N:".$nombre.";".$prefijo.";".formatNumber($cant).";;\r\n";
                                $vcffile .= "FN:".$prefijo." ".formatNumber($cant)." ".$nombre."\r\n";
                                $vcffile .= "TEL;TYPE=CELL:+".$numero."\r\n";
                                $vcffile .= "END:VCARD";
        
                            }else{
                                //nada nananina con ese numero
                                $cant_rep++;
                                
                                $vcffile .= "\r\nBEGIN:VCARD\r\n";
                                $vcffile .= "VERSION:2.1\r\n";
                                $vcffile .= "N:".$nombre.";Rep".$prefijo.";".formatNumber($cant_rep).";;\r\n";
                                $vcffile .= "FN:Rep".$prefijo." ".formatNumber($cant_rep)." ".$nombre."\r\n";
                                $vcffile .= "TEL;TYPE=CELL:+".$numero."\r\n";
                                $vcffile .= "END:VCARD";
                            }
                            
                        }
    
                    }
                    $first++;
                }
    
                fclose($file);
            }
        }
    }

    $uploadDir = __DIR__ . '/.upload/';
    
    // Create upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }


    // Generate unique filename
    $filename = uniqid('contact_').'-'.$prefijo.'.vcf';
    $filePath = $uploadDir . $filename;

    // Save vCard file
    file_put_contents($filePath, $vcffile);

    header('Content-Type: text/x-vcard');
    header('Content-Disposition: attachment; filename="'.$filename.'.vcf"');

    // Output the generated vCard data
    echo $vcffile;

}

?>