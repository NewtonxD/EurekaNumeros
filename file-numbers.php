<?php

include('includesphp/conexion.php');
/*
if( isset($_POST["prefix"]) ){

    $cant=0;
    $prefijo=$_POST["prefix"];
    
    $files_vcf= array();
    $vcffile="";
    //if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
    foreach ($_FILES['filenumber']['tmp_name'] as $key => $tmp_filename) {
        $tmp_name = $_FILES['filenumber']['tmp_name'][$key];
        // Retrieve the original file name
        //$name = $_FILES['filenumber']['name'];

        $file = fopen($tmp_name, "r");
        if($file){
            $first=0;

            while (($row = fgetcsv($file)) !== false) {
                
                if($first>0){
                    $col=0;
                    $nombre="";
                    $numero="";
                    foreach ($row as $column) {
                        if($col==0){
                            $nombre=preg_replace('/[^a-zA-Z0-9]/', '',$column);
                        }else{
                            $numero=preg_replace('/[^a-zA-Z0-9]/', '',$column);
                        }
                        $col++;
                    }

                    $query="SELECT * FROM num WHERE num like '%$numero%'";
                    $result= mysqli_query($connection,$query);

                    if(!$result) {
                        die('Query Error 1 ' . mysqli_error($connection));
                    }

                    if(mysqli_num_rows($result)==0){

                        $query="INSERT INTO num (num) VALUES ('+".$numero."')";
                        $result= mysqli_query($connection,$query);

                        if(!$result) {
                            die('Query Error 2 ' . mysqli_error($connection));
                        }
                        $cant++;
                        

                       /* BEGIN:VCARD
                        VERSION:2.1
                        N:Howard;Ja;40;;
                        FN:Ja 40 Howard
                        TEL;CELL;PREF:+36305637070
                        END:VCARD

                        
                        $vcffile .= "\r\nBEGIN:VCARD\r\n";
                        $vcffile .= "VERSION:2.1\r\n";
                        $vcffile .= "N:".$nombre.";".$prefijo.";".$cant.";;\r\n";
                        $vcffile .= "FN:".$prefijo." ".$cant." ".$nombre."\r\n";
                        $vcffile .= "TEL;TYPE=CELL:+".$numero."\r\n";
                        $vcffile .= "END:VCARD";

                        
                        if($cant%500==0){
                            $files_vcf[]=$vcffile;
                            $vcffile="";
                        }

                    }else{
                        //nada nananina con ese numero
                    }

                }
                $first++;
            }//el ultimo aunque no de
            fclose($file);
        }
    }

    $files_vcf[]=$vcffile;


    $uploadDir = __DIR__ . '/.upload/';
    
    // Create upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }


    foreach ($files_vcf as $index => $contact) {
        // Generate unique filename
        $filename = uniqid('contact_') .'-'.$index.'.vcf';
        $filePath = $uploadDir . $filename;
        // Save vCard file
        file_put_contents($filePath, $files_vcf[$index]);
    }

}*/

if( isset($_POST["prefix"]) ){

    $cant=0;
    $prefijo=$_POST["prefix"];
    

    $vcffile="";
    //if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
    foreach ($_FILES['filenumber']['tmp_name'] as $key => $tmp_filename) {
        $tmp_name = $_FILES['filenumber']['tmp_name'][$key];
        // Retrieve the original file name
        //$name = $_FILES['filenumber']['name'];

        $file = fopen($tmp_name, "r");
        if($file){
            $first=0;

            while (($row = fgetcsv($file)) !== false) {
                
                if($first>0){
                    $col=0;
                    $nombre="";
                    $numero="";
                    foreach ($row as $column) {
                        if($col==0){
                            $nombre=preg_replace('/[^a-zA-Z0-9]/', '',$column);
                        }else{
                            $numero=preg_replace('/[^a-zA-Z0-9]/', '',$column);
                        }
                        $col++;
                    }

                    $query="SELECT * FROM num WHERE num like '%$numero%'";
                    $result= mysqli_query($connection,$query);

                    if(!$result) {
                        die('Query Error 1 ' . mysqli_error($connection));
                    }

                    if(mysqli_num_rows($result)==0){

                        $query="INSERT INTO num (num) VALUES ('+".$numero."')";
                        $result= mysqli_query($connection,$query);

                        if(!$result) {
                            die('Query Error 2 ' . mysqli_error($connection));
                        }
                        $cant++;
                        /*

                        BEGIN:VCARD
                        VERSION:2.1
                        N:Howard;Ja;40;;
                        FN:Ja 40 Howard
                        TEL;CELL;PREF:+36305637070
                        END:VCARD

                        */
                        $vcffile .= "\r\nBEGIN:VCARD\r\n";
                        $vcffile .= "VERSION:2.1\r\n";
                        $vcffile .= "N:".$nombre.";".$prefijo.";".$cant.";;\r\n";
                        $vcffile .= "FN:".$prefijo." ".$cant." ".$nombre."\r\n";
                        $vcffile .= "TEL;TYPE=CELL:+".$numero."\r\n";
                        $vcffile .= "END:VCARD";

                    }else{
                        //nada nananina con ese numero
                    }

                }
                $first++;
            }

            fclose($file);
        }
    }

    $uploadDir = __DIR__ . '/.upload/';
    
    // Create upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }


    // Generate unique filename
    $filename = uniqid('contact_') .'.vcf';
    $filePath = $uploadDir . $filename;

    // Save vCard file
    file_put_contents($filePath, $vcffile);

    header('Content-Type: text/x-vcard');
    header('Content-Disposition: attachment; filename="'.$filename.'.vcf"');

    // Output the generated vCard data
    echo $vcffile;

}

?>