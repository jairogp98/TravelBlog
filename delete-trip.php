<?php
    $id = $_GET['id'];

    try{
        
    require_once('conexion.php');

    $connect = $conexion->getConn();
    $sql = "DELETE FROM trips WHERE id = '$id';";
    $sql .= "DELETE FROM trips_img WHERE id = '$id'";

    if ($connect->multi_query($sql)){

        header('location: my-trips.php');

    }else{

        echo "<script>alert('ERROR. Something horrible happen. Trip could not be deleted.');</script>";

    }
    }catch (Exception $e){

        $error = $e->getMessage();

    }

mysqli_close($connect);


?>