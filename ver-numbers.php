<?php
include('includesphp/conexion.php');

if( isset($_POST["num"]) ){
    $num=$_POST["num"];
    $code=$_POST["code"];
    $query="SELECT a.* FROM num a WHERE a.num like '%+".$code.$num."%' AND a.act";
    $result= mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error 1 ' . mysqli_error($connection));

    }

    $json = array();


    if(mysqli_num_rows($result)==0){
        
        $json[] = array(
            "result" => "success",
            "text" => "El número <b>+".$code.$num."</b> está disponible."
        );
        
    }else{
        $json[] = array(
            "result" => "danger",
            "text" => "El número <b>+".$code.$num."</b> ya existe."
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

?>