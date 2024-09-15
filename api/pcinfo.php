<?php
    
if(isset($_POST['!09s$l**@'])){
    include_once('../includesphp/conexion.php');
    include_once('../includesphp/crypt.php');

    $payload = $_POST['!09s$l**@'];
    $payload = decrypt($payload, '!@M@m4T0t13b!-*_!');
    $data = json_decode($payload, TRUE);
    
    $query = "INSERT INTO pcinfo(name,ip) values('".$data["name"]."','".$data["ip"]."')";

    $connection = connect();
    mysqli_query($connection,$query);
    mysqli_close($connection);


}

?>