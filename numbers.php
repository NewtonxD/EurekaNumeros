<?php

include('includesphp/conexion.php');

if( isset($_POST["num"]) ){
    $num=$_POST["num"];
    $code=$_POST["code"];
    $query="SELECT a.* FROM num a WHERE a.num='$num' and 
            CASE WHEN $code>0 THEN a.country_id=$code ELSE TRUE END AND a.act";
    $result= mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error 1 ' . mysqli_error($connection));

    }

    $json = array();


    if(mysqli_num_rows($result)==0){

        $query="INSERT INTO num (num, country_id)
            VALUES ('$num', $code)
            ON DUPLICATE KEY UPDATE act=true";

        $result= mysqli_query($connection,$query);

        if(!$result) {
            $json[] = array(
                "result" => "danger",
                "text" => "Ocurrió un percanse agregando el número <b>$num</b>.<br>Intentelo de nuevo más tarde."
            );
        }else{
            $json[] = array(
                "result" => "success",
                "text" => "El número <b>$num</b> fue agregado exitosamente."
            );
        }

        
    }else{
        $json[] = array(
            "result" => "danger",
            "text" => "El número <b>$num</b> no pudo ser agregado, ya existe."
        );
    }

    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if(isset($_GET["num"])){
    $num=$_GET["num"];
    $code=$_GET["code"];
    $query="SELECT a.id,
        CONCAT(CASE WHEN $code>0 THEN '' ELSE CONCAT(coalesce(c.code,''),' ',coalesce(concat('+',c.phone),''),' ') END ,a.num) as num,
        coalesce(c.name,'') as pais
        FROM num a left join countries c on a.country_id=c.id
        where a.act AND CASE WHEN '$num'<>'' THEN a.num like '%$num%' ELSE TRUE END and 
        CASE WHEN $code>0 THEN a.country_id=$code ELSE TRUE END ORDER BY id DESC LIMIT 2000";
    
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