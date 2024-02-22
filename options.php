<?php

include('includesphp/conexion.php');

if( isset($_GET) ){

    $query="SELECT concat('+ ',phone,' ',code) as code,id,limite FROM countries 
            WHERE activo
            ORDER BY phone;";

    $result= mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error ' . mysqli_error($connection));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
        'code' => $row['code'],
        'limite' => $row['limite'],
        'id' => $row['id']
        );
    }

    $jsonstring = json_encode($json);

    echo $jsonstring;
}

?>