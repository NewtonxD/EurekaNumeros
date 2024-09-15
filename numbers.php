<?php
include('includesphp/authentication.php');
include('includesphp/conexion.php');

if( isset($_POST["num"]) ){
    $num=$_POST["num"];
    $code=$_POST["code"];
    $query="SELECT a.* FROM num a WHERE a.num = '+".$code.$num."' AND a.act";
    $connection=connect();
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
    mysqli_close($connection);

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if(isset($_GET["num"])){
    $num=urldecode($_GET["num"]);
    $prefijo=urldecode($_GET["prefijo"]);
    $query="SELECT a.id,
        a.num as num,
        a.crd_at as fecha,
        coalesce(a.nom,'') as contacto
        FROM num a 
        WHERE "
            .($num!='' ? " a.num like '%".$num."%' AND " : " true AND ")
            .($prefijo!='' ? " upper(a.nom) like upper('".$prefijo."') " : " true ")
        ." ORDER BY id DESC,4 LIMIT 2000";
    $connection = connect();
    $result = mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error ' . mysqli_error($connection));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'id' => $row['id'],
          'num' => $row['num'],
          'fecha' => $row['fecha'],
          'contacto' => $row['contacto']
        );
    }
    mysqli_close($connection);
    $jsonstring = json_encode($json);
    echo $jsonstring;

}

?>