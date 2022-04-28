<?php
    include '../modelo/conexion.php';
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
    //prestamo
    $monto = $_POST['monto'];
    $interes = $_POST['interes'];
    $periodo = $_POST['periodo'];
    $contratacion = $_POST['tipoContrato'];
    $aceptar = $_POST['enviar'];
    $pagoPeriodo = $_POST['pagoPeriodo'];
    $pagoFinal = $_POST['pagoFinal'];

    if(isset($_POST['enviar'])){
        
        $conn->set_charset('utf8');
        
        $consulta = $conn->prepare("INSERT INTO prestarios(name, midName, lastName, address, city, state, ZIP, homePh, cellPh, email, 
        NSS, nacimiento, empleo, eAddress, eCity, eState, eZIP, ePh, eExt, ePossition, 
        amount, period, rate, pagoPeriodo, pagoFinal, contratacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if($consulta){

            $consulta->bind_param('ssssssssssssssssssssssssss',
            $name, $midName, $lastName, $address, $city, $state, $zip, $homePh, $cellPh, $email, 
            $NSS, $DOF, $empleo, $eAddress, $eCiudad, $eState, $eZIP, $eOffPh, $eExt, $empleo, 
            $monto, $periodo, $interes, $pagoPeriodo, $pagoFinal, $contratacion);
            
            if($consulta->execute()){
            
                $consulta = $conn->prepare("SELECT * FROM prestarios WHERE cellPh = ? AND email = ?");
                if($consulta){
            
                    $consulta->bind_param('ss',$cellPh, $email);
                    $consulta->execute();
                    $resultado = $consulta->get_result();
                    $datPrestario = $resultado->fetch_assoc();
                    header('location: ../regAuto?Reg=True&id_prestario='.$datPrestario['id_prestario']);
                }else{
                    header('location: ../newBorrower?Reg=False');
                }
            }else{
                header('location: ../newBorrower?Reg=False');
            }
            
        }else{
            header('location: ../newBorrower?Reg=False');
        }
        $conn->close();
    }else{
        $conn->close();
        header('location: ../newBorrower?Reg=False');
    }
    
?>