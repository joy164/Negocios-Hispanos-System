<?php
    include '../modelo/conexion.php';

    $id=$_REQUEST["id_prestario"];
    
    //datos basicos
    $name = $_POST['name'];
    $midName = $_POST['midName'];
    $lastName = $_POST['lastName'];
    $DOF = $_POST['DOF'];
    //dirreccion
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    //contacto
    $homePh = $_POST['homePh'];
    $cellPh = $_POST['cellPh'];
    $email = $_POST['email'];  
    //datos de empleo 
    $NSS = $_POST['NSS'];
    $empleo = $_POST['empleo'];
    $eAddress = $_POST['eDireccion'];
    $eCiudad = $_POST['eCiudad'];
    $eState = $_POST['eState'];
    $eZIP = $_POST['eZIP'];
    $eOffPh = $_POST['eOffPh'];
    $eExt = $_POST['eExt'];
    

    if(isset($_POST['enviar'])){
        $conn->set_charset('utf8');
        $consulta = $conn->prepare("UPDATE prestarios SET name = ?, midName = ?, lastName = ?, address = ?, city = ?, state = ?, ZIP= ?, homePh = ?, cellPh = ?, email= ?
        ,NSS = ?, nacimiento = ?, empleo = ?, eAddress = ?, eCity = ?, eState = ?, eZIP = ?, ePh = ?, eExt = ?, ePossition = ?
        WHERE id_prestario = ?");
    
        if($consulta){
            $consulta->bind_param('sssssssssssssssssssss', $name, $midName, $lastName, $address, $city, $state, $zip, $homePh, $cellPh, $email,
            $NSS, $DOF, $empleo, $eAddress, $eCiudad, $eState, $eZIP, $eOffPh, $eExt, $empleo, $id);
            $consulta->execute();
            if( $consulta->affected_rows > 0){
                header('location: ../detalleBorrower?Actualizado=True&id_prestario='.$id);
            }else{
                header('location: ../detalleBorrower?Actualizado=False&id_prestario='.$id);
            }
            
        }else{
            header('location: ../detalleBorrower?Actualizado=False&id_prestario='.$id);
        }
        $conn->close();
    }
    
?>