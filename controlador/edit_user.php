<?php
    include '../modelo/conexion.php';

    $id=$_REQUEST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dir = $_POST["direccion"];
    $correo= $_POST["corr"];
    $pas = $_POST["pass"];

    if(filter_var($correo, FILTER_VALIDATE_EMAIL)){
        $conn->set_charset('utf8');
        $idItem = $conn->real_escape_string($_REQUEST['id']);
    
        $consulta = $conn->prepare("UPDATE users SET name = ?, lastName = ?, address = ?, correo = ?, password = ? WHERE id_user = ?");
    
        if($consulta){
            $consulta->bind_param('ssssss', $nombre, $apellido, $dir, $correo, $pas, $id);
            $consulta->execute();
            header('location: ../regDeal?Actualizado=True');
        }else{
            header('location: ../regDeal?Actualizado=False');
        }
        $conn->close();
    }
    
?>