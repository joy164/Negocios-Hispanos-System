<?php
    include '../modelo/conexion.php';
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index");
    }
    $conn->set_charset('utf8');
    $idItem = $conn->real_escape_string($_REQUEST['id']);

    $consulta = $conn->prepare("DELETE FROM users WHERE id_user = ?");
    sleep(1);
    if($consulta){
        $consulta->bind_param('s', $idItem);
        $consulta->execute();
        if( $consulta->affected_rows > 0){
            header('location: ../regDeal?Eliminado=True');
        }else{
            header('location: ../regDeal?Eliminado=False');
        }
    }else{
        header('location: ../regDeal?Eliminado=False');
    }

    $conn->close();

?>