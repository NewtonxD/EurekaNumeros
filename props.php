<?php


include('./includesphp/authentication.php');

if(isset($_GET['pc'])){
    include('./includesphp/conexion.php');
    $pc = $_GET['pc'];

    $query = "SELECT prop_key,prop_value FROM props WHERE prop_pc='".$pc."'";
    $connection = connect();
    $result = mysqli_query($connection,$query);

    if(!$result) {
        die('Query Error ' . mysqli_error($connection));
    }

    $json = array();

    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
          'key' => $row['prop_key'],
          'value' => $row['prop_value']
        );
    }
    mysqli_close($connection);
    $jsonstring = json_encode($json);
    echo $jsonstring;
}



?>