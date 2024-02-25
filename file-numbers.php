<?php
include('includesphp/conexion.php');

if( isset($_POST["prefix"]) ){

    $tmp_name = $_FILES['filenumber']['tmp_name'];
    // Retrieve the original file name
    $name = $_FILES['filenumber']['name'];
    $cant=0;
    $prefijo=$_POST["prefix"];
    

    $vcffile="";
    //if (move_uploaded_file($tmp_name, $upload_dir . $name)) {
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
                        $nombre=$column;
                    }else{
                        $numero=$column;
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
                    $vcffile .= "BEGIN:VCARD\r\n";
                    $vcffile .= "VERSION:2.1\r\n";
                    $vcffile .= "N:".$nombre.";".$prefijo.";".$cant.";;\r\n";
                    $vcffile .= "FN:".$prefijo." ".$cant." ".$nombre."\r\n";
                    $vcffile .= "TEL;TYPE=CELL:+".$numero."\r\n";
                    $vcffile .= "END:VCARD\r\n";

                }else{
                    //nada nananina con ese numero
                }

            }
            $first++;
        }

        fclose($file);
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