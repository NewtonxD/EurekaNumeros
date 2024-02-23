<?php

include('includesphp/conexion.php');

if( isset($_POST["num"]) ){
    $num=$_POST["num"];
    $code=$_POST["code"];
    $query="SELECT a.* FROM num a WHERE a.num = '+".$code.$num."' AND a.act";
    $result= mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error 1 ' . mysqli_error($connection));

    }

    $json = array();


    if(mysqli_num_rows($result)==0){

        $query="SELECT a.* FROM num a WHERE a.num = '+".$code.$num."' AND not a.act";

        $result= mysqli_query($connection,$query);
        
        if(mysqli_num_rows($result)==0){
            $query="INSERT INTO num (num)
                VALUES ('+".$code.$num."')";

            $result= mysqli_query($connection,$query);

            if(!$result) {
                $json[] = array(
                    "result" => "danger",
                    "text" => "Ocurrió un percanse agregando el número <b>+".$code.$num."</b>.<br>Intentelo de nuevo más tarde."
                );
            }else{
                $json[] = array(
                    "result" => "success",
                    "text" => "El número <b>+".$code.$num."</b> fue agregado exitosamente."
                );
            }
        }else{

            $query="UPDATE num SET act=true WHERE num='+".$code.$num."' ";

            $result= mysqli_query($connection,$query);

            if(!$result) {
                $json[] = array(
                    "result" => "danger",
                    "text" => "Ocurrió un percanse agregando el número <b>+".$code.$num."</b>.<br>Intentelo de nuevo más tarde."
                );
            }else{
                $json[] = array(
                    "result" => "success",
                    "text" => "El número <b>+".$code.$num."</b> fue agregado exitosamente."
                );
            }

        }

        
    }else{
        $json[] = array(
            "result" => "danger",
            "text" => "El número <b>+".$code.$num."</b> no pudo ser agregado, ya existe!"
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if(isset($_GET["num"])){
    $num=$_GET["num"];
    $code=$_GET["code"];
    $query="SELECT a.id,
        a.num as num,
        '' as pais
        FROM num a WHERE a.num like '%+".$code.$num."%' ORDER BY id DESC LIMIT 2000";
    
    $result= mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error ' . mysqli_error($connection));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id' => $row['id'],
          'pais' => $row['pais'],
          'num' => $row['num']
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;

}

?>