<?php
    include '../modelo/conexion.php';
    session_start();
    if(!isset($_SESSION['id_user'])){
        header("location: index");
    }
    $conn->set_charset('utf8');
    $idItem = $conn->real_escape_string($_REQUEST['id']);
    $consulta = $conn->prepare("SELECT * FROM prestarios WHERE id_prestario = ?");
    $consulta->bind_param('s', $idItem);
    $consulta->execute();
    
    $resultado = $consulta->get_result();
    $datosPrestario = $resultado->fetch_assoc();

    $consulta = $conn->prepare("DELETE FROM prestarios WHERE id_prestario = ? and id_auto = ?");

    if($consulta){
        $consulta->bind_param('ss', $idItem, $datosPrestario['id_auto']);
        $consulta->execute();
        if( $consulta->affected_rows > 0){
            $consulta = $conn->prepare("DELETE FROM vehicle WHERE id_auto = ?");
            $consulta->bind_param('i', $datosPrestario['id_auto']);
            $consulta->execute();

            header('location: ../regPrestamos?Eliminado=True');
        }else{
            header('location: ../regPrestamos?Eliminado=False');
        }
    }else{
        header('location: ../regPrestamos?Eliminado=False');
    }
    
    $conn->close();

?>