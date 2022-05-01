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

    $consulta = $conn->prepare("DELETE FROM prestarios WHERE id_prestario = ?");

    if($consulta){
        $consulta->bind_param('i', $idItem);
        $consulta->execute();
        if( $consulta->affected_rows > 0){
            if( $datosPrestario['id_CoBorrower'] > 0){
                $consulta = $conn->prepare("DELETE FROM coborrower WHERE id_coBorrower = ?");
                $consulta->bind_param('i', $datosPrestario['id_CoBorrower']);
                $consulta->execute();
            }
            
            if($datosPrestario['id_CoSigner'] > 0){
                $consulta = $conn->prepare("DELETE FROM cosigner WHERE id_CoSigner = ?");
                $consulta->bind_param('i', $datosPrestario['id_CoSigner']);
                $consulta->execute();
            }
            
            if($datosPrestario['id_referencia'] > 0){
                $consulta = $conn->prepare("DELETE FROM referencias WHERE idReferencia = ?");
                $consulta->bind_param('i', $datosPrestario['id_referencia']);
                $consulta->execute();
            }

            header('location: ../regPrestamos?Eliminado=True');
        }else{
            header('location: ../regPrestamos?Eliminado=False');
        }
    }else{
        header('location: ../regPrestamos?Eliminado=False');
    }
    
    $conn->close();

?>