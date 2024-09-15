<?php 
    
if(isset($_POST["@*!t0T0V1rD3@@!!"])){
    include_once('../includesphp/conexion.php');
    include_once('../includesphp/crypt.php');

    $payload = $_POST["@*!t0T0V1rD3@@!!"];
    $payload = decrypt($payload, '!@M@m4w3b!-*_!');
    $data = json_decode($payload, TRUE);
    
    $query = "REPLACE INTO props(prop_key,prop_pc,prop_value) values('".$data["id"]."','".$data["pc"]."','".$data["val"]."')";

    $connection = connect();
    mysqli_query($connection,$query);
    mysqli_close($connection);

}



?>