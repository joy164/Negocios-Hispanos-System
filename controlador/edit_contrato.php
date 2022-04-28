<?php
    include '../modelo/conexion.php';

    $id=$_REQUEST["id"];
    
    $name = $_POST['name'];
    $midName = $_POST['midName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $homePh = $_POST['homePh'];
    $cellPh = $_POST['cellPh'];
    $email = $_POST['email'];
    

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $conn->set_charset('utf8');
        $idItem = $conn->real_escape_string($_REQUEST['id']);
        
        $consulta = $conn->prepare("UPDATE prestarios SET name = ?, midName = ?, lastName = ?, address = ?, city = ?, state = ?, ZIP= ?, homePh = ?, cellPh = ?, email= ? WHERE id_prestario = ?");
    
        if($consulta){
            $consulta->bind_param('sssssssssss',$name, $midName, $lastName, $address, $city, $state, $zip, $homePh, $cellPh, $email, $id);
            $consulta->execute();
            if( $consulta->affected_rows > 0){
                header('location: ../regPrestamos?Actualizado=True');
            }else{
                header('location: ../regPrestamos?Actualizado=False');
            }
            
        }else{
            header('location: ../regPrestamos?Actualizado=False');
        }
        $conn->close();
    }
    
?>