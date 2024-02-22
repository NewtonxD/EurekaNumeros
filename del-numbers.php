<?php
include('includesphp/conexion.php');

if( isset($_POST["id"]) ){
    $id=$_POST["id"];

    $query="UPDATE num SET act=false WHERE id=$id";

    $result= mysqli_query($connection,$query);

    $json = array();

    if(!$result) {
        $json[] = array(
            "result" => "danger",
            "text" => "Ocurrió un percanse tratando de borrar el número.<br>Intentelo de nuevo más tarde."
        );
    }else{
        $json[] = array(
            "result" => "success",
            "text" => "El número fue borrado exitosamente."
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

?>